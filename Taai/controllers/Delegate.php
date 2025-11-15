<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
defined('BASEPATH') or exit('No direct script access allowed');



class Delegate extends Base_Controller

{



    public function __construct()

    {

        parent::__construct();



        $this->is_user_valid_session();

    }



    /**

     * This route going to be called first

     */

    public function personal_detail()

    {

        $this->other_title_for_layout = ' | Personal Information';



        $this->getPersonalData();



        $this->display_template('personal-detail');

    }



    /**

     * This route going to be called first

     */

    public function personal_detail_update()

    {

        $this->other_title_for_layout = ' | Personal Information';



        if ($this->input->method(false) == 'post') {

            //Get form data

            $addr_line1 = addslashes(trim($this->security->xss_clean($this->input->post('addr_line1'))));

            $addr_line2 = addslashes(trim($this->security->xss_clean($this->input->post('addr_line2'))));

            $city = addslashes(trim($this->security->xss_clean($this->input->post('city'))));

            $state = addslashes(trim($this->security->xss_clean($this->input->post('state'))));

            $country = addslashes(trim($this->security->xss_clean($this->input->post('country'))));

            $pin_no = addslashes(trim($this->security->xss_clean($this->input->post('pin_no'))));

            $website = addslashes(trim($this->security->xss_clean($this->input->post('website'))));

            $mob_phone_cntry_code = addslashes(trim($this->security->xss_clean($this->input->post('mob_phone_cntry_code'))));

            $mob_phone_number = addslashes(trim($this->security->xss_clean($this->input->post('mob_phone_number'))));

            $home_phone_cntry_code = addslashes(trim($this->security->xss_clean($this->input->post('home_phone_cntry_code'))));

            $home_phone_area_code = addslashes(trim($this->security->xss_clean($this->input->post('home_phone_area_code'))));

            $home_phone_number = addslashes(trim($this->security->xss_clean($this->input->post('home_phone_number'))));

            $org_edit = addslashes(trim($this->security->xss_clean($this->input->post('org_edit'))));

            $desig_edit = addslashes(trim($this->security->xss_clean($this->input->post('desig_edit'))));

            $org_info = addslashes(trim($this->security->xss_clean($this->input->post('org_info'))));

            $key = addslashes(trim($this->security->xss_clean($this->input->post('key'))));

            $org_video_links = addslashes(trim($this->security->xss_clean($this->input->post('org_video_links'))));

            //print_r($_POST);exit;

            //if (($addr_line1  == "") && ($addr_line2 == "") &&    ($city == "") &&    ($state == "") && ($country == "") && ($pin_no == "") && ($website == "") &&    ($mob_phone_cntry_code == "") && ($mob_phone_number == "") &&    ($home_phone_cntry_code == "") && ($home_phone_area_code == "") &&    ($home_phone_number == "") &&    ($org_edit == "") &&    ($desig_edit == "") && ($org_info == "") && ($key == "")) {

			if ( ($city == "") &&   ($country == "") && ($pin_no == "") && ($website == "") &&    ($mob_phone_cntry_code == "") && ($mob_phone_number == "") &&    ($org_edit == "") &&    ($desig_edit == "") && ($org_info == "") && ($key == "")) {

                $this->session->set_flashdata('is_error', 'Please enter all mandatory fields.');

                redirect('personal-detail');

            }



            $temp_org_turn_over = $this->db->escape_str(addslashes(trim($this->security->xss_clean($this->input->post('org_turn_over')))));

            $temp_org_turn_over_unit = $this->db->escape_str(addslashes(trim($this->security->xss_clean($this->input->post('org_turn_over_unit')))));

            $temp_dollar_rate = DOLLAR_RATE;



            $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

            $condition = array('user_id' => $user_id);



            if (($temp_org_turn_over_unit == "") || ($temp_org_turn_over_unit == "INR") || ($temp_org_turn_over_unit == "USD")) {

                if ($temp_org_turn_over_unit == "USD") {

                    $temp_org_turn_over_inr = $temp_org_turn_over * $temp_dollar_rate;

                } else {

                    $temp_org_turn_over_inr = $temp_org_turn_over;

                }



                $collection = array();

                $collection['org_turn_over'] = $temp_org_turn_over;

                $collection['org_turn_over_unit'] = $temp_org_turn_over_unit;

                $collection['org_turn_over_unit_inr'] = 'INR';

                $collection['org_turn_over_inr'] = $temp_org_turn_over_inr;



                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            $collection = array('org_video_links' => $org_video_links);

            $this->interlinx_reg_model->update_reg_detail($collection, $condition);



            if ($org_edit != "") {

                $collection = array('org_name' => $org_edit);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);



                $this->meetings_model->update_schedule_details(array('sender_org' => $org_edit), array('sender_id' => $user_id));

                $this->meetings_model->update_schedule_details(array('receiver_org' => $org_edit), array('receiver_id' => $user_id));



                $this->meetings_model->update_meetings_details(array('sender_org' => $org_edit), array('sender_user_id' => $user_id));

                $this->meetings_model->update_meetings_details(array('receiver_org' => $org_edit), array('receiver_user_id' => $user_id));

            }



            if ($_POST['org_profile'] != "") {

                $temp_org_profile = $this->db->escape_str((trim($_POST['org_profile'])));



                $collection = array('org_profile' => $temp_org_profile);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);



                $this->meetings_model->update_schedule_details(array('sender_org_profile' => $temp_org_profile), array('sender_id' => $user_id));

                $this->meetings_model->update_schedule_details(array('receiver_org_profile' => $temp_org_profile), array('receiver_id' => $user_id));



                $this->meetings_model->update_meetings_details(array('sender_org_profile' => $temp_org_profile), array('sender_user_id' => $user_id));

                $this->meetings_model->update_meetings_details(array('receiver_org_profile' => $temp_org_profile), array('receiver_user_id' => $user_id));

            }



            if ($desig_edit != "") {

                $collection = array('desig' => $desig_edit);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);



                $this->meetings_model->update_schedule_details(array('sender_desig' => $desig_edit), array('sender_id' => $user_id));

                $this->meetings_model->update_schedule_details(array('receiver_desig' => $desig_edit), array('receiver_id' => $user_id));



                $this->meetings_model->update_meetings_details(array('sender_desig' => $desig_edit), array('sender_user_id' => $user_id));

                $this->meetings_model->update_meetings_details(array('receiver_desig' => $desig_edit), array('receiver_user_id' => $user_id));

            }



            if ($addr_line1 != "") {

                $collection = array('addr1' => $addr_line1);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            if ($addr_line2 != "") {

                $collection = array('addr2' => $addr_line2);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            if ($city != "") {

                $collection = array('city' => $city);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            if ($state != "") {

                $collection = array('state' => $state);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }

            if ($country != "") {

                $collection = array('country' => $country);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }

            if ($pin_no != "") {

                $collection = array('pin' => $pin_no);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }

            if ($website != "") {

                $collection = array('web_site' => $website);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            if (($mob_phone_cntry_code != "") || ($mob_phone_number != "")) {

                if (($mob_phone_cntry_code == "") || ($mob_phone_number == "")) {

                    $this->session->set_flashdata('is_error', 'Incomplete Mobile Number.');

                    redirect('personal-detail/update');

                } else {

                    if ($mob_phone_cntry_code != "") {

                        $collection = array('mob_cntry_code' => $mob_phone_cntry_code);

                        $this->interlinx_reg_model->update_reg_detail($collection, $condition);

                    }

                    if ($mob_phone_number != "") {

                        $collection = array('mob_number' => $mob_phone_number);

                        $this->interlinx_reg_model->update_reg_detail($collection, $condition);

                    }

                }

            }



            if (($home_phone_cntry_code != "") || ($home_phone_area_code != "") || (($home_phone_number != ""))) {

                if (($home_phone_cntry_code == "") || ($home_phone_area_code == "") || (($home_phone_number == ""))) {

                    $this->session->set_flashdata('is_error', 'Incomplete Telephone Number.');

                    redirect('personal-detail/update');

                }



                if ($home_phone_cntry_code != "") {

                    $collection = array('hm_ph_cntry_code' => $home_phone_cntry_code);

                    $this->interlinx_reg_model->update_reg_detail($collection, $condition);

                }

                if ($home_phone_area_code != "") {

                    $collection = array('hm_ph_area_code' => $home_phone_area_code);

                    $this->interlinx_reg_model->update_reg_detail($collection, $condition);

                }

                if ($home_phone_number != "") {

                    $collection = array('hm_ph_number' => $home_phone_number);

                    $this->interlinx_reg_model->update_reg_detail($collection, $condition);

                }

            }



            if ($key != "") {

                $keyword_detail = $this->interlinx_reg_model->get_keywords_detail_by_criteria($condition);



                $user_key_count = 1;

                $temp_user_key_count = 0;

                $user_keys = $key;

                $user_keys_arr = explode(';', $user_keys);



                //Start Vivek Code                 



                $collection = array('my_keywords' => $user_keys);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);



                //End Vivek Code



                if (empty($keyword_detail)) {

                    $this->interlinx_reg_model->save_keyword_details(array('user_id' => $user_id));



                    foreach ($user_keys_arr as $user_keys_arr_str) {

                        if ($user_keys_arr_str != "") {

                            $key_name = "key_" . $user_key_count;

                            $this->interlinx_reg_model->update_keyword_details(array($key_name => $user_keys_arr_str), $condition);

                            $user_key_count++;

                        }

                    }

                } else {

                    foreach ($user_keys_arr as $user_keys_arr_str) {

                        if ($user_keys_arr_str != "") {

                            $key_name = "key_" . $user_key_count;

                            $this->interlinx_reg_model->update_keyword_details(array($key_name => $user_keys_arr_str), $condition);

                            $user_key_count++;

                        }

                    }



                    $temp_user_key_count = $user_key_count;

                    while ($temp_user_key_count <= 10) {

                        $key_name_clr = "key_" . $temp_user_key_count;

                        $this->interlinx_reg_model->update_keyword_details(array($key_name_clr => ''), $condition);

                        $temp_user_key_count++;

                    }

                }

            }

            $res = $this->userauth->get_userdata();



            $temp_old_file_org_prodct_profile_path = $res['file_org_prodct_profile'];

            $temp_old_file_org_prodct_profile_path_folder_file = "";



            if (isset($_FILES['profile_brief']['name']) && !empty($_FILES['profile_brief']['name'])) {

                if ($_FILES["profile_brief"]["size"] > 1999999) {

                    $this->session->set_flashdata('is_error', 'Error in uploading file. File Size should be less than 2 MB');

                    redirect('personal-detail/update');

                }



                $path = 'uploads/';

                $config['upload_path'] = $path;

                $config['allowed_types'] = 'pdf'; //'png|jpg|jpeg|pdf|doc|docx|txt';

                $config['remove_spaces'] = TRUE;

                $new_name = pathinfo($_FILES["userfiles"]['name'], PATHINFO_FILENAME) . '.pdf';

                $config['file_name'] = $new_name;

                $this->load->library('upload', $config);



                $f_name1 = date('dmyHis') . "_" . basename($_FILES['profile_brief']['name']);



                $f_name1 = str_replace(" ", "", $f_name1);

                $f_name1 = str_replace("'", "", $f_name1);

                $f_name1 = str_replace("\"", "", $f_name1);

                $f_name1 = str_replace(",", "", $f_name1);

                $f_name1 = str_replace("\\", "", $f_name1);

                $f_name1 = str_replace("%", "", $f_name1);

                $f_name1 = str_replace("#", "", $f_name1);

                $f_name1 = str_replace("$", "", $f_name1);

                $f_name1 = str_replace("<", "", $f_name1);

                $f_name1 = str_replace(">", "", $f_name1);

                $f_name1 = str_replace("*", "", $f_name1);



                $config['file_name'] = $f_name1;



                // Load and initialize upload library

                $this->upload->initialize($config);

                $this->load->library('upload', $config);



                if (!$this->upload->do_upload('profile_brief')) {

                    $this->session->set_flashdata('is_error', $this->upload->display_errors());

                    redirect('personal-detail/update');

                } else {

                    $data = array('upload_data' => $this->upload->data());

                }



                $image = false;

                if (!empty($data['upload_data']['file_name'])) {

                    $image = $data['upload_data']['file_name'];

                }

                if (empty($image)) {

                    $this->session->set_flashdata('is_error', 'Error in file upload. Please try again!');

                    redirect('personal-detail/update');

                }



                $temp_web_target_path = $path . $image;

                $this->interlinx_reg_model->update_reg_detail(array('file_org_prodct_profile' => $temp_web_target_path), $condition);



                $temp_old_file_org_prodct_profile_path_folder_file = substr(strchr($temp_old_file_org_prodct_profile_path, "uploads"), 0);

                if ($temp_old_file_org_prodct_profile_path_folder_file != "") {

                    unlink($temp_old_file_org_prodct_profile_path_folder_file);

                }

            }



            $res = $this->interlinx_reg_model->get_reg_detail_by_criteria($condition);

            $this->userauth->set_userdata($res);

            redirect('personal-detail');

        }



        $this->getPersonalData();



        $this->display_template('personal-detail-update');

    }





    public function update_api() {

        // Check if the request method is POST

        if ($this->input->method() == 'post') {



            // Get JSON input data

            $inputData = json_decode(file_get_contents('php://input'), true);



            $api_key = $this->input->get_request_header('api_key', TRUE);



            if($api_key != "857830ca802b9546197d60db3e77fb97") {

                // Output error response

                $this->output

                    ->set_content_type('application/json')

                    ->set_output(json_encode(array('error' => 'Invalid API key.')));

                return;

            }





            $inputData['mob_phone_cntry_code'] = 91;

            // Sanitize input data

            $addr_line1 = addslashes(trim($this->security->xss_clean(isset($inputData['addr_line1']) ? $inputData['addr_line1'] : '')));

            $addr_line2 = addslashes(trim($this->security->xss_clean(isset($inputData['addr_line2']) ? $inputData['addr_line2'] : '')));

            $city = addslashes(trim($this->security->xss_clean(isset($inputData['city']) ? $inputData['city'] : '')));

            $state = addslashes(trim($this->security->xss_clean(isset($inputData['state']) ? $inputData['state'] : '')));

            $country = addslashes(trim($this->security->xss_clean(isset($inputData['country']) ? $inputData['country'] : '')));

            $pin_no = addslashes(trim($this->security->xss_clean(isset($inputData['pin_no']) ? $inputData['pin_no'] : '')));

            $website = addslashes(trim($this->security->xss_clean(isset($inputData['website']) ? $inputData['website'] : '')));

            $mob_phone_cntry_code = addslashes(trim($this->security->xss_clean(isset($inputData['mob_phone_cntry_code']) ? $inputData['mob_phone_cntry_code'] : '')));

            $mob_phone_number = addslashes(trim($this->security->xss_clean(isset($inputData['mob_phone_number']) ? $inputData['mob_phone_number'] : '')));

            $org_edit = addslashes(trim($this->security->xss_clean(isset($inputData['org_edit']) ? $inputData['org_edit'] : '')));

            $desig_edit = addslashes(trim($this->security->xss_clean(isset($inputData['desig_edit']) ? $inputData['desig_edit'] : '')));

            $org_info = addslashes(trim($this->security->xss_clean(isset($inputData['org_info']) ? $inputData['org_info'] : '')));

            $key = addslashes(trim($this->security->xss_clean(isset($inputData['key']) ? $inputData['key'] : '')));

            $org_video_links = addslashes(trim($this->security->xss_clean(isset($inputData['org_video_links']) ? $inputData['org_video_links'] : '')));

            $user_id = addslashes(trim($this->security->xss_clean(isset($inputData['user_id']) ? $inputData['user_id'] : '')));

            // Check mandatory fields

            if (empty($city) && empty($country) && empty($pin_no) && empty($website) &&

                empty($mob_phone_cntry_code) && empty($mob_phone_number) &&

                empty($org_edit) && empty($desig_edit) && empty($org_info) && empty($key)) {

                $this->output

                    ->set_content_type('application/json')

                    ->set_output(json_encode(array('error' => 'Please enter all mandatory fields.')));

                return;

            }



            $temp_org_turn_over = $this->db->escape_str(addslashes(trim($this->security->xss_clean(isset($inputData['org_turn_over']) ? $inputData['org_turn_over'] : ''))));

            $temp_org_turn_over_unit = $this->db->escape_str(addslashes(trim($this->security->xss_clean(isset($inputData['org_turn_over_unit']) ? $inputData['org_turn_over_unit'] : ''))));

            $temp_dollar_rate = DOLLAR_RATE;



            $condition = array('user_id' => $user_id);



            if (empty($temp_org_turn_over_unit) || $temp_org_turn_over_unit == "INR" || $temp_org_turn_over_unit == "USD") {

                if ($temp_org_turn_over_unit == "USD") {

                    $temp_org_turn_over_inr = $temp_org_turn_over * $temp_dollar_rate;

                } else {

                    $temp_org_turn_over_inr = $temp_org_turn_over;

                }



                $collection = array(

                    'org_turn_over' => $temp_org_turn_over,

                    'org_turn_over_unit' => $temp_org_turn_over_unit,

                    'org_turn_over_unit_inr' => 'INR',

                    'org_turn_over_inr' => $temp_org_turn_over_inr

                );



                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            $collection = array('org_video_links' => $org_video_links);

            $this->interlinx_reg_model->update_reg_detail($collection, $condition);



            if (!empty($org_edit)) {

                $collection = array('org_name' => $org_edit);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);



                $this->meetings_model->update_schedule_details(array('sender_org' => $org_edit), array('sender_id' => $user_id));

                $this->meetings_model->update_schedule_details(array('receiver_org' => $org_edit), array('receiver_id' => $user_id));



                $this->meetings_model->update_meetings_details(array('sender_org' => $org_edit), array('sender_user_id' => $user_id));

                $this->meetings_model->update_meetings_details(array('receiver_org' => $org_edit), array('receiver_user_id' => $user_id));

            }



            if (!empty($inputData['org_profile'])) {

                $temp_org_profile = $this->db->escape_str(trim($inputData['org_profile']));



                $collection = array('org_profile' => $temp_org_profile);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);



                $this->meetings_model->update_schedule_details(array('sender_org_profile' => $temp_org_profile), array('sender_id' => $user_id));

                $this->meetings_model->update_schedule_details(array('receiver_org_profile' => $temp_org_profile), array('receiver_id' => $user_id));



                $this->meetings_model->update_meetings_details(array('sender_org_profile' => $temp_org_profile), array('sender_user_id' => $user_id));

                $this->meetings_model->update_meetings_details(array('receiver_org_profile' => $temp_org_profile), array('receiver_user_id' => $user_id));

            }



            if (!empty($desig_edit)) {

                $collection = array('desig' => $desig_edit);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);



                $this->meetings_model->update_schedule_details(array('sender_desig' => $desig_edit), array('sender_id' => $user_id));

                $this->meetings_model->update_schedule_details(array('receiver_desig' => $desig_edit), array('receiver_id' => $user_id));



                $this->meetings_model->update_meetings_details(array('sender_desig' => $desig_edit), array('sender_user_id' => $user_id));

                $this->meetings_model->update_meetings_details(array('receiver_desig' => $desig_edit), array('receiver_user_id' => $user_id));

            }



            if (!empty($addr_line1)) {

                $collection = array('addr1' => $addr_line1);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            if (!empty($addr_line2)) {

                $collection = array('addr2' => $addr_line2);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            if (!empty($city)) {

                $collection = array('city' => $city);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            if (!empty($state)) {

                $collection = array('state' => $state);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            if (!empty($country)) {

                $collection = array('country' => $country);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            if (!empty($pin_no)) {

                $collection = array('pin' => $pin_no);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            if (!empty($website)) {

                $collection = array('web_site' => $website);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



            if (!empty($mob_phone_cntry_code) || !empty($mob_phone_number)) {

                if (empty($mob_phone_cntry_code) || empty($mob_phone_number)) {

                    $this->output

                        ->set_content_type('application/json')

                        ->set_output(json_encode(array('error' => 'Incomplete Mobile Number.')));

                    return;

                } else {

                    if (!empty($mob_phone_cntry_code)) {

                        $collection = array('mob_cntry_code' => $mob_phone_cntry_code);

                        $this->interlinx_reg_model->update_reg_detail($collection, $condition);

                    }



//                    if (!empty($mob_phone_number)) {

//                        $collection = array('phone' => $mob_phone_number);

//                        $this->interlinx_reg_model->update_reg_detail($collection, $condition);

//                    }

                }

            }



            if (!empty($org_info)) {

                $collection = array('about_org' => $org_info);

                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }



//            if (!empty($key)) {

//                $collection = array('key_products' => $key);

//                $this->interlinx_reg_model->update_reg_detail($collection, $condition);

//            }

            $ref = "Dreamcast API";

            if (!empty($ref)) {

                $collection = array('ref' => $ref);

               $this->interlinx_reg_model->update_reg_detail($collection, $condition);

            }





            // Handle org_image if exists

            if (isset($_FILES['org_image']) && $_FILES['org_image']['size'] > 0) {

                $config = array(

                    'upload_path' => './assets/upload/organization_logo/',

                    'allowed_types' => 'gif|jpg|jpeg|png',

                    'file_name' => time(),

                );

                $this->upload->initialize($config);



                if (!$this->upload->do_upload('org_image')) {

                    $this->output

                        ->set_content_type('application/json')

                        ->set_output(json_encode(array('error' => $this->upload->display_errors())));

                    return;

                } else {

                    $data = $this->upload->data();

                    $temp_org_image = $data['file_name'];



                    // Save org_image to database

                    $collection = array('org_logo' => $temp_org_image);

                    $this->interlinx_reg_model->update_reg_detail($collection, $condition);

                }

            }



            // Return success response

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode(array('success' => 'Personal details updated successfully.', 'data'=>$inputData)));

        } else {

            // Return error for unsupported method

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode(array('error' => 'Unsupported request method.')));

        }

    }



    private function getPersonalData()

    {

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        $keyword_detail = $this->interlinx_reg_model->get_keywords_detail_by_criteria(array('user_id' => $user_id));

        $qr_key_search_user_ans_keys = '';

        if (!empty($keyword_detail)) {

            for ($key_col_cnt = 1; $key_col_cnt <= 10; $key_col_cnt++) {

                if ($keyword_detail['key_' . $key_col_cnt] != "") {

                    if (empty($qr_key_search_user_ans_keys)) {

                        $qr_key_search_user_ans_keys = $keyword_detail['key_' . $key_col_cnt];

                    } else {

                        $qr_key_search_user_ans_keys .= ";" . $keyword_detail['key_' . $key_col_cnt];

                    }

                }

            }

        }

        $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id' => $user_id));

        $this->response['qr_key_search_user_ans_keys'] = $qr_key_search_user_ans_keys;

        //print_r($res);

        $this->response['res'] = $res;

    }



    /**

     * This route going to be called first

     */

    public function upload_photo()

    {

        $this->other_title_for_layout = ' | Upload Photo';



        if ($this->input->method(false) == 'post') {

            if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {

                if ((($_FILES["photo"]["type"] != "image/gif") && 

                    ($_FILES["photo"]["type"] != "image/jpeg") && 

                    ($_FILES["photo"]["type"] != "image/pjpeg") && 

                    ($_FILES["photo"]["type"] != "image/x-png") && 

                    ($_FILES["photo"]["type"] != "image/png") && 

                    ($_FILES["photo"]["type"] != "image/jpg"))) {

                    $this->session->set_flashdata('is_fileerror', 'Error in upload image. Only jpeg, jpg, png Filetype are supported.');

                    $this->redirect_referer();

                }



                if ($_FILES["photo"]["size"] > 1048576) {

                    $this->session->set_flashdata('is_fileerror', 'Error in upload image. File Size should be less than 1 MB');

                    $this->redirect_referer();

                }



                $path = 'uploads/';

                $config['upload_path'] = $path;

                $config['allowed_types'] = 'png|jpg|jpeg';

                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);



                $f_name1 = date('dmyHis') . "_" . basename($_FILES['photo']['name']);



                $config['file_name'] = $f_name1;



                // Load and initialize upload library

                $this->upload->initialize($config);

                $this->load->library('upload', $config);



                if (!$this->upload->do_upload('photo')) {

                    $this->session->set_flashdata('is_fileerror', $this->upload->display_errors());

                    $this->redirect_referer();

                } else {

                    $data = array('upload_data' => $this->upload->data());

                }



                $image = false;

                if (!empty($data['upload_data']['file_name'])) {

                    $image = $data['upload_data']['file_name'];

                }

                if (empty($image)) {

                    $this->session->set_flashdata('is_fileerror', 'Error in file upload. Please try again!');

                    $this->redirect_referer();

                }



                $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

                $condition = array('user_id' => $user_id);



                $temp_web_target_path = $path . $image;

                $this->interlinx_reg_model->update_reg_detail(array('photo' => $temp_web_target_path), $condition);



                $res = $this->userauth->get_userdata();

                $pre_photo_path = $res['photo'];

                if ($pre_photo_path != "") {

                    $pre_photo_file_name = ltrim(strstr($pre_photo_path, "/"), "/");

                    if ($pre_photo_file_name != "default_file.jpg") {

                        unlink($pre_photo_path);

                    }

                }



                $res = $this->interlinx_reg_model->get_reg_detail_by_criteria($condition);

                $this->userauth->set_userdata($res);

            }

        }

        $this->redirect_referer();

    }



    /**

     * This route going to be called first

     */

    public function change_password()

    {

        $this->other_title_for_layout = ' | Change Password';



        if ($this->input->method(false) == 'post') {

            //Get form data

            if ($_POST['pass1'] == "") {

                $this->session->set_flashdata('is_error', 'Please Enter Complete Inforation');

                redirect('change-password');

            }

            if ($_POST['pass1'] != $_POST['pass2']) {

                $this->session->set_flashdata('is_error', 'New password & confirm password should be same.');

                redirect('change-password');

            }

            $user_id = $this->userauth->get_session('SESS_MEMBER_ID');



            $condition = array('user_id' => $user_id);

            $res = $this->interlinx_reg_model->get_reg_detail_by_criteria($condition);

            if ($_POST['old_pass'] != $res['pass1']) {

                $this->session->set_flashdata('is_error', 'Old password is incorrect.');

                redirect('change-password');

            }



            $this->interlinx_reg_model->update_reg_detail(array('pass1' => $_POST['pass1'], 'pass2' => md5($_POST['pass1'])), $condition);

            $res['pass1'] = $_POST['pass1'];

            $this->response['res'] = $res;

            // load emailer file

            $message = $this->get_template('email/chng_pass_emailer');

            $subject = "Updated Login details of " . EVENT_FROM_NAME;

            $recipients = array($res['pri_email'], 'test.interlinks@gmail.com');

            //echo $message;exit;

            $this->send_mail($subject, $message, $recipients);



            $this->session->set_flashdata('is_success', 'Password successfully changed.');

            redirect('change-password');

        }



        $this->display_template('change-password');

    }



    /**

     * This route going to be called first

     */

    public function delegate_personal_detail($user_id = '')

    {

        $this->other_title_for_layout = ' | Delegate Personal Information';



        $qr_uid_search_res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id' => $user_id));

        if (empty($qr_uid_search_res)) {

            redirect('home');

        }



        $keyword_detail = $this->interlinx_reg_model->get_keywords_detail_by_criteria(array('user_id' => $user_id));

        $keywords = array();

        if (!empty($keyword_detail)) {

            for ($i_key = 1; $i_key <= 10; $i_key++) {

                if ($keyword_detail['key_' . $i_key] != "") {

                    $keywords[] = $keyword_detail['key_' . $i_key];

                }

            }

        }

        

        $qr_uid_search_res['qr_key_search_ans'] = implode(' | ', $keywords);



        if (isset($qr_uid_search_res['org_profile'])) {



            $text = $qr_uid_search_res['org_profile'];



            $qr_uid_search_res['org_profile'] = str_replace('\\r\\n', ' ', $text);



            $qr_uid_search_res['org_profile'] = str_replace(['\\r', '\\n'], ' ', $qr_uid_search_res['org_profile']);



            $qr_uid_search_res['org_profile'] = preg_replace('/\s+/', ' ', $qr_uid_search_res['org_profile']);







        }



        // Remove special characters from org_profile



        // Remove all instances of \r\n

        $cleaned_text = str_replace('\\r\\n', ' ', $text);



        // Optional: Remove any remaining escape sequences

        $cleaned_text = str_replace(['\\r', '\\n'], ' ', $cleaned_text);



        // Optional: Replace multiple spaces with a single space

        $cleaned_text = preg_replace('/\s+/', ' ', $cleaned_text);





        $this->response['qr_uid_search_res'] = $qr_uid_search_res;

        $userid = $this->userauth->get_session('SESS_MEMBER_ID');

        $this->response['qr_prod_dtails_list'] = $this->product_services_model->get_product_services_list_by_criteria(array('user_id' => $user_id));

        $result_short = $this->friends_model->get_friends_list_paging_by_criteria(array('user_id' => $userid, 'frnd_id' => $userid, 'tejfrnd_id' => $user_id));

        //print_r($result_short);

        $data_short = array();

        if (!empty($result_short) && count($result_short)) {

            $data_short = $result_short[0];

        }

        $this->response['data_short'] = $data_short;

        //print_r($this->response);



        $this->display_template('delegate-personal-detail');

    }



    /**

     * This route going to be called first

     */

    public function delete_organisation_file()

    {

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id' => $user_id));



        if ($res['file_org_prodct_profile'] != "") {

            $temp_old_file_org_prodct_profile_path = $res['file_org_prodct_profile'];



            $this->interlinx_reg_model->update_reg_detail(array('file_org_prodct_profile' => ''), array('user_id' => $user_id));



            $temp_old_file_org_prodct_profile_path_folder_file = substr(strchr($temp_old_file_org_prodct_profile_path, "uploads"), 0);

            unlink($temp_old_file_org_prodct_profile_path_folder_file);



            $this->session->set_flashdata('is_success', 'Organisation/ Product Brief file deleted successfully.');

        }



        $this->redirect_referer('personal-detail');

    }

}

