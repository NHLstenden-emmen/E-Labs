<?php
if (!empty($_POST['title']) && isset($_POST['title'])) {
	$title = $_POST['title'];
	$date =  date('Y-m-d H:i:s');
	$theory = $_POST['theory'];
	$safety = $_POST['safety'];
	$creater_id = $_SESSION['user_id'];
	$logboek = $_POST['logboek'];
	$method_materials = $_POST['method_materials'];
	if(isset($_POST['inleveren'])){
		$submitted = 1;
	} elseif(isset($_POST['opslaan'])) {
		$submitted = 0;
	}
	$grade = '';
	$year = $_POST['year'];
	$Attachment = '';
	$Goal = $_POST['Goal'];
	$Hypothesis = 'Hypothesis';
	
	$createdLabjournaalID = $db->LabjournaalToevoegen($title, $date, $theory, $safety, $creater_id, $logboek, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis);

	while ($thisResult = $createdLabjournaalID->fetch_array(MYSQLI_ASSOC)){
		$message = $db->connectNewLabjournaalWithUser($_SESSION['user_id'], $thisResult['labjournaal_id']);
	}
	echo $message;
}
if (empty($message)) {
?>
<form action="createNewLabjournaal.php" method="post" class="newlabjournaalcontainer">
	<div>
		<label for="title"><?php echo $lang["TITLE"];?>:</label> </br>
		<input type="text" name="title" class="nieuwetitellabjournaal">
	</div>
	<div></div>
	<div>
		<label for="Goal"><?php echo $lang["GOAL"];?>:</label> </br>
			<textarea class="groteretextarealabjournaal" name="Goal"></textarea>
	</div>
	<div>
		<label for="Hypothesis"><?php echo $lang["HYPOTHESIS"];?>:</label> </br>
			<textarea class="groteretextarealabjournaal" name="Hypothesis"></textarea>
	</div>
	<div>
		<label for="theory"><?php echo $lang["THEORY"];?>:</label> </br>
			<textarea class="groteretextarealabjournaal" name="theory"></textarea>
	</div>
	<div>
		<label for="safety"><?php echo $lang["SAFETY"];?>:</label> </br>
			<textarea class="groteretextarealabjournaal" name="safety"></textarea>
	</div>
	<div>
		<label for="logboek"><?php echo $lang["LOGBOOK"];?>:</label> </br>
			<textarea class="groteretextarealabjournaal" name="logboek"></textarea>
	</div>
	<div>
		<label for="method_materials"><?php echo $lang["METHOD_MATERIALS"];?>:</label> </br>
			<textarea class="groteretextarealabjournaal" name="method_materials"></textarea>
	</div>
	<div>
		<label for="year">Year:</label> </br>
		<label for="1"><?php echo $lang["YEAR_1"];?></label>
			<input type="radio" name="year" value="1" checked>
		<label for="1"><?php echo $lang["YEAR_2"];?></label>
			<input type="radio" name="year" value="2">
		<label for="1"><?php echo $lang["YEAR_3"];?></label>
			<input type="radio" name="year" value="3">
	</div>
	<div>
		<label for="fileupload"><?php echo $lang["UPLOAD_FILE"];?>:</label> </br>
			<input type="file" name="fileupload">
	</div>	
	<div>
		<input type="submit" name="opslaan" value="<?php echo $lang["SAVE"];?>">
		<input type="submit" name="inleveren" value="<?php echo $lang["HAND_IN"];?>">
	</div>
	<div>
		<input type="reset" name="reset" value="<?php echo $lang["RESET"];?>"> </br>
	</div>
</form>
<?php } ?>