<?php
session_start();
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && isset($_GET["year"]) && isset($_GET["sec"]) && isset($_GET["date"]) && isset($_SESSION["logged"]))
 {
	 include_once("inc/config.php");
	 include_once("inc/dbconnect.php");
	 $year = $mysqli->real_escape_string($_GET["year"]);
	 $sec = $mysqli->real_escape_string($_GET["sec"]);
	 $date = $mysqli->real_escape_string($_GET["date"]);
	 $date = DateTime::createFromFormat('d/m/Y', $date);
	 $date = $date->format('Y-m-d');
	 /*$subjects = unserialize(file_get_contents("inc/subjects.php"));*/
	 $subjects = array();
	 /*echo "SELECT DISTINCT sub_name from `subjects-$year`";*/
	 if($getSubjects = $mysqli->query ("SELECT DISTINCT sub_name from `subjects-$year`"))
	 {
		 while($subjectObj = $getSubjects->fetch_object())
		 {
			 $subObj = (string)$subjectObj->sub_name;
			 array_push($subjects,$subObj);
		 }
	 }
	 else
	 {
		 echo "Error while fetching Subjects";
	 }
	 $prevPeriods = array();	
	 $prevPeriodName = array();
	 $prevAttd = array();
	 if($getPrev = $mysqli->query("SELECT * from `dailyattendance-$year-$sec` WHERE date='$date'"))
	 {
	 	while($getPrevObj = $getPrev->fetch_object())
		{
			$period = (int)$getPrevObj->period;
			$sub_name = (string)$getPrevObj->sub_name;
			$absentees = json_decode((string)$getPrevObj->absentees);
			$prevPeriods[] = $period;
			$prevPeriodName[$period]=$sub_name;
			$prevAttd[$period]=$absentees;
		}
	 }
	 else
	 {
	 	echo "Error while getting previous data";
	 } 
	 date_default_timezone_set("Asia/Kolkata");
	 $editable = true;
     if(date('Y-m-d') != $date && isset($_SESSION["logged"]) && $_SESSION["role"]=="User")
	 {
		 $editable = false;
		 ?>
         <div class="block"></div>
         <?
	 }
	 ?>
          
          <div class="row">
            <div class="col-md-offset-4 col-md-4" id="message">
                
            </div>
          </div>
          <div class="row">
            <?
				if($editable)
				{
					?>
                    <div class="col-md-8 col-sm-12">
                      <form class="form-horizontal">
                        <div class="form-group">
                          <label for="selectType" class="col-md-1 control-label">Update</label>
                          <div class="col-md-3">
                            <select id="selectType" name="selectType" class="form-control">
                              <option value="Absentees">Absentees</option>
                              <option value="Presentees">Presentees</option>
                            </select>
                          </div>                  
                        </div>
                      </form>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="pull-right">
                            <button id="submitAll" data-loading-text="Saving..." autocomplete="off" class="btn btn-success">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            &nbsp;Submit
                            </button>
                        </div>
                    </div>
                    <?
				}
				else
				{
					?>
                    <div class="alert alert-warning" role="alert">
                      <strong>Access Restrcited !!</strong>&nbsp;You don't have permissions to update the attendance. Please Login as <b>admin</b>
                    </div>
                    <?
				}
			?>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                  <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>4</th>
                  <th>5</th>
                  <th>6</th>
                  <th>7</th>
                </tr>
                <tr>
                  <th class="text-left">HT No.</th>
                  <th class="text-left">Name</th>
                  
                   <?
				    for($i=1;$i<=7;$i++)
					{
						if(in_array($i,$prevPeriods))
						{
							?>
                            <td>
                            	<select id="per<?=$i ?>" name="per<?=$i ?>" class="form-control select-sub">
                                  <?    
									foreach($subjects as $sub)
									{
										
								    ?>
										<option value="<?=$sub ?>" <?=($sub == $prevPeriodName[$i])?"selected":"" ?>><?=$sub ?></option>
								    <?
									}
								  ?>
                                </select>
                            </td>
                            <?
						}
						else
						{
							?>
							<td>
								<select id="per<?=$i ?>" name="per<?=$i ?>" class="form-control select-sub">
								  <option value="none" style="display:none" disabled selected>Select Sub</option>
								  <?    
									foreach($subjects as $sub)
									{
								  ?>
										<option value="<?=$sub ?>"><?=$sub ?></option>
								  <?
									}
								  ?>
								</select>
						   </td>
						   <?
						}
                     }
				  ?>                 
                </tr>
              </thead>
              <tbody>
                 <?php
				  //echo "students-$year-$sec";
				  
				  if($getstudents = $mysqli->query ("SELECT HTNo, Name from `students-$year-$sec`"))
				  {
					  //echo "Reached Here students-$year-$sec";
					  while($student = $getstudents->fetch_object())
					  {
							$htno = (string)$student->HTNo;
							$name = (string)$student->Name;
					  ?>
							<tr>
                              <td><?=$htno ?></td>
                              <td><?=$name ?></td>
                              <?
							  for($i=1;$i<=7;$i++)
							  {
								  if(in_array($i,$prevPeriods))
								  {
									  ?>
                                      <td>
                                        <div class="checkbox checkbox-danger text-center">
                                            <input id="<?=$i ?>-<?=$htno ?>" name="<?=$i ?>" value="<?=$htno ?>" type="checkbox" <?=(in_array($htno,$prevAttd[$i]))?"checked":"" ?>>
                                            <label for="<?=$i ?>-<?=$htno ?>"></label>
                                        </div>
                                      </td>
                                      <?
								  }
								  else
								  {
									  ?>
									  <td>
										<div class="checkbox checkbox-danger text-center">
											<input id="<?=$i ?>-<?=$htno ?>" name="<?=$i ?>" value="<?=$htno ?>" type="checkbox" disabled>
											<label for="<?=$i ?>-<?=$htno ?>"></label>
										</div>
									  </td>
									  <?
								  }
							  }
							  ?>                              
                           </tr>
					  <?
					  }
				  }
                 ?>
              </tbody>
            </table>
          </div>
        
	 <?
 }
 else
 {
	 echo "Forbidden :P";
 }
?>
