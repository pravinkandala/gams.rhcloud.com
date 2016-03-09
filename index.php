<?php
define('header',1); include('inc/header.php');
define('navbar',1); define('manage',1); include('inc/navbar.php');

if(defined('showAMS'))
{
?>
    <div class="container-fluid">
      <div class="row text-center attendance-form">
      	<form class="form-horizontal col-md-offset-4">
          <fieldset>
            <div class="form-group">
              <label for="inputDate" class="col-md-2 control-label">Date</label>
              <div class="col-md-3" id="ams-container">
                <div class="input-group date">
                  <input type="text" name="inputDate" id="inputDate" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="inputYear" class="col-md-1 control-label">Year</label>
              <div class="col-md-2">
                <select name="inputYear" id="inputYear" class="form-control">
                  <option value="none" style="display:none" disabled selected>-- Year --</option>
                  <option value="2">II Year</option>
                  <option value="3">III Year</option>
                  <option value="4">IV Year</option>
                </select>
              </div>
              
              <label for="inputSec" class="col-md-1 control-label">Section</label>
              <div class="col-md-3">
                <select name="inputSec" id="inputSec" class="form-control" disabled>
                </select>
              </div>
            </div> 
          </fieldset>
        </form>
      </div>
      <div class="row  container-fluid ams-row">
      	<div id="ams-wrapper" class="ams-wrapper">
        </div>
      </div>
    </div>
<?
}
?>
    <!-- Bootstrap core JavaScript
  
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/datepicker.js"></script>
    <script src="js/custom.js"></script>
	
  </body>
</html>