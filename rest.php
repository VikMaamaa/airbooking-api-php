<?php 

    require_once('constants.php');
    class Rest {
        protected $request;
        protected $serviceName;
        protected $param;

        public function __construct()
        {
            if($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->throwError('REQUEST_METHOD_NOT_VALID', 'Request method is not valid');
            }
            $handler = fopen('php://input', 'r');
            $this->request=  stream_get_contents($handler);
            $this->validateRequest($this->request);
        }

        public function validateRequest() {
            if($_SERVER['CONTENT_TYPE'] !== 'application/json') {
                $this->throwError('REQUEST_CONTENT_TYPE_NOT_VALID', 'Request content type is not valid');
            }

            $data = json_decode($this->request, true);
            if(!isset($data['name']) || $data['name'] == "") {
                $this->throwError(API_NAME_REQUIRED, "API name required");
            }
            $this->serviceName = $data['name'];

            if(!is_array($data['param'])) {
                $this->throwError(API_PARAM_REQUIRED, "API PARAM required");
            }
            $this->param = $data['param'];
        }

        public function processApi() {
            $api = new API;
            $rMethod = new ReflectionMethod('API', $this->serviceName);
            if(!method_exists($api, $this->serviceName)) {
                $this->throwError(API_DOES_NOT_EXIST, "API does not exist.");
            }
            $rMethod->invoke($api);
        }

        public function validateParameter($fieldName, $value, $dataType, $required = true) {
            if($required == true && empty($value) == true) {
                $this->throwError(VALIDATE_PARAMETER_REQUIRED, $fieldName. " Parameter is required");
            }

            switch ($dataType) {
                case 'BOOLEAN':
                    if(!is_bool($value)) {
                        $this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for ".$fieldName.'. It should be boolean');
                    }
                    break;
                case 'INTEGER':
                    if(!is_numeric($value)) {
                            $this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for ".$fieldName . '. It should be numeric');
                    }
                        break;
                case 'STRING':
                    if(!is_string($value)) {
                        $this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for ".$fieldName.'. It should be string');
                    }
                    break;          
                default:
                // $this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName);
                    break;
            }

            return $value;
        }

        public function throwError($code, $message) {
            header("content-type: application/json");
            $errorMsg = json_encode(['error'=>['status'=> $code, 'message'=>$message]]);
            echo $errorMsg; exit;
        }

        public function returnResponse($code, $data) {
            header("content-type: application/json");
            $response = json_encode(['response' => ['status' => $code, 'result' => $data]]);
            
            echo $response; exit;
        }


        /**
	    * Get hearder Authorization
	    * */
	    public function getAuthorizationHeader(){
	        $headers = null;
	        if (isset($_SERVER['Authorization'])) {
	            $headers = trim($_SERVER["Authorization"]);
	        }
	        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
	            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
	        } elseif (function_exists('apache_request_headers')) {
	            $requestHeaders = apache_request_headers();
	            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
	            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
	            if (isset($requestHeaders['Authorization'])) {
	                $headers = trim($requestHeaders['Authorization']);
	            }
	        }
	        return $headers;
	    }
	    /**
	     * get access token from header
	     * */
	    public function getBearerToken() {
	        $headers = $this->getAuthorizationHeader();
	        // HEADER: Get the access token from the header
	        if (!empty($headers)) {
	            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	                return $matches[1];
	            }
	        }
	        $this->throwError( AUTHORIZATION_HEADER_NOT_FOUND, 'Access Token Not found');
	    }
    }

?>