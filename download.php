<?php
if(isset($_GET["year"]) && isset($_GET["sec"]) && isset($_GET["startDate"]) && isset($_GET["endDate"]) )
{
	include "inc/simple_html_dom.php";
	$table = file_get_contents("http://localhost/amsnew/genDownloadable.php?year=".$_GET["year"]."&sec=".$_GET["sec"]."&startDate=".$_GET["startDate"]."&endDate=".$_GET["endDate"]);
	
	$html = str_get_html($table);
	
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename=Report.csv');
	
	$fp = fopen("php://output", "w");
	
	foreach($html->find('tr') as $element)
	{
		$line = array();
		foreach($element->find('td') as $row)  
		{
			array_push($line,$row->plaintext);
		}
		if (!empty($line)) 
		{
			fputcsv($fp, $line);		
		}
	}
	fclose($fp);
}
else
{
	echo "Forbidden :P";
}
?>