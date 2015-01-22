<?php (defined('BASEPATH')) OR exit('No direct script access allowed');?>


<div class="frm_heading">
<h1><?php echo $this->lang->line('headingEditCategory'); ?></h1>
</div>

<div class="clear"></div>
<div class="content_box bdr_non">
	<div class="seprator_20"></div>

<?php echo form_open(lang().'/admin/categories/update/'.$categoryID.'', 'class="form"'); ?>


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
		
		
	      <p><div class="cell admin_label_width">
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
		//	echo form_checkbox($active);
			 ?>
		</p>
			
		<div class="seprator_20"></div>

<p class="clear">
 		   <div class="cell admin_label_width ">
				<div class="cell label_wrapper_topic" id="oneLineDescription">
					&nbsp;
				</div>
			 </div>
			 <div class="position_relative admin_select cell">
					<div class="tds-button">
					<button name="save" value="Save" type="submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" onclick="submitform();" >
						<span class="text-indent_0" style="background-position: right -38px;"><?php echo $this->lang->line('updateCategoryButton'); ?></span></button>
					</div>
			</div>
		</p>

			<div class="clear"></div>
			
<ul>
<!--     <li>
        <h3><?php echo $this->lang->line('headingCategorySettings'); ?></h3>
        <p><?php echo $this->lang->line('categoryName'); ?><br><?php echo form_input($name); ?>&nbsp;&nbsp;<cite>Enter Category Name.</cite></p>
        <p><?php echo $this->lang->line('categoryDescription'); ?><br><?php echo form_textarea($description); ?>&nbsp;&nbsp;<cite>Enter Category Description.</cite></p>
        <p><?php echo $this->lang->line('categoryActive'); ?><?php echo form_checkbox($active); ?>&nbsp;&nbsp;<cite>Is Category Active?.</cite></p>
    </li>
    -->
    <li>
        <?php // echo form_submit('submit', $this->lang->line('updateCategoryButton'));?>
    </li>
</ul>

<?php echo form_close(); ?>

</div>
