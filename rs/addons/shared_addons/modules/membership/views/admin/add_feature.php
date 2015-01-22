<?php    defined('BASEPATH') or exit('No direct script access allowed');  //***This for used to add/edit member details ***// ?>

<?php     
  
    if (!$this->method == 'editfeature'): ?>
	<section class="title">
    	<h4><?php echo lang('membership:edit_feature'); ?></h4>
	</section>
<?php else: ?>
	<section class="title">
    	<h4><?php echo lang('membership:add_feature') ?></h4>
	</section>
<?php endif ?>


<section class="item">
	<div class="content">
		<?php echo form_open(uri_string(), 'class="crud"') ?>
		
		<div class="form_inputs">
		
		    <ul>
				<li>
					<label for="title"><?php echo lang('membership:title');?> <span>*</span></label>
					<div class="input"><?php echo form_input('feature_title', $feature->feature_title);?></div>
				</li>
				<li>
					<label for="membership_status"><?php echo lang('membership:status');?> <span>*</span></label>
					<div class="input">
						<?php
						      $selected=$feature->feature_status;
						      $titleArray=array(lang('membership:enabled'),lang('membership:disabled'));
							  $other='class="" id="feature_status" ';
						      echo form_dropdown('feature_status',$titleArray, $selected, $other);
						  ?>
						</div>
				</li>
				
				<li class="even">
					<label for="name"><?php echo lang('membership:description');?> <span>*</span></label>
					
					<div class="input"><?php echo form_textarea('feature_description', $feature->feature_description);?></div>
				</li>
				
		    </ul>
		
		</div>
		
		<div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
		</div>
			
		<?php echo form_close();?>
	</div>
</section>

