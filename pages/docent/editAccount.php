<?php
    if(isset($_POST['update'])){
		$userID = $_GET['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $usernumber = $_POST['studentid'];
        $password = $_POST['password'];
		$passwordr = $_POST['passwordrepeat'];
        if(!empty($name) && !empty($usernumber) && !empty($email) && !empty($password) && !empty($passwordr)){
            if($password === $passwordr){
                $options = [ 'cost' => 12, ];
                $hashPass = password_hash($password, PASSWORD_BCRYPT, $options);
                $message = $db->teacherStudentEditProfile($userID, $name, $email, $usernumber, $hashPass, $role);
                echo $message;
            }
            else{
                exit($lang['PASSWORDSDONTMATCH']);
            }
        }
        else{
            exit($lang['FILLINFIELDS']);
        }
	}
	if (!isset($message)) {
		$selectCurrentUsers = $db->selectCurrentUsers($_GET['id']);
		while ($result = $selectCurrentUsers->fetch_array(MYSQLI_ASSOC)){
		?>
		<div class="addUserContainer">
			<form method="POST" autocomplete="off">
				<label for="role"><?=$lang['ROLE'];?></label><br>
				<input type="radio" name="role" id="Studentrole" value="Student" checked><label for="Studentrole">Student</label>
				<input type="radio" name="role" id="Docentrole" class="radioButtonRol" value="Docent"><label for="Docentrole"><?=$lang['TEACHER'];?></label><br>

				<label for="name"><?=$lang['NAME'];?></label><br>
				<input type="text" name="name" value='<?php echo $result['name']?>' required class="textInputGebruiker"><br>

				<label for="studentid"><?php echo $lang["STUDENT_NUMBER"];?>:</label><br>
				<input type="number" name="studentid" value='<?php echo $result['user_number']?>' required class="textInputGebruiker"><br>
				
				<label for="email"><?php echo $lang["E-MAIL"];?>:</label><br>
				<input type="email" name="email" value='<?php echo $result['email']?>' required class="textInputGebruiker"><br>
				
				<label for="password"><?php echo $lang["PASSWORD"];?>:</label><br>
				<input type="password" name="password" required min="8" class="textInputGebruiker"><br>
				
				<label for="password-repeat"><?php echo $lang["REPEAT_PASSWORD"];?>:</label><br>
				<input type="password" name="passwordrepeat" required min="8" class="textInputGebruiker"><br>
				
				<div class="formButtonsGebruiker">
					<input type="submit" name="update" value="Update">
					<input type="reset" name="resetadd" value="Reset">
				</div>
			</form>
		</div>
<?php }
	}
?>