<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Auth extends Base_Controller

{



	public function __construct()

	{

		parent::__construct();

	}



	/**

	 * This route going to be called first

	 */

	public function index()

	{

		$this->is_user_valid_session(1);



		$this->other_title_for_layout = ' | Login';

		$this->output->set_header("Content-Security-Policy: frame-ancestors 'self' https://interlinxpartnering.com");

		$this->output->set_header("Referrer-Policy: no-referrer");



		if ($this->input->method(false) == 'post') {

			//Get form data

			$formData = $this->input->post('formData', true);

			



			//Load form validation library

			$this->load->library('form_validation');



			//Check form data is valid or not

			$this->form_validation->set_rules('formData[email]', 'Email Address', 'trim|required|valid_email|xss_clean');

			$this->form_validation->set_rules('formData[password]', 'Password', 'required|xss_clean');

			if ($this->form_validation->run() == FALSE) {

				//Set flash data

				$this->session->set_flashdata('is_error', validation_errors());

				redirect('/');

			} else {

				

				$reg_detail = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_name' => strtolower($formData['email'])));

				if (empty($reg_detail)) {

					$this->session->set_flashdata('is_error', 'Invalid username or password.');

					redirect('index');

				}

				if (!$this->passwordHashCheck($formData['password'], $reg_detail['pass2'])) {

					$this->session->set_flashdata('is_error', 'Invalid username or password.');

					redirect('index');

				}



				if (empty($reg_detail['pass1'])) {

					$this->interlinx_reg_model->update_reg_detail(array('pass1' => $formData['password']), array('user_id' => $reg_detail['user_id']));

				}



				unset($reg_detail['pass1']);

				unset($reg_detail['pass2']);

				//Set admin data into session

				$this->userauth->set_userdata($reg_detail);

				$this->userauth->set_session('SESS_MEMBER_ID', $reg_detail['user_id']);

				//echo $this->userauth->get_userdata('name');

				if (empty($reg_detail['terms_condition'])) {

					redirect('terms-and-condition');

				}

				redirect('home');

			}

		}



		$this->show_template('login');

	}



	public function login_api()

	{

		// Check if the request method is GET

		if ($this->input->method() == 'get') {

			// Retrieve the API key and email from the query parameters

			$api_key = $this->input->get('api_key', TRUE);

			$email = $this->input->get('email', TRUE);



			// Validate the API key

			if ($api_key !== "9d2f8d8b144a0b7fbb137688302e9ead") {

				// Output error response

				$this->output

					->set_content_type('application/json')

					->set_output(json_encode(array('error' => 'Invalid API key.')));

				return;

			}



			// Load form validation library

			$this->load->library('form_validation');



			// Set form validation rules for the email

			$this->form_validation->set_data(['email' => $email]);

			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');



			if ($this->form_validation->run() == FALSE) {

				// Output error response if validation fails

				$this->output

					->set_content_type('application/json')

					->set_output(json_encode(array('error' => validation_errors())));

			} else {

				// Check user credentials

				$reg_detail = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_name' => strtolower($email)));



				if (is_array($reg_detail) && !empty($reg_detail)) {

					$this->userauth->set_userdata($reg_detail);

					$this->userauth->set_session('SESS_MEMBER_ID', $reg_detail['user_id']);



					$data = array(

						'user_id' => $reg_detail['user_id'],

						'title' => $reg_detail['title'],

						'fname' => $reg_detail['fname'],

						'lname' => $reg_detail['lname'],

						'pri_email' => $reg_detail['pri_email'],

						'addr1' => $reg_detail['addr1'],

						'city' => $reg_detail['city'],

						'country' => $reg_detail['country'],

						'pin' => $reg_detail['pin'],

						'org_name' => $reg_detail['org_name'],

						'desig' => $reg_detail['desig'],

						'mob_cntry_code' => $reg_detail['mob_cntry_code'],

						'mob_number' => $reg_detail['mob_number'],

						'reg_cata' => $reg_detail['reg_cata'],

						'metting_location' => $reg_detail['metting_location'],

						'metting_location_hall' => $reg_detail['metting_location_hall'],

						'metting_location_stall_name' => $reg_detail['metting_location_stall_name'],

						'metting_location_stall_no' => $reg_detail['metting_location_stall_no'],

						'my_industries' => $reg_detail['my_industries'],

						'my_keywords' => $reg_detail['my_keywords'],

					);



					// Redirect based on conditions

					if (empty($reg_detail['terms_condition'])) {

						redirect('terms-and-condition');

					} else {

						redirect('home');

					}

				} else {

					// Handle the case where user data is not found or invalid

					$this->output

						->set_content_type('text/html') // Change content type to HTML

						->set_output('Your email id is not registered in InterlinX-B2B Partnering Portal. To make yourself register or for any queries, please do mail us at <a href="mailto:tejas.rashinkar@interlinks.in">tejas.rashinkar@interlinks.in</a>. We wish you a great networking..!!');

				}



			}

		} else {

			// Output error response for invalid request method

			$this->output

				->set_content_type('application/json')

				->set_output(json_encode(array('error' => 'Invalid request method.')));

		}

	}







	/**

	 * This function handle logout

	 */

	public function logout()

	{

		if ($this->userauth->is_user_logged_in()) {

			$this->userauth->logout();

			$this->userauth->remove_session('SESS_MEMBER_ID');

		}



		redirect('/');

	}





	/**

	 * This function handle forgot password

	 */

	public function forgot_password()

	{

		$this->is_user_valid_session(1);



		$this->other_title_for_layout = ' | Forgot Password';



		if ($this->input->method(false) == 'post') {

			//Get form data

			$formData = $this->input->post('formData', true);

			//print_r($formData);exit;



			//Load form validation library

			$this->load->library('form_validation');



			//Check form data is valid or not

			$this->form_validation->set_rules('formData[email]', 'Email Address', 'trim|required|valid_email|xss_clean');

			if ($this->form_validation->run() == FALSE) {

				//Set flash data

				$this->session->set_flashdata('is_error', validation_errors());

				redirect('forgot-password');

			} else {

				$reg_detail = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_name' => $formData['email']));

				if (empty($reg_detail)) {

					$this->session->set_flashdata('is_error', 'Email Address is not registered with us. Please get registered your self on ' . EVENT_WEBSITE);

					redirect('forgot-password');

				}

				$pass1 = str_replace(' ', '_', $reg_detail['fname']) . $this->get_unique_key(5, false);

				$pass2 = $this->passwordHashMake($pass1);



				$this->interlinx_reg_model->update_reg_detail(array('pass1' => $pass1, 'pass2' => $pass2), array('user_id' => $reg_detail['user_id']));



				$reg_detail = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_name' => $formData['email']));

				$this->response['qry_email_chk_ans'] = $reg_detail;



				// load emailer file

				$message = $this->get_template('email/emailer2');

				$subject = "Registration Details Of " . EVENT_NAME . " " . EVENT_YEAR . " B2B Partnering (InterlinX)";

				$recipients = array($reg_detail['pri_email'], 'test.interlinks@gmail.com', EVENT_FROM_EMAIL);

				//$recipients = array('sagarpatil2112@gmail.com');

				//echo $message;exit;

				$this->send_mail($subject, $message, $recipients);

				$this->session->set_flashdata('is_success', 'We have sent login details on your registered email address.');



				redirect('/');

			}

		}



		$this->show_template('forgot-password');

	}



	/**

	 * This route going to be called first

	 */

	public function terms_condition()

	{

		$this->is_user_valid_session();

		$this->other_title_for_layout = ' | Terms & Condition';



		if ($this->input->method(false) == 'post') {

			//Get form data

			$termconditions = $this->input->post('termconditions', true);

			//print_r($termconditions);exit;

			if (empty($termconditions)) {

				$this->session->set_flashdata('is_error', 'Please accept terms & condition.');

				redirect('terms-and-condition');

			}







			$this->interlinx_reg_model->update_reg_detail(array('terms_condition' => $termconditions), array('user_id' => $this->userauth->get_session('SESS_MEMBER_ID')));



			$user = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id' => $this->userauth->get_session('SESS_MEMBER_ID')));

			if (empty($user['org_profile'])) {

				redirect('personal-detail/update');

			}





			redirect('home');

		}



		$this->display_template('terms-condition');

	}

}