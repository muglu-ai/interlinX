<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = "auth";

//Auth controller
$route['index'] = "auth/index";
$route['logout'] = "auth/logout";
$route['forgot-password'] = "auth/forgot_password";
//http://localhost/work/IT2020/terms_and_conditions.php
$route['terms-and-condition'] = "auth/terms_condition";

//Home controller
$route['home'] = "home/index";
$route['shortlisted-partners'] = "home/shortlisted_partners";
$route['shortlisted-partners/(:num)'] = "home/shortlisted_partners/$1";
$route['accepted-meetings'] = "home/accepted_meetings";
$route['accepted-meetings/(:num)'] = "home/accepted_meetings/$1";
//$route['pending-meetings'] = "home/pending_meetings";
//$route['pending-meetings/(:num)'] = "home/pending_meetings/$1";
$route['your-matched'] = "home/your_matched";
$route['your-matched/(:num)'] = "home/your_matched/$1";
$route['latest-registration'] = "home/latest_reg";
$route['latest-registration/(:num)'] = "home/latest_reg/$1";

//Search
$route['search-redirect'] = "home/search_redirect";
//Default search
$route['search'] = "home/search";
$route['search/(:any)'] = "home/search/$1";
$route['search/(:any)/(:num)'] = "home/search/$1/$2";
//search-by-name
$route['search-by-name'] = "home/search_by_name";
$route['search-by-name/(:any)'] = "home/search_by_name/$1";
$route['search-by-name/(:any)/(:num)'] = "home/search_by_name/$1/$2";

//search-by-industry-sector
$route['search-by-industry-sector'] = "home/search_by_industry_sector";
$route['search-by-industry-sector/(:any)'] = "home/search_by_industry_sector/$1";
$route['search-by-industry-sector/(:any)/(:num)'] = "home/search_by_industry_sector/$1/$2";

//search-by-org
$route['search-by-org'] = "home/search_by_org";
$route['search-by-org/(:any)'] = "home/search_by_org/$1";
$route['search-by-org/(:any)/(:num)'] = "home/search_by_org/$1/$2";

//search-by-country
$route['search-by-country'] = "home/search_by_country";
$route['search-by-country/(:any)'] = "home/search_by_country/$1";
$route['search-by-country/(:any)/(:num)'] = "home/search_by_country/$1/$2";

//search-by-keyword
$route['search-by-keyword'] = "home/search_by_keyword";
$route['search-by-keyword/(:any)'] = "home/search_by_keyword/$1";
$route['search-by-keyword/(:any)/(:num)'] = "home/search_by_keyword/$1/$2";

//search-by-keyword
$route['search-by-turnover'] = "home/search_by_turnover";
$route['search-by-turnover/(:num)/(:num)/(:any)'] = "home/search_by_turnover/$1/$2/$3";
$route['search-by-turnover/(:num)/(:num)/(:any)/(:num)'] = "home/search_by_turnover/$1/$2/$3/$4";

$route['notifications'] = "home/notifications";

//Delegate controller
$route['personal-detail'] = "delegate/personal_detail";
$route['personal-detail/update'] = "delegate/personal_detail_update";
$route['upload-photo'] = "delegate/upload_photo";
$route['change-password'] = "delegate/change_password";
//http://localhost/work/IT2020/personnal_page_every_one.php?lmd=ilt_clm_2345567789618&umd=it_2020_nrm_8121616&tmd=izt_com_53347621479083
$route['delegate-personal-detail/(:any)'] = "delegate/delegate_personal_detail/$1";
$route['delete-organisation-file'] = "delegate/delete_organisation_file";

//Product Services controller
$route['product-services/add'] = "product_Services/add";
$route['product-services/update/(:num)'] = "product_Services/update/$1";
$route['product-services/list'] = "product_Services/lists";
$route['product-services/delete/(:num)'] = "product_Services/delete/$1";

//Industry_Sector controller
$route['industry-sectors'] = "industry_Sector/lists";
$route['looking-for'] = "industry_Sector/your_interested_area";
$route['my-industry-sectors'] = "industry_Sector/my_industry_sectors";

//Messages controller
$route['messages/inbox'] = "messages/inbox";
$route['messages/inbox/(:num)'] = "messages/inbox/$1";
$route['messages/read/(:any)'] = "messages/read_message/$1";
$route['messages/read/(:any)/(:any)'] = "messages/read_message/$1/$2";
$route['messages/send-reply'] = "messages/send_reply";
$route['messages/inbox/delete/(:any)'] = "messages/inbox_delete/$1";
$route['messages/sent'] = "messages/sent";
$route['messages/sent/delete/(:any)'] = "messages/sent_delete/$1";
$route['messages/compose'] = "messages/compose";

//schedule controller
$route['my-calendar'] = "schedule/my_calendar";
//List view of sent 
$route['sent-meeting-request'] = "schedule/sent_meeting_request";
$route['sent-meeting-request/(:num)'] = "schedule/sent_meeting_request/$1";
//List view of received
$route['received-meeting-request'] = "schedule/received_meeting_request";
$route['received-meeting-request/(:num)'] = "schedule/received_meeting_request/$1";
$route['set-meeting-status/(:any)/(:any)'] = "schedule/set_meeting_status/$1/$2";

//http://localhost/work/IT2020/edit_my_schedule.php & 
//Edit button on this page //edit_my_schedule2.php
$route['edit-my-calendar'] = "schedule/edit_my_calendar";
//cancel_my_schedule2.php
$route['cancel-my-schedule'] = "schedule/cancel_my_schedule";
//cancel_my_schedule3.php
$route['make-free'] = "schedule/make_free";

//Shortlist Partner: add_friend.php
$route['add-friend/(:any)'] = "schedule/add_friend/$1";

$route['view-schedule/(:any)'] = "schedule/view_schedule/$1";

$route['export'] = "schedule/export_data";
$route['dwnld_data_in_acceptd_data_word'] = "schedule/dwnld_data_in_acceptd_data_word";
$route['dwnld_data_in_excel'] = "schedule/dwnld_data_in_excel";
$route['dwnld_data_in_excel_arr_slot'] = "schedule/dwnld_data_in_excel_arr_slot";
$route['dwnld_data_in_excel_free_slot'] = "schedule/dwnld_data_in_excel_free_slot";

$route['404_override'] = '';
//$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'auth/login_api';
$route['profile-update'] = 'delegate/update_api';
$route['user-meetings'] = 'schedule/my_calendar_api';
$route['user-sent-meetings'] = 'schedule/sent_meeting_request_api';
$route['user-received-meetings'] = 'schedule/received_meeting_request_api';

//$route['set-meeting-status/(:any)/(:any)'] = "schedule/set_meeting_status/$1/$2";

$route['user-set-meeting-status/(:any)/(:any)'] = 'schedule/set_meeting_status_api/$1/$2';