<?php (defined('BASEPATH')) OR exit('No direct script access allowed');?>


	<div class="cell frm_heading row">
	<h1><?php echo $this->lang->line('headingNewCategory'); ?></h1>
	</div>
	<div class="seprator_20"></div>

		<div class="clear"></div>

	
	
	
		
	<div class="content_box bdr_non">
		<?php echo form_open(lang().'/admin/categories/save_category', 'class="form"'); ?>
			<div class="seprator_20"></div>

			   <p><div class="cell admin_label_width">
					<div class="cell label_wrapper_topic ml10" id="oneLineDescription">
						<label class="">		
							<?php echo $this->lang->line('categoryName'); ?>
						</label>
						</div>
					</div>
					<?php echo form_input($name); ?>
				</p>
					
		<div class="seprator_20"></div>

		<p class="clear">
		<div class="cell admin_label_width">
			<div class="cell label_wrapper_topic ml10" id="oneLineDescription">
				<label class="">		
					Parent Category:
				</label>
			</div>
		   </div>
			<div class="position_relative admin_select cell">
				<?php echo form_dropdown('category', $category_options); ?>&nbsp;&nbsp;
			</div>
		</p>
		
		<div class="seprator_20"></div>
			

		<p class="clear">
		<div class="cell admin_label_width">
			<div class="cell label_wrapper_topic ml10" id="oneLineDescription">
				<label class="">		
					Category Type:
				</label>
			</div>
		   </div>
			<div class="position_relative admin_select cell">
				<?php echo form_dropdown('type', $category_type); ?>&nbsp;&nbsp;
			</div>
		</p>

	<div class="clear"></div>
			<div class="seprator_20"></div>
			   <p><div class="cell admin_label_width" >
					<div class="cell label_wrapper_topic ml10" id="oneLineDescription">
						<label class="">		
							<?php echo $this->lang->line('categoryDescription'); ?>
						</label>
						</div>
					</div>
					<?php echo form_textarea($description); ?>
				</p>

		<div class="seprator_10"></div>
			   <p><div class="cell admin_label_width">
					<div class="cell label_wrapper_topic ml10" id="oneLineDescription">
						<label class="">		
							<?php echo $this->lang->line('categoryActive'); ?>
						</label>
						</div>
					</div>
					<?php
				       echo '<div class="defaultP mt10">'.form_checkbox($active).'</div>';                        
					 ?>
				</p>
				
						<div class="seprator_5 row"></div>

					<div class="clear"></div>
					

<?php 

?>

		<p class="clear">
 		   <div class="cell admin_label_width ">
				<div class="cell label_wrapper_topic" id="oneLineDescription">
					&nbsp;
				</div>
			 </div>
			 <div class="position_relative admin_select cell">
					<div class="tds-button">
					<button name="save" value="Save" type="submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" onclick="submitform();" >
						<span class="text-indent_0" style="background-position: right -38px;"><?php echo $this->lang->line('addCategoryButton'); ?></span></button>
					</div>
			</div>
		</p>

			<div class="clear"></div>
			
<?php echo form_close(); ?>
</div>
