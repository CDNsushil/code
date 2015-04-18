<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 $PIImageFlag=false;
 $LPIImageFlag=false;
$showPromoImages=0;
$showLaunchPromoImages=0;
if(isset($promotionalImages) && is_array($promotionalImages) && count($promotionalImages) > 0){
		$showPromoImages =1;
}
if(isset($launchPostPRImages) && is_array($launchPostPRImages) && count($launchPostPRImages) > 0 && isset($isPostLaunchImages) && $isPostLaunchImages){
	$showLaunchPromoImages=1;
}
 $CountPI=count($promotionalImages);
 $CountLPI=count($launchPostPRImages);

 $showLaunchDivClass=""; 
 $showPromoDivClass=""; 
 $ClassForTabLPI="";
 if($showPromoImages==1) $showLaunchDivClass="dn"; //promotional images is there then hide the launch iages for default
 if($showPromoImages==0) {$showPromoDivClass="dn";  $ClassForTabLPI="wp_tab_selected"; }//promotional images is there then hide the launch iages for default
if($showPromoImages==1 || $showLaunchPromoImages==1){
?>
			  
  <div class="<?php echo $promotionalClass?>">
	<ul  id="event_tabs_link"  class="wp_news_tab bdrL_white">
	 <?php if($showPromoImages==1) { 
		 $showLaunchDivClass="dn"; 
		 ?>
	  <li id="Evetab1" class="wp_tab width_100 wp_tab_selected clr_white bdrR_white dash_link_hover"> <?php echo $this->lang->line('images');?> </li>
	  <?php } ?>
	  <!--news_box_tab-->
	  <?php if($showLaunchPromoImages==1){ ?>
		  <li id="Evetab2" class="wp_tab width_206 clr_white bdrR_white <?php echo $ClassForTabLPI;?> dash_link_hover">Launch <?php echo $this->lang->line('images');?> </li>
		  <?php
		}
		?>
	  <!--review_box_tab-->
	</ul>
	<div>
	  <div id="Evetab01" class="<?php echo $showPromoDivClass;?>" >
		<div id="PIslider" class="slider eventL_scroll_btn_box">
		  <div class="seprator_10"></div>
		  <div class="position_relative">
			<div class="z_index_2 position_relative"> <a href="#" class="buttons next mr6"></a><a href="#" class="buttons prev disable"></a> </div>
			<!--FAKEDIV-->
			<div class="fakebtn z_index_1"> <span class="buttons next mr6"></span><span class="buttons prev "></span> </div>
		  </div>
		  <div class="viewport eventL_scroll_container">
			<ul class="overview">
			   <?php 
			  
				foreach($promotionalImages as $PIkey=>$PI){
					if(($PIkey > 0)&& ($PIkey%3==0)){
							echo "</li><li>";
					}
					elseif(($PIkey%3)==0){
						echo "<li>";
					}
					
					$OrgPIImage=rtrim($PI['filePath'], '/').'/'.$PI['fileName'];
					$PIImage = addThumbFolder($OrgPIImage,$suffix='_s',$thumbFolder ='thumb',$this->config->item('eventImage'));
					
					if(!empty($OrgPIImage)){
						$PIImageFlag=true;
						$PIMediumImage = addThumbFolder($OrgPIImage,$suffix='_b',$thumbFolder ='thumb');
					if(file_exists($PIMediumImage)){
						$PIImage = getImage($PIImage,$this->config->item('eventImage'));
						$PIMediumImage = getImage($PIMediumImage,$this->config->item('eventImage'));
						$defaultClassShowImage ="max_w157_h108 bdr_bebebe ";
					}else{
						$PIImage = getImage('',$this->config->item('defaultNoMediaImg'));
						$PIMediumImage = getImage('',$this->config->item('defaultNoMediaImg'));
						$defaultClassShowImage ="max_w84_h84 p10 bdr_bebebe";
					}
					
					$mediaId = $PI['mediaId'];
					$mediaTitle = $PI['mediaTitle'];
					$mediaDescription = $PI['mediaDescription'];
					$mediaDescription = ($mediaDescription=='')?' ':nl2br($mediaDescription);

					$imageSliderInfo[] = array(
						'id'=>$mediaId,
						'image'=>$PIMediumImage,
						'title'=>string_decode($mediaTitle),
						'description'=>string_decode($mediaDescription)
					);
					
					?>
						<a  href="javascript:imageSlider(imageSliderInfo,'<?php echo $PIkey; ?>')"><div class="row position_relative Work_recent_box_wrapper dash_link_hover">
						  <div class="work_Sthumb thumb_absolute01">
							<div class="AI_table">
							  <div class="AI_cell"><img border="0" src="<?php echo $PIImage?>" class="<?php echo  $defaultClassShowImage; ?> "> </div>
							</div>
						  </div>
						  <div class="ml190 pr10 pr">
							<div class="intro_media_title max_h_32 ptr hoverOrange" onclick="javascript:imageSlider(imageSliderInfo,'<?php echo $PIkey; ?>');"><?php echo getSubString($mediaTitle,60);?></div>
							<div class="clear"></div>
							<div class="line1"></div>
							<div class="pt5 height_60"><?php echo changeToUrl(getSubString($mediaDescription,100));?></div>
							<span class="pa left_223 top_98 orange_color gray_clr_hover"><?php echo $this->lang->line('view');?>
							</span> </div>
						  <div class="clear"></div>
						</div>
						</a>
						<div class="seprator_10"></div>
					<?php
					if(($PIkey+1) == $CountPI){
						echo "</li>";
					}
				}
			}
			?>
			 </ul>
		  </div>
		</div>
		<div class="seprator_6"></div>
	  </div>
	 <?php if($showLaunchPromoImages==1){ ?>
	  <div id="Evetab02" class="<?php echo $showLaunchDivClass;?>" >
		<div id="LPIslider" class="slider eventL_scroll_btn_box">
		  <div class="seprator_10"></div>
		  <div class="position_relative">
			<div class="z_index_2 position_relative"> <a href="#" class="buttons next mr6"></a><a href="#" class="buttons prev disable"></a> </div>
			<!--FAKEDIV-->
			<div class="fakebtn z_index_1"> <span class="buttons next mr6"></span><span class="buttons prev "></span> </div>
		  </div>
		  <div class="viewport eventL_scroll_container">
			<ul class="overview">
			   <?php 
			  
				foreach($launchPostPRImages as $PIkey=>$PI){
					if(($PIkey > 0)&& ($PIkey%3==0)){
							echo "</li><li>";
					}
					elseif(($PIkey%3)==0){
						echo "<li>";
					}
					
					$OrgLPIImage=rtrim($PI['filePath'], '/').'/'.$PI['fileName'];					
					$LPIImage = addThumbFolder($OrgLPIImage,$suffix='_s',$thumbFolder ='thumb',$this->config->item('eventImage'));
					
					if(!empty($OrgLPIImage)){
						$LPIImageFlag=true;
						$PIMediumImage = addThumbFolder($OrgLPIImage,$suffix='_b',$thumbFolder ='thumb');
						//echo base_url($PIMediumImage);
					if(file_exists($PIMediumImage)){
						$PIImage = getImage($LPIImage,$this->config->item('eventImage'));
						$PIMediumImage = getImage($PIMediumImage,$this->config->item('eventImage'));
						$defaultClassShowImage ="max_w157_h108 bdr_bebebe ";
					}else{
						$PIImage = getImage('',$this->config->item('defaultNoMediaImg'));
						$PIMediumImage = getImage('',$this->config->item('defaultNoMediaImg'));
						$defaultClassShowImage ="max_w84_h84 p10 bdr_bebebe";
					}
					
					$mediaId = $PI['mediaId'];
					$mediaTitle = $PI['mediaTitle'];
					$mediaDescription = $PI['mediaDescription'];
					$mediaDescription = ($mediaDescription=='')?' ':nl2br($mediaDescription);

					$postImageSliderInfo[] = array(
						'id'=>$mediaId,
						'image'=>$PIMediumImage,
						'title'=>string_decode($mediaTitle),
						'description'=>string_decode($mediaDescription)
					);
					?>
						<a  href="javascript:imageSlider(postImageSliderInfo,'<?php echo $PIkey; ?>')"><div class="row position_relative Work_recent_box_wrapper dash_link_hover">
						  <div class="work_Sthumb thumb_absolute01">
							<div class="AI_table">
							  <div class="AI_cell"><img border="0" src="<?php echo $PIImage?>" class="<?php echo  $defaultClassShowImage;?> "> </div>
							</div>
						  </div>
						  <div class="ml190 pr10 pr">
							<div class="intro_media_title max_h_32 ptr" onclick="javascript:imageSlider(postImageSliderInfo,'<?php echo $PIkey; ?>');"><?php echo getSubString($mediaTitle,60);?></div>
							<div class="clear"></div>
							<div class="line1"></div>
							<div class="pt5 height_60"><?php echo changeToUrl(getSubString($mediaDescription,100));?></div>
							<span class="pa left_223 top_98 orange_color gray_clr_hover"><?php echo $this->lang->line('view');?>
							</span> </div>
						  <div class="clear"></div>
						</div>
						</a>
						<div class="seprator_10"></div>
					<?php
					if(($PIkey+1) == $CountPI){
						echo "</li>";
					}
				}
			}
			?>
			 </ul>
		  </div>
		</div>
		<div class="seprator_6"></div>
	  </div>
	 <?php } ?>
	 </div>
  </div>
  <?php
		if($PIImageFlag){
			//echo '<pre />';print_r($imageSliderInfo);die;
			if(is_array($imageSliderInfo) && count(@$imageSliderInfo)>0)
			{
				$imageSliderInfo=$this->load->view('common/image_slider_popup',array('imageSliderInfo'=>$imageSliderInfo),true);
				$imageSliderInfo=json_encode($imageSliderInfo);
				?>
				<script>
					var imageSliderInfo = <?php echo $imageSliderInfo;?>
				</script>
			<?php
			}
		}

		if($LPIImageFlag){
			//echo '<pre />';print_r($imageSliderInfo);die;
			if(is_array($postImageSliderInfo) && count(@$postImageSliderInfo)>0)
			{
				$postImageSliderInfo=$this->load->view('common/image_slider_popup',array('imageSliderInfo'=>$postImageSliderInfo),true);
				$postImageSliderInfo=json_encode($postImageSliderInfo);
				?>
				<script>
					var postImageSliderInfo = <?php echo $postImageSliderInfo;?>
				</script>
			<?php
			}
		}

?>
<script type="text/javascript">
	
	$(document).ready(function(){	
		if($('#PIslider')) $('#PIslider').tinycarousel({ axis: 'x', display: 1, start:1});
		if($('#LPIslider')) $('#LPIslider').tinycarousel({ axis: 'x', display: 1, start:1});
	});
	
	function imageSlider(imageSliderInfo,currentImageIndex)
	{
		loadPopupData('popupBoxWp','popup_box',imageSliderInfo);
		$.gallery={options:{_imageListUL:'#imageList',
				_imageHolderDIV:'#imageHolder',
				_imageDiv:"#imageDiv",
				_imageDescriptionDiv:'#imageDescription',
				_imageActiveCSS:'imgActiveBorder',
				_imageLoader:'#loaderDiv',
				_autoPlay:false,
				_delay:5000,
				_currentImageIndex:currentImageIndex
		}};
		initialise();
	}
	
$('#Evetab1').click(function(){
										   
		$(this).addClass('wp_tab_selected ');	
		$(this).siblings().removeClass('wp_tab_selected');
		$('#Evetab01').css('display','block');
		$('#Evetab02').css('display','none');
			
})


$('#Evetab2').click(function(){
										   
		$(this).addClass('wp_tab_selected ');	
		$(this).siblings().removeClass('wp_tab_selected');
		$('#Evetab01').css('display','none');
		$('#Evetab02').css('display','block');
	
		
		 })
</script>
	  
<?php } ?>
