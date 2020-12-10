<?php
	if (empty($_SESSION['role'])) {
		include 'login.php'; 
	} else {
		if ($_SESSION['role'] == 'Student' && isset($_SESSION['name']) && isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
			switch(strtolower($pagePath))
			{
				case 'e-labs': //file path of your home/start page
				case 'home':
				case '':
					include 'student/home.php';
					break;
				case 'labjournaal':
					include 'student/studentLabjournaal.php';
					break;
				case 'editjournaal':
					include 'student/EditJournaal.php';
					break;
				case 'createnewlabjournaal':
					include 'student/createNewLabjournaal.php';
					break;
				case 'updatelabjournaal':
					include 'student/updatelabjournaal.php';
					break;
				case 'exel':
					include 'student/EXEL.php';
					break;
				case 'gebruikersprofiel':
					include 'student/gebruikersprofiel.php';
					break;
				default:
					include '404.php'; // when the page isset found
			}
		} else if($_SESSION['role'] == 'Docent' && isset($_SESSION['name']) && isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
			switch(strtolower($pagePath))
			{
				case 'e-labs': //file path of your home/start page
				case 'home':
				case '':
					include 'docent/year.php';
					break;
				case 'gebruikersoverzicht':
					include 'docent/gebruikersoverzicht.php';
					break;
				case 'gebruikertoevoegen':
					include 'docent/gebruikerToevoegen.php';
					break;
				case 'gebruikersprofiel':
					include 'docent/gebruikersprofiel.php';
					break;
				case 'labjournaalview':
					include 'docent/labjournaalView.php';
					break;
				case 'gebruikersprofielstudent':
					include 'docent/gebruikersprofielstudentbewerken.php';
					break;
				default:
					include '404.php'; // when the page isset found
			}
		} else{
			include '404.php';
		}
	}
?>