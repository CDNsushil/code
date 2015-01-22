<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
 <td class="bg_DarkGreen" valign="top">
<?php 
$workProfileId = !empty($workProfileId) ? $workProfileId : 0;				
	$currentWorkDetail = array();
//echo 'defaultWorkId:'.$defaultWorkId;
	foreach ($work_array as $key =>$work_array_record) {
		
		if($work_array_record['workId'] == $defaultWorkId) { 
			$currentWorkDetail = $work_array_record;
		}
	}
		
if(count($currentWorkDetail)>0)	{

 
	if(strcmp(@$currentWorkDetail['workType'],'wanted')==0)
		$defaultImage = $this->config->item('defaultWorkWanted_m');
	else
		$defaultImage = $this->config->item('defaultWorkOffered_m');
	
	$thumbImage = addThumbFolder(@$currentWorkDetail['filePath'].'/'.@$currentWorkDetail['fileName'],'_m');				
	$thumbImg = getImage(@$thumbImage,$defaultImage);	
	//$thumbImg = getImage(@$currentWorkDetail['filePath'].'/'.@$currentWorkDetail['fileName'],$defaultImage); 
		
		  $LogSummarywhere=array(
					'entityId'=>$workEntityId,
					'elementId'=>$defaultWorkId
		  );		
			$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
			if($resLogSummary){
				$resLogSummary=$resLogSummary[0];
				$craveCount=$resLogSummary->craveCount;
				$ratingAvg=$resLogSummary->ratingAvg;
				$viewCount = $resLogSummary->viewCount;
			}else{
				$craveCount=0;
				$ratingAvg=0;
				$viewCount = 0;
			}
			
			$ratingAvg=roundRatingValue($ratingAvg);
			$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';	
			
			$cravedALL='';
			$loggedUserId=isloginUser();
			if($loggedUserId > 0){
				$where=array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$workEntityId,
								'elementId'=>$defaultWorkId
							);
				$countResult=countResult('LogCrave',$where);
				$cravedALL=($countResult>0)?'cravedALL':'';
			}else{
				$cravedALL='';
			}
			
?>

 <!--Middle_column-->
        <div class="cell width_476 sub_col_1 pr10 pl10 bg_DarkGreen">
          <div class="seprator_10"></div>
			
					 <div class="Work_gredient_box pt13 pl20 pr11 pb20">
						<div class="font_opensansLight font_size26 lineH_32 width450px overflowHid"><?php echo @$currentWorkDetail['workTitle'];?></div>
						<div class="seprator_20"></div>
						<?php if(@$currentWorkDetail['workCompany']!=''   &&  @$currentWorkDetail['workType']=='offered') { ?>
						<span class="cell width_100 clr_black font_size14"><b>Company</b></span><span class="cell font_size13"><?php echo @$currentWorkDetail['workCompany'];?></span> 
						<div class="clear seprator_20"></div> 
						<?php } ?>
						<div class="tal note font_size13 fntclr_Work"><?php echo @$currentWorkDetail['workShortDesc'];?></div>
					  </div>
					 <div class="seprator_7"></div>
					  <!--box-->
					  <div class="Work_gredient_box pt13 pl20 pr11 pb20">
						<div class="clr_black font_size14"><b>Description</b></div>
						<div class="clear seprator_10"></div>
						<div class="font_size13">
						  <p><?php echo @$currentWorkDetail['workDesc'];?></p>
						</div>
					  </div>
					  
					   <!--box-->
					   <?php if( @$currentWorkDetail['workTypeDesc'] !='') { ?>
						<div class="seprator_7"></div>				  
						  <div class="Work_gredient_box pt13 pl20 pr11 pb20">
							<div class="clr_black font_size14"><b>Job Requirements</b></div>
							<div class="clear seprator_10"></div>
							<div class="font_size13 NIC">
							  <p><?php echo @$currentWorkDetail['workTypeDesc'];?></p>
							</div>
						  </div>
						  <!--box-->
			 <?php } ?>
			<!-- ADS FOR CONTENT -->
			<div class="row width470px ma mt20"> <?php $this->load->view('common/adv_content_bot'); ?></div>
			<div class="clear"></div>
			
			<?php	
			   //LOAD RELATED PROMO IMAGES
			   echo $this->load->view('promo_images',$promo_images);		   
		   ?>        
         <div class="seprator_18"></div>
          <div class="scroll_box darkGrey_bg pt7 pb7 bdr_d2d2d2">
            <div class="row">
				
                    <div class="fl blog_links_wrapper pt0 ml12">
						<?php	
							//$url = base_url().uri_string();
							$currentUrl = base_url().uri_string();								
							$relation = array('getFrontShortLink', 'email','share','entityTitle'=> $currentWorkDetail['workTitle'], 'shareType'=>$currentWorkDetail['workType'], 'shareLink'=> $currentUrl,'id'=> 'Project'.$currentWorkDetail['workId'],'entityId'=>$workEntityId,'elementid'=>$defaultWorkId,'projectType'=>$currentWorkDetail['workType'],'isPublished'=>$currentWorkDetail['isPublished'],'viewType'=>'showcase');
							$this->load->view('common/relation_to_share',array('relation'=>$relation));
						?>							  
				   </div>               
                
                <div class="tds-button_rate cell Fright"> 
		           <?php //$this->load->view('rating/ratingView',array('elementId'=>$defaultWorkId,'entityId'=>$workEntityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft'));?>
		 
		        </div>
                
                  <?php
					//echo '<pre />';print_r($currentWorkDetail);$this->lang->line('work');die;
					$cacheFile = 'cache/work/work_'.$defaultWorkId.'_'.@$currentWorkDetail['tdsUid'].'.php';
					$cacheImg = @$currentWorkDetail['filePath'].'/'.@$currentWorkDetail['fileName'];
					//$this->load->view('craves/craveView',array('elementId'=>$defaultWorkId,'entityId'=>$workEntityId,'ownerId'=>@$currentWorkDetail->tdsUid,'projectType'=>$this->lang->line('work'),'furteherDetails'=>'{"workId":"'.$defaultWorkId.'","table":"Work","primeryField":"workId","imageUrl":"'.$thumbImg.'","fieldSet":"workId as id, workTitle as craveTitle, workShortDesc as craveShortDescription, workTag as tagwords"}'));
			
					$this->load->view('craves/craveView',array('elementId'=>$defaultWorkId,'entityId'=>$workEntityId,'ownerId'=>$currentWorkDetail['tdsUid'],'isPublished'=>$currentWorkDetail['isPublished'],'projectType'=>'work','furteherDetails'=>'{"projectId":"'.$defaultWorkId.'","table":"Work","primeryField":"workId","imageUrl":"'.$cacheImg.'","fieldSet":"workId as id, workTitle as craveTitle, workShortDesc as craveShortDescription, workTag as tagwords","cacheFilePath":"'.$cacheFile.'"}','tootlTip'=>$this->lang->line('craveMsg')));
				
					//Detail User Info
					$userInfo = showCaseUserDetails(@$currentWorkDetail['tdsUid']);   
					$selectworkType = ($currentWorkDetail['workExperiece']=='t') ?'Experience'.' '.ucfirst($currentWorkDetail['workType']) :$currentWorkDetail['workType'] ;             

                ?>                

			   <div class="clear"></div>
			  </div>     
          </div>
          <div class="clear seprator_18"></div>
        </div>
      </td>
      <td class="bg_DarkGreen" valign="top"> 
         <div class="cell width_284 pl10 pr10 sub_col_2 bg_DarkGreen">
          <div class="mt10"></div>
        
            <div class="row summery_right_archive_wrapper">
			<h1 class="swp_user_name clr_white "><?php echo $userInfo['userFullName'];?></h1>
			<ul class="swp_user_name_link">
			  <li class="mt9">
				  <?php 
					$method = 'works';
					$shocaseUrl=base_url(lang().'/workshowcase/'.$method.'/'.$currentWorkDetail['tdsUid'].'/'.$defaultWorkId);  ?>
	
				  <a class="clr_white" href="<?php echo $shocaseUrl;?>"><?php echo $this->lang->line('viewShowcase');?></a>
			  </li>
			</ul>
		  </div>
		  	<div class="clear seprator_10"></div> 
		 	<div class="sumRtnew_strip clr_white height_32"><?php echo "Work ".ucfirst($selectworkType) ?> </div>
			<div class="clear seprator_10"></div> 
                   
          <!--right btn-->
          <div class="scroll_box darkGrey_bg global_shadow pt15 pb15 bdr_d2d2d2"> 
          
            <?php 
            if(strcmp(@$currentWorkDetail['isUrgent'],'t')==0){
				$divWidth = 'width_116';
				$imgWidth =" max_w114_h171";
			}
            else{
				$divWidth = 'width_242';
				$imgWidth =" max_w240_h158";
			}
            ?>
            <div class="Fleft ml20 <?php echo $divWidth;?>">
              <div class="AI_table">
                <div class="AI_cell">				
					<img border="0" src="<?php echo $thumbImg;?>" class="wp_topimg_thumb  <?php echo $imgWidth; ?> bdr_d2d2d2"></div>
              </div>
            </div>
            <?php 
            //IF THE CURRENT WORK IS URGENT THEN WILL SHOW THE RED BUTTON ELSE NOT
         
            if(strcmp(@$currentWorkDetail['isUrgent'],'t')==0) { ?>
            <div class="Fright mr14"><img src="<?php echo base_url('images/frontend/urgent_tag.png');?>"></div>
            <? } ?>
            <div class="clear"></div>
            <div class="ml20 mr20 mt25">
              <div class="font_opensansSBold clr_white ">
                <div class="summery_posted_wrapper bdr_T666666">
					<span class="cell pl16">
						<?php echo $this->lang->line('advertised');?>
					</span>
					<span class="cell width125px pl15 orange">
						<?php echo date("d F Y", strtotime(@$currentWorkDetail['workPublisheDate']));?>
					</span>
					<div class="clear"></div>
				</div>
                
				<div class="summery_posted_wrapper bdr_T666666">
					 <span class="cell width220px  pl16">
					 <?php 
					 $comma='';
					 if(!empty($currentWorkDetail['workCity']) && !empty($currentWorkDetail['workCountryId'])) $comma = ',&nbsp;&nbsp;';
					 
					 echo @$currentWorkDetail['workCity']; echo (@$currentWorkDetail['workCountryId'])? $comma.getCountry(@$currentWorkDetail['workCountryId']):'';
					 ?>
					 </span>
					 <div class="clear"></div>
                 </div>
                <div class="summery_posted_wrapper bdr_T666666">
					<span class="cell width220px pl16">
						<?php 
						$langcomma='';
						if(@$currentWorkDetail['workLang1']>0 && @$currentWorkDetail['workLang2']>0) $langcomma = ',&nbsp;&nbsp;';
							echo getLanguage(@$currentWorkDetail['workLang1']); if(@$currentWorkDetail['workLang2']>0) echo $langcomma.getLanguage(@$currentWorkDetail['workLang2']);
						?>
					</span> 
					<div class="clear"></div>
				</div>               
                <div class="summery_posted_wrapper bdr_T666666">
					<span class="cell width220px pl16">
						<?php echo getIndustry(@$currentWorkDetail['workIndustryId']);?>
					</span> 
					<div class="clear"></div>
				</div>   
				<?php 
					$workTypeAdditional = @$currentWorkDetail['workTypeAdditional'];
					if($workTypeAdditional != ''){
				?>            
                <div class="summery_posted_wrapper bdr_T666666">
					<span class="cell width220px pl16">
					<?php if($workTypeAdditional=="F")echo $this->lang->line('workFree'); ?>
					<?php if($workTypeAdditional=="FT")echo $this->lang->line('workFullTime'); ?>
					<?php if($workTypeAdditional=="PT")echo $this->lang->line('workPartTime'); ?>
					<?php if($workTypeAdditional=="CA")echo $this->lang->line('workCasual'); ?>
					</span> 
					<div class="clear"></div>
				</div>               
                <?php }//end if $workTypeAdditional                
                if( @$currentWorkDetail['workExperiece'] == 't'){?>
                <div class="summery_posted_wrapper bdr_T666666">
					<span class="cell width_90 pl16"><?php echo $this->lang->line('workExperience');?></span>
					<div class="clear"></div>
				</div>
                <?php } else {    
					
					if( isset ($currentWorkDetail['workRemuneration']) && $currentWorkDetail['workRemuneration']!='') { ?>
                <div class="summery_posted_wrapper bdr_T666666">
					<span class="cell pl16">					
					<?php 
					echo @$currentWorkDetail['workRemuneration']; 
					if(@$currentWorkDetail['workRenumUnit']=="PA") $currentUnit = $this->lang->line('renumUnitPerAnnum'); 
					else if(@$currentWorkDetail['workRenumUnit']=="PM") $currentUnit = $this->lang->line('renumUnitPerMonth'); 
					else if(@$currentWorkDetail['workRenumUnit']=="PW") $currentUnit =  $this->lang->line('renumUnitPerWeek'); 
					else if(@$currentWorkDetail['workRenumUnit']=="PH") $currentUnit = $this->lang->line('renumUnitPerHour'); 
					echo (@$currentUnit != '')? '&nbsp;'.@$currentUnit:'';
					?>
					</span>
					<div class="clear"></div>
					 </div>
                <?php } } ?>
              </div>
              <div class="seprator_10 bdr_T666666 clear"></div>
              
<div class="EM_view_crave_box pl15 pt5 pb5">	
	<div class="cell width_80 height_27 pl36 icon_crave4_blog crave craveDiv<?php echo $workEntityId.''.$defaultWorkId?> <?php echo $cravedALL;?>"><?php echo $this->lang->line('craves').'&nbsp;'.$craveCount;?></div>
	<!--
	<div class=" cell padding_left16 pt10 rateDiv<?php //echo $workEntityId.''.$defaultWorkId?>">			 
			<img  src="<?php //echo base_url($ratingImg);?>" />
	</div>
	-->
	<?php //$this->load->view('rating/ratingView',array('elementId'=>$defaultWorkId,'entityId'=>$workEntityId,'ratingClass'=>'cell pt5 width_auto pl25 mt5'));?>

	<div class="cell"><div class="icon_view3_blog float_none height_27 pl36"> <?php echo $this->lang->line('project_views').'&nbsp;'.$viewCount;?></div></div>
	<div class="clear"></div>
	</div>

<?php $this->load->view('apply_classified_view',array('title'=>@$currentWorkDetail['workTitle'],'isWorkProfile'=>$workProfileId,'workId'=>$currentWorkDetail['workId'],'senderId'=>$currentWorkDetail['tdsUid'],'workType'=>@$currentWorkDetail['workType']));?>

</div>
</div>
		<div class="seprator_25"></div>
		<?php 		   
		   //LOAD RELATED WORK VIDEO
		   echo $this->load->view('promo_video');
		?>
		<div class="seprator_25"></div>
			<?php 		
			   //LOAD ALL WORK DETAIL
			   echo $this->load->view('all_works');		   
			?>
		<div class="clear seprator_5"></div>			  
		<div class="ad_box_shadow width250px mb20"><?php $this->load->view('common/adv_rhs_forum');?></div>

		</div>
</td>

<td class="advert_column" valign="top"> 
<div class="cell  sub_col_3">
	<div class="ad_box ml11 mt10 mb10">
		<?php $this->load->view('common/adv_rhs'); ?>
	</div>
	<div class="clear"></div>
</div>
<?php 
}
else {
redirectToNorecord404();
}
?>
</td><!--cell_width_284-->
<script type="text/javascript">
/*tab function*/
	$(document).ready(function(){
		$('#slider1').tinycarousel({ axis: 'y', display: 4, groupStep:1});			
		$('#slider4').tinycarousel({ axis: 'y', display: 3});
		$('#slider5').tinycarousel({ axis: 'y', display: 3});
	});
			
</script>
