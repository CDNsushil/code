<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script language="javascript" type="text/javascript">

$('iframe').load(function() {
    this.style.height =    (this.contentWindow.document.body.offsetHeight+30) + 'px';
});



</script>
<div style="border:#FF0000 0px solid;">
<div id="iframe_container" style="border:#FF0000 0px solid; height:auto">
<iframe src="<?php echo $this->config->item('base_url'); ?>en/blog/userToShareSave?postId=<?php echo $postId;?>" frameborder="0" style="height:100%"></iframe>
</div><!-- End Div iframe_container-->
</div>