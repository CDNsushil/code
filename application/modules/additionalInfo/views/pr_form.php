<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$lang=lang();
$PRfrom = array(
	'name'=>'PRfrom',
	'id'=>'PRfrom'
);
$PRsearchFrom = array(
	'name'=>'PRsearchFrom',
	'id'=>'PRsearchFrom'
);

$MW_PRheading  =str_replace('{{var catType}}',$this->lang->line('catType'.$projCategory),$this->lang->line('MW_PRHeading_'.$sectionId));

$PRidInput = array(
	'name'	=> 'PRid',
	'type'	=> 'hidden',
	'id'	=> 'PRid',
	'value'	=>0
);
$associatedElementIdInput = array(
	'name'	=> 'associatedElementId',
	'type'	=> 'hidden',
	'id'	=> 'associatedElementId',
	'value'	=>0
);
$entityIdInput = array(
	'name'	=> 'entityId',
	'type'	=> 'hidden',
	'id'	=> 'entityId',
	'value'	=>isset($entityId)?$entityId:0
);
$elementIdInput = array(
	'name'	=> 'elementId',
	'type'	=> 'hidden',
	'id'	=> 'elementId',
	'value'	=>isset($elementId)?$elementId:0
);
$projIdInput = array(
	'name'	=> 'projId',
	'type'	=> 'hidden',
	'id'	=> 'projId',
	'value'	=>isset($projId)?$projId:0
);

$externalUrlInput = array(
	'name'	=> 'externalUrl',
	'type'	=> 'text',
	'id'	=> 'externalUrl',
	'value'	=> '',
	'class'	=>'bdr_adadad width612 required url',
    "placeholder"=>"http://www.example.com",
    "onblur"=>"placeHoderHideShow(this,'http://www.example.com','show')" ,
    "onclick"=>"placeHoderHideShow(this,'http://www.example.com','hide')",
);

$searchInput = array(
	'name'	=> 'keyWord',
	'id'	=> 'search',
	'type'	=> 'text',
	'value'	=> '',
	'class'	=>'font_wN keryword width_270 pr24imp ',
    "placeholder"=>"Keyword",
    "onblur"=>"placeHoderHideShow(this,'keryword','show')" ,
    "onclick"=>"placeHoderHideShow(this,'keryword','hide')",
); ?>
   
<div class="c_1 clearb ">
    <?php echo form_open($actionUrl,$PRfrom); 
        echo form_input($PRidInput);
        echo form_input($associatedElementIdInput);
        echo form_input($entityIdInput);
        echo form_input($elementIdInput);
        echo form_input($projIdInput);  ?> 
        <h3 class="fs18 bb_aeaeae letter_sp-P3"><?php echo $MW_PRheading;?></h3>
        <?php 
        $mt40 = 'mt40';
        if($sectionId == 'news' || $sectionId == 'reviews'){
            $mt40 = '';?>
            <div class="defaultP  display_inline_block mt40 mb25">
                <label class="link_btn1 mr106"><input id="urlTypeExternal" type="radio" value="2" name="urlType" checked /><?php echo $this->lang->line('addExternalURL');?></label>
                <label class=" serch_btn1"><input id="urlTypeToad" type="radio" value="1" name="urlType" /><?php echo $this->lang->line('searchToadsquare');?></label>
            </div>
            <?php
        }?>
        <div class="link_2 <?php echo $mt40;?>">
            <ul class="public">
                <li> 
                    <?php echo form_input($externalUrlInput);?>
                </li>
                <li>
                    <h3 class="fs21 bb_aeaeae red mt20 mb15"><?php echo $this->lang->line('title');?> *</h3>
                    <span class="red fs13 fshel_midum">1 - 15 <?php echo $this->lang->line('words');?> </span> <span class="red fr  pr10 fs13 fshel_midum"><span id="wordsLimit">0</span> words </span>
                    <textarea class="bdr_adadad width612 mt10 required" name="title" id="title" value="" placeholder="Title *" onclick="placeHoderHideShow(this,'Title *','hide')" onblur="placeHoderHideShow(this,'Title *','show')" wordlength="1,15" onkeyup="checkWordLen(this,'15','wordsLimit')"></textarea>
                </li>
            </ul>
            <div class="sap_15"></div>
            <div class="fr font_weight">
                <button onclick="resetPRform('#PRfrom');" id="resetFormButton" aria-disabled="false" role="button" type="button" class="bg_ededed bdr_b1b1b1  mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only dn"><span class="ui-button-text"><span class="ui-button-text">Cancel</span></span></button>														
                <button id="saveFormButton" class="red fr" type="submit"><?php echo $this->lang->line('add');?></button>
            </div>
        </div>
    <?php echo form_close(); ?>    
    <!--   search-->	 
    <div class="serch_2 dn">
        <?php echo form_open(base_url(lang().DIRECTORY_SEPARATOR.'search'.DIRECTORY_SEPARATOR.'searchAssociated'),$PRsearchFrom);?>
        <ul class="public ">
            <li class="position_relative">
                <span class="position_relative mr20 mt10 ">
                <?php echo form_input($searchInput);?>
                <input type="submit" value="Submit" class="searchbtbbg" name="Submit">
                </span>
                <input type="hidden" name="sectionId" value="<?php echo $sectionId;?>">
                <input type="hidden" name="section" value="PRmaterial">
                <input type="hidden" name="isSectionList" value="0">
                <input id="searchButton" class="red p10 mt-5 width_75 bdr_a0a0a0 fshel_bold" type="button" onclick="$('#PRsearchFrom').submit();" value="Search" />
            </li>
        </ul>
        <?php echo form_close(); ?>
    </div>

    <?php echo '<div id="PRmaterialListing">';
            $this->load->view($listingPage);
          echo '</div>'; 
    ?>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $("#PRfrom").validate({
        submitHandler: function() {
            postFormGetHTML("#PRfrom","#PRmaterialListing");
            $("#PRfrom")[0].reset();
            $("#wordsLimit").html(0);
            $("#resetFormButton").hide();
            $("input#PRid").val(0);
            $("input#externalUrl").focus();
        }
    });
    $("#PRsearchFrom").validate({
        submitHandler: function() {
            postFormGetLightBox("#PRsearchFrom");
        }
    });
  });
  
  function editPRmetrial(id,title,url){
        if(id != undefined && id > 0){
            var wordCount = title.replace( /[^\w ]/g, "" ).split( /\s+/ ).length;
            $("input#PRid").val(id);
            $("textarea#title").val(title);
            $("#wordsLimit").html(wordCount);
            $("#resetFormButton").show();
            $("#saveFormButton").html('Save');
            if(url != undefined && url != ''){
                $("input#externalUrl").val(url);
            }
            $('.link_btn1').click();
            $("#urlTypeExternal").attr("checked", true);
        }
    }
    function resetPRform(formId){
        if(formId != undefined && formId !=''){
             $("input#PRid").val(0);
             $("#urlTypeExternal").attr("checked", true);
             $(formId)[0].reset();
             $("#wordsLimit").html(0);
             $('.link_btn1').click();
             $("#resetFormButton").hide();
             $("input#externalUrl").focus();
        }
    }
</script>
