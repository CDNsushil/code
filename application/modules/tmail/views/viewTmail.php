<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $loadView = (isset($loadView) && ($loadView!='')) ? $loadView : 'tmail_details' ;?>

	<div id="contactMeDiv">
		<?php 
		$this->load->view('tmail/'.$loadView,array('data'=>$data));?>
	</div>

<script type="text/javascript">
	
	
	
	
	function deletTmailPopup(){
        
       confirmBox("Are you sure you wish to delete?", function () {
             					 
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
                        //  $('#contactMeDiv').html(msg);	
                        } else{				
                           window.location.href= "<?php echo base_url().lang() ?>/tmail/";
                        }									
                    }
                });	
        
        });         
	}
	
		
	function acceptShowProjectRequest () {					
		var fromData=$("#viewTmailList").serialize();
		fromData = fromData+'&ajaxHit=1';
		$.post(baseUrl+language+'/showproject/acceptShowProjectRequest/',fromData, function(data) {
		  if(data){
                refreshPge();
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
			  refreshPge();
		   }
		});		
	}
	
	
	
	
</script>
