<?php
	if(isset($_POST['changepf'])){
		if(!empty($_FILES['profpic']['name'])){
			$f_type = $_FILES['profpic']['type'];
			if ($f_type== "image/gif" OR $f_type== "image/png" OR $f_type== "image/jpeg" OR $f_type== "image/JPEG" OR $f_type== "image/PNG" OR $f_type== "image/GIF"){
				if($_FILES['profpic']['size'] <= 1500000){
					if($_SESSION['pf_Pic'] != "gebruikersBestanden/profilePictures/blank-profile-picture.png"){
						unlink($_SESSION['pf_Pic']);
					}
					$UploadedFileName = str_replace(" ","_", $_FILES['profpic']['name']);
					$upload_directory = "gebruikersBestanden/profilePictures/"; //This is the folder which you created just now
					$time = time();
					$TargetPath=$time.$UploadedFileName;
				
					if(move_uploaded_file($_FILES['profpic']['tmp_name'], $upload_directory.$TargetPath)){ 
						$db->updateProfilePicture($_SESSION['user_id'], $upload_directory.$TargetPath);
						$_SESSION['pf_Pic'] = $upload_directory.$TargetPath;
						echo "<script>window.location.href='gebruikersprofiel';</script>";
						exit;
					}
				}
				else{
					$message = $lang['BIG_FILE'];
				}
			}
			else{
				$message = $lang['WRONG_FILE'];
			}
		}
	}
	if(isset($_POST['deletepf'])){
		if($_SESSION['pf_Pic'] != "gebruikersBestanden/profilePictures/blank-profile-picture.png"){
			unlink($_SESSION['pf_Pic']);
			$upload_directory = "gebruikersBestanden/profilePictures/blank-profile-picture.png";
			$db->updateProfilePicture($_SESSION['user_id'], $upload_directory);
			$_SESSION['pf_Pic'] = $upload_directory;
			echo "<script>window.location.href='gebruikersprofiel';</script>";
			exit;
		}
	}

	$errorPass ='';
	if(isset($_POST['wachtwoordwijzigen'])){
		// a check if all passwords are filled in
		if (!empty($_POST['newPassword']) && !empty($_POST['newPasswordRepeat']) && !empty($_POST['currentPassword'])) {
			// check if the new password matches
			if ($_POST['newPassword'] == $_POST['newPasswordRepeat']) {
				// gets the current users pasword
				$loginInfo = $db->getTheUserPasswordForLogin($_SESSION['email']);
				while ($result = $loginInfo->fetch_array(MYSQLI_ASSOC)){
					// verifys the current password with the hash
					if (password_verify($_POST['currentPassword'], $result['password'])){
						// hashes the password
						$errorPass = $lang['CHANGEDPASSWORD'];
						$options = [ 'cost' => 12, ];
						$newpass = $_POST['newPassword'];
						$hash = password_hash($newpass, PASSWORD_BCRYPT, $options);
						// puts the password in the databse
						$db->updateCurrentUsersPassword($result['user_id'], $hash);
					} else {
						$errorPass = $lang['CURRENTPASSNOTCORRECT'];
					}
				}
			} else {
				$errorPass = $lang['PASSWORDSDONTMATCH'];
			}
		} else {
			$errorPass = $lang['FILLINFIELDS'];
		}
	}
	if(isset($_POST['update'])){
		if (!empty($_POST['naam']) && !empty($_POST['email']) && !empty($_POST['docentnummer'])) {
			$name = $_POST['naam'];
			$email = $_POST['email'];
			$user_number = $_POST['docentnummer'];
			$userID = $_SESSION['user_id'];

			$message = $db->docentProfileEdit($userID, $name, $email, $user_number);
			echo $message;
		if($message != NULL){
			$_SESSION['name'] = $name;
			$_SESSION['email'] = $email;
			$_SESSION['user_number'] = $user_number;
		}
		} else{
			echo $lang['FILLINFIELDS'];
		}
	}
?>

<div class="gebruikersProfile">
	<img src=<?php echo $_SESSION['pf_Pic']?> class="profielfototje rounded-circle"></br>
	<form method='post' enctype='multipart/form-data' class="changeprofilepicture"> 
	<?php if(isset($message)){echo "<h4><b>".$message."</b></h4>";}?>
		<div>
			<input name='profpic' type='file'>
		</div>
		</br>
		<input value='<?php echo $lang['CHANGE_PROFILE_PHOTO']?>' name='changepf' type='submit' id="ButtonProfielBlauw">
		<input value='<?=$lang['DELETE'];?>' name='deletepf' type='submit'id="ButtonProfielBlauw">
	</form>

	<form method="POST" autocomplete="off" class="changeteacherinformation"> 
		<div class="Gebruikersprofielvakken">
			<div id="Gebruikersprofieldocentinformatie">
				<label for="docentnummer"><?php echo $lang['TEACHER_NUMBER']?>:</label></br>
				<input type="text" name="docentnummer" value='<?php echo $_SESSION['user_number']?>' id="TextInputProfiel" required></br></br>
				<label for="naam"><?php echo $lang['NAME']?>:</label></br>
				<input type="text" name="naam" value='<?php echo $_SESSION['name']?>' id="TextInputProfiel" required></br></br>
				<label for="email"><?php echo $lang['E-MAIL']?>:</label></br>
				<input type="text" name="email" value='<?php echo $_SESSION['email']?>' id="TextInputProfiel" required></br></br>
				<p> <?php echo $lang['LANGUAGE']?>: </p>
				<p>  <?php 
				// check if there is a cookie for lang set
				if(!isset($_COOKIE['lang'])){
					echo "<button type='submit' id='profileLangSwitch' value='en' class='languageSwitch' name='changelang'>EN</button>";
					// change the button to a dutch button cause the lang is set to english
				} else if($_COOKIE['lang'] == 'en'){
					echo "<button type='submit' id='profileLangSwitch' value='nl' class='languageSwitch' name='changelang'>NL</button>";
					// change the button to a english button cause the lang is set to dutch
				} else if($_COOKIE['lang'] == 'nl'){
					echo "<button type='submit' id='profileLangSwitch' value='en' class='languageSwitch' name='changelang'>EN</button>";
				}
				?></p>
			</div>
		</div>
		<div class=profileEditButtons>
			<input type="submit" name="update" value="Update" id="ButtonProfielBlauw">
			<input type="reset" name="resetadd" value="Reset" id="ButtonProfielBlauw">
		</div>
	</form>

	<div class="Gebruikersprofielvakken2">
		<div class="Gebruikersprofielvakkenspan">
	<form method='post'>
		<div>
			<label for="huidigewachtwoord"><?php echo $lang['CURRENT']. " " . $lang['PASSWORD']?>:</label> </br>
			<input placeholder='******' name='huidigewachtwoord' type='password' id="TextInputProfiel">
		</div></br>
		<div>
			<label for="newWachtwoord"><?php echo $lang['NEW']." " .$lang['PASSWORD']?>:</label> </br>
			<input placeholder='******' name='newWachtwoord' type='password' id="TextInputProfiel">
		</div></br>
		<div>
			<label for="newWachtwoordHerhalen"><?php echo $lang['REPEAT_PASSWORD']?>:</label> </br>
			<input placeholder='******' name='newWachtwoordHerhalen' type='password' id="TextInputProfiel">
		</div>
		</div>
		</div>
		<div class=profileEditButtons>
			<p><?php echo $errorPass?></p>
			<input value='Update' name='wachtwoordwijzigen' type='submit' id="ButtonProfielBlauw">
		</div>
	</form>
</div>