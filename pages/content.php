<?php
	if (empty($_SESSION['role'])) {
		include 'login.php'; 
	} else {
		if ($_SESSION['role'] == 'Student') {
			switch(strtolower($pagePath))
			{
				case 'e-labs': //file path of your home/start page
				case 'home':
					include 'student/studentHome.php';
					break;
				case 'labjournaal':
					include 'student/studentLabjournaal.php';
					break;
				case 'gebruikersprofiel':
					include 'student/StudentGebruikersprofiel.php';
					break;
				default:
					include '404.php'; // when the page isset found
			}
		} else if($_SESSION['role'] == 'Docent') {
			switch(strtolower($pagePath))
			{
				case 'e-labs': //file path of your home/start page
				case 'home':
					include 'docent/docentHome.php';
					break;
				case 'gebruikertoevoegen':
					include 'docent/gebruikerToevoegen.php';
					break;
				default:
					include '404.php'; // when the page isset found
			}
		} else{
			include '404.php';
		}
	}
?>