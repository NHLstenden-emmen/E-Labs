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
if (!empty($_POST['title']) && isset($_POST['title']) && (isset($_post['inleveren']) || isset($_POST['opslaan']))) {
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
	if(!empty($_SESSION['addusers'])){
		$medestud = $_SESSION['addusers'];
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
	unset($_SESSION['title']);
	unset($_SESSION['theory']);
	unset($_SESSION['safety']);
	unset($_SESSION['logboek']);
	unset($_SESSION['method_materials']);
	unset($_SESSION['year']); 
	unset($_SESSION['Goal']); 
	unset($_SESSION['Hypothesis']); 
}
if (empty($message)) {
?>
<form method="post" class="newlabjournaalcontainer" enctype='multipart/form-data' >
	<div class="form-row">
		<div class="col-md-4 mb-3 offset-1">
			<label for="title"><?php echo $lang["TITLE"];?>:</label> </br>
			<input type="text" name="title" class="nieuwetitellabjournaal" value="<?=$_SESSION['title']?>">
		</div>
		<div class="col-md-4 mb-3 offset-1">
			<div class="selectstudent">
				<div>
					<?php echo $lang["OTHERSTUDENTS"];?>:</br>
					<input type="search" name="searchstudent">
					<input type="submit" name="search" Value="Search"><br>
					<table id="selectphp">
					<?php
					if(!isset($_SESSION['addusers'])){
						$_SESSION['addusers'] = array();
					}
					if(isset($_POST['adduser'])){
						array_push($_SESSION['addusers'], $_POST['adduser']);
						if(isset($_POST['inleveren']) || isset($_POST['opslaan'])){
							$db->connectNewLabjournaalWithUser($_POST['adduser'], $createdLabjournaalID);
							unset($_SESSION['addusers']);
							unset($_SESSION['user_id_lab']);
						}
					}
					if(isset($_POST['search']) && !empty($_POST['searchstudent'])){
						$searchfor = "%".$_POST['searchstudent']."%";
						$result = $db->selectStudentslab($searchfor);
						if(isset($result) && $result != NULL){
							echo "<tr><th>Name</th><th>Studentnumber</th></tr>";
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
									echo "<button name='adduser' Value='".$_SESSION['user_id_lab']."'>Add user</button></td></tr>";
								}
								else{
									unset($_SESSION['button']);
								}
							} 
						} 
					}
					?>
					</table>
				</div>
				<div>
					<pre>
						<?php
						foreach($_SESSION['addusers'] as $user){
							$userdata = $db->selectCurrentUsers($user);
							foreach($userdata as $userlabjournal){
								$username = $userlabjournal['name'];
								echo "<li>".$username."&#9;<button name='deleteuser' value='".$userlabjournal['user_id']."'>Delete</button></li>";
							}
							
						}
						?>
					</pre>
					<?php
					if(isset($_POST['deleteuser'])){
						$deleteuser = $_POST['deleteuser'];
						$_SESSION['addusers'] = array_diff($_SESSION['addusers'], array($deleteuser));
						echo "<script>window.location.href = window.location.href;</script>";
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="form-row">
		<div class="col-md-4 mb-3 offset-1">
			<label for="Goal"><?php echo $lang["GOAL"];?>:</label> </br>
				<textarea class="groteretextarealabjournaal" name="Goal"><?=$_SESSION['Goal']?></textarea>
		</div>
		<div class="col-md-4 mb-3 offset-1">
			<label for="Hypothesis"><?php echo $lang["HYPOTHESIS"];?>:</label> </br>
				<textarea class="groteretextarealabjournaal" name="Hypothesis"><?=$_SESSION['Hypothesis']?></textarea>
		</div>
	</div>
	<div class="form-row">
		<div class="col-md-4 mb-3 offset-1">
			<label for="theory"><?php echo $lang["THEORY"];?>:</label> </br>
				<textarea class="groteretextarealabjournaal" name="theory"><?=$_SESSION['theory']?></textarea>
		</div>
		<div class="col-md-4 mb-3 offset-1">
			<label for="safety"><?php echo $lang["SAFETY"];?>:</label> </br>
				<textarea class="groteretextarealabjournaal" name="safety"><?=$_SESSION['safety']?></textarea>
		</div>
	</div>
	<div class="form-row">
		<div class="col-md-4 mb-3 offset-1">
			<label for="logboek"><?php echo $lang["LOGBOOK"];?>:</label> </br>
				<textarea class="groteretextarealabjournaal" name="logboek"><?=$_SESSION['logboek']?></textarea>
		</div>
		<div class="col-md-4 mb-3 offset-1">
			<label for="method_materials"><?php echo $lang["METHOD_MATERIALS"];?>:</label></br>
				<textarea class="groteretextarealabjournaal" name="method_materials"><?=$_SESSION['method_materials']?></textarea>
		</div>
	</div>
	<div class="form-row">
		<div class="col-md-4 mb-3 offset-1">
			<label for="year">Year:</label> </br>
			<label for="1"><?php echo $lang["YEAR_1"];?></label>
				<input type="radio" name="year" value="1" checked>
			<label for="1"><?php echo $lang["YEAR_2"];?></label>
				<input type="radio" name="year" value="2">
			<label for="1"><?php echo $lang["YEAR_3"];?></label>
				<input type="radio" name="year" value="3">
		</div>
		<div class="col-md-4 mb-3 offset-1">
			<label for="fileupload"><?php echo $lang["UPLOAD_FILE"];?>:</label></br>
			<input name='fileupload' type='file'>
		</div>	
	</div>
	<div class="form-row">
		<div class="col-md-4 mb-3 offset-1">
			<input type="submit" name="opslaan" value="<?php echo $lang["SAVE"];?>">
			<input type="submit" name="inleveren" value="<?php echo $lang["HAND_IN"];?>">
		</div>
		<div class="col-md-4 mb-3 offset-1">
			<input type="reset" name="reset" value="<?php echo $lang["RESET"];?>"> </br>
		</div>
	</div>
</form>

<?php } ?>