<?php defined('BASEPATH') or exit('No direct script access allowed'); 
	$userId=is_logged_in();
	$this->load->view('page_contents');
?>
<div class="clearfix"></div> 
<div class="row">
	<div class="col-sm-12">
		<p class="affiliate_signup">
			<?php if(!$userId){ ?>
			<a class="btn big_btn" href="<?php echo base_url('register')?>">Sign Up Now<i class="fa fa-arrow-right"></i></a>
			<?php } ?>
		</p>
	</div>
</div>
                    
            	
        



