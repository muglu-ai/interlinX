<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $title_for_layout;?></title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <?php echo link_tag('assets/plugins/fontawesome-free/css/all.min.css');?>
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <?php echo link_tag('assets/theme/css/adminlte.min.css');?>
        <!-- colors style -->
        <?php echo link_tag('assets/css/color.css');?>
        <!-- custom style -->
        <?php echo link_tag('assets/css/custom-style.css');?>
		<?php echo link_tag('assets/css/style.css');?>
		
		<!-- Jquery JS-->
		<?php echo script_tag('assets/plugins/jquery/jquery.min.js');?>
        <!-- jQuery UI 1.11.4 -->
        <?php echo script_tag('assets/plugins/jquery-ui/jquery-ui.min.js');?>
        <!-- Bootstrap 4 -->
        <?php echo script_tag('assets/plugins/bootstrap/js/bootstrap.bundle.min.js');?>
        <!-- AdminLTE App -->
        <?php echo script_tag('assets/theme/js/adminlte.js');?>		
		<?php echo script_tag('assets/js/common.js');?>
	</head>
	<body class="hold-transition sidebar-mini sidebar-collapse">
		<div class="wrapper">
			<!-- Navbar -->
    		<?php $this->load->view('layouts/header');?>
			<!-- /.navbar -->
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper ">
				<!-- Main content -->
				<?php echo $content_for_layout;?>
				<!-- /.content -->
			</div>
			<!-- footer -->
			<?php $this->load->view('layouts/footer');?>
			<!-- /.footer -->
		</div>
		<!-- ./wrapper -->
		
		<script type="text/javascript">
			$(document).ready(function() {
    			$('#search').keypress(function (e) {
                  if (e.which == 13) {
                  	$('#tej-search').submit();
                        return false;
                  	if($('#search').val() != '') {
                        
                    }
                  }
                });
            });
            
            
		  	window.setInterval(function(){
			  $.get('<?php echo base_url('notifications');?>', function(response) {
			  	$('.tej-msg-count').text(response.messages);
			  	$('.tej-meet-count').text(response.meetings);
			  	$('.tej-total-count').text(response.total);
			  	if(response.meetings == 0) {
			  		$('.tej-reqp').hide();
			  	} else {
			  		$('.tej-reqp').show();
			  	}
			  	if(response.messages == 0) {
			  		$('.tej-mesp').hide();
			  	} else {
			  		$('.tej-mesp').show();
			  	}
			  },'json');
			}, 4000);
			
			function chnageValue(type) {
				$('#type').val(type);
    			if(type == 'org') {
    				$('#type').val('org-sea');
    			}
    			if(type == 'country') {
    				$('#type').val('country-sea');
    			}
    			$('#tej-search').submit();
				/* if($('#search').val() != '') {
    				
    			} */
    			
    			return false;
			}
		</script>
	</body>
</html>