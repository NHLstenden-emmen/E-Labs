<?php
    // all passwords and secrets that are not supposed to be on github
    // change the example.env.php to .env.php
    include '.env.php';

    // get the current location / path of the page
    $pagePath = basename($_SERVER['REQUEST_URI'], '.php');    
    
    // main dependencies
    include 'inc/select.php';
    include 'inc/mysql.php';
    
    // build the website
    include 'inc/header.php';
    include 'inc/navbar.php';
    include 'pages/content.php';
    include 'inc/footer.php';
?>