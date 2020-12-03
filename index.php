<?php
    // all passwords and secrets that are not supposed to be on github
    // change the example.env.php to .env.php
    $env = include '.env.php';

    // get the current location / path of the page
    $pagePath = basename($_SERVER['REQUEST_URI'], '.php');
    
    // main dependencies
    include 'inc/select.php';
    include 'inc/mysql.php';
    $db = new Database();
    
    include 'inc/header.php';
    // build the website
    if (empty($_SESSION['role'])) {
        include 'pages/content.php';
    } else {
        include 'inc/navbar.php';
        include 'pages/content.php';
        include 'inc/footer.php';
    }
?>