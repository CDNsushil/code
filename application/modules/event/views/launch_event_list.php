<!-- Start Show Event Title -->
<?php
$userId = isLoginUser();
//DEFINING EDIT,PREVIEW AND DELETE URLS
$encodedEventId = encode($LaunchEventId);
$editUrl = 'launchEventForm/0/3/'.$LaunchEventId;
$previewUrl = '/event/previewLaunchEvent';
$url = 'deleteEvent/'.$encodedEventId;
$delFlag = 1;


if(isset($StartDate) && $StartDate != '')
{
	$eventStartDate = date("F d, Y", strtotime($StartDate));
	$redClockSrc = '<img class="formTip minMax16px" src="'.getImage($redClock).'" alt="'.$eventStartDate.'" title="'.$eventStartDate.'"  class="formTip"  />';
}
else $redClockSrc ='';

if(isset($FinishDate) && $FinishDate != '')
{
	$eventFinishDate = date("F d, Y", strtotime($FinishDate));
	$blueClockSrc = '<img class="formTip minMax16px" src="'.getImage($blueClock).'" alt="'.$eventFinishDate.'" title="'.$eventFinishDate.'"  class="formTip"  />';
}
else $blueClockSrc ='';

if(isset($LaunchDate) && $LaunchDate != '')
{
	$eventLaunchDate = date("F d, Y", strtotime($LaunchDate));
	$yellowClockSrc = '<img class="formTip minMax16px" src="'.getImage($yellowClock).'" alt="'.$eventLaunchDate.'"  title="'.$eventLaunchDate.'" class="formTip" />';
}
else $yellowClockSrc ='';
  
//For arrow image in between the clock images  
$arrowSep = 'images/icons/breadcrumb_separator_arrow_1_dot.png';
$arrowSepSrc = 	'<img class="minMax16px" src="'.getImage($arrowSep).'" />';

$eventTime = $Time;
	
//if filepath is set for any of the event type it will shoe he respective image else show the no-image 
if(isset($filePath)){
 if($filePath!='')
	$imagePathForEvent = $filePath.'/'.$fileName;
}
else $imagePathForEvent = '';
$eventMediaSrc = getImage($imagePathForEvent);

	if(strlen($OneLineDescription) >150) $OneLineDescription = substr($OneLineDescription,0,150).'...';
	//else  echo $OneLineDescription;

	if(isset($Tagwords)){
		if(strlen($Tagwords) >0)
		{
			if(strlen($Tagwords) >100) $tagwords = substr($Tagwords,0,100).'...';
			else  $Tagwords = $Tagwords;
			//echo '<br /><b class="txtBlack">'.$label['tags'].':</b>'.$tagwords;
		}
	}

	$sliderImages = getProductImages('TDS_EventMedia','launchEventId',$LaunchEventId, 1, 'isMain');// Defination is on Common controller
	
?>
<div class="row">
	<div class="cell width_200 Cat_wrapper">
		<?php 
			$defaultImage='images/stock_images/eventDefault.jpg';
			echo Modules::run("common/imageSlider",$sliderImages,$LaunchEventId,$defaultImage);
		?>
	</div>
	
	
	<?php //echo Modules::run("common/profileImage",$eventMediaSrc);?>
	</div>
	<div class="cell width_569 margin_left_16 ">
		<div class="row blog_wrapper bg_light_gray">
			<div class="blog_box">
				<div class="cell blog_left_wrapper">
					<div class="row">
						<h2 class="main_blog_heading"> 
								<?php 
									echo $label['launchEvent'];

									if(isset($Industry) && $Industry !='')
										echo ' ('.getIndustry($Industry).')';
								?>
						</h2>
					</div>
					<div class="row">
						<div class="cell padding_top10"> <b class="orange_color"><?php echo $this->lang->line('createdOn');?></b>  <b><?php echo date('l d F Y',strtotime($LaunchDate));?></b> </div>
					</div>
					<div class="seprator_10 row"></div>
					<div class="row"> <b class="orange_color"><?php echo $this->lang->line('project_logLineDescription');?> </b>
						<p><?php echo $OneLineDescription;?></p>
						<?php if(isset($Tagwords)){
							if(strlen($Tagwords) >0  && $Tagwords>0)
							{
							?>
								<div class="seprator_10"></div>
								<b class="orange_color"><?php echo  $this->lang->line('project_tags');?></b>
								<p><?php echo $Tagwords;?></p>
							<?php 
							} 
						}
						?>
					</div>
					<div class="seprator_10 row"></div>
					<div class="row"> <b class="orange_color"><?php echo $label['venue']; ?></b>
						<p><?php
						//Check for Address value
							if($Address !='' ) echo $Address.'<br />';
							
							//Check for State value
							if($State !='' ) echo $State.'<br />';
							
							//Check for City value
							if($City !='' ) echo $City.'<br />';
							
							//Check for Country value
							if($Country !='' && $Country>0) 
							{
							 $countryName = getCountry($Country); 			 
							}
							else 
								$countryName = '';

							if($countryName !='' ) echo $countryName.'<br />';
							
							//Check for Zip value
							if($Zip !='' ) echo $Zip.'<br />';			
							
							//Check for URL value
							if(strpos($URL, "http://")) $VenueURL = $URL;
							else $VenueURL = "http://".$URL;

							echo '<a href="'.$VenueURL.'"  target="_blank">'.$label['venueURL'].'</a>';
							?>
						</p>
					</div>
					
					<div class="row blog_links_wrapper">
					
			   <?php
			
			  // Show view page for getshortLink ,email,share,invite and postOnPost
			 // entityTitle: Title of page you want to share
			// shareType: text(like: post,film and video etc)
		   // shareLink: url to get shared with users
			$currentUrl = $this->config->site_url().$this->router->class;
			
			$relation = array('invite','share','entityTitle'=> addslashes($EventType), 'shareType'=>$label['event'], 'shareLink'=> $currentUrl, 'id'=> 'event'.$maineventid);
			
			echo Modules::run("common/loadRelations",$relation); 

		?>
			
				 </div>
					<!--blog_links_wrapper-->
				</div>
									
				<div class="blog_right_wrapper">
					<div class="blog_link2_wrapper">
						<div class="post_text">&nbsp;</div>
						
						<div class="tds-button-top"> 
							<div class="modifyBtnWrapper">
							<a href="<?php echo $editUrl;?>" class="formTip" title="<?php echo $this->lang->line('edit')?>">
							<span>
							<div class="projectEditIcon"></div>
							</span>
							</a> 

							<?php
							if($isPublished=='t'){
								$previewUrl='eventfrontend/eventlaunch/'.$userId.'/'.$LaunchEventId;
								$previeTooltip=$this->lang->line('view');
							}else{
								$previeTooltip=$this->lang->line('preview');
								 $previewUrl = '/eventfrontend/preview/'.$userId.'/'.$LaunchEventId.'/eventlaunch';
							}
							
							echo anchor($previewUrl,'<span><div class="projectPreviewIcon"></div></span>',array('target'=>'_blank','class'=>'formTip','title'=>$previeTooltip)); ?>							

							<a href="javascript://void(0);" class="formTip comingSoon" onclick="delEvent('<?php echo encode($maineventid);?>')"  title="<?php echo $this->lang->line('delete');?>"><span>
							<div class="projectDeleteIcon"></div>
							</span></a>  
						</div>
						</div>
					</div>
						
					<div class="clear"></div>
					<div class="rating_box_wrapper padding_top10">
						<div class="rating_box"> </div>
						<div class="rating_box"> </div>
						<div class="rating_box"> </div>
						<div class="rating_box"> </div>
						<div class="rating_box"> </div>
					</div>
					<!--rating_box_wrapper-->
					<div class="clear"></div>

					<div class="blog_link3_wrapper">
						<div class="blog_link3_box">
							<div class="icon_crave2_blog"><?php echo $this->lang->line('project_craved')?></div>
							<div class="blog_link3_point">0</div>
						</div>
						<div class="blog_link3_box">
							<div class="icon_view2_blog"><?php echo $this->lang->line('project_views')?></div>
							<div class="blog_link3_point">0</div>
						</div>
						<div class="blog_link3_box">
							<div class="icon_post2_blog"><?php echo $this->lang->line('project_reviews')?></div>
							<div class="blog_link3_point">0</div>
						</div>
						<div class="blog_link3_box">
							<div class="icon_lastview2_blog"> 
								<?php echo $this->lang->line('project_lastViewed')?><br/>
								<b><?php echo date('d M Y');?></b>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div><!--blog_box-->
		</div>
		<div class="shadow_blog_box"> </div>
	</div><!--width_569--> 
</div>
