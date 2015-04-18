<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//add preview word if preview mode is active
$previewWord =  (previewModeActive())?"/preview":"";
    
$collectionPageLink  =  base_url_lang('mediafrontend/'.$navigationLink1.'/'.$loggedUserId.$previewWord);
$deletedPageLink     =  base_url_lang('mediafrontend/'.$navigationLink2);

?>
<div class="row content_wrap" >
   <div class="bg_f3f3f3 fl width100_per title_head">
      <h1 class="fs30 letrP-1 opens_light mb0  fl pl25  textin30"><?php echo $this->lang->line($industryType.'_collections'); ?></h1>
        <?php if($loggedUserId) {?>
            <ul class="dis_nav fs16 mt25 fr pr30">
                <li class="<?php echo isset($navigationMenu1)?"active":""; ?>">
                    <a href="<?php echo $collectionPageLink; ?>"><?php echo $this->lang->line($industryType.'_collections_navi'); ?></a>
                </li>
                <li class="<?php echo isset($navigationMenu2)?"active":""; ?>">
                    <a href="<?php echo $deletedPageLink; ?>"><?php echo $this->lang->line($industryType.'_deleted_expired_navi'); ?></a>
                </li>
            </ul>
        <?php } ?>
   </div>
   <div class="m_auto sc_list clearb pt30 pl30 pr30 pb30" id="showmedialisting">
        <?php
            //---------media project list view call-----------//
                $this->load->view($innerViewName);
            //---------media project list view call-----------//
        ?>
   </div>
</div>


