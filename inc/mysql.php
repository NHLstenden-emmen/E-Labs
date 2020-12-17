<?php
	if (empty($env['DB_HOST'])) {
		die("no .env.php file found or database host");
	}

	class Database{
		private $host;
		private $user;
		private $pass;
		private $db;
		private $conn;
	
		public function __construct() {
			// include the env file pagina
			$pagePath = basename($_SERVER['REQUEST_URI'], '.php');
			if (strpos($pagePath, '?') !== false) {   
				$pagePath = substr($pagePath, 0, strpos($pagePath, "?")); 
			}
			if($pagePath == 'printpdf.php'){
					$env = include '../.env.php';
				}
			else{
				$env = include '.env.php';
			}
			$this->host = $env['DB_HOST'];
			$this->user = $env['DB_USERNAME'];
			$this->pass = $env['DB_PASSWORD'];
			$this->table = $env['DB_TABLE'];
			$this->db_connect();
		}
	
		private function db_connect(){
			$this->conn = @mysqli_connect($this->host,$this->user,$this->pass, $this->table);
            if(!$this->conn)
            {
                DIE("could not connect". mysqli_connect_error($this->conn));
            }
		}

		public function selectAllUsers(){
			// this gets all the users and returns them
			if ($stmt = $this->conn->prepare("SELECT `user_id`, `name`, `email`, `user_number`, `profile_picture`, `lang`, `role` FROM `users`")) {
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
		public function selectStudents(){
			// this gets all students and returns them
			if ($stmt = $this->conn->prepare("SELECT `user_id`, `name`, `email`, `user_number`, `profile_picture`, `lang`, `role` FROM `users` WHERE `role` = 'Student'")) {
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function checkUsersAllowance($userId, $userName, $userEmail){
			if($stmt = $this->conn->prepare("SELECT `role` FROM `users` WHERE `user_id` = ? AND `name` = ? AND `email` = ? ")){
					$stmt->bind_param("sss", $userId, $userName, $userEmail);
					$stmt->execute();
					$result = $stmt->get_result();
					$stmt->free_result();
					$stmt->close();
					return $result;
				}
		}

		public function selectCurrentUsers($userID){
			if ($stmt = $this->conn->prepare("SELECT `user_id`, `name`, `email`, `user_number`, `profile_picture`, `lang`, `role` FROM `users` WHERE `user_id` = ?")) {
				$stmt->bind_param("i", $userID);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
		
		public function createNewUserWithoutProfielPictureAndLang($name, $email, $user_number, $password, $role){
			
			$name = htmlspecialchars($name);
			$email = htmlspecialchars($email);
			$user_number = htmlspecialchars($user_number);
			$password = htmlspecialchars($password);
			$role = htmlspecialchars($role);
			// this query gets all the users form the table
			if ($stmt = $this->conn->prepare("SELECT `email`, `user_number` FROM `users`")) {
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
			}
			// this loops trough all the users and checks if it is a unique value
			while ($checkIfUserIsUnique = $result->fetch_array(MYSQLI_ASSOC)) {
				//this checks if the users email matches the new email
				if ($checkIfUserIsUnique['email'] == $email) {
					return "Email in use.";
				}
				//this checks if the users number matches the new number
				if ($checkIfUserIsUnique['user_number'] == $user_number) {
					return "User number in use.";
				}
			}
			// it adds the users to the database and returns a message.
			$emptyProfilePic = 'gebruikersBestanden/profilePictures/blank-profile-picture.png';
			if ($stmt = $this->conn->prepare("INSERT INTO `users`(`name`, `email`, `user_number`, `password`, `role`,`profile_picture`) VALUES (?,?,?,?,?,?)")) {
				$stmt->bind_param("ssisss", $name, $email, $user_number, $password, $role, $emptyProfilePic);
				$stmt->execute();
				$stmt->close();
				return "User Added";
			}
			return NULL;
		}

		public function getTheUserPasswordForLogin($email){
			if ($stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?")) {
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
    
		public function addNewNotification($creater, $viewer, $title, $message, $date_time){
			
			$creater = htmlspecialchars($creater);
			$viewer = htmlspecialchars($viewer);
			$title = htmlspecialchars($title);
			$message = htmlspecialchars($message);
			$date_time = htmlspecialchars($date_time);

			if ($viewer == '0') {
				if ($stmt = $this->conn->prepare("INSERT INTO `notifications`( `creater`, `title`, `message`, `date_time`) VALUES (?,?,?,?)")) {
					$stmt->bind_param("isss", $creater, $title, $message, $date_time);
					$stmt->execute();
					$stmt->close();
					return "bericht toegevoegd";
				}
			} else {
				if ($stmt = $this->conn->prepare("INSERT INTO `notifications`( `creater`, `viewer`, `title`, `message`, `date_time`) VALUES (?,?,?,?,?)")) {
					$stmt->bind_param("iisss", $creater, $viewer, $title, $message, $date_time);
					$stmt->execute();
					$stmt->close();
					return "bericht toegevoegd";
				}
			}
		}

		
		public function selectAllNotifications(){
			if ($stmt = $this->conn->prepare("SELECT notification_id, creater, viewer, title, `message`, date_time, `name` FROM `notifications` JOIN users ON notifications.creater = users.user_id WHERE `viewer` IS NULL ORDER BY date_time DESC")) {
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function selectCurrentUserNotifications($userID){
			if ($stmt = $this->conn->prepare("SELECT notification_id, creater, viewer, title, `message`, date_time, `name` FROM `notifications` JOIN users ON notifications.creater = users.user_id WHERE `viewer` = ? ORDER BY date_time DESC")) {
				$stmt->bind_param("i", $userID);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function selectAllLabjournals($year, $userId, $sorting, $ascdesc) {
            if ($ascdesc == "DESC"){
            	$sql = "SELECT * FROM `lab_journal` JOIN `lab_journal_users` ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
					WHERE year = $year
					AND lab_journal_users.user_id = $userId
					ORDER BY $sorting DESC";
            } else {
            	$sql = "SELECT * FROM `lab_journal` JOIN `lab_journal_users` ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
					WHERE year = $year
					AND lab_journal_users.user_id = $userId
					ORDER BY $sorting ASC";
            }
            if($stmt = $this->conn->prepare($sql)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
		
    
		public function getAllGradeResults($year, $sortName){
			if(!empty($sortName)){
				$sql = "SELECT DISTINCT users.user_id, users.name
					FROM users
					INNER JOIN lab_journal_users ON users.user_id = lab_journal_users.user_id
					INNER JOIN lab_journal ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
					WHERE lab_journal.year = $year AND lab_journal.submitted = 1
					GROUP BY users.user_id
					ORDER BY users.name $sortName";
			} else {
				$sql = "SELECT DISTINCT users.user_id, users.name
					FROM users
					INNER JOIN lab_journal_users ON users.user_id = lab_journal_users.user_id
					INNER JOIN lab_journal ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
					WHERE lab_journal.year = $year AND lab_journal.submitted = 1
					GROUP BY users.user_id";
			}
			if ($stmt = $this->conn->prepare($sql)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function getGradeResultsPerPerson($userId, $year, $sortDate){
		
			if(!empty($sortDate)) {
				$sql = "SELECT lab_journal.labjournaal_id, lab_journal.grade, lab_journal.title
					FROM users
					INNER JOIN lab_journal_users ON users.user_id = lab_journal_users.user_id
					INNER JOIN lab_journal ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
					WHERE users.user_id = ? AND lab_journal.year = $year AND lab_journal.submitted = 1
					ORDER BY lab_journal.date $sortDate";
			} else{	
				$sql = "SELECT lab_journal.labjournaal_id, lab_journal.grade, lab_journal.title
					FROM users
					INNER JOIN lab_journal_users ON users.user_id = lab_journal_users.user_id
					INNER JOIN lab_journal ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
					WHERE users.user_id = ? AND lab_journal.year = $year AND lab_journal.submitted = 1";					
			}

			if ($stmt = $this->conn->prepare($sql)) {
				$stmt->bind_param("i", $userId);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
		}
		public function selectcontentlabjournal($labjournaal_id){
			if($stmt = $this->conn->prepare("SELECT * FROM `lab_journal` WHERE labjournaal_id = ?")){
					$stmt->bind_param("i", $labjournaal_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$stmt->free_result();
					$stmt->close();
					return $result;
				}
				else{
					return mysqli_error($this->conn);
				}
		}
		public function selectpdfcontentpreperation(){}

		// this still needs a join in lab-journaal-users
		public function LabjournaalToevoegen($title, $date, $theory, $safety, $creater_id, $logboek, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis){
			
			$title = htmlspecialchars($title);
			$date = htmlspecialchars($date);
			$theory = htmlspecialchars($theory);
			$safety = htmlspecialchars($safety);
			$creater_id = htmlspecialchars($creater_id);
			$logboek = htmlspecialchars($logboek);
			$method_materials = htmlspecialchars($method_materials);
			$submitted = htmlspecialchars($submitted);
			$grade = htmlspecialchars($grade);
			$year = htmlspecialchars($year);
			$Attachment = htmlspecialchars($Attachment);
			$Goal = htmlspecialchars($Goal);
			$Hypothesis = htmlspecialchars($Hypothesis);

			if ($stmt = $this->conn->prepare("INSERT INTO `lab_journal`(`title`, `date`, `theory`, `safety`, `creater_id`, `logboek`, `method_materials`, `submitted`, `grade`, `year`, `Attachment`, `Goal`, `Hypothesis`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
				$stmt->bind_param("ssssissiiisss", $title, $date, $theory, $safety, $creater_id, $logboek, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis);
				$stmt->execute();
				$stmt->close();
			}
			if ($stmt = $this->conn->prepare("SELECT `labjournaal_id` FROM `lab_journal` WHERE `date`= ? AND `creater_id`= ?")) {
                $stmt->bind_param('si',$date, $creater_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
		public function connectNewLabjournaalWithUser($userId, $LabjournaalId){
			
			$userId = htmlspecialchars($userId);
			$LabjournaalId = htmlspecialchars($LabjournaalId);
			if ($stmt = $this->conn->prepare("INSERT INTO `lab_journal_users`(`user_id`, `lab_journal_id`) VALUES (?,?)")) {
                $stmt->bind_param('ii', $userId, $LabjournaalId);
				$stmt->execute();
				$stmt->close();
				return "Labjournaal toegevoegd";
			}
			return NULL;
		}

		public function updateUsersLanguage($userId, $language){

			$userId = htmlspecialchars($userId);
			$language = htmlspecialchars($language);

			if ($stmt = $this->conn->prepare("UPDATE `users` SET `lang`=? WHERE `user_id` = ?")) {
                $stmt->bind_param('si',  $language, $userId);
				$stmt->execute();
				$stmt->close();
				return "Labjournaal toegevoegd";
			}
			return NULL;
		}
		public function selectStudentSearchResultsLabjournal($userId, $searchWord) {
			$searchWord = htmlspecialchars($searchWord);
			if($stmt = $this->conn->prepare(
				"SELECT * FROM `lab_journal`
				JOIN lab_journal_users ON labjournaal_id = lab_journal_users.lab_journal_id
				JOIN users ON lab_journal_users.user_id = users.user_id
				WHERE creater_id = ?
				AND (title LIKE ?
				OR theory LIKE ?
				OR safety LIKE ?
				OR logboek LIKE ?
				OR method_materials LIKE ?
				OR goal LIKE ?
				OR hypothesis LIKE ?)
				ORDER BY `date` DESC
				")) {
				$stmt->bind_param("isssssss", $userId, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function selectStudentSearchResultsPreperation($userId, $searchWord) {
			$searchWord = htmlspecialchars($searchWord);
			if($stmt = $this->conn->prepare(
				"SELECT * FROM `preparation`
				JOIN preperation_users ON preparation_id = preperation_users.preperation_id
				JOIN users ON preperation_users.user_id = users.user_id
				WHERE creater_id = ?
				AND (title LIKE ?
				OR materials LIKE ?
				OR safety LIKE ?
				OR method LIKE ?
				OR preparation_questions LIKE ?
				OR goal LIKE ?
				OR hypothesis LIKE ?)
				ORDER BY `date` DESC
				")) {
				$stmt->bind_param("isssssss", $userId, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function selectTeacherSearchResultsPreperation($searchWord) {
			$searchWord = htmlspecialchars($searchWord);
			if($stmt = $this->conn->prepare(
				"SELECT * FROM `preparation`
				JOIN preperation_users ON preparation_id = preperation_users.preperation_id
				JOIN users ON preperation_users.user_id = users.user_id
				WHERE (title LIKE ?
				OR materials LIKE ?
				OR safety LIKE ?
				OR method LIKE ?
				OR preparation_questions LIKE ?
				OR goal LIKE ?
				OR hypothesis LIKE ?)
				ORDER BY `date` DESC
				")) {
				$stmt->bind_param("sssssss", $searchWord, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function selectTeacherSearchResultsLabjournal($searchWord) {
			$searchWord = htmlspecialchars($searchWord);
			if($stmt = $this->conn->prepare(
				"SELECT * FROM `lab_journal`
				JOIN lab_journal_users ON labjournaal_id = lab_journal_users.lab_journal_id
				JOIN users ON lab_journal_users.user_id = users.user_id
				WHERE (title LIKE ?
				OR theory LIKE ?
				OR safety LIKE ?
				OR logboek LIKE ?
				OR method_materials LIKE ?
				OR goal LIKE ?
				OR hypothesis LIKE ?)
				ORDER BY `date` DESC
				")) {
				$stmt->bind_param("sssssss", $searchWord, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function updateProfielFoto($UserID ,$profilePictureName){

			$UserID = htmlspecialchars($UserID);
			$profilePictureName = htmlspecialchars($profilePictureName);

			if ($stmt = $this->conn->prepare("UPDATE `users` SET `profile_picture` =? WHERE `user_id` = ?")) {
                $stmt->bind_param('si', $profilePictureName, $UserID);
				$stmt->execute();
				$stmt->close();
				return $profilePictureName;
			}
			return NULL;
		}
		
		public function updatelabjournaal($title, $date, $theory, $safety, $logboek, $method_materials, $submitted, $year, $Attachment, $Goal, $Hypothesis, $UserID, $labjournaal_id){

			$title = htmlspecialchars($title);
			$date = htmlspecialchars($date);
			$theory = htmlspecialchars($theory);
			$safety = htmlspecialchars($safety);
			$logboek = htmlspecialchars($logboek);
			$method_materials = htmlspecialchars($method_materials);
			$submitted = htmlspecialchars($submitted);
			$year = htmlspecialchars($year);
			$Attachment = htmlspecialchars($Attachment);
			$Goal = htmlspecialchars($Goal);
			$Hypothesis = htmlspecialchars($Hypothesis);
			$UserID = htmlspecialchars($UserID);
			$labjournaal_id = htmlspecialchars($labjournaal_id);

			if ($stmt = $this->conn->prepare("UPDATE `lab_journal` 
			JOIN lab_journal_users ON lab_journal_users.lab_journal_id =  lab_journal.labjournaal_id
			SET `title`=?,`date`=?,`theory`=?,`safety`=?, `logboek`=?,`method_materials`=?,`submitted`=?, `year`=?,`Attachment`=?,`Goal`=?,`Hypothesis`=? 
			WHERE lab_journal_users.`user_id` = ? AND labjournaal_id = ?")) {
                $stmt->bind_param('ssssssiisssii', $title, $date, $theory, $safety, $logboek, $method_materials, $submitted, $year, $Attachment, $Goal, $Hypothesis, $UserID, $labjournaal_id);
				$stmt->execute();
				$stmt->close();
				return "gelukt";
			}
			else{
				$conn = $this->conn;
				return mysqli_error($conn);
			}
		}

		public function getLabjournaal($labjournaal, $userId){
			
			$labjournaal = htmlspecialchars($labjournaal);
			$userId = htmlspecialchars($userId);
			
			if ($stmt = $this->conn->prepare("SELECT `title`,`theory`,`safety`,`logboek`,`method_materials`,`submitted`,`year`,`Attachment`,`Goal`,`Hypothesis`,`creater_id` 
			FROM `lab_journal` 
			JOIN lab_journal_users ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
			WHERE lab_journal.labjournaal_id = ? AND lab_journal_users.user_id = ? ")) {
                $stmt->bind_param('ii', $labjournaal, $userId);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function docentstudentprofielbewerken($userID, $name, $email, $usernumber, $password,$role){

			$userID = htmlspecialchars($userID);
			$name = htmlspecialchars($name);
			$email = htmlspecialchars($email);
			$usernumber = htmlspecialchars($usernumber);
			$password = htmlspecialchars($password);
			$role = htmlspecialchars($role);

			if ($stmt = $this->conn->prepare("UPDATE `users` SET `name` =?, `email` =?, `user_number` =?, `password` =?, `role`=? WHERE `user_id`=?")) {
				$stmt->bind_param('ssissi', $name, $email, $usernumber, $password,$role,$userID);
				$stmt->execute();
				$stmt->close();
				return 'geupdate';
			}
			return NULL;
		}

		public function updateCurrentUsersPassword($UserID ,$newPassword){

			$UserID = htmlspecialchars($UserID);
			$newPassword = htmlspecialchars($newPassword);

			if ($stmt = $this->conn->prepare("UPDATE `users` SET `password` = ? WHERE `user_id` = ?")) {
                $stmt->bind_param('si', $newPassword, $UserID);
				$stmt->execute();
				$stmt->close();
				return;
			}
			return NULL;
		}

		public function DocentLabjournaalView($labjournalid){
			if ($stmt = $this->conn->prepare('SELECT * FROM `lab_journal` INNER JOIN users ON lab_journal.creater_id = users.user_id WHERE labjournaal_id = ?')){
				$stmt->bind_param('i', $labjournalid);
				$stmt->execute();
				$result = $stmt->get_result();
                $stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
    
		public function DeleteUser($userid){
			if($stmt = $this->conn->prepare('UPDATE `users` SET `email` = "DELETED", `password` = "DELETED", `role`= "DELETED", `profile_picture` = NULL WHERE `user_id` =?')){
				$stmt->bind_param('i', $userid);
				$stmt->execute();
				$stmt->close();
				$message = "User Succesfully Deleted";
				return $message;
			}
			else{
				return mysqli_error($this->conn);
			}
		}
    
		public function GetAllLabUsers($labid){
		if ($stmt = $this->conn->prepare('SELECT `name`,`users`.`user_id`, `lab_journal_id` FROM `lab_journal_users` JOIN `users` ON lab_journal_users.user_id = users.user_id WHERE lab_journal_id = ?')){
			$stmt->bind_param('i', $labid);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->free_result();
			$stmt->close();
			return $result;
			}
			else{ return mysqli_error($this->conn);}
		}
		public function DeleteExtraUser($userid, $labjournaalid){
		if($stmt = $this->conn->prepare('DELETE FROM `lab_journal_users` WHERE `user_id` = ? AND `lab_journal_id` = ?')){
			$stmt->bind_param('ii', $userid, $labjournaalid);
			$stmt->execute();
			$stmt->close();
			return "Verwijderen gelukt";
		}
		else{ return mysqli_error($this->conn);}
	}
    
		public function deleteNotification($notificationId){
			
			$notificationId = htmlspecialchars($notificationId);

			if ($stmt = $this->conn->prepare("DELETE FROM `notifications` WHERE `notification_id` = ?")) {
                $stmt->bind_param('i', $notificationId);
				$stmt->execute();
				$stmt->close();
				return "Deleted Notification";
			}
			return NULL;
		}

		public function viewNotification($labjournalid){
			if ($stmt = $this->conn->prepare('SELECT notification_id, creater, viewer, title, `message`, date_time, `name` FROM `notifications` JOIN users ON notifications.creater = users.user_id WHERE `notification_id` = ? ORDER BY date_time DESC')){
				$stmt->bind_param('i', $labjournalid);
				$stmt->execute();
				$result = $stmt->get_result();
                $stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
		
		public function selectCurrentCreaterNotifications($userID){
			if ($stmt = $this->conn->prepare("SELECT notification_id, creater, viewer, title, `message`, date_time, `name` FROM `notifications` JOIN users ON notifications.creater = users.user_id WHERE `creater` = ? AND viewer IS NOT NULL ORDER BY date_time DESC")) {
				$stmt->bind_param("i", $userID);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
	}
?>
