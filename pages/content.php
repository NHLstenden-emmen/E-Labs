<?php
	if (empty($_SESSION['role'])) {
		include 'login.php'; 
	} else {
		if ($_SESSION['role'] == 'Student') {
			switch(strtolower($pagePath))
			{
				case 'e-labs': //file path of your home/start page
				case 'home':
					include 'student/home.php';
					break;
				case 'labjournaal':
					include 'student/studentLabjournaal.php';
					break;
				case 'createnewlabjournaal':
					include 'student/createNewLabjournaal.php';
					break;
				case 'editprofpic':
					include 'student/editProfpic.php';
					break;
				case 'exel':
					include 'student/EXEL.php';
					break;
				case 'gebruikersprofiel':
					include 'student/gebruikersprofiel.php';
					break;	
				case 'update':
					include 'student/update.php';
					break;
				case 'searchresults':
					include 'searchResults.php';
					break;
				default:
					include '404.php'; // when the page isset found
			}
		} else if($_SESSION['role'] == 'Docent') {
			switch(strtolower($pagePath))
			{
				case 'e-labs': //file path of your home/start page
				case 'home':
				case 'year':
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
				case 'searchresults':
					include 'searchResults.php';
					break;
				default:
					include '404.php'; // when the page isset found
			}
		} else{
			include '404.php';
		}
	}
?>