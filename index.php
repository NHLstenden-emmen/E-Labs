<?php
    session_start();
    // all passwords and secrets that are not supposed to be on github
    // change the example.env.php to .env.php
    $env = include '.env.php';

    // get the current location / path of the page
    $pagePath = basename($_SERVER['REQUEST_URI'], '.php');
    if (strpos($pagePath, '?') !== false) {   
        $pagePath = substr($pagePath, 0, strpos($pagePath, "?")); 
    }
    // if($pagePath != "createNewLabjournaal"){
    //     if (isset($_SESSION['addusers'])){
    //         unset($_SESSION['addusers']);
    //         unset($_SESSION['title']);
    //         unset($_SESSION['theory']);
    //         unset($_SESSION['safety']);
    //         unset($_SESSION['logboek']);
    //         unset($_SESSION['method_materials']);
    //         unset($_SESSION['year']); 
    //         unset($_SESSION['Goal']); 
    //         unset($_SESSION['Hypothesis']); 
    //     }
    // }

    if (strtolower($pagePath) == 'pdf'){
        if(isset($_GET['labjournaal_id'])){
            $id = 'labjournaal_id='.$_GET['labjournaal_id'];
        }
        elseif(isset($_GET['preperation_id'])){
            $id = 'preperation_id='.$_GET['preperation_id'];
        }
        header('location: FPDF/printpdf.php?'.$id);
    } else{
        // main dependencies
        include 'inc/mysql.php';
        $db = new Database();
        include 'inc/select.php';
        include 'inc/header.php';
        include 'inc/selectYear.php';
        
        // build the website
        if (empty($_SESSION['role'])) {
            include 'pages/content.php';
        } else {
            include 'inc/navbar.php';
            include 'pages/content.php';
            include 'inc/footer.php';
        }
    }
?>