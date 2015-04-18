<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$lang=lang();
$browseId1='_image';

$formAttributes = array(
	'name'=>'collaborationForm',
	'id'=>'collaborationForm'
);
$collaborationIdInput = array(
	'name'	=> 'collaborationId',
	'id'	=> 'collaborationId',
	'type'	=> 'hidden',
	'value'	=> $collaborationId
);
$sectionIdInput = array(
	'name'	=> 'sectionId',
	'id'	=> 'sectionId',
	'type'	=> 'hidden',
	'value'	=> $sectionId
);
$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'title',
	'class'	=> 'required width556px',
	'value'	=> $collaborationData->title
);

$startDateInput = array(
	'name'	=> 'startDate',
	'id'	=> 'startDate',
	'class'       => 'date-input required width_196',
	'value'	=> !empty($collaborationData->startDate) ? dateFormatView($collaborationData->startDate,'d M Y') : '',
	'readonly' =>true
);

$endDateInput = array(
	'name'	=> 'endDate',
	'id'	=> 'endDate',
	'class'       => 'date-input required width_196',
	'title'       => 'End date must be after the start date.',
	'dategreaterthan'       => '#startDate',
	'value'	=> !empty($collaborationData->endDate) ? dateFormatView($collaborationData->endDate,'d M Y') : '',
	'readonly' =>true
);

$browseId1stInput = array(
	'name'	=> 'browseId1st',
	'value'	=> $browseId1,
	'id'	=> 'browseId1st',
	'type'	=> 'hidden'
);	

?>

<div class="row form_wrapper">
	
	<?php echo $header; ?>
	
	<div class="row position_relative">	
		<?php $this->load->view("common/strip");
		echo form_open($this->uri->uri_string(),$formAttributes);
		echo form_input($collaborationIdInput);
		echo form_input($sectionIdInput);
		echo form_input($browseId1stInput);
		?>
			 
			 <div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
				<div class="cell frm_element_wrapper" >
					<?php echo form_input($titleInput); ?>
				</div>
			 </div>
			
			<?php 
				$data=array('name'=>'tagwords','id'=>'tagwords','value'=>$collaborationData->tagwords,'required'=>'required', 'labelText'=>'tagWords');
				$this->load->view("common/tag_words",$data);
			
				$data=array('name'=>'shortDescription','id'=>'shortDescription','value'=>$collaborationData->shortDescription, 'required'=>'required', 'labelText'=>'oneLineDescription');
				$this->load->view("common/oneline_description",$data);
			?>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('collaboration');?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<div class="cell pt5 width_40">
						<?php echo $this->lang->line('start'); ?>
						
					</div>
					<div class="cell">
						<?php echo form_input($startDateInput); ?>
					</div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#startDate").focus();' /> </div>
					<div class="cell pl25 pt5 width_40">
						<?php echo $this->lang->line('end'); ?>
					</div>
					<div class="cell">
						<?php echo form_input($endDateInput); ?>
					</div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#endDate").focus();' /> </div>
				</div>
			</div>
			
			<div class="row" id="indusrtyIdDiv">
				 <div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('industry');?></label></div>
				 <div class="cell frm_element_wrapper">
						<div class="fl" id="indusrtyIdList">
							<?php 
								echo form_dropdown('industryId', $industryList, $collaborationData->industryId,'id="industryId" class="width_254 required" ');
							?>
						</div>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('language1');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							echo form_dropdown('langId1', $languageList, $collaborationData->langId1,'id="langId1" class="width_254 required NumGrtrZero" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('language2');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							echo form_dropdown('langId2', $languageList, $collaborationData->langId2,'id="langId2" class="width_254 required NumGrtrZero" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			</div>
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('country');?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							echo form_dropdown('countryId', $countryList, $collaborationData->countryId,'id="countryId" class="width_254 required NumGrtrZero" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			</div>
			
			<div class="seprator_15 clear row"></div>
			<?php
				if($collaborationId > 0){
					$required='';
				}else{
					$required='required';
				}
				$collaborationImage=$collaborationData->coverImage;
				$defaultcollaborationImage=$this->config->item('defaultcollaborationImage');
				$collaborationThumbImage = addThumbFolder($collaborationImage,'_s');	
				$imgsrc = getImage($collaborationThumbImage,$defaultcollaborationImage);
				
				$data=array('typeOfFile'=>1, 'imgSrc'=>$imgsrc,'mediaFileTypes'=>$this->config->item('imageType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$dirUpload,'embedCode'=>'', 'required'=>$required, 'label'=>$this->lang->line('coverImage'),'editFlag'=>0,'fileTypeFlag'=>0,'flag'=>1,'browseId'=>$browseId1,'imgload'=>1,'norefresh'=>0);
				$this->load->view("upload_form",$data);
			 ?>
			 <div class="seprator_15 clear row"></div>
			<div class="row"> 
				<div class="label_wrapper cell formTip bg_none">
					<!--<label></label>-->
				</div>
				<!--label_wrapper-->

				<div class="cell frm_element_wrapper">
					<div style="padding: 3px 0 0 2px;" class="cell">
						<div class="defaultP">
							<input type="checkbox" name="isEvent" id="isEvent" <?php if($collaborationData->isEvent=='t') echo 'checked'; ?> value="t">
						</div>
					</div>
					<div class="cell mt5">				
							Is your Collaboration Educational Material?			
					</div>
					<div style="padding: 3px 0 0 12px;" class="cell">
						<div class="defaultP">
							<input type="checkbox" name="isEducationalMaterial" id="isEducationalMaterial" <?php if($collaborationData->isEducationalMaterial=='t') echo 'checked'; ?> value="t">
						</div>
					</div>
					<div class="cell mt5">				
							Is your Collaboration an Event?			
					</div>
					
				</div>		
			</div>

			
			<div class="seprator_25 clear row"></div>
			<div class="row">
				<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class="cell frm_element_wrapper">
					<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
					 <?php
						if(isset($collaborationId) && !empty($collaborationId)){
							$button=array('save');
								
						}else{
							$button=array('save','cancelForm');
						}
						$this->load->view("common/button_collection",array('button'=>$button)); 
					 ?>
					 <div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
				</div>
			</div>
		<?php echo form_close(); ?>
		<div class="seprator_25 clear row"></div>
	</div>
</div>


<input type="hidden" name="relocateId" id="relocateId" value="<?php echo base_url(lang().'/collaboration/description/'.$collaborationId);?>" />

<script>
	$(document).ready(function(){
		$("#collaborationForm").validate({
			submitHandler: function() {
				var fromData=$("#collaborationForm").serialize();
				var url = baseUrl+language+'/collaboration/saveDescription';
					$.post(url,fromData, function(data) {
					  if(data){
						
						var collaborationId =  $("#collaborationId").val();
						collaborationId = parseInt(collaborationId);
						if(data.collaborationId && collaborationId == 0){
							$("#relocateId").val(baseUrl+language+'/collaboration/description/'+data.collaborationId);
							$("#fileUploadPath<?php echo $browseId1?>").val('<?php echo $dirMedia?>'+data.collaborationId);
						}
						var redirectUrl=$("#relocateId").val();
						$("#uploadFileByJquery<?php echo $browseId1?>").click();
						
						var fileName1 =  $("#fileName<?php echo $browseId1?>").val();
						if(fileName1 == undefined){
							fileName1 = '';
						}
						if(fileName1.length < 4 ){
							goTolink('',redirectUrl);
						}
					  }
					},"json");
			}
		});
		
	});
</script>
