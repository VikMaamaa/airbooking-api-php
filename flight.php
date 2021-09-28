<?php 
	class Flight {
		private $id;
        private $flight_id;
		private $departure_time;
		private $time;
		private $departure;
		private $destination;
		private $icao;
		private $price;
		private $date;
		private $status;
		private $tableName = 'flights';
		private $dbConn;

		function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
		function setDeparture($departure) { $this->departure = $departure; }
		function getDeparture() { return $this->departure; }
		function setDestination($destination) { $this->destination = $destination; }
		function getDestination() { return $this->destination; }
		function setSeats($seats) { $this->seats = $seats; }
		function getSeats() { return $this->seats; }
		function setPrice($price) { $this->price = $price; }
		function getPrice() { return $this->price; }
		function setDate($date) { $this->date = $date; }
		function getDate() { return $this->date; }
		function setTime($time) { $this->time = $time; }
		function getTime() { return $this->time; }
		function setStatus($status) { $this->status = $status; }
		function getStatus() { return $this->status; }
		function setIcao($icao) { $this->icao = $icao; }
		function getIcao() { return $this->icao; }

		public function __construct() {
			$db = new DbConnect();
			$this->dbConn = $db->connect();
		}

		public function getAllFlights() {
			$conn = $this->dbConn;
			$result = $conn->query("SELECT * FROM `flights`  ORDER BY `flight_id` ASC");
			return $result;
		}

		public function getFlightDetailsById() {

			$flight_id = $this->id;
			$conn = $this->dbConn;
		

			$result =$conn->query("SELECT * FROM `flights`  WHERE `flights`.`flight_id` = $flight_id ");
			
			

			return $result;
		}
		

		public function insert() {
			$departure = $this->departure;
			$destination = $this->destination;
			$seats = $this->seats;
			$price = $this->price;
			$date = $this->date;
			$time = $this->time;
			$status = $this->status;
			$icao = $this->icao;
			$tableName = $this->tableName;

			$conn = $this->dbConn;
			$result = $conn->query("INSERT INTO `flights` (`flight_id`, `departure`, `destination`, `seats`, `price`,  `date`,`time`, `icao`,`status`) VALUES(NULL,'$departure','$destination', '$seats', '$price', '$date','$time','$icao','$status') " );
			
			// return $result;
			if($result === TRUE) {
				return true;
			} else {
				// echo "Failed";
				return false;
			}
		}

		public function update() {
			
			$flight_id = $this->getId();
			$departure = $this->getDeparture();
			$destination = $this->getDestination();
			$seats = $this->getSeats();
			$price = $this->getPrice();
			$date = $this->getDate();
			$time = $this->getTime();
			$icao = $this->getIcao();
			$status = $this->getStatus();
			$destination = $this->destination;
			// $price = (int)$price;
			$time =$this->time;
			$date = $this->date;
			// $date = '2';
			$userId = $this->id;
			$conn = $this->dbConn;
			
			$result = $conn->query("UPDATE `flights` SET `departure` = '$departure', `destination` = '$destination', `seats` = '$seats', `price` = '$price', `date` = '$date', `time` = '$time', `icao` = '$icao', `status` = '$status' WHERE `flights`.`flight_id` = $flight_id ");
			if($result) {
				return true;
			} else {
				return false;
			}
		}


		

		public function delete() {
			
			$flight_id = $this->id;
			$conn = $this->dbConn;
			$result = $conn->query("DELETE FROM `flights` WHERE `flight_id` = $flight_id");
			
			if($result) {
				return true;
			} else {
				return false;
			}
		}
	}
 ?>