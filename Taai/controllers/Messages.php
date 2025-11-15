<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->is_user_valid_session();
    }
    
    /**
     * This route going to be called first
     */
    public function inbox($pageNumber = 1) {
        $this->other_title_for_layout = ' | Inbox';
        
        //Load pagination library
        $this->load->library("pagination");
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $criteria = array();
        $criteria['user_id'] = $user_id;
        //Get total number of rows in table
        $totalRows = $this->messages_model->get_inbox_list_paging_by_criteria($criteria);
        //Get pagination configuration
        $config = $this->get_paging_config('messages/inbox', count($totalRows));
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
        $messagesList = $this->messages_model->get_inbox_list_paging_by_criteria($criteria);
        /* foreach ($messagesList as $messagesDetail) {
            if($messagesDetail['read_flag'] != "True") {
                $this->messages_model->update_messages_detail_by_query($messagesDetail['msg_id']);
            }
        } */
        $this->response['messagesList'] = $messagesList;
        $this->response['pagination'] = $this->pagination->create_links();
        $this->response['submenu'] = 'inbox';
        //print_r($this->response);
        
        $this->display_template('message-inbox');
    }
    
    /**
     * This route going to be called first
     */
    public function read_message($msg_id, $param = '') {
        if(empty($msg_id)) {
            if(empty($param)) {
                redirect('messages/inbox');
            }
            redirect('messages/sent');
        }
        
        $this->other_title_for_layout = ' | Inbox Read';
        if(!empty($param)) {
            $this->other_title_for_layout = ' | Sent Read';
        }
        
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $criteria = array();
        if(empty($param)) {
            $criteria['receiver_id'] = $user_id;
        } else {
            $criteria['sender_id'] = $user_id;
        }
        $criteria['msg_id'] = $msg_id;
        $messagesDetail = $this->messages_model->get_messages_detail_by_criteria($criteria);
        if(empty($messagesDetail)) {
            //$this->session->set_flashdata('is_error', 'Please Enter Complete Information to add reply.');
            if(empty($param)) {
                redirect('messages/inbox');
            }
            redirect('messages/sent');
        }
        $this->response['submenu'] = 'outbox';
        if(empty($param)) {
            if($messagesDetail['read_flag'] != "True") {
                $this->messages_model->update_messages_detail_by_query($messagesDetail['msg_id']);
            }
            $this->response['submenu'] = 'inbox';
        }
        $this->response['param'] = $param;
        $this->response['messagesDetail'] = $messagesDetail;
        $this->display_template('message-read');
    }
    
    /**
     * This route going to be called first
     */
    public function send_reply() {
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
        
        if($this->input->method(false) == 'post') {
            $temp_msg_id = trim($this->security->xss_clean($this->input->post('temp_msg_id')));
            $reply_msg_txt = trim($this->security->xss_clean($this->input->post('reply_msg_txt')));
            
            if( ($temp_msg_id == "") || ($reply_msg_txt == "") ) {
                $this->session->set_flashdata('is_error', 'Please Enter Complete Information to send reply.');
                redirect('messages/read/' . $temp_msg_id);
            }
            
            $qr_reply_msg_details_ans_row = $this->messages_model->get_messages_detail_by_criteria(array('msg_id'=>$temp_msg_id, 'receiver_id'=>$user_id));
            
            if(empty($qr_reply_msg_details_ans_row)) {
                $this->session->set_flashdata('is_error', 'Something went wrong while sending reply on message.');
                redirect('messages/inbox');
            }
            
            $temp_msg_txt = $reply_msg_txt;
            $temp_msg_sub = "RE: " . $qr_reply_msg_details_ans_row['msg_subject'];
            
            $qry_msg_sender_info_chk_ans = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$qr_reply_msg_details_ans_row['sender_id']));
            if(empty($qry_msg_sender_info_chk_ans)) {
                $this->session->set_flashdata('is_error', 'Something went wrong while sending reply on message.');
                redirect('messages/inbox');
            }
            
            $dup_msg_id1 = 0;
            do {
                $msg_no1 = "RY" . $this->get_referral_code(12);
                $res_no1 = $this->messages_model->get_messages_detail_by_criteria(array('msg_id'=>$msg_no1));
                if(empty($res_no1)) {
                    $dup_msg_id1++;
                } else {
                    $msg_no1 = "";
                    continue;
                }
            } while(!($dup_msg_id1 == 1));
            
            $criteria = array();
            $criteria['msg_id'] = $msg_no1;
            $criteria['sender_id'] = $res['user_id'];
            $criteria['sender_title'] = $res['title'];
            $criteria['sender_fname'] = $res['fname'];
            $criteria['sender_lname'] = $res['lname'];
            $criteria['Sender_email'] = $res['pri_email'];
            $criteria['sender_org'] = $res['org_name'];
            $criteria['receiver_id'] = $qry_msg_sender_info_chk_ans['user_id'];
            $criteria['receiver_title'] = $qry_msg_sender_info_chk_ans['title'];
            $criteria['receiver_fname'] = $qry_msg_sender_info_chk_ans['fname'];
            $criteria['receiver_lname'] = $qry_msg_sender_info_chk_ans['lname'];
            $criteria['receiver_email'] = $qry_msg_sender_info_chk_ans['pri_email'];
            $criteria['receiver_org'] = $qry_msg_sender_info_chk_ans['org_name'];
            $criteria['msg_subject'] = $temp_msg_sub;
            $criteria['msg'] = $temp_msg_txt;
            $criteria['msg_time'] = date("h:i:s a");
            $criteria['msg_date'] = date("Y-m-d");
            $criteria['read_flag'] = 'False';
            $criteria['request_type'] = 'Send';
            
            $id = $this->messages_model->save_messages_details($criteria);
            
            if(!empty($id)) {
                $temp_msg_txt = isset($temp_msg_txt) ? preg_replace('#(\\\r|\\\r\\\n|\\\n)#', '<br/>', $temp_msg_txt) : false;
                $this->response['res'] = $res;
                $this->response['temp_msg_sub'] = $temp_msg_sub;
                $this->response['temp_msg_txt'] = $temp_msg_txt;
                $this->response['qry_frnd_info_chk_ans'] = $qry_msg_sender_info_chk_ans;
                // load emailer file
                $message = $this->get_template('email/emailer_to_msg_reciever');
                $subject = $res['title'] . " " . $res['fname'] . " " . $res['lname'] . " Sent New Message For You On InterlinX";
                $recipients = array($qry_msg_sender_info_chk_ans['pri_email'], 'test.interlinks@gmail.com');
                //echo $message;exit;
                $this->send_mail($subject, $message, $recipients);
                
                $this->session->set_flashdata('is_success', 'Your reply has been sent successfully.');
                redirect('messages/read/' . $temp_msg_id);
            }
        }
        
        redirect('messages/inbox');
    }
    
    /**
     * This route going to be called first
     */
    public function inbox_delete($id = '') {
        if(empty($id)) {
            redirect('messages/inbox');
        }
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $this->messages_model->update_messages_details_criteria(array('receiver_dele_flag'=>'True'), array('msg_id'=>$id, 'receiver_id'=>$user_id));
        
        $this->session->set_flashdata('is_success', 'Message has been deleted successfully.');
        redirect('messages/inbox');
    }
    
    /**
     * This route going to be called first
     */
    public function sent($pageNumber = 1) {
        $this->other_title_for_layout = ' | Sent';
        
        //Load pagination library
        $this->load->library("pagination");
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $criteria = array();
        $criteria['user_id'] = $user_id;
        //Get total number of rows in table
        $totalRows = $this->messages_model->get_outbox_list_paging_by_criteria($criteria);
        //Get pagination configuration
        $config = $this->get_paging_config('messages/sent', count($totalRows));
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
        $messagesList = $this->messages_model->get_outbox_list_paging_by_criteria($criteria);
        $this->response['messagesList'] = $messagesList;
        $this->response['pagination'] = $this->pagination->create_links();
        $this->response['submenu'] = 'outbox';
        //print_r($this->response);
        
        $this->display_template('message-sent');
    }
    
    /**
     * This route going to be called first
     */
    public function sent_delete($id = '') {
        if(empty($id)) {
            redirect('messages/inbox');
        }
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $this->messages_model->update_messages_details_criteria(array('sender_dele_flag'=>'True'), array('msg_id'=>$id, 'sender_id'=>$user_id));
        
        $this->session->set_flashdata('is_success', 'Message has been deleted successfully.');
        redirect('messages/sent');
    }
    
    /**
     * This route going to be called first
     */
    public function compose() {
        $this->other_title_for_layout = ' | Compose';

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        if($this->input->method(false) == 'post') {
            $temp_rec_usr_id = $this->security->xss_clean($this->input->post('frnd_lst'));
            $temp_msg_sub = $this->security->xss_clean($this->input->post('msg_subject'));
            $temp_msg_txt = $this->security->xss_clean($this->input->post('msg_txt'));
            $is_meeting_send = $this->security->xss_clean($this->input->post('is_meeting_send'));
            //echo $temp_msg_txt;exit;
            if (empty($temp_rec_usr_id) || empty($temp_msg_sub) || empty($temp_msg_txt)) {
                //Set flash data
                $this->session->set_flashdata('is_error', 'Please enter all mandatory fields.');
                if(!empty($is_meeting_send)) {
                    $this->redirect_referer();
                }
                redirect('messages/compose');
            }
            
            $qry_frnd_info_chk_ans = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$temp_rec_usr_id));
            if(empty($qry_frnd_info_chk_ans)) {
                //Set flash data
                $this->session->set_flashdata('is_error', 'Please enter all mandatory fields.');
                if(!empty($is_meeting_send)) {
                    $this->redirect_referer();
                }
                redirect('messages/compose');
            }
            
            $i_msg_id1 = 0;
            do {
                $msg_no1 = 'M' . $this->get_referral_code(11);
                $res_no1 = $this->messages_model->get_messages_detail_by_criteria(array('msg_id'=>$msg_no1, 'sender_id'=>$user_id, 'receiver_id'=>$temp_rec_usr_id));
                if(empty($res_no1)) {
                    $i_msg_id1++;
                } else {
                    $msg_no1 = "";
                    continue;
                }
            } while(!($i_msg_id1 == 1));
            
            $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
            
            $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
            
            $criteria = array();
            $criteria['msg_id'] = $msg_no1;
            $criteria['sender_id'] = $res['user_id'];
            $criteria['sender_title'] = $res['title'];
            $criteria['sender_fname'] = $res['fname'];
            $criteria['sender_lname'] = $res['lname'];
            $criteria['Sender_email'] = $res['pri_email'];
            $criteria['sender_org'] = $res['org_name'];
            $criteria['receiver_id'] = $qry_frnd_info_chk_ans['user_id'];
            $criteria['receiver_title'] = $qry_frnd_info_chk_ans['title'];
            $criteria['receiver_fname'] = $qry_frnd_info_chk_ans['fname'];
            $criteria['receiver_lname'] = $qry_frnd_info_chk_ans['lname'];
            $criteria['receiver_email'] = $qry_frnd_info_chk_ans['pri_email'];
            $criteria['receiver_org'] = $qry_frnd_info_chk_ans['org_name'];
            $criteria['msg_subject'] = $temp_msg_sub;
            $criteria['msg'] = $temp_msg_txt;
            $criteria['msg_time'] = date("h:i:s a");
            $criteria['msg_date'] = date("Y-m-d");
            $criteria['read_flag'] = 'False';
            $criteria['request_type'] = 'Send';
            
            $id = $this->messages_model->save_messages_details($criteria);
            
            if(!empty($id)) {
                //$temp_msg_txt = isset($temp_msg_txt) ? preg_replace('#(\\\r|\\\r\\\n|\\\n)#', '<br/>', $temp_msg_txt) : false;
                $this->response['res'] = $res;
                $this->response['temp_msg_sub'] = $temp_msg_sub;
                $this->response['temp_msg_txt'] = $temp_msg_txt;
                $this->response['qry_frnd_info_chk_ans'] = $qry_frnd_info_chk_ans;
                // load emailer file
                $message = $this->get_template('email/emailer_to_msg_reciever');
                $subject = $res['title'] . " " . $res['fname'] . " " . $res['lname'] . " Sent New Message For You On InterlinX";
                $recipients = array($qry_frnd_info_chk_ans['pri_email'], 'test.interlinks@gmail.com');
                //echo $message;exit;
                $this->send_mail($subject, $message, $recipients);
                
                $this->session->set_flashdata('is_success', 'Your Message has been sent successfully.');
                if(!empty($is_meeting_send)) {
                    $this->redirect_referer();
                }
                redirect('messages/sent');
            }
        }
        
        $criteria = array();
        $criteria['user_id'] = $criteria['frnd_id'] = $user_id;
        //Get total number of rows in table
        $friendsList = $this->friends_model->get_friends_list_paging_by_criteria($criteria);
        
        $this->response['friendsList'] = $friendsList;
        //print_r($this->response);
        
        $this->display_template('message-compose');
    }
}