<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Terms and Condition</h1>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<div class="container">
		<div class="row">
			<div class="">
				<div class="card card-primary card-outline p-5">
					<form action="<?php echo base_url('terms-and-condition');?>" onsubmit="return validterms()" method="post">
						<p><strong>We are pleased to inform you that you now have access to InterlinX- The Online Partnering Tool, which will enable you to:</strong></p>	
						<ol>
							<li>Update your Profile on the InterlinX Partnering Tool so that other registered users can browse through the same and vice versa. High quality meeting request that you may receive will depend upon how well defined is your profile.</li>
							<li>Update your Meeting Scheduler according to your availability for the meetings. Make sure that you select your slots carefully so that they don't clash with your other IMP programs.</li>
							<li>Identify delegates whom you would like to meet. Search options based on country, name, organisations or key words available.</li>
							<li>Shortlist prospective delegates to avoid searching for them time and again.</li>
							<li>Send meeting requests to prospective delegates by choosing one of the available slots. If he/she accepts your request the meeting will automatically get scheduled.</li>
							<li>For each scheduled / accepted meeting(s) you will be allotted with a specific table in InterlinX B2B meeting lounge. Make sure once committed you should attend the meeting. Kindly note that the delegates who miss out on two meetings without intimation will be blocked from conducting further meetings. You may Cancel/ Reschedule your meeting up to 1 hour before the scheduled time.</li>
							<li>InterlinX tool also provide you facility to send or received message(s) to/from other delegates.</li>
							<li>So what are you waiting for? Go ahead and make new connections!</li>
						</ol>
						<p><strong>Note: </strong><i>Kindly note that InterlinX-Tool is only a medium to enhance your chances of meeting the delegates of your preference, However InterlinX-Tool does not guarantee any meetings.</i></p>
						
						<div><label><input name="termconditions" id="termconditions" type="checkbox" value="Yes" />&nbsp;Yes I have read all Steps very Clearly.</label></div>
						<button type="submit" class="btn btn-success btn-md">Yes, I read</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
function validterms()
{
	if(document.getElementById('termconditions').checked==false)
	{
		alert('Please read all steps clearly');
		document.getElementById('termconditions').focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>