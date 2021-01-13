<?php
if (!empty($_POST['title']) && isset($_POST['Opslaan']) || isset($_POST['Inleveren'])){
	$title = $_POST['title'];
	$date =  date('Y-m-d H:i:s');
	$theory = $_POST['theory'];
	$safety = $_POST['safety'];
	$creater_id = $_SESSION['user_id'];
	$log = $_POST['log'];
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
	if(isset($_SESSION['addusers'])){
		$additionalusers = $db->GetAllLabUsers($labjournaal_id);
		$arrayusers = $additionalusers->fetch_all(MYSQLI_ASSOC);
		$userids = array_map(function($x){
			return $x['user_id'];
		}, $arrayusers);
		$arraysorted = array_diff($_SESSION['addusers'], $userids);
		foreach($arraysorted as $arraysorted2){
		$db->connectNewLabjournalWithUser($arraysorted2, $_GET['id']);
		}
	}
	if(!empty($_FILES['fileupload']['name'])){
		$getLabjournal = $db->getLabjournal($_GET['id'], $_SESSION['user_id']);
		while ($result = $getLabjournal->fetch_array(MYSQLI_ASSOC)){ 
			if(!empty($result['Attachment'])){
				if(file_exists($result['Attachment'])){
					unlink($result['Attachment']);
				}
			}
		}
		$target_file = basename($_FILES["fileupload"]["name"]);
		$uploadOk = 1;
		$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// check the size of the file
		if ($_FILES["fileupload"]["size"] > 2000000) {
			echo $lang['BIG_FILE']."<br>";
			$uploadOk = 0;
		}

		// Allow certain file formats
		if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" && $fileType != "csv" ) {
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
			$message = $db->updatelabjournalWithAtatchment($title, $date, $theory, $safety, $log, $method_materials, $submitted, $year, $Attachment, $Goal, $Hypothesis, $UserID, $labjournaal_id);
		} else {
			$message = $db->updatelabjournalWithOutAtatchment($title, $date, $theory, $safety, $log, $method_materials, $submitted, $year, $Goal, $Hypothesis, $UserID, $labjournaal_id);
		}
	} else{
		$message = $db->updatelabjournalWithOutAtatchment($title, $date, $theory, $safety, $log, $method_materials, $submitted, $year, $Goal, $Hypothesis, $UserID, $labjournaal_id);
	}
}


if (empty($message) && isset($_GET['id'])) {
	$getLabjournal = $db->getLabjournal($_GET['id'], $_SESSION['user_id']);
	while ($result = $getLabjournal->fetch_array(MYSQLI_ASSOC)){ 
		$_SESSION['creator_id'] = $result['creator_id'];
		if(!empty($_FILES['fileupload']['name'])){
			var_dump($result['Attachment']);
			unlink($result['Attachment']);
		}
		if ($result["submitted"] == 0) {
		?>
	<form method="post" enctype='multipart/form-data'>
		<div class="newlabjournaalcontainer3delen">
			<div class="grotetextarealabjournaalmidden">
				<label for="title" class="titlemarge"><?php echo $lang["TITLE"];?>:</label> </br>
				<input type="text" name="title" class="inputtitle" value="<?php echo $result['title'];?>">
				<!-- </form> -->
			</div>
			<div class="grotetextarealabjournaallinks">
				<label for="Goal"><?php echo $lang["GOAL"];?>:</label> </br>
				<textarea class="labjournaaltext" name="Goal" value="<?php echo $result['Goal'];?>"><?php echo $result['Goal'];?></textarea>
			</div>
			<div class="grotetextarealabjournaalmidden">
				<label for="Hypothesis"><?php echo $lang["HYPOTHESIS"];?>:</label> </br>
				<textarea class="labjournaaltext" name="Hypothesis" value="<?php echo $result['Hypothesis'];?>"><?php echo $result['Hypothesis'];?></textarea>
			</div>
			<div class="grotetextarealabjournaalrechts">
				<label for="theory"><?php echo $lang["THEORY"];?>:</label> </br>
				<textarea class="labjournaaltext" name="theory" value="<?php echo $result['theory'];?>"><?php echo $result['theory'];?></textarea>
			</div>
			<div class="grotetextarealabjournaallinks">
				<label for="safety"><?php echo $lang["SAFETY"];?>:</label> </br>
				<textarea class="labjournaaltext" name="safety" value="<?php echo $result['safety'];?>"><?php echo $result['safety'];?></textarea>
			</div>
			<div class="grotetextarealabjournaalmidden">
				<label for="log"><?php echo $lang["LOG"];?>:</label> </br>
				<textarea class="labjournaaltext" name="log" value="<?php echo $result['log'];?>"><?php echo $result['log'];?></textarea>
			</div>
			<div class="grotetextarealabjournaalrechts">
				<label for="method_materials"><?php echo $lang["METHOD_MATERIALS"];?>:</label> </br>
				<textarea class="labjournaaltext" name="method_materials" value="<?php echo $result['method_materials'];?>"><?php echo $result['method_materials'];?></textarea>
			</div>
			<div class="grotetextarealabjournaallinks">
				<label for="year"><?php echo $lang["YEAR"];?>:</label> </br>
				<label for="1"><?php echo $lang["YEAR"]." 1";?></label>
					<input type="radio" name="year" value="1" <?php if($year == 1){echo 'checked';}?>>
				<label for="1"><?php echo $lang["YEAR"]." 2";?></label>
					<input type="radio" name="year" value="2"<?php if($year == 2){echo 'checked';}?>>
				<label for="1"><?php echo $lang["YEAR"]." 3";?></label>
					<input type="radio" name="year" value="3"<?php if($year == 3){echo 'checked';}?>>
			</div>
			<div class="grotetextarealabjournaalmidden">
			<a class="help"><i class="fas fa-question-circle" title="<?=$lang['ONLY'].' JPG, JPEG, PNG, GIF & csv '.$lang['ALLOWED']?>"></i></a>
				<label for="fileupload"><?php echo $lang["UPLOAD_FILE"];?>:</label></br>
				<input name='fileupload' type='file'>				
			</div>
			<div class="grotetextarealabjournaalrechts">
				<div class="selectstudent">
					<div>
						<?php echo $lang["OTHERSTUDENTS"];?>:</br>
						<input type="search" name="searchstudent" class="searchstudentbox">
						<input type="submit" name="search" class="searchstudentbutton" Value="Search"><br>
						<table id="selectphp">
							<?php
							if(!isset($_SESSION['addusers'])){
								$_SESSION['addusers'] = array();
							}
							if(isset($_POST['adduser'])){
								array_push($_SESSION['addusers'], (int)$_POST['adduser']);
								if(isset($_POST['inleveren']) || isset($_POST['opslaan'])){
									unset($_SESSION['addusers']);
									unset($_SESSION['user_id_lab']);
								}
							}
							if(isset($_POST['search']) && !empty($_POST['searchstudent'])){
								$searchfor = "%".$_POST['searchstudent']."%";
								$resultsearch = $db->selectStudentslab($searchfor);
								if(isset($resultsearch) && $resultsearch != NULL){
									echo "<tr><th>".$lang['NAME']."</th><th>".$lang['STUDENT_NUMBER']."</th><th>Toevoegen</th></tr>";
									foreach ($resultsearch as $user){
										$_SESSION['user_id_lab'] = $user['user_id'];
										echo "<tr><td>".$user['name']."</td><td>".$user['user_number']."</td><td>";
										foreach($_SESSION['addusers'] as $labuser){
											if($user['user_id'] == $labuser && $user['user_id'] != $_SESSION['creator_id']){
												echo $_SESSION['button'] = "<button class='unclickable'>".$lang['ADDED']."</button>";
											}
										}								
										if($user['user_id'] == $_SESSION['creator_id']){
											echo $_SESSION['button'] = "<button class='unclickable'>Creator</button>";
										}
										if(!isset($_SESSION['button'])){
											echo "<button name='adduser' Value=".$_SESSION['user_id_lab'].">".$lang['ADD_USER']."</button>";
										}
										elseif(isset($_SESSION['button'])){
											unset($_SESSION['button']);
										}
										echo "</td></tr>";
									} 
								} 
							}
							?>
						</table>
					</div>
					<div class="selectedusers">
							<?php
							$labusers = $db->GetAllLabUsers($_GET['id']);
							foreach($labusers as $lab){
								$labuserid = (int)$lab['user_id'];
								array_push($_SESSION['addusers'], $labuserid);
								$_SESSION['addusers'] = array_unique($_SESSION['addusers']);
							}
							foreach($_SESSION['addusers'] as $user){
								$userdata = $db->selectCurrentUsers($user);
								foreach($userdata as $userlabjournal){
									if($userlabjournal['user_id'] != $_SESSION['creator_id']){
										$username = $userlabjournal['name'];
										echo "<tr><td>".$username."&#9;<button name='deleteuser' value='".$userlabjournal['user_id']."'>".$lang['DELETE']."</button></td></tr>";
									}
								}
							}
							?>
						
						<?php
						if(isset($_POST['deleteuser'])){
							$deleteuser = $_POST['deleteuser'];
							$_SESSION['addusers'] = array_diff($_SESSION['addusers'], array($deleteuser));
							$db->DeleteExtraUser($deleteuser, $_GET['id']);
							echo "<script>window.location.href = window.location.href;</script>";
						}
						?>
					</div>
				</div> 
			</div>
		</div>
		<div class="newlabjournaalcontainer4delen">	
			<div class="bestandlabjournaaltoegevoegd">
			<?php 
				// check if its a img of excel file
				$fileSortCheck = strtolower($result["Attachment"]);
				$file = $result["Attachment"];
				// check if source is a image
				if (preg_match('/(\.jpg|\.png|\.jpeg|\.gif)$/', $fileSortCheck)) {
					echo '<img src="'.$file.'" alt="" class="bestandlabjournaaltoegevoegdwidth" srcset="">';
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
					echo $lang['FILENOTFOUND'];
				}
			?>
			</div>
		</div>
		<div class="newlabjournaalcontainer3delen">
			<div class="grotetextarealabjournaalmidden">
				<input type="submit" name="Opslaan" class="oirbuttonlabjournaal" value="<?php echo $lang["SAVE"];?>">
			</div>
			<div class="grotetextarealabjournaalmidden">
				<input type="submit" name="Inleveren" class="oirbuttonlabjournaal" value="<?php echo $lang["HAND_IN"];?>">
			</div>
			<div class="grotetextarealabjournaalmidden">
				<input type="reset" name="reset" class="oirbuttonlabjournaal" value="<?php echo $lang["RESET"];?>"> </br>
			</div>
		</div>
	</div>
	</form>
	<?php  }}
	} else {
		if ($message == "gelukt") {
			echo $lang['LABJOURNALADDED'].". <a href='labjournal'>".$lang['GOBACKOVERVIEW']."</a>";
		} else {
			echo '<a href="labjournal">'.$lang['PROBLEMOCCURRED'].'</a>';
		}
}
?>