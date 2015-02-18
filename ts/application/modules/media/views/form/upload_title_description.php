<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    
$formAttributes = array(
    'name'=>'titleDescForm',
    'id'=>'titleDescForm',
);

// set Collection Title 
$projNameValue = set_value('projName')?set_value('projName'):$elementDetails->title;
$albumTitle       =   array(
    'name'        =>  'albumTitle',
    'id'          =>  'albumTitle',
    'class'       =>  'required width527 min-height_25 mt14 bdr_adadad',
   // 'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  set_value('projName')?set_value('projName'):string_decode($elementDetails->title),
    'wordlength'  =>  "1,15",
    'onkeyup'     =>  "checkWordLen(this,15,'titleLimit')",
    'placeholder' =>  "Album Title",
    'onBlur'      =>  "placeHoderHideShow(this,'Album Ttile','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Album Ttile','hide')"
);

$projDescProjValue = set_value('projDescriptionProject')?set_value('projDescriptionProject'):$elementDetails->description;
$projDescProjValue = htmlentities($projDescProjValue);

$projDescriptionProject = array(
    'name'        =>  'projDescription',
    'id'          =>  'projDescription',
    'class'       =>  'font_wN width_615 height_215 bdr_adadad mt13',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($projDescProjValue),
    'wordlength'  =>  "0,200",
    'onkeyup'     =>  "checkWordLen(this,200,'descLimit')",
    'placeholder' =>  "Description ",
    'onBlur'      =>  "placeHoderHideShow(this,'Description','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Description','hide')"
);

$tagWordsValue = set_value('projTag')?set_value('projTag'):$elementDetails->tags;
$tagWordsValue = htmlentities($tagWordsValue);

$tagWords = array(
    'name'        =>  'projTag',
    'id'          =>  'projTag',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt16 height51',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($tagWordsValue),
    'wordlength'  =>  "3,25",
    'onkeyup'     =>  "checkWordLen(this,25,'tagLimit')",
    'placeholder' =>  "Tag Words",
    'onBlur'      =>  "placeHoderHideShow(this,'Tag Words','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Tag Words','hide')"
);

$elementEntityIdField = array(
    'name'	=> 'elementEntityId'.$browseId,
    'value'	=> $elementEntityId,
    'id'	=> 'elementEntityId'.$browseId,
    'type'	=> 'hidden'
);

$baseUrl = formBaseUrl();
// set skip url
$skipUrl = '/uploadimageinfo/'.$projectId.'/'.$elementId;
if($ispriceShippingCharge == 1 || $ispriceShippingCharge == 3) {
    $skipUrl = '/priceshippingcharge/'.$projectId.'/'.$elementId;
} elseif($ispriceShippingCharge == 2) {
    $skipUrl = '/shippingcharge/'.$projectId.'/'.$elementId;
}
?>
   
<div class="TabbedPanelsContentGroup design_wrap width_665 m_auto ">
     <div class="TabbedPanelsContent member width635 m_auto clearb">
        <?php   
        echo form_open($baseUrl.'/settitlendescription/'.$elementId,$formAttributes); 
        echo form_input($elementEntityIdField);
        ?>
            <div class="c_1 clearb mb15 mt25">
               <ul class="form_img">
                  <li class="">
                     <h4 class="red fs21  bb_aeaeae width635"><?php echo $uploadTitle;?> </h4>
                     <span class="red fs13 pl10 fshel_midum">1 - 15 words </span> 
                     <span class="red fr pr10 fs13 fshel_midum"> <span id="titleLimit"><?php echo str_word_count($projNameValue);?></span>  <span>words</span> </span>
                     <?php echo form_input($albumTitle);?>
                  </li>
                  <li>
                     <h4 class="red fs21  bb_aeaeae"> Description</h4>
                     <span class="red pl10 fs13 fshel_midum ">0 - 200 words</span>
                      <span class="red pr10 fr fs13 fshel_midum"><span id="descLimit"><?php echo str_word_count($projDescProjValue);?></span>  <span>words</span> </span></label>
                     <?php echo form_textarea($projDescriptionProject); ?>
                  </li>
                  <li>
                     <h4 class="red fs21  bb_aeaeae"> Tag Words* </h4>
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
        $backPage = '/setdisplayimage/'.$projectId.'/'.$elementId;
        if($indusrtyName == 'photographyNart') {
            $backPage = '/uploadfile/'.$projectId.'/'.$elementId;
        }
        // set back page
        $data['backPage'] = $backPage;
        if(!empty($tagWordsValue) && !empty($projNameValue)) {
            // set skip page
            $data['skipPage'] = $skipUrl;
        }
        // set next form name
        $data['formName'] = 'titleDescForm';
        
        $this->load->view('common_view/upload_buttons',$data);
        ?>
     </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#titleDescForm").validate({
            submitHandler: function() {
                var fromData=$("#titleDescForm").serialize();
                $.post('<?php echo $baseUrl.'/uploadtitlepost/'.$projectId.'/'.$elementId;?>',fromData, function(data) {
                    if(data){
                        window.location.href = '<?php echo $baseUrl ?>' + data.nextStep;
                    }
                }, "json");
            }
        });
    });
</script>
