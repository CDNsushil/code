<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form used to add review of users....?>		
<?php if(!empty($error_string)):?>
	<div class="error-box">
		<?php echo $error_string;?>
	</div>
<?php endif;?>
<section class="item testimonial ">
	<div class="content ">
	<?php echo form_open(uri_string()); ?>

		
			<div>
				<h3 class="mt10"><span class=""><?php echo lang('user:add_testimonials');?>
			</div>
			<div>
				<label for="first_name"><?php echo lang('user:topic') ?><span>*</span></label>
				<?php echo form_input('topic',$_testimonial->topic,'required')?>
			</div>		
			<div>	
				<label for="description"><?php echo lang('user:your_experience') ?><span>*</span></label>
				<?php echo form_textarea('description',$_testimonial->description,'required')?>
			</div>
			<div>
				<?php  echo form_submit('save','Save','class="button"');?>
				<?php echo form_button('back',lang('global:back'),'required onClick="history.go(-1)" class="button"')?>
					
			</div>
		
		<?php echo form_close();?>
		</div>
	</section>



