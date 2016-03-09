<?php
session_start();

$dbhost  = $_SESSION['dbhost'];
$dbuser  = $_SESSION['dbuser'];
$dbpass  = $_SESSION['dbpass'];
$dbname  = $_SESSION['dbname'];


$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db($dbname);

if(isset($_POST['upload']))
    {
    	for($y=2;$y<=4;$y++)
    	{
	         for($s=1;$s<=$_POST["sec".$y];$s++)
	         {
		         $fname = $_FILES['file'.$y.'_'.$s]['name'];
		         echo 'upload file name: '.$fname.' ';
		         $chk_ext = explode(".",$fname);
		        
		         if(strtolower(end($chk_ext)) == "csv")
		         {
		        
		             $filename = $_FILES['file'.$y.'_'.$s]['tmp_name'];
		             $handle = fopen($filename, "r");
		       
		       		echo "Entering here";
		       		$count = 0;
		             while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		             {
		             	if($count  == 0)
		             	{	
		             		$count++;
		             		continue;
		             	}
		                $sql = "INSERT into `students-".$y."-".$s."`(HTNo,Name) values('$data[0]','$data[1]')";
		                mysql_query($sql) or die(mysql_error());
		                
		             }
		       
		             fclose($handle);
		             echo "Successfully Imported";
		            
		         }
		         else
		         {
		             echo "Invalid File";
		         }
		     }
	    }   
    }
file_put_contents("../inc/config.php", "<?php".PHP_EOL.'$setup=1;'.PHP_EOL."?>");
?>
