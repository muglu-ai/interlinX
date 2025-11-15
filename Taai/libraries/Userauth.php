<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * This class authenticate the user login
 * @author Sagar Patil
 *
 */
class Userauth {
	/**
	 * Reference to CodeIgniter instance
	 *
	 * @var object
	 */
	protected $CI;
	
	function __construct() {
		$this->CI = & get_instance ();
	}
	
	/**
	 * This function return user data. If key is not empty it return the data of that key otherwise return complete data. 
	 * @return mixed[] Return the user session data
	 */
	function get_userdata($key = '') {
		if(!empty($key)) {
			return isset($this->CI->session->userdata(USER_SESSION_NAME)[$key]) ? $this->CI->session->userdata(USER_SESSION_NAME)[$key] : '';
		}
		return $this->CI->session->userdata(USER_SESSION_NAME);
	}
	
	/**
	 * This function set the user data in session
	 *
	 * @param mixed[] $data
	 */
	public function set_userdata($data = array()) {
		$user_detail = $this->get_userdata();
		foreach ($data as $key=>$value) {
			$user_detail[$key] = $value;
		}
		
		$this->CI->session->set_userdata(USER_SESSION_NAME, $user_detail);
	}
	
	/**
	 * This function unset the user data
	 *
	 * @param string $key Holds the key which is will be unset
	 */
	public function unsetUserdata($key) {
		if(!empty($key)) {
			$user_detail = $this->get_userdata();
			if(isset($user_detail[$key])) {
				unset($user_detail[$key]);
			}
			$this->CI->session->set_userdata(USER_SESSION_NAME, $user_detail);
		}
	}
	
	/**
	 * This function return true if user is logged in otherwise return the false
	 * @return boolean Return true/false
	 */
	function is_user_logged_in() {
		return ($this->CI->session->userdata(USER_SESSION_NAME)) ? true : false;
	}
	
	/**
	 * This function destroy the user session 
	 */
	function logout() {
	    return $this->CI->session->unset_userdata(USER_SESSION_NAME);
	}
	
	/**
	 * This function set the user data in session
	 *
	 * @param mixed[] $data
	 */
	public function set_session($key, $value) {
	    return $this->CI->session->set_userdata($key, $value);
	}
	
	/**
	 * This function get the user data in session
	 *
	 * @param mixed[] $data
	 */
	public function get_session($key) {
	    return $this->CI->session->userdata($key);
	}
	
	/**
	 * This function remove the user data in session
	 *
	 * @param mixed[] $data
	 */
	public function remove_session($key) {
	    return $this->CI->session->unset_userdata($key);
	}
}