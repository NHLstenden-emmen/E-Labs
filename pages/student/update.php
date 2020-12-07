<?php
	$id = $_GET['id'];
	
	$UploadedFileName=$_FILES['profpic']['name'];
	$upload_directory = "gebruikersBestanden/profilePictures/"; //This is the folder which you created just now
	$TargetPath=time().$UploadedFileName;
	if(move_uploaded_file($_FILES['profpic']['tmp_name'], $upload_directory.$TargetPath)){ 
		$TableName = "users";
		$db->updateProfielFoto($id, $upload_directory.$TargetPath);
		$_SESSION['pf_Pic'] = $upload_directory.$TargetPath;
		header('Location: editprofpic');                    
	}
?>