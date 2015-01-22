<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
	$(document).ready(function(){	
		$("#newsForm").validate({});
		$('#newspublishDate').datepicker({dateFormat:'d MM yy'});	
	});
	
</script>
<?php
$newsFormAttributes = array(
	'name'=>'newsForm',
	'id'=>'newsForm',
	'toggleDivForm'=>'NEWSForm-Content-Box',
	'section'=>'#news'
);

$externalUrl = array(
	'name'	=> 'externalUrl',
	'id'	=> 'newsexternalUrl',
	'class'	=> 'width548px required url',
	'value'	=> set_value('externalUrl')
	//'placeholder'	=> 'Add external url here'
);


$title = array(
	'name'	=> 'title',
	'id'	=> 'newstitle',
	'class'	=> 'width548px  required',
	'value'	=> set_value('newsTitle'),
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$writerName = array(
	'name'	=> 'writerName',
	'id'	=> 'newswriterName',
	'class'	=> 'width548px required',
	'value'	=> set_value('writerName'),	
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$currentDate = array(
	'name'	=> 'currentDate',
	'id'	=> 'currentDate',	
	'value'	=> date('Y-m-d'),	
	'type' =>'hidden'
);

$publishDate = array(
	'name'	=> 'publishDate',
	'id'	=> 'newspublishDate',
	'class'	=> 'width246px',	
	'title' =>'Publish date must be greater than/equal to Current date',
	'value'	=> '',
	'readonly'=>true
);

$newsEmbbededVideo = array(
	'name'	=> 'newsEmbbededVideo',
	'id'	=> 'newsEmbbededVideo',
	'value'	=> set_value('newsEmbbededVideo'),//,set_value('workOneLineDesc',$workOffered['workOneLineDesc']);	
	'rows'      => 2,
    'cols'      => 45,
	'class'       => 'width548px rz required embededURL'
);

?>
<script type="text/javascript">
/* 
$(function(){
	var pickerOpts = {
		dateFormat:"d MM yy"
	};	
	$("#newspublishDate").datepicker(pickerOpts);
	
	
	
}); */
  
   
  
</script>


<!--
	<div class="row">
		<div class="label_wrapper cell"><div class="lable_heading"><h1><span id="newsHeading"><?php echo $label['add'];?></span> <?php echo $label['NEWS'];?></h1></div></div>
		<div class="small_frm_wp" >                        
			<div class=" cell frm_element_wrapper inner_heading">
				<a href="javascript:void(0);" class="Fright orange_color mr5" onclick="openLightBox('loginLightBoxWp','loginFormContainer','/additionalInfo/searchAdditionalInfo','news','AddInfoNews','newsTitle')"><?php echo $label['searchOnToadsquare'];?></a>
			</div>
		</div>
	</div>
-->

<div class="dn" id="uploadElementForm" style="display: block;">
<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
<?php echo form_open('additionalInfo/saveAddInfoNews',$newsFormAttributes); ?>
<div class="upload_media_left_box">
	<input type="hidden" value="0" name="newsId" id="newsId" />
	<input type="hidden" value="<?php echo $entityId;?>" name="entityId" id="entityId" />
	<input type="hidden" value="<?php echo $elementId;?>" name="elementId" id="elementId" />
	<input type="hidden" value="<?php echo $returnUrl;?>" name="returnUrl" id="returnUrl" />
	
	<div class="row">
		<div class="label_wrapper cell"><label class="select_field"><?php echo $label['title'];?></label></div>
		<div class="cell frm_element_wrapper" >
			<?php echo form_input($title); ?>
			<div class="row wordcounter"><?php echo form_error($title['name']); ?></div>
		</div>
	</div>
	
	<div class="row">
		<div class="label_wrapper cell"><label class="select_field"><?php echo $label['authorName'];?></label></div>
		<div class="cell frm_element_wrapper" >
			<?php echo form_input($writerName); ?>
			<div class="row wordcounter"><?php echo form_error($writerName['name']); ?></div>
		</div>
		
	</div>
	
	<?php 
		$value=set_value('description');
		$value=htmlentities($value);
		$wordOption=array('minVal'=>0,'maxVal'=>50,'wordLabel'=>$this->lang->line('words0-50'));
		$data=array('name'=>'newsDescription','id'=>'newsDescription','value'=>$value, 'labelText'=>'description', 'required'=>'', 'descLimit'=>'newsDescLimit', 'view'=>'description','addclass'=>'width548px','wordOption'=>$wordOption);
		echo Modules::run("common/formInputField",$data);
	?>
	<div class="seprator_25 clear row"></div>
	<div class="row">
		<div class="label_wrapper cell bg-non">&nbsp;</div>
		<div id="selectFileTypeDiv" class="cell frm_element_wrapper fl" >
			<div id="selectFileTypeDiv" class="fl">
					<?php
						$NSST1=$NSST2=$NSST3='';
						$NSSTD1=$NSSTD2=$NSSTD3='dn';
						$urlType=isset($urlType)?$urlType:1;
						if($urlType==2){
							$NSST2='checked';
							$NSSTD2='';
						}elseif($urlType==3){
							$NSST3='checked';
							$NSSTD3='';
						}else{
							$NSST1='checked';
							$NSSTD1='';
						}
					?>
					<div class="cell defaultP" >
					  <input id="newsURLts" type="radio" name="newsUrlType"  class="#newsSelectSearchType" value="1" <?php echo $NSST1;?> onclick="selectSearchType('#news','#newsSearchOnToadsquareDiv');"  />
					</div>
					
					<div class="cell mr20">
					  <label class="lH25"><?php echo $this->lang->line('searchToadsquare');?></label>
					</div>
					
					<div class="cell defaultP " >
						<input id="newsURLExternal" type="radio" name="newsUrlType" class="#newsSelectSearchType" value="2" <?php echo $NSST2;?> onclick="selectSearchType('#news','#newsExternalURLDiv');" />
					</div>
					
					<div class="cell mr20">
					  <label class="lH25"><?php echo $this->lang->line('externalURL');?></label>
					</div>
					
					<div class="cell defaultP" >
						<input id="newsURLEmbed" type="radio" name="newsUrlType" class="#newsSelectSearchType" value="3" <?php echo $NSST3;?> onclick="selectSearchType('#news','#newsEmbedURLDiv');" />
					</div>
					
					<div class="cell mr20">
					  <label class="lH25"><?php echo $this->lang->line('embeddedURL');?></label>
					</div>
			</div>
		</div>
	</div>
	
	<div class="row <?php echo $NSSTD1;?> #newsURLDiv" id="newsSearchOnToadsquareDiv">
		<div class="label_wrapper cell"><label class="select_field"><?php echo $this->lang->line('searchLabel');?></label></div>
		
		<div class=" cell frm_element_wrapper">
			<div class="row">
				<div id="displaySearchInputDiv" class="cell search_box_wrapper">
					<input id="newsSearch" name="newsSearch" type="text" class="search_text_box" value="<?php echo $this->lang->line('keywordSearch');?>" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
					<div class="search_btn ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/search/searchontoadsquare/',$('#newsSearch').val(),'news','newsSearch');">
						<img src="<?php echo base_url('images/btn_search_box.png');?>">
					</div>
				</div>
				
				<div id="newsSearchResult" class="cell">	
					<div class="row">
						<div id="newsSearchDiv" class="cell pt8 pl20 pr20 width300px"></div>
						 <div id="newsSearchRow" class="cell pl5 pt8 dn">
							 <div  class="small_btn formTip " title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteAssociatedNews()"><div class="cat_smll_plus_icon"></div></a></div>
						 </div>
					 </div>
				</div>
				<input id="newsSearchelementid_from" name="associatedNewsElementId" type="hidden" value="0">
				<input id="newsSearchprojectid" name="projId" type="hidden" value="0">
			</div>
	    </div>
	</div>
	
	
	
	<div class="row <?php echo $NSSTD2;?> #newsURLDiv" id="newsExternalURLDiv">
		<div class="label_wrapper cell"><label class="select_field"><?php echo $label['externalURL'];?></label></div>
		<div class="cell frm_element_wrapper" >
			<?php echo form_input($externalUrl); ?>
			<div class="row wordcounter"><?php echo form_error($externalUrl['name']); ?></div>
		</div>
	</div>

	<div class="row <?php echo $NSSTD3;?> #newsURLDiv" id="newsEmbedURLDiv">
		<div class="label_wrapper cell"><label class="select_field"><?php echo $label['embeddedURL'];?></label></div>
		<div class="cell frm_element_wrapper" >
			<?php echo form_textarea($newsEmbbededVideo); ?>
			<div class="row wordcounter"><?php echo form_error($newsEmbbededVideo['name']); ?></div>
		</div>
	</div>
	
	<div class="seprator_25 clear row"></div>	
		  
	<div class="row">
		<div class="label_wrapper cell"><label><?php echo $label['langauage'];?></label></div>
		<div class="cell frm_element_wrapper fl" >
		   <?php
				$language = getlanguageList();
				echo form_dropdown('newsLanguage', $language, set_value('newsLanguage'),'id="newsLanguage" ');
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="label_wrapper cell"><label><?php echo $label['datePublish']; ?></label></div>
		<div class="cell frm_element_wrapper" >
			<div class="cell width270px"><?php echo form_input($currentDate); echo form_input($publishDate); ?></div>
			<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#newspublishDate").focus();' /> </div>
			<div class="row wordcounter"><?php echo form_error($publishDate['name']); ?></div>
		</div>
	</div>

	<div class="row">
		<div class="label_wrapper cell bg-non">&nbsp;</div>
		<div class="cell frm_element_wrapper">
			<div class="Req_fld cell"><?php echo $label['requiredFields'];?></div><!--Req_fld-->			
			<?php
				$button=array('ajaxCancel','save');
				echo Modules::run("common/loadButtons",$button); 
			 ?>
			 <div class="fl pb10"><?php echo $label['afterReqMsg']?> </div>
		</div>
		
	</div>
</div>
<?php echo form_close(); ?>

<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->

<!--upload_media_left_box-->
<div class="seprator_25 clear"></div>
</div>
