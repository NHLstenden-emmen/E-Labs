<div class="background">
    <div class="loginbox">
        <div class="logo">
            <img src="images/Logo2.png" alt="logo">
        </div>
            <form method="post">
                <button class="nl" type="">Nederlands</button>
                <button class="en" type="">Engels</button>
                <input type="text" name="name" placeholder="Enter Username" required>
                <input type="password" name="password" placeholder="Enter Password" required>
                <label class="check">
                    <input type="checkbox" checked="checked" name="remember"> Onthoud Gebruikersnaam
                </label><br>
                <button class="inloggen" type="submit">inloggen</button><br>
                <div class="vergeten">
                    <a href="#">Wachtwoord vergeten?</a>
                </div>
            </form> 
    </div>
    
<?php
    $name = $_POST['name'];
    $pass = $_POST['password'];
    $login = $db->login($name,$pass);
    while ($result = $login->fetch_array(MYSQLI_ASSOC)){
        echo $result['name'];
        if ($result['role'] == "docent") {
            exit('hoi');
        }
    }
?>

</div> 