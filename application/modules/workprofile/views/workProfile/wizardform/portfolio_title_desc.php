<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'titleDescForm',
    'id'=>'titleDescForm',
);
// get media type
$mediaTypeVal = (isset($profileMediaData->mediaType)) ? $profileMediaData->mediaType : '';
// set title field header text
$titleText = $this->lang->line('portTitle'.$mediaTypeVal);
// set description field header text
$descriptionText = $this->lang->line('portDescription'.$mediaTypeVal);

// set media Title 
$mediaTitleValue = set_value('mediaTitle')?set_value('mediaTitle'):$profileMediaData->mediaTitle;
$mediaTitleInput = array(
    'name'        =>  'mediaTitle',
    'id'          =>  'mediaTitle',
    'class'       =>  'required width527 min-height_25 mt14 bdr_adadad',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  set_value('mediaTitle')?set_value('mediaTitle'):string_decode($profileMediaData->mediaTitle),
    'wordlength'  =>  "1,15",
    'onkeyup'     =>  "checkWordLen(this,15,'titleLimit')",
    'placeholder' =>  $titleText,
    'onBlur'      =>  "placeHoderHideShow(this,".$titleText.",'show')",
    'onClick'     =>  "placeHoderHideShow(this,".$titleText.",'hide')"
);

// set media Description
$mediaDescValue = set_value('mediaDesc')?set_value('mediaDesc'):$profileMediaData->mediaDesc;
$mediaDescValue = htmlentities($mediaDescValue);
$mediaDescInput = array(
    'name'        =>  'mediaDesc',
    'id'          =>  'mediaDesc',
    'class'       =>  'font_wN width_615 red_bdr_2 mt14 height_215',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($mediaDescValue),
    'wordlength'  =>  "0,200",
    'onkeyup'     =>  "checkWordLen(this,200,'descLimit')",
    'placeholder' =>  $descriptionText,
    'onBlur'      =>  "placeHoderHideShow(this,".$descriptionText.",'show')",
    'onClick'     =>  "placeHoderHideShow(this,".$descriptionText.",'hide')"
);

// set media Id
$mediaIdInput = array(
	'name'    =>  'mediaId',
    'id'      =>  'mediaId',
	'type' 	  =>  'hidden',
	'value'   =>  $mediaId
);

// set media Type
$mediaTypeInput = array(
	'name'    =>  'mediaType',
    'id'      =>  'mediaType',
	'type' 	  =>  'hidden',
	'value'   =>  $mediaTypeVal
);

// set base url
$baseUrl = base_url_lang('/workprofile');

?>
<div class="TabbedPanelsContentGroup design_wrap width_665 m_auto ">
	<div class="TabbedPanelsContent width635 m_auto clearb TabbedPanelsContentVisible">
		<?php echo form_open($baseUrl.'/portfoliotitlendesc/'.$mediaId.'/'.$mediaTypeVal,$formAttributes); ?>
			<div class="c_1 clearb mb25 ">
				<ul class="form_img mt25">
					<li>
						<h4 class="fs21 bb_aeaeae red"><?php echo $titleText;?></h4>
						<span class="width527"> 
							<span class="red fs13 fshel_midum"><?php echo '1 - 15' .$this->lang->line('words');?></span> 
							<span id="word_counter" class="red fr fs13 fshel_midum wordcounter">
								<?php echo form_error($mediaTitleInput['mediaTitle']); ?>
								<span class="five_words" > 
									<span id="titleLimit">
										<?php echo str_word_count($mediaTitleValue);?>
									</span>
									<span>
										<?php echo $this->lang->line('words');?>
									</span>
								</span>
							</span>
							<?php echo form_input($mediaTitleInput);?>
						</span>
					</li>
					
					<li>
					<h4 class="fs21 bb_aeaeae red"><?php echo $descriptionText;?></h4>
					<span class="red fs13 fshel_midum "><?php echo '0 - 200' .$this->lang->line('words');?></span>
					<span class="red pt6 pr10 fr fs13 fshel_midum">
					<?php echo form_error($mediaDescInput['mediaDesc']); ?>
						<span class="five_words" > 
							<span id="descLimit">
								<?php echo str_word_count($mediaDescValue);?>
							</span>
							<span>
								<?php echo $this->lang->line('words');?>
							</span>
						</span>
					</span>
					<?php echo form_textarea($mediaDescInput); ?>
					</li>
				</ul>
			</div>
			<?php 
			echo form_input($mediaIdInput);
			echo form_input($mediaTypeInput);
		echo form_close();?>
		<!-- Form buttons -->
		<?php
		// set cancle url
		$data['cancleUrlType'] = 2; 
		// set back url
		$data['backPage'] = '/workprofile/uploadmedia/'.$mediaId.'/'.$mediaTypeVal;
		// set next form name
		$data['formName'] = 'titleDescForm';
		$this->load->view('workProfile/wizardform/common_buttons',$data);
		?>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#titleDescForm").validate({
            submitHandler: function() {
                var fromData=$("#titleDescForm").serialize();
                $.post('<?php echo $baseUrl.'/settitlendescription/';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
</script>
