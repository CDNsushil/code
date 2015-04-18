<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="viewport scroll_container03">
  <ul class="overview" style="height: 1422px; top: 0px;">
				  
<?php					
		$countLi = 0;  // No need to reset $countLi
		$countImg = 0;  // Need to reset $countImg when $countLiMod3 == Zero
		$countrecord = 0;  // Need to reset $countImg when $countLiMod3 == Zero
		$remCountImg = 0;  // Need to reset $remCountImg 
		 
		
		$openLi = '<li class="row">';  // Only assign once
		$closeLi = '</li>';  // Only assign once

		$seperatorLi = '<div class="seprator_14 clear"></div>';  // Only assign once
		unset($promoImages['activeRecord']);
		$totalImages = count($promoImages);		
		$rem = $totalImages%$this->config->item('maxUPImages');
		$remCountImg = $rem;
		$remSpace4Img = ($this->config->item('maxUPImages') - $rem);		
		//echo 'media title:<pre />';print_r($promoImages);
		
		foreach($promoImages as $upcomingPromoImg)
		{	
			
			$countLi++;
			$countImg++;
			$countrecord++;
			
			if($countLi ==1) echo $openLi;
			
			if ($countImg%2 == 0) $marginDiv = 'ml20 mr20';
			else $marginDiv = '';
			if($upcomingPromoImg['noMedia']==1) $maxHW = 'max_w138_h96 p10';//when no media found
			else $maxHW = 'max_h145_w200';
			
	  ?>    	
	  <div class="cell <?php echo $marginDiv;?>">
		<div class="up_gallery_thumb_box "><div class="AI_table"><div class="AI_cell"><img src="<?php echo $upcomingPromoImg['thumbFinalImg_s'];?>" class="<?php echo $maxHW;?> bdr_cecece ptr" onclick="openLightBox('popupBoxWp','popup_box','/upcomingfrontend/popupimages','<?php echo $upcomingPromoImg['projId'];?>','<?php echo $countrecord;?>');"></div>
		
		<!--"openLightBox('popupImages','popupImagesContainer','/upcomingfrontend/popupimages','<?php echo $upcomingPromoImg['projId'];?>','<?php echo $countrecord;?>');"-->
		</div></div>
		<div class="up_gallery_title"><?php echo getSubString($upcomingPromoImg['mediaTitle'],50);?></div>
	  </div>	  
      <?php        
			if ($countLi%3 == 0) {
				$countImg=0;
				if($countLi == $totalImages){
					echo $seperatorLi;
				if($remSpace4Img==0) 
					echo $closeLi;
				}
				else
					echo $seperatorLi . $closeLi . $openLi;
			}
			if($countLi == $totalImages && $remSpace4Img<6){		
			//To show blank iamges for remaining space
			//echo '<br />maxUPImages:'.$this->config->item('maxUPImages').' , remSpace4Img:'.$remSpace4Img;
			$remCountImg=$totalImages%3;
			
			for($remCount=$totalImages;$remCount<=$this->config->item('maxUPImages')-1;$remCount++) {
			//echo 'remCount:'.$remCount;				
			$remCountImg++;
			
			if ($remCountImg%2 == 0 && $remCountImg%3 != 0) $remMarginDiv = 'ml20 mr20';
			else $remMarginDiv = '';
				
			if($remCountImg == 1 || $remSpace4Img==0) echo $openLi;
		?>
			<div class="cell <?php echo $remMarginDiv;?> opacity_2">
			<div class="up_gallery_thumb_box "><div class="AI_table"><div class="AI_cell"></div>
			</div></div>
			<div class="up_gallery_title">&nbsp;</div>
			</div>
	  
			<?php			  
			   $newLi = $remCountImg;  
			  				
				if (($remCountImg)%3 == 0) {
					$remCountImg=0;  	
					if($remCount == $this->config->item('maxUPImages')-1)
						echo $seperatorLi . $closeLi;
					else
						echo $seperatorLi . $closeLi;
				}			   	
			}						
		}	
	//}//if isset mediaId
	}//End Foreach
			
	?>
	
 </ul>
</div>
