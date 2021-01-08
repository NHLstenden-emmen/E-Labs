<?php
if (!empty($_POST['title']) && isset($_POST['Opslaan']) || isset($_POST['Inleveren'])){
	$title = $_POST['title'];
	$date =  date('Y-m-d H:i:s');
	$theory = $_POST['theory'];
	$safety = $_POST['safety'];
	$creater_id = $_SESSION['user_id'];
	$logboek = $_POST['logboek'];
	$method_materials = $_POST['method_materials'];
	if(isset($_POST['Inleveren'])){
		$submitted = 1;
	} elseif(isset($_POST['Opslaan'])) {
		$submitted = 0;
	}
	$grade = 0;
	$year = $_POST['year'];
	$Goal = $_POST['Goal'];
	$Hypothesis = $_POST['Hypothesis'];
	$UserID = $_SESSION['user_id'];
	$labjournaal_id = $_GET['id'];
	if(!empty($_FILES['fileupload']['name'])){
		
		$target_file = basename($_FILES["fileupload"]["name"]);
		$uploadOk = 1;
		$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// check the size of the file
		if ($_FILES["fileupload"]["size"] > 2000000) {
			echo "Sorry, your file is too large.<br>";
			$uploadOk = 0;
		}

		// Allow certain file formats
		if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" && $fileType != "csv" ) {
			echo "Sorry, only JPG, JPEG, PNG, GIF & CSV(excel file form) files are allowed.<br>";
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
			$message = $db->updatelabjournaalWithAtatchment($title, $date, $theory, $safety, $logboek, $method_materials, $submitted, $year, $Attachment, $Goal, $Hypothesis, $UserID, $labjournaal_id);
		} else {
			$message = $db->updatelabjournaalWithOutAtatchment($title, $date, $theory, $safety, $logboek, $method_materials, $submitted, $year, $Goal, $Hypothesis, $UserID, $labjournaal_id);
		}
	} else{
		$message = $db->updatelabjournaalWithOutAtatchment($title, $date, $theory, $safety, $logboek, $method_materials, $submitted, $year, $Goal, $Hypothesis, $UserID, $labjournaal_id);
	}
}


if (empty($message) && isset($_GET['id'])) {
	$getLabjournaal = $db->getLabjournaal($_GET['id'], $_SESSION['user_id']);
	while ($result = $getLabjournaal->fetch_array(MYSQLI_ASSOC)){ 
		if ($result["submitted"] == 0) {
		?>
	<form method="post" enctype='multipart/form-data' class="newlabjournaalcontainer">
		<div class="form-row">
			<div class="col-md-4 mb-3 offset-1">
				<label for="title"><?php echo $lang["TITLE"];?>:</label> </br>
				<input type="text" name="title" class="nieuwetitellabjournaal" value="<?php echo $result['title'];?>">
				<!-- </form> -->
			</div>
			<div class="col-md-4 mb-3 offset-1">
					<?php
						echo "<label for='users'><a class='help'><i class='fas fa-question-circle' Title='Ctrl + Linkermuisknop om meerdere te selecteren'></i></a>".$lang['OTHERSTUDENTS']."</label>";
						$student = $db->selectStudents();
						echo '<div class="twoinone"><div><select name="medestudenten" multiple>';
						while ($user = $student->fetch_array(MYSQLI_ASSOC)){
							if($user['user_id'] !== $_SESSION['user_id'] && $user['user_id'] !== $result['creater_id']){
								echo "<option value='".$user['user_id']."'";
								$labusers = $db->GetAllLabUsers($_GET['id']);
								while($labuser = $labusers->fetch_array(MYSQLI_ASSOC)){
									if($user['user_id'] === $labuser['user_id']){
										echo "selected='selected'";
									}
								}
								echo ">".$user['name']."</option>";
							}
						}
						echo "</select></div><div>";
						if($_SESSION['user_id'] == $result['creater_id']){
							$labusers = $db->GetAllLabUsers($_GET['id']);
							echo "<ul><pre>";
							while ($users = $labusers->fetch_array(MYSQLI_ASSOC)){
								if($users['user_id'] !== $result['creater_id']){
									$username = $users['name'];
									echo "<li>".$username."&#9;&#9;<button name='delete' value='".$users['user_id']."'>Delete</button></li>";
								}
							}
							echo "</pre></ul>";
						}
						echo "</div></div>";
						if(isset($_POST['delete'])){
							$deleteuser = $_POST['delete'];
							$delete = $db->DeleteExtraUser($deleteuser, $_GET['id']);
							echo $delete;
						}
						?>
			</div>
		</div>
		<!-- <form method="post" class="newlabjournaalcontainer"> -->
		<div class="form-row">
			<div class="col-md-4 mb-3 offset-1">
				<label for="Goal"><?php echo $lang["GOAL"];?>:</label> </br>
					<textarea class="groteretextarealabjournaal" name="Goal" value="<?php echo $result['Goal'];?>"><?php echo $result['Goal'];?></textarea>
			</div>
			<div class="col-md-4 mb-3 offset-1">
				<label for="Hypothesis"><?php echo $lang["HYPOTHESIS"];?>:</label> </br>
					<textarea class="groteretextarealabjournaal" name="Hypothesis" value="<?php echo $result['Hypothesis'];?>"><?php echo $result['Hypothesis'];?></textarea>
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-4 mb-3 offset-1">
				<label for="theory"><?php echo $lang["THEORY"];?>:</label> </br>
					<textarea class="groteretextarealabjournaal" name="theory" value="<?php echo $result['theory'];?>"><?php echo $result['theory'];?></textarea>
			</div>
			<div class="col-md-4 mb-3 offset-1">
				<label for="safety"><?php echo $lang["SAFETY"];?>:</label> </br>
					<textarea class="groteretextarealabjournaal" name="safety" value="<?php echo $result['safety'];?>"><?php echo $result['safety'];?></textarea>
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-4 mb-3 offset-1">
				<label for="logboek"><?php echo $lang["LOGBOOK"];?>:</label> </br>
					<textarea class="groteretextarealabjournaal" name="logboek" value="<?php echo $result['logboek'];?>"><?php echo $result['logboek'];?></textarea>
			</div>
			<div class="col-md-4 mb-3 offset-1">
				<label for="method_materials"><?php echo $lang["METHOD_MATERIALS"];?>:</label> </br>
					<textarea class="groteretextarealabjournaal" name="method_materials" value="<?php echo $result['method_materials'];?>"><?php echo $result['method_materials'];?></textarea>
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-4 mb-3 offset-1">
			
				<label for="year"><?php echo $lang["YEAR"];?>:</label> </br>
				<label for="1"><?php echo $lang["YEAR_1"];?></label>
					<input type="radio" name="year" value="1" <?php if($year == 1){echo 'checked';}?>>
				<label for="1"><?php echo $lang["YEAR_2"];?></label>
					<input type="radio" name="year" value="2"<?php if($year == 2){echo 'checked';}?>>
				<label for="1"><?php echo $lang["YEAR_3"];?></label>
					<input type="radio" name="year" value="3"<?php if($year == 3){echo 'checked';}?>>
			</div>
			<div class="col-md-4 mb-3 offset-1">
				<label for="fileupload"><?php echo $lang["UPLOAD_FILE"];?>:</label></br>
				<input name='fileupload' type='file'>				
			</div>	
		</div>
		<?php 
			// check if its a img of excel file
			$fileSortCheck = strtolower($result["Attachment"]);
			$file = $result["Attachment"];
			// check if source is a image
			if (preg_match('/(\.jpg|\.png|\.jpeg|\.gif)$/', $fileSortCheck)) {
				echo '<img src="'.$file.'" alt="" srcset="">';
				// check if source is a csv format from excel.
			} else if (preg_match('/(\.csv)$/', $fileSortCheck)){
					echo "<br>";
					echo "<table>\n\n";
						$f = fopen($file, "r");
						while (($line = fgetcsv($f)) !== false) {
							echo "<tr>";
							foreach ($line as $cell) {
								echo "<td style='border: 1px solid black;'>" . htmlspecialchars($cell) . "</td>";
							}
							echo "</tr>\n";
						}
						fclose($f);
					echo "\n</table>";
			} else if (empty($result["Attachment"])){
				# just a check if there is a scoure set.
			} else {
				echo "AN error occurred: file was not found";
			}
		?>
		<div class="form-row">
			<div class="col-md-4 mb-3 offset-1">
				<input type="submit" name="Opslaan" value="<?php echo $lang["SAVE"];?>">
				<input type="submit" name="Inleveren" value="<?php echo $lang["HAND_IN"];?>">
			</div>
			<div class="col-md-4 mb-3 offset-1">
				<input type="reset" name="reset" value="<?php echo $lang["RESET"];?>"> </br>
			</div>
		</div>
	</form>
	<?php  }}
	} else {
		if ($message == "gelukt") {
			echo '<a href="labjournaal">Labjournaal bijgewerkt terug naar het overzicht.</a>';
		} else {
			echo '<a href="labjournaal">Er is een probleem opgetreden.</a>';
		}
}
?>