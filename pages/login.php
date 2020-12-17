<?php
    $error = "";
    if (isset($_POST['email']) && isset($_POST['password'])) {

        $email = $_POST['email'];
        $pass = $_POST['password'];
        $loginInfo = $db->getTheUserPasswordForLogin($email);
        if ($loginInfo->num_rows === 0) { 
            $error = "de gebruiker is niet gevonden.";
        }
        while ($result = $loginInfo->fetch_array(MYSQLI_ASSOC)){
            // this is a check if the password is correct
            if (password_verify($pass, $result['password'])) {
                // this is a checkbox check for the remember me check 
                if (!empty($_POST["remember"])) {
                    setcookie("member_login", $email);
                } else {
                    setcookie("member_login", '');
                }
                // this changes the cookie lang to the users database prefred lang
                setcookie("lang", $result['lang'], time()+3600);

                // store values in session
                $_SESSION['email'] = $result['email'];
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['name'] = $result['name'];
                $_SESSION['pf_Pic'] = $result['profile_picture'];
                $_SESSION['user_number'] = $result['user_number'];
                
                // go to the page of the users role
                if ($result['role'] == "Docent") {
                    $_SESSION['role'] = 'Docent';
                    // server fix for the relocation problem
                    echo "<script>window.location.href='home';</script>";
                    exit;
                } else if ($result['role'] == "Student") {
                    $_SESSION['role'] = 'Student';
                    // server fix for the relocation problem
                    echo "<script>window.location.href='home';</script>";
                    exit;
                } else{
                    die('er is iets fout gegaan.');
                }
            } else {
                $error = "het wachtwoord klopt niet.";
            }
        }
    }
?>

<div class="loginPagina background">
    <div class="loginbox">
        <div class="logo">
            <img src="images/Logo2.png" alt="logo">
        </div>
        <div class="nl-en">
            <form method='post' id='langSwitch'>
                <button type='submit' value='nl' class='nl <?php if($_COOKIE['lang'] == 'nl' || empty($_COOKIE['lang'])){echo 'checked';} ?>' name='changelang'>
                    Nederlands
                </button>
            </form>
            <form method='post' id='langSwitch'>
                <button type='submit' value='en' class='en <?php if($_COOKIE['lang'] == 'en'){echo 'checked';} ?>' name='changelang'>
                    Engels
                </button>
            </form>
        </div>
        <form method="POST">
            <input value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" type="text" name="email" placeholder="<?php echo $lang["E-MAIL"];?>" required>
            <input type="password" name="password" placeholder="<?php echo $lang["PASSWORD"];?>" required>
            <div class="error"><?php echo $error; ?></div>
            <label class="check">
                <input type="checkbox" name="remember" id="remember"
                <?php if(isset($_COOKIE["member_login"])) { ?> checked 
                <?php } ?> /><?php echo $lang["REMEMBER_EMAIL"];?>
            </label><br>
            <button class="inloggen" type="submit"><?php echo $lang["LOGIN"];?></button><br>
            <div class="vergeten">
                <a href="https://passwordreset.microsoftonline.com/?whr=nhlstenden.com" target=”_blank” class="vergeten-tekst"><?php echo $lang["FORGOT_YOUR_PASSWORD"];?> </a>
            </div>
        </form> 
    </div>
</div> 

</body>
</html>
