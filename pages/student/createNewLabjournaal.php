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
	$Goal = $_POST['Goal'];
	$Hypothesis = $_POST['Hypothesis'];
	if(!empty($_POST['medestudenten'])){
		$medestud = $_POST['medestudenten'];
	}

	if(!empty($_FILES['fileupload']['name'])){
		
		$target_file = basename($_FILES["fileupload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// check the size of the file
		if ($_FILES["fileupload"]["size"] > 2000000) {
			echo "Sorry, your file is too large.<br>";
			$uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
			$uploadOk = 0;
		}

		$UploadedFileName=$_FILES['fileupload']['name'];
		
		$upload_directory = "gebruikersBestanden/uploads/";
		$time = time();
		$TargetPath=$time.$UploadedFileName;
	
		if(move_uploaded_file($_FILES['fileupload']['tmp_name'], $upload_directory.$TargetPath)){ 
			$Attachment = $upload_directory.$TargetPath;
		}
		if ($uploadOk == 1) {
			echo $title, $date, $theory, $safety, $creater_id, $logboek, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis;
			$createdLabjournaalID = $db->LabjournaalToevoegenWithAttachment($title, $date, $theory, $safety, $creater_id, $logboek, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis);
		} else {
			$createdLabjournaalID = $db->LabjournaalToevoegenWithOutAttachment($title, $date, $theory, $safety, $creater_id, $logboek, $method_materials, $submitted, $grade, $year, $Goal, $Hypothesis);
		}
	} else{ 
		$createdLabjournaalID = $db->LabjournaalToevoegenWithOutAttachment($title, $date, $theory, $safety, $creater_id, $logboek, $method_materials, $submitted, $grade, $year, $Goal, $Hypothesis);
	}


	while ($thisResult = $createdLabjournaalID->fetch_array(MYSQLI_ASSOC)){
		$message = $db->connectNewLabjournaalWithUser($_SESSION['user_id'], $thisResult['labjournaal_id']);
		if(isset($medestud)){
		foreach($medestud as $entry){
			$db->connectNewLabjournaalWithUser($entry, $thisResult['labjournaal_id']);
		}}
	}
	if ($message == "Labjournaal toegevoegd") {
		echo '<a href="labjournaal">Labjournaal toegevoegd terug naar het overzicht.</a>';
	} else {
		echo '<a href="labjournaal">Er is een probleem opgetreden.</a>';
	}
}



if (empty($message)) {
	$result = $db->selectStudents();
?>
<form method="post" class="newlabjournaalcontainer" enctype='multipart/form-data' >
	<div>
		<label for="title"><?php echo $lang["TITLE"];?>:</label> </br>
		<input type="text" name="title" class="nieuwetitellabjournaal">
	</div>
	<div>
	<label for="medestudenten"><?php echo $lang["OTHERSTUDENTS"];?>:</label> </br>
	<select name="medestudenten[ ]" multiple>
	<?php
	while ($user = $result->fetch_array(MYSQLI_ASSOC)){
		if($user['user_id'] !== $_SESSION['user_id']){
			echo "<option value='".$user["user_id"]."'>".$user['name']."</option>";
		}
	}
	?>
	</select>
	</div>
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
		<label for="fileupload"><?php echo $lang["UPLOAD_FILE"];?>:</label></br>
		<input name='fileupload' type='file'>
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