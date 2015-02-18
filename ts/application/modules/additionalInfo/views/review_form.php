<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
	$(document).ready(function(){	
		$("#reviewsForm").validate({});
		$('#reviewpublishDate').datepicker({dateFormat:'d MM yy'});
		
			
	});
</script>
<?php
$reviewsFormAttributes = array(
	'name'=>'reviewsForm',
	'id'=>'reviewsForm',
	'toggleDivForm'=>'REVIEWSForm-Content-Box',
	'section'=>'#review'
);

$externalUrl = array(
	'name'	=> 'externalUrl',
	'id'	=> 'reviewexternalUrl',
	'class'	=> 'width548px  url',
	'title'=>  'Add external url here',
	'value'	=> set_value('externalUrl')
	//'placeholder'	=> 'Add external url here'
);

$title = array(
	'name'	=> 'title',
	'id'	=> 'reviewtitle',
	'class'	=> 'width548px  required',
	'title'=>  $label['addTitleMsg'],
	'value'	=> set_value('reviewTitle'),
	//'placeholder'	=> $label['addTitleMsg'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$writerName = array(
	'name'	=> 'writerName',
	'id'	=> 'reviewwriterName',
	'class'	=> 'width548px required',
	'title'=>  $label['addWriterMsg'],	
	'value'	=> set_value('writerName'),	
	//'placeholder' => $label['addWriterMsg'],
	//'minlength'	=> 2,
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
	'id'	=> 'reviewpublishDate',
	'class'	=> 'width246px',	
	'title' =>'Publish date must be greater than/equal to Current date',
	'value'	=> set_value('publishDate'),
	'readonly'=>true
);

$reviewsEmbbededVideo = array(
	'name'	=> 'reviewsEmbbededVideo',
	'id'	=> 'reviewEmbbededVideo',
	'value'	=> set_value('reviewsEmbbededVideo'),//,set_value('workOneLineDesc',$workOffered['workOneLineDesc']);	
	'rows'      => 2,
    'cols'      => 45,
	'class'       => 'width548px embededURL rz '
);
?>

<!--<div class="row">
	<div class="label_wrapper cell"><div class="lable_heading"><h1><span id="reviewHeading"><?php echo $label['add'];?></span> <?php echo $label['REVIEWS'];?></h1></div></div>
	<div class="small_frm_wp" >                        
		<div class=" cell frm_element_wrapper inner_heading">
			<a href="javascript:void(0);" class="Fright orange_color mr5" onclick="openLightBox('loginLightBoxWp','loginFormContainer','/additionalInfo/searchAdditionalInfo','review','AddInfoReviews','reviewTitle')"><?php echo $label['searchOnToadsquare'];?></a>
		</div>
	</div>
</div>
-->

<div class="dn" id="uploadElementForm" style="display: block;">
<div class="upload_media_left_top row"></div><!--upload_media_left_top-->

<?php echo form_open('additionalInfo/saveAddInfoReviews',$reviewsFormAttributes); ?>
<div class="upload_media_left_box">
	<input type="hidden" value="0" name="reviewId" id="reviewId" />
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
		$data=array('id'=>'reviewDescription','name'=>'reviewDescription','value'=>$value, 'labelText'=>'description', 'required'=>'','descLimit'=>'reviewDescLimit', 'view'=>'description','addclass'=>'width548px','wordOption'=>$wordOption);
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
						$urlType=@$urlType?$urlType:2;
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
					
					<?php /*
					<div class="cell defaultP" >
					  <input id="reviewURLts" type="radio" name="reviewUrlType"  class="#reviewSelectSearchType" value="1" <?php echo $NSST1;?> onclick="selectSearchType('#review','#reviewSearchOnToadsquareDiv');"  />
					</div>
					
					<div class="cell mr20">
					  <label class="lH25"><?php echo $this->lang->line('searchOnToadsquare');?></label>
					</div>
					*/ ?>
					<div class="cell defaultP " >
						<input id="reviewURLExternal" type="radio" name="reviewUrlType" class="#reviewSelectSearchType" value="2" <?php echo $NSST2;?> onclick="selectSearchType('#review','#reviewExternalURLDiv');" />
					</div>
					
					<div class="cell mr20">
					  <label class="lH25"><?php echo $this->lang->line('externalURL');?></label>
					</div>
					
					<div class="cell defaultP" >
						<input id="reviewURLEmbed" type="radio" name="reviewUrlType" class="#reviewSelectSearchType" value="3" <?php echo $NSST3;?> onclick="selectSearchType('#review','#reviewEmbedURLDiv');" />
					</div>
					
					<div class="cell mr20">
					  <label class="lH25"><?php echo $this->lang->line('embeddedURL');?></label>
					</div>
			</div>
		</div>
	</div>
	
	<div class="row <?php echo $NSSTD1;?> #reviewURLDiv" id="reviewSearchOnToadsquareDiv">
		<div class="label_wrapper cell"><label><?php echo $this->lang->line('searchOnToadsquare');?></label></div>
		<div class="cell frm_element_wrapper fl" >
		   <div class="fl">
				<div class="search_box_wrapper">
                    	<input type="text" placeholder="<?php echo $this->lang->line('keywordSearch');?>"; value="" class="search_text_box">
                        <div class="search_btn">
							<!--onclick="openLightBox('loginLightBoxWp','loginFormContainer','/additionalInfo/searchAdditionalInfo','review','AddInfoReviews','reviewTitle')" -->
							<img src="<?php echo base_url('templates/default/images/btn_search_box.png');?>"  />
                        </div>
                  </div>
			</div>
		</div>
	</div>
	
	<div class="row <?php echo $NSSTD2;?> #reviewURLDiv" id="reviewExternalURLDiv">
		<div class="label_wrapper cell"><label><?php echo $label['externalURL'];?></label></div>
		<div class="cell frm_element_wrapper" >
			<?php echo form_input($externalUrl); ?>
			<div class="row wordcounter"><?php echo form_error($externalUrl['name']); ?></div>
		</div>
	</div>

	<div class="row <?php echo $NSSTD3;?> #reviewURLDiv" id="reviewEmbedURLDiv">
		<div class="label_wrapper cell"><label><?php echo $label['embeddedURL'];?></label></div>
		<div class="cell frm_element_wrapper" >
			<?php echo form_textarea($reviewsEmbbededVideo); ?>
			<div class="row wordcounter"><?php echo form_error($reviewsEmbbededVideo['name']); ?></div>
		</div>
	</div>
	
	<div class="seprator_25 clear row"></div>
		  
	<div class="row">
		<div class="label_wrapper cell"><label><?php echo $label['langauage'];?></label></div>
		<div class="cell frm_element_wrapper" >
		   <?php
				$language = getlanguageList();
				echo form_dropdown('reviewLanguage', $language, set_value('reviewLanguage'),'id="reviewLanguage"');
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="label_wrapper cell"><label><?php echo $label['datePublish']; ?></label></div>
		<div class="cell frm_element_wrapper" >
			<div class="cell width270px"><?php  echo form_input($currentDate); echo form_input($publishDate); ?></div>
			<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#reviewpublishDate").focus();' /> </div>
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
