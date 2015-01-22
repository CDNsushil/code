<!-- Modal -->
<?php
	$preview_img=(isset($previewImg))?$previewImg:'';
?>
<div class="modal fade" id="banner_preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
		 <!-- <i class="icon-print"></i> -->
		
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title banner_term" id="myModalLabel">Banner Preview</h4>
      </div>
      <?php echo form_open(base_url().'users/login'); ?>
      <div class="modal-body">
       <div class="form-group" id="term_content">
			<div id="previw_content">
			<?php echo $preview_img; ?>
			</div>
         </div>
      </div>
     
      <div class="modal-footer ">
		  <div class="banner_term">Banner Preview </div>
         
      </div>
   <?php echo form_close(); ?>
    </div>
  </div>
</div>
 

