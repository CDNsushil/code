<!-- Modal to add product testimonial-->
<?php $bannerId=(!empty($banner_id))?$banner_id:''; ?>
<?php $productTesti=(!empty($testiData))?'1':'0'; ?>

<?php
		 
?>

<div class="modal fade" id="email_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="">

  <div class="modal-dialog LoginModal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Send Email To Friends</h4>
      </div>
      <?php echo form_open(base_url().'affiliate/affiliateProductEmail','id="email_form" name="email_form"'); ?>
      <div class="modal-body">
        	<div class="form-group">
				 <div class="add_loader"></div>
            	<div class="control-group">
                	<label><?php echo 'To'; ?><span>*</span></label>
						<input type="text" id="email_to" name="email_to" class="email_to" value="" autocomplete="off" required >
						<div class="email_append"></div>
               		<span class="error"></span>
                </div>
 
            </div>
      </div>
     
   
      <div class="modal-footer text-center">
		  <input type="hidden" name="banner_id" id="banner_id" value="<?php echo $bannerId; ?>">
		  <input type="hidden" name="product_testi" id="product_testi" value="<?php echo $productTesti; ?>">
		 
         <button type="submit" class="btn btn-primary col-xs-12" >Send Email</button>
      </div>
      
     
		<?php echo form_close(); ?>
    </div>
  </div>
</div>
	<?php 
		//get all gmail friends of affiliate
		$frnd_emails=(!empty($affi_frnd_emails))?$affi_frnd_emails:'';
	
		$frndEmails='';
		if(!empty($frnd_emails)){
			foreach($frnd_emails as $frnd){
				$frndEmails=$frndEmails.$frnd->contact_email.',';
			}
		}
		
	?>
	<input type="hidden" name="affi_frnd_emails" id="affi_frnd_emails" value='<?php echo json_encode($frndEmails);  ?>'>
	

 <script type="text/javascript">
	
	$(document).ready(function (){
	$('#email_form').submit(function (){
		
	var checkClass=$('.selectContact').hasClass('select_contact');
	if(checkClass){
		checkEmailValid($('.selectContact').text());
		return false;
	} 
	
	//to load loder
	$('.modal').css({ zIndex: 0 });
	$('.add_loader').css({ 'display': 'block' });
			
	var fromData=$("#email_form").serialize();
	var url = baseUrl+'affiliate/affiliateProductEmail';
		
		$.post(url,fromData, function(data) {
		  if(data){
			  $('.modal').css({ zIndex: 1050 });
			  $('.add_loader').css({ 'display': 'none' });
			  if(data.status=='success'){
					 $('#email_to').val('');
					$('#email_popup').modal('hide');
					 location.reload();
					 return true;
				}
				notificatinshow(data.msg,data.status)
			}
		},"json"); 
			return false; 
		}); 
		
		//search gmail contacts
		$(".email_to").keyup(function(e){
			if(e.which==38 || e.which==40){
				
				if(e.which==38){
					var selectId=$('.selectContact').attr('id');
					if($('#'+selectId).prev('li').hasClass('select_contact')){
						$('.select_contact').removeClass('selectContact');
						$('#'+selectId).prev('li').addClass('selectContact');
					}
					
				}else if(e.which==40){
					var selectId=$('.selectContact').attr('id');
					
					if($('#'+selectId).next('li').hasClass('select_contact')){
						$('.select_contact').removeClass('selectContact');
						$('#'+selectId).next('li').addClass('selectContact');
					}
				}
				return false;
			}
			
			var searchWord='';
			var appendEmail='<ul class="email_contact">';
			var to_email=$(this).val();
			var enterEmail=$("#email_to").val().split(",");
			var array = $('#affi_frnd_emails').val().split(',');
	
			$.each(enterEmail,function(j){
				searchWord=enterEmail[j];
			});
			if(searchWord!=''){
				var count=1;
				var selectContact='selectContact';
				$.each(array,function(i){
				
						array[i]=array[i].replace('"','');
						var str=array[i].substring(0, searchWord.length);
						if(searchWord==str){
							appendEmail += '<li class="select_contact '+selectContact+'" id="emailSelect'+count+'">'+array[i]+'</li>';  
							count=parseInt(count)+1;
							selectContact='';
						}
				});
			}
			appendEmail+='</ul>';
		
			$('.email_append').html(appendEmail);
			return false;
		});
		
	$( document ).delegate( "li.select_contact", "click", function() {
		var email=$(this).text();
		checkEmailValid(email);
		
		});
		
		function checkEmailValid(email){
			
			var email_to=$('#email_to').val();
			var newEmail='';
			var list = email_to.split(",");
			for(i=0; i<list.length; i++){
				var validEmail=list[i];
				var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
				if (re.test(validEmail)) {
					newEmail=newEmail+validEmail+',';
				}	
			}
				if(email!=''){
					newEmail=newEmail+email+',';
				}
			$('#email_to').val(newEmail);
			$('.email_append').html('');
			$('#email_to').focus();
		}
	});
</script>
   


 

 
  



