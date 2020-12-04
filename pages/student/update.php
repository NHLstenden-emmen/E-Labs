<?php

$id = $_GET['id'];
$DBConnect = mysqli_connect("localhost", "root", "");
if ($DBConnect === FALSE)
{
  echo "<p>Unable to connect to the database
  server.</p>"
  . "<p>Error code " . mysqli_errno()
  . ": "
  . mysqli_error() . "</p>";
}
else {
  $DBName = "e-labs";
  mysqli_select_db($DBConnect, $DBName);
  
  	  $UploadedFileName=$_FILES['profpic']['name'];
	  $upload_directory = "MyUploadImages/"; //This is the folder which you created just now
	  $TargetPath=time().$UploadedFileName;
	  if(move_uploaded_file($_FILES['profpic']['tmp_name'], $upload_directory.$TargetPath)){ 
			$TableName = "users";
	
	
    $SQLstring = "UPDATE " . $TableName . " SET profile_picture = '" . $upload_directory.$TargetPath . "' WHERE user_id=" . $id;
    if ($stmt = mysqli_prepare($DBConnect, $SQLstring)) {
      $QueryResult = mysqli_stmt_execute($stmt);
    }else{
      printf("Error: %s.\n", mysqli_stmt_error($stmt));
    }
    header('Location: editprofpic');                    
	}
  
}
  ?>
