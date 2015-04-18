<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$collectionPageLink  =  base_url_lang();
$deletedPageLink     =  base_url_lang();

?>
<div class="row content_wrap" >
   <div class="bg_f3f3f3 fl width100_per title_head">
      <h1 class="fs30 letrP-1 opens_light mb0  fl pl25  textin30"><?php echo $this->lang->line('upcomingMediaShowcase'); ?></h1>
        <?php /* if($loggedUserId) {?>
            <ul class="dis_nav fs16 mt25 fr pr30">
                <li class="<?php echo isset($navigationMenu1)?"active":""; ?>">
                    <a href="<?php echo $collectionPageLink; ?>"><?php echo $this->lang->line('_collections_navi'); ?></a>
                </li>
                <li class="<?php echo isset($navigationMenu2)?"active":""; ?>">
                    <a href="<?php echo $deletedPageLink; ?>"><?php echo $this->lang->line('_deleted_expired_navi'); ?></a>
                </li>
            </ul>
        <?php } */ ?>
   </div>
   
	<div class="m_auto sc_list clearb pt30 pl30 pr30 pb30" id="showmedialisting">
		<?php
		if(!empty($projectListingData)) {
			echo $projectCollectionResult;
		} else {
			echo '<h4 class="fs18">No record available for your selection.</h4>';
		}
		?>
	</div>
   
</div>


