<?php
session_start();
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )
{
	$absenteesJson = file_get_contents('php://input');
	$absenteesArray = json_decode($absenteesJson,true);
	include_once("inc/dbconnect.php");
	$date = DateTime::createFromFormat('d/m/Y', $absenteesArray["date"]);
	$date = $date->format('Y-m-d');
	$year = $absenteesArray["year"];
	$sec = $absenteesArray["sec"];
	$absenteesArray = $absenteesArray["attendance"];
	
	/* Get Subjects */
	$subjects = array();
	if($getSubjects = $mysqli->query ("SELECT id,sub_name from `subjects-$year`"))
	{
	   while($subjectObj = $getSubjects->fetch_object())
	   {
		   $subId = (int)$subjectObj->id;
		   $subObj = (string)$subjectObj->sub_name;
		   $subjects[$subObj]=$subId;
	   }
	}
	else
	{
	   echo "Error while fetching Subjects";
	}
	
	/* Data Handling */
	foreach($absenteesArray as $period=>$details)
	{
		if($details["sub_name"] == "null")
		{
			break;
		}
		else
		{
			$effPeriod = $period + 1;
			$effSubId = $subjects[$details["sub_name"]];
			if($checkAvailable = $mysqli->query("SELECT date, period, sub_name from `dailyattendance-$year-$sec` WHERE date='$date' AND period=$effPeriod"))
			{
				if($checkAvailable->fetch_object())
				{
					if(isset($_SESSION["logged"]) && $_SESSION["role"]="Administrator")
					{
						if($qryDB = $mysqli->prepare("UPDATE `dailyattendance-".$year."-".$sec."` SET sub_name=?, absentees=? WHERE date=? AND period=?"))
						{
							$qryDB->bind_param("sssi",$details["sub_name"],json_encode($details["absentees"]),$date,$effPeriod);
							$qryDB->execute();
							$qryDB->close();
						}
						else
						{
							echo "Wrong Update Stmt :/";
						}	
					}
					else
					{
						echo "Access Denied :(";
					}
				}
				else
				{
					if($qryDB = $mysqli->prepare("INSERT into `dailyattendance-".$year."-".$sec."` (date, period, sub_name, absentees) VALUES (?, ?, ?, ?)"))
					{
						$qryDB->bind_param("siss",$date,$effPeriod,$details["sub_name"],json_encode($details["absentees"]));
						$qryDB->execute();
						$qryDB->close();
					}
					else
					{
						echo "Wrong Insert Stmt :/";
					}	
				}
			}
			else
			{
				echo "Wrong Check Available Statement";
			}		 
		}
	}
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Kudos !! </strong>Attendance has been Saved!.
	</div>
<?
}
else
{
	echo "Forbidden :P";
}
?>