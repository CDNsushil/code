<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script>
$(document).ready(function(){	
	$("#interviewForm").validate({});	
});
</script>
<?php
$reviewsFormAttributes = array(
	'name'=>'interviewForm',
	'id'=>'interviewForm',
	'toggleDivForm'=>'INTERVIEWSForm-Content-Box',
	'section'=>'#interv'
);

$externalUrl = array(
	'name'	=> 'externalUrl',
	'id'	=> 'intervexternalUrl',
	'class'	=> 'width548px url',
	'title'=>  'Add external url here',
	'value'	=> set_value('externalUrl')
	//'placeholder'	=> 'Add external url here'
);


$title = array(
	'name'	=> 'title',
	'id'	=> 'intervtitle',
	'class'	=> 'width548px required',
	'title'=>  $label['addTitleMsg'],
	'value'	=> set_value('intervTitle'),
	//'placeholder'	=> $label['addTitleMsg'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$writerName = array(
	'name'	=> 'writerName',
	'id'	=> 'intervwriterName',
	'class'	=> 'width548px',
	'title'=>  $label['addWriterMsg'],	
	'value'	=> set_value('writerName'),	
	//'placeholder' => $label['addWriterMsg'],
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
	'id'	=> 'intervpublishDate',
	'class'	=> 'width246px date-input',	
	'title' =>'Publish date must be greater than/equal to Current date',	
	'value'	=> set_value('publishDate'),
	'readonly'=>true
);

$interviewEmbbededVideo = array(
	'name'	=> 'interviewEmbbededVideo',
	'id'	=> 'intervEmbbededVideo',
	'value'	=> set_value('interviewEmbbededVideo'),//,set_value('workOneLineDesc',$workOffered['workOneLineDesc']);	
	'rows'      => 2,
    'cols'      => 45,
	'class'       => 'width548px rz embededURL'
);

?>

<!--<div class="row">
	<div class="label_wrapper cell"><div class="lable_heading"><h1><span id="intervHeading"><?php echo $label['add'];?></span> <?php echo $label['INTERVIEWS'];?></h1></div></div>
	<div class="small_frm_wp" >                        
		<div class=" cell frm_element_wrapper inner_heading">
		</div>
	</div>
</div>
-->

<div class="dn" id="uploadElementForm" style="display: block;">
<div class="upload_media_left_top row"></div><!--upload_media_left_top-->

<?php echo form_open('additionalInfo/saveAddInfoInterviews',$reviewsFormAttributes); ?>
<div class="upload_media_left_box">
	<input type="hidden" value="0" name="intervId" id="intervId" />
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
		<div class="label_wrapper cell"><label><?php echo $label['interviewer'];?></label></div>
		<div class="cell frm_element_wrapper" >
			<?php echo form_input($writerName); ?>
			<div class="row wordcounter"><?php echo form_error($writerName['name']); ?></div>
		</div>
		
	</div>
	
	<?php 
		$value=set_value('description');
		$value=htmlentities($value);
		$wordOption=array('minVal'=>0,'maxVal'=>50,'wordLabel'=>$this->lang->line('descriptionMsgNR'));
		$data=array('id'=>'intervDescription','name'=>'intervDescription','value'=>$value, 'labelText'=>'description', 'required'=>'','descLimit'=>'intrvDescLimit', 'view'=>'description','addclass'=>'width548px','wordOption'=>$wordOption);
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
					<div class="cell defaultP" >
						<input id="intervURLExternal" type="radio" name="intervUrlType" class="#intervSelectSearchType" value="2" <?php echo $NSST2;?> onclick="selectSearchType('#interv','#intervExternalURLDiv');" />
					</div>
					
					<div class="cell mr20">
					  <label class="lH25"><?php echo $this->lang->line('externalURL');?></label>
					</div>
					
					<div class="cell defaultP" >
						<input id="intervURLEmbed" type="radio" name="intervUrlType" class="#intervSelectSearchType" value="3" <?php echo $NSST3;?> onclick="selectSearchType('#interv','#intervEmbedURLDiv');" />
					</div>
					
					<div class="cell mr20">
					  <label class="lH25"><?php echo $this->lang->line('embeddedURL');?></label>
					</div>
			</div>
		</div>
	</div>
	
	
	
	<div class="row <?php echo $NSSTD2;?> #intervURLDiv" id="intervExternalURLDiv">
		<div class="label_wrapper cell"><label><?php echo $label['externalURL'];?></label></div>
		<div class="cell frm_element_wrapper" >
			<?php echo form_input($externalUrl); ?>
			<div class="row wordcounter"><?php echo form_error($externalUrl['name']); ?></div>
		</div>
	</div>

	<div class="row <?php echo $NSSTD3;?> #intervURLDiv" id="intervEmbedURLDiv">
		<div class="label_wrapper cell"><label><?php echo $label['embeddedURL'];?></label></div>
		<div class="cell frm_element_wrapper" >
			<?php echo form_textarea($interviewEmbbededVideo); ?>
			<div class="row wordcounter"><?php echo form_error($interviewEmbbededVideo['name']); ?></div>
		</div>
	</div>
	
	<div class="seprator_25 clear row"></div>
	
		<div class="row">
			<div class="label_wrapper cell"><label class="select_field"><?php echo $label['langauage'];?></label></div>
			<div class="cell frm_element_wrapper" >
			   <?php
					$language = getlanguageList();
					echo form_dropdown('intervLanguage', $language, set_value('intervLanguage'),'id="intervLanguage" class="required"');
				?>
				
			</div>
		</div>
	
	<div class="row">
		<div class="label_wrapper cell"><label><?php echo $label['datePublish']; ?></label></div>
		<div class="cell frm_element_wrapper" >
			<div class="cell width270px"><?php  echo form_input($currentDate); echo form_input($publishDate); ?></div>
			<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#intervpublishDate").focus();' /> </div>
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
