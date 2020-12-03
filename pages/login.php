
<div class="loginPagina background">
    <div class="loginbox">
        <div class="logo">
            <img src="images/Logo2.png" alt="logo">
        </div>
        <form method="POST">
            <div class="nl-en">
                <a class="nl <?php if($_COOKIE['lang'] == 'nl' || empty($_COOKIE['lang'])){echo 'checked';} ?>">Nederlands</a>
                <a class="en <?php if($_COOKIE['lang'] == 'en'){echo 'checked';} ?>">Engels</a>
            </div>
            <input value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" type="text" name="name" placeholder="Gebruikersnaam" required>
            <input type="password" name="password" placeholder="Wachtwoord" required>
            <div class="error">bericht voor een error ofzo </div>
            <label class="check">
                <input type="checkbox" name="remember" id="remember"
                <?php if(isset($_COOKIE["member_login"])) { ?> checked
                <?php } ?> /> Onthoud Gebruikersnaam
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
<?php
    if (isset($_POST['name']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $pass = $_POST['password'];
        $login = $db->login($name,$pass);
        if (! empty($_POST["remember"])) {
            setcookie("member_login", $name);
        } else {
            setcookie("member_login", '');
        }
        while ($result = $login->fetch_array(MYSQLI_ASSOC)){
            // store the users prefrensed lang in a kookiee
                setcookie("lang", $result['lang'], time()+3600);

            // store values in session
            $_SESSION['name'] = $result['name'];
            $_SESSION['user_id'] = $result['user_id'];

            // go to the page of the users role
            if ($result['role'] == "Docent") {
                $_SESSION['role'] = 'Docent';
                header("Location: docent");
                die();
            } else if ($result['role'] == "Student") {
                $_SESSION['role'] = 'Student';
                header("Location: student");
                die();
            }
        } 
    }
?>