<?php

defined('BASEPATH') or exit('No direct script access allowed');



/*

|--------------------------------------------------------------------------

| Display Debug backtrace

|--------------------------------------------------------------------------

|

| If set to TRUE, a backtrace will be displayed along with php errors. If

| error_reporting is disabled, the backtrace will not display, regardless

| of this setting

|

*/

defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);



/*

|--------------------------------------------------------------------------

| File and Directory Modes

|--------------------------------------------------------------------------

|

| These prefs are used when checking and setting modes when working

| with the file system.  The defaults are fine on servers with proper

| security, but you may wish (or even need) to change the values in

| certain environments (Apache running a separate process for each

| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should

| always be used to set the mode correctly.

|

*/

defined('FILE_READ_MODE')  or define('FILE_READ_MODE', 0644);

defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);

defined('DIR_READ_MODE')   or define('DIR_READ_MODE', 0755);

defined('DIR_WRITE_MODE')  or define('DIR_WRITE_MODE', 0755);



/*

|--------------------------------------------------------------------------

| File Stream Modes

|--------------------------------------------------------------------------

|

| These modes are used when working with fopen()/popen()

|

*/

defined('FOPEN_READ')                           or define('FOPEN_READ', 'rb');

defined('FOPEN_READ_WRITE')                     or define('FOPEN_READ_WRITE', 'r+b');

defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care

defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care

defined('FOPEN_WRITE_CREATE')                   or define('FOPEN_WRITE_CREATE', 'ab');

defined('FOPEN_READ_WRITE_CREATE')              or define('FOPEN_READ_WRITE_CREATE', 'a+b');

defined('FOPEN_WRITE_CREATE_STRICT')            or define('FOPEN_WRITE_CREATE_STRICT', 'xb');

defined('FOPEN_READ_WRITE_CREATE_STRICT')       or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');



/*

|--------------------------------------------------------------------------

| Exit Status Codes

|--------------------------------------------------------------------------

|

| Used to indicate the conditions under which the script is exit()ing.

| While there is no universal standard for error codes, there are some

| broad conventions.  Three such conventions are mentioned below, for

| those who wish to make use of them.  The CodeIgniter defaults were

| chosen for the least overlap with these conventions, while still

| leaving room for others to be defined in future versions and user

| applications.

|

| The three main conventions used for determining exit status codes

| are as follows:

|

|    Standard C/C++ Library (stdlibc):

|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html

|       (This link also contains other GNU-specific conventions)

|    BSD sysexits.h:

|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits

|    Bash scripting:

|       http://tldp.org/LDP/abs/html/exitcodes.html

|

*/

defined('EXIT_SUCCESS')        or define('EXIT_SUCCESS', 0); // no errors

defined('EXIT_ERROR')          or define('EXIT_ERROR', 1); // generic error

defined('EXIT_CONFIG')         or define('EXIT_CONFIG', 3); // configuration error

defined('EXIT_UNKNOWN_FILE')   or define('EXIT_UNKNOWN_FILE', 4); // file not found

defined('EXIT_UNKNOWN_CLASS')  or define('EXIT_UNKNOWN_CLASS', 5); // unknown class

defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member

defined('EXIT_USER_INPUT')     or define('EXIT_USER_INPUT', 7); // invalid user input

defined('EXIT_DATABASE')       or define('EXIT_DATABASE', 8); // database error

defined('EXIT__AUTO_MIN')      or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code

defined('EXIT__AUTO_MAX')      or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



/*

|--------------------------------------------------------------------------

| Define Project level constants

|--------------------------------------------------------------------------

| This constants used in whole project

|

*/

define('ADMIN_SESSION_NAME', 'admin_login_session');

define('USER_SESSION_NAME', 'tej_login_session');



//Below things need to be configured

//==================================

define('PROJECT_TITLE', 'Bengaluru Tech Summit');

define('PROJECT_LOGO', '/assets/img/logo.png');

define('EVENT_LOGO_LINK', PROJECT_LOGO);

define('EVENT_NAME', 'Bengaluru Tech Summit');



define('TABLE_PREFIX', 'it');

define('EVENT_YEAR', 2025);



define('EVENT_DATE', '18 Nov - 20 Dec, ' . EVENT_YEAR);

define('EVENT_WEBSITE', 'https://bengalurutechsummit.com/web/bts-interlinx/');

define('EVENT_MAILER_LOGO_LINK', 'https://www.bengalurutechsummit.com/web/bts-interlinx/assets/img/logo.png');

define('LOGO_WIDTH', '80%');

define('EVENT_ENQUIRY_EMAIL', 'enquiry@interlinx.in');

define('EVENT_INTERLINX_NO_OF_DAYS', 3);

//define('EVENT_INTERLINX_DATE_ARR', serialize(array('2023-11-29', '2023-11-30', '2023-12-01')));

define('EVENT_INTERLINX_DATE_ARR', serialize(array('2025-11-18', '2025-11-19', '2025-11-20')));



define('INTERLINX_FOLDER_NAME', 'bts-interlinx/');

define('INTERLINX_LINK', 'https://www.bengalurutechsummit.com/web/bts-interlinx/'); //http://www.interlinx.in/



define('DOLLAR_RATE', 74);



define('ZOOM_MEETING_ACTIVATE_DATE', '2025-12-29');

define('IS_ZOOM_MEETING_ACTIVATE', false);



define('ZOOM_USER_ID_LIST', serialize(array('info@interlinks.in', 'sagar.patil@interlinks.in', 'mayuri.ladi@interlinks.in', 'accounts@interlinks.in', 'bengaluru.backup1@mmactiv.com', 'btsmarketing@mmactiv.com', 'conference@mmactiv.com', 'copywriter@mmactiv.com', 'creatives@mmactiv.com', 'ela.dhawan@mmactiv.com', 'ims2020@mmactiv.com', 'jagdish@interlinks.in', 'kalyani.sharma@mmactiv.com', 'milan.ks@mmactiv.com', 'mmactiv.images@mmactiv.com', 'mumbai.backup1@mmactiv.com', 'narayanan.suresh@mmactiv.com', 'noreply@interlinks.in', 'ondemand@mmactiv.com', 'pranoti.manapure@interlinks.in', 'rohit.thumbre@mmactiv.com', 'sagar.kadam@mmactiv.com', 'sales2019@mmactiv.com', 'sandhya.nanjappa@mmactiv.com', 'social@mmactiv.com', 'sonali.wankhade@mmactiv.com', 'srikant.kumar@mmactiv.com', 'srinivas.rasoor@mmactiv.com', 'sumitra.issac@mmactiv.com', 'un-exhibit@mmactiv.com')));

//JWT of account MMA valid till 23:59 12/15/2020

define('JWT_TOKEN', 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6ImYteUtESnlLUjAyaG5NUTZGV1FKR1EiLCJleHAiOjE2Mzk1OTI5NDAsImlhdCI6MTYzNDIwNzE4M30.V11naeVu3AEw4Hlz1oQkbuHV4D7wJ2oNa3bmDIxngvs');

//==================================



define('EVENT_FROM_NAME', EVENT_NAME . ' ' . EVENT_YEAR . ' InterlinX');

define('INTERLINX_NAME', EVENT_NAME . ' ' . EVENT_YEAR . ' InterlinX');

define('EVENT_THANK_YOU_NAME', "Team " . EVENT_NAME . " InterlinX");

define('EVENT_WEBSITE_FORM_LINK', EVENT_WEBSITE . 'web/it_forms/');

define('EVENT_WEBSITE_LINK', EVENT_WEBSITE_FORM_LINK);

define('EVENT_INTERLINX_PATH', EVENT_WEBSITE . INTERLINX_FOLDER_NAME);

define('EVENT_INTERLINX_DIR', EVENT_WEBSITE . INTERLINX_FOLDER_NAME);

define('COMMON_IMAGE_PATH', EVENT_INTERLINX_PATH . 'images/');

define('INTERLINX_LOGO_LINK', 'assets/img/interlinx-logo.png');

define('EVENT_INTERLINX_LINK', 'https://bengalurutechsummit.com/web/bts-interlinx/');//EVENT_WEBSITE . INTERLINX_FOLDER_NAME);

define('EVENT_FROM_EMAIL', EVENT_ENQUIRY_EMAIL);

define('EVENT_INTERLINX_REG_LINK', 'https://www.bengalurutechsummit.com/web/it_forms/registration.php');

/* define('EVENT_NAME', 'Project');

define('EVENT_NAME', 'Project');

define('EVENT_NAME', 'Project'); */



/*

 |--------------------------------------------------------------------------

 | Define database table constants

 |--------------------------------------------------------------------------

 | This constants used in whole project

 |

 */

define('EVENT_TBL_MSTR_COMMUNITY', TABLE_PREFIX . '_' . EVENT_YEAR . '_master_community_tbl');

define('EVENT_TBL_INX_REG_TBL', TABLE_PREFIX . '_' . EVENT_YEAR . '_interlinx_reg_table');

define('EVENT_TBL_FRNDS', TABLE_PREFIX . '_' . EVENT_YEAR . '_frnds_table');

define('EVENT_TBL_ALL_USR_KEYWORD', TABLE_PREFIX . '_' . EVENT_YEAR . '_all_user_keyword_table');

define('EVENT_TBL_ALL_USR_PRODUCT_DTLS', TABLE_PREFIX . '_' . EVENT_YEAR . '_all_user_product_details');

define('EVENT_TBL_ALL_USR_SHDL', TABLE_PREFIX . '_' . EVENT_YEAR . '_all_users_schedule');

define('EVENT_TBL_MSG', TABLE_PREFIX . '_' . EVENT_YEAR . '_msg_table');

define('EVENT_TBL_GLBL_MEETING', TABLE_PREFIX . '_' . EVENT_YEAR . '_global_meeting_table');

define('EVENT_TBL_ALL_TABLE_ALL', TABLE_PREFIX . '_' . EVENT_YEAR . '_table_all');

define('EVENT_TBL_AVBL_TIME_SLOTS', TABLE_PREFIX . '_' . EVENT_YEAR . '_avb_time_table_slots');

define('EVENT_TBL_REG_DEMO', TABLE_PREFIX . '_' . EVENT_YEAR . '_reg_tbl_demo');

define('EVENT_TBL_REG_LOGIN', TABLE_PREFIX . '_' . EVENT_YEAR . '_reg_tbl_login');

define('EVENT_TBL_REG', TABLE_PREFIX . '_' . EVENT_YEAR . '_reg_tbl');



/*

 |--------------------------------------------------------------------------

 | Define Email configuration constants

 |--------------------------------------------------------------------------

 | This constants used to send mail using email library

 |

 */

define('MAIL_PROTOCOL', 'smtp');

define('MAIL_HOST', 'mail.bengalurutechsummit.com');

define('MAIL_PORT', '25');

define('MAIL_USER', 'enquiry-bengalurutechsummit');

define('MAIL_PASSWORD', 'Enq@ui2ry@be');

define('MAIL_FROM_EMAIL', EVENT_ENQUIRY_EMAIL);

define('MAIL_FROM_NAME', EVENT_NAME);



/*

 |--------------------------------------------------------------------------

 | Define payment status and payment mode constants

 |--------------------------------------------------------------------------

 */

define('PAYMENT_STATUS_PAID', 'Paid');

define('PAYMENT_STATUS_NOT_PAID', 'Not Paid');

define('PAYMENT_STATUS_PARTIAL', 'Partial');



define('PAYMENT_MODE_CC', 'CCAvenue');

define('PAYMENT_MODE_BT', 'Bank Transfer');

define('PAYMENT_MODE_CHEQUE', 'Cheque/DD');

define('PAYMENT_MODE_PAYPAL', 'Paypal');

define('PAYMENT_MODE_COMPLIMENTARY', 'Complimentary');



define('GST', 18);

define('DOLLAR', 83);

define('AMOUNT_EXTENSION_INR', 'INR');

define('AMOUNT_EXTENSION_USD', 'USD');

define('CCAVENUE_PROCESSING_CHARGE_PER', 7);

define('PAYPAL_PROCESSING_CHARGE_PER', 9.3);

