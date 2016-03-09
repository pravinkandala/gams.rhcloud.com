<?php
if(isset($_GET["year"]) && isset($_GET["sec"]) && isset($_GET["startDate"]) && isset($_GET["endDate"]) )
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
	<table border="1">
		<thead>
			<tr>
				<td>S.No.</td>
				<td>Roll No.</td>
				<td>Name</td>
				<?
				foreach($subjects as $subName=>$subAttd)
				{
					?>
					<td><?=$subName ?></td>
					<?
				}
				?>
				<td>Total</td>
				<td>Average</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>Classes Conducted</td>
				<?
				$tot = 0;
				foreach($subjects as $subName=>$subAttd)
				{
					$tot = $tot + $subAttd;
					?>
					<td><?=$subAttd ?></td>
					<?
				}
				?>
				<td><?=$tot ?></td>
				<td>100.00</td>
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
						<td><?=number_format(($totAttd/$tot)*100,2,'.','') ?></td>
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
<?
}
else
{
	echo "Forbidden :P";
}
?>