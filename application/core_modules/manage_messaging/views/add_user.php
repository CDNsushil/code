<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	
<div>
	<div class="row height_32"> 
		<div class="cell ml46 mt10">
			<div class="defaultP"> 
				<input type="checkbox" class="case1" name="selectall" id="selectall" value="0">
			</div>
		</div>
		<div class="cell ml10 mt10 b"><?php echo $this->lang->line('selectAll');?></div>
		<div class="clear"></div>
	</div>
		<div class="seprator_7"></div>
	
	<input type="hidden" id="userIds" name="userIds" value="">
	<div class="tab_shadow tab_shadow_g"> </div>
</div>
<div class="shadow_sep row"></div>
<div class="clear"></div>
<div class="row">
	<div id="showUsersList" class="cell mr12 pl10">
		<?php echo $this->load->view("add_user_view"); ?>
	</div>              
	<div class="clear"></div>         
</div>
			<!--from_element_wrapper-->
	
<script type="text/javascript">
$(document).ready(function(){	          
	runTimeCheckBox();   
	
	/* Select all Users */			
	$("#selectall").click(function () {	
		if($("#selectall").is(':checked')){
			$("#userMsgSlider").hide();
			$('.case').attr('checked', 'checked');
		}else{
			$("#userMsgSlider").show();
			$('.case').attr('checked', false);
		}			
		setValInTo();
	  });					
});	


/* Function to set user emails in to field*/
function setValInTo(){
	var BASEPATH = "<?php echo base_url();?>";
	var userVal = [];
	 $('.case:checkbox:checked').each(function(i){
			  userVal[i] = $(this).val();  
		});	
	$('#userIds').val(userVal);
	if(userVal==''){
		$('#toUser').val(userVal);
	}
	var form_data = {userIds: userVal};
	if(userVal!=''){
		$.ajax
		({
			type: "POST",
			url: BASEPATH+"admin/settings/manage_messaging/setEmails",
			data: form_data,
			success: function(data)
			{		
				$('#toUser').val(data);
			}
		});
		return false;
	}	
}

/* Function for slider */
$(document).ready(function(){
		if($('#userMsgSlider'))	
		$('#userMsgSlider').tinycarousel({ axis: 'y', display: 17, start:1});	
		
		if($('#AMslider'))	
		$('#AMslider').tinycarousel();	
	}); 

</script>
