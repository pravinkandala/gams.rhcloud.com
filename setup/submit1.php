<?php
session_start();
set_time_limit(500);

$data = json_decode(file_get_contents('php://input'), true);
/*echo "<pre>";
print_r($data);
echo "</pre>";*/

$dbhost  = $_SESSION['dbhost'];
$dbuser  = $_SESSION['dbuser'];
$dbpass  = $_SESSION['dbpass'];
$dbname  = $_SESSION['dbname'];
$year[2] = 2;
$year[3] = 3;
$year[4] = 4;
$sql     = array();
$retval  = array();


###########################

$nos = array(0,$data[2]["sec"],$data[3]["sec"],$data[4]["sec"]);
$branch = "CSE";
$roman = array('I','II','III','IV');

$str = '<?php'.PHP_EOL.' $sections = array( ';
for($i=2;$i<=4;$i++)
{
    $str = $str." '".$i."' => array( ";
    for($j=1;$j<=$nos[$i-1];$j++)
    {
        if($j == $nos[$i-1])
            $str = $str." '".$j."' => '".$roman[$i-1]." - ".$branch." ".$j."'";
        else
            $str = $str." '".$j."' => '".$roman[$i-1]." - ".$branch." ".$j."', ";
    }
    if($i==4)
        $str = $str." )";
    else
        $str = $str." ),";
    
}
$str = $str." );".PHP_EOL." ?>";
file_put_contents("../inc/sections.php", $str);





########################################



$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}

for ($i = 2; $i < 5; $i++) {
    
    
    $sql[$i] = "CREATE TABLE IF NOT EXISTS `subjects-" . $year[$i] . "`( " . "id INT(2) NOT NULL AUTO_INCREMENT, " . "sub_name VARCHAR(20) NOT NULL, " . "primary key (id))";
    
    mysql_select_db($dbname);
    $retval[$i] = mysql_query($sql[$i], $conn);
    if (!$retval[$i]) {
        die('Could not create table: ' . mysql_error());
    }
}


for ($i = 2; $i < 5; $i++) {
    
    
    for ($x = 1; $x <= $data[$i]["sec"]; $x++) {
        $sql[5] = "CREATE TABLE IF NOT EXISTS `dailyattendance-" . $year[$i] . "-" . $x . "` ( " . "date date NOT NULL, " . "period int(11) NOT NULL, " . "sub_name varchar(25) NOT NULL, " . "absentees text NOT NULL, " . "primary key (date,period))";
        
        
        mysql_select_db($dbname);
        $retval[5] = mysql_query($sql[5], $conn);
        if (!$retval[5]) {
            
            die('Could not alter table: ' . mysql_error());
            
        }
        
        
        $sql[6] = "CREATE TABLE IF NOT EXISTS `students-" . $year[$i] . "-" . $x . "`( 
         HTNo VARCHAR(10) NOT NULL,
         Name VARCHAR(30) NOT NULL,
	     primary key (HTNo))";
        
        
        mysql_select_db($dbname);
        $retval[6] = mysql_query($sql[6], $conn);
        if (!$retval[6]) {
            
            die('Could not alter table: ' . mysql_error());
            
        }
    }
}
for ($i = 2; $i < 5; $i++) {
    for ($x = 0; $x < $data[$i]["nosub"]; $x++) {
        $sql[7] = "INSERT INTO `subjects-" . $year[$i] . "`" . "(sub_name)" . "VALUES('" . $data[$i]["subs"][$x] . "')";
        
        mysql_select_db($dbname);
        $retval[7] = mysql_query($sql[7], $conn);
        if (!$retval[7]) {
            die('Could not create table: ' . mysql_error());
        }
    }
}


for ($i = 2; $i < 5; $i++) {
    
    for ($y = 1; $y <= $data[$i]["sec"]; $y++) {
        for ($x = 1; $x <= $data[$i]["nosub"]; $x++) {
            
            $sql[8] = "ALTER TABLE `students-" . $year[$i] . "-" . $y . "`
	         ADD COLUMN `sub-" . $x . "` int(3) NOT NULL DEFAULT 0";
            
            mysql_select_db($dbname);
            $retval[8] = mysql_query($sql[8], $conn);
            if (!$retval[8]) {
                
                die('Could not alter table: ' . mysql_error());
            }
            
        }
    }
}

#################################################
?>
<div class="container" id="contain3">
<div id="steps">
        <div class="step" data-desc="Database Credentials">1</div>
        <div class="step" data-desc="Access Credentials">2</div>
        <div class="step" data-desc="Insert Data">3</div>
        <div class="step active" data-desc="Upload Student List">4</div>
    </div>
    <div class="row">

<form action="upload.php" method="post" enctype="multipart/form-data">
<?php
		$sec2 = $data[2]["sec"];
		$sec3 = $data[3]["sec"];
		$sec4 = $data[4]["sec"];
?>
<input type="hidden" value="<?=$sec2 ?>" name="sec2" />
<input type="hidden" value="<?=$sec3 ?>" name="sec3" />
<input type="hidden" value="<?=$sec4 ?>" name="sec4" />
<table border="1">
	<thead>
		<tr>
			<th>2nd Year</th>
			<th>3rd Year</th>
			<th>4th Year</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		
		$i2=$i3=$i4=0;
		$rows=max($sec2,$sec3,$sec4);
		for($i=0;$i<$rows;$i++)
		{
			?>
			<tr>
				<td><?=($i2++<$sec2)?'<input type="file" name="file2_'.$i2.'" />':"" ?></td>
				<td><?=($i3++<$sec3)?'<input type="file" name="file3_'.$i3.'" />':"" ?></td>
				<td><?=($i4++<$sec4)?'<input type="file" name="file4_'.$i4.'" />':"" ?></td>
			</tr>
			<?		
		}
		?>
	</tbody>
</table>
<input type='submit' name='upload' value='upload'>
</form>
</div>
</div>
<script src="js/index.js"></script>