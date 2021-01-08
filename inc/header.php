<!DOCTYPE html>
<html lang="nl">
    <head>
		<!-- start favicon -->
		<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
		<link rel="manifest" href="images/favicon/site.webmanifest">
		<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#005aa7">
		<meta name="apple-mobile-web-app-title" content="E-Labs">
		<meta name="application-name" content="E-Labs">
		<meta name="msapplication-TileColor" content="#005aa7">
		<meta name="theme-color" content="#ffffff">

		<!-- meta tags -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="description" content="Free Web tutorials">
		<meta name="keywords" content="E-labs">
		<meta name="author" content="Kevin Smulders">
		<meta name="author" content="Mike">
		<meta name="author" content="Esmee">
		<meta name="author" content="Coen">
		<meta name="author" content="Lucas">
		<meta name="author" content="Tamara">
		<meta name="author" content="Niels">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>E-Labs <?php if (strtolower($pagePath) !== "e-labs") { echo " - " . $pagePath; } ?></title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<!-- Font Awesome CDN -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

		<!-- style sheet -->
		<link rel="stylesheet" href="css/main/main.css">
		<link rel="stylesheet" href="css/main/navbar.css">
		<link rel="stylesheet" href="css/main/footer.css">
		<?php
		if (empty($_SESSION['role'])) {
			echo '<link rel="stylesheet" href="css/pages/login.css">';
		} else {
			if ($_SESSION['role'] == 'Student') {
				switch(strtolower($pagePath))
				{
					case 'e-labs'://file path of your home/start page
					case 'home':
					case '':
						echo '<link rel="stylesheet" href="css/pages/studentHome.css">';
						break;
					case 'labjournaal':
						echo '<link rel="stylesheet" href="css/pages/studentLabjournaal.css">';
						break;
					case 'gebruikersprofiel':
						echo '<link rel="stylesheet" href="css/pages/gebruikersprofiel.css">';
						break;
					case 'gebruikertoevoegen':
						echo '<link rel="stylesheet" href="css/pages/gebruikerToevoegen.css">';
						break;
					case 'searchresults':
						echo '<link rel="stylesheet" href="css/pages/searchResults.css">';
						break;
					case 'editjournaal':
					case 'viewlabjournaal':
					case 'createnewlabjournaal'://file path of nieuwlabjournaal
						echo '<link rel="stylesheet" href="css/pages/nieuwlabjournaal.css">';
						break;
					case 'aboutus':
						echo '<link rel="stylesheet" href="css/pages/aboutus.css">';
						break;
					default:
						echo '<link rel="stylesheet" href="css/pages/404.css">';
						break;
				}
			} else if($_SESSION['role'] == 'Docent') {
				switch(strtolower($pagePath))
				{
					case 'e-labs'://file path of your home/start page
					case 'home':
					case 'labjournaal':
					case '':
						echo '<link rel="stylesheet" href="css/pages/docentenHome.css">';
						break;
					case 'year':
						echo '<link rel="stylesheet" href="css/pages/docentenHome.css">';
						break;
					case 'gebruikersprofiel':
						echo '<link rel="stylesheet" href="css/pages/gebruikersprofiel.css">';
						break;
					case 'searchresults':
						echo '<link rel="stylesheet" href="css/pages/searchResults.css">';
						break;
					case 'gebruikertoevoegen':
						echo '<link rel="stylesheet" href="css/pages/gebruikerToevoegen.css">';
						break;
					case 'gebruikersoverzicht':
						echo '<link rel="stylesheet" href="css/pages/gebruikersoverzichtd.css">';
					break;
					case 'labjournaalview':
						echo '<link rel="stylesheet" href="css/pages/labjournaalview.css">';
						break;
					case 'aboutus':
						echo '<link rel="stylesheet" href="css/pages/aboutus.css">';
						break;
					default:
						echo '<link rel="stylesheet" href="css/pages/404.css">';
						break;

				}
			} else{
				echo '<link rel="stylesheet" href="css/pages/404.css">';
			}
		}
		?> 
    </head>
	<body>
