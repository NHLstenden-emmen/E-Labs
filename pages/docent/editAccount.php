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
                die(echo $lang['PASSWORDSDONTMATCH']);
            }
        }
        else{
            die(echo $lang['FILLINFIELDS']);
        }
	}
	if (!isset($message)) {
		$selectCurrentUsers = $db->selectCurrentUsers($_GET['id']);
		while ($result = $selectCurrentUsers->fetch_array(MYSQLI_ASSOC)){
		?>
		<div class="gebruikertoevoegenblock" id="InputAdd">
			<form method="POST" autocomplete="off">
				<label for="role"><?=$lang['ROLE'];?></label><br>
				<input type="radio" name="role" id="Studentrole" value="Student" checked><label for="Studentrole">Student</label>
				<input type="radio" name="role" id="Docentrole" value="Docent"><label for="Docentrole"><?=$lang['teacher'];?></label><br>

				<label for="name"><?=$lang['NAME'];?></label><br>
				<input type="text" name="name" value='<?php echo $result['name']?>' required><br>

				<label for="studentid"><?php echo $lang["STUDENT_NUMBER"];?>:</label><br>
				<input type="number" name="studentid" value='<?php echo $result['user_number']?>' required><br>
				
				<label for="email"><?php echo $lang["E-MAIL"];?>:</label><br>
				<input type="email" name="email" value='<?php echo $result['email']?>' required><br>
				
				<label for="password"><?php echo $lang["PASSWORD"];?>:</label><br>
				<input type="password" name="password" required min="8"><br>
				
				<label for="password-repeat"><?php echo $lang["REPEAT_PASSWORD"];?>:</label><br>
				<input type="password" name="passwordrepeat" required min="8"><br>
				
				<div class=buttons>
					<input type="submit" name="update" value="Update">
					<input type="reset" name="resetadd" value="Reset">
				</div>
			</form>
		</div>
<?php }
	}
?>