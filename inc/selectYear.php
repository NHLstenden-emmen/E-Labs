<?php
	// Checks if cookie is set
	
	if(isset($_COOKIE['labYear'])) {
		if(isset($_GET['year'])) {
			setcookie("labYear", $_GET['year']);
			$year = $_GET['year'];
		} else {
			$year = $_COOKIE['labYear'];
		}
	} else {
		if(isset($_GET['year'])){
			setcookie("labYear", $_GET['year']);
			$year = $_GET['year'];
		} else {
			$year = 1;
		}
	}
?>