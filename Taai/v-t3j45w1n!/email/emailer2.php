<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <title><?php echo EVENT_NAME;?></title>	
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


		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td width='600' align='center' valign='middle'>&nbsp;</td>
          </tr>
        </table>
		<form id='form1' action='' method='post'>
		  <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
            
            <tr>
              <td valign='top' class='style4'></td>
              <td colspan='4' valign='top' class='style4'>&nbsp;</td>
            </tr>
            <tr>
              <td valign='top' class='style4'></td>
              <td width='225' align='center' valign='middle' class='style4'><a href="<?php echo EVENT_INTERLINX_LINK;?>" target='_blank'><img align='middle' border='0' src="<?php echo EVENT_MAILER_LOGO_LINK;?>" title="<?php echo INTERLINX_NAME;?>" alt="<?php echo INTERLINX_NAME;?>" width='120'></a></td>
              <td width='269' align='center' valign='middle' class='style4'>
			   
			  </td>
              <td width='23' valign='top' class='style4'>&nbsp;</td>
              <td width='11' valign='top' class='style4'>&nbsp;</td>
            </tr>
            <tr>
              <td valign='top' class='style4'></td>
              <td colspan='4' valign='top' class='style4'>&nbsp;</td>
            </tr>
            <tr>
              <td width='72' height='10' valign='top' class='style4'></td>
              <td colspan='4' valign='top' class='style4'>Dear <?php echo $qry_email_chk_ans['title'] . ' ' . $qry_email_chk_ans['fname'] . ' ' . $qry_email_chk_ans['lname'];?></td>
            </tr>
            <tr>
              <td valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'></td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'>Thank you for registering with us. </td>
            </tr>
            
            <tr>
              <td valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'>&nbsp;</td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'>The Following are your login details. </td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'></td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'>Username : <?php echo $qry_email_chk_ans['user_name'];?></td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'></td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'>Password : <?php echo $qry_email_chk_ans['pass1'];?></td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'></td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'><a href="<?php echo EVENT_INTERLINX_LINK;?>" target='_blank'>Click Here</a> to login to <?php echo EVENT_FROM_NAME;?>.</td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'></td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'>Happy  Partnering, </td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'></td>
            </tr>
            <tr>
              <td height='10' valign='top' class='style4'>&nbsp;</td>
              <td colspan='4' valign='top' class='style4'><p><?php echo EVENT_THANK_YOU_NAME;?></p></td>
            </tr>
          </table>
		  <p class='submit'>&nbsp;</p>								
  </form>		
</div>
</body>
</html>