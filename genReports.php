<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && isset($_GET["year"]) && isset($_GET["sec"]) && isset($_GET["startDate"]) && isset($_GET["endDate"]) )
{
	
	include_once("inc/dbconnect.php");
	$year = $mysqli->real_escape_string($_GET["year"]);
	$sec = $mysqli->real_escape_string($_GET["sec"]);
	
	$startDate = DateTime::createFromFormat('d/m/Y',$mysqli->real_escape_string($_GET["startDate"]));
	$startDate = $startDate->format('Y-m-d');
	
	$endDate = DateTime::createFromFormat('d/m/Y',$mysqli->real_escape_string($_GET["endDate"]));
	$endDate = $endDate->format('Y-m-d');
	
	/* Get Subjects with its total Attendance */
	$subjects = array();
	$subjectsId = array();
	if($getSubjects = $mysqli->query ("SELECT `id`,`sub_name` from `subjects-$year`"))
	{
	   while($subjectObj = $getSubjects->fetch_assoc())
	   {
		   $subName = $subjectObj["sub_name"];
		   $subId = $subjectObj["id"];
		   $subjects[$subName] = 0;
		   $subjectsId[$subName] = $subId;
	   }
	}
	else
	{
	   echo "Error while fetching Subjects";
	}
	$subjectsName = array_flip($subjectsId);
	
	/* Reset Previous Reports */
	$resetQry = "UPDATE `students-$year-$sec` SET ";
	$subCount = count($subjectsId);
	for($i=1;$i<=$subCount;$i++)
	{
		if($i == $subCount)
		{
			$resetQry = $resetQry."`sub-$i`=0";
		}
		else
		{	
			$resetQry = $resetQry."`sub-$i`=0, ";
		}
	}
	if($resetReport = $mysqli->query($resetQry))
	{
		//$resetReport->close();
	}
	else
	{
		echo "Error while resetting the data";
	}
	
	/*Generate Report*/
	if($getDailyAttd = $mysqli->query("SELECT sub_name, absentees FROM `dailyattendance-$year-$sec` WHERE date BETWEEN '$startDate' AND '$endDate' "))
	{
		while($getDailyAttdObj = $getDailyAttd->fetch_object())
		{
			$sub_name = (string)$getDailyAttdObj->sub_name;
			$absentees = json_decode((string)$getDailyAttdObj->absentees);
			$subjects[$sub_name] = $subjects[$sub_name] + 1;
			$effSubId = $subjectsId[$sub_name];
			foreach($absentees as $absStudent)
			{
				if($updStudAttnd = $mysqli->prepare("UPDATE `students-".$year."-".$sec."` SET `sub-".$effSubId."` = `sub-".$effSubId."` + 1 WHERE HTNo = ?"))
				{
					$updStudAttnd->bind_param("s",$absStudent);
					$updStudAttnd->execute();
					$updStudAttnd->close();
				}
				else
				{
					echo "Error in Update Student Attendance Statement";
				}
			}
		}
	}
	?>
	<div class="row">
	  <div class="col-md-offset-4 col-md-4" id="message">
	  </div>
	  <div class="col-md-4 col-sm-12 pull-right text-right">
		  <button id="export" data-loading-text="Downloading..." autocomplete="off" class="btn btn-success">
			<span class="glyphicon glyphicon-export" aria-hidden="true"></span>
			&nbsp;Export to CSV
		  </button>
	  </div>
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-bordered reports-table">
			<thead>
				<tr>
					<th rowspan="2">S.No.</th>
					<th rowspan="2">Roll No.</th>
					<th>Name</th>
					<?
					foreach($subjects as $subName=>$subAttd)
					{
						?>
						<th><?=$subName ?></th>
						<?
					}
					?>
					<th>Total</th>
					<th>Average</th>
				</tr>
				<tr>
					<th>Classes Conducted</th>
					<?
					$tot = 0;
					foreach($subjects as $subName=>$subAttd)
					{
						$tot = $tot + $subAttd;
						?>
						<th><?=$subAttd ?></th>
						<?
					}
					?>
					<th><?=$tot ?></th>
					<th>100.00</th>
				</tr>
			</thead>
			<tbody>
				<?
				if($getStudents = $mysqli->query ("SELECT * from `students-$year-$sec`"))
				{
					$sno=0;
					while($studentObj = $getStudents->fetch_assoc())
					{
						$sno = $sno + 1;
						?>
						<tr>
							<td><?=$sno ?></td>
							<td><?=$studentObj["HTNo"] ?></td>
							<td><?=$studentObj["Name"] ?></td>
							<?
							$subCount = count($subjectsId);
							$totAttd = 0;
							for($i=1;$i<=$subCount;$i++)
							{
								$present = $subjects[$subjectsName[$i]] - $studentObj["sub-$i"];
								$totAttd = $totAttd + $present;
								?>
								<td><?=$present ?></td>
								<?
							}
							?>
							<td><?=$totAttd ?></td>
							<td><?=($tot==0)?$tot:number_format(($totAttd/$tot)*100,2,'.','') ?></td>
						</tr>
						<?
					}
				}
				else
				{
					echo "Error in SELECT Statement";
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