<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    
$formAttributes = array(
    'name'=>'newsReviewForm',
    'id'=>'newsReviewForm',
);

// set Collection Title 
$titleValue = set_value('title')?set_value('title'):$projData->title;
$titleInput       =   array(
    'name'        =>  'title',
    'id'          =>  'title',
    'class'       =>  'required width527 min-height_25 mt14 bdr_adadad',
    'value'       =>  set_value('title')?set_value('title'):string_decode($projData->title),
    'wordlength'  =>  "1,15",
    'onkeyup'     =>  "checkWordLen(this,15,'titleLimit')",
    'placeholder' =>  "Title *",
    'onBlur'      =>  "placeHoderHideShow(this,'Title *','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Title *','hide')"
);

// set Collection Title 
$articleSubjectValue = (isset($projData->title_subjects))?$projData->title_subjects:'';
$articleSubjectInput =   array(
    'name'        =>  'articleSubject',
    'id'          =>  'articleSubject',
    'class'       =>  'required width527 min-height_25 mt14 bdr_adadad',
    'value'       =>  set_value('articleSubject')?set_value('articleSubject'):string_decode($projData->title_subjects),
    'wordlength'  =>  "1,15",
    'onkeyup'     =>  "checkWordLen(this,15,'subjectLimit')",
    'placeholder' =>  "Article Subject *",
    'onBlur'      =>  "placeHoderHideShow(this,'Article Subject *','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Article Subject *','hide')"
);


$articleValue = set_value('article')?set_value('article'):$projData->article;
$articleInput = array(
    'name'        =>  'article',
    'id'          =>  'ckeditor',
    'class'       =>  'ckeditor required',
    'value'       =>  html_entity_decode($articleValue),
    'tabindex'    =>  "1",
);

$tagWordsValue = set_value('tags')?set_value('tags'):$projData->tags;
$tagWordsValue = htmlentities($tagWordsValue);

$tagWords = array(
    'name'        =>  'tags',
    'id'          =>  'tags',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt16 height51',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($tagWordsValue),
    'wordlength'  =>  "3,25",
    'onkeyup'     =>  "checkWordLen(this,25,'tagLimit')",
    'placeholder' =>  "Tag Words *",
    'onBlur'      =>  "placeHoderHideShow(this,'Tag Words *','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Tag Words *','hide')"
);

$elementEntityIdField = array(
    'name'	=> 'elementEntityId'.$browseId,
    'value'	=> $elementEntityId,
    'id'	=> 'elementEntityId'.$browseId,
    'type'	=> 'hidden'
);

$baseUrl = formBaseUrl();
// set skip url
if(!empty($projectId) && !empty($elementId)) {
    $skipUrl = '/uploaddisplayimage/'.$projectId.'/'.$elementId;
}
?>


<div class="TabbedPanelsContentGroup design_wrap width_665 m_auto ">
     <div class="TabbedPanelsContent member width635 m_auto clearb">
        <?php   
        echo form_open($baseUrl,$formAttributes); 
        echo form_input($elementEntityIdField);
        ?>
            <div class="c_1 clearb mb15 mt25">
               <ul class="form_img">
                   <li class="">
                     <h4 class="red fs21  bb_aeaeae width635"><?php echo $this->lang->line('addTitle')?>*</h4>
                     <span class="red fs13 pl10 fshel_midum">1 - 15 words </span> 
                     <span class="red fr pr10 fs13 fshel_midum"> <span id="titleLimit"><?php echo str_word_count($titleValue);?></span>  <span>words</span> </span>
                     <?php echo form_input($titleInput);?>
                  </li>
                  <?php if($sectionId == '3:2') { ?>
                      <li class="">
                         <h4 class="red fs21  bb_aeaeae width635"><?php echo $this->lang->line('subjectTitle')?>*</h4>
                         <span class="red fs13 pl10 fshel_midum">1 - 15 words </span> 
                         <span class="red fr pr10 fs13 fshel_midum"> <span id="subjectLimit"><?php echo str_word_count($articleSubjectValue);?></span>  <span>words</span> </span>
                         <?php echo form_input($articleSubjectInput);?>
                      </li>
                  <?php }?>
                  <li>
                     <h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('writeArticle')?></h4>
                    <div class="editor_wrap">
                        <?php echo form_textarea($articleInput); ?>
                    </div>
                  </li>
                  <li>
                     <h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('tagWords')?>*</h4>
                     <span class="red pl10 fs13 fshel_midum">3 - 25 words</span> 
                     <span class="red pr10 fr fs13 fshel_midum"><span id="tagLimit"><?php echo str_word_count($tagWordsValue);?></span>  <span>words</span> </span></label>
                      <?php echo form_textarea($tagWords); ?>
                  </li>
               </ul>
            </div>
        <?php echo form_close();?>
        <!-- Form buttons -->
        <?php 
        // set back page
        //$data['backPage'] = '/setdisplayimage/'.$projectId.'/'.$elementId;
        // set skip page
        $data['skipPage'] =  $skipUrl;
        // set next form name
        $data['formName'] = 'newsReviewForm';
        
        $this->load->view('common_view/upload_buttons',$data);
        ?>
     </div>
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
        $("#newsReviewForm").validate({
            submitHandler: function() {
                var fromData=$("#newsReviewForm").serialize();
                $.post('<?php echo $baseUrl.'/savenewsnreviews/'.$projectId.'/'.$elementId;?>',fromData, function(data) {
                    if(data){
                        if(data.nextStep != '') {
                            window.location.href = '<?php echo $baseUrl ?>' + data.nextStep;
                        } else {
                            window.location.href = window.location.href; 
                        }
                    }
                }, "json");
            }
        });
    });
</script>
