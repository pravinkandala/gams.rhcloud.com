<?php
define('header',1); include('inc/header.php');
define('navbar',1); define('reports',1); include('inc/navbar.php');

if(defined('showAMS'))
{
?>
    <div class="container-fluid">
      <div class="row text-center attendance-form">
      	<form class="form-horizontal col-md-offset-4">
          <fieldset>
            <div class="form-group">
              <div class="col-md-offset-1 col-md-1">
                <label class="control-label">Dates</label>
              </div>
              <div class="col-md-4" id="ams-container">
              	<div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="input-md form-control startDate" name="startDate" id="startDate" />
                    <span class="input-group-addon">to</span>
                    <input type="text" class="input-md form-control endDate" name="endDate" id="endDate"/>
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
    <script src="js/custom-reports.js"></script>
	
  </body>
</html>