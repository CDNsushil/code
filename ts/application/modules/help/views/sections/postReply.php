<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	

<?php echo form_open('help/submit_post/', 'class="form" name="quickReply" id="customForm"');?>
<div class="page_list">
<ul class="page_list">
<li class="alt">
	
	



<!--<div class="avatar">
<?php 
    //echo '<img src="'.$this->users_m->gravatar($this->session->userdata('email'), "x", "45").'" title="'.$this->session->userdata('username').''.$this->lang->line('avatarTitle').'" height="45px" width="45px"/>';
?>
</div>-->
<div class="pb5"><textarea  name="comments_box" class="quickReplyBox pt30 mt-27 required clr_666_import" onblur="placeHoderHideShow(this,'Comment','show')" onclick="placeHoderHideShow(this,'Comment','hide')" value="Comment" placeholder="Comment" rows="10" style="width:95%"></textarea></div>

<?php
if(!$this->uri->segment(4) || !$this->uri->segment(5))
{
	echo form_hidden('CategoryID', $this->session->userdata('cat_id'));
	echo form_hidden('TopicID', $this->session->userdata('post_id'));
} 
else 
{
	echo form_hidden('CategoryID', $this->uri->segment(4));
	echo form_hidden('TopicID', $this->uri->segment(5));
}
?>

<?php 		echo '<li><div class="tds-button fr mb8"><button onclick="submitform();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value='.$this->lang->line('submitPostButton').' name="save"><span class="text-indent_0">'.$this->lang->line('submitPostButton').'</span></button></div>';
 ?>
<?php //echo form_submit('submit', $this->lang->line('submitPostButton'), 'class="btn" title="'.$this->lang->line('submitPostButton').'"'); ?>

</form>
</li>
</ul>
</div>
