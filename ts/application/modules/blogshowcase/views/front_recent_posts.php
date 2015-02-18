<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$currentMethod = $this->router->method;

//echo '<pre />';print_r($postQuery);
$currentClass = $this->router->class;
if(strcmp($currentClass,'blogs')==0) {$postlinkmethod = 'frontpost';$ml = '';}
else {$postlinkmethod = 'frontPostDetail';$ml = '';}

if(isset($postResults) && is_array($postResults) && count($postResults) > 0){	
	
	$postResults = object2array($postResults);
	if(!empty($postResults)){
	$href=($currentMethod=='preview')?'/blogshowcase/preview/'.$userId.'/0/frontcatposts':'/'.$currentClass .'/frontcatposts/'.$userId;
	$href=base_url(lang().$href);	
	$flag =0;
	echo '<div class="row">';
		echo '<div class="row summery_right_archive_wrapper height25">';
			echo anchor($href,'<h1 class="sumRtnew_strip clr_white dash_link_hover">'.$label['recentPosts'].'</h1>',array('class'=>'','title'=>$label['recentPosts']));
		echo '</div>';
		?>
		<div class="scroll_box innershadw bg-non-color width_282 backgroundBlack <?php echo $ml;?>" id="tab" >
			<div id="ResentPostslider" class=" slider mt3 scroll_light_btn nriSlider">
				<a class="buttons prev" href="#"></a>
				<div class="viewport scroll_container02">
					<ul class="overview">
					<?php
					$slider1StartFrom = 1;
					$prevRecId=0;
					$nextRecId=0;
					$nextRecFlag=false;
					$prevRecFlag=false;
					
					foreach($postResults as $count_post_array => $row)
					{
						if($currentPostId==$row->postId) {
							$aClass = 'orange_color'; 
							$slider1StartFrom = ceil(($count_post_array)/3);
							$prevRecFlag=true;
						}
						else $aClass = '';
						
						if(($nextRecFlag==false) && ($prevRecFlag==true) && ($currentPostId>$row->postId)){
							$nextRecFlag=true;
							$nextRecId=$row->postId;							
						}
						if($prevRecFlag==false){
							$prevRecId=$row->postId;							
						}					
					
					$recentPostTitle = getSubString($row->postTitle,20).'...';
											
					//if filepath is set for any of the post type it will show the respective image else show the no-image 
					if(!isset($row->filePath) || @$row->filePath!=''){
						 $imagePathForEvent = @$row->filePath.'/'.@$row->fileName;
						 $smallImg = addThumbFolder(@$imagePathForEvent,'_s');
					}
					else $smallImg = '';

					$finalSmallImg = getImage($smallImg,$this->config->item('defaultBlogImg_s'));
					$recentPostMediaSrc = '<img class="max_w68_h68 ma"  src="'.$finalSmallImg.'" alt="'.$recentPostTitle.'" />';					
					$href=($currentMethod=='preview')?'/blogshowcase/preview/'.$row->custId.'/'.$row->postId.'/'.$postlinkmethod.'/':'/'.$currentClass .'/'.$postlinkmethod.'/'.$row->custId.'/'.$row->postId;
					$href=base_url(lang().$href);
									
					?>
					  <li>
						 <div class="row recent_box_wrapper01 ptr">
							 <div class="row mediaElements">
						 
							<div class="cell recent_thumb_PApage thumb_absolute01 ptr">
								<div class="AI_table">
									<div class="AI_cell">
										<?php echo anchor($href,$recentPostMediaSrc); ?>
									</div>
								</div> 
						  </div>			
						  <div class="cell ml71 ">
							  <div class="cell recent_two_line01 pl10 height_42 mw186px ptr" onclick="window.location.href='<?php echo $href;?>'"> 
								<div class="row">
									<div class="cell org_anchor_hover"><?php echo anchor($href,$recentPostTitle,array('class'=>$aClass)); ?> </div> 
									<div class="cell recent_short_txt lH5 clear"><?php echo date("l F d  Y", strtotime($row->dateCreated));?></div>
								</div>
							<div class="clear"></div>
							 </div>	
								<div class="SMA_blog_status_bar fr">
								<div class="mt7">
									<span class="blogS_view_btn Fright "><?php echo $row->viewCount;?></span>
									<span class="blogS_crave_btn Fright width_20 "><?php echo $row->craveCount;?></span>
								</div>
								</div>
						  </div>
						  <div class="clear"></div>		 
						</div>
						</div>
					  </li>	
					<?php
					}//End For
				
					if(empty($postData) || !is_object($postData)) $postData = new stdClass;
					//	echo '<pre />postData';print_r($postData);
					if(!empty($prevRecId) && $prevRecId > 0){
						$postData->prevRecId=$prevRecId;				
					}
					if(!empty($nextRecId) && $nextRecId>0){	
						$postData->nextRecId=$nextRecId;				
					}
				//}
					?>
					</ul>
				</div>
				<a class="buttons next" href="#"></a>
			</div>
		</div>
		<?php
	echo '</div>';?>
	<div class="clear"></div>
	<script>
		$('#ResentPostslider').tinycarousel({ axis: 'y', display: 3, start:<?php echo $slider1StartFrom; ?>});	
	</script>
	<?php
}
}//End If
?>
	
