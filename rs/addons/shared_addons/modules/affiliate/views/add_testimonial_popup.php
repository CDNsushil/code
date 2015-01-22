<!-- Modal to add product testimonial-->
<?php $title=(!empty($testiData))?$testiData[0]->title:''; ?>
<?php $description=(!empty($testiData))?$testiData[0]->description:''; ?>
<?php $bannerId=(!empty($banner_id))?$banner_id:''; ?>
<div class="modal fade" id="add_product_testi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog LoginModal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Product Testimonial</h4>
      </div>
      <?php echo form_open(base_url().'affiliate/addProductTestimonial','id=""'); ?>
      <div class="modal-body">
        	<div class="form-group">
            	<div class="control-group">
                	<label><?php echo lang('global:title') ?><span>*</span></label>
               		<input type="text" name="title" id="title" required maxlength="250" class="" placeholder="Title" value="<?php echo $title; ?>">
               		<span class="error"></span>
                </div>
                <div class="control-group">
                	<label class="pull-left"><?php echo lang('global:description') ?><span>*</span></label>
                     
               		<textarea rows="5" name="description"  required placeholder="Description" ><?php echo $description; ?></textarea>
                </div>
             
            </div>
      </div>
     
      <div class="modal-footer text-center">
		  <input type="hidden" name="banner_id" id="banner_id" value="<?php echo $bannerId; ?>">
		 
         <button type="submit" class="btn btn-primary col-xs-12" >Save</button>
      </div>
   <?php echo form_close(); ?>
    </div>
  </div>
</div>
 
 <script type="text/javascript">
	$(document).ready(function (){
	$('#testimonial_form').submit(function (){
		var fromData=$("#testimonial_form").serialize();
		var url = baseUrl+'affiliate/addProductTestimonial';
	 
		$.post(url,fromData, function(data) {
		  if(data){
			  $('#add_product_testi').modal('hide');
			   notificatinshow(data.msg,data.status)
			}
		},"json");
	
		return false; 
		});
	}); 
	</script>
 
