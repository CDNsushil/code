<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    // set project cover image
    $getProjectCoverImage = getProjectCoverImage($projData->projId,'_b',1);
    // set base url
    $baseUrl = formBaseUrl();
    // set rating avg image
    $ratingAvg = roundRatingValue($ratingAvg);
    $ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';
    // set delete redirect url
    $deleteRedirect = $baseUrl.'/publicisemediacollection';
    // set cover image edit url
    $editCoverLink = $baseUrl.'/selectcoverimage/'.$projData->projId;
    // set publish url
    $publishLink = $baseUrl.'/publicise/'.$projData->projId;
    // set add element url
    $addElement = $baseUrl.'/uploadform/'.$projData->projId;
    // set showcase media url
    $mediaShowcaseUrl = base_url(lang().'/mediafrontend/mediashowcases/'.$userId.'/'.$projData->projId);
    // set links for news and review
    if($sectionId == '3:1' || $sectionId == '3:2') {
        // set cover image edit url
        $editCoverLink = $baseUrl.'/newsreviewcoverimage/'.$projData->projId.'/'.$elementId;
        // set publish url
        $publishLink = $baseUrl.'/publishcollection/'.$projData->projId.'/'.$elementId;
        // set add element url
        $addElement = $baseUrl;
        // set showcase media url
        $mediaShowcaseUrl = base_url(lang().'/mediafrontend/writingpublishing/'.$userId.'/'.$projData->projId.'/'.$indusrtyName);
    }
?>
<div class="wizard_wrap fs14 ">
    <div class="width900 m_auto display_table">
        <!-- left wrap start-->
        <div class="sap_30"></div>
        <div class="widht_300 lineH18 fl mr40">
            <div class="head_list fl pt8 pb7 pl13 width_273  bg_fdfdfd bdr_ececec ">
                <div class="fl color_666">
                    <div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
                    <div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
                    <div class="fl mr5 mt6">
                       <img  src="<?php echo base_url($ratingImg);?>" />
                    </div>
                    <div class="btn_share_icon"><?php echo $reviewCount;?></div>
                </div>
            </div>
            <div class="sap_35"></div>
            <div class="clearbox mt3">
                <p class="red"> MEMBERSHIP STORAGE SPACE</p>
                <b><?php echo $remainingSize .' of '. $containerSize?></b>
            </div>
            <div class="sap_30"></div>
            <a href="<?php echo $baseUrl.'/membershipcart/'.$projData->projId;?>">
                <button class="height40 fs13 pl30 pr30 white_button" type="button" role="button" aria-disabled="false">
                    <span class="ui-button-text">Add Space</span>
                </button> 
            </a>
            <div class="sap_30"></div>
            <b>Collection Contains</b>
            <ul class="edit_list">
                <?php  if($sectionId != '3:1' && $sectionId != '3:2') { ?>
                    <li class="pt8"><b class="red price"><?php echo $downloadFiles;?></b>  <?php echo $fileFormateNames['fileType'];?></li> 
                    <li><b class="red price"><?php echo $nonDownloadFiles;?></b>  <?php echo $fileFormateNames['fileShipped'];?>'s</li>
                <?php } else { ?>
                    <li class="pt8"><b class="red price"><?php echo $newsreviewCount;?></b>  <?php echo $this->lang->line('collectionElement');?></li> 
                <?php } ?>
            </ul>
            <div class="sap_30"></div>
           <?php  if(!isset($isPubliciseSection)) { ?>
                <a href="<?php echo $publishLink;?>">
                    <button class="red pl15 pr15 white_button bdr_a0a0a0" type="button" role="button" aria-disabled="false"><span class="ui-button-text">Hide Collection from Showcase</span></button> 
                </a>
                <div class="sap_30"></div>
            <?php 
                // set delete redirect url
                $deleteRedirect = $baseUrl.'/editmediacollection';
            } ?>
            <?php if($projData->isBlocked == 't') { ?>
            <div class="alert_box bdr3_ee242c">
                <p>	Another member of Toadsquare has declared that they believe that the material <b class="red">&lt; INSERT TITLE OF ITEM &gt;</b> is illegal. Please see your email and Tmail for more details.</p>
                <div class="sap_20"></div>
                <p>Access to this material has been suspended.</p>
            </div>
            <?php } ?>
        </div>
        <!-- left wrap end-->
        
        <!-- right wrap start-->                              
        <div class="right_wrap fl edit_al width_485">
            <h4 class="fs21"><?php echo $projData->projName;?><br><?php echo $projData->projShortDesc;?></h4>
            <div class="sap_20"></div>
            <div class="edit_vedio bg_f5f5f5 bb_b7b7b7	">
              <div class="display_table edit_vedio_thumb"> <div class="table_cell">  <img alt="" src="<?php echo $getProjectCoverImage;?>"></div> </div> 
                <ul class="fs18 ml106 pl45 mt46 ">
                    <?php  if($sectionId != '3:1' && $sectionId != '3:2') { ?>
                        <li>
                            <a href="<?php echo $baseUrl.'/publicise/'.$projData->projId;?>">
                                <?php echo $this->lang->line('editMediaPublish');?>
                                <span class="red pl5"> &gt;</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo $addElement;?>">
                            <?php echo $this->lang->line('editMediaAddAnFile');?>
                            <span class="red pl5"> &gt;</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $baseUrl.'/editmediaelements/'.$projData->projId;?>">
                            <?php echo $this->lang->line('editMediaEditAnFile');?>
                            <span class="red pl5"> &gt;</span>
                        </a>
                    </li>
                    <?php
                    if($sectionId != '3:1' && $sectionId != '3:2') {
                        if($sectionId == 1) { 
                            if(!empty($isTrailer)) { 
                               echo  '<li><a href="'.$baseUrl.'/addtrailerorsamplefile/'.$projData->projId.'/2">'.$this->lang->line('editMediaAddTrailer').'<span class="red pl5"> &gt;</span></a></li>';
                            } else {
                                echo  '<li><a href="'.$baseUrl.'/uploadform/'.$projData->projId.'/'.$trailerElementId.'">'.$this->lang->line('editMediaEditTrailer').'<span class="red pl5"> &gt;</span></a></li>';
                            } 
                        }
                        if($sectionId != 4) {
                            if(!empty($isSample)) {
                                echo '<li><a href="'.$baseUrl.'/addtrailerorsamplefile/'.$projData->projId.'/1">'.$this->lang->line('editMediaAddSample').'<span class="red pl5"> &gt;</span></a></li>';
                            } else {
                                echo '<li><a href="'.$baseUrl.'/uploadform/'.$projData->projId.'/'.$sampleElementId.'">'.$this->lang->line('editMediaEditSample').'<span class="red pl5"> &gt;</span></a></li>';
                            }
                        } 
                    } ?>
                    <li>
                        <a href="<?php echo $editCoverLink;?>">
                            <?php echo $this->lang->line('editMediaCoverPage');?>
                            <span class="red pl5">&gt;</span>
                        </a>
                    </li>
                    <?php  if($sectionId != '3:1' && $sectionId != '3:2' && $projData->projSellstatus == 't') { ?>
                        <li>
                            <a href="<?php echo $baseUrl.'/setupsales/'.$projData->projId;?>">
                                <?php echo $this->lang->line('editMediaSalesInfo');?>
                                <span class="red pl5"> &gt;</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if($projData->isPublished == 't') { ?>
                        <li>
                            <a href="<?php echo $mediaShowcaseUrl;?>">
                                <?php echo $this->lang->line('editMediaViewInShowcase');?>
                                <span class="red pl5"> &gt;</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="javascript:void(0);" onclick="deleteMediaCollection('<?php echo $projData->projId;?>');";>
                           <?php echo $this->lang->line('editMediaDeleteCollection');?>
                            <span class="red pl5"> &gt;</span>
                        </a>
                    </li>
                </ul>
                <div class="sap_30"></div>
            </div>
        </div>
        <!-- right wrap end-->
        <div class="sap_20"></div>
    </div>
</div>

<script>
/**
 * Remove Project from media collection
 */
function deleteMediaCollection(projId) {
    confirmBox("Do you really want to delete this project?", function () {
        var fromData='projId='+projId;
        $.post('<?php echo $baseUrl.'/deleteproject';?>',fromData, function(data) {
            window.location.href = '<?php echo $deleteRedirect;?>';
        },'json');
    });
}
</script>

