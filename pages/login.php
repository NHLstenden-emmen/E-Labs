<?php
    $error = "";
    if (isset($_POST['email'])) {

        $email = $_POST['email'];
        $pass = $_POST['password'];
        $loginInfo = $db->getTheUserPasswordForLogin($email);
        while ($result = $loginInfo->fetch_array(MYSQLI_ASSOC)){
            if (password_verify($pass, $result['password'])) {
                if (!empty($_POST["remember"])) {
                    setcookie("member_login", $email);
                } else {
                    setcookie("member_login", '');
                }
                setcookie("lang", $result['lang'], time()+3600);

                // store values in session
                $_SESSION['email'] = $result['email'];
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['name'] = $result['name'];
                $_SESSION['pf_Pic'] = $result['profile_picture'];
                
                // go to the page of the users role
                if ($result['role'] == "Docent") {
                    $_SESSION['role'] = 'Docent';
                    header("Location: home");
                    die();
                } else if ($result['role'] == "Student") {
                    $_SESSION['role'] = 'Student';
                    header("Location: home");
                    die();
                } else{
                    die('er is iets fout gegaan.');
                }
            } else {
                $error = "het wachtwoord klopt niet.";
            }
        }
        if (!empty($loginInfo->fetch_array(MYSQLI_ASSOC))) {
            $error = "de gebruiker is niet gevonden.";
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
                    Engels
                </button>
            </form>
            <form method='post' id='langSwitch'>
                <button type='submit' value='en' class='en <?php if($_COOKIE['lang'] == 'en'){echo 'checked';} ?>' name='changelang'>
                    Nederlands
                </button>
            </form>
        </div>
        <form method="POST">
            <input value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" type="text" name="email" placeholder="email" required>
            <input type="password" name="password" placeholder="Wachtwoord" required>
            <div class="error"><?php echo $error; ?></div>
            <label class="check">
                <input type="checkbox" name="remember" id="remember"
                <?php if(isset($_COOKIE["member_login"])) { ?> checked
                <?php } ?> /> Onthoud e-mail
            </label><br>
            <button class="inloggen" type="submit">inloggen</button><br>
            <div class="vergeten">
                <a href="https://passwordreset.microsoftonline.com/?whr=nhlstenden.com" target=”_blank” class="vergeten-tekst">Wachtwoord vergeten?</a>
            </div>
        </form> 
    </div>
</div> 

</body>
</html>
