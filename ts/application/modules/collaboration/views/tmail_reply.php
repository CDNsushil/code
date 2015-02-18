<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
'name'=>'replyTmail',
'id'=>'replyTmail'
);

$composebody = array(
		'id'	=> 'body',
		'name'	=> 'body',
		'class'	=> 'width556px rz required ',
		'rows'  => 12,
		'cols'  => 50,
		'value' =>''
	);
	
$replyEmailId = (isset($replyEmailId) && $replyEmailId!='') ? $replyEmailId :'';	
	
$replyUserName = (isset($replyName) && $replyName!='') ? $replyName :'';	

$subject = (isset($subject) && ($subject!='')) ? $subject :'';	
$subject = array(
		'name'	=> 'subject',
		'id'	=> 'subject',	
		'class'	=> 'Bdr width_551 required',
		'value'	=> 'Re: '.$subject
	);		
?>

<script type="text/javascript">
	bkLib.onDomLoaded(function() {
		var myNicEditor = new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','hr','subscript','superscript','link','unlink']});
		//myNicEditor.panelInstance('replymsg');
		myNicEditor.setPanel('myNicPanel');  
        myNicEditor.addInstance('body');
	});
</script>

<div class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $this->lang->line('communications');?></h1>
		</div>		
	</div> <!--row-->
	<div class="clear"></div>
</div><!--row form_wrapper-->

<div class="row pt2 ">
	<div class="row ">
		<div class="cell tab_left width_202">
			<div class="tab_heading_global"><?php echo $this->lang->line('reply');?></div>
			<!--tab_heading-->
		</div>
		<div class="cell tab_right width_590">
			<div class="tds-button-inbox Fright mt5 mr10 btn_span_hover">
				<a href="<?php echo base_url(lang().'/collaboration/communications/'.$collaborationId) ?>" onmouseup="mouseout_inputtmail(this)" onmousedown="mouseup_inputtmail(this)"><span><?php echo $this->lang->line('comIndex');?>
				</span></a>
			</div>
		</div>
	</div>
	<!--row-->
	<div class="clear"></div>
	<div class="upload_media_left_top row mt10"></div>
	<div class="form_wrapper toggle pr5 upload_media_left_box">
		<div class="shadow_wp strip_absolute">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%">
				<tbody>
					<tr>
						<td height="271"><img src="<?php echo base_url('/images/shadow-top.png')?>"></td>
					</tr>
					<tr>
						<td class="shadow_mid">&nbsp;</td>
					</tr>
					<tr>
						<td height="271"><img src="<?php echo base_url('/images/shadow-bottom.png')?>"></td>
					</tr>
				</tbody>
			</table>
		</div> <!-- shadow_wp strip_absolute -->

		<div class="row">
			<div class="tab_shadow tab_shadow_g mt-16"> </div>
		</div>
		<div class="shadow_sep row"> </div>
		<div class="clear"></div>
		<!---<div class="seprator_10"> </div>-->

		<?php echo form_open(base_url(lang().'/collaboration'),$formAttributes); ?>
			<div class="width100percent">
				<input type="hidden" name="recipientsId" value="<?php echo $receiverid;?>" > 
				<div class="row width_791">
					<div class="label_wrapper_global cell">
						<label class="select_field_g">To</label>
					</div>
					<!--label_wrapper-->
					<div class=" cell frm_element_wrapper pl24">             
						<?php //echo form_input($receiverMail);  ?>
						<div class="disable_div"> <?php echo $replyrName ?> </div>
						<div class="mt3 ">
							<?php //echo $this->lang->line('sendReplayMessage'); ?>
						</div>	             
					</div>
				</div>
          
				<div class="row width_791">
					<div class="label_wrapper_global cell">
						<label class="select_field_g"><?php echo $this->lang->line('subject');?></label>
					</div>
					<!--label_wrapper-->
					<div class=" cell frm_element_wrapper pl24">
						<?php echo form_input($subject); ?>
					</div>
				</div>
				<div class="row width_791">
					<div class="label_wrapper_global cell">
						<label class="select_field_g"><?php echo $this->lang->line('compose');?></label>
					</div>
					<!--label_wrapper-->
					<div class=" cell frm_element_wrapper pl24">
						<div id="myNicPanel" class="width527px bdr_e2e2e2 tmailtop_gradient p15"></div>
						<div id="myInstance1" class="NIC">
							<?php echo form_textarea($composebody); ?>
						</div>
						<div id="replErrorMsg"></div>	
					</div> 
				</div>
          
				<div class="row">
					<div class="label_wrapper cell bg-non"> </div>
					<!--label_wrapper-->
					<div class=" cell frm_element_wrapper pl25" style="width:200px">
						<div class="Req_fld mr30 font_arial font_size11 clr_676767 mt10"><?php echo $this->lang->line('requiredFields');?></div> 
					</div>
				</div>             
				<div class="tds-button fr mt15 mb10 mr18">
					<button type="button"  id="cancel"  onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" style="background-position: 0px -38px;" class="dash_link_hover">
						<span style="background-position: right -38px;">
							<div class="Fleft"><?php echo $this->lang->line('cancel');?></div>
							<div class="cancel_button"></div>
						</span>
					</button>
              
					<button type="save"  id="checkSave" type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover">
						<span>
							<div class="Fleft"><?php echo $this->lang->line('send');?></div>
							<div class="send_button"></div>
						</span>
					</button>			  
				</div>
				<div class="clear"></div>
				<div class=" seprator_3 clear"></div>
			</div>        
    	<?php echo form_close(); ?>	
	</div> <!--tab_wp-->
	<div class="upload_media_left_bottom row"></div>
</div> <!--row pt2-->

<script>
function mouseout_inputtmail(obj){
	obj.style.backgroundPosition ='0px -0px';
	obj.firstChild.style.backgroundPosition ='right -0px';
}

function mouseup_inputtmail(obj){
	obj.style.backgroundPosition ='-0px -33px';
	obj.firstChild.style.backgroundPosition ='right -33px';
}

$(document).ready(function(){
	$('#checkSave').click(function() {
		$("#replyTmail").validate({			
			submitHandler: function() {						
				body=$('.nicEdit-main').html().replace(/^\s+|\s+$/g,"");					
				
				if(body.replace('<br>','')==''){
					$('#replErrorMsg').html('This is required field');
					$('#myInstance1').addClass('error_div_border');
					return false;
				}else{
					$('#replErrorMsg').html('');
					$('#myInstance1').removeClass('error_div_border');
				}
				var fromData=$("#replyTmail").serialize();	
				fromData = fromData+'&ajaxHit=1'+'&replymsg='+body+'&isAllMember=0';	      
				$.post(baseUrl+language+'/collaboration/sendCommunicationTmail',fromData, function(data) {
					if(data){
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);
						refreshPge();	        							
					}
				},"json");			
			}
		});
	});	
		
	$('#cancel').click(function() {			
		history.go(-1);			
	});	
}); 
</script>

