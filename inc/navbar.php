<?php
if(defined('navbar')) 
{
	include_once("inc/dbconnect.php");
	if(isset($_POST["ams_uname"]) && isset($_POST["ams_pwd"]))
	{
		$uname=htmlspecialchars($_POST["ams_uname"],ENT_QUOTES);
		$pwd=htmlspecialchars($_POST["ams_pwd"],ENT_QUOTES);
		if($getUser = $mysqli->query ("SELECT role from `ams-users` WHERE uname='$uname' AND pass='$pwd'"))
		{
			if($getUserObj = $getUser->fetch_object())
			{
				$role = (string)$getUserObj->role;
				$_SESSION["logged"]=$uname;
				$_SESSION["role"]=$role;
			}
			else
			{
				define('wrongCredentials',1);
			}
		}
	}
	else if(isset($_POST["ams_uname_main"]) && isset($_POST["ams_pwd_main"]))
	{
		$uname=htmlspecialchars($_POST["ams_uname_main"],ENT_QUOTES);
		$pwd=htmlspecialchars($_POST["ams_pwd_main"],ENT_QUOTES);
		if($getUser = $mysqli->query ("SELECT role from `ams-users` WHERE uname='$uname' AND pass='$pwd'"))
		{
			if($getUserObj = $getUser->fetch_object())
			{
				$role = (string)$getUserObj->role;
				$_SESSION["logged"]=$uname;
				$_SESSION["role"]=$role;
			}
			else
			{
				define('wrongCredentials',1);
			}
		}
	}
?>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li <?=defined('manage')?'class="active" ><a href="#">':'><a href="index.php">' ?>Manage Attendance</a></li>
            <li <?=defined('reports')?'class="active" ><a href="#">':'><a href="reports.php">' ?>Reports</a></li>
            <li class="dropdown">
            	<?
					if(isset($_SESSION["logged"]))
					{
						?>
                        <a href="#" class="dropdown-toggle logged-in" data-toggle="dropdown" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
                        <div class="dropdown-menu" style="padding:17px;">
                          	<label>Logged in as</label>
                            <h5 class="text-center"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;<?=$_SESSION["logged"] ?></h5>
                            <a role="button" href="users/logout.php" class="btn btn-default btn-login">Log Out</a>
                        </div>
                        <?
					}
					else
					{
						?>
                        <a href="#" class="dropdown-toggle login-state" data-toggle="dropdown" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
                        <div class="dropdown-menu" style="padding:17px;">
                          <form id="formLogin" method="post"> 
                            <label style="margin-bottom:10px;">Login</label> 
                            <div class="form-group">
                                <input class="form-control input-sm" name="ams_uname" id="ams_uname" type="text" placeholder="Username" title="Enter your username" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" name="ams_pwd" id="ams_pwd" type="password" placeholder="Password" title="Enter your password" required>
                            </div>
                            <button type="submit" id="btnLogin" class="btn btn-default btn-login">Login</button>
                          </form>
                        </div>
                        <?
					}
				?>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <?
	if(!isset($_SESSION["logged"]))
	{
		?>
        <div class="container-fluid">
          <div class="row text-center attendance-form">
          	<div class="col-md-offset-4 col-md-4">
            	<?
				if(defined('wrongCredentials')) {
				?>
               	<div class="alert alert-warning alert-dismissible text-left" role="alert">
                	 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      Wrong Credentials !!
                </div>
                <?
				}
				?>
            	<form class="form-horizontal" method="post">
                      <fieldset>
                        <legend>Login</legend>
                        <div class="form-group">
                            <input class="form-control input-md" name="ams_uname_main" id="ams_uname_main" type="text" placeholder="Username" title="Enter your username" required>
                        </div>
                        <div class="form-group">
                                        <input class="form-control input-md" name="ams_pwd_main" id="ams_pwd_main" type="password" placeholder="Password" title="Enter your password" required>
                        </div>
                        <div class="form-group">
                        	<a href="#" class="pull-left" style="padding-top:12px">Forgot Password</a>
                        	<button type="submit" id="btnLogin_main" class="btn btn-default btn-login-main pull-right">Login</button>
                        </div>
                     </fieldset>
                   </form>
                
            </div>
         </div>
       </div>             	
       <?
	}
	else
	{
		define('showAMS',1);
	}
}
else
{
	echo "Forbidden :P";
}
?>