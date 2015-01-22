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
		<!------<div class="bg_222222 pt25 pl20 pr20 pb25 font_opensans">--->  
      
          <?php
          
			//echo "mediaId=".$mediaId;
			//$mediaId=4166;
			//echo $mediaId = @$promoMedias[0]['fileId'].'_full'; // patter is like mediaId_mediaType mediaType can be clip/ full
			/*$mediaArray['mediaId']=$mediaId.'_full';  // media file Id
			$mediaArray['loginUserID']=isLoginUser(); // login user Id
			$mediaArray['entityID']=$entityID; // entity Id
			$mediaArray['elementID']=$elementID; //element id
			$mediaArray['projectID']=$projectID; // project id
			$mediaArray['width']='610'; // width
			$mediaArray['height']='400'; // height
			echo Modules::run("player/getPlayer", $mediaArray); */
			
			//$mediaId = "4653";
		if(!isset($article) || $article=='' ){
		?>
			 <div class="bg_222222 font_opensans height_550">
			 <iframe src="<?php echo base_url().'en/player/getMainPlayerIframe/'.$mediaId.'_full/'.$entityID.'/'.$elementID.'/'.$projectID; ?>" width="652" height="550"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe> 
			 </div>
		<?php 
        }else 
        {
		?>
		<div class="bg_222222 clr_white p5">
			<?php 
			  echo $article;
			?>
		</div>
		<?php
		} 
	    ?>       
      </div>
      <div class="seprator_30"></div>
      <!--text box-->
      <div class="up_partition_shadow pt24">
        <div class="row ml52 mr52">
          <div class="cell mr24">
            <div class="up_popup_book_thumb global_shadow">
              <div class="AI_table">
                <div class="AI_cell"><img class="max_h223_w142 bdr_8e8e8e" src="<?php echo $imagePath;?>"></div>
              </div>
            </div>
          </div>
          <div class="cell ml14 width_490">
            <div class="up_popup_titlebottom"><?php echo $title;?></div>
            <div class="pt15">
              <p><?php echo changeToUrl($description);?></p>
            </div>
          </div>
          <div class="clear"></div>
        </div>
      </div>
      
      <div class="seprator_40"></div>
      
    </div>
 
