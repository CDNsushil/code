<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'albumDescForm',
    'id'=>'albumDescForm',
);
// set Collection Title 
$projNameValue = set_value('projName')?set_value('projName'):$projData->projName;
$projName = array(
    'name'        =>  'projName',
    'id'          =>  'projName',
    'class'       =>  'required width527 min-height_25 mt14 bdr_adadad',
    'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  set_value('projName')?set_value('projName'):string_decode($projData->projName),
    'wordlength'  =>  "1,15",
    'onkeyup'     =>  "checkWordLen(this,15,'titleLimit')",
    'placeholder' =>  "Title",
    'onBlur'      =>  "placeHoderHideShow(this,'Title','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Title','hide')"
);

// set Collection Introduction
$projShortDescValue = set_value('projShortDesc')?set_value('projShortDesc'):$projData->projShortDesc;
$projShortDescValue = htmlentities($projShortDescValue);
$projShortDesc = array(
    'name'        =>  'projShortDesc',
    'id'          =>  'projShortDesc',
    'class'       =>  'required font_wN width_615 bdr_adadad mt14 height51',
    'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($projShortDescValue),
    'wordlength'  =>  "3,25",
    'onkeyup'     =>  "checkWordLen(this,25,'introLimit')",
    'placeholder' =>  "Collection Introduction",
    'onBlur'      =>  "placeHoderHideShow(this,'Collection Introduction','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Collection Introduction','hide')"
);

// set About the Collection 
$projDescProjValue = set_value('projDescription')?set_value('projDescription'):$projData->projDescription;
$projDescProjValue = htmlentities($projDescProjValue);
$projDescriptionProject = array(
    'name'        =>  'projDescription',
    'id'          =>  'projDescription',
    'class'       =>  'font_wN width_615 red_bdr_2 mt14 height_215',
    'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($projDescProjValue),
    'wordlength'  =>  "0,200",
    'onkeyup'     =>  "checkWordLen(this,200,'descLimit')",
    'placeholder' =>  "About the Collection ",
    'onBlur'      =>  "placeHoderHideShow(this,'About the Collection ','show')",
    'onClick'     =>  "placeHoderHideShow(this,'About the Collection ','hide')"
);

// set Tag Words
$tagWordsValue = set_value('projTag')?set_value('projTag'):$projData->projTag;
$tagWordsValue = htmlentities($tagWordsValue);
$tagWords = array(
    'name'        =>  'projTag',
    'id'          =>  'projTag',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt14 height51',
    'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($tagWordsValue),
    'wordlength'  =>  "3,25",
    'onkeyup'     =>  "checkWordLen(this,25,'tagLimit')",
    'placeholder' =>  "Tag Words",
    'onBlur'      =>  "placeHoderHideShow(this,'Tag Words','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Tag Words','hide')"
);

// set base url
$baseUrl = formBaseUrl();
// set back n skip url
$backUrl = '/selectcoverimage/'.$projectId;
$skipUrl = '/selectcollectioninfo/'.$projectId; 
if(isset($isStage2)) {
    $backUrl = '/newsreviewcoverimage/'.$projectId.'/'.$elementId;
    $skipUrl = '/newsreviewcollectioninfo/'.$projectId.'/'.$elementId;
}
// set element id
$elementId = (isset($elementId))?$elementId:'';
?>  
<div class="TabbedPanelsContent">
    <?php echo form_open($baseUrl.'/settitlendescription/'.$projectId.'/'.$elementId,$formAttributes); ?>
        <div class="c_1 clearb mb25 ">
            <ul class="form_img mt25">
                <li>
                    <h4 class="fs21 bb_aeaeae red">Collection Title*</h4>
                    <span class=" width_550"> 
                        <span class="red fs13 fshel_midum"><?php echo '1 - 15' .$this->lang->line('words');?></span> 
                        <span id="word_counter" class="red fr fs13 fshel_midum wordcounter">
                            <?php echo form_error($projName['name']); ?>
                            <span class="five_words" > 
                                <span id="titleLimit">
                                    <?php echo str_word_count($projNameValue);?>
                                </span>
                                <span>
                                    <?php echo $this->lang->line('words');?>
                                </span>
                            </span>
                        </span>
                        <?php echo form_input($projName);?>
                    </span>
                </li>
                <li>
                <h4 class="fs21 bb_aeaeae red">Collection Introduction*</h4>
                <span class="red fs13 fshel_midum"><?php echo '3 - 25' .$this->lang->line('words');?></span> 
                <span class="red pt6 pr10 fr fs13 fshel_midum">
                    <?php echo form_error($projShortDesc['name']); ?>
                    <span class="five_words" > 
                        <span id="introLimit">
                            <?php echo str_word_count($projShortDescValue);?>
                        </span>
                        <span>
                            <?php echo $this->lang->line('words');?>
                        </span>
                    </span>
                </span>
                <?php echo form_textarea($projShortDesc); ?>
                </li>
                <li>
                <h4 class="fs21 bb_aeaeae red">About the Collection </h4>
                <span class="red fs13 fshel_midum "><?php echo '0 - 200' .$this->lang->line('words');?></span>
                <span class="red pt6 pr10 fr fs13 fshel_midum">
                <?php echo form_error($projDescriptionProject['name']); ?>
                    <span class="five_words" > 
                        <span id="descLimit">
                            <?php echo str_word_count($projDescProjValue);?>
                        </span>
                        <span>
                            <?php echo $this->lang->line('words');?>
                        </span>
                    </span>
                </span>
                <?php echo form_textarea($projDescriptionProject); ?>
                </li>
                <li>
                    <h4 class="fs21 bb_aeaeae red"> Tag Words* </h4>
                    <span class="red fs13 fshel_midum"><?php echo '3 - 25' .$this->lang->line('words');?></span>
                    <span id="word_counter" class="red pt6 pr10 fr fs13 fshel_midum wordcounter">
                        <?php echo form_error($tagWords['name']); ?>
                        <span class="five_words" > 
                            <span id="tagLimit">
                                <?php echo str_word_count($tagWordsValue);?>
                            </span>
                            <span>
                                <?php echo $this->lang->line('words');?>
                            </span>
                         </span>
                    </span>
                    <?php echo form_textarea($tagWords); ?>
                </li>
            </ul>
        </div>
        <ul class="review display_inline_block pt0 ">
            <li class="icon_2 fl fs15 lineH24" > Tag Words do not appear on the site. They help search engines find your work. </li>
        </ul>
    <?php echo form_close();?>
    <!-- Form buttons -->
    <?php 
    // set back url
    $data['backPage'] =  $backUrl;
    if(!empty($projShortDescValue)) {
        // set skip url
        $data['skipPage'] = $skipUrl;
    }
    // set next form name
    $data['formName'] = 'albumDescForm';
    $data['industry'] = $industry;
    $data['projectId'] = $projectId;
    $this->load->view('common_view/cover_buttons',$data);
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#albumDescForm").validate({
            submitHandler: function() {
                var fromData=$("#albumDescForm").serialize();
                $.post('<?php echo $baseUrl.'/settitlendescription/'.$projectId.'/'.$elementId;?>',fromData, function(data) {
                    if(data){
                        window.location.href = '<?php echo $baseUrl ?>' + data.nextStep;
                        $('#messageSuccessError').html('<div class="successMsg"><?php echo "You have successfully update project details.";?></div>');
                        timeout = setTimeout(hideDiv, 5000);
                    }
                }, "json");
            }
        });
    });
</script>
