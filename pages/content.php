<?php
	switch($pagePath)
	{
		case 'E-Labs': //file path of your home/start page
		case 'E-labs':
			include 'home.php';
			break;
		case 'docent':
			include 'docent/docentHome.php';
			break;
		case 'student':
			include 'student/studentHome.php';
			break;
		default:
			include '404.php'; // when the page isset found
	}

?>