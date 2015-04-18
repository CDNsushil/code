<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');
echo $head; ?>

<body class="<?php echo isset($bodyClass)?$bodyClass:'lpwh_bg';?>" >
	<div class="dn" id="popupBoxWp">
		<div class="popup_box" id="popup_box"></div>
	</div>
	<!------add verified email popup Condition start--------->
	
	<div class="<?php echo isset($mainClass)?$mainClass:'';?>">
		<div class="wrapper_toad">
			<?php 
			$this->load->view('header');
			?>
			<div class="content_front_wrapper">
				<div class="pt10 pr10 pb10 pl10">
					<div class="bg_444">
						<?php if(isset($content)){echo $content;}?> 
						<div class="clear"></div>
					</div>
				</div><!--content_wrapper-->
			</div><!--content_wrapper-->
			<div class="clear"></div>
			<?php $this->load->view('footer');?>
		</div>
	</div><!--main-->   
	
</body>
</html>
