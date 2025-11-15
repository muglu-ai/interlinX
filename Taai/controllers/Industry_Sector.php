<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Industry_Sector extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->is_user_valid_session();
    }
    
    /**
     * This route going to be called first
     */
    public function lists() {
        $this->other_title_for_layout = ' | Industry Sectors';
        
        $industry_sector_list = $this->industry_sector_model->get_industry_sectors_list_by_criteria();
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        if($this->input->method(false) == 'post') {
            $qr_inds_sector_row_cnt = count($industry_sector_list);
            for($i_industry = 1; $i_industry <= $qr_inds_sector_row_cnt; $i_industry++) {
                $intr[$i_industry] = $this->input->post('intr'. $i_industry);
                
                $cnt_inst_sec = $i_industry;

            }
            $cnt_inst_sec++;
            
            $intr[$cnt_inst_sec] = $this->input->post('intr' . $cnt_inst_sec);
            
            
            $temp_intr_40 = $this->input->post('intr_other');
            
            if($temp_intr_40 =="OTHER") {
                $intr[$cnt_inst_sec] = $this->input->post('specify_other');
                $this->interlinx_reg_model->update_reg_detail(array('intr_other'=>$intr[$cnt_inst_sec]), array('user_id'=>$user_id));
            } else{
                $this->interlinx_reg_model->update_reg_detail(array('intr_other'=>''), array('user_id'=>$user_id));
            }
            //print_r($intr);
            
            for($i_industry = 1; $i_industry <= $qr_inds_sector_row_cnt; $i_industry++) {
                //echo $intr[$i_industry];
                $this->interlinx_reg_model->update_reg_detail(array('intr' . $i_industry=>$intr[$i_industry]), array('user_id'=>$user_id));
            }
            
            $this->session->set_flashdata('is_success', 'Industry sectors updated successfully.');
            redirect('industry-sectors');
        }
        $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
        $this->response['res'] = $res;
        $this->response['industry_sector_list'] = $industry_sector_list;
        
        //print_r($this->response);
        $this->display_template('industry-sector');
    }
    
    /**
     * This route going to be called first
     */
    public function your_interested_area() {
        $this->other_title_for_layout = ' | I am Looking For';
        
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
        $this->response['my_keywords'] = $res['my_keywords'];
        
        if($this->input->method(false) == 'post') {
            $interested_area = $this->security->xss_clean($this->input->post('my_keywords'));
            //print_r($interested_area);exit;
            if(!empty($interested_area)) {
                $this->interlinx_reg_model->update_reg_detail(array('my_keywords'=>$interested_area), array('user_id'=>$user_id));
            }
            $this->session->set_flashdata('is_success', 'Your Interested Area successfully updated.');
            redirect('looking-for');
        }
        
        $this->display_template('your-interested-area');
    }
    
    /**
     * This route going to be called first
     */
    public function my_industry_sectors() {
        $this->other_title_for_layout = ' | My Industry Sector';
        
        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');
        
        $industry_sector_list = $this->industry_sector_model->get_industry_sectors_list_by_criteria();
        
        $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));
        $my_industries = array();
        $ind = explode(';', $res['my_industries']);
        foreach ($ind as $my_industry) {
            if(!isset($my_industries['tej_' . $my_industry])) {
                $my_industries['tej_' . $my_industry] = $my_industry;
            }
        }
		$this->response['resmy_industries'] = $res['my_industries'];
        $this->response['my_industries'] = $my_industries;
        $this->response['industry_sector_list'] = $industry_sector_list;
        //print_r($this->response);
        if($this->input->method(false) == 'post') {
            $interested_area = $this->security->xss_clean($this->input->post('intr'));
			$temp_intr_40 = $this->input->post('intr' . count($industry_sector_list) + 1);
            if($temp_intr_40 =="OTHER") {
                $interested_area[] = '#Other-' . $this->input->post('specify_other');
            }
            //print_r($interested_area);exit;
            if(!empty($interested_area)) {
                $interested_area = implode(';', $interested_area);
                $this->interlinx_reg_model->update_reg_detail(array('my_industries'=>$interested_area), array('user_id'=>$user_id));
            }
            $this->session->set_flashdata('is_success', 'Your Industry Sectors successfully updated.');
            redirect('my-industry-sectors');
        }
        
        $this->display_template('my-industry-sectors');
    }
}