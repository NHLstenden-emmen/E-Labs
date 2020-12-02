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
		case 'labjournaal':
		case 'labjournaal?year=1':
		case 'labjournaal?year=2':
		case 'labjournaal?year=3':
			include 'student/studentLabjournaal.php';
			break;
		default:
			include '404.php'; // when the page isset found
	}

?>