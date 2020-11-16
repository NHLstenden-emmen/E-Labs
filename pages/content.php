<?php
	switch($pagePath)
	{
		case 'docent':
			include 'docent/docentHome.php'; //file path of your home/start page
			break;
		case 'student':
			include 'student/studentHome.php';
			break;
		default:
			include '404.php'; // when the page isset found
	}

?>