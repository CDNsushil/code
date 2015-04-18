<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    //-----form start--------//
    echo form_open('forums/submit_post/', 'class="form" name="quickReply" id="customForm"');

?>

<div class="comment_form bdrcece bdrcece ">
   <textarea class="height171 p15 width100_per bdr_non bb_none   color_444 fs13 required" type="text"  name="comments_box" value="" placeholder="Add a Comment to this discussion"></textarea>

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

<div class="btn_wrap  pt20 pb20 bt_none bb_none clearbox">
   <button class="red fr bg_fff mr15" type="submit">Post</button>
</div>

</div>




</form>

<script type="text/javascript">
	 $(document).ready(function() {
        // validate the comment form when it is submitted
	   $("#customForm").validate({ });
	 });  
</script>
