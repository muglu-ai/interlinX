<?php
$mail_interlinx_str = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head> 
	<title>" . $EVENT_NAME . "</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />    
	<meta name='keywords' content=''></meta>
	<meta name='description' content='Free form designs from CSS Globe'></meta>
	<meta http-equiv='imagetoolbar' content='no' />
	<style type='text/css'>
body{ 
	background:#f8f8f8;
	font:13px Trebuchet MS, Arial, Helvetica, Sans-Serif;
	color:#333;
	line-height:160%;
	margin:0;
	padding:0; 
	text-align:center;
	}

h1{
	font-size:200%;
	font-weight:normal;
	}		
h2, h3, h4, h5, h6{
	font-weight:normal;
	margin:1em 0;
	}	
h2{            
	font-size:160%;
	}	
h3{          
	font-size:140%;
	}
h4{          
	font-size:120%;
	}				

a{
	text-decoration:none;
	color:#f30;
	}
a:hover{
	color:#999;
	}			
table, input, textarea, select, li{
	font:100% Trebuchet MS, Arial, Helvetica, Sans-Serif;
	line-height:160%;
	color:#333;
	}				
p, blockquote, ul, ol, form{
	margin:1em 0;
	}
blockquote{
	}
img{
	border:none;
	}			
hr{
	display:none;
	}	
table{
	margin:1em 0;
	width:100%;
	border-collapse:collapse;
	}
th, td{	
	padding:2px 5px;
	}	
th{	
	text-align:left;
	}
li{
	display:list-item;
	}	
	
#container{	
	margin:0 auto;
	background:#fff;
	width:600px;
	padding:20px 40px;
	text-align:left;
	}		
	#form1{
		margin:1em 0;
		padding-top:10px;
		background:url(http://www.interlinx.in/images/form1/form_top.gif) no-repeat 0 0;
		}
	#form1 fieldset{
		margin:0;
		padding:0;
		border:none;	
		float:left;
		display:inline;
		width:260px;
		margin-left:25px;
		}		
	#form1 legend{display:none;}	
	#form1 p{margin:.5em 0;}	
	#form1 label{display:block;}	
	#form1 input, #form1 textarea{		
		width:252px;
		border:1px solid #ddd;
		padding:3px;
		}		
	#form1 textarea{
		height:125px;
		overflow:auto;
		}					
	#form1 p.submit{
		clear:both;
		background:url(http://www.interlinx.in/images/form1/form_bottom.gif) no-repeat 0 100%;
		padding:0 25px 20px 25px;
		margin:0;
		text-align:right;
		}	
	#form1 button{
		width:129px;
		height:35px;
		line-height:35px;		
		border:none;
		background:url(http://www.interlinx.in/images/form1/form_button.gif) no-repeat 0 0;
		color:#fff;
		cursor:pointer; 
		text-align:center;
		}	
.style1 {color: #005DA6}
.style3 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
}
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #000000; font-weight: bold; }
.style4 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
.style5 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FF0000;
}
-->
    </style>
</head>
<body>

<div id='container'>


		<table width='100%' border='0' cellspacing='0' cellpadding='0' align='left'>
          <tr>
            <td width='600' align='center' valign='middle'>&nbsp;</td>
          </tr>
        </table>
		<form id='form11' action='' method='post'>
		  <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
            
            <tr>
              <td valign='top' class='style4'></td>
              <td colspan='4' valign='top' class='style4'>&nbsp;</td>
            </tr>
            <tr>
              <td width='267' colspan='5' valign='middle' class='style4'>			  
			  <a href='" . $EVENT_WEBSITE_LINK . "' target='_blank'><img src='" . $EVENT_LOGO_LINK . "' title='" . $EVENT_NAME . " " . $EVENT_YEAR . "' alt='" . $EVENT_NAME . " " . $EVENT_YEAR . "' border='0' align='middle' width='18%'/></a>
			 </td>
            </tr>
            <tr>
              <td valign='top' class='style4'></td>
              <td colspan='4' valign='top' class='style4'>&nbsp;</td>
            </tr>
            <tr>
              <td colspan='4' valign='top' class='style4'>Dear " . $qr_gt_user_inx_login_data_ans['title'] . " " . $qr_gt_user_inx_login_data_ans['fname'] . " " . $qr_gt_user_inx_login_data_ans['lname'] . "</td>
            </tr>
            <tr>
              <td valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'></td>
            </tr>
            <tr>
              <td colspan='4' valign='top' class='style4'>
			  
			 We are pleased to inform you that you now have access to IEIA Open Seminar B2B Meetings Portal, which will enable you to:
              <ol style='font-size: 14px;'>
              	<li>Update your Profile on the B2B Portal Tool so that other registered users can browse through the same and vice versa. </li>
              	<li>Update your Meeting Scheduler according to your availability for the meetings. 
              	Make sure that you select your slots carefully so that they don't clash with your other important programs.</li>
              	<li> Identify delegates whom you would like to meet. Search options based on country, name, organisations or keywords available.</li>
              	<li>Shortlist prospective delegates to avoid searching for them time and again.</li>
              	<li>Send meeting requests to prospective delegates by choosing one of the available slots. 
              	If he/she accepts your request the meeting will automatically get scheduled.</li>
              	<li>For each scheduled / accepted meeting(s) you will be allotted with a specific table in the B2B meeting lounge. 
              	Make sure once committed you should attend the meeting. 
              	Kindly note that the delegates who miss out on two meetings without intimation will be blocked from conducting further meetings.
              	 You may Cancel/ Reschedule your meeting up to 1 hour before the scheduled time.
</li>
              	<li>The B2B Meetings tool also provides you with a facility to send or receive message(s) to/from other delegates.</li>
              	
              </ol>
			  <center>So what are you waiting for? Go ahead and make new connections!</center>
              <p><strong>Note: </strong><i>Kindly note that IEIA Open Seminar B2B Meetings Portal Tool  is only a medium to enhance your chances of meeting the delegates of
               your preference, However IEIA Open Seminar B2B Meetings Portal Tool does not guarantee any meetings.</i>
              </p>
              <p>&nbsp;</p>
              <p><strong>Please find below your login details:</strong><br/>
              	<a href='" . $interlink . "' target='_blank'>Click Here</a> to login to " . $EVENT_NAME . " " . $EVENT_YEAR . " B2B Meetings Portal.<br/>
              	Username :  <strong>" . $qr_gt_user_inx_login_data_ans['user_name'] . "</strong><br/>
              	Password : <strong>" . $qr_gt_user_inx_login_data_ans['pass1'] . "</strong>
              </p><br/>
              <p>
			  Should you have any queries.<br/> Please do connect us at <a href='tel:+919834235670'>+91 - 98342 35670</a> /  <a href='mailto:tejas.rashinkar@interlinks.in'>tejas.rashinkar@interlinks.in</a> 

              </p>
              <p>We wish you a great networking..!!</p><br/>
              </td>
            </tr>
            <tr>
              <td colspan='4' valign='top' class='style4'>
              <p>Best Regards,<br/>
           IEIA Team</p></td>
            </tr>
              <td colspan='4' valign='top' class='style4'>&nbsp;
              <p style='font-weight: bold;'>INDIAN EXHIBITION INDUSTRY ASSOCIATION<br/> </p>
              4th Floor, PHD House</br>
              4/2 Siri Institutional Area<br/>
              August Kranti Marg</br>
              New Delhi – 110 016, India <br/>
              Tel: +91 11 410 45 481 / 83 <br/>
              E-mail : <a href='mailto:membership@ieia.in'> membership@ieia.in</a> <br/>
              </td>
          </table>
		  <p class='submit'>&nbsp;</p>								
  </form>		
</div>
</body>
</html>";
