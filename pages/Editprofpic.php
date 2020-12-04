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
		$TableName = "users";
		$SQLstring = "SELECT * FROM " . $TableName . " WHERE user_id= ?" ;
		if ($stmt = mysqli_prepare($DBConnect, $SQLstring)) {
			mysqli_stmt_bind_param($stmt, 's', $id);
		$QueryResult = mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $id, $name, $email, $usernumber, $password, $profilepic, $lang, $role);
		while (mysqli_stmt_fetch($stmt)) {

			?>
			<h2>Edit Profilepic</h2>
			<form method="POST" action="update?id=<?php echo $id; ?>">
			<p>profilepic </p><p><?php echo $profilepic; ?>
			</td><td><input name="UploadImages" input type="file"  /><br></td>
			<p><input type="submit" value="Update" /></p>
			</form>
			<?php

		}

		}else{
			printf("Error: %s.\n", mysqli_stmt_error($stmt));
		}
	}
?>
