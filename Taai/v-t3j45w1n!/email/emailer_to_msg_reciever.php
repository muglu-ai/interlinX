<html>
<head>

<title><?php echo EVENT_NAME;?></title>
</head>

<body style='margin-left: 0px; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; background-color:#e9e9e9;'>
  <table width='550' border='0' align='center' cellpadding='0' cellspacing='0'>
    <tr>
      <td align='left' valign='top'>&nbsp;</td>
    </tr>
    <tr>
      <td align='left' valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td width='10' align='left' valign='top'><img src='<?php echo COMMON_IMAGE_PATH;?>main-top-left-corner.gif' width='10' height='10' /></td>
          <td width='680' height='10' align='center' valign='top' bgcolor='#FFFFFF'></td>
          <td width='10' align='right' valign='top'><img src='<?php echo COMMON_IMAGE_PATH;?>main-top-right-corner.gif' width='10' height='10' /></td>
        </tr>
        <tr>
          <td align='left' valign='top' bgcolor='#FFFFFF'>&nbsp;</td>
          <td align='center' valign='top' bgcolor='#FFFFFF'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
              <tr>
                <td align='center' valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td align='left' valign='top'>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align='left' valign='top'><table width='90%' border='0' align='center' cellpadding='0' cellspacing='0'>
                        <tr>
                         
                          <td width='50%' align='center' valign='middle' bgcolor=''><a href='<?php echo EVENT_INTERLINX_LINK;?>' target='_blank'><img align='middle' border='0' src='<?php echo EVENT_MAILER_LOGO_LINK;?>' title='<?php echo INTERLINX_NAME;?>' /></a></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align='left' valign='top'>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align='left' valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          
                          <tr>
                            <td height='5' align='left' valign='top'></td>
                          </tr>
                          <tr>
                            <td align='right' valign='top'><table width='98%' border='0' cellspacing='0' cellpadding='0'>
                                <tr>
                                  <td width='4%' align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td width='96%' align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:left;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:left;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>Dear <?php echo $qry_frnd_info_chk_ans['title']." ".$qry_frnd_info_chk_ans['fname']." ".$qry_frnd_info_chk_ans['lname'];?> ,</td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>You  have received New Message on <?php echo EVENT_FROM_NAME;?> </td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                    <tr>
                                      <td style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>Organisation Name </td>
                                      <td style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;<?php echo $res['org_name'];?></td>
                                    </tr>
                                    <tr>
                                      <td style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                      <td style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td width='35%' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>Sender   Name</td>
                                      <td width='65%' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'><?php echo $res['title']." ".$res['fname']." ".$res['lname'];?></td>
                                    </tr>
                                  </table></td>
                                </tr>
								
								
								<tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                </tr>
                                
								<tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                    <tr>
                                      <td width='35%' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>Subject</td>
                                      <td width='65%' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'><?php echo $temp_msg_sub;?></td>
                                    </tr>
                                  </table></td>
                                </tr> 
								
								
								
								
								
								
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                </tr>
                                
								<tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                    <tr>
                                      <td width='35%' align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>Message</td>
                                      <td width='65%' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'><?php echo $temp_msg_txt;?></td>
                                    </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>To Reply, please go to following link:</td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'><a href='<?php echo EVENT_INTERLINX_LINK;?>' target='_blank'><?php echo EVENT_INTERLINX_LINK;?></a>.</td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                </tr>
                                
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'><p>Happy  Interlinking,</p></td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'><p><?php echo EVENT_THANK_YOU_NAME;?></p></td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                  <td align='left' valign='top' style='text-align:justify;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:11px;	line-height:18px; color:#6e6e6e; text-decoration:none;'>&nbsp;</td>
                                </tr>
                            </table></td>
                          </tr>
                      </table></td>
                    </tr>

                </table></td>
              </tr>
          </table></td>
          <td align='right' valign='top' bgcolor='#FFFFFF'>&nbsp;</td>
        </tr>
        <tr>
          <td align='left' valign='top'><img src='<?php echo COMMON_IMAGE_PATH;?>main-bottom-left-corner.gif' width='10' height='10' /></td>
          <td height='10' align='center' valign='top' bgcolor='#FFFFFF'></td>
          <td align='right' valign='top'><img src='<?php echo COMMON_IMAGE_PATH;?>main-bottom-right-corner.gif' width='10' height='10' /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align='left' valign='top'>&nbsp;</td>
    </tr>
    <tr>
      <td align='left' valign='top'>&nbsp;</td>
    </tr>
</table>
</body>
</html>