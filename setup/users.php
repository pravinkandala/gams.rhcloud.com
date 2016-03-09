<?php
session_start();
// Establishing connection with server..
//$connection         = mysql_connect("localhost", "root", "root");
$dbuser             = $_POST['uname'];
$dbpass             = $_POST['pass'];
$dbname             = $_POST['dname'];
$semdate            = $_POST['smdt'];
$dbhost             = "localhost";
$_SESSION['dbuser'] = $dbuser;
$_SESSION['dbpass'] = $dbpass;
$_SESSION['dbname'] = $dbname;
$_SESSION['dbhost'] = $dbhost;
// Selecting Database
$conn               = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
$sql    = 'CREATE Database IF NOT EXISTS `' . $dbname . '`';
$retval = mysql_query($sql, $conn);
if (!$retval) {
    die('Could not create database: ' . mysql_error());
}

$prevData = file_get_contents("../inc/dbconnect.php");
$newdata = str_replace("<DB_USER_HERE>", $dbuser, $prevData);
$newdata = str_replace("<DB_PASS_HERE>", $dbpass, $newdata);
$newdata = str_replace("<DB_NAME_HERE>", $dbname, $newdata);
file_put_contents("../inc/dbconnect.php", $newdata);

$prevData = file_get_contents("../js/custom.js");
$newdata = str_replace("<SEM_START_DATE>", $semdate, $prevData);
file_put_contents("../js/custom.js", $newdata);

$prevData = file_get_contents("../js/custom-reports.js");
$newdata = str_replace("<SEM_START_DATE>", $semdate, $prevData);
file_put_contents("../js/custom-reports.js", $newdata);

?>
<div class="container" id="contain2">
    <div id="steps">
        <div class="step" data-desc="Database Credentials">1</div>
        <div class="step active" data-desc="Access Credentials">2</div>
        <div class="step" data-desc="Insert Data">3</div>
        <div class="step" data-desc="Upload Student List">4</div>
    </div>
    <div class="row">

        <h4 style="color:#F33" align="centre">Number of Users</h4>
        <form id="form1">
            <div >
                <div class="form-inline">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">

                        <input type="text" class="form-control bfh-number" name="tot-members" id="num-members" data-min="1" data-max="25">

                        <button type="button" id='delete_row' class="pull-right btn btn-default btn-warning">Delete</button>
                        <button type="button" id="add_row" class="btn btn-success">Add User</button>

                    </div>
                    <div class="col-md-4">
                    </div>
                </div>

                <br>
                <br>
                <div class="row clearfix">
                    <div class="col-md-8 column col-md-offset-2">

                        <input type="hidden" value="1" id="tot-members" name="tot-members" />
                        <table class="table table-bordered table-hover" id="tab_logic">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th class="text-center">
                                        USERNAME
                                    </th>
                                    <th class="text-center">
                                        PASSWORD
                                    </th>
                                    <th class="text-center">
                                        TYPE OF USER
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr id='addr0'>
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        <input type="text" name='name0' id="name0" placeholder='User Name' class="form-control" />
                                    </td>
                                    <td>
                                        <input type="password" name='pass0' id="pass0" placeholder='Password' class="form-control" />
                                    </td>
                                    <td>
                                        <div class="btn-group"  name="btn0" id="btn0" data-toggle="buttons">
                                            <label class="btn btn-default">
                                                <input type="radio" id="admin0" value="admin">ADMIN</label>
                                            <label class="btn btn-default">
                                                <input type="radio" id="user0" value="user">USER</label>
                                        </div>
                                    </td>

                                </tr>
                                <tr id='addr1'></tr>
                            </tbody>
                        </table>
                        <input type="button" id="next0" class="btn btn-default pull-right" value="Submit"/>



                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="js/index.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var i;
        $("#add_row").click(function() {
            var num = $("#num-members").val();
            for (i = 0; i < num; i++) {
                $('#addr' + i).html("<td>" + (i + 1) + "</td><td><input name='name" + i + "' id='name" + i + "' type='text' placeholder='User Name' class='form-control input-md'/></td><td><input name='pass" + i + "' id='pass" + i + "' type='password' placeholder='Password'  class='form-control input-md'></td><td><div class='btn-group' id='btn" + i + "' data-toggle='buttons'><label class='btn btn-default'><input type='radio' id='admin"+i+"' value='admin'>ADMIN</label><label class='btn btn-default'><input type='radio' id='user"+i+"' value='user'>USER</label></div></td>");

                $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');

            }
            $('#tot-members').val(num);
        });
        $("#delete_row").click(function() {
            if (i > 1) {
                $("#addr" + (i - 1)).html('');
                i--;
            }
            $('#tot-members').val($("#num-members").val());
        });



    });
</script>
