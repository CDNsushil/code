<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$competitionGroupLimit = $this->config->item('competitionGroupLimit');
$browseId='_group';
$defCoverImage=$this->config->item('defaultcompetitonImg73X110');
$defaultImagePath = getImage($defCoverImage);
if(isset($CompetitionGroupsData) && is_array($CompetitionGroupsData) && count($CompetitionGroupsData)>0){
	foreach($CompetitionGroupsData as $k=>$data){ 
		if(($data->coverImage) && !empty($data->coverImage) ){
			$mainCoverImage = $data->coverImage;
		}
		else{
			$mainCoverImage = '';
		}
		$coverImage='';
		
		$coverImage = addThumbFolder($mainCoverImage,$suffix='_xxs',$thumbFolder ='thumb',$defCoverImage);	
		$coverImage = getImage($coverImage,$defCoverImage);
		$data->coverImage=$coverImage;
		$jsonData=json_encode($data);
		?>
		<script>var dataCG<?php echo $data->competitionGroupId;?> = <?php echo $jsonData;?>;</script>
		
		<div class="row" id="CG<?php echo $data->competitionGroupId;?>">
			<div class="label_wrapper cell"><div class="labeldiv"><span>Group <?php echo ($k+1);?> </span></div></div>									 
			<div id="CGData<?php echo $data->competitionGroupId;?>" class="cell frm_element_wrapper extract_content_bg">
				<!--extract_img_wp-->
				<?php /*<div class="extract_img_wp"> 
					<img class="formTip ptr maxWH30 ma" src="<?php echo $coverImage;?>"  title="<?php echo $data->title; ?>"  />
				</div> */?>
				<!--extract_heading_box-->
				<div class="extract_heading_box"> <?php  echo  getSubString($data->title,50); ?> </div>
				
				<!--extract_button_box-->
				<div class="extract_button_box">
					<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteTabelRow('CompetitionGroup','competitionGroupId','<?php echo $data->competitionGroupId;?>','','','','#CG','','','',1,'<?php echo $this->lang->line('confirmMsgDelGroup');?>')" ><div class="cat_smll_plus_icon"></div></a></div>
					<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCG(dataCG<?php echo $data->competitionGroupId;?>,'#competitionGroupFormDiv');" href="javascript:void(0)"><div class="cat_smll_edit_icon"></div></a></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
		<?php
	}
}?>
<script>
	function fillFormValueCG(data,formId){ 
		var browseId = '<?php echo $browseId;?>';
		if(!$(formId).is(":visible")){
				$(formId).slideToggle('slow');
		}
		if(data == '0'){
			$(formId+' form')[0].reset();
			$(formId+' form input[type=hidden]').val('');
			$('#galImg_'+browseId).attr('src','<?php echo $defaultImagePath;?>');
		}else{
			$.each(data, function(key, value){
			  if($(formId+' form [name=' + key + ']') !='undefind'){
				  $(formId+' form [name=' + key + ']').val(value);
			  }
			});
			if(data.coverImage != 'undefind'){
				$('#galImg_'+browseId).attr('src',data.coverImage);
			}
		}
		$('#browseId').val(browseId);
	}
</script>
