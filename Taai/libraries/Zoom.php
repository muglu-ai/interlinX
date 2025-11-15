<?php
class Zoom {
	//MMA Acount
    //private $API_KEY = 'rKIafPiyQEO3JLbtnqk_jw';
	//private $API_SECRET = 'LDf4jCB0Bg9W9LNp6AHYbtIAEhdzFVwoRZVo';
	
	//SCI Account
	private $API_KEY = 'f-yKDJyKR02hnMQ6FWQJGQ';
	private $API_SECRET = '4eotVFou3e8NfVFpbVbWcOjLkkheLQD6I9lJ';
	
    /** 
     * This function generate the JWT token by using API KEY and API SECRET
     * Return the JWT token
     */
    /* public function generateJWTToken() {
        $token = array(
            "iss" => $this->API_KEY,
            "exp" => time() + 3600 //60 seconds
        );

        $this->JWT_TOKEN = JWT::encode( $token, $this->API_SECRET );
    } */

	/**
	 * This function call the URL using cURL function
	 * @param $url Holds the link of the API/webservice
	 * @param $data Holds the data which is need to retriev API data
	 * @param $method Holds the method of the API
	 * 
	 * @return Return the API response
	 */
    public function sendRequest($url = '', $data, $method = 'GET') {
		$curl = curl_init();
		
		$headers = array(
			'authorization: Bearer ' . JWT_TOKEN,
			'content-type: application/json'
		);

		switch ($method) {
			case "POST":
				if (!empty($data)) {
					//echo '###';print_r(json_encode($data));exit;
					curl_setopt($curl, CURLOPT_POST, count($data));
					curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
				}
				break;
			case "PUT":
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
				break;
		}

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_HTTPHEADER => $headers,
			//CURLOPT_CAINFO => dirname(__FILE__)."/cacert.pem" 
		));
	
		$response = curl_exec($curl);
		$error = curl_error($curl);
		  
		curl_close($curl);
		  
		if ($error) {
			return $error;
			echo "cURL Error #:" . $error;
		} else {
			//echo $response;
		}
		
		$response = json_decode($response, true);
		return $response;
	}
	
	/**
	 * This function call create meeting API of the Zoom
	 * @param mixed[] Holds the create meeting information in array
	 * @param string Holds the Zoom userId of the user
	 * 
	 * @return Returns the create meeting API response
	 */
	public function create_meeting($data = array(), $userId = 'me') {
		$url = 'https://api.zoom.us/v2/users/' . $userId . '/meetings';
		
		return $this->sendRequest($url, $data, 'POST');
	}
	
	/**
	 * This function call create meeting API of the Zoom
	 * @param mixed[] Holds the Id of the Zoom meeting
	 * 
	 * @return Returns the API response
	 */
	public function get_meeting($meetingId) {
		$url = 'https://api.zoom.us/v2/meetings/' . $meetingId;
		
		return $this->sendRequest($url, null, 'GET');
	}
	
	/**
	 * This function call to end meeting API of the Zoom
	 * @param mixed[] Holds the Id of the Zoom meeting
	 * 
	 * @return Returns the API response
	 */
	public function end_meeting($meetingId) {
		$url = 'https://api.zoom.us/v2/meetings/' . $meetingId . '/status';
		
		$data = array('action'=>'end');

		return $this->sendRequest($url, $data, 'PUT');
	}
	
	/**
	 * This function call to delete meeting API of the Zoom
	 * @param mixed[] Holds the Id of the Zoom meeting
	 * 
	 * @return Returns the API response
	 */
	public function delete_meeting($meetingId) {
		$url = 'https://api.zoom.us/v2/meetings/' . $meetingId;
		
		return $this->sendRequest($url, null, 'DELETE');
	}

	public function random_strings($length_of_string = 5) { 
		// String of all alphanumeric character 
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
		// Shufle the $str_result and returns substring 
		return substr(str_shuffle($str_result), 0, $length_of_string); 
	}
}


