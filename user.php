<?php 
	class User {
		private $id;
        private $user_id;
		// private $name;
		private $email;
        private $role;
		private $password;
		private $active;
		// private $active;
		// private $updatedOn;
		// private $createdBy;
		private $createdOn;
		private $tableName = 'users';
		private $dbConn;

		function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
		// function setName($name) { $this->name = $name; }
		// function getName() { return $this->name; }
		function setEmail($email) { $this->email = $email; }
		function getEmail() { return $this->email; }
		function setPassword($password) { $this->password = $password; }
		function getPassword() { return $this->password; }
		function setRole($role) { $this->role = $role; }
		function getRole() { return $this->role; }
		function setActive($active) { $this->active = $active; }
		function getActive() { return $this->active; }
		// function setUpdatedOn($updatedOn) { $this->updatedOn = $updatedOn; }
		// function getUpdatedOn() { return $this->updatedOn; }
		// function setCreatedBy($createdBy) { $this->createdBy = $createdBy; }
		// function getCreatedBy() { return $this->createdBy; }
		function setCreatedOn($createdOn) { $this->createdOn = $createdOn; }
		function getCreatedOn() { return $this->createdOn; }

		public function __construct() {
			$db = new DbConnect();
			$this->dbConn = $db->connect();
		}

		public function getAllUsers() {
			$conn = $this->dbConn;
			$result = $conn->query("SELECT * FROM `users`  ORDER BY `id` ASC");
			return $result;
		}

		public function getUserDetailsById() {

			$id = $this->id;
			$conn = $this->dbConn;
		

			$result =$conn->query("SELECT * FROM `users`  WHERE `id` = $id ");
			
			

			return $result;
		}
		

		public function insert() {
			// $name = $this->name;
			$email = $this->email;
			$password = $this->password;
			$role = $this->role;
			$active = $this->active;
			// $createdBy = $this->createdBy;
			$createdOn = $this->createdOn;
			$tableName = $this->tableName;

			$conn = $this->dbConn;
			$result = $conn->query("INSERT INTO `users` (`id`,  `email`, `password`, `role`,  `active`, `created_on`) VALUES(NULL,'$email', '$password', '$role','$active','$createdOn') " );
			// $result = $conn->query("INSERT INTO `users` (`id`, `email`, `password`, `role`, `active`, `created_on`) VALUES (NULL, 'victor1@example.com', 'pass123', 'admin', '1', '2021-08-28')");
			// return $result;
			if($result === TRUE) {
				return true;
			} else {
				// echo "Failed";
				return false;
			}
		}

		public function update() {
			
		
			// $name = $this->getName();
			$password = $this->getPassword();
			$role = $this->getRole();
			$email = $this->email;
			$active = $this->getActive();
			// $role = (int)$role;
			$createdOn =$this->createdOn;
			// $active = $this->getActive;
			// $active = '2';
			$userId = $this->id;
			$conn = $this->dbConn;
			
			$result = $conn->query("UPDATE `users` SET  `email` = '$email', `password` = '$password', `role` = '$role', `active` = '$active', `created_on` = '$createdOn' WHERE `users`.`id` = $userId ");
			if($result) {
				return true;
			} else {
				return false;
			}
		}


		

		public function delete() {
			
			$userId = $this->id;
			$conn = $this->dbConn;
			$result = $conn->query("DELETE FROM `users` WHERE `id` = $userId");
			
			if($result) {
				return true;
			} else {
				return false;
			}
		}
	}
 ?>