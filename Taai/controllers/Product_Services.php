<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Services extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->is_user_valid_session();
    }
    
    /**
     * This route going to be called first
     */
    public function lists() {
        $this->other_title_for_layout = ' | Add Product Services';
        
        $this->response['product_list'] = $this->product_services_model->get_product_services_list_by_criteria(array('user_id'=>$this->userauth->get_session('SESS_MEMBER_ID')));
        
        $this->display_template('product-services-list');
    }
    
    /**
     * This route going to be called first
     */
    public function add() {
        $this->other_title_for_layout = ' | Add Product Services';
        
        if($this->input->method(false) == 'post') {
            //Load form validation library
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('product_type', 'Type', 'trim|required');
            $this->form_validation->set_rules('product_title', 'Product name', 'trim|required');
            $this->form_validation->set_rules('product_link', 'Product link', 'trim|required');
            $this->form_validation->set_rules('product_details', 'Product description', 'trim|required');
            
            if ($this->form_validation->run() == FALSE) {
                //Set flash data
                $this->session->set_flashdata('is_error', validation_errors());
                redirect('product-services/add');
            } else {
                $product_type = $this->security->xss_clean($this->input->post('product_type'));
                $product_title = $this->security->xss_clean($this->input->post('product_title'));
                $product_link = $this->security->xss_clean($this->input->post('product_link'));
                $product_details = $this->security->xss_clean($this->input->post('product_details'));
                $product_keywords = $this->security->xss_clean($this->input->post('product_keywords'));
                $product_image = $this->security->xss_clean($this->input->post('product_image'));
                $product_video_link = $this->security->xss_clean($this->input->post('product_video_link'));
                
                $criteria = array();
                $criteria['user_id'] = $this->userauth->get_session('SESS_MEMBER_ID');
                $criteria['product_type'] = $product_type;
                $criteria['product_title'] = $product_title;
                $criteria['product_link'] = $product_link;
                $criteria['product_details'] = $product_details;
                $criteria['product_image'] = $product_image;
                $criteria['product_video_link'] = $product_video_link;
                
                $id = $this->product_services_model->save_product_services_details($criteria);
                
                if(!empty($product_keywords)) {
                    $this->update_product_keyword($product_keywords, $id, $criteria['user_id']);
                }
            }
            $this->session->set_flashdata('is_success', 'Product/Service details added successfully.');
            redirect('product-services/list');
        }
        
        $this->display_template('product-services-add');
    }
    
    /**
     * This route going to be called first
     */
    public function update($id = '') {
        $this->other_title_for_layout = ' | Update Product Services';
        
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        if($this->input->method(false) == 'post') {
            //Load form validation library
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('product_type', 'Type', 'trim|required');
            $this->form_validation->set_rules('product_title', 'Product name', 'trim|required');
            $this->form_validation->set_rules('product_link', 'Product link', 'trim|required');
            $this->form_validation->set_rules('product_details', 'Product description', 'trim|required');
            
            if ($this->form_validation->run() == FALSE) {
                //Set flash data
                $this->session->set_flashdata('is_error', validation_errors());
                redirect('product-services/update/' . $id);
            } else {
                $product_type = $this->security->xss_clean($this->input->post('product_type'));
                $product_title = $this->security->xss_clean($this->input->post('product_title'));
                $product_link = $this->security->xss_clean($this->input->post('product_link'));
                $product_details = $this->security->xss_clean($this->input->post('product_details'));
                $product_keywords = $this->security->xss_clean($this->input->post('product_keywords'));
                $product_image = $this->security->xss_clean($this->input->post('product_image'));
                $product_video_link = $this->security->xss_clean($this->input->post('product_video_link'));
                
                $criteria = array();
                $criteria['product_type'] = $product_type;
                $criteria['product_title'] = $product_title;
                $criteria['product_link'] = $product_link;
                $criteria['product_details'] = $product_details;
                $criteria['product_image'] = $product_image;
                $criteria['product_video_link'] = $product_video_link;
                
                $this->product_services_model->update_product_services_details($criteria, array('srno'=>$id, 'user_id'=>$user_id));
                
                if(!empty($product_keywords)) {
                    $this->update_product_keyword($product_keywords, $id, $user_id);
                }
            }
            
            $this->session->set_flashdata('is_success', 'Product/Service details updated successfully.');
            redirect('product-services/list');
        }
        
        $product_detail = $this->product_services_model->get_product_services_detail_by_criteria(array('srno'=>$id, 'user_id'=>$user_id));
        if(empty($product_detail)) {
            redirect('product-services/list');
        }
        $this->response['qr_prod_details_res'] = $product_detail;
        
        $this->display_template('product-services-update');
    }
    
    private function update_product_keyword($product_keywords, $id, $user_id) {
        $condition = array('srno'=>$id, 'user_id'=>$user_id);
        $product_detail = $this->product_services_model->get_product_services_detail_by_criteria($condition);
        $user_key_count = 1;
        $temp_user_key_count = 0;
        $user_keys = $product_keywords;
        $user_keys_arr = explode(';', $user_keys);
        
        if(empty($product_detail)) {
            foreach($user_keys_arr as $user_keys_arr_str ) {
                if($user_keys_arr_str != "") {
                    $key_name = "prod_key_" . $user_key_count;
                    $this->product_services_model->update_product_services_details(array($key_name=>$user_keys_arr_str), $condition);
                    $user_key_count++;
                }
            }
        } else {
            foreach($user_keys_arr as $user_keys_arr_str ) {
                if($user_keys_arr_str != "") {
                    $key_name = "prod_key_" . $user_key_count;
                    $this->product_services_model->update_product_services_details(array($key_name=>$user_keys_arr_str), $condition);
                    $user_key_count++;
                }
                
            }
            
            $temp_user_key_count =$user_key_count;
            while($temp_user_key_count <= 10) {
                $key_name_clr = "prod_key_" . $temp_user_key_count;
                $this->product_services_model->update_product_services_details(array($key_name_clr=>''), $condition);
                $temp_user_key_count++;
                
            }
        }
    }
    
    /**
     * This route going to be called first
     */
    public function delete($id = '') {
        if(empty($id)) {
            redirect('product-services/list');
        }
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $this->product_services_model->delete_product_services(array('srno'=>$id, 'user_id'=>$user_id));
        
        $this->session->set_flashdata('is_success', 'Product/Service details deleted successfully.');
        $this->redirect_referer();
    }
}