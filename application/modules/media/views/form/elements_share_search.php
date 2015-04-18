<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = formBaseUrl(); 
// set share page url
$share = (!empty($isShareMenu))?'share':'email';
$shareUrl = $baseUrl.'/'.$share.'/'.$projectId;?>
<div class=" popupBoxWp" id="popupBoxWp" >
    <div class="popup_box" id="popup_box">
        <div class="select_popup bg_fff">
            <div class="shiping_csroll ">
                <div class="close_btn position_absolute" onClick="$(this).parent().trigger('close')" id="popup_close_btn"></div>
                <div class="row defaultP width100_per pr0 clearbox share_popup">
                    <div class="width640 m_auto">
                        <?php if(!empty($sampleNTrailData)) { ?>
                            <div class="row ">
                                <?php 
                                foreach($sampleNTrailData as $sampleNTrailData) { 
                                    $elementTypeHead = ($sampleNTrailData->elementType == 1) ? 'SAMPLE' : 'TRAILER';
                                    // get element image
                                    $elementImage = getElementImage($sampleNTrailData->displayImageType,$sampleNTrailData->imagePath,$indusrty);
                                    // set title
                                    $title = (!empty($sampleNTrailData->title))?$sampleNTrailData->title:'Untitled';?>
                                    <!-- ======= box ======== -->
                                    <div class="fl  sah_box">
                                        <h5 class="red pl5 font_bold pb8 fs13"><?php echo $elementTypeHead;?></h5>
                                        <div class="bdrcece bg_f3 display_table share_box">
                                            <div class="table_cell radio_wrap  ">
                                                <input name="elementId" type="radio" value="<?php echo $sampleNTrailData->elementId?>"  />
                                            </div>
                                            <div class="table_cell share_thumb">
                                                <img src="<?php echo  $elementImage ;?>"  alt="" />
                                            </div>	
                                            <div class="display_table  mt4 ">
                                                <p class="blc4c4c4 table_cell height38 pl10">
                                                    <?php echo getSubString(html_entity_decode($title),35);?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php 
                                } ?>
                             </div>
                            <hr class="bb_F1592A mt0 mb10" />
                        <?php 
                        } ?>
                        
                        <div id="searchResultDiv">
                            <?php
                            if($searchResult) {
                                echo $searchResult;
                            } else {
                                echo '<div class="p15">search result will come here</div>';
                            } ?>
                        </div>
                       
                        <div class="clearb row mt30 mb15">
                            <button class="bg_f1592a fr" id="searchSelect"> Select</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
 $(document).ready(function() {
     
    $('#searchSelect').click(function() {
        // get checked project element id
        var projElementId = $('input:radio[name=elementId]:checked').val();
        if(projElementId != '' && projElementId != undefined) {
            window.location.href = '<?php echo $shareUrl;?>'+'/'+projElementId;
            /*fromData = 'elementId='+projElementId+'&industry=<?php echo $industry;?>'+'&projectId=<?php echo $projectId;?>';
            $.post(baseUrl+language+'/media/getelementshortlink',fromData, function(data) {
                if(data) {
                    $('#getElementShortLink').val(data);
                     $("#elementtoolbox").attr("addthis:url",data);
                    $('#popup_close_btn').parent().trigger('close');
                }
            });*/
        } else {
            alert('Please select element first!');
            return false;
        }
    });
     
    radioCheckboxRender();
 });
</script>
