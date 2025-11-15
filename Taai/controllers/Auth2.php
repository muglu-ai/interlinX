<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * This route going to be called first
     */
    public function index() {
        $this->is_user_valid_session(1);
        
        $this->other_title_for_layout = ' | Login';
        
        /* $reg_detail = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_name'=>'srinivas@samayglobal.com', 'pass2'=>md5(trim('Srinivas123'))));
        if(empty($reg_detail)) {
            $this->session->set_flashdata('is_error', 'Invalid username or password.');
            redirect('index');
        }
        
        unset($reg_detail['pass1']);
        unset($reg_detail['pass2']);
        //Set admin data into session
        $this->userauth->set_userdata($reg_detail);
        $this->userauth->set_session('SESS_MEMBER_ID', $reg_detail['user_id']); */
        
		if($this->input->method(false) == 'post') {
		    //Get form data
		    $formData = $this->input->post('formData', true);
		    //print_r($formData);exit;
		    
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
		        //$reg_detail = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_name'=>strtolower($formData['email']), 'pass2'=>passwordHashMake(trim($formData['password']))));
				$reg_detail = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_name'=>strtolower($formData['email'])));
				//print_r($reg_detail);exit;
		        if(empty($reg_detail)) {
		            $this->session->set_flashdata('is_error', 'Invalid username or password.');
		            redirect('index');
		        }
				if(!$this->passwordHashCheck($formData['password'], $reg_detail['pass2'])) {
					$this->session->set_flashdata('is_error', 'Invalid username or password.');
		            redirect('index');
				}

				if(empty($reg_detail['pass1'])) {
					$this->interlinx_reg_model->update_reg_detail(array('pass1'=>$formData['password']), array('user_id'=>$reg_detail['user_id']));
				}
		        
		        unset($reg_detail['pass1']);
		        unset($reg_detail['pass2']);
		        //Set admin data into session
		        $this->userauth->set_userdata($reg_detail);
		        $this->userauth->set_session('SESS_MEMBER_ID', $reg_detail['user_id']);
		        //echo $this->userauth->get_userdata('name');
                print_r($reg_detail['terms_condition']);
                if(empty($reg_detail['terms_condition'])) {
                    redirect('terms-and-condition');
                    print("terms_condition not accepted");
                }
                exit;

		        if(empty($reg_detail['terms_condition'])) {
		          redirect('terms-and-condition');
		        }
		        redirect('home');
		    }
		}
		
		$this->show_template('login');
	}
	
	/**
	 * This function handle logout
	 */
	public function logout() {
	    if($this->userauth->is_user_logged_in()) {
	        $this->userauth->logout();
	        $this->userauth->remove_session('SESS_MEMBER_ID');
	    }
	    
	    redirect('/');
	}
	
	
	/**
	 * This function handle forgot password
	 */
	public function forgot_password() {
	    $this->is_user_valid_session(1);
	    
	    $this->other_title_for_layout = ' | Forgot Password';
	    
	    if($this->input->method(false) == 'post') {
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
	            $reg_detail = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_name'=>$formData['email']));
	            if(empty($reg_detail)) {
	                $this->session->set_flashdata('is_error', 'Email Address is not registered with us. Please get registered your self on ' . EVENT_WEBSITE );
	                redirect('forgot-password');
	            }
				$pass1 = str_replace(' ', '_', $reg_detail['fname']) . $this->get_unique_key(5, false);
				$pass2 = $this->passwordHashMake($pass1);

				$this->interlinx_reg_model->update_reg_detail(array('pass1'=>$pass1, 'pass2'=>$pass2), array('user_id'=>$reg_detail['user_id']));
	            
				$reg_detail = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_name'=>$formData['email']));
				$this->response['qry_email_chk_ans'] = $reg_detail;
	            
	            // load emailer file
	            $message = $this->get_template('email/emailer2');
	            $subject = "Registration Details Of " . EVENT_NAME . " " . EVENT_YEAR . " B2B Partnering (InterlinX)";
	            $recipients = array($reg_detail['pri_email'], 'test.interlinks@gmail.com', EVENT_FROM_EMAIL);
	            //$recipients = array('sagarpatil2112@gmail.com');
	            //echo $message;exit;
	            $this->send_mail($subject, $message, $recipients);
	            $this->session->set_flashdata('is_success', 'We have sent login details on your registered email address.');
                if(empty($reg_detail['org_profile'])) {
                    redirect('personal-detail/update');
                }
	            redirect('/');
	        }
	    }
	    
	    $this->show_template('forgot-password');
	}
	
	/**
	 * This route going to be called first
	 */
	public function terms_condition() {
	    $this->is_user_valid_session();
	    $this->other_title_for_layout = ' | Terms & Condition';
	    
	    if($this->input->method(false) == 'post') {
	        //Get form data
	        $termconditions = $this->input->post('termconditions', true);
	        //print_r($termconditions);exit;
	        if(empty($termconditions)) {
	            $this->session->set_flashdata('is_error', 'Please accept terms & condition.');
	            redirect('terms-and-condition');
	        }
	        
	        $this->interlinx_reg_model->update_reg_detail(array('terms_condition'=>$termconditions), array('user_id'=>$this->userauth->get_session('SESS_MEMBER_ID')));
            if(empty($reg_detail['org_profile'])) {
                redirect('personal-detail/update');
            }

            redirect('home');
	    }
	    
	    $this->display_template('terms-condition');
	}
}