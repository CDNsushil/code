<!-- Modal -->
<?php $data=getTermsCondition('15');?>
<div class="modal fade" id="term_condi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog LoginModal">
    <div class="modal-content">
      <div class="modal-header">
		 <!-- <i class="icon-print"></i> -->
		
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Terms & Condition</h4>
      </div>
      <?php echo form_open(base_url().'users/login'); ?>
      <div class="modal-body">
        	<div class="form-group" id="term_content">
				<?php echo $data;?>
				
            </div>
      </div>
     
      <div class="modal-footer ">
		  <div class="bottom_term">Terms & Condition  <div class="term_div"><a href="javascript:void(0)" title="print" ><div class="print_term"></div></a></div> </div>
         
      </div>
   <?php echo form_close(); ?>
    </div>
  </div>
</div>
 
<script type="text/javascript">
	$(document).ready(function(){
		$('.print_term').click(function(){
		
		 var printContents = document.getElementById('term_content').innerHTML;
		 w=window.open();
		 w.document.write(printContents);
		 w.print();
		 w.close();

		});
	});
	</script>
