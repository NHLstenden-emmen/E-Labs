<?php
	switch(strtolower($pagePath))
	{
		case 'e-labs': //file path of your home/start page
			include 'home.php';
			break;
		case 'docent':
			include 'docent/docentHome.php';
			break;
		case 'student':
			include 'student/studentHome.php';
			break;
		case 'editprofpic':
			include 'Editprofpic.php';
			break;
		case 'update':
			include 'update.php';
			break;
		default:
			include '404.php'; // when the page isset found
	}

?>