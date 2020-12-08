<?php
	if(isset($_POST['changepf'])){
		$UploadedFileName=$_FILES['profpic']['name'];
		$upload_directory = "gebruikersBestanden/profilePictures/"; //This is the folder which you created just now
		$TargetPath=time().$UploadedFileName;
		
		if(move_uploaded_file($_FILES['profpic']['tmp_name'], $upload_directory.$TargetPath)){ 
			$TableName = "users";
			$db->updateProfielFoto($_SESSION['user_id'], $upload_directory.$TargetPath);
			$_SESSION['pf_Pic'] = $upload_directory.$TargetPath;
		}
	}
?>
<div class="gebruikersProfile">
	<img src=<?php echo $_SESSION['pf_Pic']?> class="profielfototje rounded-circle">
	<form method='post' enctype='multipart/form-data' class="changeprofilepicture"> 
		<input name='profpic' type='file'>
		<input value='<?php echo $lang['CHANGE_PROFILE_PHOTO']?>' name='changepf' type='submit'>
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
</div>