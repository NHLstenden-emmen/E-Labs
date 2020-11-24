<?php
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
	
		public function selectAllFromStudenten(){
			if ($stmt = $this->conn->prepare("SELECT * FROM student")) {
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->free_result();
				$stmt->close();
				return $result;
			}
			return NULL;
		}

		public function selectAllFromStudentensWhereStudentID($column){
			if ($stmt = $this->conn->prepare("SELECT * FROM student WHERE StudentID = ?")) {
				$stmt->bind_param("i", $column);
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

<?php
	//examples for the mysql select queries

	// $selectAllFromStudenten = $db->selectAllFromStudenten();
	// while ($result = $selectAllFromStudenten->fetch_array(MYSQLI_ASSOC)){
	// 	// print_r($result);
	// 	echo  "<br> all names " .$result['surname'];
	// }

	
	// $selectAllFromStudentensWhereStudentID = $db->selectAllFromStudentensWhereStudentID("100");
	// while ($result = $selectAllFromStudentensWhereStudentID->fetch_array(MYSQLI_ASSOC)){
	// 	// print_r($result); 
	// 	echo "<br> name of student id 100 " . $result["firstname"];
	// }
?>