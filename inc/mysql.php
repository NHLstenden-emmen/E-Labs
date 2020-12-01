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
			// include the env file agina
			$env = include '.env.php';
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

		// 	$selectAllUsers = $db->selectAllUsers("student");
		// while ($result = $selectAllUsers->fetch_array(MYSQLI_ASSOC)){
		// 	echo  $result['name'];
		// }
		public function selectAllUsers($role){
			// this gets all the users and returns them
			if ($stmt = $this->conn->prepare("SELECT * FROM `users` WHERE `role` = ?")) {
				$stmt->bind_param("s", $role);
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

		public function login($username, $password){
			if ($stmt = $this->conn->prepare("select * from users where name = ? && password = ?")) {
				$stmt->bind_param("ss", $username, $password);
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
