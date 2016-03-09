<?php
session_start();
$dbhost  = $_SESSION['dbhost'];
$dbuser  = $_SESSION['dbuser'];
$dbpass  = $_SESSION['dbpass'];
$dbname  = $_SESSION['dbname'];

// Establishing connection with server..
 // $connection = mysql_connect("localhost", $dbuser, $dbpass);
  

// Selecting Database 
  $conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbname);

$sql = " CREATE  TABLE  IF NOT EXISTS `ams-users` (  `uname` varchar( 25  )  NOT  NULL ,
 `pass` varchar( 25  )  NOT  NULL ,
 `role` varchar( 15  )  NOT  NULL , PRIMARY KEY(uname) )";
            
            
            $retval = mysql_query($sql, $conn);
            if (!$retval) {
                
                die('Could not alter table: ' . mysql_error());
            }

$data = json_decode(file_get_contents('php://input'), true);

foreach ($data as $i)
{
   $sql = "insert into `ams-users`(uname,pass,role) values ('$i[0]','$i[1]','$i[2]')";
   $retval = mysql_query($sql, $conn);
   if (!$retval) {   
        die('Could not alter table: ' . mysql_error());
    }
}
/*for ($i=0; $i <count($data) ; $i++) { 

    $sql = "insert into `ams-users`(uname,pass,role) values ("$data[i]")";
            
            mysql_select_db($dbname);
            $retval = mysql_query($sql[8], $conn);
            if (!$retval) {
                
                die('Could not alter table: ' . mysql_error());
    
}*/
?>

        <div class="container" id="contain1">
            <div id="steps">
        <div class="step" data-desc="Database Credentials">1</div>
        <div class="step" data-desc="Access Credentials">2</div>
        <div class="step active" data-desc="Insert Data">3</div>
        <div class="step" data-desc="Upload Student List">4</div>
    </div>
            <div class="row">
                <form id="form2">
                                          
                        <div class="row">

                            <div class="col-md-offset-1 col-md-3">
                                <h2 align="center"> 2nd Year</h2>
                                <div class="form-group">

                                    <label for="sections">Number of Sections</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="sections" name="sections" placeholder="No. Of Sections" required>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="InputSub">No. of Subjects</label>

                                    <div class="input-group">
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control bfh-number" name="tot-sub" id="num-members">
                                        </div>
                                        <button type="button" id="add_sub" class="btn pull-left  btn-success">Add</button>
                                        <button type="button" id='delete_row' class="pull-right btn btn-warning">Delete</button>
                                        <br>

                                        </br>
                                        </br>
                                        </br>

                                        <input type="hidden" value="1" id="tot-members" name="tot-members" />
                                        <table class="table table-bordered table-hover" id="tab_logic">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th class="text-center">
                                                        Subject Name
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id='addr0'>
                                                    <td>
                                                        1
                                                    </td>
                                                    <td>
                                                        <input type="text" id='sub0' placeholder='Subject Name' class="form-control" />
                                                    </td>
                                                </tr>
                                                <tr id='addr1'></tr>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>



                            </div>

                            <div class="col-md-offset-1 col-md-3">
                                <h2 align="center"> 3rd Year</h2>
                                <div class="form-group">

                                    <label for="sections">Number of Sections</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="sections3" name="sections3" placeholder="No. Of Sections" required>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="InputSub">No. of Subjects</label>

                                    <div class="input-group">
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control bfh-number" name="tot-sub3" id="num-members3">
                                        </div>
                                        <button type="button" id="add_sub3" class="btn pull-left  btn-success">Add</button>
                                        <button type="button" id='delete_row3' class="pull-right btn btn-warning">Delete</button>
                                        <br>

                                        </br>
                                        </br>
                                        </br>

                                        <input type="hidden" value="1" id="tot-members3" name="tot-members3" />
                                        <table class="table table-bordered table-hover" id="tab_logic3">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th class="text-center">
                                                        Subject Name
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id='addr30'>
                                                    <td>
                                                        1
                                                    </td>
                                                    <td>
                                                        <input type="text" id='sub30' placeholder='Subject Name' class="form-control" />
                                                    </td>
                                                </tr>
                                                <tr id='addr31'></tr>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>


                            </div>


                            <div class="col-md-offset-1 col-md-3">
                                <h2 align="center"> 4th Year</h2>
                                <div class="form-group">

                                    <label for="sections">Number of Sections</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="sections4" name="sections4" placeholder="No. Of Sections" required>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                    </div>

                                </div>
                                <div class="form-group">

                                    <label for="InputSub">No. of Subjects</label>

                                    <div class="input-group">
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control bfh-number" name="tot-sub4" id="num-members4">
                                        </div>
                                        <button type="button" id="add_sub4" class="btn pull-left  btn-success">Add</button>
                                        <button type="button" id='delete_row4' class="pull-right btn btn-warning">Delete</button>
                                        <br>

                                        </br>
                                        </br>
                                        </br>

                                        <input type="hidden" value="1" id="tot-members4" name="tot-members4" />
                                        <table class="table table-bordered table-hover" id="tab_logic4">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th class="text-center">
                                                        Subject Name
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id='addr40'>
                                                    <td>
                                                        1
                                                    </td>
                                                    <td>
                                                        <input type="text" id='sub40' placeholder='Subject Name' class="form-control" />
                                                    </td>
                                                </tr>
                                                <tr id='addr41'></tr>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <input type="button" name="next1" id="next1" value="Next" class="btn btn-info pull-right"/>
                </form>
                

                    </div>
                </div>
                <!-- Registration form - END -->

           


                <script src="js/index.js"></script>
                  <script src="script.js"></script>
                  
                <script type="text/javascript">
                $(document).ready(function() {
                    var i;
                    $("#add_sub").click(function() {
                        var num = $("#num-members").val();
                        for (i = 0; i < num; i++) {
                            $('#addr' + i).html("<td>" + (i + 1) + "</td><td><input id='sub" + i + "' type='text' placeholder='Subject Name' class='form-control input-md'/> </td>");

                            $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');

                        }
                        $('#tot-sub').val(num);
                    });
                    $("#delete_row").click(function() {
                        if (i > 1) {
                            $("#addr" + (i - 1)).html('');
                            i--;
                        }
                        $('#tot-sub').val($("#num-members").val());
                    });

                });


                $(document).ready(function() {
                    var i;
                    $("#add_sub3").click(function() {
                        var num = $("#num-members3").val();
                        for (i = 0; i < num; i++) {
                            $('#addr3' + i).html("<td>" + (i + 1) + "</td><td><input id='sub3" + i + "' type='text' placeholder='Subject Name' class='form-control input-md'/> </td>");

                            $('#tab_logic3').append('<tr id="addr3' + (i + 1) + '"></tr>');

                        }
                        $('#tot-sub3').val(num);
                    });
                    $("#delete_row3").click(function() {
                        if (i > 1) {
                            $("#addr3" + (i - 1)).html('');
                            i--;
                        }
                        $('#tot-sub3').val($("#num-members3").val());
                    });

                });


                $(document).ready(function() {
                    var i;
                    $("#add_sub4").click(function() {
                        var num = $("#num-members4").val();
                        for (i = 0; i < num; i++) {
                            $('#addr4' + i).html("<td>" + (i + 1) + "</td><td><input id='sub4" + i + "' type='text' placeholder='Subject Name' class='form-control input-md'/> </td>");

                            $('#tab_logic4').append('<tr id="addr4' + (i + 1) + '"></tr>');

                        }
                        $('#tot-sub4').val(num);
                    });
                    $("#delete_row4").click(function() {
                        if (i > 1) {
                            $("#addr4" + (i - 1)).html('');
                            i--;
                        }
                        $('#tot-sub4').val($("#num-members4").val());
                    });

                });


                
            </script>
           
         



