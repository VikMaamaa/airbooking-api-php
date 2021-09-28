<?php 
	class Booking {
		private $id;
		private $bookedBy;
		private $flightId;
		private $seatNumber;
		private $fullName;
		private $dob;
		private $phone;
		private $tof;
		// private $createdOn;
		private $tableName = 'bookings';
		private $dbConn;

		function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
		function setTof($tof) { $this->tof = $tof; }
		function getTof() { return $this->tof; }
		function setBookedBy($bookedBy) { $this->bookedBy = $bookedBy; }
		function getBookedBy() { return $this->bookedBy; }
		function setFlightId($flightId) { $this->flightId = $flightId; }
		function getFlightId() { return $this->flightId; }
		function setSeatNumber($seatNumber) { $this->seatNumber = $seatNumber; }
		function getSeatNumber() { return $this->seatNumber; }
		function setFullName($fullName) { $this->fullName = $fullName; }
		function getFullName() { return $this->fullName; }
		function setDob($dob) { $this->dob = $dob; }
		function getDob() { return $this->dob; }
		function setPhone($phone) { $this->phone = $phone; }
		function getPhone() { return $this->phone; }
		function setCreatedOn($createdOn) { $this->createdOn = $createdOn; }
		function getCreatedOn() { return $this->createdOn; }

		public function __construct() {
			$db = new DbConnect();
			$this->dbConn = $db->connect();
		}

		public function getAllBookings() {
			$conn = $this->dbConn;
			$result = $conn->query("SELECT * FROM `booking`  ORDER BY `booking_id` ASC");
			return $result;
		}

		public function getBookingDetailsById() {

			$bookingId = $this->id;
			$conn = $this->dbConn;
		

			$result =$conn->query("SELECT * FROM `booking`  WHERE `booking`.`booking_id` = $bookingId ");
			
			

			return $result;
		}

		public function getAllUserBooking() {

			$bookedBy = $this->bookedBy;
			$conn = $this->dbConn;
		

			$result =$conn->query("SELECT * FROM `booking`  WHERE `booking`.`booked_by` = $bookedBy ");
			
			

			return $result;
		}
		

		public function insert() {
			$tof = $this->tof;
			$bookedBy = $this->bookedBy;
			$flightId = $this->flightId;
			$seatNumber = $this->seatNumber;
			$fullName = $this->fullName;
			$dob = $this->dob;
			$phone = $this->phone;
			$createdOn = $this->createdOn;
			$tableName = $this->tableName;

			$conn = $this->dbConn;
			$result = $conn->query("INSERT INTO `booking` (`booking_id`, `flight_id`, `type_of_flight`, `seat_number`, `full_name`, `date_of_birth`, `phone_no`, `booked_by`) VALUES(NULL,'$flightId','$tof',  '$seatNumber','$fullName','$dob','$phone','$bookedBy')");
			// $result = $conn->query("INSERT INTO `booking` (`booking_id`, `flight_id`, `type_of_flight`, `seat_number`, `full_name`, `date_of_birth`, `phone_no`, `booked_by`) VALUES (NULL, '$flightId', '$tof', '$seatNumber', 'test', '30 dec', '090', '1')");
			// return $result;
			if($result === TRUE) {
				return true;
			} else {
				// echo "Failed";
				return false;
			}
		}

		public function update() {
			$tof = $this->tof;
			$bookedBy = $this->bookedBy;
			$flightId = $this->flightId;
			$seatNumber = $this->seatNumber;
			$fullName = $this->fullName;
			$dob = $this->dob;
			$phone = $this->phone;
			$bookingId = $this->id;
			$conn = $this->dbConn;
			
			$result = $conn->query("UPDATE `booking` SET `flight_id` = '$flightId', `type_of_flight` = '$tof', `seat_number` = '$seatNumber', `full_name` = '$fullName', `date_of_birth` = '$dob', `phone_no` = '$phone',`booked_by`='$bookedBy' WHERE `booking`.`booking_id` = $bookingId ");
			if($result) {
				return true;
			} else {
				return false;
			}
		}


		

		public function delete() {
			
			$bookingId = $this->id;
			$conn = $this->dbConn;
			$result = $conn->query("DELETE FROM `booking` WHERE `booking_id` = $bookingId");
			
			if($result) {
				return true;
			} else {
				return false;
			}
		}
	}
 ?>