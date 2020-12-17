<?php
	if(isset($_POST['changepf'])){
		if(!empty($_FILES['profpic']['name'])){
			if($_SESSION['pf_Pic'] != "gebruikersBestanden/profilePictures/blank-profile-picture.png"){
				unlink($_SESSION['pf_Pic']);
			}
			$UploadedFileName=$_FILES['profpic']['name'];
			$upload_directory = "gebruikersBestanden/profilePictures/"; //This is the folder which you created just now
			$time = time();
			$TargetPath=$time.$UploadedFileName;
		
			if(move_uploaded_file($_FILES['profpic']['tmp_name'], $upload_directory.$TargetPath)){ 
				$db->updateProfielFoto($_SESSION['user_id'], $upload_directory.$TargetPath);
				$_SESSION['pf_Pic'] = $upload_directory.$TargetPath;
				echo "<script>window.location.href='gebruikersprofiel';</script>";
				exit;
			}
		}
	}
	if(isset($_POST['deletepf'])){
		if($_SESSION['pf_Pic'] != "gebruikersBestanden/profilePictures/blank-profile-picture.png"){
			unlink($_SESSION['pf_Pic']);
			$upload_directory = "gebruikersBestanden/profilePictures/blank-profile-picture.png";
			$db->updateProfielFoto($_SESSION['user_id'], $upload_directory);
			$_SESSION['pf_Pic'] = $upload_directory;
			echo "<script>window.location.href='gebruikersprofiel';</script>";
			exit;
		}
	}

	$errorPass ='';
	if(isset($_POST['wachtwoordweizigen'])){
		// a check if all passwords are filled in
		if (!empty($_POST['newWachtwoord']) && !empty($_POST['newWachtwoordHerhalen']) && !empty($_POST['huidigewachtwoord'])) {
			// check if the new password matches
			if ($_POST['newWachtwoord'] == $_POST['newWachtwoordHerhalen']) {
				// gets the current users pasword
				$loginInfo = $db->getTheUserPasswordForLogin($_SESSION['email']);
				while ($result = $loginInfo->fetch_array(MYSQLI_ASSOC)){
					// verifys the current password with the hash
					if (password_verify($_POST['huidigewachtwoord'], $result['password'])){
						// hashes the password
						$errorPass = "wachtwoord verandert";
						$options = [ 'cost' => 12, ];
						$newpass = $_POST['newWachtwoord'];
						$hash = password_hash($newpass, PASSWORD_BCRYPT, $options);
						// puts the password in the databse
						$db->updateCurrentUsersPassword($result['user_id'], $hash);
					} else {
						$errorPass = "current wacht woord klopt niet";
					}
				}
			} else {
				$errorPass = "de wachtwoorden komen niet overeen";
			}
		} else {
			$errorPass = "vul op alle locaties een wachtwoord in";
		}
	}
?>
<div class="gebruikersProfile">
	<img src=<?php echo $_SESSION['pf_Pic']?> class="profielfototje rounded-circle">
	<form method='post' enctype='multipart/form-data' class="changeprofilepicture"> 
		<input name='profpic' type='file'>
		<input value='<?php echo $lang['CHANGE_PROFILE_PHOTO']?>' name='changepf' type='submit' >
		<input value='delete' name='deletepf' type='submit'>
	</form>
	<div class="Gebruikersprofielcontainer">
		<div id="Gebruikersprofielstudentinformatierechts"> 
			<p> <?php echo $lang['STUDENT_NUMBER']?>: </p>
			<p id="profielinformatiekleurgrijs"> <?php echo $_SESSION['user_number']?></p>
			<p> <?php echo $lang["NAME"];?>: </p>
			<p id="profielinformatiekleurgrijs"> <?php echo $_SESSION['name']?></p>
		</div>
		<div id="Gebruikersprofielstudentinformatielinks"> 
			<p><?php echo $lang['E-MAIL']?>: </p>
			<p id="profielinformatiekleurgrijs">  <?php echo $_SESSION['email']?> </p>
			<p> <?php echo $lang['LANGUAGE']?>: </p>
			<p id="profielinformatiekleurgrijs">  <?php echo $_COOKIE['lang']?> </p>
		</div>
	</div>
	<form method="POST" class='changePassword'>
		<div>
			<label for="huidigewachtwoord"><?php echo $lang['CURRENT']. " " . $lang['PASSWORD']?>:</label> </br>
			<input placeholder='******' name='huidigewachtwoord' type='password'>
		</div></br>
		<div>
			<label for="newWachtwoord"><?php echo $lang['NEW']." " .$lang['PASSWORD']?>:</label> </br>
			<input placeholder='******' name='newWachtwoord' type='password'>
		</div>
		<div>
			<label for="newWachtwoordHerhalen"><?php echo $lang['REPEAT_PASSWORD']?>:</label> </br>
			<input placeholder='******' name='newWachtwoordHerhalen' type='password'>
		</div></br>
		<p><?php echo $errorPass?></p>
		<input value='update' name='wachtwoordweizigen' type='submit'>
	</form>
</div>