<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes =   array(
    'name' =>  'editCollectionForm',
    'id'   =>  'editCollectionForm'
);
// set base url
$baseUrl = formBaseUrl();
?>
<div class="wizard_wrap">
    <div class="width900 m_auto display_table">
        <h3 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('selectMediaElementToEdit');?></h3>
        <div class="sap_45"></div>
        <?php echo form_open($baseUrl.'/editproject/',$formAttributes); ?>
            <ul class="edit_select_video defaultP">
            <?php 
            if(!empty($elementList) && count($elementList)>0) {
                foreach($elementList as $elementData) {
                    // get element image
                    $elementImage = getElementImage($elementData->displayImageType,$elementData->imagePath,$indusrtyName);?>
                    <li class="video_block">
                        <div class="table_cell">
                             <img alt="" src="<?php echo $elementImage;?>">
                            <div class="thum_text">
                                <div class="rate_wrap">
                                   <input type="radio" id="elementId" class="check_img ez-hide" name="elementId" value="<?php echo $projectId.'_'.$elementData->elementId;?>">
                                      <div class="font_bold title_edit text_alighL fl "> <?php echo getSubString(html_entity_decode($elementData->title),35);?></div>    
                                </div>
                            </div>
                        </div>
                    </li>
                <?php 
                }  
            } else {
                echo '<h4 class="fs18">No record available for your selection.</h4>';
            }?>
            </ul>
       <?php echo form_close();?>
        <div class="sap_50"></div>
        <div class=" fs14 fr btn_wrap display_block font_weight">
            <a href="<?php echo base_url(lang().'/media/'.$indusrtyName.'/'.$projectId);?>">
                <button type="button" class="bg_ededed bdr_b1b1b1 mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Cancel</span></button>
            </a>
            <?php  if(!empty($elementList) && count($elementList)>0) { ?>
                <button type="button" id="nextBtn" class="b_F1592A next_edit bdr_F1592A ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Next</span></button>
            <?php } ?>
        </div>
        <div class="sap_25"></div>
    </div>
</div>
<script>
    // manage project edit page url
    $('#nextBtn').click(function() {
        // get checked project element id
        var projElementId = $('input:radio[name=elementId]:checked').val();
        if(projElementId != '' && projElementId != undefined) {
            window.location = '<?php echo $baseUrl?>'+'/editprojectelement/'+projElementId;
        } else {
            alert('Please select element first!');
            return false;
        }
    });
</script>
