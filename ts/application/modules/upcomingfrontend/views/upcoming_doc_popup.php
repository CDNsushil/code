<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php //echo '<pre />';print_r($promoMedias);echo count($promoMedias);die;

	$file = getImage(@$promoMedias[0]['filePath'].@$promoMedias[0]['fileName']);
	$fileType = 2;
	$duration = 5;
	
	$imgDetail = getMediaDetail(@$promoMedias[0]['thumbFileId']);				
				
				if(is_array($imgDetail) && !empty($imgDetail))
				{
					$thumbPromoImgPath = $imgDetail[0]->filePath;
					$thumbPromoImgName = $imgDetail[0]->fileName;
				}else
				{
					$thumbPromoImgPath = '';
					$thumbPromoImgName = '';
				}							
				$thumbFinalPromoImg = getImage($thumbPromoImgPath.'/'.$thumbPromoImgName,$this->config->item('defaultDocImg'));

?>

<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
    <div class="cream_gradient width_776">
      <!--top_title-->
      <div class="seprator_30"></div>
      <!--text box-->
      <div class="trans_bdr_box ml52 mr52">
        <!---<div class="bg_222222 pt25 pl20 pr20 pb25 font_opensans">-->
         <div class="bg_222222 font_opensans">
          <?php
			
			/* Old code
			 * $mediaArray['mediaId']=$promoMedias[0]['fileId'].'_full';  // media file Id
			$mediaArray['loginUserID']=isLoginUser(); // login user Id
			$mediaArray['entityID']=$mediaEntityID; // entity Id
			$mediaArray['elementID']=$promoMedias[0]['projId']; //element id
			$mediaArray['projectID']=$promoMedias[0]['projId']; // project id
			//echo Modules::run("player/getPlayer", $mediaArray); */
			
			$mediaId = $promoMedias[0]['fileId'];
			$entityID = $mediaEntityID;
			$elementID = $promoMedias[0]['projId'];
			$projectID = $promoMedias[0]['projId']; 
		?>
		
		 <iframe src="<?php echo base_url().'en/player/getPlayerIframe/'.$mediaId.'_full/'.$entityID.'/'.$elementID.'/'.$projectID; ?>" width="652" height="400"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>
        </div>
      </div>
      <div class="seprator_30"></div>
      <!--text box-->
      <div class="up_partition_shadow pt24">
        <div class="row ml52 mr52">
          <div class="cell mr24">
            <div class="up_popup_book_thumb global_shadow">
              <div class="AI_table">
                <div class="AI_cell"><img class="max_h223_w142 bdr_8e8e8e" src="<?php echo $thumbFinalPromoImg;?>"></div>
              </div>
            </div>
          </div>
          <div class="cell ml14 width_490">
            <div class="up_popup_titlebottom"><?php echo @$promoMedias[0]['mediaTitle'];?></div>
            <div class="pt15">
              <p><?php echo changeToUrl($promoMedias[0]['mediaDescription']);?></p>
            </div>
          </div>
          <div class="clear"></div>
        </div>
      </div>
      <div class="seprator_40"></div>
    </div>
  
