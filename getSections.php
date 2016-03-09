 <?php
 if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && isset($_GET["year"]))
 {
     include_once("inc/sections.php");
	 $year = $_GET["year"];
	 ?>
     <option value="none" style="display:none" disabled selected>-- Section --</option>
     <?
	 foreach($sections[$year] as $no=>$sec)
	 {
		?>
        <option value="<?=$no ?>"><?=$sec ?></option>
        <?
	 }
 }
 else
 {
	 echo "Forbidden :P";
 }
 ?>