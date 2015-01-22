<?php defined('BASEPATH') or exit('No direct script access allowed');
	$checked='checked';
?>

<section class="title">
	<?php if ($this->method === 'create'): ?>
		<h4><?php echo lang('cms:add_title') ?></h4>
		<?php echo form_open_multipart('admin/cms/save', 'class="crud" autocomplete="off"') ?>
	
	<?php else: ?>
		<h4><?php echo sprintf(lang('cms:edit_title'), ucfirst($cms['title'])) ?></h4>
		<?php echo form_open_multipart('admin/cms/save', 'class="crud"') ?>
	<?php endif;
    echo form_input(array('type'=>'hidden','value'=>$cms['id'],'name'=>'id'));
    ?>
</section>

<section class="item">
	<div class="content">
		<div class="tabs">
			<!-- Content tab -->
			<div class="form_inputs" id="user-basic-data-tab">
				<fieldset>
					<ul>
						
						<li class="even">
							<label for="title"><?php echo lang('cms:title') ?> <span>*</span></label>
							<div class="input">
								<?php echo form_input('title', $cms['title'], 'id="title" required class="alpha"') ?>
								<span class="error"></span>
							</div>
						</li>
						
                        <li>
                            <label for="description"><?php echo lang('cms:content'); ?> <span>*</span></label>
                            <div class="input"><?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $cms['description'], 'rows'=>10, 'cols'=>40, 'class'=>'required wysiwyg-advanced')) ?></div>
                        </li>
						
						<li class="even">
							<label for="active"><?php echo lang('cms:status') ?><span>*</span></label>
							<div class="input">
								<?php $options = array(1 => lang('cms:enabled'), 0 => lang('cms:disabled')) ?>
								<?php echo form_dropdown('status', $options, $cms['status'], 'id="status"') ?>
							</div>
						</li>
					</ul>
				</fieldset>
			</div>
		</div>
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )) ?>
		</div>
	
	<?php echo form_close() ?>

	</div>
</section>

<script>
	$( document).ready(function() {
	var error=false;
	$('form').submit(function(){
		if(error){
			return false;
		}
	});
});
</script>
