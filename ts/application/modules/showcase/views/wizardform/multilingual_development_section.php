<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'developmentForm',
    'id'=>'developmentForm',
);

$optionAreaNameValue = set_value('optionAreaName')?set_value('optionAreaName'):$showcaseRes->optionAreaName;
$optionAreaNameValue = htmlentities($optionAreaNameValue);

$intrestAreaInput = array(
    'name'        =>  'optionAreaName',
    'id'          =>  'optionAreaName',
    'class'       =>  'required width527 min-height_25 mt14 bdr_adadad',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($optionAreaNameValue),
    'wordlength'  =>  "1,15",
    'onkeyup'     =>  "checkWordLen(this,15,'intrestArea')",
    'placeholder' =>  "Main area of Interest",
    'onBlur'      =>  "placeHoderHideShow(this,'Main area of Interest','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Main area of Interest','hide')"
);

$creativeFocusValue = set_value('creativeFocus')?set_value('creativeFocus'):$showcaseRes->creativeFocus;
$creativeFocusValue = htmlentities($creativeFocusValue);

$creativeFocusInput = array(
    'name'        =>  'creativeFocus',
    'id'          =>  'creativeFocus',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt16 height51',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($creativeFocusValue),
    'wordlength'  =>  "1,50",
    'onkeyup'     =>  "checkWordLen(this,50,'creativeFocus')",
    'placeholder' =>  "Your current focus",
    'onBlur'      =>  "placeHoderHideShow(this,'Your current focus','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Your current focus','hide')"
);

$creativePathValue = set_value('creativePath')?set_value('creativePath'):$showcaseRes->creativePath;
$creativePathInput = array(
    'name'        =>  'creativePath',
    'id'          =>  'ckeditor',
    'class'       =>  'ckeditor required',
    'value'       =>  html_entity_decode($creativePathValue),
    'tabindex'    =>  "1",
);

$showcaseLangIdInput  =   array(
  'name'     =>  'showcaseLangId',
  'id'       =>  'showcaseLangId',
  'value'    =>  $showcaseLangId,
  'type'     => 'hidden',    
); 

$showcaseIdInput  =   array(
  'name'     =>  'showcaseId',
  'id'       =>  'showcaseId',
  'value'    =>  $showcaseId,
  'type'     => 'hidden',    
);

$langSectionInput  =   array(
  'name'     =>  'langSection',
  'id'       =>  'langSection',
  'value'    =>  'developmentSection',
  'type'     => 'hidden',    
);

$nextStepInput  =   array(
  'name'     =>  'nextStep',
  'id'       =>  'nextStep',
  'value'    =>  'whatnext',
  'type'     => 'hidden',    
);

// set base url
$baseUrl = base_url(lang().'/showcase/');
$business = '';
if(isset($isEnterprise)) {
    $business = 'Business';
}
?>


<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php   
    echo form_open($baseUrl.'/setdevelopmentdetails/',$formAttributes); 
    ?>
        <div class="c_1 clearb">
           <ul class="form_img mt25">
              <li>
                 <h4 class="red fs20  bb_aeaeae"> <?php echo $this->lang->line('mainAreaOfInterest')?> </h4>
                 <span class="pl10 fs13 fshel_midum">1 - 15 words</span> 
                 <span class="red pr10 fr fs13 fshel_midum"><span id="intrestArea"><?php echo str_word_count($optionAreaNameValue);?></span>  <span>words</span> </span></label>
                  <?php echo form_input($intrestAreaInput); ?>
                </li>
                
                <li>
                    <h4 class="red fs20 bb_aeaeae mb0"> <?php echo $this->lang->line('maincreativeFocus')?> </h4>
                    <p class="pt10 fs16 mb20"><?php echo $this->lang->line('maincreativeFocusNote');?></p>
                    <span class="pl10 fs13 fshel_midum">1 - 50 words</span> 
                    <span class="red pr10 fr fs13 fshel_midum"><span id="creativeFocus"><?php echo str_word_count($creativeFocusValue);?></span>  <span>words</span> </span></label>
                    <?php echo form_textarea($creativeFocusInput); ?>
                </li>
                
               <li>
                <h4 class="red fs20 bb_aeaeae mb0"> <?php echo $this->lang->line('mainDevelopmentPath')?></h4>
                <p class="pt10 fs16"><?php echo $this->lang->line('mainDevelopmentPathNote');?></p>
                <span class="sap_30"></span>
                <div class="editor_wrap editor_showcase">
                    <?php echo form_textarea($creativePathInput); ?>
                </div>
              </li>
           </ul>
        </div>
    <?php 
        echo form_input($showcaseLangIdInput);
        echo form_input($showcaseIdInput);
        echo form_input($langSectionInput); 
        echo form_input($nextStepInput);
    echo form_close();?>
    <!-- Form buttons -->
    <?php 
    // set back page
    $data['backPage'] = '/showcase/aboutothersection/'.$showcaseLangId;
    // set next form name
    $data['formName'] = 'developmentForm';
    
    $this->load->view('wizardform/showcase_buttons',$data);
    ?>
</div>
<script type="text/javascript">
   /**
    * Set Editor's instance for data management
    */
    CKEDITOR.on('instanceReady', function(){
       $.each( CKEDITOR.instances, function(instance) {
        CKEDITOR.instances[instance].on("change", function(e) {
            for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
        });
       });
    });
    
    $(document).ready(function() {
        $("#developmentForm").validate({
            submitHandler: function() {
                var fromData=$("#developmentForm").serialize();
                $.post('<?php echo $baseUrl.'/setmutilingualdata';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
</script>
