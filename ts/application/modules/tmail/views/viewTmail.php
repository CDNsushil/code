<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $loadView = (isset($loadView) && ($loadView!='')) ? $loadView : 'tmail_details' ;?>

	<div id="contactMeDiv">
		<?php 
		$this->load->view('tmail/'.$loadView,array('data'=>$data));?>
	</div>

<script type="text/javascript">
	function conformYesBox()
	{ 
		$("#YesBoxWp").lightbox_me('center:true');
	}
	function closeBox(){
		$('#YesBoxWp').trigger('close');	
	}
	function deleteMail(confirmflag){
		if(confirmflag=='t'){
		deletTmailPopup();
		$('#YesBoxWp').trigger('close');
		}
		else{
		$('#YesBoxWp').trigger('close');	
		}			
	}
	
	
	
	function deletTmailPopup(){ 					 
		var val = parseInt($('#currentRecordId').val());			
		var nextRecord =parseInt($('#nextRecordId').val());
		var type = ($('#viewType').val());		
		
		$.ajax
		({     
			type: "POST",
			url: "<?php echo base_url() ?>tmail/trashTmailPopupMessage/"+val+'/'+type+'/'+nextRecord,
			success: function(msg)
			{
				//$('#contactMeDiv').html(msg)
				window.location.href= "<?php echo base_url().lang() ?>/tmail/viewTmail/"+nextRecord+'/'+type;

				if(nextRecord!=0){ 														
				  $('#contactMeDiv').html(msg);	
				} else{				
				   window.location.href= "<?php echo base_url().lang() ?>/tmail/";
				}									
			}
		});	
		runTimeCheckBox();          
	}
	
		
	function acceptShowProjectRequest () {					
		var fromData=$("#viewTmailList").serialize();
		fromData = fromData+'&ajaxHit=1';
		$.post(baseUrl+language+'/showproject/acceptShowProjectRequest/',fromData, function(data) {
		  if(data){
			 // $('#contactMeDiv').html('<div class="p15"><?php echo $this->lang->line("acceptedRequest");?></div>');
			  $('#showProjectAccept').remove();
		  }else{
			alert("<?php echo $this->lang->line('sessionExpired');?>");  
		  }
		});		
	}		
	// END 
	
	
	function replayTmail () {
		$('#send_work_profile_not_sent').hide();
		$('#send_work_profile_sent').show();					
		var fromData=$("#viewTmailList").serialize();
		fromData = fromData+'&ajaxHit=1';
		$.post(baseUrl+language+'/tmail/replyrequestWP/',fromData, function(data) {
		  if(data){
			   
			   $('#messageSuccessError').html('<div class="successMsg"><?php echo "Work Profile Sent Successfully";?> </div>');
			   
		
			   timeout = setTimeout(hideDiv, 5000);
		  }
		});		
	}
	
	
	
	
</script>
