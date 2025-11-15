<table width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">
<tr>
<td>
<table width="70%" align="center">
<tr>
  <td>
  <table width="100%">
  <tr>
  <td align="left" valign="middle">
  <a href="<?php echo INTERLINX_LINK;?>" target="_blank"><img src="<?php echo base_url(INTERLINX_LOGO_LINK);?>" border="0" /></a> </td>
  <td align="right" valign="middle">
<a href="<?php echo EVENT_INTERLINX_LINK;?>" target="_blank"><img align="middle" border="0" src="<?php echo EVENT_MAILER_LOGO_LINK;?>" title="<?php echo INTERLINX_NAME;?>" ></a>  </td>
  </tr>
  </table>  </td>
  </tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><strong>Meeting Schedule of <?php echo $this->userauth->get_userdata('title') . ' ' . $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname');?> for <?php echo EVENT_FROM_NAME;?></strong></td>
  </tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>
  	<table width="100%" align="center" border="1" cellpadding="5px;" cellspacing="0">
	<tr>
	  <th>Srno</th>
	  <th>Meeting With ( Designation)</th>
	  <th>Organization Name</th>
	  <th>Time Slot</th>
	  <th>Date and Day</th>
	  <th>InterlinX Meeting Venue</th>
	  </tr>
	<?php 
	$i_cnt = 1;
	foreach ($schedule_record_list as $rowr) {?>
	<tr>
	  <td><?php echo $i_cnt++;?></td>
	  <td><?php echo $rowr["sender_title"].' '.$rowr["sender_fname"].' '.$rowr["sender_lname"].'('.$rowr["sender_desig"].')';?></td>
		<?php $temp_meet_time_start_arr = explode(":",$rowr['meeting_time_start']);
		$temp_meet_time_end_arr = explode(":",$rowr['meeting_time_end']);?>
	  <td><?php echo $rowr["sender_org"];?></td>
	  <td> <?php echo '('.$temp_meet_time_start_arr[0].':'.$temp_meet_time_start_arr[1].') to ('.$temp_meet_time_end_arr[0].':'.$temp_meet_time_end_arr[1].')';?> </td>
	  <td><?php echo $rowr["meeting_date"];?></td>
	  <td><?php echo $rowr["table_no"];?></td>
	 </tr>
	<?php }?>
	  
	</table>  </td>
  </tr>
<tr>
  <td>&nbsp;</td>
  </tr>

<tr>
<td width="36%">&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>