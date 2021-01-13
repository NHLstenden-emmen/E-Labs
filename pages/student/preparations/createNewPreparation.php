<?php
if(!isset($_SESSION['title'])){
	$_SESSION['title'] = "";
	$_SESSION['theory'] = "";
	$_SESSION['safety'] = "";
	$_SESSION['logboek'] = "";
	$_SESSION['method_materials'] = "";
	$_SESSION['year'] = "";
	$_SESSION['Goal'] = "";
	$_SESSION['Hypothesis'] = "";
}
if(isset($_POST['search']) || isset($_POST['adduser']) || isset($_POST['deleteuser'])){
$_SESSION['title'] = $_POST['title'];
$_SESSION['theory'] = $_POST['theory'];
$_SESSION['safety'] = $_POST['safety'];
$_SESSION['logboek'] = $_POST['logboek'];
$_SESSION['method_materials'] = $_POST['method_materials'];
$_SESSION['year'] = $_POST['year'];
$_SESSION['Goal'] = $_POST['Goal'];
$_SESSION['Hypothesis'] = $_POST['Hypothesis'];
}
if (!empty($_POST['title']) && !empty($_POST['theory']) && !empty($_POST['safety']) && !empty($_POST['logboek']) && !empty($_POST['method_materials']) && !empty($_POST['year']) && !empty($_POST['Goal']) && !empty($_POST['Hypothesis']) && (isset($_post['inleveren']) || isset($_POST['opslaan']))){
	$title = $_POST['title'];
	$date =  date('Y-m-d H:i:s');
	$theory = $_POST['theory'];
	$safety = $_POST['safety'];
	$creator_id = $_SESSION['user_id'];
	$log = $_POST['logboek'];
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
	if(!empty($_SESSION['addusers'])){
		$medestud = $_SESSION['addusers'];
	}

	if(!empty($_FILES['fileupload']['name'])){
		
		$target_file = basename($_FILES["fileupload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// check the size of the file
		if ($_FILES["fileupload"]["size"] > 2000000) {
			echo $lang['BIG_FILE']."<br>";
			$uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "csv" ) {
			echo $lang['WRONG_FILE']." (".$lang['ONLY']." JPG, JPEG, PNG, GIF & csv ".$lang['ALLOWED'].")<br>";
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
			$createdPreparationID = $db->addPreparationWithAttachment($title, $date, $theory, $safety, $creator_id, $log, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis);
		} else {
			$createdPreparationID = $db->addPreparationWithOutAttachment($title, $date, $theory, $safety, $creator_id, $log, $method_materials, $submitted, $grade, $year, $Goal, $Hypothesis);
		}
	} else{ 
		$createdPreparationID = $db->addPreparationWithOutAttachment($title, $date, $theory, $safety, $creator_id, $log, $method_materials, $submitted, $grade, $year, $Goal, $Hypothesis);
	}


	while ($thisResult = $createdPreparationID->fetch_array(MYSQLI_ASSOC)){
		$message = $db->connectNewPreparationWithUser($_SESSION['user_id'], $thisResult['preparation_id']);
		if(isset($medestud)){
		foreach($medestud as $entry){
			$db->connectNewPreparationWithUser($entry, $thisResult['preparation_id']);
		}}
	}
	echo $message;
	if ($message == "Preparation toegevoegd") {
		echo $lang['LUCASHELPENGLISHEN'].". <a href='preparations'>".$lang['GOBACKOVERVIEW']."</a>";
	} else {
		echo '<a href="preparations">'.$lang['PROBLEMOCCURRED'].'</a>';
	}
	unset($_SESSION['title']);
	unset($_SESSION['theory']);
	unset($_SESSION['safety']);
	unset($_SESSION['logboek']);
	unset($_SESSION['method_materials']);
	unset($_SESSION['year']); 
	unset($_SESSION['Goal']); 
	unset($_SESSION['Hypothesis']); 
}
else if(isset($_POST['inleveren']) || isset($_POST['opslaan'])){
	echo $lang['FILLINFIELDS'];
}
if (empty($message)){
?>
<form method="post" enctype='multipart/form-data' >
<div class="newlabjournaalcontainer3delen">
	<div class="grotetextarealabjournaalmidden">
		<label for="title" class="titlemarge"><?php echo $lang["TITLE"];?>:</label> </br>
		<input type="text" name="title" class="inputtitle" value="<?=$_SESSION['title']?>">
	</div>
	<div class="grotetextarealabjournaallinks">
		<label for="Goal"><?php echo $lang["GOAL"];?>:</label> </br>
		<textarea class="labjournaaltext" name="Goal"><?=$_SESSION['Goal']?></textarea>
	</div>
	<div class="grotetextarealabjournaalmidden">
		<label for="Hypothesis"><?php echo $lang["HYPOTHESIS"];?>:</label> </br>
		<textarea class="labjournaaltext" name="Hypothesis"><?=$_SESSION['Hypothesis']?></textarea>
	</div>
	<div class="grotetextarealabjournaalrechts">				
		<label for="theory"><?php echo $lang["THEORY"];?>:</label> </br>
		<textarea name="theory"><?=$_SESSION['theory']?></textarea>
	</div>
	<div class="grotetextarealabjournaallinks">				
		<label for="safety"><?php echo $lang["SAFETY"];?>:</label> </br>
		<textarea name="safety"><?=$_SESSION['safety']?></textarea>
	</div>
	<div class="grotetextarealabjournaalmidden">
		<label for="logboek"><?php echo $lang["LOG"];?>:</label> </br>
		<textarea name="logboek"><?=$_SESSION['logboek']?></textarea>
	</div>
	<div class="grotetextarealabjournaalrechts">
		<label for="method_materials"><?php echo $lang["METHOD_MATERIALS"];?>:</label></br>
		<textarea name="method_materials"><?=$_SESSION['method_materials']?></textarea>
	</div>
	<div class="grotetextarealabjournaallinks">
		<label for="year">Year:</label> </br>
		<label for="1"><?php echo $lang["YEAR"]." 1";?></label>
			<input type="radio" name="year" value="1" checked>
		<label for="1"><?php echo $lang["YEAR"]." 2";?></label>
			<input type="radio" name="year" value="2">
		<label for="1"><?php echo $lang["YEAR"]." 3";?></label>
			<input type="radio" name="year" value="3">
	</div>
	<div class="grotetextarealabjournaalmidden">
		<label for="fileupload"><?php echo $lang["UPLOAD_FILE"];?>:</label></br>
		<input name='fileupload' type='file'>
	</div>	
	<div class="grotetextarealabjournaalrechts">
			<div class="selectstudent">
				<div>
					<?php echo $lang["OTHERSTUDENTS"];?>:</br>
					<input type="search" name="searchstudent" class="searchstudentbox">
					<input type="submit" name="search" class="searchstudentbutton" Value=<?=$lang['SEARCH'];?>><br>
					<?php
					if(!isset($_SESSION['addusers'])){
						$_SESSION['addusers'] = array();
					}
					if(isset($_POST['adduser'])){
						array_push($_SESSION['addusers'], $_POST['adduser']);
						$_SESSION['addusers'] = array_unique($_SESSION['addusers']);
						if(isset($_POST['inleveren']) || isset($_POST['opslaan'])){
							$db->connectNewPreparationWithUser($_POST['adduser'], $createdPreparationID);
							unset($_SESSION['addusers']);
							unset($_SESSION['user_id_lab']);
						}
					}
					if(isset($_POST['search']) && !empty($_POST['searchstudent'])){
						echo "<table id='selectphp'>";
						$searchfor = "%".$_POST['searchstudent']."%";
						$result = $db->selectStudentslab($searchfor);
						if(isset($result) && $result != NULL){
							echo "<tr><th>Name</th><th>Studentnumber</th><th>Toevoegen</th></tr>";
							foreach ($result as $user){
								$_SESSION['user_id_lab'] = $user['user_id'];
								echo "<tr><td>".$user['name']."</td><td>".$user['user_number']."</td><td>";
								if(!empty($_SESSION['addusers'])){
									foreach($_SESSION['addusers'] as $labuser){
										if($user['user_id'] == $labuser){
											echo $_SESSION['button'] = "<button class='unclickable'>Added</button></td></tr>";
										}
									}
								} 
								if($user['user_id'] == $_SESSION['user_id']){
									echo $_SESSION['button'] = "<button class='unclickable'>Creator</button></td></tr>";
								}
								if(!isset($_SESSION['button'])){
									echo "<button name='adduser' Value='".$_SESSION['user_id_lab']."'>".$lang['ADD_USER']."</button></td></tr>";
								}
								else{
									unset($_SESSION['button']);
								}
							} 
						} 
					echo "</table>";
					}
					?>
				</div>
				<div class="selectedusers">
					<?php
					if(isset($_SESSION['addusers'])){
						echo "<pre>";
						foreach($_SESSION['addusers'] as $user){
							$userdata = $db->selectCurrentUsers($user);
							foreach($userdata as $userPreparation){
								$username = $userPreparation['name'];
								echo "<li>".$username."&#9;<button name='deleteuser' value='".$userPreparation['user_id']."'>".$lang['DELETE']."</button></li>";
							}
						}
						echo "</pre>";
					}
					if(isset($_POST['deleteuser'])){
						$deleteuser = $_POST['deleteuser'];
						$_SESSION['addusers'] = array_diff($_SESSION['addusers'], array($deleteuser));
						echo "<script>window.location.href = window.location.href;</script>";
					}
					?>
				</div>
			</div> 
		</div>
	<div class="grotetextarealabjournaalmidden">
		<input type="submit" name="opslaan" class="oirbuttonlabjournaal" value="<?php echo $lang["SAVE"];?>">
	</div>
	<div class="grotetextarealabjournaalmidden">
		<input type="submit" name="inleveren" class="oirbuttonlabjournaal" value="<?php echo $lang["HAND_IN"];?>">
	</div>
	<div class="grotetextarealabjournaalmidden">
		<input type="reset" name="reset" class="oirbuttonlabjournaal" value="<?php echo $lang["RESET"];?>"> </br>
	</div>
	</div>
</div>
</form>


<?php } ?>