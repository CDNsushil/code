<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	 $thumbFolder='thumb';
	 $methodArray=array('filmvideo','musicaudio','photographyart');
	 $blog_status_bar='SMA_blog_status_bar';
	 $blog_height='height_31';
	 $blog_width='width_171';
	 $blog_mt='mt8';
	 $elementHeading=($method=='musicaudio')?$this->lang->line('pieces'):($method=='educationmaterial'?$this->lang->line('lessons'):$elementHeading);
	 $elementHeading=$method=='photographyart'?$this->lang->line('imagesorpieces'):$elementHeading;
	 $elementHeading=$method=='news'?$this->lang->line('articles'):$elementHeading;
	 $elementHeading=$method=='reviews'?$this->lang->line('reviews'):$elementHeading;
	 
	 $projSellstatus=$project['projSellstatus']=='t'?true:false;
?>
<div class="row summery_right_archive_wrapper width_auto">
	<h1 class="sumRtnew_strip <?php echo $clr_white;?>"><?php echo $elementHeading;?></h1>
	<div class="scroll_box mt11  global_shadow <?php echo $sectionBgcolor;?>">
	  <div id="mediaMainElementSlider" class="slider"> <a class="buttons prev" href="#"></a>
		<div class="viewport scroll_container01 <?php echo $elememtDivHeihgt;?>">
		  <ul class="overview">
				<?php
				$pieceSrartFrom=1;
				$rowCount=2;
				foreach($mainElements as $e=>$element){
					$LogSummarywhere=array(
							'entityId'=>$elementEntityId,
							'elementId'=>$element['elementId']
					);
					$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
					if($resLogSummary){
						$resLogSummary=$resLogSummary[0];
						$craveCount=$resLogSummary->craveCount;
						$viewCount =$resLogSummary->viewCount;
					}else{
						$craveCount=0;
						$viewCount =0;
					}
					
					$cravedALL='';
					$loggedUserId=isloginUser();
					if($loggedUserId > 0){
						$where=array(
										'tdsUid'=>$loggedUserId,
										'entityId'=>$elementEntityId,
										'elementId'=>$element['elementId']
									);
						$countResult=countResult('LogCrave',$where);
						$cravedALL=($countResult>0)?'cravedALL':'';
					}else{
						$cravedALL='';
					}
					
					$previeLink='media/'.$constant['project_preview'].'/'.$project['projectid'];
					if($industryType=='photographyNart'){
						if($projSellstatus){
							$thumbFolder='watermark';
						}
						$thumbImage = addThumbFolder($element['filePath'].$element['fileName'],'_xs',$thumbFolder);	
						$elementImage=getImage($thumbImage,$imagetype_xs,'');
						$elementImage=$element['isExternal']=='t'?checkExternalImage(trim($element['filePath']),'_xs'):$elementImage;
					}else{
						
						if($industryType=='filmNvideo'){
							if(empty($element['imagePath'])){	
							$thumbImage = getVideoThumbFolder(@$element['filePath'].$element['fileName'],'_xs');	
							$elementImage=getImage($thumbImage,$imagetype_xs);	
							}else{
								$thumbImage = addThumbFolder(@$element['imagePath'],'_xs');	
								$elementImage=getImage($thumbImage,$imagetype_xs);
							}
						}else{	
							$thumbImage = addThumbFolder(@$element['imagePath'],'_xs');	
							$elementImage=getImage($thumbImage,$imagetype_xs);
						}
					}
					
					$elementUrl=base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId.'/'.$element['elementId'].'/'.$method);
					 $elementTextColor='';
					  if($elementId==$element['elementId']){
						 $elementTextColor='orange_color';
						 $pieceSrartFrom=ceil(($e+1)/4);
					 }
					 
					?>						
					<li>
					  <div class="row recent_box_wrapper01" >
						<div class="row mediaElements" elementId="<?php echo $element['elementId'];?>" default="<?php echo $element['default'];?>">
						  <div class="cell recent_thumb_PApage thumb_absolute01 ptr" onclick="window.location.href='<?php echo $elementUrl;?>'" >
							<div class="AI_table">
							  <div class="AI_cell"> <img class="max_w68_h68 bdr_cecece" src="<?php echo $elementImage;?>"></div>
							</div>
						  </div>
						  <div class="cell ml71">
							<div class="cell recent_two_line01 pl10 height_42 mw186px ptr <?php echo $elementTextColor;?> dash_link_hover" onclick="window.location.href='<?php echo $elementUrl;?>'"><?php echo getSubString(html_entity_decode($element['title']),24);?></div>
							
							<div class="SMA_blog_status_bar ml1 fr ">
								<div id="loadertxt_<?php echo $rowCount; ?>" class="Fleft dn mt11 mL5"><img src="<?php echo  base_url(); ?>images/loading_wbg.gif" ></div>
								<div class="mt7">
								
								<?php
								if($method=='musicaudio'){
								
									
								$getMediaPathData['fileName'] = $element['fileName'];
								$getMediaPathData['filePath'] = $element['filePath'];
								$getFullFilePath = getFullMediaPath($getMediaPathData);
								
								if($element['isExternal']=="f")
								{ ?>
									<span id="rowCount_<?php echo $rowCount; ?>"   class="status_bar_play_btn ptr Fright mt-3 playAudioIcon" onclick="playMediaClipFile('<?php echo  base64_encode($getFullFilePath); ?>',this)"></span>
								<?php }else { echo '<span class="Fright pr23">&nbsp;</span>'; }  }elseif($method=='writingpublishing'){ ?>
								
								<span class="Fright mr10 ptr dash_link_hover"><?php echo $this->lang->line('read');?></span>
									<?php
								}
								?>
								<span class="blogS_view_btn Fright "><?php //echo $element['viewCount'];?><?php echo $viewCount;?></span>
								<div class="blogS_crave_btn Fright width_20 craveDiv<?php echo $elementEntityId.''.$element['elementId']?> <?php echo $cravedALL;?>"><span class="inline"><?php echo $craveCount;?></span></div>
								</div>
							</div>
							<div class="clear"></div>
						  </div>
						</div>
						<div class="clear"></div>
					  </div>
				  </li>
					<?php
					
					$rowCount++;
				}
				?>
		  </ul>
		</div>
		<a class="buttons next" href="#"></a> </div>
	</div>
</div>
<script type="text/javascript">
	/*tab function*/
	$(document).ready(function(){
		if($('#mediaMainElementSlider'))	
		$('#mediaMainElementSlider').tinycarousel({ axis: 'y', display: 4, start:<?php echo $pieceSrartFrom; ?>});	
	});
</script>
