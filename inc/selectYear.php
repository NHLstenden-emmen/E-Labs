<?php
	// Checks if cookie is set
	if(isset($_COOKIE['labYear'])) {
		if(isset($_GET['year'])) {
			setcookie("labYear", $_GET['year']);
			$year = $_COOKIE['labYear'];
		} else {
			$year = $_COOKIE['labYear'];
		}
	} else {
		if(isset($_GET['year'])){
			setcookie("labYear", $_GET['year']);
			$year = $_COOKIE['labYear'];
		} else {
			$year = 1;
		}
	}
?>