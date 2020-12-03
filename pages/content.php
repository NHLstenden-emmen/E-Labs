<?php
	if (!empty($_SESSION['role'])) {
		if ($_SESSION['role'] == 'Student') {
			switch(strtolower($pagePath))
			{
				case 'e-labs': //file path of your home/start page
					include 'home.php';
					break;
				case 'student':
					include 'student/studentHome.php';
					break;
				default:
					include '404.php'; // when the page isset found
			}
		} else if($_SESSION['role'] == 'Docent') {
			switch(strtolower($pagePath))
			{
				case 'e-labs': //file path of your home/start page
					include 'home.php';
					break;
				case 'docent':
					include 'docent/docentHome.php';
					break;
				default:
					include '404.php'; // when the page isset found
			}
		} else{
			include '404.php';
		}
	} else {
		include 'login.php'; // when the page isset found
	}
?>