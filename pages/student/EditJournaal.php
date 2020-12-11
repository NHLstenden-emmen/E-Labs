<?php
if(isset($_POST['uploadcsv'])){
		if(!empty($_FILES['fileupload']['name'])){

			$UploadedFileName=$_FILES['fileupload']['name'];
			
			$upload_directory = "gebruikersBestanden/uploads/"; //This is the folder which you created just now
			$time = time();
			$TargetPath=$time.$UploadedFileName;
		
			if(move_uploaded_file($_FILES['fileupload']['tmp_name'], $upload_directory.$TargetPath)){ 
				$db->updatebestanden($_SESSION['user_id'], $upload_directory.$TargetPath);
			}

		}
}

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
	$grade = 0;
	$year = $_POST['year'];
	$Attachment = '';
	$Goal = $_POST['Goal'];
	$Hypothesis = 'Hypothesis';
	$UserID = $_SESSION['user_id'];
	$labjournaal_id = $_GET['id'];
	$message = $db->updatelabjournaal($title, $date, $theory, $safety, $logboek, $method_materials, $submitted, $year, $Attachment, $Goal, $Hypothesis, $UserID, $labjournaal_id);
}


if (empty($message) && isset($_GET['id'])) {
	$getLabjournaal = $db->getLabjournaal($_GET['id'], $_SESSION['user_id']);
	while ($result = $getLabjournaal->fetch_array(MYSQLI_ASSOC)){ 
		if ($result["submitted"] == 0) {
		?>
	<form method="post" class="newlabjournaalcontainer">
		<div>
			<label for="title"><?php echo $lang["TITLE"];?>:</label> </br>
			<input type="text" name="title" class="nieuwetitellabjournaal" value="<?php echo $result['title'];?>">
		</div>
		<div></div>
		<div>
			<label for="Goal"><?php echo $lang["GOAL"];?>:</label> </br>
				<textarea class="groteretextarealabjournaal" name="Goal" value="<?php echo $result['Goal'];?>"><?php echo $result['Goal'];?></textarea>
		</div>
		<div>
			<label for="Hypothesis"><?php echo $lang["HYPOTHESIS"];?>:</label> </br>
				<textarea class="groteretextarealabjournaal" name="Hypothesis" value="<?php echo $result['Hypothesis'];?>"><?php echo $result['Hypothesis'];?></textarea>
		</div>
		<div>
			<label for="theory"><?php echo $lang["THEORY"];?>:</label> </br>
				<textarea class="groteretextarealabjournaal" name="theory" value="<?php echo $result['theory'];?>"><?php echo $result['theory'];?></textarea>
		</div>
		<div>
			<label for="safety"><?php echo $lang["SAFETY"];?>:</label> </br>
				<textarea class="groteretextarealabjournaal" name="safety" value="<?php echo $result['safety'];?>"><?php echo $result['safety'];?></textarea>
		</div>
		<div>
			<label for="logboek"><?php echo $lang["LOGBOOK"];?>:</label> </br>
				<textarea class="groteretextarealabjournaal" name="logboek" value="<?php echo $result['logboek'];?>"><?php echo $result['logboek'];?></textarea>
		</div>
		<div>
			<label for="method_materials"><?php echo $lang["METHOD_MATERIALS"];?>:</label> </br>
				<textarea class="groteretextarealabjournaal" name="method_materials" value="<?php echo $result['method_materials'];?>"><?php echo $result['method_materials'];?></textarea>
		</div>
		<div>
			<label for="year"><?php echo $lang["YEAR"];?>:</label> </br>
			<label for="1"><?php echo $lang["YEAR_1"];?></label>
				<input type="radio" name="year" value="1" checked>
			<label for="1"><?php echo $lang["YEAR_2"];?></label>
				<input type="radio" name="year" value="2">
			<label for="1"><?php echo $lang["YEAR_3"];?></label>
				<input type="radio" name="year" value="3">
		</div>
		<div>
			<label for="fileupload"><?php echo $lang["UPLOAD_FILE"];?>:</label> </br>
				<input type="file" name="fileupload" value="<?php echo $result['Attachment'];?>">
				<input type="submit" name="uploadcsv" value="Change/Upload File">
		</div>	
		<div>
			<input type="submit" name="opslaan" value="<?php echo $lang["SAVE"];?>">
			<input type="submit" name="inleveren" value="<?php echo $lang["HAND_IN"];?>">
		</div>
		<div>
			<input type="reset" name="reset" value="<?php echo $lang["RESET"];?>"> </br>
		</div>
	</form>
	<?php  }}
	} else {
	echo $message;
}
?>