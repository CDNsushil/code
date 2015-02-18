<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo '<div class="frm_heading_wp pb10"><div class="summery_right_archive_wrapper  absolute_heading  padding_0 "> <h1>'.$this->lang->line('headerEditPost').'</h1> </div></div>';
echo ' <div class="clear"></div><div class="edit_post_wp">'	;

echo form_open('forums/update_post/'.$commentID.'', 'class="form"'); 
?>

<div class="page_list">
<ul class="ul_relative">
   
  
    
    <li class="alt">
		
    	
    	<?php echo form_textarea($body); ?>
    	
    	
    </li>
    
    <li><?php echo $this->lang->line('hintPostText'); ?></li>
    
    <?php
    /*
    if($this->ion_auth->logged_in())
    {
    	if($this->ion_auth->is_admin())
    	{
    	echo '<li>
    		<div class="summery_right_archive_wrapper width_100_per padding_0 "> <h1>'.$this->lang->line('postReported').'</h1></div></li>
    	
    		<li>'.form_checkbox($reported).''.$this->lang->line('hintPostReported').'
    	</li>';
    	}
    } */
    ?>
    
    <?php 
    		echo '<li><div class="tds-button fr"><button onclick="submitform();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value="Save" name="save"><span class="text-indent_0">Update Post</span></button></div>';
    ?>
    
   <!--  <li class="alt">
    	<?php // echo form_submit($updatePost); ?>
        <div class="clear">&nbsp;</div>
    </li> -->
    
   
</ul>
</div>
</div><!--edit_post-->
<?php echo form_close(); ?>
