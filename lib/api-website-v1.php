<?php

////////////////////////////////////////////////////////////////////////////////////////////////
//													Mapaprop PHP api websites v1
//										http://www.mapaprop.com/ayuda/?page_id=2073
////////////////////////////////////////////////////////////////////////////////////////////////
class MapapropAPI {
	
	public $VERSION= "1";
// 	private $url = "https://gestion.mapaprop.com/action/api-website-v1/";
	private $URL = "https://localhost:8443/action/api-website-v1/";
	
	
////////////////////////////////////////////////////////////////////////////////////////////////
//																		public methods
////////////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	 * @doc http://www.mapaprop.com/ayuda/?page_id=2136
	 */
	public function queryZones() {
		$fields = array(
				'token'=>MAPAPROP_TOKEN,
		);
		return $this->post('query-zones', $fields);
	}

	/**
	 * @doc http://www.mapaprop.com/ayuda/?page_id=2128
	 */
	public function queryFeatured() {
		$fields = array(
				'token'=>MAPAPROP_TOKEN,
		);
		return $this->post('query-featured', $fields);
	}

	/**
	 * @doc http://www.mapaprop.com/ayuda/?page_id=2138
	 * @param unknown $code
	 */
	public function queryProperty($code) {
		$fields = array(
				'token'=>MAPAPROP_TOKEN,
				'code'=>$code
		);
		return $this->post('query-property', $fields);
	}

	/**
	 * @doc http://www.mapaprop.com/ayuda/?page_id=2157
	 * @param unknown $code
	 */
	public function queryImages($code) {
		$fields = array(
				'token'=>MAPAPROP_TOKEN,
				'code'=>$code
		);
		return $this->post('query-images', $fields);
	}

	/**
	 * @doc http://www.mapaprop.com/ayuda/?page_id=2164
	 * @param unknown $code
	 */
	public function queryPages() {
		$fields = array(
				'token'=>MAPAPROP_TOKEN
		);
		return $this->post('query-pages', $fields);
	}
	
	/**
	 * @doc http://www.mapaprop.com/ayuda/?page_id=2168
	 * @param unknown $code
	 */
	public function queryPage($id) {
		$fields = array(
				'token'=>MAPAPROP_TOKEN,
				'id'=>$id
		);
		return $this->post('query-page', $fields);
	}
	
	/**
	 * @doc http://www.mapaprop.com/ayuda/?page_id=2142
	 * @param unknown $custId
	 * @param unknown $propertyId
	 * @param unknown $name
	 * @param unknown $email
	 * @param unknown $phone
	 * @param unknown $text
	 */
	public function submitQuestion($code, $name, $email, $phone, $text) {
		$this->checkEnvironment();
		$domain = $this->getDomain();
		$referer = $this->getReferer();
		$ip = $this->getRemoteAddress();
		$userAgent = $this->getUserAgent();
		$fields = array(
				'token'=>MAPAPROP_TOKEN,
				'code'=>$code,
				'name'=>$name,
				'email'=>$email,
				'phone'=>$phone,
				'text'=>$text,
				'domain'=>$domain,
				'referer'=>$referer,
				'userAgent'=>$userAgent,
				'ip'=>$ip
		);
		return $this->post("submit-question", $fields);
	}

	/*
	 * Submit the contact form, all variables are required
	*/
	public function submitContact($name, $subject, $email, $phone, $text) {
		$this->checkEnvironment();
		$domain = $this->getDomain();
		$referer = $this->getReferer();
		$ip = $this->getRemoteAddress();
		$userAgent = $this->getUserAgent();
		$fields = array(
				'name'=>$name,
				'subject'=>$subject,
				'email'=>$email,
				'phone'=>$phone,
				'text'=>$text,
				'domain'=>$domain,
				'referer'=>$referer,
				'userAgent'=>$userAgent,
				'ip'=>$ip
		);
		return $this->post("submit-contact", $fields);
	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	//																non public methods
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	 * checks if the TOKEN variable is already defined
	 * @throws Exception
	 */
	public function checkEnvironment() {
		if (!defined('MAPAPROP_TOKEN')) {
			throw new Exception('The constant MAPAPROP_TOKEN must be defined before any call to the API');
		}
	}
	

	private function post($action, $fields) {
		try {
			$fields = json_encode($fields);
			
			//open connection
			$ch = curl_init();
		
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //TODO make it true
			curl_setopt($ch, CURLOPT_VERBOSE, true); //TODO remove
			curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $this->URL.$action);
			curl_setopt($ch, CURLOPT_USERAGENT, 'API call from '.$this->getDomain());
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		
			//execute post
			$result = curl_exec($ch);

			//echo $result; //TODO REMOVE
			
			/* Check for http codes. */
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($httpCode == 404) {
				throw new Exception("Command not found");
			} else if ($httpCode == 403) {
				throw new Exception("Unauthorized command");
			}
			$error = curl_error($ch);
			if ($error) {
// 				throw new Exception($error);
			}
			//close connection
			curl_close($ch);
			
			return $result;
			
		} catch (Exception $e) {
			return $this->createException($e);
		}
	}
	
	function createException($e) {
		$response = array(
				'error'=>true,
				'message'=>$e->getMessage()
		);
		return json_encode($response);
	}
	
	/*
	 * return the IP information of the client
	*/
	private function getRemoteAddress() {
		$ip;
		if (getenv("HTTP_CLIENT_IP")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} else if(getenv("HTTP_X_FORWARDED_FOR")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		} else if(getenv("REMOTE_ADDR")) {
			$ip = getenv("REMOTE_ADDR");
		} else {
			$ip = "UNKNOWN";
		}
		return $ip;
	}

	/*
	 * return the current domain
	*/
	private function getDomain() {
		return $_SERVER['HTTP_HOST'];
	}
	
	/*
	 * return the user agent of the browser
	 */
	private function getUserAgent() {
		return $_SERVER['HTTP_USER_AGENT'];
	}

	/*
	 * returns the referer
	 */
	private function getReferer() {
		return $_SERVER['HTTP_REFERER'];
	}
}


///////////////////////////////////////////////////////
//                 response class
///////////////////////////////////////////////////////

class MapapropResponse {
	public $error;
	
	public function setMessage($message, $error = null) {
		$this->error = new MapapropError();
		$this->error->message = $message;
		$this->error->status = $error == null;
	}
}

class MapapropError {
	public $message;
	public $status;
}

