<div class="gebruikertoevoegenblock" id="InputAdd">
    <form action="gebruikertoevoegen" method="POST" autocomplete="off">
        <label for="role">Rol:</label><br>
        <input type="radio" name="role" id="Studentrole" value="Student" checked><label for="Studentrole">Student</label>
        <input type="radio" name="role" id="Docentrole" value="Docent"><label for="Docentrole">Docent</label><br>
        <label for="name">Volledige naam:</label><br>
        <input type="text" name="name" required><br>
        <label for="studentid"><?php echo $lang["STUDENT_NUMBER"];?>:</label><br>
        <input type="number" name="studentid" required><br>
        <label for="email"><?php echo $lang["E-MAIL"];?>:</label><br>
        <input type="email" name="email" required><br>
        <label for="password"><?php echo $lang["PASSWORD"];?>:</label><br>
        <input type="password" name="password" required min="8"><br>
        <label for="password-repeat"><?php echo $lang["REPEAT_PASSWORD"];?>:</label><br>
        <input type="password" name="passwordrepeat" required min="8"><br>
        <div class=buttons>
            <input type="submit" name="submitadd" value="Toevoegen">
            <input type="reset" name="resetadd" value="Reset">
        </div>
    </form>
</div>

<?php
if(isset($_POST['submitadd'])){
    $role = $_POST['role'];
    $name = $_POST['name'];
    $studentid = $_POST['studentid'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordr = $_POST['passwordrepeat'];
    if(!empty($name) && !empty($studentid) && !empty($email) && !empty($password) && !empty($passwordr)){
        if($password === $passwordr){
            $options = [ 'cost' => 12, ];
            $newpass = $password;
            $password = password_hash($newpass, PASSWORD_BCRYPT, $options);
            $message = $db->createNewUserWithoutProfielPictureAndLang($name, $email, $studentid, $password, $role);
            echo $message;
        }
        else{
            die("Wachtwoorden komen niet overeen");
        }
    }
    else{
        die("Vul alle velden in s.v.p.");
    }
    }
?>
 
