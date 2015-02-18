<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$competitionGroupLimit = $this->config->item('competitionGroupLimit');
$fileMaxSize = $this->config->item('defaultContainerSize');
$lang=lang();
$browseId='_group';
$formAttributes = array(
	'name'=>'competitionGroupForm',
	'id'=>'competitionGroupForm'
);
$competitionGroupIdInput = array(
	'name'	=> 'competitionGroupId',
	'id'	=> 'competitionGroupId',
	'type'	=> 'hidden',
	'value'	=> '0'
);
$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'competitionGroupTitle',
	'class'	=> 'required width556px',
	'value'	=> ''
);
$browseIdInput = array(
	'name'	=> 'browseId',
	'value'	=> $browseId,
	'id'	=> 'browseId',
	'type'	=> 'hidden'
);
$ajaxHit = (isset($ajaxHit) && ($ajaxHit == 1))?1:0;
$countGroup = (isset($countGroup) && is_numeric($countGroup))?$countGroup:0;
$dn = ($countGroup >0)?'dn':'';
$isReloadPage=1;
if($ajaxHit == 1){	?>
	<div class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
	<div class="popup_gredient width808px">
		<div class="row " >
			<div class="popup_heading_small p15"><?php echo $this->lang->line('addCompetitionsGroup');?></div>
		</div>
		<div class="form_wrapper toggle frm_strip_bg " >
	<?php
	$isReloadPage=0;
	$dn='';
} ?>
			
			<div class="row <?php echo $dn;?>" id="competitionGroupFormDiv">	
				<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
				<div class="upload_media_left_box">
					<?php
					echo form_open($this->uri->uri_string(),$formAttributes); 
						echo form_input($competitionGroupIdInput);
						echo form_input($browseIdInput);
						
						/*$required='';
						$competitonImage='';
						$defaultcompetitonImage=$this->config->item('defaultcompetitonImage');
						$defaultImagePath = getImage($defaultcompetitonImage);
						$competitonThumbImage = addThumbFolder($competitonImage,'_s');	
						$imgsrc = getImage($competitonThumbImage,$defaultcompetitonImage);
						$data=array('typeOfFile'=>1, 'imgSrc'=>$imgsrc,'mediaFileTypes'=>$this->config->item('imageType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$dirUpload,'embedCode'=>'', 'required'=>$required, 'label'=>$this->lang->line('coverImage'),'editFlag'=>0,'fileTypeFlag'=>0,'flag'=>1,'browseId'=>$browseId,'imgload'=>1,'isReloadPage'=>$isReloadPage);
						$this->load->view("upload_form",$data);*/ ?>

						<div class="row">
							<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
							<div class="cell frm_element_wrapper" >
								<?php echo form_input($titleInput); ?>
							</div>
						</div>

						<?php 	
						$data=array('name'=>'onelineDescription','id'=>'onelineDescriptionLabel','value'=>'', 'required'=>'required', 'labelText'=>'oneLineDescription');
						$this->load->view("common/oneline_description",$data);

						$data=array('name'=>'tagwords','id'=>'tagwords','value'=>'','required'=>'required', 'labelText'=>'tagWords');
						$this->load->view("common/tag_words",$data);

						/*$data=array('name'=>'description','id'=>'description','value'=>'', 'required'=>'required', 'labelText'=>'description', 'wordOption'=>array('minVal'=>15,'maxVal'=>600));
						$this->load->view("common/description",$data);*/ ?>
						
						<div class="seprator_25 clear row"></div>
						
						<div class="row">
							<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
							<div class=" cell frm_element_wrapper">
								<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
								 <div class="tds-button Fright mr10"> <button name="saveGroup" value="saveGroup" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="submit"><span><div class="Fleft">Submit</div> <div class="icon-publish-btn"></div></span> </button> </div>
								<div class="tds-button Fright mr18"><button id="CGcancelButton" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="button"><span><div class="Fleft">Cancel</div> <div class="icon-cancel-btn-new"></div> </span> </button> </div>
								 <div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
							</div>
						</div>				
						<?php 
					echo form_close(); ?>
				</div>
				<div class="upload_media_left_bottom row"></div>
				<div class="seprator_25 clear row"></div>
			</div>
	
	<?php
if($ajaxHit == 1){	?>
		</div>
	</div>
	<?php
} ?>

<script>
	$(document).ready(function(){
		$("#CGcancelButton").click(function(){
			var browseId = '<?php echo $browseId;?>';
			var ajaxHit = '<?php echo $ajaxHit;?>';
			ajaxHit = parseInt(ajaxHit);
			if(ajaxHit==1){
				$(this).parent().trigger('close');
			}else{
				$('#competitionGroupForm')[0].reset();
				$('#competitionGroupForm form input[type=hidden]').val('');
				$('#browseId').val('<?php echo $browseId;?>');
				$('#galImg_'+browseId).attr('src','<?php echo $defaultImagePath;?>');
				$("#competitionGroupFormDiv").slideToggle('slow');
			}
		});
	
		$("#competitionGroupForm").validate({
			submitHandler: function() {
				var ajaxHit = '<?php echo $ajaxHit;?>';
				ajaxHit = parseInt(ajaxHit);
				var fromData=$("#competitionGroupForm").serialize();
				fromData = fromData+'&ajaxHit='+ajaxHit;
				var url = baseUrl+language+'/competition/competitionGroupSave';
				$.post(url,fromData, function(data) {
				  if(data){
					$("#uploadFileByJquery<?php echo $browseId;?>").click();
					if(data.saveMode == 'add'){
						var text = $('#competitionGroupTitle').attr('value');
						var defaultSelected = false;
						var nowSelected     = true;
						var competitionGroupLimit = '<?php echo $this->config->item('competitionGroupLimit');?>';
						competitionGroupLimit = parseInt(competitionGroupLimit);
						
						$('#competitionGroupIdSeleect').append( new Option(text,data.competitionGroupId,defaultSelected,nowSelected) );
						$('#competitionGroupIdSeleect').selectBoxJquery('value', data.competitionGroupId);	
					
						if(data.countGroup >= competitionGroupLimit){
							 $('#competitionGroupAddButton').remove();
						}
					}
					var fileName =  $("#fileName<?php echo $browseId?>").val();
					if(fileName == undefined){
						fileName = '';
					}
					
					
					if(fileName.length < 4 ){
						if(ajaxHit==1){
							$('#popupBoxWp').trigger('close');
							$('#popup_box').hide();
							$('#defaultLoader').remove();
						}else{
							refreshPge();
						}
					}
					
					$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
					timeout = setTimeout(hideDiv, 5000);
					
				  }
				},"json");
			}
		});
	});
</script>
