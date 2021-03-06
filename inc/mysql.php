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
			return mysqli_error($this->conn);
		}

		public function selectStudentslab($name){
			$name = htmlspecialchars($name);
			if ($stmt = $this->conn->prepare("SELECT `user_id`, `name`, `email`, `user_number`, `profile_picture`, `lang`, `role` FROM `users` WHERE `role` = 'Student' AND `name` LIKE ?")) {
				$stmt->bind_param("s", $name);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return mysqli_error($this->conn);
		}

		public function checkUsersAllowance($userId, $userName, $userEmail){

			$userId = htmlspecialchars($userId);
			$userName = htmlspecialchars($userName);
			$userEmail = htmlspecialchars($userEmail);

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
			
			$userID = htmlspecialchars($userID);

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

			$email = htmlspecialchars($email);

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
    
		public function addNewNotification($creator, $viewer, $title, $message, $date_time){
			
			$creator = htmlspecialchars($creator);
			$viewer = htmlspecialchars($viewer);
			$title = htmlspecialchars($title);
			$message = htmlspecialchars($message);
			$date_time = htmlspecialchars($date_time);

			if ($viewer == '0') {
				if ($stmt = $this->conn->prepare("INSERT INTO `notifications`( `creator`, `title`, `message`, `date_time`) VALUES (?,?,?,?)")) {
					$stmt->bind_param("isss", $creator, $title, $message, $date_time);
					$stmt->execute();
					$stmt->close();
					return "bericht toegevoegd";
				}
			} else {
				if ($stmt = $this->conn->prepare("INSERT INTO `notifications`( `creator`, `viewer`, `title`, `message`, `date_time`) VALUES (?,?,?,?,?)")) {
					$stmt->bind_param("iisss", $creator, $viewer, $title, $message, $date_time);
					$stmt->execute();
					$stmt->close();
					return "bericht toegevoegd";
				}
			}
		}

		
		public function selectAllNotifications(){
			if ($stmt = $this->conn->prepare("SELECT notification_id, creator, viewer, title, `message`, date_time, `name` FROM `notifications` JOIN users ON notifications.creator = users.user_id WHERE `viewer` IS NULL ORDER BY date_time DESC")) {
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function selectCurrentUserNotifications($userID){
			$userID = htmlspecialchars($userID);
			if ($stmt = $this->conn->prepare("SELECT notification_id, creator, viewer, title, `message`, date_time, `name` FROM `notifications` JOIN users ON notifications.creator = users.user_id WHERE `viewer` = ? ORDER BY date_time DESC")) {
				$stmt->bind_param("i", $userID);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function selectAllPreperations($year, $userId, $sorting, $ascdesc) {

			$year = htmlspecialchars($year);
			$userId = htmlspecialchars($userId);
			$sorting = htmlspecialchars($sorting);
			$ascdesc = htmlspecialchars($ascdesc);

            if($stmt = $this->conn->prepare("SELECT * FROM `preparation` JOIN `preperation_users` ON preparation.preparation_id = preperation_users.preparation_id 
			WHERE year = ?
			AND preperation_users.user_id = ?
			ORDER BY $sorting $ascdesc")) {
				$stmt->bind_param("ii", $year,$userId);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
		
		public function selectAllLabjournals($year, $userId, $sorting, $ascdesc) {

			$year = htmlspecialchars($year);
			$userId = htmlspecialchars($userId);
			$sorting = htmlspecialchars($sorting);
			$ascdesc = htmlspecialchars($ascdesc);

            if($stmt = $this->conn->prepare("SELECT * FROM `lab_journal` JOIN `lab_journal_users` ON lab_journal.labjournal_id = lab_journal_users.lab_journal_id
				WHERE year = ?
				AND lab_journal_users.user_id = ?
				ORDER BY $sorting $ascdesc")) {
				$stmt->bind_param("ii", $year,$userId);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
    
		public function getAllGradeResults($year,$submitted, $sorting, $ascdesc) {

			$year = htmlspecialchars($year);
			$submitted = htmlspecialchars($submitted);
			$sorting = htmlspecialchars($sorting);
			$ascdesc = htmlspecialchars($ascdesc);

			if ($stmt = $this->conn->prepare("SELECT * FROM `users` 
			JOIN lab_journal_users ON users.user_id = lab_journal_users.user_id
			JOIN lab_journal ON lab_journal.labjournal_id = lab_journal_users.lab_journal_id
			WHERE lab_journal.year = ? AND lab_journal.submitted = ?
			ORDER BY $sorting $ascdesc")) {
				$stmt->bind_param("ii", $year,$submitted);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function getAllPreparationsGradeResults($year,$submitted, $sorting, $ascdesc) {

			$year = htmlspecialchars($year);
			$submitted = htmlspecialchars($submitted);
			$sorting = htmlspecialchars($sorting);
			$ascdesc = htmlspecialchars($ascdesc);

			if ($stmt = $this->conn->prepare("SELECT * FROM `users` 
			JOIN preperation_users ON users.user_id = preperation_users.user_id
			JOIN preparation ON preparation.preparation_id  = preperation_users.preparation_id 
			WHERE preparation.year = ? AND preparation.submitted = ?
			ORDER BY $sorting $ascdesc")) {
				$stmt->bind_param("ii", $year,$submitted);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function getGradeResultsPerPerson($userId, $year,$archive, $sortDate){
			
			$year = htmlspecialchars($year);
			$userId = htmlspecialchars($userId);
			$archive = htmlspecialchars($archive);
			$sortDate = htmlspecialchars($sortDate);
		
			if(!empty($sortDate)) {
				$sql = "SELECT lab_journal.labjournal_id, lab_journal.grade, lab_journal.title
					FROM users
					INNER JOIN lab_journal_users ON users.user_id = lab_journal_users.user_id
					INNER JOIN lab_journal ON lab_journal.labjournal_id = lab_journal_users.lab_journal_id
					WHERE users.user_id = ? AND lab_journal.year = $year AND lab_journal.submitted = $archive
					ORDER BY lab_journal.date $sortDate";
			} else{	
				$sql = "SELECT lab_journal.labjournal_id, lab_journal.grade, lab_journal.title
					FROM users
					INNER JOIN lab_journal_users ON users.user_id = lab_journal_users.user_id
					INNER JOIN lab_journal ON lab_journal.labjournal_id = lab_journal_users.lab_journal_id
					WHERE users.user_id = ? AND lab_journal.year = $year AND lab_journal.submitted = $archive";
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
		public function selectcontentlabjournal($labjournal_id){

			$labjournal_id = htmlspecialchars($labjournal_id);

			if($stmt = $this->conn->prepare("SELECT * FROM `lab_journal` WHERE labjournal_id = ?")){
					$stmt->bind_param("i", $labjournal_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$stmt->free_result();
					$stmt->close();
					return $result;
				}
			return NULL;
		}

		public function selectcontentpreparation($prepid){
			if($stmt = $this->conn->prepare("SELECT * FROM `preparation` WHERE preparation_id = ?")){
					$stmt->bind_param("i", $prepid);
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
		
		public function addLabJournalWithOutAttachment($title, $date, $theory, $safety, $creator_id, $log, $method_materials, $submitted, $grade, $year, $Goal, $Hypothesis){
			
			$title = htmlspecialchars($title);
			$date = htmlspecialchars($date);
			$theory = htmlspecialchars($theory);
			$safety = htmlspecialchars($safety);
			$creator_id = htmlspecialchars($creator_id);
			$log = htmlspecialchars($log);
			$method_materials = htmlspecialchars($method_materials);
			$submitted = htmlspecialchars($submitted);
			$grade = htmlspecialchars($grade);
			$year = htmlspecialchars($year);
			$Goal = htmlspecialchars($Goal);
			$Hypothesis = htmlspecialchars($Hypothesis);

			if ($stmt = $this->conn->prepare("INSERT INTO `lab_journal`(`title`, `date`, `theory`, `safety`, `creator_id`, `log`, `method_materials`, `submitted`, `grade`, `year`, `Goal`, `Hypothesis`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)")) {
				$stmt->bind_param("ssssissiiiss", $title, $date, $theory, $safety, $creator_id, $log, $method_materials, $submitted, $grade, $year, $Goal, $Hypothesis);
				$stmt->execute();
				$stmt->close();
			}
			if ($stmt = $this->conn->prepare("SELECT `labjournal_id` FROM `lab_journal` WHERE `date`= ? AND `creator_id`= ?")) {
                $stmt->bind_param('si',$date, $creator_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		
		public function addPreparationWithOutAttachment($title, $date, $theory, $safety, $creator_id, $log, $method_materials, $submitted, $grade, $year, $Goal, $Hypothesis){
			
			$title = htmlspecialchars($title);
			$date = htmlspecialchars($date);
			$theory = htmlspecialchars($theory);
			$safety = htmlspecialchars($safety);
			$creator_id = htmlspecialchars($creator_id);
			$log = htmlspecialchars($log);
			$method_materials = htmlspecialchars($method_materials);
			$submitted = htmlspecialchars($submitted);
			$grade = htmlspecialchars($grade);
			$year = htmlspecialchars($year);
			$Goal = htmlspecialchars($Goal);
			$Hypothesis = htmlspecialchars($Hypothesis);

			if ($stmt = $this->conn->prepare("INSERT INTO `preparation`(`title`, `date`, `theory`, `safety`, `creator_id`, `log`, `method_materials`, `submitted`, `grade`, `year`, `Goal`, `Hypothesis`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)")) {
				$stmt->bind_param("ssssissiiiss", $title, $date, $theory, $safety, $creator_id, $log, $method_materials, $submitted, $grade, $year, $Goal, $Hypothesis);
				$stmt->execute();
				$stmt->close();
			}
			if ($stmt = $this->conn->prepare("SELECT `preparation_id` FROM `preparation` WHERE `date`= ? AND `creator_id`= ?")) {
                $stmt->bind_param('si',$date, $creator_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function addLabJournalWithAttachment($title, $date, $theory, $safety, $creator_id, $log, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis){
			
			$title = htmlspecialchars($title);
			$date = htmlspecialchars($date);
			$theory = htmlspecialchars($theory);
			$safety = htmlspecialchars($safety);
			$creator_id = htmlspecialchars($creator_id);
			$log = htmlspecialchars($log);
			$method_materials = htmlspecialchars($method_materials);
			$submitted = htmlspecialchars($submitted);
			$grade = htmlspecialchars($grade);
			$year = htmlspecialchars($year);
			$Attachment = htmlspecialchars($Attachment);
			$Goal = htmlspecialchars($Goal);
			$Hypothesis = htmlspecialchars($Hypothesis);

			if ($stmt = $this->conn->prepare("INSERT INTO `lab_journal`(`title`, `date`, `theory`, `safety`, `creator_id`, `log`, `method_materials`, `submitted`, `grade`, `year`, `Attachment`, `Goal`, `Hypothesis`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
				$stmt->bind_param("ssssissiiisss", $title, $date, $theory, $safety, $creator_id, $log, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis);
				$stmt->execute();
				$stmt->close();
			}
			if ($stmt = $this->conn->prepare("SELECT `labjournal_id` FROM `lab_journal` WHERE `date`= ? AND `creator_id`= ?")) {
                $stmt->bind_param('si',$date, $creator_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function addPreparationWithAttachment($title, $date, $theory, $safety, $creator_id, $log, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis){
			
			$title = htmlspecialchars($title);
			$date = htmlspecialchars($date);
			$theory = htmlspecialchars($theory);
			$safety = htmlspecialchars($safety);
			$creator_id = htmlspecialchars($creator_id);
			$log = htmlspecialchars($log);
			$method_materials = htmlspecialchars($method_materials);
			$submitted = htmlspecialchars($submitted);
			$grade = htmlspecialchars($grade);
			$year = htmlspecialchars($year);
			$Attachment = htmlspecialchars($Attachment);
			$Goal = htmlspecialchars($Goal);
			$Hypothesis = htmlspecialchars($Hypothesis);

			if ($stmt = $this->conn->prepare("INSERT INTO `preparation`(`title`, `date`, `theory`, `safety`, `creator_id`, `log`, `method_materials`, `submitted`, `grade`, `year`, `Attachment`, `Goal`, `Hypothesis`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
				$stmt->bind_param("ssssissiiisss", $title, $date, $theory, $safety, $creator_id, $log, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis);
				$stmt->execute();
				$stmt->close();
			}
			if ($stmt = $this->conn->prepare("SELECT `preparation_id` FROM `preparation` WHERE `date`= ? AND `creator_id`= ?")) {
                $stmt->bind_param('si',$date, $creator_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function connectNewLabjournalWithUser($userId, $LabjournalId){
			
			$userId = htmlspecialchars($userId);
			$LabjournalId = htmlspecialchars($LabjournalId);
			
			if ($stmt = $this->conn->prepare("INSERT INTO `lab_journal_users`(`user_id`, `lab_journal_id`) VALUES (?,?)")) {
                $stmt->bind_param('ii', $userId, $LabjournalId);
				$stmt->execute();
				$stmt->close();
				return "Labjournaal toegevoegd";
			}
			return NULL;
		}

		public function connectNewPreparationWithUser($userId, $preparation_id){
			
			$userId = htmlspecialchars($userId);
			$preparation_id = htmlspecialchars($preparation_id);
			
			if ($stmt = $this->conn->prepare("INSERT INTO `preperation_users`(`user_id`, `preparation_id`) VALUES (?,?)")) {
                $stmt->bind_param('ii', $userId, $preparation_id);
				$stmt->execute();
				$stmt->close();
				return "Preparation toegevoegd";
			}
			return NULL;
		}

		public function archiveLabjournal($labjournalid, $submitted){
			
			$labjournalid = htmlspecialchars($labjournalid);
			$submitted = htmlspecialchars($submitted);

			if ($stmt = $this->conn->prepare("UPDATE `lab_journal` SET `submitted`= ? WHERE `labjournal_id` = ?")) {
				$stmt->bind_param('ii', $submitted, $labjournalid);
				$stmt->execute();
				$stmt->close();
				return "functie is uitgevoegd";
			}
			return NULL;
		}

		public function archivePreparation($preparation_id, $submitted){
			
			$labjournalid = htmlspecialchars($preparation_id);
			$submitted = htmlspecialchars($submitted);

			if ($stmt = $this->conn->prepare("UPDATE `preparation` SET `submitted`= ? WHERE `preparation_id` = ?")) {
				$stmt->bind_param('ii', $submitted, $preparation_id);
				$stmt->execute();
				$stmt->close();
				return "functie is uitgevoegd";
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
				return "Gebruikerstaal geupdate";
			}
			return NULL;
		}
		public function selectStudentSearchResultsLabjournal($userId, $searchWord) {

			$searchWord = htmlspecialchars($searchWord);
			$userId = htmlspecialchars($userId);

			if($stmt = $this->conn->prepare(
				"SELECT * FROM `lab_journal`
				JOIN lab_journal_users ON labjournal_id = lab_journal_users.lab_journal_id
				JOIN users ON lab_journal_users.user_id = users.user_id
				WHERE lab_journal_users.user_id = ?
				AND (title LIKE ?
				OR theory LIKE ?
				OR safety LIKE ?
				OR log LIKE ?
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
			$userId = htmlspecialchars($userId);

			if($stmt = $this->conn->prepare(
				"SELECT * FROM `preparation`
				JOIN preperation_users ON preparation.preparation_id = preperation_users.preparation_id
				JOIN users ON preperation_users.user_id = users.user_id
				WHERE preperation_users.user_id = ?
				AND (title LIKE ?
				OR theory LIKE ?
				OR safety LIKE ?
				OR log LIKE ?
				OR method_materials LIKE ?
				OR Goal LIKE ?
				OR Hypothesis LIKE ?)
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

		public function selectTeacherSearchResultsPreperation($searchWord){

			$searchWord = htmlspecialchars($searchWord);

			if($stmt = $this->conn->prepare(
				"SELECT * FROM `preparation`
				JOIN preperation_users ON preparation.preparation_id = preperation_users.preparation_id
				JOIN users ON preperation_users.user_id = users.user_id
				AND (title LIKE ?
				OR theory LIKE ?
				OR safety LIKE ?
				OR log LIKE ?
				OR method_materials LIKE ?
				OR goal LIKE ?
				OR hypothesis LIKE ?)
				AND submitted = 1
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
				JOIN lab_journal_users ON labjournal_id = lab_journal_users.lab_journal_id
				JOIN users ON lab_journal_users.user_id = users.user_id
				WHERE (title LIKE ?
				OR theory LIKE ?
				OR `safety` LIKE ?
				OR `log` LIKE ?
				OR method_materials LIKE ?
				OR goal LIKE ?
				OR hypothesis LIKE ?)
				AND submitted = 1
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

		public function updateProfilePicture($UserID ,$profilePictureName){

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
		
		public function updatelabjournalWithAtatchment($title, $date, $theory, $safety, $log, $method_materials, $submitted, $year, $Attachment, $Goal, $Hypothesis, $UserID, $labjournal_id){

			$title = htmlspecialchars($title);
			$date = htmlspecialchars($date);
			$theory = htmlspecialchars($theory);
			$safety = htmlspecialchars($safety);
			$log = htmlspecialchars($log);
			$method_materials = htmlspecialchars($method_materials);
			$submitted = htmlspecialchars($submitted);
			$year = htmlspecialchars($year);
			$Attachment = htmlspecialchars($Attachment);
			$Goal = htmlspecialchars($Goal);
			$Hypothesis = htmlspecialchars($Hypothesis);
			$UserID = htmlspecialchars($UserID);
			$labjournal_id = htmlspecialchars($labjournal_id);

			if ($stmt = $this->conn->prepare("UPDATE `lab_journal` 
			JOIN lab_journal_users ON lab_journal_users.lab_journal_id =  lab_journal.labjournal_id
			SET `title`=?,`date`=?,`theory`=?,`safety`=?, `log`=?,`method_materials`=?,`submitted`=?, `year`=?,`Attachment`=?,`Goal`=?,`Hypothesis`=? 
			WHERE lab_journal_users.`user_id` = ? AND labjournal_id = ?")) {
                $stmt->bind_param('ssssssiisssii', $title, $date, $theory, $safety, $log, $method_materials, $submitted, $year, $Attachment, $Goal, $Hypothesis, $UserID, $labjournal_id);
				$stmt->execute();
				$stmt->close();
				return "gelukt";
			}
			return NULL;
		}

		public function updatePreparationWithAtatchment($title, $date, $theory, $safety, $log, $method_materials, $submitted, $year, $Attachment, $Goal, $Hypothesis, $UserID, $labjournal_id){

			$title = htmlspecialchars($title);
			$date = htmlspecialchars($date);
			$theory = htmlspecialchars($theory);
			$safety = htmlspecialchars($safety);
			$log = htmlspecialchars($log);
			$method_materials = htmlspecialchars($method_materials);
			$submitted = htmlspecialchars($submitted);
			$year = htmlspecialchars($year);
			$Attachment = htmlspecialchars($Attachment);
			$Goal = htmlspecialchars($Goal);
			$Hypothesis = htmlspecialchars($Hypothesis);
			$UserID = htmlspecialchars($UserID);
			$labjournal_id = htmlspecialchars($labjournal_id);

			if ($stmt = $this->conn->prepare("UPDATE `preparation` 
			JOIN preperation_users ON preperation_users.preparation_id =  preparation.preparation_id
			SET `title`=?,`date`=?,`theory`=?,`safety`=?, `log`=?,`method_materials`=?,`submitted`=?, `year`=?,`Attachment`=?,`Goal`=?,`Hypothesis`=? 
			WHERE preperation_users.`user_id` = ? AND preparation.preparation_id = ?")) {
                $stmt->bind_param('ssssssiisssii', $title, $date, $theory, $safety, $log, $method_materials, $submitted, $year, $Attachment, $Goal, $Hypothesis, $UserID, $labjournal_id);
				$stmt->execute();
				$stmt->close();
				return "gelukt";
			}
			return NULL;
		}

		public function updatelabjournalWithoutAtatchment($title, $date, $theory, $safety, $log, $method_materials, $submitted, $year, $Goal, $Hypothesis, $UserID, $labjournal_id){

			$title = htmlspecialchars($title);
			$date = htmlspecialchars($date);
			$theory = htmlspecialchars($theory);
			$safety = htmlspecialchars($safety);
			$log = htmlspecialchars($log);
			$method_materials = htmlspecialchars($method_materials);
			$submitted = htmlspecialchars($submitted);
			$year = htmlspecialchars($year);
			$Goal = htmlspecialchars($Goal);
			$Hypothesis = htmlspecialchars($Hypothesis);
			$UserID = htmlspecialchars($UserID);
			$labjournal_id = htmlspecialchars($labjournal_id);

			if ($stmt = $this->conn->prepare("UPDATE `lab_journal` 
			JOIN lab_journal_users ON lab_journal_users.lab_journal_id =  lab_journal.labjournal_id
			SET `title`=?,`date`=?,`theory`=?,`safety`=?, `log`=?,`method_materials`=?,`submitted`=?, `year`=?,`Goal`=?,`Hypothesis`=? 
			WHERE lab_journal_users.`user_id` = ? AND labjournal_id = ?")) {
                $stmt->bind_param('ssssssiissii', $title, $date, $theory, $safety, $log, $method_materials, $submitted, $year, $Goal, $Hypothesis, $UserID, $labjournal_id);
				$stmt->execute();
				$stmt->close();
				return "gelukt";
			}
			return NULL;
		}

		public function updatePreperationWithoutAtatchment($title, $date, $theory, $safety, $log, $method_materials, $submitted, $year, $Goal, $Hypothesis, $UserID, $labjournal_id){

			$title = htmlspecialchars($title);
			$date = htmlspecialchars($date);
			$theory = htmlspecialchars($theory);
			$safety = htmlspecialchars($safety);
			$log = htmlspecialchars($log);
			$method_materials = htmlspecialchars($method_materials);
			$submitted = htmlspecialchars($submitted);
			$year = htmlspecialchars($year);
			$Goal = htmlspecialchars($Goal);
			$Hypothesis = htmlspecialchars($Hypothesis);
			$UserID = htmlspecialchars($UserID);
			$labjournal_id = htmlspecialchars($labjournal_id);

			if ($stmt = $this->conn->prepare("UPDATE `preparation` 
			JOIN preperation_users ON preperation_users.preparation_id =  preparation.preparation_id
			SET `title`=?,`date`=?,`theory`=?,`safety`=?, `log`=?,`method_materials`=?,`submitted`=?, `year`=?,`Goal`=?,`Hypothesis`=? 
			WHERE preperation_users.`user_id` = ? AND preparation.preparation_id = ?")) {
				
                $stmt->bind_param('ssssssiissii', $title, $date, $theory, $safety, $log, $method_materials, $submitted, $year, $Goal, $Hypothesis, $UserID, $labjournal_id);
				$stmt->execute();
				$stmt->close();
				return "gelukt";
			}
			return NULL;
		}

		public function getLabjournal($labjournal, $userId){
			
			$labjournal = htmlspecialchars($labjournal);
			$userId = htmlspecialchars($userId);
			
			if ($stmt = $this->conn->prepare("SELECT `title`,`theory`,`safety`,`log`,`method_materials`,`submitted`,`year`,`Attachment`,`Goal`,`Hypothesis`,`creator_id` 
			FROM `lab_journal` 
			JOIN lab_journal_users ON lab_journal.labjournal_id = lab_journal_users.lab_journal_id
			WHERE lab_journal.labjournal_id = ? AND lab_journal_users.user_id = ?")) {
                $stmt->bind_param('ii', $labjournal, $userId);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
		
		public function getPreparation($Preparation, $userId){
			
			$Preparation = htmlspecialchars($Preparation);
			$userId = htmlspecialchars($userId);
			
			if ($stmt = $this->conn->prepare("SELECT `title`,`theory`,`safety`,`log`,`method_materials`,`submitted`,`year`,`Attachment`,`Goal`,`Hypothesis`,`creator_id` 
			FROM `preparation` 
			JOIN preperation_users ON preparation.preparation_id = preperation_users.preparation_id
			WHERE preparation.preparation_id = ? AND preperation_users.user_id = ?")) {
                $stmt->bind_param('ii', $Preparation, $userId);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function teacherStudentProfileEdit($userID, $name, $email, $usernumber, $password,$role){

			$userID = htmlspecialchars($userID);
			$name = htmlspecialchars($name);
			$email = htmlspecialchars($email);
			$usernumber = htmlspecialchars($usernumber);
			$password = htmlspecialchars($password);
			$role = htmlspecialchars($role);

			if ($stmt = $this->conn->prepare("UPDATE `users` SET `name` =?, `email` =?, `user_number` =?, `password` =?, `role`=? WHERE `user_id`=?")) {
				$stmt->bind_param('ssissi', $name, $email, $usernumber, $password, $role, $userID);
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

		public function teacherLabjournalView($labjournalid){

			$labjournalid = htmlspecialchars($labjournalid);

			if ($stmt = $this->conn->prepare('SELECT * FROM `lab_journal` INNER JOIN users ON lab_journal.creator_id = users.user_id WHERE labjournal_id = ?')){
				$stmt->bind_param('i', $labjournalid);
				$stmt->execute();
				$result = $stmt->get_result();
                $stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function teacherPreparationView($preparation_id){
			$preparation_id = htmlspecialchars($preparation_id);
			if ($stmt = $this->conn->prepare('SELECT * FROM `preparation` INNER JOIN users ON preparation.creator_id = users.user_id WHERE preparation_id = ?')){
				$stmt->bind_param('i', $preparation_id);
				$stmt->execute();
				$result = $stmt->get_result();
                $stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function teacherProfileEdit($userID, $name, $email, $user_number){

			$userID = htmlspecialchars($userID);
			$name = htmlspecialchars($name);
			$email = htmlspecialchars($email);
			$user_number = htmlspecialchars($user_number);

			if ($stmt = $this->conn->prepare("UPDATE `users` SET `name` =?, `email` =?, `user_number` =? WHERE `user_id`=?")) {
				$stmt->bind_param('ssii', $name, $email, $user_number, $userID);
				$stmt->execute();
				$stmt->close();
				return 'geupdate';
			}
			return NULL;
		}
    
		public function updateGradeView($labjournal_id, $grade){

			$grade = htmlspecialchars($grade);
			$labjournal_id = htmlspecialchars($labjournal_id);

			if ($stmt = $this->conn->prepare("UPDATE lab_journal SET grade=? WHERE labjournal_id=?")) {
				$stmt->bind_param('ii', $grade, $labjournal_id);
				$stmt->execute();
				$stmt->close();
				return;
			}
			return NULL;
		}

		public function updatePreparationGradeView($preparation_id, $grade){

			$preparation_id = htmlspecialchars($preparation_id);
			$grade = htmlspecialchars($grade);

			if ($stmt = $this->conn->prepare("UPDATE preparation SET grade=? WHERE preparation_id=?")) {
				$stmt->bind_param('ii', $grade, $preparation_id);
				$stmt->execute();
				$stmt->close();
				return;
			}
			return NULL;
		}
    
		public function DeleteUser($userid){
			
			$userid = htmlspecialchars($userid);

			if($stmt = $this->conn->prepare('UPDATE `users` SET `email` = "DELETED", `password` = "DELETED", `role`= "DELETED", `profile_picture` = NULL WHERE `user_id` =?')){
				$stmt->bind_param('i', $userid);
				$stmt->execute();
				$stmt->close();
				$message = "User Succesfully Deleted";
				return $message;
			}
			return NULL;
		}
    
		public function GetAllLabUsers($labid){

			$labid = htmlspecialchars($labid);

			if ($stmt = $this->conn->prepare('SELECT `name`,`users`.`user_id`, `lab_journal_id` FROM `lab_journal_users` JOIN `users` ON lab_journal_users.user_id = users.user_id WHERE lab_journal_id = ?')){
				$stmt->bind_param('i', $labid);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function GetAllPreparationUsers($prepid){

			$prepid = htmlspecialchars($prepid);
			
		if ($stmt = $this->conn->prepare('SELECT `name`,`users`.`user_id`, `preparation_id` FROM `preperation_users` JOIN `users` ON preperation_users.user_id = users.user_id WHERE preparation_id = ?')){
			$stmt->bind_param('i', $prepid);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->free_result();
			$stmt->close();
			return $result;
			}
			return NULL;
		}

		public function DeleteExtraUser($userid, $labjournalid){
			
			$userid = htmlspecialchars($userid);
			$labjournalid = htmlspecialchars($labjournalid);

			if($stmt = $this->conn->prepare('DELETE FROM `lab_journal_users` WHERE `user_id` = ? AND `lab_journal_id` = ?')){
				$stmt->bind_param('ii', $userid, $labjournalid);
				$stmt->execute();
				$stmt->close();
				return "Verwijderen gelukt";
			}
			return NULL;
		}

		public function DeleteExtraUserInPreparation($userid, $preparation_id){

			$userid = htmlspecialchars($userid);
			$preparation_id = htmlspecialchars($preparation_id);

			if($stmt = $this->conn->prepare('DELETE FROM `preperation_users` WHERE `user_id` = ? AND `preparation_id` = ?')){
				$stmt->bind_param('ii', $userid, $preparation_id);
				$stmt->execute();
				$stmt->close();
				return "Verwijderen gelukt";
			}
			return NULL;
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

			$labjournalid = htmlspecialchars($labjournalid);

			if ($stmt = $this->conn->prepare('SELECT notification_id, title, `message`, date_time, 
			krijgViewer.name as Vname, 
			krijgCreator.name as Cname 
			FROM `notifications`
			JOIN users krijgCreator ON notifications.creator = krijgCreator.user_id
			LEFT JOIN users krijgViewer ON notifications.viewer = krijgViewer.user_id
			WHERE `notification_id` = ?')){
				$stmt->bind_param('i', $labjournalid);
				$stmt->execute();
				$result = $stmt->get_result();
                $stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}
		
		public function selectCurrentCreatorNotifications($userID){

			$userID = htmlspecialchars($userID);

			if ($stmt = $this->conn->prepare("SELECT notification_id, creator, viewer, title, `message`, date_time, `name` FROM `notifications` JOIN users ON notifications.creator = users.user_id WHERE `creator` = ? AND viewer IS NOT NULL ORDER BY date_time DESC")) {
				$stmt->bind_param("i", $userID);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function selectAllUsers2($sorting, $ascdesc) {

			$sorting = htmlspecialchars($sorting);
			$ascdesc = htmlspecialchars($ascdesc);

            if($stmt = $this->conn->prepare("SELECT * FROM `users`
			ORDER BY $sorting $ascdesc")) {
				//$stmt->bind_param("s", $sorting);
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