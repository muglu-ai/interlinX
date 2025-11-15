<?php
// ini_set('display_errors', 1);
// set max memory limit to 0 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->is_user_valid_session();
    }
    
    /**
     * This route going to be called first
     */
    public function index() {
		$this->other_title_for_layout = ' | Home';
		$user_id = $this->userauth->get_session('SESS_MEMBER_ID');
		//print_r($_SESSION);
		$shortlistPartnersList = $this->friends_model->get_friends_list_by_sql(array('user_id'=>$user_id));
		//print_r($shortlistPartnersList);exit;
		$messagesReceivedList = $this->messages_model->get_inbox_list_paging_by_criteria(array('user_id'=>$user_id, 'offset'=>0, 'limit'=>10));
		
		$receivedMeetingList  = $this->meetings_model->get_meetings_list_paging_by_criteria(array('receiver_user_id'=>$user_id, 'status'=>'Accepted', 'offset'=>0, 'limit'=>5));
		
		$sentMeetingList      = $this->meetings_model->get_meetings_list_paging_by_criteria(array('sender_user_id'=>$user_id, 'status'=>'Accepted', 'offset'=>0, 'limit'=>5));
		
		$acceptedMeetings     = $this->meetings_model->get_meetings_count_by_criteria(array('receiver_user_id'=>$user_id, 'status'=>'Accepted')) + $this->meetings_model->get_meetings_count_by_criteria(array('sender_user_id'=>$user_id, 'status'=>'Accepted'));
		//$pendingMeetingsList  = $this->meetings_model->get_meetings_list_by_criteria(array('receiver_user_id'=>$user_id, 'status'=>'Pending'));
		$pendingMeetingsList  = $this->meetings_model->get_meetings_list_paging_by_criteria(array('receiver_user_id'=>$user_id, 'offset'=>0, 'limit'=>5));
	    
		$res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
		//print_r($res);exit;
		
		$matchedList = array();
//        print_r($res['my_industries']);
		if(!empty($res['my_industries']) && !empty($res['my_keywords'])) {
			//$matchedList  = $this->interlinx_reg_model->get_matched_data(array('user_id'=>$user_id, 'my_industries'=>$res['my_industries'], 'my_keywords'=>$res['my_keywords']));
			$matchedList  = $this->interlinx_reg_model->get_matched_data(array('user_id'=>$user_id, 'my_industries'=>$res, 'my_keywords'=>$res['my_keywords']));
		}
//        echo "<pre>";
//        print_r($matchedList);
//        die;


		
		$totalRegistration = $this->interlinx_reg_model->get_total_registration_count($user_id);
//        print_r($totalRegistration);
//		print_r($matchedList);
//		die;
        $this->response['shortlistPartners']      = $shortlistPartnersList;
		$this->response['messagesReceivedList']   = $messagesReceivedList;
		$this->response['acceptedMeetings']       = $acceptedMeetings;
		$this->response['receivedMeetingList']    = $receivedMeetingList;
		$this->response['sentMeetingList']        = $sentMeetingList;
		$this->response['pendingMeetingsList']    = $pendingMeetingsList;
		$this->response['matchedList']            = $matchedList;
		$this->response['totalRegistration']      = $totalRegistration;
		
	    //print_r($this->response);
	    
		$this->display_template('home');
    }
    
    /**
     * This route going to be called first
     */
    public function shortlisted_partners($pageNumber = 1) {
        $this->other_title_for_layout = ' | Shortlisted Partners';
        
        //Load pagination library
        $this->load->library("pagination");
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $criteria = array();
        $criteria['user_id'] = $user_id;
        //Get total number of rows in table
        $shortlistPartnersList = $this->friends_model->get_friends_list_by_sql($criteria);
        //Get pagination configuration
        $config = $this->get_paging_config('shortlisted-partners', count($shortlistPartnersList));
        $config["per_page"] = 12;
        //$config['reuse_query_string'] = TRUE;
        //$config['page_query_string'] = true;
        //$config['suffix'] = http_build_query($data, '', "&");
        //For query string
        //if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
        //$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
        //Initialize pagination
        $this->pagination->initialize($config);
        
        $criteria['limit'] = $config["per_page"];
        $offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
        $criteria['offset'] = $offset;
        
        //Get order list
        $shortlistPartnersList = $this->friends_model->get_friends_list_by_sql($criteria);
        $this->response['shortlistPartners'] = $shortlistPartnersList;
        $this->response['pagination'] = $this->pagination->create_links();
        $this->response['offset'] = $offset;
        //print_r($this->response);
        
        $this->display_template('shortlisted-partners');
    }
    
    /**
     * This route going to be called first
     */
    public function accepted_meetings($pageNumber = 1) {
        $this->other_title_for_layout = ' | Sent Meeting Request';
        
        //Load pagination library
        $this->load->library("pagination");
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $criteria = array();
        $criteria['tej_sender_user_id'] = $user_id;
        $criteria['tej_data'] = true;
        $criteria['tej_receiver_user_id'] = $user_id;
        $criteria['status'] = 'Accepted';
        //Get total number of rows in table (count only)
        $totalRows = $this->meetings_model->get_meetings_count_by_criteria($criteria);
        //Get pagination configuration
        $config = $this->get_paging_config('accepted-meetings', $totalRows);
        $config["per_page"] = 12;
        //$config['reuse_query_string'] = TRUE;
        //$config['page_query_string'] = true;
        //$config['suffix'] = http_build_query($data, '', "&");
        //For query string
        //if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
        //$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
        //Initialize pagination
        $this->pagination->initialize($config);
        
        $criteria['limit'] = $config["per_page"];
        $offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
        $criteria['offset'] = $offset;
        
        //Get order list
        $meeting_list = $this->meetings_model->get_meetings_list_paging_by_criteria($criteria);
        $this->response['meeting_list'] = $meeting_list;
        $this->response['pagination'] = $this->pagination->create_links();
        $this->response['offset'] = $offset;
        //print_r($this->response);
        
        $this->display_template('meeting-request-accepted');
    }
    
    /**
     * This route going to be called first
     */
    public function your_matched($pageNumber = 1) {
        $this->other_title_for_layout = ' | Your matched';
        
        //Load pagination library
        $this->load->library("pagination");
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
        //print_r($res);exit;
		$matchedList = array();
		$pagi = $offset = '';
        if(!empty($res['my_industries']) || !empty($res['my_keywords'])) {
			$criteria = array('user_id'=>$user_id, 'my_industries'=>$res, 'my_keywords'=>$res['my_keywords']);
            //Get total number of rows in table (count only)
            $totalRows = $this->interlinx_reg_model->get_matched_count($criteria);
            //Get pagination configuration
            $config = $this->get_paging_config('your-matched', $totalRows);
			$config["per_page"] = 12;
			//$config['reuse_query_string'] = TRUE;
			//$config['page_query_string'] = true;
			//$config['suffix'] = http_build_query($data, '', "&");
			//For query string
			//if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
			//$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
			//Initialize pagination
			$this->pagination->initialize($config);
			
			$criteria['limit'] = $config["per_page"];
			$offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
			$criteria['offset'] = $offset;
			
            //Get order list
            $matchedList = $this->interlinx_reg_model->get_matched_data($criteria);
			$pagi = $this->pagination->create_links();
		}
        $this->response['matchedList'] = $matchedList;
        $this->response['pagination'] = $pagi;
        $this->response['offset'] = $offset;
//        print_r($this->response);
//        die;
        $this->display_template('your-matched');
    }
    
    public function search_redirect() {
        $data = $this->input->get();
        if($data['type'] == 'default') {
            redirect('search/' . $data['search']);
        }
        if($data['type'] == 'name') {
            redirect('search-by-name/' . $data['search']);
        }
        if($data['type'] == 'industry') {
            redirect('search-by-industry-sector/' . $data['search']);
        }
        if($data['type'] == 'org') {
            redirect('search-by-org/' . $data['search']);
        }
        if($data['type'] == 'org-sea') {
            redirect('search-by-org/' . base64_encode($data['search']));
        }
        //print_r($data);exit;
        if($data['type'] == 'country') {
            redirect('search-by-country/' . $data['search']);
        }
        if($data['type'] == 'country-sea') {
            redirect('search-by-country/' . base64_encode($data['search']));
        }
        if($data['type'] == 'keywords') {
            redirect('search-by-keyword/' . $data['search']);
        }
        if($data['type'] == 'turn') {
            redirect('search-by-turnover/' . $data['from'] .'/'.$data['to'] . '/' . $data['cur']);
        }
        
        print_r($data);
    }
    
    public function search($param = '', $pageNumber = 1) {
        $this->other_title_for_layout = ' | Search';
        
        $searchparam = $param;
        if(empty($searchparam)) {
            $searchparam = 'null';
        }
        if($param == 'null') {
            $param = '';
        }
        $param = strtolower($param);
        
        $criteria = array('search'=>$param);
        
        /* $gotName_1 =  explode('.',$param);
        foreach($gotName_1 as $gotName_1_str)
        {
            $gotName = $gotName_1_str;
        } */
        
        if(!empty($param)) {
            $data_sector_intr = $this->industry_sector_model->get_data($param);
            if(!empty($data_sector_intr))
            {
                $intr_no = $data_sector_intr['srno'];
            }
            
            //$cata = "intr1";
            if(isset($intr_no)) {
                $criteria['cata'] = "intr" . $intr_no;
            }
        }
        
        //Load pagination library
        $this->load->library("pagination");
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
        //print_r($res);exit;
        $criteria['search-tej'] = true;
        $criteria['user_id'] = $user_id;
        //Get total number of rows in table (count only)
        $totalRows = $this->interlinx_reg_model->get_matched_count($criteria);
        //Get pagination configuration
        $config = $this->get_paging_config('search/' . $searchparam, $totalRows);
        $config["per_page"] = 12;
        //$config['reuse_query_string'] = TRUE;
        //$config['page_query_string'] = true;
        //$config['suffix'] = http_build_query($data, '', "&");
        //For query string
        //if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
        //$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
        //Initialize pagination
        $this->pagination->initialize($config);
        
        $criteria['limit'] = $config["per_page"];
        $offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
        $criteria['offset'] = $offset;
        
        //Get order list
        $matchedList = $this->interlinx_reg_model->get_matched_data($criteria);
        $this->response['matchedList'] = $matchedList;
        $this->response['pagination'] = $this->pagination->create_links();
        $this->response['offset'] = $offset;
        $this->response['param'] = $param;
        
        //print_r($this->response);
        
        $this->display_template('search');
    }
    
    public function search_by_name($param = '', $pageNumber = 1) {
        $this->other_title_for_layout = ' | Search by name';
        
        $searchparam = $param;
        /* if(empty($searchparam)) {
            $searchparam = 'null';
        }
        if($param == 'null') {
            $param = '';
        } */
        $param = strtolower($param);
        
        $criteria = array('search'=>$param);
        
        /* $gotName_1 =  explode('.',$param);
         foreach($gotName_1 as $gotName_1_str)
         {
         $gotName = $gotName_1_str;
         } */
        
        if(!empty($param)) {
            $data_sector_intr = $this->industry_sector_model->get_data($param);
            if(!empty($data_sector_intr))
            {
                $intr_no = $data_sector_intr['srno'];
            }
            
            //$cata = "intr1";
            if(isset($intr_no)) {
                $criteria['cata'] = "intr" . $intr_no;
            }
        }
        
        //Load pagination library
        $this->load->library("pagination");
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        if(!empty($param)) {
            $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
            //print_r($res);exit;
            $criteria['search-tej'] = true;
            $criteria['user_id'] = $user_id;
            //Get total number of rows in table (count only)
            $totalRows = $this->interlinx_reg_model->get_matched_count($criteria);
            //Get pagination configuration
            $config = $this->get_paging_config('search-by-name/' . $searchparam, $totalRows);
            $config["per_page"] = 12;
            //$config['reuse_query_string'] = TRUE;
            //$config['page_query_string'] = true;
            //$config['suffix'] = http_build_query($data, '', "&");
            //For query string
            //if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
            //$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
            //Initialize pagination
            $this->pagination->initialize($config);
            
            $criteria['limit'] = $config["per_page"];
            $offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
            $criteria['offset'] = $offset;
            
            //Get order list
            $matchedList = $this->interlinx_reg_model->get_matched_data($criteria);
            $this->response['matchedList'] = $matchedList;
            $this->response['pagination'] = $this->pagination->create_links();
            $this->response['offset'] = $offset;
        }
        $this->response['param'] = $param;
        
        //print_r($this->response);
        
        $this->display_template('search-by-name');
    }
    
    public function search_by_industry_sector($param = '', $pageNumber = 1) {
        $this->other_title_for_layout = ' | Search by industry-sector';
        //echo $param . '#';
        $searchparam = $param;
        
        if(!empty($param)) {
            $param = str_replace('t3j', '', $param);
            //$searchparam = $param;
            $data_sector_intr = $this->industry_sector_model->get_industry_sectors_detail_by_criteria(array('srno'=>$param));
            if(!empty($data_sector_intr))
            {
                $intr_no = $data_sector_intr['srno'];
                $param = $data_sector_intr['comm_name'];;
            }
            $criteria = array('search'=>$param);
            
            if(isset($intr_no) && !empty($intr_no)) {
                $criteria['cata'] = "intr" . $intr_no;
            } else {
                $criteria['catas'] = $param;
                //redirect('search-by-industry-sector');
            }
            
            //Load pagination library
            $this->load->library("pagination");
            $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
            
            $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
            //print_r($res);exit;
            $criteria['search-tejind'] = true;
            $criteria['user_id'] = $user_id;
            //Get total number of rows in table (count only)
            $totalRows = $this->interlinx_reg_model->get_matched_count($criteria);
            //Get pagination configuration
            $config = $this->get_paging_config('search-by-industry-sector/' . $searchparam, $totalRows);
            $config["per_page"] = 12;
            //$config['reuse_query_string'] = TRUE;
            //$config['page_query_string'] = true;
            //$config['suffix'] = http_build_query($data, '', "&");
            //For query string
            //if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
            //$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
            //Initialize pagination
            $this->pagination->initialize($config);
            
            $criteria['limit'] = $config["per_page"];
            $offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
            $criteria['offset'] = $offset;
            
            //Get order list
            $matchedList = $this->interlinx_reg_model->get_matched_data($criteria);
            $this->response['matchedList'] = $matchedList;
            $this->response['pagination'] = $this->pagination->create_links();
            $this->response['offset'] = $offset;
        }
        $this->response['param'] = $param;
        $this->response['searchparam'] = $searchparam;
        $this->response['industries'] = $this->industry_sector_model->get_industry_sectors_list_by_criteria();
        //print_r($this->response);
        
        $this->display_template('search-by-industry-sector');
    }
    
    public function search_by_org($param = '', $pageNumber = 1) {
        $this->other_title_for_layout = ' | Search by Org';
        //echo $param . '#';
        $searchparam = $param;
        
        if(!empty($param)) {
            $param = (base64_decode($param));
            $param = strtolower($param);
            $criteria = array('search'=>$param);

            //Load pagination library
            $this->load->library("pagination");
            $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
            
            $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
            //print_r($res);exit;
            $criteria['search-tejorg'] = true;
            $criteria['user_id'] = $user_id;
            //Get total number of rows in table (count only)
            $totalRows = $this->interlinx_reg_model->get_matched_count($criteria);
            //Get pagination configuration
            $config = $this->get_paging_config('search-by-org/' . $searchparam, $totalRows);
            $config["per_page"] = 12;
            //$config['reuse_query_string'] = TRUE;
            //$config['page_query_string'] = true;
            //$config['suffix'] = http_build_query($data, '', "&");
            //For query string
            //if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
            //$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
            //Initialize pagination
            $this->pagination->initialize($config);
            
            $criteria['limit'] = $config["per_page"];
            $offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
            $criteria['offset'] = $offset;
            
            //Get order list
            $matchedList = $this->interlinx_reg_model->get_matched_data($criteria);
            $this->response['matchedList'] = $matchedList;
            $this->response['pagination'] = $this->pagination->create_links();
            $this->response['offset'] = $offset;
        }
        $this->response['param'] = base64_decode($searchparam);
        $this->response['searchparam'] = $searchparam;
        $this->response['orgList'] = $this->interlinx_reg_model->get_data3();
        //print_r($this->response);
        
        $this->display_template('search-by-org');
    }
    
    public function search_by_country($param = '', $pageNumber = 1) {
        $this->other_title_for_layout = ' | Search by country';
        //echo $param . '#';
        $searchparam = $param;
        
        if(!empty($param)) {
            $param = (base64_decode($param));
            $param = strtolower($param);
            $criteria = array('search'=>$param);
            
            //Load pagination library
            $this->load->library("pagination");
            $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
            
            $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
            //print_r($res);exit;
            $criteria['search-tejcou'] = true;
            $criteria['user_id'] = $user_id;
            //Get total number of rows in table (count only)
            $totalRows = $this->interlinx_reg_model->get_matched_count($criteria);
            //Get pagination configuration
            $config = $this->get_paging_config('search-by-org/' . $searchparam, $totalRows);
            $config["per_page"] = 12;
            //$config['reuse_query_string'] = TRUE;
            //$config['page_query_string'] = true;
            //$config['suffix'] = http_build_query($data, '', "&");
            //For query string
            //if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
            //$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
            //Initialize pagination
            $this->pagination->initialize($config);
            
            $criteria['limit'] = $config["per_page"];
            $offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
            $criteria['offset'] = $offset;
            
            //Get order list
            $matchedList = $this->interlinx_reg_model->get_matched_data($criteria);
            $this->response['matchedList'] = $matchedList;
            $this->response['pagination'] = $this->pagination->create_links();
            $this->response['offset'] = $offset;
        }
        $this->response['param'] = base64_decode($searchparam);
        $this->response['searchparam'] = $searchparam;
        $this->response['orgList'] = $this->interlinx_reg_model->get_data4();
        //print_r($this->response);
        
        $this->display_template('search-by-country');
    }
    
    public function search_by_keyword($param = '', $pageNumber = 1) {
        $this->other_title_for_layout = ' | Search by keyword';
        
        $searchparam = $param;
        /* if(empty($searchparam)) {
         $searchparam = 'null';
         }
         if($param == 'null') {
         $param = '';
         } */
        $param = strtolower($param);
        
        $criteria = array('search'=>$param);
        
        //Load pagination library
        $this->load->library("pagination");
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        if(!empty($param)) {
            $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
            //print_r($res);exit;
            $criteria['search-tej'] = true;
            $criteria['user_id'] = $user_id;
            //Get total number of rows in table (count only)
            $totalRows = $this->interlinx_reg_model->get_keywords_count($criteria);
            //Get pagination configuration
            $config = $this->get_paging_config('search-by-keyword/' . $searchparam, $totalRows);
            $config["per_page"] = 12;
            //$config['reuse_query_string'] = TRUE;
            //$config['page_query_string'] = true;
            //$config['suffix'] = http_build_query($data, '', "&");
            //For query string
            //if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
            //$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
            //Initialize pagination
            $this->pagination->initialize($config);
            
            $criteria['limit'] = $config["per_page"];
            $offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
            $criteria['offset'] = $offset;
            
            //Get order list
            $matchedList = $this->interlinx_reg_model->get_keywords_data($criteria);
            $data = array();
            foreach ($matchedList as $matched) {
                $data[] = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$matched['user_id']));
            }
            $this->response['matchedList'] = $data;
            $this->response['pagination'] = $this->pagination->create_links();
            $this->response['offset'] = $offset;
        }
        $this->response['param'] = $param;
        
        //print_r($this->response);
        
        $this->display_template('search-by-keyword');
    }
    
    public function search_by_turnover($from = '', $to = '', $cur = '', $pageNumber = 1) {
        $this->other_title_for_layout = ' | Search by keyword';
        
        //Load pagination library
        $this->load->library("pagination");
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        if(!empty($from) && !empty($to) && !empty($cur)) {
            $criteria = array('to'=>$to, 'from'=>$from, 'cur'=>$cur);
            
            $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
            //print_r($res);exit;
            $criteria['search-tejturn'] = true;
            $criteria['user_id'] = $user_id;
            //Get total number of rows in table
            $matchedList = $this->interlinx_reg_model->get_matched_data($criteria);
            //Get pagination configuration
            $config = $this->get_paging_config('search-by-turnover/' . $from . '/'. $to .'/' .$cur, count($matchedList));
            $config["per_page"] = 12;
            //$config['reuse_query_string'] = TRUE;
            //$config['page_query_string'] = true;
            //$config['suffix'] = http_build_query($data, '', "&");
            //For query string
            //if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
            //$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
            //Initialize pagination
            $this->pagination->initialize($config);
            
            $criteria['limit'] = $config["per_page"];
            $offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
            $criteria['offset'] = $offset;
            
            //Get order list
            $matchedList = $this->interlinx_reg_model->get_matched_data($criteria);
            $this->response['matchedList'] = $matchedList;
            $this->response['pagination'] = $this->pagination->create_links();
            $this->response['offset'] = $offset;
        }
        $this->response['from'] = $from;
        $this->response['to'] = $to;
        $this->response['cur'] = $cur;
        
        //print_r($this->response);
        
        $this->display_template('search-by-turnover');
    }
    
    /**
     * This route going to be called first
     */
    public function notifications() {
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        //print_r($_SESSION);
        $messages = $this->messages_model->get_data($user_id);
        $meetings = $this->meetings_model->get_schedule_data3($user_id);
        //print_r($messages);
        //print_r($meetings);
        $response_data = array('messages'=>count($messages), 'meetings'=>count($meetings), 'total'=>(count($messages) + count($meetings)));
        
        echo json_encode($response_data);
        
        return;
    }
    
    /**
     * This route going to be called first
     */
    /* public function pending_meetings($pageNumber = 1) {
        $this->other_title_for_layout = ' | Sent Meeting Request';
        
        //Load pagination library
        $this->load->library("pagination");
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $criteria = array();
        $criteria['tej_sender_user_id'] = $user_id;
        $criteria['tej_data'] = true;
        $criteria['tej_receiver_user_id'] = $user_id;
        $criteria['status'] = 'Accepted';
        //Get total number of rows in table
        $totalRows = $this->meetings_model->get_meetings_list_paging_by_criteria($criteria);
        //Get pagination configuration
        $config = $this->get_paging_config('accepted-meetings', count($totalRows));
        $config["per_page"] = 10;
        //$config['reuse_query_string'] = TRUE;
        //$config['page_query_string'] = true;
        //$config['suffix'] = http_build_query($data, '', "&");
        //For query string
        //if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
        //$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
        //Initialize pagination
        $this->pagination->initialize($config);
        
        $criteria['limit'] = $config["per_page"];
        $offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
        $criteria['offset'] = $offset;
        
        //Get order list
        $meeting_list = $this->meetings_model->get_meetings_list_paging_by_criteria($criteria);
        $this->response['meeting_list'] = $meeting_list;
        $this->response['pagination'] = $this->pagination->create_links();
        $this->response['offset'] = $offset;
        //print_r($this->response);
        
        $this->display_template('meeting-request-accepted');
    } */
    
    /**
     * This route going to be called first
     */
    public function latest_reg($pageNumber = 1) {
        $this->other_title_for_layout = ' | Your matched';
        
        //Load pagination library
        $this->load->library("pagination");
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
        //print_r($res);exit;
        $matchedList = array();
        $pagi = $offset = '';
        
        $criteria = array('user_id'=>$user_id, 'latest-tej'=>true);
        //Get total number of rows in table (count only)
        $totalRows = $this->interlinx_reg_model->get_matched_count($criteria);
        //Get pagination configuration
        $config = $this->get_paging_config('latest-registration', $totalRows);
        $config["per_page"] = 24;
        //$config['reuse_query_string'] = TRUE;
        //$config['page_query_string'] = true;
        //$config['suffix'] = http_build_query($data, '', "&");
        //For query string
        //if (count($data) > 0) $config['suffix'] = '?' . http_build_query($data, '', "&");
        //$config['first_url'] = $config['base_url'] . '?'  .http_build_query($data);
        //Initialize pagination
        $this->pagination->initialize($config);
        
        $criteria['limit'] = $config["per_page"];
        $offset = intval(($pageNumber  == 1 || $pageNumber  == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);
        $criteria['offset'] = $offset;
        
        //Get order list
        $matchedList = $this->interlinx_reg_model->get_matched_data($criteria);
        $pagi = $this->pagination->create_links();

        $this->response['matchedList'] = $matchedList;
        $this->response['pagination'] = $pagi;
        $this->response['offset'] = $offset;
        //print_r($this->response);
        
        $this->display_template('latest-registration');
    }
}