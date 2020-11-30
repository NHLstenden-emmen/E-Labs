<?php
    session_start();
    
    $c = mysqli_connect('localhost','root','');
    
    mysqli_select_db($c, 'e-labs');
    
    $name = $_POST['name'];
    $pass = $_POST['password'];
    
    $s = " select * from users where name = '$name' && password = '$pass'";
    
    $result = mysqli_query($c, $s);
    
    $num = mysqli_num_rows($result);
    
    if($num == 1){
        header('location:testhome.php');
    }else{
        header('location:login.php');
    }
?>

