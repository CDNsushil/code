<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$editPageLink = formBaseUrl().'/editproject/'.$projectId;
?>


<div class="clearbox bg_e7e7 position_relative minheight_350 ">
  <div class="sap_45"></div>
  <a href="<?php echo $editPageLink; ?>"><div class="close_btn mt20 mr20 position_absolute"></div></a>
  <div class="width800 m_auto">
    <div class="sap_45"></div>
     <div class="select_session_wap" id="searchResultDiv">
        <?php
            $elementRecords = $elementRes; //  cast object to an array
            if(!empty($elementRecords)) {
                echo $elementCollectionResult;
            } else {
                echo '<h4 class="fs18">No record available for your selection.</h4>';
            }
        ?>
     </div>
   </div>
  <div class="sap_45"></div>
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
