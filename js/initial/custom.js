var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10) { dd='0'+dd } 
if(mm<10) { mm='0'+mm } 
today = dd+'/'+mm+'/'+yyyy;
$('#ams-container .input-group.date').datepicker({
    format: "dd/mm/yyyy",
    weekStart: 1,
    startDate: "<SEM_START_DATE>",
	endDate: today,
    todayBtn: "linked",
	daysOfWeekDisabled: "0",
    autoclose: true,
    todayHighlight: true
});
$('#ams-container .input-group.date').datepicker('setDate',today);
var tot_periods=7;
$('#inputDate').change(function(e) {

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
	var date = document.getElementById("inputDate");
    $.ajax({
		type:"GET",
		url:"getAMS.php",
		data:"year="+year.options[year.selectedIndex].value+"&sec="+this.options[this.selectedIndex].value+"&date="+date.value,
		success: function(response) {
					//document.getElementById('ams-wrapper').innerHTML = response;
					$('#ams-wrapper').html(response);
			     }
	});
	
});

$('.ams-row').on('change', '#selectType', function(e) {
	if(this.value == "Absentees") {
		var num_periods = tot_periods;
		while(num_periods)
		{
			if($('#per'+num_periods).val() == null) {
				$("input[name='"+num_periods+"']").removeAttr('checked');
				
			}
			num_periods--;
		}
		
	}
	else if(this.value == "Presentees") {
		var  num_periods = tot_periods;
		while(num_periods)
		{
			if($('#per'+num_periods).val() == null) {
				$("input[name='"+num_periods+"']").prop('checked',true);
			}
			num_periods--;
		}
	}
});
$('.ams-row').on('change','select', function(e) {
	var checkPer = this.name;
	var pttr = /^per([1-7])$/;
	var match = pttr.exec(checkPer);
	if(match) {
		var per_no = match[1];
		$("input[name='"+per_no+"']").removeAttr('disabled');
	}
});
$('.ams-row').on('click','#submitAll', function() {
	var $btn = $(this).button('loading');
	var date = $('#inputDate').val();
	var year = $('#inputYear').val();
	var sec = $('#inputSec').val();
	var attendance = '[';
	for(var i=1;i<=tot_periods;i++) {
		var sub_name = $('#per'+i).val();
		var absent = "";
		$('input[name="'+i+'"]:checked').each(function() {
			absent = absent + "\"" + this.value + "\" , "; 
		});
		attendance = attendance + '{ "sub_name" : "' + sub_name + '" , "absentees" : [' + absent.slice(0,-2) + '] } , '; 
	}
	attendance = attendance.slice(0,-2) + ']';
	var jsonOut = '{ "date" : "' + date.trim() + '" , "year" : ' + year + ' , "sec" : ' + sec + ' , "attendance" : ' + attendance + ' } ';
	console.log(JSON.parse(jsonOut));
	var jsonObj = JSON.parse(jsonOut);
	$.ajax({
	  type: "POST",
	  url: "process.php",
	  data: jsonOut,
	  contentType: "application/json",
	  success: function(result){
		  $("#message").html(result);
		  $btn.button('reset');
	  },
	  error: function(e){
		  console.log(e.message);
	  }
    });
	
});
