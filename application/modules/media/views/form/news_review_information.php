<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$lang=lang();
$formAttributes =   array(
    'name' =>  'elementInformation',
    'id'   =>  'elementInformation'
);

// set Subgenre of element
$wordCountValue = set_value('wordCount')?set_value('wordCount'):string_decode($elementData->wordCount);
$wordCountInput = array(
    'name'        =>  'wordCount',
    'id'          =>  'wordCount',
    'class'       =>  'number font_wN width_325 fs13 pb6',
    'title'       =>  'wordCount',
    'value'       =>  $wordCountValue,
    'placeholder' =>  "0",
    'onBlur'      =>  "placeHoderHideShow(this,'0','show')",
    'onClick'     =>  "placeHoderHideShow(this,'0','hide')"
);

// set Subgenre of element
$subjectValue = set_value('articleSubject')?set_value('articleSubject'):string_decode($elementData->articleSubject);
$subjectInput = array(
    'name'        =>  'articleSubject',
    'id'          =>  'articleSubject',
    'class'       =>  'font_wN width_325 fs13 pb6 required',
    'title'       =>  'Subject *',
    'value'       =>  $subjectValue,
    'placeholder' =>  "Subject *",
    'onBlur'      =>  "placeHoderHideShow(this,'Subject *','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Subject *','hide')"
);

// set Exhibited of element
$classificationValue = set_value('classification')?set_value('classification'):string_decode($elementData->classification);
$exhibitedInput = array(
    'name'        =>  'classification',
    'id'          =>  'classification',
    'class'       =>  'font_wN width_325 fs13 pb6',
    'title'       =>  'Copyright Notes',
    'value'       =>  $classificationValue,
    'wordlength'  =>  "0,10",
    'onkeyup'     =>  "checkWordLen(this,10,'exhibitedLimit')",
    'placeholder' =>  "Copyright Notes",
    'onBlur'      =>  "placeHoderHideShow(this,'Copyright Notes','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Copyright Notes','hide')"
);
// set project id
$projectIdInput = array(
    'name'  => 'projectId',
    'id'    => 'projectId',
    'value' => $projectId,
    'type'  => 'hidden'
);
// set element id
$elementIdInput = array(
    'name'  => 'elementId',
    'id'    => 'elementId',
    'value' => $elementId,
    'type'  => 'hidden'
);
// set entity id
$entityIdInput = array(
    'name'  => 'entityId',
    'id'    => 'entityId',
    'value' => $entityId,
    'type'  => 'hidden'
);

// set entity id
$industryIdHidden = array(
    'name'  => 'industryId',
    'id'    => 'industryId',
    'value' => (!empty($elementData->industryId))?$elementData->industryId:'0',
    'type'  => 'hidden'
);
// set base url
$baseUrl = formBaseUrl();
// set back url
$backUrl = '/uploaddisplayimage/'.$projectId.'/'.$elementId;

?>
    <div class="TabbedPanelsContent member creative_wrap  width635 m_auto clearb">
        
        <?php if($elementData->genreId == 0 && count($otherElementRes) > 0) { ?>
            <div class="c_1">
                <h3 class="fs21  fl red fnt_mouse bd_none"> Copy Creative Team from Image </h3>
                <div class="fr mt52 ml40 display_table width_216">
                    <ul class="billing_form date mt5 pl10 clearb fl">
                        <li class="select width_69 min-height_29">
                            <select name="teamElements" id="teamElements" class="main_SELECT"  >
                                <?php
                                $i = 1;
                                foreach($otherElementRes as $otherElementRes) { ?>
                                    <option value="<?php echo $otherElementRes->elementId;?>" ><?php echo $i;?></option>
                                <?php $i++;} ?>
                            </select>
                        </li>
                    </ul>
                    <div class="ml40">
                        <input class="red fr p10 bdr_a0a0a0 fshel_bold" value="Copy" id="copyElementInfo" type="button" />
                    </div>
                </div>
            </div>
            <p class=" font_helLight fs23 clearb  mt15 mb15 text_alighL" > OR</p>
        <?php } else {
            echo '<div class="sap_35"></div>';
        } ?>
        <div class="c_1 clearb mb15">
            <?php echo form_open($baseUrl.'/settitlendescription/'.$elementId,$formAttributes); ?>
                <h4 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('uploadStage_information')?></h3>
                <div class="pannel7 Image_Info ">
                    <!--========================== Step 3  innertab==============================-->
                    <ul id="tabs_nav" class=" mt60  pt4 width_200 pr3 fl bdr_right_666 fshel_midum">
                        <li><a href="#" name="#tab1" id="current">Industry*</a></li>
                        <?php if($sectionId == '3:2') { ?>
                            <li><a href="#" name="#tabSub" >Subject*</a></li>
                        <?php }?>
                        <li id="genderLeftID" style="display:<?php if($elementData->genreId != 0){ echo "display"; }else { echo "none"; } ?>"><a href="#"  name="#tab2">Genre of the Subject*</a></li>
                        <li><a href="#" name="#tab3">Word Count</a></li>
                        <li><a href="#" name="#tab4">Language</a></li>
                        <li><a href="#" name="#tab5">Country of Origin</a></li>
                        <li><a href="#" name="#tab6">Copyright Notes</a></li>
                    </ul>
                    <!--=========== Step 3  inner tab content ========-->
                    <div id="content_tabs" class="fl pl70 width_360 mt10">
                        <div id="tab1">
                            <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25">Industry</h4>
                            <ul class="billing_form width169 mt2 pl10 fl">
                                <li class="select">
                                    <?php 
                                    $industryId = set_value('industryId')?set_value('industryId'):@$elementData->industryId;
                                    if( ! $industryId > 0) {
                                        $industryId = '';
                                    }
                                    
                                    $isDisabled = (!empty($elementData->projectId) && !empty($elementData->projectElementId))?"disabled":"";
                                    if(!empty($isDisabled)){
                                            echo form_input($industryIdHidden);
                                    }
                                    
                                    $industryList = getIndustryList('en','1');
                                    echo form_dropdown('industryId', $industryList, $industryId,'id="industryId" class="required" '.$isDisabled.'');
                                    
                                    
                                    ?>
                                </li>
                            </ul>
                        </div>
                        <?php if($sectionId == '3:2') { ?>
                            <div id="tabSub">
                                <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25">Subject</h4>
                                <div class="input_wrap pl10 mt3 pl10 fl">
                                    <?php echo form_input($subjectInput);?>
                                </div>
                            </div>
                        <?php } ?>
                        <div id="tab2" id="genreDisId" style="display:<?php if($elementData->genreId != 0){ echo "display"; }else { echo "none"; } ?>"  >
                            <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25">Genre of the Subject</h4>
                            <div id="genreLi">
                                <ul class="billing_form width169 mt2 pl10 fl">
                                    <li class="select">
                                        <?php 
                                        $projGenre = set_value('genreId')?set_value('genreId'):$elementData->genreId;
                                        if( ! $projGenre > 0) {
                                            $projGenre = '';
                                        }
                                        $genre = getGenerList(0,$industryId,lang(),'selectGenre');
                                        //$subgenre = getMediaGenerList($projCategory,'selectGenre');
                                        echo form_dropdown('genreId', $genre, $projGenre,'id="genreId" class="required" ');
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="tab3">
                            <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25">Word Count</h4>
                            <div class="input_wrap pl10 mt3 pl10 fl">
                                <?php echo form_input($wordCountInput);?>
                            </div>
                        </div>
                        <div id="tab4">
                            <h4 class="fs21 fnt_mouse  bb_e7e7e7 pl15 mb25">Language</h4> 
                            <ul class="billing_form width166 mt2 pl10 fl">
                                <li class="select">
                                    <?php 
                                    $languageId = set_value('languageId')?set_value('languageId'):$elementData->languageId;
                                    $languageList = getlanguageList();
                                    echo form_dropdown('languageId', $languageList, $languageId,'id="languageId" class=" main_SELECT required"');
                                    ?> 
                                </li>
                            </ul>
                        </div>
                        <div id="tab5" class="origin">
                            <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25">Country of Origin</h4>
                            <div class="date_wrap clearb display_table pl20 pb7 pt10 mb12 fs14"> Country of Origin </div>
                            <ul class="billing_form width166 mt2 pl10 fl">
                                <li class="select">
                                    <?php 
                                    $producedInCountry=set_value('producedInCountry')?set_value('producedInCountry'):@$elementData->producedInCountry;
                                    $producedInCountryList = getCountryList();
                                    echo form_dropdown('producedInCountry', $producedInCountryList, $producedInCountry,'id="producedInCountry" class=" main_SELECT required"');
                                    ?> 
                                </li>
                            </ul>
                        </div>
                        <div id="tab6">
                            <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25">Copyright Notes</h4>
                            <div class="input_wrap pl10 mt3 pl10 fl">
                                <?php echo form_input($exhibitedInput);?>
                            </div>
                             <div class="pl20 fl width_333 mt1 pt15"> 
                                <span class="red fs13 fshel_midum">
                                    <?php echo '0 - 10' .$this->lang->line('words');?> 
                                </span>
                                <span id="word_counter" class="red fr fs13 fshel_midum wordcounter">
                                    <?php echo form_error($exhibitedInput['classification']); ?>
                                    <span class="five_words" > 
                                        <span id="exhibitedLimit">
                                            <?php echo str_word_count($classificationValue);?>
                                        </span>
                                        <span>
                                            <?php echo $this->lang->line('words');?>
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                echo form_input($elementIdInput);
                echo form_input($entityIdInput);
                echo form_input($projectIdInput);
            echo form_close();?>
        </div>
        <!-- Form buttons -->
        <?php 
        // set back page
        $data['backPage'] = $backUrl;
        // set skip page
        //$data['skipPage'] = '/uploadcreativeteam/'.$projectId.'/'.$elementId;
        $data['isSkipstep'] = 1;
        // set next form name
        $data['formName'] = 'elementInformation';
        
        $this->load->view('common_view/upload_buttons',$data);
        ?>
    </div>


<script type="text/javascript">
    $(document).ready(function() {
        $("#elementInformation").validate({
            submitHandler: function() {
                 /* To check ull validation */
                var industryId = $('#industryId').val();
                var genreId = $('#genreId').val();
                
                if($('#genderLeftID').css('display') == 'none')
                {
                    genreId = 'Check';
                }
                
                var articleSubject = $('#articleSubject').val();
                if(industryId == "" || genreId == "" || articleSubject == "" )
                {
                        customAlert('Please fill all mandatory filled');
                        return false;
                }
                
                
                var fromData=$("#elementInformation").serialize();
                $.post('<?php echo $baseUrl.'/setnewsreviewinformation/';?>',fromData, function(data) {
                    if(data){
                        window.location.href = '<?php echo $baseUrl;?>'+data.nextStep;
                    }
                }, "json");
            }
        });
    
        // manage elements information copy functionality  
        $('#industryId').change(function() {
            var industryId = $('#industryId').val();
            
            var fromData = 'industryId='+industryId;
            $.post('<?php echo $baseUrl.'/getgenrelisting/';?>',fromData, function(data) {
                if(data) {
                    //alert(data.result);
                    if(data.result == 1){
                        $('#genreDisId').show();
                        $('#genderLeftID').show();
                        $('#genreLi').html(data.html);
                    }
                    else{
                        $('#genreDisId').hide();
                        $('#genderLeftID').hide();
                        $('select#genreId option').removeAttr('selected');
                        $('select#genreId option:first-child').attr("selected", "selected");
                    }
                }
            },'json');
        });
    });
</script>
