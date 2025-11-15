<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Schedule extends Base_Controller {

    

    public function __construct() {

        parent::__construct();

        

        $this->is_user_valid_session();

    }

    

    /**

     * This route going to be called first

     */

    public function my_calendar() {

        $this->other_title_for_layout = ' | My Calendar';

        

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        

        $EVENT_INTERLINX_DATE_ARR = unserialize(EVENT_INTERLINX_DATE_ARR);

        

        $schedule_list = array();

        for($i_days_cnt = 0; $i_days_cnt < EVENT_INTERLINX_NO_OF_DAYS; $i_days_cnt++) {

            $schedule_record_list = $this->meetings_model->get_schedule_list_by_criteria(array('meeting_date'=>$EVENT_INTERLINX_DATE_ARR[$i_days_cnt], 'receiver_id'=>$user_id));

            //print_r($schedule_list);

            $record = array();

            foreach ($schedule_record_list as $res_sch) {

                $global_meet_data = array();

                if($res_sch['status'] == "Accepted") {

                    $global_meet_res = $this->meetings_model->get_meetings_detail_by_criteria(array('meeting_date'=>$res_sch['meeting_date'], 'meeting_time_start'=>$res_sch['meeting_time_start'], 'meeting_time_end'=>$res_sch['meeting_time_end'], 'sender_user_id'=>$res_sch['sender_id'], 'receiver_user_id'=>$res_sch['receiver_id'], 'status'=>'Accepted'));

                    

                    if(!empty($global_meet_res)) {

                        $global_meet_data = $global_meet_res;

                    } else {

                        $global_meet_res = $this->meetings_model->get_meetings_detail_by_criteria(array('meeting_date'=>$res_sch['meeting_date'], 'meeting_time_start'=>$res_sch['meeting_time_start'], 'meeting_time_end'=>$res_sch['meeting_time_end'], 'sender_user_id'=>$res_sch['receiver_id'], 'receiver_user_id'=>$res_sch['sender_id'], 'status'=>'Accepted'));

                        if(!empty($global_meet_res)) {

                            $global_meet_data = $global_meet_res;

                        }

                    }

                }

                $res_sch['global_meet_data'] = $global_meet_data;

                $record[] = $res_sch;

            }

            $schedule_list[$i_days_cnt] = $record;

        }

        $this->response['EVENT_INTERLINX_DATE_ARR'] = $EVENT_INTERLINX_DATE_ARR;

        $this->response['schedule_list'] = $schedule_list;

        //print_r($this->response);

        

        $this->display_template('my-calendar');

    }



    public function my_calendar_api() {



        //if method is post then continue

            // Get form data



            // Set the header for JSON response

            header('Content-Type: application/json');

            if($this->input->method(false) == 'get') {

            $api_key = $this->input->get_request_header('api_key', TRUE);

            if($api_key != "9d2f8d8b144a0b7fbb137688302e9ead") {

                // Output error response

                $this->output

                    ->set_content_type('application/json')

                    ->set_output(json_encode(array('error' => 'Invalid API key.')));

                return;

            }



            $this->other_title_for_layout = ' | My Calendar';



            $user_id = $this->userauth->get_session('SESS_MEMBER_ID');



            $EVENT_INTERLINX_DATE_ARR = unserialize(EVENT_INTERLINX_DATE_ARR);



            $schedule_list = array();

            for ($i_days_cnt = 0; $i_days_cnt < EVENT_INTERLINX_NO_OF_DAYS; $i_days_cnt++) {

                $schedule_record_list = $this->meetings_model->get_schedule_list_by_criteria(array('meeting_date' => $EVENT_INTERLINX_DATE_ARR[$i_days_cnt], 'receiver_id' => $user_id));

                $record = array();

                foreach ($schedule_record_list as $res_sch) {

                    $global_meet_data = array();

                    if ($res_sch['status'] == "Accepted") {

                        $global_meet_res = $this->meetings_model->get_meetings_detail_by_criteria(array('meeting_date' => $res_sch['meeting_date'], 'meeting_time_start' => $res_sch['meeting_time_start'], 'meeting_time_end' => $res_sch['meeting_time_end'], 'sender_user_id' => $res_sch['sender_id'], 'receiver_user_id' => $res_sch['receiver_id'], 'status' => 'Accepted'));



                        if (!empty($global_meet_res)) {

                            $global_meet_data = $global_meet_res;

                        } else {

                            $global_meet_res = $this->meetings_model->get_meetings_detail_by_criteria(array('meeting_date' => $res_sch['meeting_date'], 'meeting_time_start' => $res_sch['meeting_time_start'], 'meeting_time_end' => $res_sch['meeting_time_end'], 'sender_user_id' => $res_sch['receiver_id'], 'receiver_user_id' => $res_sch['sender_id'], 'status' => 'Accepted'));

                            if (!empty($global_meet_res)) {

                                $global_meet_data = $global_meet_res;

                            }

                        }

                    }

                    $res_sch['global_meet_data'] = $global_meet_data;

                    $record[] = $res_sch;

                }

                $schedule_list[$i_days_cnt] = $record;

            }



                $data = array(); // Initialize the data array



                foreach ($schedule_list as $day => $schedule_record_list) {

                    $formatted_schedule_record_list = array();



                    foreach ($schedule_record_list as $schedule) {

                        // Remove 'am' or 'pm' from the time strings

                        $meeting_time_end = trim(str_replace(array('am', 'pm'), '', $schedule['meeting_time_end']));

                        $meeting_time_start = trim(str_replace(array('am', 'pm'), '', $schedule['meeting_time_start']));



                        // Convert meeting_time_start from IST to UTC

                        $meetingTimeStartIST = new DateTime($meeting_time_start, new DateTimeZone('Asia/Kolkata'));

                        $meetingTimeStartIST->setTimezone(new DateTimeZone('UTC'));

                        $meetingTimeStartUTC = $meetingTimeStartIST->format('H:i:s');





                        // Convert meeting_time_end from IST to UTC

                        $meetingTimeEndIST = new DateTime($meeting_time_end, new DateTimeZone('Asia/Kolkata'));

                        $meetingTimeEndIST->setTimezone(new DateTimeZone('UTC'));

                        $meetingTimeEndUTC = $meetingTimeEndIST->format('H:i:s');



                        $formatted_schedule = array(

                            'meeting_date' => $schedule['meeting_date'],

                            'meeting_time_start' => $schedule['meeting_date'] . " TO ". $meetingTimeStartUTC,

                            'meeting_time_end' =>$schedule['meeting_date'] . " TO ". $meetingTimeEndUTC, // Use the converted time

                            'receiver_id' => $schedule['receiver_id'],

                            'receiver_name' => $schedule['receiver_title'] . " ". $schedule['receiver_fname']. " ". $schedule['receiver_lname'],

                            'sender_id' => $schedule['sender_id'],

                            'sender_name' => $schedule['sender_title']. " " . $schedule['sender_fname'] . " " . $schedule['sender_lname'],

                            'message'=>$schedule['message'],

                            'status' => $schedule['status'],

                            'table_no' => $schedule['table_no'],

                        );



                        // Check if there is global meeting data and format it

                        if (!empty($schedule['global_meet_data'])) {

                            $formatted_global_meet_data = array();

                            foreach ($schedule['global_meet_data'] as $global_meet) {

                                // Remove any extra spaces and 'pm' from the time string

                                $global_meeting_time_start = trim(str_replace('pm','am', '', $global_meet['meeting_time_start']));

                                $global_meeting_time_end = trim(str_replace('pm','am', $global_meet['meeting_time_end']));

                                // Convert global meeting_time_start from IST to UTC

                                $globalMeetingTimeStartIST = new DateTime($global_meeting_time_start, new DateTimeZone('Asia/Kolkata'));

                                $globalMeetingTimeStartIST->setTimezone(new DateTimeZone('UTC'));

                                $globalMeetingTimeStartUTC = $globalMeetingTimeStartIST->format('H:i:s');



                                // Convert global meeting_time_end from IST to UTC

                                $globalMeetingTimeEndIST = new DateTime($global_meeting_time_end, new DateTimeZone('Asia/Kolkata'));

                                $globalMeetingTimeEndIST->setTimezone(new DateTimeZone('UTC'));

                                $globalMeetingTimeEndUTC = $globalMeetingTimeEndIST->format('H:i:s');



                                $formatted_global_meet_data[] = array(

                                    'meeting_date' => date('Y-m-d', strtotime($global_meet['meeting_date'])),

                                    'meeting_time_start' =>$schedule['meeting_date'] . " TO ". $globalMeetingTimeStartUTC . '+00:00',

                                    'meeting_time_end' => $schedule['meeting_date'] . " TO ".$globalMeetingTimeEndUTC. '+00:00', // Use the converted time

                                    'sender_user_id' => $global_meet['sender_user_id'],

                                    'receiver_user_id' => $global_meet['receiver_user_id']

                                );

                            }

                            $formatted_schedule['global_meet_data'] = $formatted_global_meet_data;

                        }



                        $formatted_schedule_record_list[] = $formatted_schedule;

                    }



                    $data[$day] = $formatted_schedule_record_list;

                }













                //for each $schedule_list store it in array





//                $data[]= array();

//                 foreach ($schedule_list as $schedule) {

//                     $data= array(

//                         'req_date' => $schedule['req_date'],

//                         'req_time' => $schedule['req_time'],

//                         'sender_id' => $schedule['sender_id'],

//                         'sender_title' => $schedule['sender_title'],

//                         'sender_fname' => $schedule['sender_fname'],

//                         'sender_lname' => $schedule['sender_lname'],

//                         'sender_org' => $schedule['sender_org'],

//                         'sender_desig' => $schedule['sender_desig'],

//                         'sender_org_profile' => $schedule['sender_org_profile'],

//                         'sender_email' => $schedule['sender_email'],

//                         'receiver_id' => $schedule['receiver_id'],

//                         'receiver_title' => $schedule['receiver_title'],

//                         'receiver_fname' => $schedule['receiver_fname'],

//                         'receiver_lname' => $schedule['receiver_lname'],

//                         'receiver_org' => $schedule['receiver_org'],

//                         'receiver_desig' => $schedule['receiver_desig'],

//                         'receiver_org_profile' => $schedule['receiver_org_profile'],

//                         'receiver_email' => $schedule['receiver_email'],

//                         'req_type' => $schedule['req_type'],

//                         'meeting_date' => date('Y-m-d', strtotime($schedule['meeting_date'])),

//                         'meeting_time_start' => date('Y-m-d', strtotime($schedule['meeting_date'])) ."TO" .  date('H:i:s', strtotime($schedule['meeting_time_start'])),

//                         'meeting_time_end' => date('Y-m-d', strtotime($schedule['meeting_date'])) . "TO" . date('H:i:s', strtotime($schedule['meeting_time_end'])),

//                         'message' => $schedule['message'],

//                         'status' => $schedule['status'],

//                         'table_no' => $schedule['table_no'],

//                         'messege_id' => $schedule['messege_id'],

//                         'global_meet_data' => $schedule['global_meet_data']

//                     );

//                 }



            $response = array(

            //'EVENT_INTERLINX_DATE_ARR' => $EVENT_INTERLINX_DATE_ARR,

                'schedule_list' => $data

            );



            // Return the JSON response

            echo json_encode($response);

            exit;

        }

            else{

                // Output error response

                $this->output

                    ->set_content_type('application/json')

                    ->set_output(json_encode(array('error' => 'Invalid request method.')));

                return;

            }

}

    

    /**

     * This route going to be called first

     */

    public function sent_meeting_request($pageNumber = 1) {

        $this->other_title_for_layout = ' | Sent Meeting Request';

        

        //Load pagination library

        $this->load->library("pagination");

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        

        $criteria = array();

        $criteria['sender_user_id'] = $user_id;

        //Get total number of rows in table

        $totalRows = $this->meetings_model->get_meetings_list_paging_by_criteria($criteria);

        //Get pagination configuration

        $config = $this->get_paging_config('sent-meeting-request', count($totalRows));

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

        

        $this->display_template('meeting-request-sent');

    }



    public function sent_meeting_request_api($pageNumber = 1) {

        // Set the header for JSON response

        header('Content-Type: application/json');



        if($this->input->method(false) == 'get') {

            $api_key = $this->input->get_request_header('api_key', TRUE);

            if($api_key != "9d2f8d8b144a0b7fbb137688302e9ead") {

                // Output error response

                $this->output

                    ->set_content_type('application/json')

                    ->set_output(json_encode(array('error' => 'Invalid API key.')));

                return;

            }





        $this->other_title_for_layout = ' | Sent Meeting Request';



        // Load pagination library

        $this->load->library("pagination");

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');



        $criteria = array();

        $criteria['sender_user_id'] = $user_id;

        // Get total number of rows in table

        $totalRows = $this->meetings_model->get_meetings_list_paging_by_criteria($criteria);

        // Get pagination configuration

        $config = $this->get_paging_config('sent-meeting-request', count($totalRows));

        $config["per_page"] = 10;



        // Initialize pagination

        $this->pagination->initialize($config);



        $criteria['limit'] = $config["per_page"];

        $offset = intval(($pageNumber == 1 || $pageNumber == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);

        $criteria['offset'] = $offset;



        // Get order list

        $meeting_list = $this->meetings_model->get_meetings_list_paging_by_criteria($criteria);

        $data = array();



        foreach ($meeting_list as $meetings){



            $global_meeting_time_start = trim(str_replace(array('pm','am') ,'', $meetings['meeting_time_start']));

            // Convert global meeting_time_start from IST to UTC

            $globalMeetingTimeStartIST = new DateTime($global_meeting_time_start, new DateTimeZone('Asia/Kolkata'));

            $globalMeetingTimeStartIST->setTimezone(new DateTimeZone('UTC'));

            $globalMeetingTimeStartUTC = $globalMeetingTimeStartIST->format('H:i:s');



            $global_meeting_time_end = trim(str_replace(array('pm','am') ,'', $meetings['meeting_time_end']));

            // Convert global meeting_time_start from IST to UTC

            $globalMeetingTimeEndIST = new DateTime($global_meeting_time_end, new DateTimeZone('Asia/Kolkata'));

            $globalMeetingTimeEndIST->setTimezone(new DateTimeZone('UTC'));

            $globalMeetingTimeEndUTC = $globalMeetingTimeEndIST->format('H:i:s');





            $data[] = array(

                'messege_id'=> $meetings['messege_id'],

                'req_date' => $meetings['req_date'],

                'req_time' => $meetings['req_time'],

                'sender_user_id' => $meetings['sender_user_id'],

                'sender_fname' => $meetings['sender_fname'],

                'sender_lname' => $meetings['sender_lname'],

                'sender_email' => $meetings['sender_email'],

                'sender_org' => $meetings['sender_org'],

                'sender_org_profile'=> $meetings['sender_org_profile'],

                'sender_desig' => $meetings['sender_desig'],

                'sender_mob_cntry_code' => $meetings['sender_mob_cntry_code'],

                'sender_mob_number' => $meetings['sender_mob_number'],

                'receiver_user_id' => $meetings['receiver_user_id'],

                'receiver_title' => $meetings['receiver_title'],

                'receiver_fname'=> $meetings['receiver_fname'],

                'receiver_lname'=> $meetings['receiver_lname'],

                'receiver_email'=> $meetings['receiver_email'],

                'receiver_org'=> $meetings['receiver_org'],

                'receiver_org_profile'=> $meetings['receiver_org_profile'],

                'receiver_desig'=> $meetings['receiver_desig'],

                'receiver_mob_cntry_code'=> $meetings['receiver_mob_cntry_code'],

                'receiver_mob_number'=> $meetings['receiver_mob_number'],

                'meeting_date'=> $meetings['meeting_date'],

                'meeting_time_start'=> $meetings['meeting_date'] . " TO ".$globalMeetingTimeStartUTC. '+00:00',

                'meeting_time_end'=> $meetings['meeting_date'] . " TO ".$globalMeetingTimeEndUTC. '+00:00',

                'messege'=> $meetings['messege'],

                'status'=> $meetings['status'],

                'table_no'=> $meetings['table_no'],

            );

        }





        $response = array(

            'meeting_list' => $data,

        );



        // Return the JSON response

        echo json_encode($response);

        exit;

        }

        else{

            // Output error response

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode(array('error' => 'Invalid request method.')));

            return;

        }

    }





    /**

     * This route going to be called first

     */

    public function received_meeting_request($pageNumber = 1) {

        $this->other_title_for_layout = ' | Received Meeting Request';

        

        //Load pagination library

        $this->load->library("pagination");

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        

        $criteria = array();

        $criteria['receiver_user_id'] = $user_id;

        //Get total number of rows in table

        $totalRows = $this->meetings_model->get_meetings_list_paging_by_criteria($criteria);

        //Get pagination configuration

        $config = $this->get_paging_config('received-meeting-request', count($totalRows));

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

        

        foreach ($meeting_list as $meeting) {

            if($meeting['read_flag'] != 'True') {

                $this->meetings_model->update_meetings_details(array('read_flag'=>'True'), array('messege_id'=>$meeting['messege_id']));

            }

        }

        

        $this->response['meeting_list'] = $meeting_list;

        $this->response['pagination'] = $this->pagination->create_links();

        $this->response['offset'] = $offset;

        //print_r($this->response);

        

        $this->display_template('meeting-request-received');

    }



    public function received_meeting_request_api($pageNumber = 1) {

        // Set the header for JSON response

        header('Content-Type: application/json');



        if($this->input->method(false) == 'get') {

            $api_key = $this->input->get_request_header('api_key', TRUE);

            if ($api_key != "9d2f8d8b144a0b7fbb137688302e9ead") {

                // Output error response

                $this->output

                    ->set_content_type('application/json')

                    ->set_output(json_encode(array('error' => 'Invalid API key.')));

                return;

            }



            $this->other_title_for_layout = ' | Received Meeting Request';



            // Load pagination library

            $this->load->library("pagination");

            $user_id = $this->userauth->get_session('SESS_MEMBER_ID');



            $criteria = array();

            $criteria['receiver_user_id'] = $user_id;

            // Get total number of rows in table

            $totalRows = $this->meetings_model->get_meetings_list_paging_by_criteria($criteria);

            // Get pagination configuration

            $config = $this->get_paging_config('received-meeting-request', count($totalRows));

            $config["per_page"] = 10;



            // Initialize pagination

            $this->pagination->initialize($config);



            $criteria['limit'] = $config["per_page"];

            $offset = intval(($pageNumber == 1 || $pageNumber == 0) ? 0 : ($pageNumber * $config['per_page']) - $config['per_page']);

            $criteria['offset'] = $offset;



            // Get order list

            $meeting_list = $this->meetings_model->get_meetings_list_paging_by_criteria($criteria);



            // Mark meetings as read

            foreach ($meeting_list as &$meeting) {

                if ($meeting['read_flag'] != 'True') {

                    $this->meetings_model->update_meetings_details(array('read_flag' => 'True'), array('messege_id' => $meeting['messege_id']));

                }

            }





            // Initialize an empty array to hold data for all meetings

            $data = array();



            // Iterate over $meeting_list to create a sub-array for each meeting's details

            foreach ($meeting_list as $meeting) {



                $meeting_time_start = trim(str_replace(array('am', 'pm'), '', $meeting['meeting_time_start']));

                $meetingTimeEnd = trim(str_replace(array('am', 'pm'), '',$meeting['meeting_time_end']));



                $meetingTimeStartIST = new DateTime($meeting_time_start, new DateTimeZone('Asia/Kolkata'));

                $meetingTimeStartIST->setTimezone(new DateTimeZone('UTC'));

                $meetingTimeStartUTC = $meetingTimeStartIST->format('H:i:s');



                $meetingTimeEndIST = new DateTime($meetingTimeEnd, new DateTimeZone('Asia/Kolkata'));

                $meetingTimeEndIST->setTimezone(new DateTimeZone('UTC'));

                $meetingTimeEndUTC = $meetingTimeEndIST->format('H:i:s');







                $data[] = array(

                    'messege_id' => $meeting['messege_id'],

                    'req_date' => $meeting['req_date'],

                    'req_time' => $meeting['req_time'],

                    'sender_user_id' => $meeting['sender_user_id'],

                    'sender_title' => $meeting['sender_title'],

                    'sender_fname' => $meeting['sender_fname'],

                    'sender_lname' => $meeting['sender_lname'],

                    'sender_email' => $meeting['sender_email'],

                    'sender_org' => $meeting['sender_org'],

                    'sender_desig' => $meeting['sender_desig'],

                    'sender_mob_number' => $meeting['sender_mob_number'],





                    'receiver_user_id' => $meeting['receiver_user_id'],

                    'receiver_title' => $meeting['receiver_title'],

                    'receiver_fname' => $meeting['receiver_fname'],

                    'receiver_lname' => $meeting['receiver_lname'],

                    'receiver_email' => $meeting['receiver_email'],

                    'receiver_org' => $meeting['receiver_org'],

                    'receiver_desig' => $meeting['receiver_desig'],

                    'receiver_mob_number' => $meeting['receiver_mob_number'],

                    'meeting_time_start' => date('Y-m-d', strtotime($meeting['meeting_date'])) ." TO ". $meetingTimeStartUTC ,

                    'meeting_time_end' => date('Y-m-d', strtotime($meeting['meeting_date'])) ." TO ". $meetingTimeEndUTC,

                    'messege' => $meeting['messege'],

                    'status' => $meeting['status'],

                    'table_no' => $meeting['table_no'],

                );

            }



            $response = array(

                'meeting_list' => $data,

            );



            // Return the JSON response

            echo json_encode($response);

            exit;

        }

        else{

            // Output error response

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode(array('error' => 'Invalid request method.')));

            return;



        }

    }

    

    public function set_meeting_status($req_status_id, $req_stat) {

        ini_set('memory_limit', '100M');

        if( ($req_stat == "") || ($req_status_id == "") )

        {

            $this->session->set_flashdata('is_error', 'Error in Process.Please Try after some time.');

            //$this->redirect_referer();

			redirect('received-meeting-request');

        }

        

        $responce_date = date("Y-m-d");

        $responce_time = date("h:i:s a");

        

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        $met_req_row_ans = $this->meetings_model->get_meetings_detail_by_criteria(array('messege_id'=>$req_status_id, 'receiver_user_id'=>$user_id));



        if(empty($met_req_row_ans)) {

            //$this->redirect_referer();

			redirect('received-meeting-request');

        }

        

        $cl_name = $met_req_row_ans['sender_title'].$met_req_row_ans['sender_fname']." ".$met_req_row_ans['sender_lname'];

        $msg_id_gbl=$met_req_row_ans['messege_id'];

        

        $temp_met_sender_org_profile = ($met_req_row_ans['sender_org_profile']);

        $temp_met_receiver_org_profile = ($met_req_row_ans['receiver_org_profile']);

        

        //----------------------------------- Checking Sender Block Availability

        $temp_chk_send_usr_slot_qr1_id = $this->meetings_model->get_schedule_detail_by_criteria(array('meeting_date'=> $met_req_row_ans['meeting_date'], 'meeting_time_start' => $met_req_row_ans['meeting_time_start'], 'receiver_id' => $met_req_row_ans['sender_user_id']));

        

        if($req_stat == "Accepted")

        {

            if( ($temp_chk_send_usr_slot_qr1_id['status'] == "Accepted") )

            {

                $this->session->set_flashdata('is_error', 'Sender have Already Confirmed Another Meeting At This Slot.');

                //$this->redirect_referer();

				redirect('received-meeting-request');

            }

        }

        

        //----------------------------------- Checking Receiver  Block Availability

        $temp_chk_rec_user_slot_qr1_id = $this->meetings_model->get_schedule_detail_by_criteria(array('meeting_date' => $met_req_row_ans['meeting_date'], 'meeting_time_start'=> $met_req_row_ans['meeting_time_start'], 'receiver_id' => $user_id));

        

        if($req_stat == "Accepted")

        {

            

            if( ($temp_chk_rec_user_slot_qr1_id['status'] == "Accepted") )

            {

                $this->session->set_flashdata('is_error', 'You have Already Confirmed Another Meeting At This Slot.Please Modify your schedule using Edit My Schedule');

                //$this->redirect_referer();

				redirect('received-meeting-request');

            }

        }

        $temp_select_avb_table_no = "";

        $temp_total_avb_table = "";

        $temp_total_alloc_table = "";

        $temp_total_rem_table = "";

        

        $no_meeting_table_flg = "false";

        $temp_metting_location = "";

        $temp_temp_metting_location_hall = "";

        $temp_metting_location_stall_name = "";

        $temp_metting_location_stall_no = "";

        

        $zoom_user_id = '';

        if($req_stat == "Accepted")

        {

            ////------------------------------ start checking sender is exhibitor and making meeting at stall

            $qr_chk_sender_no_mtng_tbl_ans_row = $this->interlinx_reg_model->get_data1($met_req_row_ans['sender_user_id']);

            if(isset($qr_chk_sender_no_mtng_tbl_ans_row['metting_location']) && (($qr_chk_sender_no_mtng_tbl_ans_row['metting_location'] == "In Exhibition Stall") && ($qr_chk_sender_no_mtng_tbl_ans_row['metting_location_hall'] != "") && ($qr_chk_sender_no_mtng_tbl_ans_row['metting_location_stall_name'] != "") && ($qr_chk_sender_no_mtng_tbl_ans_row['metting_location_stall_no'] != "") )){

                $no_meeting_table_flg = "true";

                $temp_metting_location = $qr_chk_sender_no_mtng_tbl_ans_row['metting_location'];

                $temp_temp_metting_location_hall = $qr_chk_sender_no_mtng_tbl_ans_row['metting_location_hall'];

                $temp_metting_location_stall_name = $qr_chk_sender_no_mtng_tbl_ans_row['metting_location_stall_name'];

                $temp_metting_location_stall_no = $qr_chk_sender_no_mtng_tbl_ans_row['metting_location_stall_no'];

                

                $temp_select_avb_table_no = "Location: $temp_temp_metting_location_hall, Stall: $temp_metting_location_stall_name, Stall No.: $temp_metting_location_stall_no ";

            }

            

            //------------------------------ start checking receiver is exhibitor and making meeting at stall

            $qr_chk_receiver_no_mtng_tbl_ans_row = $this->interlinx_reg_model->get_data2($user_id);

            if(isset($qr_chk_sender_no_mtng_tbl_ans_row['metting_location']) && (($qr_chk_receiver_no_mtng_tbl_ans_row['metting_location'] == "In Exhibition Stall") && ($qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_hall'] != "") && ($qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_stall_name'] != "") && ($qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_stall_no'] != "") )){

                $no_meeting_table_flg = "true";

                $temp_metting_location = $qr_chk_receiver_no_mtng_tbl_ans_row['metting_location'];

                $temp_temp_metting_location_hall = $qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_hall'];

                $temp_metting_location_stall_name = $qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_stall_name'];

                $temp_metting_location_stall_no = $qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_stall_no'];

                

                $temp_select_avb_table_no = "Location: $temp_temp_metting_location_hall, Stall: $temp_metting_location_stall_name, Stall No.: $temp_metting_location_stall_no ";

            }

            if($no_meeting_table_flg != "true"){

                //--------------------------------------- Start checking table availability

                //$qr_check_table_avb_id = mysql_query("SELECT * FROM $EVENT_TBL_AVBL_TIME_SLOTS WHERE meeting_date = '$met_req_row_ans[meeting_date]' AND meeting_time_start = '$met_req_row_ans[meeting_time_start]' ");

                $qr_check_table_avb_ans_row = $this->meetings_model->get_available_timeslot_detail_by_criteria(array('meeting_date' => $met_req_row_ans['meeting_date'], 'meeting_time_start' => $met_req_row_ans['meeting_time_start']));

                $temp_total_avb_table = $qr_check_table_avb_ans_row['total_table'];

                $temp_total_alloc_table = $qr_check_table_avb_ans_row['allocated_table'];

                $temp_total_rem_table =	$qr_check_table_avb_ans_row['rem_table'];

                if($temp_total_rem_table <= 0){

                    $this->session->set_flashdata('is_error', 'All Tables are full for Selected  date & time slot 1 . Please contact admin on ' . EVENT_FROM_EMAIL);

                    //$this->redirect_referer();

					redirect('received-meeting-request');

                }

                if( ($temp_total_avb_table - $temp_total_alloc_table) <= 0 )

                {

                    $this->session->set_flashdata('is_error', 'All Tables are full for Selected  date & time slot 2. Please contact admin on ' . EVENT_FROM_EMAIL);

                    //$this->redirect_referer();

					redirect('received-meeting-request');

                }

                if(($temp_total_avb_table == $temp_total_alloc_table))

                {

                    $this->session->set_flashdata('is_error', 'All Tables are full for Selected  date & time slot 3. Please contact admin on ' . EVENT_FROM_EMAIL);

                    //$this->redirect_referer();

					redirect('received-meeting-request');

                }

                

                if($qr_check_table_avb_ans_row['status'] == "Over")

                {

                    $this->session->set_flashdata('is_error', 'All Tables are full for Selected  date & time slot 4. Please contact admin on ' . EVENT_FROM_EMAIL);

                    //$this->redirect_referer();

					redirect('received-meeting-request');

                }

                

                //-----------------------Start Searching for which Table is available for this slot	

                //$qr_search_table_for_free_slot_id = mysql_query("SELECT * FROM $EVENT_TBL_ALL_TABLE_ALL WHERE ( (meeting_date = '$met_req_row_ans[meeting_date]') AND (meeting_time_start = '$met_req_row_ans[meeting_time_start]') AND ((status != 'Over') OR (ISNULL(status))) ) ")or die(mysql_error());

                $qr_search_table_for_free_slot_num_rows = $this->meetings_model->get_schedule_data1($met_req_row_ans['meeting_date'], $met_req_row_ans['meeting_time_start']);



                if(empty($qr_search_table_for_free_slot_num_rows)){



                    $this->session->set_flashdata('is_error', 'All Tables are full for Selected  date & time slot 5. Please contact admin on ' . EVENT_FROM_EMAIL);

                    //$this->redirect_referer();

					redirect('received-meeting-request');

                }

                

                $temp_table_allocation_status_flag = "Failed";



                foreach ($qr_search_table_for_free_slot_num_rows as $qr_search_table_for_free_slot_ans) {

                    $temp_select_avb_table_no = $qr_search_table_for_free_slot_ans['table_no'];

                    

                    //$qr_fetch_sel_table_info_id = mysql_query("SELECT * FROM $EVENT_TBL_ALL_TABLE_ALL WHERE ( (meeting_date = '$met_req_row_ans[meeting_date]') AND (meeting_time_start = '$met_req_row_ans[meeting_time_start]') AND (table_no='$temp_select_avb_table_no') ) ");

                    $qr_fetch_sel_table_info_ans = $this->meetings_model->get_schedule_data2($met_req_row_ans['meeting_date'], $met_req_row_ans['meeting_time_start'], $temp_select_avb_table_no);

                    

                    if($qr_fetch_sel_table_info_ans['status'] == "Over")

                    {

                        continue;

                    } else{

                        //----------------------------- Start Making entry in available table ----------------------------------------------

                        $collection = array('req_date'=>$met_req_row_ans['req_date'],'req_time'=>$met_req_row_ans['req_time'],'req_type'=>'Online','status'=>'Over','messege_id'=>$met_req_row_ans['messege_id'],'sender_id'=>$met_req_row_ans['sender_user_id'],'sender_org'=>$met_req_row_ans['sender_org'],'sender_title'=>$met_req_row_ans['sender_title'],'sender_fname'=>$met_req_row_ans['sender_fname'],'sender_lname'=>$met_req_row_ans['sender_lname'],'sender_desig'=>$met_req_row_ans['sender_desig'],'sender_org_profile'=>strip_tags($temp_met_sender_org_profile),'sender_email'=>$met_req_row_ans['sender_email'],'receiver_id'=>$met_req_row_ans['receiver_user_id'],'receiver_org'=>$met_req_row_ans['receiver_org'],'receiver_title'=>$met_req_row_ans['receiver_title'],'receiver_fname'=>$met_req_row_ans['receiver_fname'],'receiver_lname'=>$met_req_row_ans['receiver_lname'],'receiver_desig'=>$met_req_row_ans['receiver_desig'],'receiver_org_profile'=>strip_tags($temp_met_receiver_org_profile),'receiver_email'=>$met_req_row_ans['receiver_email']);

                        //mysql_query("UPDATE $EVENT_TBL_ALL_TABLE_ALL SET req_date='$met_req_row_ans[req_date]',req_time='$met_req_row_ans[req_time]',req_type='Online',status='Over',messege_id='$met_req_row_ans[messege_id]',sender_id='$met_req_row_ans[sender_user_id]',sender_org='$met_req_row_ans[sender_org]',sender_title='$met_req_row_ans[sender_title]',sender_fname='$met_req_row_ans[sender_fname]',sender_lname='$met_req_row_ans[sender_lname]',sender_desig='$met_req_row_ans[sender_desig]',sender_org_profile='$temp_met_sender_org_profile',sender_email='$met_req_row_ans[sender_email]',receiver_id='$met_req_row_ans[receiver_user_id]',receiver_org='$met_req_row_ans[receiver_org]',receiver_title='$met_req_row_ans[receiver_title]',receiver_fname='$met_req_row_ans[receiver_fname]',receiver_lname='$met_req_row_ans[receiver_lname]',receiver_desig='$met_req_row_ans[receiver_desig]',receiver_org_profile='$temp_met_receiver_org_profile',receiver_email='$met_req_row_ans[receiver_email]' WHERE ( (meeting_date = '$met_req_row_ans[meeting_date]') AND (meeting_time_start = '$met_req_row_ans[meeting_time_start]') AND (table_no='$temp_select_avb_table_no') AND ((status != 'Over') OR (ISNULL(status))) )")or die(mysql_error());//---------------------------------------

                        $this->meetings_model->update_data_all($collection, $met_req_row_ans['meeting_date'], $met_req_row_ans['meeting_time_start'], $temp_select_avb_table_no);

                        //----------------------------- End Making entry in available table ----------------------------------------------

                        

                        //----------------------------- Start updating meeting table availability -------------------------------------------

                        

                        $curr_rem_table = ($temp_total_rem_table -1);

                        $curr_alloc_table = ($temp_total_alloc_table + 1);

                        //mysql_query("UPDATE $EVENT_TBL_AVBL_TIME_SLOTS SET read_flag='False',allocated_table='$curr_alloc_table',rem_table='$curr_rem_table' WHERE (meeting_date = '$met_req_row_ans[meeting_date]') AND (meeting_time_start = '$met_req_row_ans[meeting_time_start]') AND (status != 'Over') ")or die(mysql_error());

                        $collection = array('read_flag'=>'False','allocated_table'=>$curr_alloc_table,'rem_table'=>$curr_rem_table);

                        $this->meetings_model->update_data_all2($collection, $met_req_row_ans['meeting_date'], $met_req_row_ans['meeting_time_start']);

                        

                        if(($curr_rem_table <= 0)||($curr_alloc_table == $temp_total_alloc_table))

                        {

                            $this->meetings_model->update_available_timeslot_details(array('status'=>'Over'), array('meeting_date'=>$met_req_row_ans['meeting_date'], 'meeting_time_start'=>$met_req_row_ans['meeting_time_start']));

                            //mysql_query("UPDATE $EVENT_TBL_AVBL_TIME_SLOTS SET status='Over' WHERE (meeting_date = '$met_req_row_ans[meeting_date]') AND (meeting_time_start = '$met_req_row_ans[meeting_time_start]') ")or die(mysql_error());

                        }

                        

                        //----------------------------- End Making entry in available table-------------------------------------------------

                        

                        $temp_table_allocation_status_flag = "Success";

                        break;

                    }

                }

                

                //Here to check Zoom meeting is scheduled or not on same time

                if($temp_table_allocation_status_flag == "Success" && IS_ZOOM_MEETING_ACTIVATE) {

                    $ZOOM_USER_ID_LIST = unserialize(ZOOM_USER_ID_LIST);

                    foreach($ZOOM_USER_ID_LIST as $zoomUserId) {

                        $qr_fetch_sel_table_info_id = $this->meetings_model->get_meetings_detail_by_criteria(array('meeting_date'=>$met_req_row_ans['meeting_date'], 'meeting_time_start'=>$met_req_row_ans['meeting_time_start'],'zoom_user_id'=>$zoomUserId,'status'=>'Accepted'));

                        //$qr_fetch_sel_table_info_id = mysql_query("SELECT * FROM $EVENT_TBL_GLBL_MEETING WHERE meeting_date = '$met_req_row_ans[meeting_date]' AND meeting_time_start = '$met_req_row_ans[meeting_time_start]' AND zoom_user_id='$zoomUserId' AND status='Accepted' ");

                        if(empty($qr_fetch_sel_table_info_id)) {

                            $zoom_user_id = $zoomUserId;

                            $temp_table_allocation_status_flag = "Success";

                            break;

                        } else {

                            $temp_table_allocation_status_flag = "Failed";

                        }

                    }

                }

                if($temp_table_allocation_status_flag == "Failed"){

                    $this->session->set_flashdata('is_error', 'All Tables are full for Selected  date & time slot. Please contact admin on ' . EVENT_FROM_EMAIL);

                    //$this->redirect_referer();

					redirect('received-meeting-request');

                }

            }

        }

        

        if($req_stat == "Accepted") // && !empty($zoom_user_id))

        {

            $msg_details = addslashes($met_req_row_ans['messege']);

            

            $collection = array('req_date'=>$responce_date,'req_time'=>$responce_time,'sender_title'=>$met_req_row_ans['sender_title'],'sender_fname'=>$met_req_row_ans['sender_fname'],'sender_lname'=>$met_req_row_ans['sender_lname'],'sender_org'=>$met_req_row_ans['sender_org'],'sender_desig'=>$met_req_row_ans['sender_desig'],'sender_email'=>$met_req_row_ans['sender_email'],'sender_org_profile'=>$temp_met_sender_org_profile,'sender_id'=>$met_req_row_ans['sender_user_id'],'req_type'=>'Received','meeting_date'=>$met_req_row_ans['meeting_date'],'meeting_time_start'=>$met_req_row_ans['meeting_time_start'],'meeting_time_end'=>$met_req_row_ans['meeting_time_end'],'message'=>$msg_details,'status'=>$req_stat,'messege_id'=>$msg_id_gbl,'table_no'=>$temp_select_avb_table_no);

            //mysql_query("UPDATE $EVENT_TBL_ALL_USR_SHDL SET req_date='$responce_date',req_time='$responce_time',sender_title='$met_req_row_ans[sender_title]',sender_fname='$met_req_row_ans[sender_fname]',sender_lname='$met_req_row_ans[sender_lname]',sender_org='$met_req_row_ans[sender_org]',sender_desig='$met_req_row_ans[sender_desig]',sender_email='$met_req_row_ans[sender_email]',sender_org_profile='$temp_met_sender_org_profile',sender_id='$met_req_row_ans[sender_user_id]',req_type='Received',meeting_date='$met_req_row_ans[meeting_date]',meeting_time_start='$met_req_row_ans[meeting_time_start]',meeting_time_end='$met_req_row_ans[meeting_time_end]',message='$msg_details',status='$req_stat',messege_id='$msg_id_gbl',table_no='$temp_select_avb_table_no' WHERE ( meeting_date = '$met_req_row_ans[meeting_date]') AND ( meeting_time_start = '$met_req_row_ans[meeting_time_start]') AND (receiver_id = '$res[user_id]')");

            $condition = array('meeting_date' => $met_req_row_ans['meeting_date'], 'meeting_time_start' => $met_req_row_ans['meeting_time_start'],'receiver_id' => $user_id);

            $this->meetings_model->update_schedule_details($collection, $condition);

            

            $condition = array('meeting_date' => $met_req_row_ans['meeting_date'], 'meeting_time_start' => $met_req_row_ans['meeting_time_start'],'receiver_id' => $met_req_row_ans['sender_user_id']);

            $collection = array('req_date'=>$responce_date,'req_time'=>$responce_time,'sender_title'=>$met_req_row_ans['receiver_title'],'sender_fname'=>$met_req_row_ans['receiver_fname'],'sender_lname'=>$met_req_row_ans['receiver_lname'],'sender_org'=>$met_req_row_ans['receiver_org'],'sender_desig'=>$met_req_row_ans['receiver_desig'],'sender_email'=>$met_req_row_ans['receiver_email'],'sender_org_profile'=>$temp_met_receiver_org_profile,'sender_id'=>$met_req_row_ans['receiver_user_id'],'req_type'=>'Send','meeting_date'=>$met_req_row_ans['meeting_date'],'meeting_time_start'=>$met_req_row_ans['meeting_time_start'],'meeting_time_end'=>$met_req_row_ans['meeting_time_end'],'message'=>$msg_details,'status'=>$req_stat,'messege_id'=>$msg_id_gbl,'table_no'=>$temp_select_avb_table_no);

            //mysql_query("UPDATE $EVENT_TBL_ALL_USR_SHDL SET req_date='$responce_date',req_time='$responce_time',sender_title='$met_req_row_ans[receiver_title]',sender_fname='$met_req_row_ans[receiver_fname]',sender_lname='$met_req_row_ans[receiver_lname]',sender_org='$met_req_row_ans[receiver_org]',sender_desig='$met_req_row_ans[receiver_desig]',sender_email='$met_req_row_ans[receiver_email]',sender_org_profile='$temp_met_receiver_org_profile',sender_id='$met_req_row_ans[receiver_user_id]',req_type='Send',meeting_date='$met_req_row_ans[meeting_date]',meeting_time_start='$met_req_row_ans[meeting_time_start]',meeting_time_end='$met_req_row_ans[meeting_time_end]',message='$msg_details',status='$req_stat',messege_id='$msg_id_gbl',table_no='$temp_select_avb_table_no' WHERE ( meeting_date = '$met_req_row_ans[meeting_date]') AND ( meeting_time_start = '$met_req_row_ans[meeting_time_start]') AND (receiver_id = '$met_req_row_ans[sender_user_id]')");

            $this->meetings_model->update_schedule_details($collection, $condition);

            

			if(isset($zoom_user_id) && !empty($zoom_user_id)) {

				$this->load->library('zoom');

				$zoom = $this->zoom;

				

				$meeting_time_start = str_replace('am', '', $met_req_row_ans['meeting_time_start']);

				$meeting_time_start = str_replace('pm', '', $meeting_time_start);

				$meeting_time_start = trim($meeting_time_start);

				$post_time  = $met_req_row_ans['meeting_date'] . ' ' . $meeting_time_start;

				$start_time = $met_req_row_ans['meeting_date'] . 'T' . $meeting_time_start;//gmdate( "Y-m-d\TH:i:sZ", strtotime( $post_time ) );

				$createAMeetingArray = array();

				$mess = $met_req_row_ans['messege'];

				if( strlen( $met_req_row_ans['messege'] ) >= 100 ) {

					$pos=strpos($met_req_row_ans['messege'], ' ', 100);

					$mess = substr($met_req_row_ans['messege'],0,$pos );

				}

				

				$createAMeetingArray['topic']      = $mess;

				$createAMeetingArray['type']       = 2; //Scheduled

				$createAMeetingArray['start_time'] = $start_time;

				$createAMeetingArray['timezone']   = 'Asia/Calcutta';

				$createAMeetingArray['duration']   = 30;

				$createAMeetingArray['password']   = $zoom->random_strings();

				//$createAMeetingArray['agenda']     = 'This meeting created by API';

				$createAMeetingArray['settings']   = array(

					'join_before_host'  => true,

					'host_video'        => false,

					'participant_video' => true,

					'in_meeting'        => true,

					'waiting_room'      => false);

				//print_r($createAMeetingArray);exit;

				$response = $zoom->create_meeting($createAMeetingArray, $zoom_user_id);

				//print_r($response);exit;

				if(isset($response['id']) && !empty($response['id'])) {

					$meeting_id = $response['id'];

					$password = $response['password'];

					//$zoom_host_link = $response['start_url'];

					$zoom_host_link = $zoom_participant_link = $response['join_url'];

					$zoom_meeting_created_at = date('Y-m-d H:i:s');

					$collection = array('zoom_user_id'=>$zoom_user_id, 'meeting_id'=>$meeting_id,'password'=>$password,'zoom_host_link'=>$zoom_host_link,'zoom_participant_link'=>$zoom_participant_link, 'zoom_meeting_created_at'=>$zoom_meeting_created_at);

					$condition = array('messege_id' =>$req_status_id,'sender_user_id' =>$met_req_row_ans['sender_user_id'],'meeting_date' =>$met_req_row_ans['meeting_date'],'meeting_time_start' => $met_req_row_ans['meeting_time_start']);

					$this->meetings_model->update_meetings_details($collection, $condition);

					//$sql = "UPDATE $EVENT_TBL_GLBL_MEETING SET zoom_user_id='$zoom_user_id', meeting_id='$meeting_id',password='$password',zoom_host_link='$zoom_host_link',zoom_participant_link='$zoom_participant_link', zoom_meeting_created_at='$zoom_meeting_created_at' WHERE ( (messege_id = '$req_status_id') AND (sender_user_id = '$met_req_row_ans[sender_user_id]') AND (meeting_date = '$met_req_row_ans[meeting_date]') AND (meeting_time_start = '$met_req_row_ans[meeting_time_start]') )";

					//echo $sql;exit;

				}

			}

        }

        

        $condition = array('messege_id' =>$req_status_id,'sender_user_id' =>$met_req_row_ans['sender_user_id'],'meeting_date' =>$met_req_row_ans['meeting_date'],'meeting_time_start' => $met_req_row_ans['meeting_time_start']);

        $this->meetings_model->update_meetings_details(array('status'=>$req_stat,'table_no'=>$temp_select_avb_table_no), $condition);

        //mysql_query("UPDATE $EVENT_TBL_GLBL_MEETING SET status='$req_stat',table_no='$temp_select_avb_table_no' WHERE ( (messege_id = '$req_status_id') AND (sender_user_id = '$met_req_row_ans[sender_user_id]') AND (meeting_date = '$met_req_row_ans[meeting_date]') AND (meeting_time_start = '$met_req_row_ans[meeting_time_start]') )");

        

        $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));

        $this->response['res'] = $res;

        $this->response['req_stat'] = $req_stat;

        $this->response['met_req_row_ans'] = $met_req_row_ans;

        $this->response['temp_select_avb_table_no'] = $temp_select_avb_table_no;

        //---------------------Email For meeting Request Sender

        // load emailer file

        $message = $this->get_template('email/emailer_meeting_request_accept_sender');

        //echo $message;

        $subject = "Updated Status of Meeting Request";

        $qr_for_sec_email_of_sender_ans = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$met_req_row_ans['sender_user_id']));

        if($qr_for_sec_email_of_sender_ans['pri_email'] != "")

        {

            if($qr_for_sec_email_of_sender_ans['sec_email'] != "")

            {

                $recipients = array($qr_for_sec_email_of_sender_ans['pri_email'],$qr_for_sec_email_of_sender_ans['sec_email'],'test.interlinks@gmail.com');

            }

            else

            {

                $recipients = array($qr_for_sec_email_of_sender_ans['pri_email'],'test.interlinks@gmail.com');

            }

        }

        else

        {

            $recipients = array($met_req_row_ans['sender_email'],'test.interlinks@gmail.com');

        }

        

        $this->send_mail($subject, $message, $recipients);

        

        //--------------------------Email For meeting Request Receiver

        $message = $this->get_template('email/emailer_meeting_request_accept_reciever');

        //echo $message;

        $subject = "Updated Status of Meeting Request";

        if($res['sec_email'] != "")

        {

            $recipients = array($res['pri_email'],$res['sec_email'],'test.interlinks@gmail.com');

        }

        else

        {

            $recipients = array($res['pri_email'],'test.interlinks@gmail.com');

        }

        $this->send_mail($subject, $message, $recipients);

        //exit;

        $this->session->set_flashdata('is_success', 'You have successfully <strong>' . $req_stat . '</strong> the meeting on ' . $met_req_row_ans['meeting_date'] . ' @' . $met_req_row_ans['meeting_time_start']." - ".$met_req_row_ans['meeting_time_end']);

		//exit;

        //$this->redirect_referer();

		redirect('received-meeting-request');

    }



    public function set_meeting_status_api($req_status_id, $req_stat) {

        ini_set('memory_limit', '100M');



        if($this->input->method(false) == 'post') {

            $api_key = $this->input->get_request_header('api_key', TRUE);

            if($api_key != "9d2f8d8b144a0b7fbb137688302e9ead") {

                // Output error response

                $this->output

                    ->set_content_type('application/json')

                    ->set_output(json_encode(array('error' => 'Invalid API key.')));

                return;

            }



        if (($req_stat == "") || ($req_status_id == "")) {

            $response = array('status' => 'error', 'message' => 'Error in Process. Please Try after some time.');

            echo json_encode($response);

            return;

        }



        $responce_date = date("Y-m-d");

        $responce_time = date("h:i:s a");



        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        $met_req_row_ans = $this->meetings_model->get_meetings_detail_by_criteria(array('messege_id' => $req_status_id, 'receiver_user_id' => $user_id));

        if (empty($met_req_row_ans)) {

            $response = array('status' => 'error', 'message' => 'Meeting request not found.');

            echo json_encode($response);

            return;

        }



        $cl_name = $met_req_row_ans['sender_title'] . $met_req_row_ans['sender_fname'] . " " . $met_req_row_ans['sender_lname'];

        $msg_id_gbl = $met_req_row_ans['messege_id'];



        $temp_met_sender_org_profile = $met_req_row_ans['sender_org_profile'];

        $temp_met_receiver_org_profile = $met_req_row_ans['receiver_org_profile'];



        // Checking Sender Block Availability

        $temp_chk_send_usr_slot_qr1_id = $this->meetings_model->get_schedule_detail_by_criteria(array(

            'meeting_date' => $met_req_row_ans['meeting_date'],

            'meeting_time_start' => $met_req_row_ans['meeting_time_start'],

            'receiver_id' => $met_req_row_ans['sender_user_id']

        ));



        if ($req_stat == "Accepted" && $temp_chk_send_usr_slot_qr1_id['status'] == "Accepted") {

            $response = array('status' => 'error', 'message' => 'Sender has already confirmed another meeting at this slot.');

            echo json_encode($response);

            return;

        }



        // Checking Receiver Block Availability

        $temp_chk_rec_user_slot_qr1_id = $this->meetings_model->get_schedule_detail_by_criteria(array(

            'meeting_date' => $met_req_row_ans['meeting_date'],

            'meeting_time_start' => $met_req_row_ans['meeting_time_start'],

            'receiver_id' => $user_id

        ));



        if ($req_stat == "Accepted" && $temp_chk_rec_user_slot_qr1_id['status'] == "Accepted") {

            $response = array('status' => 'error', 'message' => 'You have already confirmed another meeting at this slot. Please modify your schedule using Edit My Schedule');

            echo json_encode($response);

            return;

        }



        $temp_select_avb_table_no = "";

        $no_meeting_table_flg = "false";

        $zoom_user_id = '';



        if ($req_stat == "Accepted") {

            // Check if sender is an exhibitor and making meeting at stall

            $qr_chk_sender_no_mtng_tbl_ans_row = $this->interlinx_reg_model->get_data1($met_req_row_ans['sender_user_id']);

            if (isset($qr_chk_sender_no_mtng_tbl_ans_row['metting_location']) &&

                ($qr_chk_sender_no_mtng_tbl_ans_row['metting_location'] == "In Exhibition Stall") &&

                !empty($qr_chk_sender_no_mtng_tbl_ans_row['metting_location_hall']) &&

                !empty($qr_chk_sender_no_mtng_tbl_ans_row['metting_location_stall_name']) &&

                !empty($qr_chk_sender_no_mtng_tbl_ans_row['metting_location_stall_no'])) {



                $no_meeting_table_flg = "true";

                $temp_select_avb_table_no = "Location: " . $qr_chk_sender_no_mtng_tbl_ans_row['metting_location_hall'] .

                    ", Stall: " . $qr_chk_sender_no_mtng_tbl_ans_row['metting_location_stall_name'] .

                    ", Stall No.: " . $qr_chk_sender_no_mtng_tbl_ans_row['metting_location_stall_no'];

            }



            // Check if receiver is an exhibitor and making meeting at stall

            $qr_chk_receiver_no_mtng_tbl_ans_row = $this->interlinx_reg_model->get_data2($user_id);

            if (isset($qr_chk_receiver_no_mtng_tbl_ans_row['metting_location']) &&

                ($qr_chk_receiver_no_mtng_tbl_ans_row['metting_location'] == "In Exhibition Stall") &&

                !empty($qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_hall']) &&

                !empty($qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_stall_name']) &&

                !empty($qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_stall_no'])) {



                $no_meeting_table_flg = "true";

                $temp_select_avb_table_no = "Location: " . $qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_hall'] .

                    ", Stall: " . $qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_stall_name'] .

                    ", Stall No.: " . $qr_chk_receiver_no_mtng_tbl_ans_row['metting_location_stall_no'];

            }



            if ($no_meeting_table_flg != "true") {

                // Check table availability

                $qr_check_table_avb_ans_row = $this->meetings_model->get_available_timeslot_detail_by_criteria(array(

                    'meeting_date' => $met_req_row_ans['meeting_date'],

                    'meeting_time_start' => $met_req_row_ans['meeting_time_start']

                ));



                $temp_total_rem_table = $qr_check_table_avb_ans_row['rem_table'];

                $temp_total_alloc_table = $qr_check_table_avb_ans_row['allocated_table'];

                $temp_total_avb_table = $qr_check_table_avb_ans_row['total_table'];



                if ($temp_total_rem_table <= 0 ||

                    ($temp_total_avb_table - $temp_total_alloc_table) <= 0 ||

                    ($temp_total_avb_table == $temp_total_alloc_table) ||

                    $qr_check_table_avb_ans_row['status'] == "Over") {



                    $response = array('status' => 'error', 'message' => 'All tables are full for the selected date & time slot. Please contact admin on ' . EVENT_FROM_EMAIL);

                    echo json_encode($response);

                    return;

                }



                // Searching for available table

                $qr_search_table_for_free_slot_num_rows = $this->meetings_model->get_schedule_data1($met_req_row_ans['meeting_date'], $met_req_row_ans['meeting_time_start']);

                if (empty($qr_search_table_for_free_slot_num_rows)) {

                    $response = array('status' => 'error', 'message' => 'All tables are full for the selected date & time slot. Please contact admin on ' . EVENT_FROM_EMAIL);

                    echo json_encode($response);

                    return;

                }



                $temp_table_allocation_status_flag = "Failed";

                foreach ($qr_search_table_for_free_slot_num_rows as $qr_search_table_for_free_slot_ans) {

                    $temp_select_avb_table_no = $qr_search_table_for_free_slot_ans['table_no'];

                    $qr_fetch_sel_table_info_ans = $this->meetings_model->get_schedule_data2($met_req_row_ans['meeting_date'], $met_req_row_ans['meeting_time_start'], $temp_select_avb_table_no);



                    if ($qr_fetch_sel_table_info_ans['status'] != "Over") {

                        $collection = array(

                            'req_date' => $met_req_row_ans['req_date'],

                            'req_time' => $met_req_row_ans['req_time'],

                            'req_type' => 'Online',

                            'status' => 'Over',

                            'messege_id' => $met_req_row_ans['messege_id'],

                            'sender_id' => $met_req_row_ans['sender_user_id'],

                            'sender_org' => $met_req_row_ans['sender_org'],

                            'sender_title' => $met_req_row_ans['sender_title'],

                            'sender_fname' => $met_req_row_ans['sender_fname'],

                            'sender_lname' => $met_req_row_ans['sender_lname'],

                            'sender_desig' => $met_req_row_ans['sender_desig'],

                            'sender_org_profile' => strip_tags($temp_met_sender_org_profile),

                            'sender_email' => $met_req_row_ans['sender_email'],

                            'receiver_id' => $met_req_row_ans['receiver_user_id'],

                            'receiver_org' => $met_req_row_ans['receiver_org'],

                            'receiver_title' => $met_req_row_ans['receiver_title'],

                            'receiver_fname' => $met_req_row_ans['receiver_fname'],

                            'receiver_lname' => $met_req_row_ans['receiver_lname'],

                            'receiver_desig' => $met_req_row_ans['receiver_desig'],

                            'receiver_org_profile' => strip_tags($temp_met_receiver_org_profile),

                            'receiver_email' => $met_req_row_ans['receiver_email']

                        );



                        $this->meetings_model->update_data_all($collection, $met_req_row_ans['meeting_date'], $met_req_row_ans['meeting_time_start']);



                        $collection = array(

                            'req_date' => $met_req_row_ans['req_date'],

                            'req_time' => $met_req_row_ans['req_time'],

                            'req_type' => 'Online',

                            'table_no' => $temp_select_avb_table_no,

                            'status' => 'On'

                        );

                        $this->meetings_model->update_data_all_table($collection, $met_req_row_ans['meeting_date'], $met_req_row_ans['meeting_time_start']);



                        $temp_table_allocation_status_flag = "Success";

                        break;

                    }

                }



                if ($temp_table_allocation_status_flag == "Failed") {

                    $response = array('status' => 'error', 'message' => 'All tables are full for the selected date & time slot. Please contact admin on ' . EVENT_FROM_EMAIL);

                    echo json_encode($response);

                    return;

                }

            }

        }



        $user_profile_title = $this->userauth->get_session('SESS_TITLE');

        $user_profile_first_name = $this->userauth->get_session('SESS_FIRST_NAME');

        $user_profile_last_name = $this->userauth->get_session('SESS_LAST_NAME');

        $user_profile_desig = $this->userauth->get_session('SESS_DESIGNATION');

        $user_profile_org = $this->userauth->get_session('SESS_ORG_NAME');

        $user_profile_org_profile = strip_tags($this->userauth->get_session('SESS_ORG_PROFILE'));

        $user_profile_email = $this->userauth->get_session('SESS_EMAIL_ID');

        $user_org_profl = strip_tags($this->userauth->get_session('SESS_ORG_PROFILE'));



        $collection = array(

            'meeting_req_status' => $req_stat,

            'meeting_responce_date' => $responce_date,

            'meeting_responce_time' => $responce_time,

            'read_flag' => 'False'

        );

        $this->meetings_model->update_data($collection, $msg_id_gbl);



        if ($req_stat == "Accepted") {

            $message = $this->get_template('email/emailer_meeting_request_accept_sender');

        $subject = "Updated Status of Meeting Request";

            $qr_for_sec_email_of_sender_ans = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$met_req_row_ans['sender_user_id']));

        if($qr_for_sec_email_of_sender_ans['pri_email'] != "")

        {

            if($qr_for_sec_email_of_sender_ans['sec_email'] != "")

            {

                $recipients = array($qr_for_sec_email_of_sender_ans['pri_email'],$qr_for_sec_email_of_sender_ans['sec_email'],'test.interlinks@gmail.com');

            }

            else

            {

                $recipients = array($qr_for_sec_email_of_sender_ans['pri_email'],'test.interlinks@gmail.com');

            }

        }

        else

        {

            $recipients = array($met_req_row_ans['sender_email'],'test.interlinks@gmail.com');

        }



        $this->send_mail($subject, $message, $recipients);





        }



        $response = array('status' => 'success', 'message' => 'Meeting Request ' . $req_stat . ' Successfully.');

        echo json_encode($response);

            }

        else{

            $response = array('status' => 'error', 'message' => 'Invalid Request.');

            echo json_encode($response);

            return;

        }

    }















    /**

     * This route going to be called first

     */



    public function edit_my_calendar() {

        $this->other_title_for_layout = ' | Edit My Calendar';

        

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        

        if($this->input->method(false) == 'post') {

            $meeting_date_txt = trim($this->security->xss_clean($this->input->post('meeting_date_txt')));

            $meeting_start_time_txt = trim($this->security->xss_clean($this->input->post('meeting_start_time_txt')));

            $meeting_End_time_txt = trim($this->security->xss_clean($this->input->post('meeting_End_time_txt')));

            $meeting_status_txt = trim($this->security->xss_clean($this->input->post('meeting_status_txt')));

            $block_info = trim($this->security->xss_clean($this->input->post('block_info')));

            $cl_title_txt = trim($this->security->xss_clean($this->input->post('cl_title_txt')));

            $cl_fname_txt = trim($this->security->xss_clean($this->input->post('cl_fname_txt')));

            $cl_lname_txt = trim($this->security->xss_clean($this->input->post('cl_lname_txt')));

            $cl_org_txt = trim($this->security->xss_clean($this->input->post('cl_org_txt')));

            $cl_desig_txt = trim($this->security->xss_clean($this->input->post('cl_desig_txt')));

            $cl_org_profile_txt = trim($this->security->xss_clean($this->input->post('cl_org_profile_txt')));

            $cl_msg_txt = trim($this->security->xss_clean($this->input->post('cl_msg_txt')));

            $cl_email_txt = trim($this->security->xss_clean($this->input->post('cl_email_txt')));

            

            if( ($meeting_date_txt=="") || ($meeting_start_time_txt=="") || ($meeting_End_time_txt=="")  ) {

                $this->session->set_flashdata('is_error', 'Please Enter Complete Information.');

                redirect('edit-my-calendar');

            }

            

            $responce_date = date("Y-m-d");

            $responce_time = date("h:i:s a");

            

            //----------------------------------- Checking self Block Availability -------------------------------------------

            $temp_chk_rec_user_slot_qr1_id = $this->meetings_model->get_schedule_detail_by_criteria(array('meeting_date'=>$meeting_date_txt, 'meeting_time_start'=>$meeting_start_time_txt, 'receiver_id'=>$user_id));

            

            if( ($temp_chk_rec_user_slot_qr1_id['status'] == "Accepted") ) {

                $this->session->set_flashdata('is_error', 'You have Already Confirmed Another Meeting At This Slot.Please Modify your schedule using Edit My Schedule');

                redirect('edit-my-calendar');

            }

            

            if($block_info == "block_cl_info") {

                $collection = $condition = array();

                $collection['req_date'] = $responce_date;

                $collection['req_time'] = $responce_time;

                $collection['req_type'] = 'Self';

                $collection['message'] = 'Block For Personal Meeting';

                $collection['status'] = 'Accepted';

                $collection['sender_fname'] = 'Self';

                $collection['sender_id'] = $user_id;

                

                $condition['meeting_date'] = $meeting_date_txt;

                $condition['meeting_time_start'] = $meeting_start_time_txt;

                $condition['meeting_time_end'] = $meeting_End_time_txt;

                $condition['receiver_id'] = $user_id;

                

                $this->meetings_model->update_schedule_details($collection, $condition);

            } else {

                if( ($cl_title_txt == "" ) || ($cl_fname_txt == "" ) || ($cl_lname_txt == "") || ($cl_org_txt == "")   || ($cl_msg_txt == "")  ) {

                    $this->session->set_flashdata('is_error', 'Please Enter Complete Information.');

                    redirect('edit-my-calendar');

                }

                

                $temp_client_email = $cl_email_txt;

                

                //------------------------------------ Secrching in db about client email ------------------------------------------------------

                $collection = $condition = array();

                $collection['req_date'] = $responce_date;

                $collection['req_time'] = $responce_time;

                $collection['sender_title'] = $cl_title_txt;

                $collection['sender_fname'] = $cl_fname_txt;

                $collection['sender_lname'] = $cl_lname_txt;

                $collection['sender_org'] = $cl_org_txt;

                $collection['sender_desig'] = $cl_desig_txt;

                $collection['sender_org_profile'] = $cl_org_profile_txt;

                $collection['sender_email'] = $temp_client_email;

                $collection['sender_id'] = 'XXX';

                $collection['req_type'] = 'Self';

                $collection['message'] = $cl_msg_txt;

                $collection['status'] = 'Accepted';

                

                $condition['meeting_date'] = $meeting_date_txt;

                $condition['meeting_time_start'] = $meeting_start_time_txt;

                $condition['meeting_time_end'] = $meeting_End_time_txt;

                $condition['receiver_id'] = $user_id;

                

                $this->meetings_model->update_schedule_details($collection, $condition);

            }

            

            //************** cheking othere entries of user from global_meeting table for Current date and time slot  *********************

            //------------------------------------------- checking entries for receiver as sender---------------------------------

            

            $condition = array();

            $condition['meeting_date'] = $meeting_date_txt;

            $condition['meeting_time_start'] = $meeting_start_time_txt;

            $condition['sender_user_id'] = $user_id;

            $this->meetings_model->update_meetings_details(array('status'=>'Rejected'), $condition);

            //------------------------------------------- End checking entries for receiver as sender -------------------------------

            

            //------------------------------------------- checking entries for receiver as receiver ---------------------------------

            $condition = array();

            $condition['meeting_date'] = $meeting_date_txt;

            $condition['meeting_time_start'] = $meeting_start_time_txt;

            $condition['receiver_user_id'] = $user_id;

            $this->meetings_model->update_meetings_details(array('status'=>'Rejected'), $condition);

            //------------------------------------------- End checking entries for receiver as receiver ---------------------------------

            

            $this->session->set_flashdata('is_success', 'Your timeslot has been blocked successfully.');

            redirect('edit-my-calendar');

        }

        

        $EVENT_INTERLINX_DATE_ARR = unserialize(EVENT_INTERLINX_DATE_ARR);

        

        $schedule_list = array();

        for($i_days_cnt = 0; $i_days_cnt < EVENT_INTERLINX_NO_OF_DAYS; $i_days_cnt++) {

            $schedule_record_list = $this->meetings_model->get_schedule_list_by_criteria(array('meeting_date'=>$EVENT_INTERLINX_DATE_ARR[$i_days_cnt], 'receiver_id'=>$user_id));

            //print_r($schedule_list);

            $record = array();

            foreach ($schedule_record_list as $res_sch) {

                $global_meet_data = array();

                if($res_sch['status'] == "Accepted") {

                    $global_meet_res = $this->meetings_model->get_meetings_detail_by_criteria(array('meeting_date'=>$res_sch['meeting_date'], 'meeting_time_start'=>$res_sch['meeting_time_start'], 'meeting_time_end'=>$res_sch['meeting_time_end'], 'sender_user_id'=>$res_sch['sender_id'], 'receiver_user_id'=>$res_sch['receiver_id'], 'status'=>'Accepted'));

                    

                    if(!empty($global_meet_res)) {

                        $global_meet_data = $global_meet_res;

                    } else {

                        $global_meet_res = $this->meetings_model->get_meetings_detail_by_criteria(array('meeting_date'=>$res_sch['meeting_date'], 'meeting_time_start'=>$res_sch['meeting_time_start'], 'meeting_time_end'=>$res_sch['meeting_time_end'], 'sender_user_id'=>$res_sch['receiver_id'], 'receiver_user_id'=>$res_sch['sender_id'], 'status'=>'Accepted'));

                        if(!empty($global_meet_res)) {

                            $global_meet_data = $global_meet_res;

                        }

                    }

                }

                $res_sch['global_meet_data'] = $global_meet_data;

                $record[] = $res_sch;

            }

            $schedule_list[$i_days_cnt] = $record;

        }

        $this->response['EVENT_INTERLINX_DATE_ARR'] = $EVENT_INTERLINX_DATE_ARR;

        $this->response['schedule_list'] = $schedule_list;

        //print_r($this->response);

        

        $this->display_template('edit-my-calendar');

    }

    

    /**

     * This route going to be called first

     */

    public function cancel_my_schedule() {

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        

        if($this->input->method(false) == 'post') {

            $can_meeting_client_id_txt1 = trim($this->security->xss_clean($this->input->post('can_meeting_client_id_txt1')));

            $can_meeting_date_txt1 = trim($this->security->xss_clean($this->input->post('can_meeting_date_txt1')));

            $can_meeting_start_time_txt1 = trim($this->security->xss_clean($this->input->post('can_meeting_start_time_txt1')));

            $can_meeting_End_time_txt1 = trim($this->security->xss_clean($this->input->post('can_meeting_End_time_txt1')));

            $can_meeting_status_txt1 = trim($this->security->xss_clean($this->input->post('can_meeting_status_txt1')));

            $can_cl_msg_txt1 = trim($this->security->xss_clean($this->input->post('can_cl_msg_txt1')));

            

            if( ($can_meeting_date_txt1=="") || ($can_meeting_start_time_txt1=="") || ($can_meeting_End_time_txt1=="") ) {

                $this->session->set_flashdata('is_error', 'Please Enter Complete Information.');

                redirect('edit-my-calendar');

            }

            

            if($can_meeting_client_id_txt1 != "") {

                if($can_meeting_client_id_txt1 != $user_id) {

                    if( ($can_cl_msg_txt1=="") ) {

                        $this->session->set_flashdata('is_error', 'Please Enter Message for Client about cancellation.');

                        redirect('edit-my-calendar');

                    }

                }

            }

            

            $collection = array('req_date'=>'','req_time'=>'','sender_title'=>'','sender_fname'=>'','sender_lname'=>'','sender_org'=>'','sender_desig'=>'','sender_org_profile'=>'','sender_email'=>'','sender_id'=>'','req_type'=>'','message'=>'','status'=>'','messege_id'=>'','table_no'=>''); 

            $condition = array();

            

            $condition['meeting_date'] = $can_meeting_date_txt1;

            $condition['meeting_time_start'] = $can_meeting_start_time_txt1;

            $condition['meeting_time_end'] = $can_meeting_End_time_txt1;

            $condition['receiver_id'] = $user_id;

            

            $this->meetings_model->update_schedule_details($collection, $condition);

            

            

            $can_temp_client_id = $can_meeting_client_id_txt1;

            if( ($can_temp_client_id != '') && ($can_temp_client_id != 'Self') ) {

                //----------------------------- Start Making alloted table free ----------------------------------------------------------------

                $qr_fetch_dele_meet_details_ans_row = $this->meetings_model->get_schedule_detail_by_criteria(array('meeting_date'=>$can_meeting_date_txt1, 'meeting_time_start'=>$can_meeting_start_time_txt1, 'receiver_id'=>$can_temp_client_id));

                

                if(!empty($qr_fetch_dele_meet_details_ans_row)) {

                    $temp_alloted_table_no = $qr_fetch_dele_meet_details_ans_row['table_no'];

                    $temp_meet_msg_id = $qr_fetch_dele_meet_details_ans_row['messege_id'];



                    //--------------------------check in table is allocated or not-------------------------------------------------------------------------------

                    $table_type_search_1 = stristr($temp_alloted_table_no, "Location");

                    $table_type_search_2 = stristr($temp_alloted_table_no, "Hall");

                    $table_type_search_3 = stristr($temp_alloted_table_no, "Stall");

                    

                    if( ($table_type_search_1 == "") && ($table_type_search_2 == "") && ($table_type_search_3 == "") ) {

                        $temp_table_allocation_flag = "true";

                    } else{

                        $temp_table_allocation_flag = "false";

                    }

                    

                    //---------------------------------------------------------------------------------------------------------------------------------------------

                    if($temp_table_allocation_flag =="true") {

                        if($qr_fetch_dele_meet_details_ans_row['table_no'] != "") {

                            $collection = array('req_date'=>'','req_time'=>'','req_type'=>'','status'=>'','messege_id'=>'','sender_id'=>'','sender_org'=>'','sender_title'=>'','sender_fname'=>'','sender_lname'=>'','sender_desig'=>'','sender_org_profile'=>'','sender_email'=>'','receiver_id'=>'','receiver_org'=>'','receiver_title'=>'','receiver_fname'=>'','receiver_lname'=>'','receiver_desig'=>'','receiver_org_profile'=>'','receiver_email'=>''); 

                            $condition = array();

                            

                            $condition['meeting_date'] = $can_meeting_date_txt1;

                            $condition['meeting_time_start'] = $can_meeting_start_time_txt1;

                            $condition['table_no'] = $temp_alloted_table_no;

                            $condition['messege_id'] = $temp_meet_msg_id;

                            

                            $this->meetings_model->update_all_table_details($collection, $condition);

                            

                            //start incresing table resource

                            $qr_check_table_avb_ans_row = $this->meetings_model->get_available_timeslot_detail_by_criteria(array('meeting_date' => $can_meeting_date_txt1, 'meeting_time_start' =>$can_meeting_start_time_txt1));

                            $temp_total_avb_table = $qr_check_table_avb_ans_row['total_table'];

                            $temp_total_alloc_table = $qr_check_table_avb_ans_row['allocated_table'];

                            $temp_total_rem_table =	$qr_check_table_avb_ans_row['rem_table'];

                            

                            if($temp_total_avb_table >=1) {

                                $curr_rem_table = ($temp_total_rem_table +1);

                                $curr_alloc_table = ($temp_total_alloc_table - 1);

                                

                                if(($temp_total_avb_table>=$curr_alloc_table) && ($temp_total_avb_table>=$curr_rem_table)) {

                                    $collection = array();

                                    $collection['read_flag'] = 'False';

                                    $collection['allocated_table'] = $curr_alloc_table;

                                    $collection['rem_table'] = $curr_rem_table;

                                    $this->meetings_model->update_available_timeslot_details($collection, array('meeting_date' => $can_meeting_date_txt1, 'meeting_time_start' =>$can_meeting_start_time_txt1));

                                }

                                

                                if(($qr_check_table_avb_ans_row['status']== "Over") && ($temp_total_avb_table>$curr_alloc_table) && ($temp_total_avb_table>=$curr_rem_table) ){

                                    $collection = array();

                                    $collection['status'] = 'Available';

                                    $this->meetings_model->update_available_timeslot_details($collection, array('meeting_date' => $can_meeting_date_txt1, 'meeting_time_start' =>$can_meeting_start_time_txt1));

                                }

                            }

                            //end incresing table resource

                        }//table no. check end

                    }//table allocation check

                    

                    $this->meetings_model->update_meetings_details(array('table_no'=>'', 'status'=>'Cancelled'), array('messege_id'=>$temp_meet_msg_id));

                        

                    $global_meeting_data = $this->meetings_model->get_meetings_detail_by_criteria(array('messege_id'=>$temp_meet_msg_id));

                    if(!empty($global_meeting_data['meeting_id']) && IS_ZOOM_MEETING_ACTIVATE) {

                        $this->load->library('zoom');

                        $this->zoom->delete_meeting($global_meeting_data['meeting_id']);

                    }

                }

                

                ////----------------------------- Making alloted table free

                $collection = $condition = array();

                $collection['req_date'] = '';

                $collection['req_time'] = '';

                $collection['sender_title'] = '';

                $collection['sender_fname'] = '';

                $collection['sender_lname'] = '';

                $collection['sender_org'] = '';

                $collection['sender_desig'] = '';

                $collection['sender_org_profile'] = '';

                $collection['sender_email'] = '';

                $collection['sender_id'] = '';

                $collection['req_type'] = '';

                $collection['message'] = '';

                $collection['messege_id'] = '';

                $collection['table_no'] = '';

                

                $condition['meeting_date'] = $can_meeting_date_txt1;

                $condition['meeting_time_start'] = $can_meeting_start_time_txt1;

                $condition['meeting_time_end'] = $can_meeting_End_time_txt1;

                $condition['receiver_id'] = $can_temp_client_id;

                

                $this->meetings_model->update_schedule_details($collection, $condition);

                

                $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));

                

                $qr_can_cli_row = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$can_temp_client_id));

                $this->response['can_meeting_date_txt1'] = $can_meeting_date_txt1;

                $this->response['can_meeting_start_time_txt1'] = $can_meeting_start_time_txt1;

                $this->response['can_meeting_End_time_txt1'] = $can_meeting_End_time_txt1;

                $this->response['can_cl_msg_txt1'] = $can_cl_msg_txt1;

                $this->response['res'] = $res;

                $this->response['qr_can_cli_row'] = $qr_can_cli_row;

                

                if( ($can_temp_client_id != "") && ($can_temp_client_id != 'Self') && ($can_temp_client_id != $user_id) ) {

                    // load emailer file

                    $message = $this->get_template('email/emailer_cancel_meeting_request_canceler');

                    $subject = "You have Canceled Meeting";

                    $recipients = array($res['pri_email'], 'test.interlinks@gmail.com', EVENT_FROM_EMAIL);

                    //echo $message;

                    $this->send_mail($subject, $message, $recipients);

                    

                    // load emailer file

                    $message = $this->get_template('email/emailer_cancel_meeting_request_cancel_receiver');

                    $subject = "Your Meeting Has been cancelled";

                    $recipients = array($qr_can_cli_row['pri_email'], 'test.interlinks@gmail.com', EVENT_FROM_EMAIL, 'interlinks@mmactiv.in');

                    //echo $message;exit;

                    $this->send_mail($subject, $message, $recipients);

                }

            }

            $this->session->set_flashdata('is_success', 'Meeting has been cancelled successfully.');

        }

        $this->redirect_referer();

    }

    

    /**

     * This route going to be called first

     */

    public function make_free() {

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        

        if($this->input->method(false) == 'post') {

            $count = $this->input->post('count');

            //print_r($_POST);exit;

            if($count) {

                for($i=1; $i<= $count; $i++) {

                    $id = $this->input->post('asc_' . $i);

                    if(!empty($id)) {

                        $qr_free_multi_slots_res = $this->meetings_model->get_schedule_detail_by_criteria(array('no'=>$id));

                        

                        if( ($id == $qr_free_multi_slots_res['no']) && ( ($qr_free_multi_slots_res['sender_id']==$user_id) || ($qr_free_multi_slots_res['sender_id']=="") )) {

                            $collection = $condition = array();

                            $collection['req_date'] = '';

                            $collection['req_time'] = '';

                            $collection['sender_title'] = '';

                            $collection['sender_fname'] = '';

                            $collection['sender_lname'] = '';

                            $collection['sender_org'] = '';

                            $collection['sender_desig'] = '';

                            $collection['sender_org_profile'] = '';

                            $collection['sender_email'] = '';

                            $collection['sender_id'] = '';

                            $collection['req_type'] = '';

                            $collection['message'] = '';

                            $collection['messege_id'] = '';

                            $collection['status'] = '';

                            

                            $condition['no'] = $id;

                            

                            $this->meetings_model->update_schedule_details($collection, $condition);

                            $this->session->set_flashdata('is_success', 'Your meeting slot has been free now.');

                        } else {

                            $this->session->set_flashdata('is_error', 'You can free slot which are not allocated to any other delegate.');

                        }

                    }

                }

            }

            //$this->session->set_flashdata('is_error', 'You can free slot which are not allocated to any other delegate.');

        }

        $this->redirect_referer();

    }

    

    /**

     * This route going to be called first

     */

    public function add_friend($dup_user_id = '') {

        if(empty($dup_user_id)) {

            redirect('edit-my-calendar');

        }

        

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        

        $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));

        

        $frnd_res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('dup_user_id'=>$dup_user_id));

        

        $tst_qr = $this->friends_model->get_friends_detail_by_criteria(array('frnd_id'=>$frnd_res['user_id'], 'owner_id'=>$user_id));

        

        if(!empty($tst_qr)) {

            $this->session->set_flashdata('is_error', 'Sorry, Please check your collaborator list.');

            $this->redirect_referer();

        }

        //$chk_self_frnd_tbl_num = $this->friends_model->get_friends_detail_by_criteria(array('frnd_id'=>$user_id, 'owner_id'=>$frnd_res['user_id']));

        $criteria = array();

        $criteria['owner_id'] = $user_id;

        $criteria['owner_title'] = $res['title'];

        $criteria['owner_fname'] = $res['fname'];

        $criteria['owner_lname'] = $res['lname'];

        $criteria['owner_org'] = $res['org_name'];

        $criteria['owner_email'] = $res['pri_email'];

        $criteria['frnd_id'] = $frnd_res['user_id'];

        $criteria['frnd_title'] = $frnd_res['title'];

        $criteria['frnd_fname'] = $frnd_res['fname'];

        $criteria['frnd_lname'] = $frnd_res['lname'];

        $criteria['request'] = 'Send';

        $criteria['status'] = 'Pending';

        

        $this->friends_model->save_friends_details($criteria);

        

        $this->session->set_flashdata('is_success', 'You have shortlisted this delegate.');

        $this->redirect_referer();

    }

    

    /**

     * This route going to be called first

     */

    public function view_schedule($dup_user_id = '') {

        if(empty($dup_user_id)) {

            $this->session->set_flashdata('is_error', 'Problem in schedule initialization. Try after some time');

            redirect('edit-my-calendar');

        }

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        

        $this->other_title_for_layout = ' | View Schedule';

        

        if($this->input->method(false) == 'post') {

            $temp_met_date = $met_date = $this->input->post('met_date');

            $temp_met_time_start = $met_time = $this->input->post('met_time');

            $temp_get_mas_html = $msg = $this->input->post('msg');

            $dele_dup_user_id = $this->input->post('dele_dup_user_id');

            $temp_met_time_end = $met_time_end = $this->input->post('met_time_end');

            

            if(empty($met_date) || empty($met_time) || empty($msg) || empty($dele_dup_user_id) || empty($met_time_end)) {

                $this->session->set_flashdata('is_error', 'Problem in scheduling meeting, please Enter Messege For Delegate');

                $this->redirect_referer();

            }

            

            $req_msg_date = date("Y-m-d");

            $req_msg_time = date("h:i:s a");

            

            $dup_dele_row_ans = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('dup_user_id'=>$dup_user_id));

            if(empty($dup_dele_row_ans)) {

                $this->session->set_flashdata('is_error', 'Problem in scheduling meeting please try after some time.');

                $this->redirect_referer();

            }

            

            $temp_chk_usr_slot_qr1_id = $this->meetings_model->get_schedule_detail_by_criteria(array('meeting_date'=>$temp_met_date, 'meeting_time_start'=>$temp_met_time_start, 'meeting_time_end'=>$temp_met_time_end, 'receiver_id'=>$user_id));

            if( ($temp_chk_usr_slot_qr1_id['status'] == "Accepted") ) {

                $this->session->set_flashdata('is_error', 'You have Already Confirmed Another Meeting At This Slot. Please Modify your schedule using Edit My Schedule');

                $this->redirect_referer();

            }

            

            $req_msg_no = "gbl-";

            $i = 0;

            do {

                $req_msg_no1 = $req_msg_no.rand(1, 999999).mt_rand(0,999999);

                

                $res_no = $this->meetings_model->get_meetings_detail_by_criteria(array('messege_id'=>$req_msg_no1));

                

                if(empty($res_no)) {

                    $i++;

                } else {

                    $req_msg_no1 = "";

                }

            } while(!($i == 1));

            

            $res = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('user_id'=>$user_id));

            

            /*echo "<script language='javascript'>alert('in file');</script>";*/

            $temp_res_org_profile = addslashes($res['org_profile']);

            $temp_dup_org_profile = addslashes($dup_dele_row_ans['org_profile']);

            

            $collection = array('messege_id'=>$req_msg_no1, 'req_date'=>$req_msg_date, 'req_time'=>$req_msg_time, 'sender_user_id'=>$user_id, 

                'sender_title'=>$res['title'], 'sender_fname'=>$res['fname'], 'sender_lname'=>$res['lname'], 

                'sender_email'=>$res['pri_email'], 'sender_org'=>$res['org_name'], 'sender_org_profile'=>$temp_res_org_profile, 

                'sender_desig'=>$res['desig'], 'sender_mob_cntry_code'=>$res['mob_cntry_code'], 'sender_mob_number'=>$res['mob_number'], 

                'receiver_user_id'=>$dup_dele_row_ans['user_id'], 'receiver_title'=>$dup_dele_row_ans['title'], 'receiver_fname'=>$dup_dele_row_ans['fname'], 

                'receiver_lname'=>$dup_dele_row_ans['lname'], 'receiver_email'=>$dup_dele_row_ans['pri_email'], 'receiver_org'=>$dup_dele_row_ans['org_name'], 

                'receiver_org_profile'=>$temp_dup_org_profile, 'receiver_desig'=>$dup_dele_row_ans['desig'], 'receiver_mob_cntry_code'=>$dup_dele_row_ans['mob_cntry_code'], 

                'receiver_mob_number'=>$dup_dele_row_ans['mob_number'], 'meeting_date'=>$met_date, 'meeting_time_start'=>$met_time, 'meeting_time_end'=>$met_time_end, 

                'messege'=>$temp_get_mas_html, 'status'=>'Pending', 'read_flag'=>'False');

            

            $this->meetings_model->save_meetings_details($collection);

            

            $this->response['res'] = $res;

            $this->response['dup_dele_row_ans'] = $dup_dele_row_ans;

            $this->response['met_date'] = $met_date;

            $this->response['met_time'] = $met_time;

            $this->response['met_time_end'] = $met_time_end;

            $this->response['temp_get_mas_html'] = $temp_get_mas_html;

            

            // load emailer file

            $message = $this->get_template('email/emailer_meeting_request_sender');

            $subject = "Meeting Request Has Been Sent to ".$dup_dele_row_ans['title']." ".$dup_dele_row_ans['fname']." ".$dup_dele_row_ans['lname']." On InterlinX";

            $recipients = array($res['pri_email'], 'test.interlinks@gmail.com', EVENT_FROM_EMAIL);

            //echo $message;

            //$this->send_mail($subject, $message, $recipients);

            

            // load emailer file

            $message = $this->get_template('email/emailer_meeting_request_reciever');

            $subject = "New Meeting Request From ".$res['title']." ".$res['fname']." ".$res['lname']." On InterlinX";

            $recipients = array($dup_dele_row_ans['pri_email'], 'test.interlinks@gmail.com', EVENT_FROM_EMAIL);

            //echo $message;exit;

            $this->send_mail($subject, $message, $recipients);

            

            $this->session->set_flashdata('is_success', 'Meeting Scheduling Request Send Successfully.');

            $this->redirect_referer();

        }

        

        $dup_dele_row_ans = $this->interlinx_reg_model->get_reg_detail_by_criteria(array('dup_user_id'=>$dup_user_id));

        

        $EVENT_INTERLINX_DATE_ARR = unserialize(EVENT_INTERLINX_DATE_ARR);

        //print_r($EVENT_INTERLINX_DATE_ARR);

        $schedule_list = array();

        for($i_days_cnt = 0; $i_days_cnt < EVENT_INTERLINX_NO_OF_DAYS; $i_days_cnt++) {

            $schedule_record_list = $this->meetings_model->get_schedule_list_by_criteria(array('meeting_date'=>$EVENT_INTERLINX_DATE_ARR[$i_days_cnt], 'receiver_id'=>$dup_dele_row_ans['user_id']));

            //print_r($schedule_record_list);

            $schedule_list[$i_days_cnt] = $schedule_record_list;

        }

        $this->response['EVENT_INTERLINX_DATE_ARR'] = $EVENT_INTERLINX_DATE_ARR;

        $this->response['schedule_list'] = $schedule_list;

        $this->response['dup_dele_row_ans'] = $dup_dele_row_ans;

        //print_r($this->response);

        

        $this->display_template('view-schedule');

    }

    

    /**

     * This route going to be called first

     */

    public function export_data() {

        $this->display_template('export');

    }

    

    /**

     * This route going to be called first

     */

    public function dwnld_data_in_acceptd_data_word() {

        $file = $this->userauth->get_userdata('title') . ' ' . $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname').' Meetings details'.date("Y-m-d_h:m:s");

        

        $EVENT_INTERLINX_DATE_ARR = unserialize(EVENT_INTERLINX_DATE_ARR);

        $qr_whr_claus='';

        for($i_days_cnt = 0; $i_days_cnt < EVENT_INTERLINX_NO_OF_DAYS; $i_days_cnt++) {

            if($qr_whr_claus ==""){

                $qr_whr_claus = "(meeting_date='$EVENT_INTERLINX_DATE_ARR[$i_days_cnt]')";

            } else {

                $qr_whr_claus = $qr_whr_claus. "OR (meeting_date='$EVENT_INTERLINX_DATE_ARR[$i_days_cnt]') ";

            }

        }

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        $schedule_record_list = $this->meetings_model->get_schedule_list($user_id, $qr_whr_claus);

        $this->response['schedule_record_list'] = $schedule_record_list;

        $message = $this->get_template('word_data');

        //echo $message;exit;

        //include("word_data.php");

        

        header("Content-type: application/msword");

        header("Content-disposition: attachment");

        header( "Content-disposition: filename=".$file.".doc");

        print $message;

        

        ob_end_flush();

    }

    

    /**

     * This route going to be called first

     */

    public function dwnld_data_in_excel() {

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        

        $csv_output= "";

        $csv_output ="\n\n";

        $header= EVENT_FROM_NAME . " Meeting Schedule Details for ".$this->userauth->get_userdata('title') . ' ' . $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname');

        

        //$file = 'registration_data'.date("d-m-Y h:m:s");

        $file = $this->userauth->get_userdata('title') . ' ' . $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname').' Meetings details'.date("Y-m-d_h:m:s");

        

        $csv_output = $header."\n\n"."Complete Scheduled details "."\n\n\n";

        

        $csv_output  .= "SR.No\tClient Name\tClient Organisation\tClient Designation\tClient Organisation Profile\tMeeting Date\tMeeting Time Start\tMeeting Time End\tMessage\tTable Number";

        $name = $_SESSION['SESS_MEMBER_ID'];

        $csv_output .= "\n\n";

        

        $qr_whr_claus = "";

        

        $schedule_record_list = $this->meetings_model->get_schedule_list_by_criteria(array('receiver_id'=>$user_id));

        $i_cnt = 1;

        

        foreach ($schedule_record_list as $rowr) {

            $csv_output .= $i_cnt;

            $csv_output .="\t";

            /*$csv_output .=$rowr['req_date'];

             $csv_output .="\t";

             $csv_output .=$rowr['req_time'];

             $csv_output .="\t";

             $csv_output .=$rowr['sender_id'];

             $csv_output .="\t";*/

            $csv_output .=$rowr['sender_title'].".".$rowr['sender_fname']." ".$rowr['sender_lname'];

            $csv_output .="\t";

            $csv_output .=$rowr['sender_org'];

            $csv_output .="\t";

            $csv_output .=$rowr['sender_desig'];

            $csv_output .="\t";

            $csv_output .=strip_tags($rowr['sender_org_profile']);

            $csv_output .="\t";

            /*$csv_output .=$rowr['sender_email'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_id'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_title'].".".$rowr['receiver_fname']." ".$rowr['receiver_lname'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_org'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_desig'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_org_profile'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_email'];

             $csv_output .="\t";

             $csv_output .=$rowr['req_type'];

             $csv_output .="\t";	*/

            $csv_output .=$rowr['meeting_date'];

            $csv_output .="\t";

            

            $temp_meet_time_start_arr = explode(":",$rowr['meeting_time_start']);

            $temp_meet_time_end_arr = explode(":",$rowr['meeting_time_end']);

            

            $csv_output .=$temp_meet_time_start_arr[0].":".$temp_meet_time_start_arr[1];

            $csv_output .="\t";

            $csv_output .=$temp_meet_time_end_arr[0].":".$temp_meet_time_end_arr[1];

            $csv_output .="\t";

            

            /*$csv_output .=$rowr['messege_id'];

             $csv_output .="\t";	*/

            $csv_output .=$rowr['message'];

            $csv_output .="\t";

            /*$csv_output .=$rowr['status'];

             $csv_output .="\t";	*/

            $csv_output .=$rowr['table_no'];

            $csv_output .="\t";

            

            $i_cnt = $i_cnt + 1 ;

            $csv_output .="\n\n";

        }

        

        header("Content-type: application/vnd.ms-excel");

        header("Content-disposition: xls" . date("Y-m-d") . ".xls");

        header( "Content-disposition: filename=".$file.".xls");

        print $csv_output;

        exit;

    }

    

    /**

     * This route going to be called first

     */

    public function dwnld_data_in_excel_arr_slot() {

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        

        $csv_output= "";

        $csv_output ="\n\n";

        $header= EVENT_FROM_NAME . " Meeting Schedule Details for ".$this->userauth->get_userdata('title') . ' ' . $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname');

        

        $file = $this->userauth->get_userdata('title') . ' ' . $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname').' Meetings details'.date("Y-m-d_h:m:s");

        

        $csv_output = $header."\n\n"."Scheduled meetings details "."\n\n\n";

        

        $csv_output  .= "SR.No\tClient Name\tClient Organisation\tClient Designation\tClient Organisation Profile\tMeeting Date\tMeeting Time Start\tMeeting Time End\tMessage\tTable Number";

        $csv_output .= "\n\n";

        

        $EVENT_INTERLINX_DATE_ARR = unserialize(EVENT_INTERLINX_DATE_ARR);

        $qr_whr_claus='';

        for($i_days_cnt = 0; $i_days_cnt < EVENT_INTERLINX_NO_OF_DAYS; $i_days_cnt++) {

            if($qr_whr_claus ==""){

                $qr_whr_claus = "(meeting_date='$EVENT_INTERLINX_DATE_ARR[$i_days_cnt]')";

            } else {

                $qr_whr_claus = $qr_whr_claus. "OR (meeting_date='$EVENT_INTERLINX_DATE_ARR[$i_days_cnt]') ";

            }

        }

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        $schedule_record_list = $this->meetings_model->get_schedule_list($user_id, $qr_whr_claus);

        

        $i_cnt = 1;

        

        foreach ($schedule_record_list as $rowr) {

            $csv_output .= $i_cnt;

            $csv_output .="\t";

            /*$csv_output .=$rowr['req_date'];

             $csv_output .="\t";

             $csv_output .=$rowr['req_time'];

             $csv_output .="\t";

             $csv_output .=$rowr['sender_id'];

             $csv_output .="\t";*/

            $csv_output .=$rowr['sender_title'].".".$rowr['sender_fname']." ".$rowr['sender_lname'];

            $csv_output .="\t";

            $csv_output .=$rowr['sender_org'];

            $csv_output .="\t";

            $csv_output .=$rowr['sender_desig'];

            $csv_output .="\t";

            $csv_output .= strip_tags($rowr['sender_org_profile']);

            $csv_output .="\t";

            /*$csv_output .=$rowr['sender_email'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_id'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_title'].".".$rowr['receiver_fname']." ".$rowr['receiver_lname'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_org'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_desig'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_org_profile'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_email'];

             $csv_output .="\t";

             $csv_output .=$rowr['req_type'];

             $csv_output .="\t";	*/

            $csv_output .=$rowr['meeting_date'];

            $csv_output .="\t";

            

            $temp_meet_time_start_arr = explode(":",$rowr['meeting_time_start']);

            $temp_meet_time_end_arr = explode(":",$rowr['meeting_time_end']);

            

            $csv_output .=$temp_meet_time_start_arr[0].":".$temp_meet_time_start_arr[1];

            $csv_output .="\t";

            $csv_output .=$temp_meet_time_end_arr[0].":".$temp_meet_time_end_arr[1];

            $csv_output .="\t";

            

            /*$csv_output .=$rowr['messege_id'];

             $csv_output .="\t";	*/

            $csv_output .=$rowr['message'];

            $csv_output .="\t";

            /*$csv_output .=$rowr['status'];

             $csv_output .="\t";	*/

            $csv_output .=$rowr['table_no'];

            $csv_output .="\t";

            $i_cnt = $i_cnt + 1 ;

            $csv_output .="\n\n";

        }

        header("Content-type: application/vnd.ms-excel");

        header("Content-disposition: xls" . date("Y-m-d") . ".xls");

        header( "Content-disposition: filename=".$file.".xls");

        print $csv_output;

        exit;

    }

    

    /**

     * This route going to be called first

     */

    public function dwnld_data_in_excel_free_slot() {

        $user_id = $this->userauth->get_session('SESS_MEMBER_ID');

        

        $csv_output = "";

        $csv_output = "\n\n";

        $header = EVENT_FROM_NAME . " Meeting Schedule Details for ".$this->userauth->get_userdata('title') . ' ' . $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname');

        

        $file = $this->userauth->get_userdata('title') . ' ' . $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname').' Meetings details'.date("Y-m-d_h:m:s");

        

        $csv_output = $header."\n\n";

        $csv_output = $header."\n\n"."Free Slots Details From Scheduled "."\n\n\n";

        $csv_output  .= "SR.No\tClient Name\tClient Organisation\tClient Designation\tClient Organisation Profile\tMeeting Date\tMeeting Time Start\tMeeting Time End\tMessage\tTable Number";

        $csv_output .= "\n\n";

        

        $EVENT_INTERLINX_DATE_ARR = unserialize(EVENT_INTERLINX_DATE_ARR);

        $qr_whr_claus='';

        for($i_days_cnt = 0; $i_days_cnt < EVENT_INTERLINX_NO_OF_DAYS; $i_days_cnt++) {

            if($qr_whr_claus ==""){

                $qr_whr_claus = "(meeting_date='$EVENT_INTERLINX_DATE_ARR[$i_days_cnt]')";

            } else {

                $qr_whr_claus = $qr_whr_claus. "OR (meeting_date='$EVENT_INTERLINX_DATE_ARR[$i_days_cnt]') ";

            }

        }

        

        $schedule_record_list = $this->meetings_model->get_free_schedule_list($user_id, $qr_whr_claus);

        

        $i_cnt = 1;

        

        foreach ($schedule_record_list as $rowr) {

            $csv_output .= $i_cnt;

            $csv_output .="\t";

            /*$csv_output .=$rowr['req_date'];

             $csv_output .="\t";

             $csv_output .=$rowr['req_time'];

             $csv_output .="\t";

             $csv_output .=$rowr['sender_id'];

             $csv_output .="\t";*/

            $csv_output .=$rowr['sender_title'].".".$rowr['sender_fname']." ".$rowr['sender_lname'];

            $csv_output .="\t";

            $csv_output .=$rowr['sender_org'];

            $csv_output .="\t";

            $csv_output .=$rowr['sender_desig'];

            $csv_output .="\t";

            $csv_output .= strip_tags($rowr['sender_org_profile']);

            $csv_output .="\t";

            /*$csv_output .=$rowr['sender_email'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_id'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_title'].".".$rowr['receiver_fname']." ".$rowr['receiver_lname'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_org'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_desig'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_org_profile'];

             $csv_output .="\t";

             $csv_output .=$rowr['receiver_email'];

             $csv_output .="\t";

             $csv_output .=$rowr['req_type'];

             $csv_output .="\t";	*/

            $csv_output .=$rowr['meeting_date'];

            $csv_output .="\t";

            

            $temp_meet_time_start_arr = explode(":",$rowr['meeting_time_start']);

            $temp_meet_time_end_arr = explode(":",$rowr['meeting_time_end']);

            

            $csv_output .=$temp_meet_time_start_arr[0].":".$temp_meet_time_start_arr[1];

            $csv_output .="\t";

            $csv_output .=$temp_meet_time_end_arr[0].":".$temp_meet_time_end_arr[1];

            $csv_output .="\t";

            

            /*$csv_output .=$rowr['messege_id'];

             $csv_output .="\t";	*/

            $csv_output .=$rowr['message'];

            $csv_output .="\t";

            /*$csv_output .=$rowr['status'];

             $csv_output .="\t";	*/

            $csv_output .=$rowr['table_no'];

            $csv_output .="\t";

            

            $i_cnt = $i_cnt + 1 ;

            $csv_output .="\n\n";

        }

        header("Content-type: application/vnd.ms-excel");

        header("Content-disposition: xls" . date("Y-m-d") . ".xls");

        header( "Content-disposition: filename=".$file.".xls");

        print $csv_output;

        exit;

    }

}