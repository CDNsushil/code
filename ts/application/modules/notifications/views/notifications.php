<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
//print_r($section_craved_list);
$selectSection = end($this->uri->segment_array());
$selectSection =  (!isset($selectSection) || ($selectSection=='index'))?'all':$selectSection;

?>
<div id="mainContent">
<div id="YesNoBoxWp" class="customAlert" style="display:none; width:260px;">
				
	<div class="row">
		<div class="cell mb20"><?php echo $this->lang->line('deletMsgAlert'); ?></div> 
	</div>
	<div class="row">
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>Yes</span>',array('onclick'=>'deleteMessageNotification(\'t\');','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>No</span>',array('onclick'=>"$(this).parent().trigger('close');",'onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
	</div>
</div>   


<div class="row form_wrapper">
    <div class="row">
      <div class="cell frm_heading">
        <h1>Notifications</h1>
      </div>
      <div class="cell frm_element_wrapper width_577 pl16 pt0"> 
		<div class="tds-button-big Fright">
			<a href="<?php echo base_url(); ?>messagecenter/contacts" onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)"><span>Contacts</span></a>
		</div>

		<div class="tds-button-big Fright"> 
		<a href="<?php echo base_url(); ?>tmail" onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)"><span>Tmail</span></a>  
		</div>
		
		<div class="row line1 mr3" style="width: 100% !important;"></div>                                        
	   </div>
		<div class="cell shadow_wp strip_absolute "><!-- <img src="images/strip_blog.png"  border="0"/>-->
		<table height="850px" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td height="271">	<img src="<?php echo base_url(); ?>images/shadow-top.png"></td>
			</tr>
			<tr>
				<td class="shadow_mid">&nbsp;</td>
			</tr>
			<tr>
				<td height="271"><img src="<?php echo base_url(); ?>images/shadow-bottom.png"></td>
			</tr>
		</tbody>
		</table>
		<div class="clear"></div>
		</div>
    </div>
  
    <div class="row position_relative">
		<div class="cell width_200">
			<div class="notification_menu">
				
				<ul>
					<?php 
					
					$listNotificationData['selectSection']=$selectSection;
					
					echo $this->load->view('list_notification_type',$listNotificationData); 
					
					?>				
				</ul>
				
			</div><!--cat_wrapper-->
		</div><!--width_200-->
    
  
    		<?php if(!empty($section_craved_list)){ ?>
    		<div class="cell width_582 pl13">
    		<div class="row seprator_3"></div>
    		<div id="showNotification"> 
    		<?php 
				$listNotification['selectSection'] = $selectSection;
				$listNotification['section_craved_list'] = $section_craved_list;
				echo $this->load->view('list_notification',$listNotification);  
    		?>
		    </div>		
		  
          	<div class="row">	
				<div class="tds-button fr">            
					<button id="DelTmail" onclick="showYesNo();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Cancel" name="cancel" type="button" class="dash_link_hover"><span><div class="Fleft">Delete</div> <div class="icon-form-delete-btn"></div></span></button>
				</div>
				<div id="selectall" class="tds-button Fright mr9"> 
					<button type="button"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft">Select All</div> <div class="icon-save-btn"></div> </span> </button>  
				</div>
			  
				<div class="clear"></div>
			</div><!-- row --> 	
	</div><!-- cell width_582 pl13 -->
      	<?php } //If
			else{
			?>
			<div class="cell width500px ">
				<div class="row">
				
				<div class="cell frm_element_wrapper right8">
					<div class="nocravebg nocravbg_commonshedow"> 
						<div class="nocravebg_inner">
							<div class="font_opensansSBold font_size24 clr_f1592a bdrB_878688 width_267 mt22 ml160">
								<?php echo $this->lang->line('noNotificationFound'); ?>
							</div>
						</div>
						<div class="nocravebg_btm"></div>
					</div>
				</div>
			  </div>
			</div>
			
			<?php	
			}
      ?>
     
	
	<div class="clear"></div>
  </div> <!-- position_relative -->
  <div class="clear"></div>
</div>	
	
			

</div>   <!-- div maincontent -->     
<script type="text/javascript">
 
$(document).ready(function(){
	selectBox();             		          
	runTimeCheckBox();   
				
	$("#selectall").click(function () {						
	  $('.case').attr('checked', 'checked');
		runTimeCheckBox(); 
	  });	 				
					
});					
					
function showYesNo()
{ 
	var n = $("input:checked").length;
	
	if(n>0){
		$("#YesNoBoxWp").lightbox_me('center:true');
	}else{
		alert('<?php echo $this->lang->line('checkMsgAlert') ?>');
		return false;
	}
}
function deleteMessageNotification(confirmflag){
	
	if(confirmflag=='t'){
		deleteNotification();
		$(this).parent().trigger('close');
		
	}
	else{
		$('#YesNoBoxWp').trigger('close');	
	}			
}

function deleteNotification(){  	
	            
	var fromData='';					
	var val = [];
	var section = '<?php echo $selectSection?>';
	
	$(':checkbox:checked').each(function(i){
		  val[i] = $(this).val();						  
	});		
	
	fromData = fromData+'&ajaxHit=1&delItems='+val+'&section='+section;
	
	$.post(baseUrl+language+'/notifications/trashNotificationMessage/',fromData, function(data) {
		if(data){
			$('#YesNoBoxWp').trigger('close');																
			$('#mainContent').html(data);
		
			$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('recordDeleted');?> </div>');
			timeout = setTimeout(hideDiv, 5000);
		}
	});	
	runTimeCheckBox();   
}
// END 
	  	

</script>
