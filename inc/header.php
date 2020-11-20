<!DOCTYPE html>
<html lang="nl">
    <head>
		<!-- meta tags -->
		<meta charset="UTF-8">
		<meta name="description" content="Free Web tutorials">
		<meta name="keywords" content="E-Labs">
		<meta name="author" content="Kevin Smulders">
		<meta name="author" content="Mike">
		<meta name="author" content="Esmee">
		<meta name="author" content="Coen">
		<meta name="author" content="Lucas">
		<meta name="author" content="Tamara">
		<meta name="author" content="Niels">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>E-Labs <?php if ($pagePath !== "E-Labs") { echo " - " . $pagePath; } ?></title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<!-- Font Awesome CDN -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
		
		<!-- style sheet -->
		<?php
		switch($pagePath)
		{
			case 'E-Labs':
				echo '<link rel="stylesheet" href="css/pages/home.css">';
				break;
			default:
				echo '<link rel="stylesheet" href="css/pages/404.css">';
				break;
		}
		
		?>
    </head>
	<body>