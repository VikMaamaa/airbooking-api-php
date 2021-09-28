<?php 

	class Api extends Rest {
		
		public function __construct() {
			parent::__construct();
            $db = new DbConnect();
			$this->dbConn = $db->connect();
		}
        private $dbConn;

        //Airport
        public function addAirport() {

			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
                // var_dump($result);
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['role'] == "admin") ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not an Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			$name = $this->validateParameter('airportName', $this->param['airportName'], STRING, false);
			$icao = $this->validateParameter('icao', $this->param['icao'], STRING, false);
			$state = $this->validateParameter('addr', $this->param['state'], STRING, false);
			$iata = $this->validateParameter('mobile', $this->param['iata'], INTEGER, false);

			$air = new Airport;
			$air->setAirportName($name);
			$air->setState($state);
			$air->setIata($iata);
			$air->setIcao($icao);

			if(!$air->insert()) {
				$message = 'Failed to insert.';
			} else {
				$message = "Inserted successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

        public function getAirportDetails() {
			$icao = $this->validateParameter('icao', $this->param['icao'], INTEGER);

			$air = new Airport;
			$air->setIcao($icao);
			$air = $air->getAirportDetailsById();
            

          if(!(gettype($air) == "object")) {
            $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Airport not found.']);
        }
            $air  =$air->fetch_assoc();
            
            $response['icao'] 	= $air['icao'];
			$response['state'] 	= $air['state'];
			$response['airportName'] 	= $air['name'];
			$response['iata'] 		= $air['iata'];
			
			$this->returnResponse(SUCCESS_RESPONSE, $response);
		}

        public function getAllAirports() {
			$air = new Airport;
			
			$air = $air->getAllAirports();
            
            $res = [];
        

          if(!(gettype($air) == "object")) {
            $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Airports not found.']);
        }
            
            while($fetch=$air->fetch_array()) {
            $response['icao'] 	= $fetch['icao'];
			$response['state'] 	= $fetch['state'];
			$response['airportName'] 	= $fetch['name'];
			$response['iata'] 		= $fetch['iata'];
            
            array_push($res,$response);
            }
      
			$this->returnResponse(SUCCESS_RESPONSE, $res);
		}


        public function updateAirport() {

			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
                // var_dump($result);
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['role'] == "admin") ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not an Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			$name = $this->validateParameter('airportName', $this->param['airportName'], STRING, false);
			$icao = $this->validateParameter('icao', $this->param['icao'], STRING, false);
			$state = $this->validateParameter('addr', $this->param['state'], STRING, false);
			$iata = $this->validateParameter('mobile', $this->param['iata'], INTEGER, false);

			$air = new Airport;
			$air->setAirportName($name);
			$air->setState($state);
			$air->setIata($iata);
			$air->setIcao($icao);

			if(!$air->update()) {
				$message = 'Failed to update.';
			} else {
				$message = "Updated successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

        public function deleteAirport() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
                // var_dump($result);
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['role'] == "admin") ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not an Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			$icao = $this->validateParameter('icao', $this->param['icao'], STRING, false);

			$air = new Airport;
			$air->setIcao($icao);

			if(!$air->delete()) {
				$message = 'Failed to delete.';
			} else {
				$message = "deleted successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}


        //Flights
        public function addFlight() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
                // var_dump($result);
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['role'] == "admin") ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not an Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			$departure = $this->validateParameter('departure', $this->param['departure'], STRING, false);
			$destination = $this->validateParameter('destination', $this->param['destination'], STRING, false);
			$seats = $this->validateParameter('seats', $this->param['seats'], STRING, false);
			$price = $this->validateParameter('price', $this->param['price'], STRING, false);
            $date = $this->validateParameter('date', $this->param['date'], STRING, false);
            $time = $this->validateParameter('time', $this->param['time'], STRING, false);
            $icao = $this->validateParameter('icao', $this->param['icao'], STRING, false);
            $status = $this->validateParameter('status', $this->param['status'], STRING, false);

			$air = new Flight;
			$air->setDeparture($departure);
			$air->setDestination($destination);
			$air->setSeats($seats);
            $air->setPrice($price);
            $air->setDate($date);
            $air->setTime($time);
			$air->setIcao($icao);
            $air->setStatus($status);
			

			if(!$air->insert()) {
				$message = 'Failed to insert.';
			} else {
				$message = "Inserted successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

        public function getFlightDetails() {
			
			$flightId = $this->validateParameter('flightId', $this->param['flightId'], INTEGER);

			$flight = new Flight;
			$flight->setId($flightId);
			$flight = $flight->getFlightDetailsById();
            

          if(!(gettype($flight) == "object")) {
            $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Flight not found.']);
        }
            $flight  =$flight->fetch_assoc();
            
            $response['flightId'] 	= $flight['flight_id'];
			$response['departure'] 	= $flight['departure'];
			$response['destination'] 	= $flight['destination'];
			$response['seats'] 		= $flight['seats'];
            $response['price'] 		= $flight['price'];
            $response['date'] 		= $flight['date'];
            $response['time'] 		= $flight['time'];
            $response['icao'] 		= $flight['icao'];
            $response['status'] 		= $flight['status'];
       
			$this->returnResponse(SUCCESS_RESPONSE, $response);
		}

        public function getAllFlights() {
			$air = new Flight;
			
			$air = $air->getAllFlights();
            $res = [];

          if(!(gettype($air) == "object")) {
            $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Flights not found.']);
        }
            
            while($flight=$air->fetch_array()) {
                $response['flightId'] 	= $flight['flight_id'];
                $response['departure'] 	= $flight['departure'];
                $response['destination'] 	= $flight['destination'];
                $response['seats'] 		= $flight['seats'];
                $response['price'] 		= $flight['price'];
                $response['date'] 		= $flight['date'];
                $response['time'] 		= $flight['time'];
                $response['icao'] 		= $flight['icao'];
                $response['status'] 		= $flight['status'];
            array_push($res,$response);
            }
			
			$this->returnResponse(SUCCESS_RESPONSE, $res);
		}

        public function updateFlight() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
                // var_dump($result);
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['role'] == "admin") ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not an Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
            $flightId = $this->validateParameter('flightId', $this->param['flightId'], INTEGER);
			$departure = $this->validateParameter('departure', $this->param['departure'], STRING, false);
			$destination = $this->validateParameter('destination', $this->param['destination'], STRING, false);
			$seats = $this->validateParameter('seats', $this->param['seats'], STRING, false);
			$price = $this->validateParameter('price', $this->param['price'], STRING, false);
            $date = $this->validateParameter('date', $this->param['date'], STRING, false);
            $time = $this->validateParameter('time', $this->param['time'], STRING, false);
            $icao = $this->validateParameter('icao', $this->param['icao'], STRING, false);
            $status = $this->validateParameter('status', $this->param['status'], STRING, false);

			$air = new Flight;
            $air->setId($flightId);
			$air->setDeparture($departure);
			$air->setDestination($destination);
			$air->setSeats($seats);
            $air->setPrice($price);
            $air->setDate($date);
            $air->setTime($time);
			$air->setIcao($icao);
            $air->setStatus($status);

			if(!$air->update()) {
				$message = 'Failed to update.';
			} else {
				$message = "Updated successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

        public function deleteFlight() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
                // var_dump($result);
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['role'] == "admin") ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not an Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			$flightId = $this->validateParameter('flightId', $this->param['flightId'], STRING, false);

			$air = new Flight;
			$air->setId($flightId);

			if(!$air->delete()) {
				$message = 'Failed to delete.';
			} else {
				$message = "deleted successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

		//Bookings
		public function addBooking() {


			$flightId = $this->validateParameter('flightId', $this->param['flightId'], STRING, false);
			$flightType = $this->validateParameter('flightType', $this->param['flightType'], STRING, false);
			// $seatNumber = $this->validateParameter('seatNumber', $this->param['seatNumber'], STRING, false);
			$fullName = $this->validateParameter('fullName', $this->param['fullName'], STRING, false);
            $dob = $this->validateParameter('dateOfBirth', $this->param['dateOfBirth'], STRING, false);
            $phone = $this->validateParameter('phoneNumber', $this->param['phoneNumber'], STRING, false);
            
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;
				$bookedBy = $id;
				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`, `role`, `active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
                // var_dump($result);
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( $user['role'] == "admin" ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not allowed to book");
				}


				$result = $conn->query("SELECT `seats` FROM `flights` WHERE `flight_id` = '".$flightId."'");
				$data = $result->fetch_assoc();
				if($data['seats'] == 0) {
					$this->returnResponse(SUCCESS_RESPONSE, "No seats available");
				}

				$seatLeft = $data['seats'];
				$seatNumber = $seatLeft;
				$book = new Booking;
				$book->setFlightId($flightId);
				$book->setTof($flightType);
				$book->setSeatNumber($seatNumber);
				$book->setFullName($fullName);
				$book->setDob($dob);
				$book->setPhone($phone);
				$book->setBookedBy($bookedBy);
				

				if(!$book->insert()) {
					$message = 'Failed to insert.';
				} else {
					$seatLeft -=1;
					if($conn->query("UPDATE `flights` SET `seats` = '".$seatLeft."' WHERE `flights`.`flight_id` = '".$flightId."'")){
						$message = "Inserted successfully.";
					}else{
						$message = 'Failed to insert.';
					}
					
				}

				$this->returnResponse(SUCCESS_RESPONSE, $message);
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			
		}

		public function getBookingDetails() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
               
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['active'] == 1) ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not activated. Please contact the Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			$bookingId = $this->validateParameter('bookingId', $this->param['bookingId'], INTEGER);

			$flight = new Booking;
			$flight->setId($bookingId);
			$flight = $flight->getBookingDetailsById();
            

          if(!(gettype($flight) == "object")) {
            $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Flight not found.']);
        }
            $flightR  =$flight->fetch_assoc();
            
            $response['flightId'] 	= $flightR['flight_id'];
			$response['bookingId'] 	= $flightR['booking_id'];
			$response['flightType'] 	= $flightR['type_of_flight'];
			$response['seatNumber'] 		= $flightR['seat_number'];
            $response['fullName'] 		= $flightR['full_name'];
            $response['dateOfBirth'] 		= $flightR['date_of_birth'];
            $response['phoneNumber'] 		= $flightR['phone_no'];
            $response['bookedBy'] 		= $flightR['booked_by'];
       
			$this->returnResponse(SUCCESS_RESPONSE, $response);
		}

		public function getAllBookings() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
               
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['active'] == 1) ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not activated. Please contact the Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			$air = new Booking;
			// $air->setId($customerId);
			$air = $air->getAllBookings();
            $res = [];
			
          if(!(gettype($air) == "object")) {
            $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Bookings not found.']);
        }
            
            while($flight=$air->fetch_array()) {
                $response['flightId'] 	= $flight['flight_id'];
			$response['bookingId'] 	= $flight['booking_id'];
			$response['flightType'] 	= $flight['type_of_flight'];
			$response['seatNumber'] 		= $flight['seat_number'];
            $response['fullName'] 		= $flight['full_name'];
            $response['dateOfBirth'] 		= $flight['date_of_birth'];
            $response['phoneNumber'] 		= $flight['phone_no'];
            $response['bookedBy'] 		= $flight['booked_by'];
            array_push($res,$response);
            }
        
			$this->returnResponse(SUCCESS_RESPONSE, $res);
		}

		public function updateBooking() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
               
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['active'] == 1) ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not activated. Please contact the Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			$bookingId = $this->validateParameter('bookingId', $this->param['bookingId'], INTEGER);
            $flightId = $this->validateParameter('flightId', $this->param['flightId'], STRING, false);
			$flightType = $this->validateParameter('flightType', $this->param['flightType'], STRING, false);
			$seatNumber = $this->validateParameter('seatNumber', $this->param['seatNumber'], STRING, false);
			$fullName = $this->validateParameter('fullName', $this->param['fullName'], STRING, false);
            $dob = $this->validateParameter('dateOfBirth', $this->param['dateOfBirth'], STRING, false);
            $phone = $this->validateParameter('phoneNumber', $this->param['phoneNumber'], STRING, false);
            $bookedBy = $this->validateParameter('bookedBy', $this->param['bookedBy'], STRING, false);
            // $status = $this->validateParameter('status', $this->param['status'], STRING, false);

			$book = new Booking;
			$book->setId($bookingId);
			$book->setFlightId($flightId);
			$book->setTof($flightType);
			$book->setSeatNumber($seatNumber);
            $book->setFullName($fullName);
            $book->setDob($dob);
            $book->setPhone($phone);
			$book->setBookedBy($bookedBy);

			if(!$book->update()) {
				$message = 'Failed to update.';
			} else {
				$message = "Updated successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

		public function getAllUserBookings() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
               
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['active'] == 1) ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not activated. Please contact the Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			$bookedBy = $this->validateParameter('bookedBy', $this->param['bookedBy'], INTEGER);

			$flightI = new Booking;
			$flightI->setBookedBy($bookedBy);
			$air = $flightI->getAllUserBooking();
            
			// var_dump($air);
          if(!(gettype($air) == "object")) {
            $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Bookings not found.']);
        }

			if(!($air->num_rows > 0)) {
				$this->returnResponse(SUCCESS_RESPONSE, ['message' => 'User has no Booking.']);
			}
           $res = [];
			while($flight=$air->fetch_array()) {
                $response['flightId'] 	= $flight['flight_id'];
			$response['bookingId'] 	= $flight['booking_id'];
			$response['flightType'] 	= $flight['type_of_flight'];
			$response['seatNumber'] 		= $flight['seat_number'];
            $response['fullName'] 		= $flight['full_name'];
            $response['dateOfBirth'] 		= $flight['date_of_birth'];
            $response['phoneNumber'] 		= $flight['phone_no'];
            $response['bookedBy'] 		= $flight['booked_by'];
            array_push($res,$response);
            }
        
			$this->returnResponse(SUCCESS_RESPONSE, $res);
       
			$this->returnResponse(SUCCESS_RESPONSE, $response);
		}

		public function deleteBooking() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
               
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['active'] == 1) ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not activated. Please contact the Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			// $flightId = $this->validateParameter('flightId', $this->param['flightId'], STRING, false);
			$bookingId = $this->validateParameter('bookingId', $this->param['bookingId'], INTEGER);

			$air = new Booking;
			$air->setId($bookingId);

			if(!$air->delete()) {
				$message = 'Failed to delete.';
			} else {
				$message = "deleted successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}


		//User
		public function addUser() {

			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
                // var_dump($result);
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['role'] == "admin") ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not an Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			
			$email = $this->validateParameter('email', $this->param['email'], STRING, false);
			$password = $this->validateParameter('password', $this->param['password'], STRING, false);
			$role = $this->validateParameter('role', $this->param['role'], INTEGER, false);
			
	
			$cust = new User;
			
			$cust->setEmail($email);
			$cust->setPassword($password);
			$cust->setRole($role);
			$cust->setActive("1");
			$cust->setCreatedOn(date('Y-m-d'));
	
			if(!$cust->insert()) {
				$message = 'Failed to insert.';
			} else {
				$message = "Inserted successfully.";
			}
	
			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

		public function register() {
			
			$email = $this->validateParameter('email', $this->param['email'], STRING, false);
			$password = $this->validateParameter('password', $this->param['password'], STRING, false);
			$role = "user";
	
			$cust = new User;
			$cust->setEmail($email);
			$cust->setPassword($password);
			$cust->setRole($role);
			$cust->setActive("1");
			$cust->setCreatedOn(date('Y-m-d'));
	
			if(!$cust->insert()) {
				$message = 'Failed to insert.';
			} else {
				$message = "Inserted successfully.";
			}
	
			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

		public function login() {
			$email = $this->validateParameter('email', $this->param['email'], STRING);
			$pass = $this->validateParameter('pass', $this->param['pass'], STRING);
			try {
				$conn = $this->dbConn;
				
				$result = $conn->query("SELECT `id`, `email`,`role` ,`password`, `active`, `created_on` FROM `users` WHERE `email` = '".$email."' AND `password` = '".$pass."'");
                
                // var_dump($result);
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( $user['active'] == 0 ) {
					$this->returnResponse(USER_NOT_ACTIVE, "User is not activated. Please contact to admin.");
				}

				$paylod = [
					'iat' => time(),
					'iss' => 'localhost',
					'exp' => time() + (24*60*60),
					'userId' => $user['id']
				];

				$token = JWT::encode($paylod, SECRET_KEY);
				
				$data = ['token' => $token];
				$this->returnResponse(SUCCESS_RESPONSE, $data);
			} catch (Exception $e) {
				$this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
			}
		}

		public function getUserDetails() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
               
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['active'] == 1) ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not activated. Contact the Admin for more info");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			$userId = $this->validateParameter('userId', $this->param['userId'], INTEGER);
	
			$flight = new User;
			$flight->setId($userId);
			$flight = $flight->getUserDetailsById();
			
	
		  if(!(gettype($flight) == "object")) {
			$this->returnResponse(SUCCESS_RESPONSE, ['message' => 'User not found.']);
		}

		if(!($flight->num_rows > 0)) {
			$this->returnResponse(SUCCESS_RESPONSE, ['message' => 'User does not exists.']);
		}
			$flightR  =$flight->fetch_assoc();
			
			$response['userId'] 	= $flightR['id'];
			$response['email'] 	= $flightR['email'];
			$response['role'] 	= $flightR['role'];
	   
			$this->returnResponse(SUCCESS_RESPONSE, $response);
		}

		public function getAllUsers() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
               
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['role'] == "admin") ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not an Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}


			$air = new User;
			$air = $air->getAllUsers();
            $res = [];
			
          if(!(gettype($air) == "object")) {
            $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Bookings not found.']);
        }
            
            while($flight=$air->fetch_array()) {
				$response['userId'] 	= $flight['id'];
				$response['email'] 	= $flight['email'];
				$response['role'] 	= $flight['role'];
            array_push($res,$response);
            }
        
			$this->returnResponse(SUCCESS_RESPONSE, $res);
		}

		public function updateUserByAdmin() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
                // var_dump($result);
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['role'] == "admin") ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not an Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			$email = $this->validateParameter('email', $this->param['email'], STRING, false);
			$password = $this->validateParameter('password', $this->param['password'], STRING, false);
			$role = $this->validateParameter('role', $this->param['role'], INTEGER, false);
			$id = $this->validateParameter('userId', $this->param['userId'], INTEGER, false);
			
			$cust = new User;
			$cust->setId($id);
			$cust->setEmail($email);
			$cust->setPassword($password);
			$cust->setRole($role);
			$cust->setActive("1");
			$cust->setCreatedOn(date('Y-m-d'));

			if(!$cust->update()) {
				$message = 'Failed to update.';
			} else {
				$message = "Updated successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

		public function updateUserByUser() {
			$email = $this->validateParameter('email', $this->param['email'], STRING, false);
			$password = $this->validateParameter('password', $this->param['password'], STRING, false);
			$id = $this->validateParameter('userId', $this->param['userId'], INTEGER, false);
			$role = "user";
	
			$cust = new User;
			$cust->setId($id);
			$cust->setEmail($email);
			$cust->setPassword($password);
			$cust->setRole($role);
			$cust->setActive("1");
			$cust->setCreatedOn(date('Y-m-d'));

			if(!$cust->update()) {
				$message = 'Failed to update.';
			} else {
				$message = "Updated successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}


		
		public function deleteUser() {
			try{
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRET_KEY, ['HS256']);
				
				$id = $payload->userId;

				$conn = $this->dbConn;
				$result = $conn->query("SELECT `id`, `email`, `password`,`role` ,`active`, `created_on` FROM `users` WHERE `id` = '".$id."'");
                
               
				if (!($result->num_rows > 0)) {
					$this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
				}
                $user = $result->fetch_assoc();
				if( !($user['role'] == "admin") ) {
					$this->returnResponse(USER_NOT_ACTIVE, "You are not an Admin");
				}
			}catch(Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
			
			$userId = $this->validateParameter('userId', $this->param['userId'], INTEGER);

			$air = new User;
			$air->setId($userId);

			if(!$air->delete()) {
				$message = 'Failed to delete.';
			} else {
				$message = "deleted successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}
	}
	


 ?>