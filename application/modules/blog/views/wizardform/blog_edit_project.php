<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    // get blog image url
	$blogImagePath = getBlogImage($blogData,0,'_b');
    // set base url
    $baseUrl = base_url(lang());
    // set rating avg image
    $ratingAvg = roundRatingValue($ratingAvg);
    $ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';
    //echo "<pre>";
    //print_r($blogData);die;
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
                       <img src="<?php echo base_url($ratingImg);?>" />
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
            <a href="<?php echo $baseUrl.'/blog/membershipcart/'.$blogData->projId;?>">
                <button class="height40 fs13 pl30 pr30 white_button" type="button" role="button" aria-disabled="false">
                    <span class="ui-button-text"><?php echo $this->lang->line('addSpace');?></span>
                </button> 
            </a>
            <div class="sap_30"></div>
                    
			<?php if( $blogData->isPublished == 't' ) { ?>
                <a href="<?php echo $baseUrl.'/blog/previewnpublishblog';?>">
                    <button class="red pl15 pr15 white_button bdr_a0a0a0" type="button" role="button" aria-disabled="false"><span class="ui-button-text">Hide Collection from Showcase</span></button> 
                </a>
                <div class="sap_30"></div>
            <?php } ?>
            <?php if($blogData->isBlocked == 't') { ?>
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
            <h4 class="fs21"><?php echo $blogData->blogTitle;?><br><?php echo $blogData->blogOneLineDesc;?></h4>
            <div class="sap_20"></div>
            <div class="edit_vedio bg_f5f5f5 bb_b7b7b7	">
              <div class="display_table edit_vedio_thumb"> <div class="table_cell">  <img alt="" src="<?php echo $blogImagePath;?>"></div> </div> 
                <ul class="fs18 ml106 pl45 mt46 ">
					<?php if($blogData->isPublished == 'f') { ?>
                        <li>
                            <a href="<?php echo $baseUrl.'/blog/previewnpublishblog';?>">
                                <?php echo $this->lang->line('publishYourBlog');?>
                                <span class="red pl5"> &gt;</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo $baseUrl.'/blog/addpost';?>">
                            <?php echo $this->lang->line('addAPost');?>
                            <span class="red pl5"> &gt;</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $baseUrl.'/blog/editposts';?>">
                            <?php echo $this->lang->line('editPosts');?>
                            <span class="red pl5"> &gt;</span>
                        </a>
                    </li>
             
                    <?php if($blogData->isPublished == 't') { ?>
                        <li>
                            <a href="<?php echo $baseUrl.'/blogshowcase/index';?>">
                                <?php echo $this->lang->line('blogViewInShowcase');?>
                                <span class="red pl5"> &gt;</span>
                            </a>
                        </li>
                    <?php } ?>
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

