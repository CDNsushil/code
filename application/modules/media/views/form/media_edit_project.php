<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    // set project cover image
    $getProjectCoverImage = getProjectCoverImage($projData->projId,'_l');
    // set base url
    $baseUrl = formBaseUrl();
    // set rating avg image
    $ratingAvg = roundRatingValue($ratingAvg);
    $ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';
    // set delete redirect url
    $deleteRedirect = $baseUrl.'/publicisemediacollection';
    // set cover image edit url
    $editCoverLink = $baseUrl.'/selectcoverimage/'.$projData->projId;
    // set publish url
    $publishLink = $baseUrl.'/previewpublish/'.$projData->projId;
    //$publishLink = $baseUrl.'/publicise/'.$projData->projId;
    
    // set add element url
    $addElement = $baseUrl.'/uploadform/'.$projData->projId;
    // set showcase media url
    $mediaShowcaseUrl = base_url(lang().'/mediafrontend/mediashowcases/'.$userId.'/'.$projData->projId);
    
    // set links for news and review
    if($sectionId == '3:1' || $sectionId == '3:2') {
        // set cover image edit url
        $editCoverLink = $baseUrl.'/newsreviewcoverimage/'.$projData->projId.'/'.$elementId;
        // set publish url
        $publishLink = $baseUrl.'/publishcollection/'.$projData->projId.'/'.$elementId;
        // set add element url
        $addElement = $baseUrl;
        // set showcase media url
        //$mediaShowcaseUrl = base_url(lang().'/mediafrontend/writingpublishing/'.$userId.'/'.$projData->projId.'/'.$indusrtyName);
        if($sectionId == '3:1')
        $mediaShowcaseUrl = base_url(lang().'/mediafrontend/newscollection/'.$userId);
        else if($sectionId == '3:2')
        $mediaShowcaseUrl = base_url(lang().'/mediafrontend/reviewscollection/'.$userId);
        
       
    } 
    
    // set edit element no record link if element count is 0
    $editElementUrl = $baseUrl.'/editmediaelements/'.$projData->projId;
?>

<div class="newlanding_container">
	<div class=" m_auto  width840 ">
		<div class="sap_40"></div>
		<h3 class=" fs24 "><?php echo $projData->projName;?></h3>
		<div class="sap_30"></div>
		<div class="edit_section">
			<div class="bdr_e5e5 clearbox display_table position_relative">
				<div class="table_cell bdrR_F1592A width_380 pt30 pb30 position_relative">
					<div class="secton_img ">
						<img src="<?php echo $getProjectCoverImage;?>" class="" />   
					</div>
					<div class="fl position_absolute pl25 pt10 pb10 bottom0"><span class="red">Collection Storage Space </span>   <b>
						<?php echo $remainingSize .' of '. $containerSize?></b></div>
					</div>
					<div class="table_cell pl30 pr30 pt30 pb30 fr width455 box_siz">
						<div class="bbe6e6 pb15 fl width100_per mb30" >
							<h4 class="red opens_light fs28 fl">Edit Collection</h4>
							<div class="head_list fr mt10 ">
								<div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
								<div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
								<div class="rating fl pt5"><img alt=" " src="<?php echo base_url($ratingImg);?>"></div>
								<div class="btn_share_icon icon_so"><?php echo $reviewCount;?></div>
							</div>
						</div>
						<ul class="red_arrowli fs18 text_alignR list_mb15">
							<?php  if( $projData->isPublished == 'f') { ?>
								<li>
									<a href="<?php echo $publishLink;?>">
										<?php echo $this->lang->line('editMediaPublish');?>
									</a>
								</li>
							<?php } ?>
                    
							<li>
								<a href="<?php echo $editCoverLink;?>"> <?php echo $this->lang->line('editMediaCoverPage');?> </a>
							</li>
                    
							<?php  if($sectionId != '3:1' && $sectionId != '3:2' && $projData->projSellstatus == 't') { ?>
								<li>
									<a href="<?php echo $baseUrl.'/setupsales/'.$projData->projId;?>">
										<?php echo $this->lang->line('editMediaSalesInfo');?>
									</a>
								</li>
							<?php } ?>
                  
							<li>
								<a href="<?php echo base_url_lang('cart/mysales'); ?>"><?php echo $this->lang->line('editColectionSales');?>  </a>
							</li>
                     
							<?php if($projData->isPublished == 't') { ?>
								<li>
									<a href="<?php echo $mediaShowcaseUrl;?>">
										<?php echo $this->lang->line('editMediaViewInShowcase');?>
									</a>
								</li>
							<?php } ?>
       
							<li>
								<a href="javascript:void(0)">
									<?php echo $this->lang->line('editMediaTestFile');?>
								</a>
							</li>
				  
							<li>
								<a href="<?php echo $baseUrl.'/membershipcart/'.$projData->projId;?>">
								   <?php echo $this->lang->line('editMediaAddSpace');?>
								</a>
							</li>
                   
							<?php if($subscriptionType == 1) { ?>
								 <li>
									<a href="<?php echo $baseUrl.'/renewmediacart/'.$projData->projId;?>">
										<?php echo $this->lang->line('renew_container');?>
									</a>
								 </li>
							<?php } ?>
                    
							<?php  if(!isset($isPubliciseSection) && $projData->isPublished == 't') { ?>
								<li> 
									<a href="<?php echo $publishLink;?>">
										<?php echo $this->lang->line('editMediaHide');?>
									</a>
								</li>
								<?php 
								// set delete redirect url
								$deleteRedirect = $baseUrl.'/editmediacollection';
							} ?>
						</ul>
					</div>
				</div>
				<div class="bdr_e5e5 clearbox display_table">
					<?php 
					if($projData->isBlocked == 't' || (!empty($blockedElements) && count($blockedElements) > 0)) { ?>
						<div class="table_cell width_380 position_relative bdr3_ee242c p20 text_alighL">
							<!--<div class=" width100_per height100per ">-->
								<div class="bbe6e6 pb16 mb15 fs18">Problem reported about this Collection </div>
								<p class="fs15"> 
									Another member of Toadsquare has declared that they believe that the material <br />
									<br />
									<?php 
									if($projData->isBlocked == 't' ) { ?>
										<b class="clr_ed1c24">
											&lt; <?php echo $projData->projName;?> &gt;
										</b>
										<br /><br />
									<?php 
									} else {
										foreach($blockedElements as $blockedElements) { ?>
											<a href="<?php echo $baseUrl.'/uploadfile/'.$projData->projId.'/'.$blockedElements->elementId;?>">
												<b class="clr_ed1c24"> &lt; <?php echo $blockedElements->title;?> &gt;</b><br />
											</a>
											<br />
									<?php } } ?>
									is illegal. Please see your email and Tmail for more details. 
									<br /> <br />
									Access to this material has been suspended.
								</p>
							<!--</div>-->
							
						<?php } else {
							echo '<div class="table_cell bdrR_F1592A width_380 pt30 pb30 position_relative">';
						}?> 
					</div>

					<div class="table_cell pl30 pr30 pt30 pb30 fr width455 box_siz">
						<div class="bbe6e6 pb5 fl width100_per mb30" >
							<h4 class="red opens_light fs24 fl"><?php echo $this->lang->line('editMediaElement');?></h4>
							<div class=" fr mt5 fs13 ">
								<?php  if($sectionId != '3:1' && $sectionId != '3:2') { ?>
									<span class="pr12 "><b class="red pr5"><?php echo $downloadFiles;?></b>  <?php echo $fileFormateNames['fileType'];?></span> 
									<span><b class="red price"><?php echo $nonDownloadFiles;?></b>  <?php echo $fileFormateNames['fileShipped'];?>'s</span>
								<?php } else { ?>
									<span class="pr12"><b class="red pr5"><?php echo $newsreviewCount;?></b>  <?php echo $this->lang->line('collectionElement');?></span> 
								<?php } ?>
							</div>
						</div>
						<ul class="red_arrowli fs18 text_alignR list_mb15">
							<li><a href="<?php echo $addElement;?>"> <?php echo $this->lang->line('editMediaAddAnFile');?>  </a></li>
							<li>
								<?php 
								if($downloadFiles == 0 && $nonDownloadFiles == 0 && $sectionId != '3:1' && $sectionId != '3:2' ) { ?>
									<a href="javascript:void(0)" onclick="customAlert('<?php echo $this->lang->line('noElementAvailable');?>','Warning')" >
								<?php
								} else {
									echo '<a href="'. $editElementUrl.'">';
								}
									echo $this->lang->line('editMediaEditAnFile');?>
								</a>
							</li>
							<?php
							if($sectionId != '3:1' && $sectionId != '3:2') {
								if($sectionId == 1) { 
									if(!empty($isTrailer)) { 
										echo  '<li><a href="'.$baseUrl.'/addtrailerorsamplefile/'.$projData->projId.'/2">'.$this->lang->line('editMediaAddTrailer').'</a></li>';
									} else {
										echo  '<li><a href="'.$baseUrl.'/uploadform/'.$projData->projId.'/'.$trailerElementId.'">'.$this->lang->line('editMediaEditTrailer').'</a></li>';
									} 
								}
								if($sectionId != 4) {
									if(!empty($isSample)) {
										echo '<li><a href="'.$baseUrl.'/addtrailerorsamplefile/'.$projData->projId.'/1">'.$this->lang->line('editMediaAddSample').'</a></li>';
									} else {
										echo '<li><a href="'.$baseUrl.'/uploadform/'.$projData->projId.'/'.$sampleElementId.'">'.$this->lang->line('editMediaEditSample').'</a></li>';
									}	
								} 
							} ?>
						</ul>
						<div class="sap_30"></div>
					</div>
				</div>
			</div>
      
		<div class="sap_25"></div>
		<a href="javascript:void(0);" onclick="deleteMediaCollection('<?php echo $projData->projId;?>');";>
			<button type="button" class="white_button">Delete Collection</button>
		</a>
		<div class="sap_30"></div>
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

