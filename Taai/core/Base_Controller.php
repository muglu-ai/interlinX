<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**

 * This class object is the sub class of super class that every library in CodeIgniter will be assigned to.

 * This class define all common function that will be reuse while coding.

 *

 * @author Sagar Patil <sagarpatil2112@gmail.com>

 * @package CodeIgniter

 * @subpackage Libraries

 * @category Libraries

 * @access Public

 * @version 1.0

 * @copyright Copyright (c) 2021

 */

class Base_Controller extends CI_Controller {

	protected $response = array();

	

	protected $template = array();

	

	//Title for the layout page

	protected $title_for_layout;

	protected $other_title_for_layout;

	

	//Contents of the view(middle content) and store it

	private $content_for_layout = '';

	

	public function __construct() {

		parent::__construct();

		date_default_timezone_set('Asia/Kolkata');

		$this->title_for_layout = PROJECT_TITLE . ' InterlinX : Partnering Tool';

		

		$this->load->model(array('interlinx_reg_model', 'friends_model', 'meetings_model', 'messages_model', 'product_services_model', 'industry_sector_model', '', ''));

	}

	

	/**

	 * This function rendered the layout of the project

	 * @param string $template_name

	 */

	public function display_template($template_name = 'sample-view') {

		$this->template['title_for_layout'] = $this->title_for_layout . $this->other_title_for_layout;

		$this->template['content_for_layout'] = $this->load->view($template_name, $this->response, true);

		

		$this->load->view('layouts/index', $this->template);

	}

	

	/**

	 * This function return the HTML of the given template

	 * @param string $template_name

	 * @return string Return the HTML string

	 */

	public function get_template($template_name = 'sample-view') {

		return $this->load->view($template_name, $this->response, true);

	}

	

	/**

	 * This function return the HTML of the given template

	 * @param string $template_name

	 * @return string Return the HTML string

	 */

	public function show_template($template_name = 'sample-view') {

		return $this->load->view($template_name, $this->response);

	}

		

	/**

	 * This function is used to get unique key using current datetime

	 *

	 * @return string Return the unique string

	 */

	public function get_unique_key($len = 23, $is_long_key = true) {

		$base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';

		$max = strlen($base) - 1;

		$uniqueKey = '';

		while (strlen($uniqueKey)<$len+1) {

			$uniqueKey .= $base[mt_rand(0,$max)];

		}

		$uniqueKey = $uniqueKey;

		if($is_long_key) {

			$uniqueKey = date("YmdHisu") . $uniqueKey;

		}

		//date("YmdHis").substr(microtime(FALSE), 2, 3)



		return $uniqueKey;

	}

		

	/**

	 * This function is used to get unique key using current datetime

	 *

	 * @return string Return the unique string

	 */

	public function send_mail($subject, $message, $to = array(), $from = array(), $cc = array(), $bcc = array(), $reply_to = array()) {

	    //$to = array('sagarpatil2112@gmail.com', 'test.interlinks@gmail.com');

		$to = implode(";",$to);//exit;

		return $this->elastic_mail($subject, $message, $to);

		exit;



		// Set Mail Configuration

	    $emailConfig = array(

	        'protocol' => MAIL_PROTOCOL,

	        'smtp_host' => MAIL_HOST,

	        'smtp_port' => MAIL_PORT,

	        'smtp_user' => MAIL_USER,

	        'smtp_pass' => MAIL_PASSWORD,

	        'smtp_crypto'=>'tls',

	        'mailtype' => 'html',

	        'charset' => 'iso-8859-1'

	    );

	    $to = array('sagarpatil2112@gmail.com', 'test.interlinks@gmail.com');

	    foreach($to as $em) {

	        // Load CodeIgniter Email library

	        $this->load->library('email', $emailConfig);

	        

			$this->email->set_mailtype("html");

	        // Set email preferences

	        $this->email->from(MAIL_FROM_EMAIL, MAIL_FROM_NAME);

	        if(!empty($reply_to)) {

	            $this->email->reply_to($reply_to['email'], $reply_to['name']);

	        }

	        

	        $this->email->to($em);

	        //$this->email->cc('sagarpatil2112@gmail.com');

	        if(!empty($cc)) {

	            $this->email->cc($cc);

	        }

	        if(!empty($bcc)) {

	            $this->email->bcc($bcc);

	        }

	        $this->email->subject($subject);

	        $this->email->message($message);

	        

	        // Ready to send email and check whether the email was successfully sent

	        if (!$this->email->send()) {

	            // Raise error message

	            show_error($this->email->print_debugger());

	        }// else {echo 'sent';}

	    }

		return true;

	}

    

	private function elastic_mail($subject, $message, $to) {

		$url = 'https://api.elasticemail.com/v2/email/send';



		try {

			$post = array('from' => 'enquiry@interlinx.in',

			'fromName' => EVENT_NAME . " " . EVENT_YEAR,

			'apikey' => 'B28BC46A67EAFBAF60DDFE3257D34E756B550950312375B641A3C111D1811928822355B83637DA21623EBE9535648F65',

			'subject' => $subject, //"Thank you for Registration on " . $EVENT_NAME . " " . $EVENT_YEAR . " InterlinX",

			'to' => $to, // 'sagarpatil2112@gmail.com;liomayer04@gmail.com;vivek.patil@mmactiv.com;vivek@interlinks.in;test.interlinks@gmail.com',

			'bodyHtml' => $message);//,//'<h1>Html Body</h1>',

			//'bodyText' => 'Text Body');

			

			$ch = curl_init();

			curl_setopt_array($ch, array(

				CURLOPT_URL => $url,

				CURLOPT_POST => true,

				CURLOPT_POSTFIELDS => $post,

				CURLOPT_RETURNTRANSFER => true,

				CURLOPT_HEADER => false,

				CURLOPT_SSL_VERIFYPEER => false

			));

			

			$result=curl_exec ($ch);

			curl_close ($ch);

			

			return true;



			/*$data = json_decode($result, true);

			if(isset($data['success']) && $data['success']) {

				//print_r($data);

				return true;

			}

			//echo $result;

			return false;*/

		} catch(Exception $ex){

			echo $ex->getMessage();

		}

	}



    /**

     * This function return the configuration of pagination

     * 

     * @param string $actionUrl - Holds the action URL of page list view

     * @param string/integer $tableNameTotalRows - Holds the name of the table OR total number of rows in the table

     * @param number $perPage - Holds the number of per page records

     * @param number $uriSegment - Holds the URI segment number

     * 

     * @return string 

     */

    public function get_paging_config($actionUrl, $tableNameTotalRows, $perPage = 10, $uriSegment = 3) {

    	//pagination settings

    	$config['base_url'] = base_url($actionUrl);

    	if(!is_int($tableNameTotalRows)) {

    		// load base model

    		$this->load->model('base_model');

    		$tableNameTotalRows = $this->base_model->countAll($tableNameTotalRows);

    	}

    	$config['total_rows'] = $tableNameTotalRows;

    	$config['per_page'] = $perPage;

    	//Set that how many number of pages you want to view.

    	//$config["uri_segment"] = $uriSegment;

    	//$choice = $config["total_rows"] / $config["per_page"];

    	$config["num_links"] = 2;//floor($choice);

    	// Use pagination number for anchor URL.

    	$config['use_page_numbers'] = TRUE;

    	$config['first_url'] = '1';

    	

    	//config for bootstrap 3 pagination class integration

    	$config['full_tag_open'] = '<ul class="pagination">';

    	$config['full_tag_close'] = '</ul>';

    	$config['first_link'] = '';

    	$config['last_link'] = '';

    	$config['first_tag_open'] = '<li class="page-item">';

    	$config['first_tag_close'] = '</li>';

    	$config['prev_link'] = '<span class="page-link">Previous</span>';

    	$config['prev_tag_open'] = '<li class="page-item">';

    	$config['prev_tag_close'] = '</li>';

    	$config['next_link'] = '<span class="page-link">Next</span>';

    	$config['next_tag_open'] = '<li class="page-item">';

    	$config['next_tag_close'] = '</li>';

    	$config['last_tag_open'] = '';

    	$config['last_tag_close'] = '';

    	$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:;" class="page-link">';

    	$config['cur_tag_close'] = '</a></li>';

    	$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';

    	$config['num_tag_close'] = '</span></li>';

    	

    	return $config;

    }

    

    /**

     * This function generate the referral code for member coupon

     * @return string

     */

    public function get_referral_code($length = 4) {

    	$numbers      = [1, 2, 3, 4, 5, 6, 7, 8, 9];

    	$uppercase    = ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'];

    	$coupon = '';

    	$characters = array_merge($numbers, $uppercase);

    	for ($i = 0; $i < $length; $i++) {

    		$coupon .= $characters[mt_rand(0, count($characters) - 1)];

    	}

    	

    	return $coupon;

	}

    

    /**

     * This function validated the user session, if it is valid/invalid session, will be redirected to particular route.

     * @param bool $is_logged_in

     */

    public function is_user_valid_session($is_logged_in = false) {

    	if($is_logged_in) {

	    	if($this->userauth->is_user_logged_in()) {

	    		redirect('home');

	    	}

    	} else {

	    	if(!$this->userauth->is_user_logged_in()) {

	    		redirect();

	    	}

    	}

    }

    

    /**

     * This function redirect to referer link if not exist redirect to given link

     * @param string $param

     */

    public function redirect_referer($param = '') {

    	if(!empty($_SERVER['HTTP_REFERER'])) {

    		redirect($_SERVER['HTTP_REFERER']);

    	}

    	redirect($param);

    }

		

	/**

	 * This function is used to get unique number using current datetime

	 *

	 * @return string Return the unique string

	 */

	public function generate_random_number($len = 6) {

		$base = '1234567890';

		$max = strlen($base) - 1;

		$uniqueNumber = '';

		while (strlen($uniqueNumber) < $len) {

			$uniqueNumber .= $base[mt_rand(0, $max)];

		}

		return $uniqueNumber;

	}



	function passwordHashMake($pasword) {

		//$pasword = 'user-password';

		// To create a valid password out of laravel Try out!

		$cost = 10; // Default cost

		$passwordHash = password_hash($pasword, PASSWORD_BCRYPT, ['cost' => $cost]);

		

		return $passwordHash;

		/*// To validate the password you can use

		$hash = '$2y$10$dvaeLvqt7slsq6JlJ0hQ7Oj0kfBiitGEwl8jCk20ZJGffsmKPRUau';



		if (password_verify($pasword, $hash)) {

			echo 'Password is valid!';

		} else {

			echo 'Invalid password.';

		}*/

	}



	function passwordHashCheck($pasword, $paswordHash) {

		//$pasword = 'user-password';

		// To create a valid password out of laravel Try out!

		$cost = 10; // Default cost

		$password = password_hash($pasword, PASSWORD_BCRYPT, ['cost' => $cost]);

		

		//return $passwordHash;

		// To validate the password you can use

		//$paswordHash = '$2y$10$dvaeLvqt7slsq6JlJ0hQ7Oj0kfBiitGEwl8jCk20ZJGffsmKPRUau';



		if (password_verify($pasword, $paswordHash)) {

			return true;

			//echo 'Password is valid!';

		} else {

			return false;

			//echo 'Invalid password.';

		}

	}

}

?>