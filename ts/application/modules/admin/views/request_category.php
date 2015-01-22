<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo '<div class="frm_heading_wp"><div class="summery_right_archive_wrapper  absolute_heading  padding_0 "> <h1>Request Category</h1> </div></div>';
echo ' <div class="clear"></div><div class="edit_post_wp">';

echo form_open('admin/udpdate_request/', 'class="form"'); 
?>

<div class="page_list">
<ul class="ul_relative">
   
	<div id="oneLineDescription" class=" label_wrapper_topic">
		<label class="select_field_topic">Category Name</label>
	</div>
	
    <li class="alt">
    	<?php echo form_input($title); ?>
    </li>
    

 <div id="oneLineDescription" class=" label_wrapper_topic">
	 	 	<label class="select_field_topic">Message</label>
	</div>
	
    <li class="alt">
    	<?php echo form_textarea($body); ?>
    </li>
    

    <?php 
 	echo '<li></li><div class="tds-button fr"><button onclick="submitform();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value="Save" name="save"><span class="text-indent_0">Confirm</span></button></div>';
    ?>
    
   <input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id;?>">
</ul>
</div>
</div><!--edit_post-->
<?php echo form_close(); ?>

