<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if(!empty($promo_images)){ ?>
 <div class="seprator_10"></div>
  <div class="scroll_box mt10 darkGrey_bg global_shadow bdr_d2d2d2">
            <div class="clr_white font_size14 pl20 mt10"><b><?php echo $this->lang->line('images');?></b></div>
            
            <div class="slider scroll_light_btn" id="slider1"> <a href="#" class="buttons prev mr12 disable"></a>
              <div class="viewport WorkS_scroll_container">
                <ul class="overview" style="height: 798px; top: 0px;">
				<?php
                 	$openLi = '<li>';  // Only assign once
					$closeLi = '</li>';  // Only assign once
					
					$popup_images['promo_images'] = $promo_images;										  
				    $popup_images = $this->load->view('popup_images',$popup_images, true);
				   
					foreach($promo_images as $count_promo_images => $promoImagesDetail)
					{ 
					
					if(isset($promoImagesDetail['mediaId']) && @$promoImagesDetail['mediaId']>0)
					{															
					if($promoImagesDetail['noMedia']==1) $maxHW = 'max_w84_h84 p10';//when no media found
					else $maxHW = 'max_w202_h110';
					
					echo $openLi;
					?> 
					<a class="ptr"  onclick="openLightBox('popupBoxWp','popup_box','/workshowcase/popupimages','<?php echo $promoImagesDetail['workId'];?>','<?php echo $count_promo_images;?>','<?php echo $workType;?>');"> 
					<div class="row position_relative Work_recent_box_wrapper">
                      <div class="work_Sthumb thumb_absolute01">
                        <div class="AI_table">
                          <div class="AI_cell"><img border="0" class="<?php echo $maxHW;?> bdr_bebebe " src="<?php echo @$promoImagesDetail['thumbFinalImg_s'];?>" /> </div>
                        </div>
                      </div>
                      <div class="ml190 pr10">
                        <div class="intro_media_title minH15 hoverOrange"><?php echo getSubString(@$promoImagesDetail['mediaTitle'],32);?></div>
                        <div class="line1"></div>
                        <div class="pt5 minHeight60px"><?php echo getSubString(@$promoImagesDetail['mediaDescription'],80);?></div>
                       
                        <a class="Fright orange_color mt_minus11 gray_clr_hover"  onclick="openLightBox('popupBoxWp','popup_box','/workshowcase/popupimages','<?php echo $promoImagesDetail['workId'];?>','<?php echo $count_promo_images;?>','<?php echo $workType;?>');">View</a> </div>
                      <div class="clear"></div>
                    </div>
                  </a>
                 <?
					echo $closeLi;
					}
					}	
				                       
                ?>
                </ul>
                <script>
					var popup_images=<?php echo json_encode($popup_images);?>;
				</script>
              </div>
              <a href="#" class="buttons next mr12"></a> </div>
              
  <div class="seprator_6"></div>
  </div>         
<?php }else echo ' <div class="seprator_2"></div>'; ?>
