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
			}
		}
	}
	if(isset($_POST['deletepf'])){
		if($_SESSION['pf_Pic'] != "gebruikersBestanden/profilePictures/blank-profile-picture.png"){
			unlink($_SESSION['pf_Pic']);
			$upload_directory = "gebruikersBestanden/profilePictures/blank-profile-picture.png";
			$db->updateProfielFoto($_SESSION['user_id'], $upload_directory);
			$_SESSION['pf_Pic'] = $upload_directory;
			$deletemessage="Verwijderen voltooid!";
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
						$errorPass = "current wachtwoord klopt niet";
					}
				}
			} else {
				$errorPass = "de wachtwoorden komen niet overeen";
			}
		} else {
			$errorPass = "vul op alle locaties een wachtwoord in";
		}
	}
	if(isset($_POST['update'])){
		echo 'hallo kees';
		if (!empty($_POST['naam']) && !empty($_POST['email']) && !empty($_POST['docentnummer'])) {
			$name = $_POST['naam'];
			$email = $_POST['email'];
			$user_number = $_POST['docentnummer'];

			$message = $db->docentprofielbewerken($_SESSION['user_id'], $name, $email, $user_number);
			echo $message;
		} else{
			echo "Vul alle velden in s.v.p.";
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

	<form method="POST" autocomplete="off" class="changeteacherinformation"> 
		<div class="Gebruikersprofielcontainer">
			<div id="Gebruikersprofielstudentinformatierechts">
				<label for="docentnummer"><?php echo $lang['TEACHER_NUMBER']?>:</label><br>
				<input type="text" name="docentnummer" value='<?php echo $_SESSION['user_number']?>' id="profielinformatiekleurgrijs" required><br>
				
				<label for="naam"><?php echo $lang['NAME']?>:</label><br>
				<input type="text" name="naam" value='<?php echo $_SESSION['name']?>' id="profielinformatiekleurgrijs" required><br>
			</div>
			<div id="Gebruikersprofielstudentinformatielinks">
				<label for="email"><?php echo $lang['E-MAIL']?>:</label><br>
				<input type="text" name="email" value='<?php echo $_SESSION['email']?>' id="profielinformatiekleurgrijs" required><br>
				<p> <?php echo $lang['LANGUAGE']?>: </p>
				<p id="profielinformatiekleurgrijs">  <?php 
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
		<div class=buttons>
			<input type="submit" name="update" value="update">
			<input type="reset" name="resetadd" value="Reset">
		</div>
	</form>

	<form method='post' class="changePassword">
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
		<div>
			<p><?php echo $errorPass?></p>
			<input value='update' name='wachtwoordweizigen' type='submit'>
		</div>
	</form>
</div>