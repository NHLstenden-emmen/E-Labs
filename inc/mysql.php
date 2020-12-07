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
			$this->conn = @mysqli_connect($this->host,$this->user,$this->password, $this->table);
            if(!$this->conn)
            {
                DIE("could not connect". mysqli_connect_error($this->conn));
            }
		}

		// $selectAllUsers = $db->selectAllUsers();
		// while ($result = $selectAllUsers->fetch_array(MYSQLI_ASSOC)){
		// 	echo  $result['name'];
		// }
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

		public function selectCurrentUsers($userID){
			// this gets all the users and returns them
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
		
		// $message = $db->createNewUserWithoutProfielPictureAndLang("test 2","mail4@emai5ltje.com","12345","test","Student");
		// echo $message;
		public function createNewUserWithoutProfielPictureAndLang($name, $email, $user_number, $password, $role){
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
			if ($stmt = $this->conn->prepare("INSERT INTO `users`(`name`, `email`, `user_number`, `password`, `role`) VALUES (?,?,?,?,?)")) {
				$stmt->bind_param("ssiss", $name, $email, $user_number, $password, $role);
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
			if ($stmt = $this->conn->prepare("INSERT INTO `notifications`( `creater`, `viewer`, `title`, `message`, `date_time`) VALUES (?,?,?,?,?)")) {
				$stmt->bind_param("iissd", $creater, $viewer, $title, $message, $date_time);
				$stmt->execute();
				$stmt->close();
				return "bericht toegevoegd";
			}
			return NULL;
		}

		
		public function selectAllNotifications(){
			if ($stmt = $this->conn->prepare("SELECT * FROM `notifications` WHERE `viewer` IS NULL")) {
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function selectCurrentUserNotifications($userID){
			if ($stmt = $this->conn->prepare("SELECT * FROM `notifications` WHERE `viewer` = ?")) {
				$stmt->bind_param("i", $userID);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function selectAllLabjournals($year, $userId) {
            if (
            	$stmt = $this->conn->prepare("SELECT * FROM `lab_journal` JOIN `lab_journal_users` ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
					WHERE year = ?
					AND lab_journal_users.user_id = ?")) {
                $stmt->bind_param("ii", $year, $userId);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
		}
    
		public function getAllGradeResults($year){
			$sql = "SELECT DISTINCT users.user_id, users.name
                FROM users
                INNER JOIN lab_journal_users ON users.user_id = lab_journal_users.user_id
                INNER JOIN lab_journal ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
				WHERE lab_journal.year = $year
				GROUP BY users.user_id";
			if ($stmt = $this->conn->prepare($sql)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result; 
			}
			return NULL;
		}

		public function getGradeResultsPerPerson($userId, $year){
			$sql = "SELECT lab_journal.labjournaal_id, lab_journal.grade, lab_journal.title
                FROM users
                INNER JOIN lab_journal_users ON users.user_id = lab_journal_users.user_id
                INNER JOIN lab_journal ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
                WHERE users.user_id = ? AND lab_journal.year = $year";
			if ($stmt = $this->conn->prepare($sql)) {
				$stmt->bind_param("i", $userId);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
		}
		public function selectpdfcontentlabjournal($docid){
			if($stmt = $this->conn->prepare("SELECT * FROM `lab_journal` WHERE labjournaal_id = ?")){
					$stmt->bind_param("i", $docid);
					$stmt->execute();
					$result = $stmt->get_result();
					$stmt->free_result();
					$stmt->close();
					return $result;
				}
		}
		public function selectpdfcontentpreperation(){}

		// this still needs a join in lab-journaal-users
		public function LabjournaalToevoegen($title, $date, $theory, $safety, $creater_id, $logboek, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis){
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
			if ($stmt = $this->conn->prepare("INSERT INTO `lab_journal_users`(`user_id`, `lab_journal_id`) VALUES (?,?)")) {
                $stmt->bind_param('ii', $userId, $LabjournaalId);
				$stmt->execute();
				$stmt->close();
				return "Labjournaal toegevoegd";
			}
			return NULL;
		}

		public function updateUsersLanguage($userId, $language){
			if ($stmt = $this->conn->prepare("UPDATE `users` SET `lang`=? WHERE `user_id` = ?")) {
                $stmt->bind_param('si',  $language, $userId);
				$stmt->execute();
				$stmt->close();
				return "Labjournaal toegevoegd";
			}
			return NULL;
		}

		public function updateProfielFoto($UserID ,$profilePictureName){
			if ($stmt = $this->conn->prepare("UPDATE `users` SET `profile_picture` =? WHERE `user_id` = ?")) {
                $stmt->bind_param('si', $profilePictureName, $UserID);
				$stmt->execute();
				$stmt->close();
				return;
			}
			return NULL;
		}
	}
?>
