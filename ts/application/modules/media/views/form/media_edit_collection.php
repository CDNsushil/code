<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 


// set base url
$baseUrl = formBaseUrl();
// set next project view page url
$nextPageURL = $baseUrl.'/editproject/';
if(isset($isPubliciseSection) && !empty($isPubliciseSection)) {
    $nextPageURL = $baseUrl.'/publiciseproject/';
}
?>
<div class="wizard_wrap">
    <div class="width900 m_auto display_table">
        <h3 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('selectMediaToEdit');?></h3>
        <div class="sap_45"></div>
            <div id="searchResultDiv">
                <?php
                $projRecords = (array)$projList; //  cast object to an array
                if(!empty($projRecords)) {
                    echo $mediaCollectionResult;
                } else {
                    echo '<h4 class="fs18">No record available for your selection.</h4>';
                }?>
            </div>
      
        <div class="sap_50"></div>
        <div class=" fs14 fr btn_wrap display_block font_weight">
            <a href="<?php echo $baseUrl;?>">
                <button type="button" class="bg_ededed bdr_b1b1b1 mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Cancel</span></button>
            </a>
            <?php if(!empty($projRecords)) { ?>
                <button type="button" id="nextBtn" class="b_F1592A next_edit bdr_F1592A ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Next</span></button>
            <?php } ?>
        </div>
        <div class="sap_25"></div>
    </div>
</div>
<script>
    // manage project edit page url
    $('#nextBtn').click(function() {
        var projId = $('input:radio[name=projectId]:checked').val();
        if(projId != '' && projId != undefined) {
            window.location = '<?php echo $nextPageURL;?>'+projId;
        } else {
            alert('Please select project first!');
            return false;
        }
    });
</script>
