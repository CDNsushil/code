<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'aboutSectionForm',
    'id'=>'aboutSectionForm',
);

$promotinalSectionValue = set_value('promotionalsection')?set_value('promotionalsection'):$showcaseRes->promotionalsection;
$promotinalSectionInput = array(
    'name'        =>  'promotionalsection',
    'id'          =>  'ckeditor',
    'class'       =>  'ckeditor required',
    'value'       =>  html_entity_decode($promotinalSectionValue),
    'tabindex'    =>  "1",
);

$tagWordsValue = set_value('tagwords')?set_value('tagwords'):$showcaseRes->tagwords;
$tagWordsValue = htmlentities($tagWordsValue);

$tagWords = array(
    'name'        =>  'tagwords',
    'id'          =>  'tagwords',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt16 height51',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($tagWordsValue),
    'wordlength'  =>  "3,25",
    'onkeyup'     =>  "checkWordLen(this,25,'tagLimit')",
    'placeholder' =>  "Tag Words",
    'onBlur'      =>  "placeHoderHideShow(this,'Tag Words','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Tag Words','hide')"
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
  'value'    =>  'aboutSection',
  'type'     => 'hidden',    
);

$nextStepInput  =   array(
  'name'     =>  'nextStep',
  'id'       =>  'nextStep',
  'value'    =>  'otherdevelopmentsection',
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
    echo form_open($baseUrl.'/setmutilingualdata/',$formAttributes); 
    ?>
        <div class="c_1 clearb">
           <ul class="form_img mt25">
              <li>
                 <h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('tagWords')?> </h4>
                 <span class="pl10 fs13 fshel_midum">3 - 25 words</span> 
                 <span class="red pr10 fr fs13 fshel_midum"><span id="tagLimit"><?php echo str_word_count($tagWordsValue);?></span>  <span>words</span> </span></label>
                  <?php echo form_textarea($tagWords); ?>
              </li>
              <li class="icon_2 pt0 mt25"><?php echo $this->lang->line('tagNote');?></li>
               <li>
                <h4 class="red fs21 bb_aeaeae mb0"> <?php echo $this->lang->line('aboutSection'.$business)?></h4>
                <p class="pt10 fs16"><?php echo $this->lang->line('aboutUsNote');?></p>
                <span class="sap_30"></span>
                <div class="editor_wrap editor_showcase">
                    <?php echo form_textarea($promotinalSectionInput); ?>
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
        $data['backPage'] = '/showcase/addotherlanguage/'.$showcaseLangId;
        // set next form name
        $data['formName'] = 'aboutSectionForm';
        
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
        $("#aboutSectionForm").validate({
            submitHandler: function() {
                var fromData=$("#aboutSectionForm").serialize();
                $.post('<?php echo $baseUrl.'/setmutilingualdata';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
</script>
