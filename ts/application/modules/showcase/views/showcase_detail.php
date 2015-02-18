<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?> 
<td valign="top" class="rc_black">

	<div class="CSEprise_TopBox mr9 ml9 mt3 <?php echo $headerClass;?> clr_bababa">
	  <div class="CSEprise_pattern">
		<div class="CSEprise_cat_box">
			<!--Multilingual slider start here-->
			<?php 
			$slider1StartFrom = 1;
			if(isset($multilingualList) && !empty($multilingualList)){ ?>
				<div class="Fright mr14">
					<div class="multilangbg">
						<div id="multilanguage">
							<a class="buttons prev disable" href="#" id="prev" onclick="setHiddenVal('prev','<?php echo $userId;?>');">left</a>
							<div class="viewport CSEprise_Subcat pt8">
								<ul class="overview">
									<?php 
									$countLanguage = count($multilingualList);		
									for($i=0;$i<count($multilingualList);$i++) 
									{
										if($multilingualShowcaseId==$multilingualList[$i]['showcaseLangId']) {
											$sliderPosition = $i+1;
											$slider1StartFrom = $sliderPosition;
										}
										$langName = getLanguage($multilingualList[$i]['langId']);
										$multilangual_link = site_url(lang().'/showcase/aboutme/'.$userId.'/'.$multilingualList[$i]['showcaseLangId']);?>                                    
										<li class="text_alignC">
											<?php echo $langName; ?>
											<input type="hidden" id="hideMultiId-<?php echo $i;?>" value="<?php echo $multilingualList[$i]['showcaseLangId'];?>">
										</li>								 
									<?php } 
									?>  								
								</ul>
							</div>
							<a class="buttons next" href="#" id="next" onclick="setHiddenVal('next','<?php echo $userId;?>');">right</a>
						</div>
					</div>
				</div>			
				<!--Multilingual slider End here-->
			<?php }else{?>
			<div class="CSEprise_Subcat Fright mr14">
					<?php  echo $this->lang->line('english'); ?>
			</div>
			<?php }?>
		  <div class="<?php echo $headingClass;?>"><?php if($showcaseData['isPublished']=='t' || ($checkPublished==false)){ echo $sectionHeading; }?></div>
		  <div class="clear"></div>
		</div>
		<div class="CSEprise_heading bdr_Borange height_33 ml30 mr14">
		  <h1 class="Fleft clr_white"><?php echo $enterPriseName;?></h1>
		  <div class="Fright font_OpenSansBold pt12 font_size13 "><?php echo $showcaseData['cityName'];?></div>
		  <div class="clear"></div>
		</div>
		<div class="row pb13">
		  <div class="width_545 cell font_opensans font_size18 text_alignC pt10 clr_f6f7f2">
			  <?php 
			  if($showcaseData['isPublished']=='t' || ($checkPublished==false)){
				 echo $creativeArea; 
			  }
			  ?>
		  </div>
		  <div class="Fright font_opensansSBold mr14 font_size13"><?php echo $showcaseData['countryName'];?></div>
		  <div class="clear"></div>
		</div>
	  </div>
	  <div class="bdr_c2c3bf seprator_1"></div>
	</div>
	<?php
	if($showcaseData['isPublished']!='t' && ($checkPublished==true)){ ?>
		<div class="CSEprise_centerbox mr9 ml9">
			<div class="pt20 p15 height_695">
				<?php  echo $this->lang->line('showcaseNotPublished');?>
			</div>
			<div class="seprator_15"></div>
		</div>
	<?php	
	}else{

	if($page!='associatedmembers'){ ?>
		<div class="CSEprise_detailBox mr9 ml9 lineH_normal">
		  <div class="font_opensans font_size18 pt30 ml50 mr50 clr_444">
			<?php
			if(isset($multilingualCreativeFocus) && !empty($multilingualCreativeFocus)){
			   echo nl2br(str_replace('\\','',$multilingualCreativeFocus));
			}else{
				echo nl2br(str_replace('\\','',$showcaseData['creativeFocus']));
			}
			   ?>
		  </div>
		  <div class="seprator_20"></div>
		  <div class="showcase_link_hover">
			<?php
			$CSEprise_navflag=false;
			$bgnonFlag=false;
			if(isset($multilingualShowcaseId) && !empty($multilingualShowcaseId)){
				$userMultilingualShowcaseId = '/'.$multilingualShowcaseId;
			}else{
				$userMultilingualShowcaseId = '';
			}
				if($externalReviewsFlag > 0){ 
					if($CSEprise_navflag==false){
							echo '<ul class="CSEprise_nav">';
							$CSEprise_navflag=true;
					}
					$bgnon=($bgnonFlag==false)?'bg-non':'';
					$bgnonFlag=true;
					$href=($mathod=='preview')?'/showcase/preview/'.$userId.'/reviews'.$userMultilingualShowcaseId:'/showcase/reviews/'.$userId.$userMultilingualShowcaseId;
					$href=base_url(lang().$href);
					?>
					<li class="<?php echo $bgnon;?>"><a href="<?php echo $href;?>" class="<?php echo $rsSelected?>"><?php  echo $this->lang->line('reviews'); ?></a></li>
					<?php
				}
				if($externalNewsFlag > 0){ 
					if($CSEprise_navflag==false){
							echo '<ul class="CSEprise_nav">';
							$CSEprise_navflag=true;
					}
					$bgnon=($bgnonFlag==false)?'bg-non':'';
					$bgnonFlag=true;
					$href=($mathod=='preview')?'/showcase/preview/'.$userId.'/news'.$userMultilingualShowcaseId:'/showcase/news/'.$userId.$userMultilingualShowcaseId;
					$href=base_url(lang().$href);
					?>
					<li class="<?php echo $bgnon;?>"><a href="<?php echo $href;?>" class="<?php echo $nsSelected?>"><?php  echo $this->lang->line('news'); ?></a></li>
					<?php
				}
			
				$interviewFileId=trim($showcaseData['interviewFileId']);
				if($interviewFileId > 0){
					if($CSEprise_navflag==false){
							echo '<ul class="CSEprise_nav">';
							$CSEprise_navflag=true;
					}
					$bgnon=($bgnonFlag==false)?'bg-non':'';
					$bgnonFlag=true;
					$href=($mathod=='preview')?'/showcase/preview/'.$userId.'/interview'.$userMultilingualShowcaseId:'/showcase/interview/'.$userId.$userMultilingualShowcaseId;
					$href=base_url(lang().$href);
					?>
					<li class="<?php echo $bgnon;?>"><a href="<?php echo $href;?>" class="<?php echo $mvSelected?>" ><?php  echo $this->lang->line('interview'); ?></a></li>
					<?php
				}
			
				$creativePath=trim($showcaseData['creativePath']);
				if(!empty($creativePath) && strlen($creativePath) > 4){
					if($CSEprise_navflag==false){
							echo '<ul class="CSEprise_nav">';
							$CSEprise_navflag=true;
					}
					$bgnon=($bgnonFlag==false)?'bg-non':'';
					$bgnonFlag=true;
					$href=($mathod=='preview')?'/showcase/preview/'.$userId.'/developementpath'.$userMultilingualShowcaseId:'/showcase/developementpath/'.$userId.$userMultilingualShowcaseId;
					$href=base_url(lang().$href);
					?>
					<li class="<?php echo $bgnon;?>"><a href="<?php echo $href;?>" class="<?php echo $dpSelected?>"><?php  echo $this->lang->line('developmentPath'); ?></a></li>
					<?php
				}
			
				$promotionalsection=trim($showcaseData['promotionalsection']);
				if(!empty($promotionalsection) && strlen($promotionalsection) > 4){
					if($CSEprise_navflag==false){
							echo '<ul class="CSEprise_nav">';
							$CSEprise_navflag=true;
					}
					$bgnon=($bgnonFlag==false)?'bg-non':'';
					$bgnonFlag=true;
					$href=($mathod=='preview')?'/showcase/preview/'.$userId.'/aboutme'.$userMultilingualShowcaseId:'/showcase/aboutme/'.$userId.$userMultilingualShowcaseId;
					$href=base_url(lang().$href);
					?>
					<li class="<?php echo $bgnon;?>"><a href="<?php echo $href;?>" class="<?php echo $amSelected?>"><?php  echo $this->lang->line('aboutMe'); ?></a></li>
					<?php
				}
				
				$introductoryFileId=trim($showcaseData['introductoryFileId']);
				if($introductoryFileId > 0){
					if($CSEprise_navflag==false){
							echo '<ul class="CSEprise_nav">';
							$CSEprise_navflag=true;
					}
					$bgnon=($bgnonFlag==false)?'bg-non':'';
					$bgnonFlag=true;
					$href=($mathod=='preview')?'/showcase/preview/'.$userId.'/introductoryvideo'.$userMultilingualShowcaseId:'/showcase/introductoryvideo/'.$userId.$userMultilingualShowcaseId;
					$href=base_url(lang().$href);
					?>
					<li class="<?php echo $bgnon;?>"><a href="<?php echo $href;?>" class="<?php echo $ivSelected?>" > <?php  echo $this->lang->line('introductryVideo'); ?> </a></li>
					<?php
				}
				
				if($CSEprise_navflag==true){
						echo '</ul>';
				}
			?>
			
		 </div>
		  <div class="clear seprator_13"></div>
		</div>
		
		<?php
	}
	if($innerPageData){
		if($this->router->method=='aboutme' || $this->router->method=='developementpath') $addClass = 'NIC';
		else $addClass = '';
		?>
		<div class="CSEprise_centerbox mr9 ml9">
			<div class="white_horLine <?php echo $addClass;?>">
			  <?php 
                echo $innerPageData;
			  ?>
			</div>
			<div class="seprator_15"></div>
		</div>
		<?php
	}
	?>
	<div class="seprator_5"></div>
	
	<div class="<?php echo $headerClass;?> mr9 ml9">
	  <div class="CSEprise_pattern">
		<div class="seprator_5"></div>
		<div class="CSEprise_action_box Fleft pr10">
		  <div class="height_21 Fleft pt5 ml3 pr">
			<?php
				if($showcaseData['reviewMe']=='t'){
					$this->load->view('media/reviewView',array('elementId'=>$showcaseData['showcaseId'],'projectId'=>$showcaseData['showcaseId'],'entityId'=>$entityId,'projName'=>$enterPriseName,'section' =>$sectionHeading,'industryId' =>$industryId,'reviewClass'=>'tds-button01 cell','isPublished'=>$showcaseData['isPublished']));
				}
			?>
			<?php $this->load->view('craves/craveView',array('craveClass'=>'tds-button_crave cell','elementId'=>$showcaseData['showcaseId'],'entityId'=>$entityId,'ownerId'=>$showcaseData['tdsUid'],'projectType'=>$industryType,'isPublished'=>$showcaseData['isPublished'],'furteherDetails'=>'{"projectId":"'.$showcaseData['showcaseId'].'","table":"UserShowcase","primeryField":"showcaseId","fieldSet":"showcaseId as id,profileImageName as craveImage, firstName as craveTitle, creativeFocus as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}'));?>
			<?php $this->load->view('rating/ratingView',array('elementId'=>$showcaseData['showcaseId'],'entityId'=>$entityId,'ratingAvg'=>$showcaseData['ratingAvg'],'ratingClass'=>'tds-button_rate cell','isPublished'=>$showcaseData['isPublished']));?>
		  </div>
		  <?php
			$loggedUserId=isloginUser();
			if($loggedUserId > 0){
				$where=array(
					'tdsUid'=>$loggedUserId,
					'entityId'=>$entityId,
					'elementId'=>$showcaseData['showcaseId']
				);
				$countResult=countResult('LogCrave',$where);
				$cravedALL=($countResult>0)?'cravedALL':'';
			}else{
				$cravedALL='';
			}
		  ?>
		  <div class="icon_crave4_blog ml15 craveDiv<?php echo $entityId.''.$showcaseData['showcaseId'].' '.$cravedALL;?>"> Craves <span class="inline"><?php echo $showcaseData['craveCount']>0?$showcaseData['craveCount']:0;?></span></div>
		  <div class="mt6 Fleft pl10" id="rateDiv<?php echo $entityId.''.$showcaseData['showcaseId']?>">
			<?php 
			$ratingAvg=roundRatingValue($showcaseData['ratingAvg']);
			$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';
			?>
			<img  src="<?php echo base_url($ratingImg);?>" />
		  </div>
		  <div class="icon_view3_blog ml10"> Views <?php echo $showcaseData['viewCount']>0?$showcaseData['viewCount']:0;?></div>
		</div>
		<?php
		if($showcaseData['recommendMe']=='t'){?>
			<div class="height_15 Fright pt5 mr24 pr">
			  <?php $this->load->view('recommendations/recommendations_view',array('recommendationsClass'=>'tds-button01 cell','userId'=>$showcaseData['tdsUid']));?>
			</div>
			<?php
		}
		?>
		<div class="seprator_5 clear"></div>
	  </div>
	</div>
	<div class="seprator_5"></div>   
	<?php
		if($showcaseData['recommendMe']=='t'){
			$this->load->view('showcase_recommendations', array('to_userid'=>$showcaseData['tdsUid']));
		}
	?>
	<div class="seprator_20"></div>
	<div>
	  
	<?php $this->load->view('social_icons');?>
	  
	  
	 <div class="showcase_social_lnk bdr_4c4c4c Fleft  ml20 pl10">
		<?php
		 $slink=base_url(lang().'/showcase/aboutme/'.$showcaseData['tdsUid']);
		 $relation = array('getFrontShortLink', 'email','share','entityTitle'=> $enterPriseName,'emailClass'=>'icon_trmail dash_link_hover','shareClass'=>'icon_trshare dash_link_hover','shortlinkClass'=>'icon_trshortlink dash_link_hover','shareLink'=> $slink,'id'=>'Showcase','entityId'=>$entityId,'isPublished'=>$showcaseData['isPublished']);
		
		 $this->load->view('common/relation_to_share',array('relation'=>$relation));
		
		 ?>
	
	</div>   
	  
		  <?php /* To Show/Hide Associated Button  */
		      if($showcaseData['enterprise']=='t'){
				  
		           $where = array('from_showcaseid'=>$showcaseData['showcaseId']);
		           
		      } else {				  				  
				        $where = array('to_showcaseid'=>$showcaseData['showcaseId']); 				   
				       
				      }
		    
		  $showAssociateButton= countResult('AssociatedEnterprise',$where);
		// echo $showcaseData['showcaseId'].'----'.$showcaseData['enterprise'];
		  
			$target='';
			
			
			if(isset($showcaseData['from_showcaseid']) && $showcaseData['from_showcaseid'] > 0 &&  $showcaseData['enterprise'] !='t'){
			
				$whereCondi=array(
					'showcaseId'=> $showcaseData['from_showcaseid'],
					'isPublished'=> 't'
				);
				$getUserIdByShow=getDataFromTabel('UserShowcase', 'tdsUid',  $whereCondi, '', $orderBy='', '', 1 );
				$getFromShowUserId = "";
				if($getUserIdByShow)
				{
					$getUserIdByShow = $getUserIdByShow[0];
					$getFromShowUserId = $getUserIdByShow->tdsUid;
				}else
				{
					$showAssociateButton = 0;
				}
			
				$link=base_url(lang().'/showcase/aboutme/'.$getFromShowUserId);
				$target='target="_blanck"';
			}elseif($showcaseData['enterprise'] !='t'){
				$link='';
				//$link="javascript:customAlert('you are not associated with any enterprise.')";
				
			}else{
				
				
				$whereCondi=array(
					'tdsUid'=> $showcaseData['tdsUid'],
					'isPublished'=> 't'
				);
				$getUserIdByShow=getDataFromTabel('UserShowcase', 'showcaseId',  $whereCondi, '', $orderBy='', '', 1 );
				$getFromShowUserId = "";
				
				if($getUserIdByShow)
				{
					$getUserIdByShow = $getUserIdByShow[0];
					$getFromShowcaseId = $getUserIdByShow->showcaseId;
				}
				$getIsAssociatedMembers	= 	 getIsAssociatedMembers($getFromShowcaseId);
				if($getIsAssociatedMembers && count($getIsAssociatedMembers) > 0)
				{
					$link=base_url(lang().'/showcase/associatedmembers/'.$showcaseData['tdsUid']);
				}else
				{
					$showAssociateButton = 0;
				}	
			}
		 
			if( $showAssociateButton >0){ ?>
				<div class="Fright bdr_4c4c4c ml10 height_24 pt10 pb10 pl10 mr9">
					<a <?php echo $target;?> href="<?php echo $link;?>" class="font_opensansLight font_size24 clr_blue height_24 Fleft gray_light_hover"><?php echo $memberHeading;?></a>
					<span class="Fright pt8 pl20 pr10"><img src="<?php echo base_url();?>images/three_arrow.png" /></span>
				</div> <?php 
			}   ?>
	</div>
	<?php }
	// echo Modules::run("showcase/index",array('userId'=>$userId,'multilangId'=>0,'page'=>''));
	// echo $page;die;
	/* set Users Showcase home page default menu*/
	$getUserShowcase = getUserShowcaseId($userId);
	if((isset($getUserShowcase->introductoryFileId)) && ($getUserShowcase->introductoryFileId>0)){
		$showcaseUrl = '/showcase/introductoryvideo/'.$userId;
	}else{
		
		if((isset($getUserShowcase->interviewFileId)) && ($externalNewsFlag==0) && ($externalReviewsFlag<1) && (strlen($creativePath) < 5) && (strlen($promotionalsection) < 5) && ($getUserShowcase->introductoryFileId==0)){
			$showcaseUrl = '/showcase/interview/'.$userId;
		}
		elseif(($getUserShowcase->interviewFileId==0) && ($externalNewsFlag>0) && ($externalReviewsFlag==0) && (strlen($creativePath) < 5) && (strlen($promotionalsection) < 5) && ($getUserShowcase->introductoryFileId==0)){
			$showcaseUrl = '/showcase/news/'.$userId;
		}
		elseif(($getUserShowcase->interviewFileId==0) && ($externalNewsFlag==0) && ($externalReviewsFlag>0) && (strlen($creativePath) < 5) && (strlen($promotionalsection) < 5) && ($getUserShowcase->introductoryFileId==0)){
			$showcaseUrl = '/showcase/reviews/'.$userId;
		}
		elseif(($getUserShowcase->interviewFileId==0) && ($externalNewsFlag==0) && ($externalReviewsFlag==0) && (strlen($creativePath) > 4) && (strlen($promotionalsection) < 5) && ($getUserShowcase->introductoryFileId==0)){
			
			$showcaseUrl = '/showcase/developementpath/'.$userId;
		}
		else{
			$showcaseUrl = '/showcase/aboutme/'.$userId;
		}
	}

	/*Get current method of controller */ 
	$method = $this->router->fetch_method();
	if(isset($method) && !empty($method) && $method!='preview' && $method!='index'){
		$taskMethod = '/showcase/'.$method.'/'.$userId;
	}
	elseif(!empty($method) && $method=='preview' && !empty($page)){
		$taskMethod = '/showcase/'.$method.'/'.$userId.'/'.$page;
	}
	elseif(!empty($method) && $method=='index'){
		//$taskMethod = '/showcase/aboutme/'.$userId;
		$taskMethod = $showcaseUrl;
	}
	else{
		//$taskMethod = '/showcase/aboutme/'.$userId;
		$taskMethod = $showcaseUrl;
	}
	?>
	<input type="hidden" id="hiddenMultiId" value="">
	<div class="clear seprator_14"></div>	
<script type="text/javascript">
	$(document).ready(function(){
		if($('#recommendationSlider'))	
		$('#recommendationSlider').tinycarousel({ axis: 'y', display: 3, start:1});	
		
		if($('#AMslider'))	
		$('#AMslider').tinycarousel();	
	});
</script>            
</td>
<!-- Script for scroll multilingual languages-->
<script type="text/javascript">
	$(document).ready(function(){
		if($('#multilanguage'))	
		$('#multilanguage').tinycarousel({ axis: 'x', display: 1, start:<?php echo $slider1StartFrom; ?>});
	});
	
	/* Function sets hidden value of language Id*/
	function setHiddenVal(val1,userId){
		if(val1=='next'){
			var index = multiLangId+1;
		}else{
			var index = multiLangId-1;
		}
	
		var currentMultiId = $('#hideMultiId-'+index).val();
		setTimeout(function() {	
			$('#hiddenMultiId').val(currentMultiId);
			var multiLangIds = multiLangId;
			reloadMultingualPage(val1,userId,multiLangIds);
		}, 1500);
	}
	
	/* Function redirect to language after delay*/
	function reloadMultingualPage(val1,userId,multiLangIds){
		if(val1=='next'){
			var index = multiLangIds;
		}else{
			var index = multiLangIds;
		}
		var methodType = '<?php echo $taskMethod;?>';
		var currentMultiId = $('#hideMultiId-'+index).val();
		var hiddenMultiId = $('#hiddenMultiId').val();
		
		if(currentMultiId==hiddenMultiId){
			setTimeout(function() {
					//window.location.href=baseUrl+language+'/showcase/'+methodType+'/'+userId+'/'+currentMultiId;
					window.location.href=baseUrl+language+methodType+'/'+currentMultiId;
			}, 1500);
		}
		else{
			return false;
		}	
	}
</script>  
