<?php 
	class Airport {
		private $id;
        private $icao;
		private $airport_name;
		private $city;
		private $state;
		private $iata;
		private $updatedBy;
		private $updatedOn;
		private $createdBy;
		private $createdOn;
		private $tableName = 'airports';
		private $dbConn;

		function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
        function setIcao($icao) { $this->icao = $icao; }
		function getIcao() { return $this->icao; }
		function setIata ($iata) { $this->iata = $iata; }
		function getIata() { return $this->iata; }
		function setAirportName($airport_name) { $this->airport_name = $airport_name; }
		function getAirportName() { return $this->airport_name; }
		function setState($state) { $this->state = $state;}
		function getState() {return $this->state;}
		function setEmail($email) { $this->email = $email; }
		function getEmail() { return $this->email; }
		function setAddress($address) { $this->address = $address; }
		function getAddress() { return $this->address; }
		function setMobile($mobile) { $this->mobile = $mobile; }
		function getMobile() { return $this->mobile; }
		function setUpdatedBy($updatedBy) { $this->updatedBy = $updatedBy; }
		function getUpdatedBy() { return $this->updatedBy; }
		function setUpdatedOn($updatedOn) { $this->updatedOn = $updatedOn; }
		function getUpdatedOn() { return $this->updatedOn; }
		function setCreatedBy($createdBy) { $this->createdBy = $createdBy; }
		function getCreatedBy() { return $this->createdBy; }
		function setCreatedOn($createdOn) { $this->createdOn = $createdOn; }
		function getCreatedOn() { return $this->createdOn; }

		public function __construct() {
			$db = new DbConnect();
			$this->dbConn = $db->connect();
		}

		public function getAllAirports() {
			$conn = $this->dbConn;
			$result = $conn->query("SELECT * FROM `airport`  ORDER BY `icao` ASC");
			return $result;
		}

		public function getAirportDetailsById() {

			$airportIcao = $this->icao;
			$conn = $this->dbConn;
		

			$result =$conn->query("SELECT * FROM `airport` WHERE `airport`.`icao` = $airportIcao ");
			
			

			return $result;
		}
		

		public function insert() {
			$name = $this->airport_name;
			$icao = $this->icao;
			$state = $this->state;
			$iata = $this->iata;
			// $createdBy = $this->createdBy;
			// $createdOn = $this->createdOn;
			// $tableName = $this->tableName;

			$conn = $this->dbConn;
			$result = $conn->query("INSERT INTO `airport` (`icao`, `name`, `state`, `iata`) VALUES('$icao','$name', '$state', '$iata') " );
			
			// return $result;
			if($result === TRUE) {
				return true;
			} else {
				// echo "Failed";
				return false;
			}
		}

		public function update() {
			$name = $this->getAirPortName();
			$icao = $this->getIcao();
			$state = $this->getState();
			$iata = $this->getIata();
			// $mobile = (int)$mobile;
			// $updatedOn =$this->updatedOn;
			// $updatedBy = $this->updatedBy;
			// $updatedBy = '2';
			// $userId = $this->id;
			$conn = $this->dbConn;
			
			$result = $conn->query("UPDATE `airport` SET `name` = '$name', `state` = '$state', `icao` = '$icao', `iata` = '$iata' WHERE `airport`.`icao` = $icao ");
			if($result) {
				return true;
			} else {
				return false;
			}
		}


		

		public function delete() {
			
			$icao = $this->icao;
			$conn = $this->dbConn;
			$result = $conn->query("DELETE FROM `airport` WHERE `icao` = $icao");
			
			if($result) {
				return true;
			} else {
				return false;
			}
		}
	}
 ?>