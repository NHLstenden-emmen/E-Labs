<?php
	if (empty($_SESSION['role'])) {
		include 'login.php'; 
	} else {
		$checkUsersAllowance = $db->checkUsersAllowance($_SESSION['user_id'],$_SESSION['name'],$_SESSION['email']);
		while ($result = $checkUsersAllowance->fetch_array(MYSQLI_ASSOC)){
			$_SESSION['role'] = $result['role'];
			if ($result['role'] == 'Student') {
				switch(strtolower($pagePath))
				{
					case 'e-labs': //file path of your home/start page
					case 'home':
					case '':
						include 'student/home.php';
						break;
					case 'labjournal':
						include 'student/labjournaal/labjournal.php';
						break;
					case 'editjournal':
						include 'student/labjournaal/EditJournal.php';
						break;
					case 'createnewlabjournal':
						include 'student/labjournaal/createNewLabjournal.php';
						break;
					case 'viewlabjournal':
						include 'student/labjournaal/viewLabjournal.php';
						break;

					case 'preparations':
						include 'student/preparations/preparations.php';
						break;
					case 'editpreparation':
						include 'student/preparations/EditPreparation.php';
						break;
					case 'createnewpreparation':
						include 'student/preparations/createNewPreparation.php';
						break;
					case 'viewpreparation':
						include 'student/preparations/viewPreparation.php';
						break;

					case 'userprofile':
						include 'student/userProfile.php';
						break;
					case 'searchresults':
						include 'searchResults.php';
						break;
					case 'aboutus':
						include 'aboutUs.php';
						break;
					default:
						include '404.php'; // when the page isset found
				}
			} else if($result['role'] == 'Docent') {
				switch(strtolower($pagePath))
				{
					case 'e-labs': //file path of your home/start page
					case 'home':
					case 'labjournal':
					case '':
						include 'docent/labjournaal/labjournal.php';
						break;
					case 'labjournalview':
						include 'docent/labjournaal/labjournalView.php';
						break;
					case 'preparations':
						include 'docent/preparations/preparations.php';
						break;
					case 'preparationsview':
						include 'docent/preparations/preparationsView.php';
						break;
					case 'useroverview':
						include 'docent/userOverview.php';
						break;
					case 'adduser':
						include 'docent/addUser.php';
						break;
					case 'userprofile':
						include 'docent/userProfile.php';
						break;
					case 'notificationsoverview':
						include 'docent/notifications.php';
						break;
					case 'addeditnotification':
						include 'docent/addEditNotification.php';
						break;
					case'editaccount':
						include 'docent/editAccount.php';
						break;
					case 'searchresults':
						include 'searchResults.php';
						break;
					case 'deleteaccount':
						include 'docent/deleteAccount.php';
						break;
					case 'aboutus':
						include 'aboutUs.php';
						break;
					default:
						include '404.php'; // when the page isset found
				}
			} else{
				include '404.php';
			}
		}
	}
?>