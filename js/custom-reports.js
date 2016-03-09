var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10) { dd='0'+dd } 
if(mm<10) { mm='0'+mm } 
today = dd+'/'+mm+'/'+yyyy;
$('#ams-container .input-daterange').datepicker({
    format: "dd/mm/yyyy",
    weekStart: 1,
    startDate: "<SEM_START_DATE>",
	endDate: today,
    todayBtn: "linked",
	daysOfWeekDisabled: "0",
    autoclose: true,
    todayHighlight: true
});
$('#ams-container .input-daterange .startDate').datepicker('setDate','<SEM_START_DATE>');
$('#ams-container .input-daterange .endDate').datepicker('setDate',today);

$('#startDate').change(function(e) {

    $('#inputYear').prop('selectedIndex',0);
	//$('#inputYear').attr('disabled');
	
    $('#inputSec').prop('selectedIndex',0);
	$('#inputSec').attr('disabled','disabled');
	
	$('#ams-wrapper').html('');
});

$('#endDate').change(function(e) {

    $('#inputYear').prop('selectedIndex',0);
	//$('#inputYear').attr('disabled');
	
    $('#inputSec').prop('selectedIndex',0);
	$('#inputSec').attr('disabled','disabled');
	
	$('#ams-wrapper').html('');
});

$('#inputYear').change(function(e) {
	
	$.ajax({
		type:"GET",
		url:"getSections.php",
		data:"year="+this.options[this.selectedIndex].value,
		success: function(response) {
					document.getElementById('inputSec').innerHTML = response;
					//$('#inputSec').html(response);
					$('#ams-wrapper').html('');
					$('#inputSec').removeAttr('disabled');
			     }
	});
	
});

$('#inputSec').change(function(e) {
	$('#ams-wrapper').html('<div class="text-center"><img src="inc/loader.gif" style="margin-top: 100px" alt="Loading"/></div>');
	var year = document.getElementById("inputYear");
	var startDate = document.getElementById("startDate");
	var endDate = document.getElementById("endDate");
    $.ajax({
		type:"GET",
		url:"genReports.php",
		data:"year="+year.options[year.selectedIndex].value+"&sec="+this.options[this.selectedIndex].value+"&startDate="+startDate.value+"&endDate="+endDate.value,
		success: function(response) {
					//document.getElementById('ams-wrapper').innerHTML = response;
					$('#ams-wrapper').html(response);
			     }
	});
	
});

$('.ams-row').on('click','#export', function() {
	var $btn = $(this).button('loading');
	var startDate = $('#startDate').val();
	var endDate = $('#endDate').val();
	var year = $('#inputYear').val();
	var sec = $('#inputSec').val();
	window.location="download.php?year="+year+"&sec="+sec+"&startDate="+startDate+"&endDate="+endDate;
	$("#message").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Your Download has been started...</div>');
	setTimeout(function(){ $btn.button('reset'); }, 3000);
});
