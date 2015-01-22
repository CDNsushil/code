<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$fileMaxSize = $this->config->item('defaultContainerSize');
$lang=lang();
$formAttributes = array(
	'name'=>'competetionPrize',
	'id'=>'competetionPrize'
);
$competitionIdInput = array(
	'name'	=> 'competitionId',
	'id'	=> 'competitionId',
	'type'	=> 'hidden',
	'value'	=> $competitionId
);
$titleInput = array(
	'name'	=> 'title',
	'id'	=> 'title',
	'class'	=> 'required width556px',
	'value'	=> ''
);
$spacificationsInput = array(
	'name'	=> 'spacifications',
	'id'	=> 'spacifications',
	'class'	=> 'required width556px',
	'value'	=> ''
);


$prize = array(
	'name'	=> 'prize',
	'id'	=> 'prize',
	'value'	=> '',
	'class' => 'required number width_100',
	
);
$getCompetitionData=getDataFromTabel($table='Competition', $field='isPublished',  array('competitionId'=>$competitionId,'isBlocked'=>'f','isArchive'=>'f'), $whereValue='', $orderBy='competitionId', $order='DESC', 1, $offset=0, $resultInArray=false  );		
$isPublished = 'f';
if(!empty($getCompetitionData))
{
	$getCompetitionData = $getCompetitionData[0];
	$isPublished  = $getCompetitionData->isPublished;
}
?>

<div class="row form_wrapper" >
	
	<?php echo $header; ?>
	
	<div class="row position_relative" >	
		
		<?php $this->load->view("common/strip");?>
	<div class="seprator_5 clear row"></div>	
	<div class="row" id="competitionPrizeForm">	
		<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
		<div class="upload_media_left_box">
			<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
				<input type="hidden" name="isEdit" id="isEdit" value="0">
				<input type="hidden" name="compPrizeId" id="compPrizeId" value="0">
				<input type="hidden" name="userName" id="userName" value="<?php echo $userName ?>">
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
			
				$data=array('name'=>'description','id'=>'description','value'=>'', 'required'=>'', 'labelText'=>'description', 'wordOption'=>array('minVal'=>15,'maxVal'=>600));
				$this->load->view("common/description",$data); ?>
				


			<div class="seprator_15 clear"></div>



	 

		   <?php				
				if($competitionId > 0){
						$required='';
					}else{
						$required='required';
					}
					$competitonImage='';
					$defaultcompetitonImage=$this->config->item('defaultcompetitonImage');
					$competitonThumbImage = addThumbFolder($competitonImage,'_s');	
					$imgsrc = getImage($competitonThumbImage,$defaultcompetitonImage);
					
					if($currentLang !='language2'){
						$data=array('typeOfFile'=>1, 'imgSrc'=>$imgsrc,'mediaFileTypes'=>$this->config->item('imageType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$dirUpload,'embedCode'=>'', 'required'=>$required, 'label'=>$this->lang->line('image'),'editFlag'=>0,'fileTypeFlag'=>0,'flag'=>1,'browseId'=>'','imgload'=>1,'norefresh'=>0);
						$this->load->view("common/upload_ws_frm",$data);
					}
				 ?>


			
			<div class="seprator_25 clear row"></div>
				<div class="row">
					<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
					<div class=" cell frm_element_wrapper">
						<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
						 <?php
							echo form_input($competitionIdInput);
							if(isset($competitionId) && !empty($competitionId)){
								$button=array('save','cancelForm');
							}else{
								$button=array('save','cancelForm');
							}
							$this->load->view("common/button_collection",array('button'=>$button)); 
						 ?>
						 <div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
					</div>
				</div>
		
		 
		
			<input type="hidden" name="prizeOrder" id="prizeOrder" value=""/>
			<?php echo form_close(); ?>
		</div>
		<div class="upload_media_left_bottom row"></div>
		<div class="seprator_25 clear row"></div>
	
	</div>
		
	

<?php

$data['prizeData'] = $prizeData;
$data['userName'] = $userName;

 ?>

<div id ="competitionPrizeListing">

  <?php $this->load->view('prize_list',$data); ?> 

</div>

</div>
</div>
<div class="seprator_15 clear row"></div>
<?php 
	
	$isEditBlock=false;
	if(isset($competitionId) && !empty($competitionId)){
		// if competition is published then can't be edit
		if(isCompetitionPublished($competitionId)){
			$isEditBlock=true;
		}	
	}	

?>

<script type="text/javascript">
// Assign varibale for checking competition isPublished
var isPublished = '<?php echo $isPublished; ?>';	

function editVal(data,orderValue){

// checking competition isPublished or not
/*if(isPublished=='t') {
	customAlert('You can\'t edit this prize because competition have been published.');
	return false;
}*/	
	
$('#competitionPrizeForm').show();
$('#short_strip').hide();
$('#long_strip').show();
 //$('#competitionPrizeForm').removeClass('dn');	
 
 $('label.error').remove();
			
	$('input.error').each(function(index){
			var inputClass =$(this).attr('class').replace('error', '');
			$(this).attr('class',inputClass);
	});
	$('textarea.error').each(function(index){
			var inputClass =$(this).attr('class').replace('error', '');
			$(this).attr('class',inputClass);
	});
	
	//$('#fileError').html('');
 
 
 
 var userName = $('#userName').val();
	
	
	if($('#competitionId') )
		$('#competitionId').val(data.competitionId);
		
	if($('#title'))
		$('#title').val(data.title);
	
	if($('#tagwords'))
		$('#tagwords').val(data.tagwords);
		
	if($('#onelineDescription'))
		$('#onelineDescription').val(data.onelineDescription);
		
	if($('#description'))
		$('#description').val(data.description);
		
		
	if($('#prize'))
		$('#prize').val(data.prize);
		
		
		
	if($('#galImg_'))
		$('#galImg_').attr('src',data.image);	
			
	
		
	if($('#compPrizeId'))
		$('#compPrizeId').val(data.compPrizeId);	
		
		
	if($('#isEdit'))
		$('#isEdit').val('1');	
		
	$('#prizeOrder').val(orderValue);	
	
	$('#currency_'+data.currency).attr("checked", true);
	runTimeCheckBox();	
	
	$('#distributionType_'+data.distributionType).attr("checked", true);
	runTimeCheckBox();	
		
	
}	
	

	
function addVal(competitionId,orderValue){
	
	// checking competition isPublished or not
	/*if(isPublished=='t') {
		customAlert('You can\'t add new prize because competition have been published.');
		return false;
	}*/
	
	//$('#competitionPrizeForm').removeClass('dn');
	$('#short_strip').hide();
	$('#long_strip').show();
	$('#competitionPrizeForm').show();
	
	if($('#competitionId') )
		$('#competitionId').val(competitionId);
		
	if($('#title'))
		$('#title').val('');
	
	if($('#tagwords'))
		$('#tagwords').val('');
		
	if($('#onelineDescription'))
		$('#onelineDescription').val('');
		
	if($('#description'))
		$('#description').val('');
		
		
	if($('#prize'))
		$('#prize').val('');
		
	
	if($('#fileName'))
		$('#fileName').val('');
		
	if($('#fileInput'))
		$('#fileInput').val('');	
		
		

	if($('#galImg_'))
		$('#galImg_').attr('src',baseUrl+'images/default_thumb/comptition.jpg');	
		
	
	if($('#compPrizeId'))
		$('#compPrizeId').val('0');	
		
		
	if($('#isEdit'))
		$('#isEdit').val('0');	
		
	
	$('#currency_0').attr("checked", true);
	runTimeCheckBox();	
	
	$('#distributionType_3').attr("checked", true);
	runTimeCheckBox();
	
	$('#prizeOrder').val(orderValue);
		
}		


 function deletcompetitionPrize(competitionPrizeId,competitionId){	 	

		// checking competition isPublished or not
		<?php if($isEditBlock) { ?>
			customAlert('<?php echo $this->lang->line('cannotDeleteCompMsgPrize'); ?>');
			return false;
		<?php } ?>
		
		var isConfirm = confirm("Are you sure you really want to delete!")		
		
		if(isConfirm)
		{
			$.ajax
				({     
					type: "POST",
					url: "<?php echo base_url() ?>competition/deleteCompetition/"+competitionPrizeId+'/'+competitionId,
																
					success: function(msg){ 			
						  $('#rowPrize'+competitionPrizeId).remove();						
						  $('#competitionPrizeListing').html(msg);	
						  $('#competitionPrizeForm').hide();										
					}
			  });	
		}  					  
	} 


function calcelForm(){
	
	$('#short_strip').show();
	$('#long_strip').hide();
	var formId = '#competetionPrize';
	$(formId)[0].reset();
	//$(formId+' input[type=hidden]').val('');	 
	$('#competitionPrizeForm').hide();
//	$('#competitionPrizeForm').addClass('dn');
	
		
	}


$(document).ready(function(){
	
 $('#competitionPrizeForm').hide();	
	
 $("#competetionPrize").validate({

		submitHandler: function() {					

			var fromData=$("#competetionPrize").serialize();
		<?php if($isEditBlock) { ?>
			customAlert('<?php echo $this->lang->line('cannotEditCompMsgPrize'); ?>');
			return false;
		<?php }else{ ?>
			$.post(baseUrl+language+'/competition/prizes/language1/<?php echo $competitionId;?>',fromData, function(data) {
				if(data){	
					$("#uploadFileByJquery").click();	
					$('#competitionPrizeListing').html(data);
					var fileName1 =  $("#fileName").val();
						if(!fileName1){
							fileName1 = '';
						}
						if(fileName1.length < 4){
							refreshPge();
						}
				}

			});
		<?php } ?>	
			
		}
	});

 });

</script>
