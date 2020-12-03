<div class="background">
    <div class="loginbox">
        <div class="logo">
            <img src="images/Logo2.png" alt="logo">
        </div>
            <form method="post">
                <div class="nl-en">    
                    <a class="nl">Nederlands</a>
                    <a class="en">Engels</a>
                </div>
                <input value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" type="text" name="name" placeholder="Gebruikersnaam" required>
                <input type="password" name="password" placeholder="Wachtwoord" required>
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
    
<?php
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $pass = $_POST['password'];
        $login = $db->login($name,$pass);
        while ($result = $login->fetch_array(MYSQLI_ASSOC)){
            echo $result['name'];
            if ($result['role'] == "docent") {
                exit('hoi');
            } 
        }
        
        if (! empty($_POST["remember"])) {
        setcookie("member_login", $name);
        } else {
            setcookie("member_login", '');
        }
    }
?>

</div> 