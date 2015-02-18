<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
     
<?php
/*foreach($query as $row)
{*/

$row = $query[0];
		
$viewCount=0;
$craveCount=0;
$ratingAvg=0;
		$LogSummarywhere=array(
					'entityId'=>$entityId,
					'elementId'=>@$row->blogId
		);
		$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
		
		if($resLogSummary)
		{
			$resLogSummary=$resLogSummary[0];
			$viewCount=$resLogSummary->viewCount;
			$craveCount=$resLogSummary->craveCount;
			$ratingAvg=$resLogSummary->ratingAvg;
		}else
		{
			$viewCount=0;
			$craveCount=0;
			$ratingAvg=0;
		}
		
		$ratingAvg=roundRatingValue($ratingAvg);
		$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';			
		
		
		$cravedALL='';
		$loggedUserId=isloginUser();
		if($loggedUserId > 0){
			$where = array(
						'tdsUid'=>$loggedUserId,
						'entityId'=>$entityId,
						'elementId'=>@$row->blogId
					);
			$countResult = countResult('LogCrave',$where);
			$cravedALL = ($countResult>0)?'cravedALL':'';
		}else
		{
			$cravedALL='';
		}
     
	//if filepath is set for any of the blog type it will show the respective image else show the default image
	if(!isset($row->filePath) || @$row->filePath!=''){
		 $imagePathForEvent = @$row->filePath.'/'.@$row->fileName;
		 $smallImg = addThumbFolder(@$imagePathForEvent,'_s');
	   }
	else $smallImg = '';

	$finalSmallImg = getImage($smallImg,$this->config->item('defaultBlogImg_s'));

	$blogMediaSrc = '<img class="maxWidth165px maxHeight120px ma"  src="'.$finalSmallImg.'" />'; 
	
	$postYear = date('Y',strtotime($row->dateCreated)); 	
	$postDate = date('d',strtotime($row->dateCreated)); 	
	$postMon = date('M',strtotime($row->dateCreated)); 	
?> 

<td class="bg_blog_container" valign="top">	                  
    <div class="cell width_476 sub_col_1 mr11 ml9 mt10" id="frontPostsInfo">
		<div class="row width_451 sub_col_middle  global_shadow_light " >  
		<div class="seprator_10"></div>
        	<div class="row">
			<div class="bolggradierbg minH294 bdr_ccc">
			<table width="100%" cellspacing="0" cellpadding="0" padding="0">
				<tbody><tr>
					<td class="blog_headingpatern font_arial clr_white font_weight font_size28 pl30 pr30 pb12 pt12 lH30 height_83">
						  <?php echo getSubString($row->blogTitle,50);?>
					</td>
				</tr>
			</tbody></table>
			
			<div class="seprator_13"></div>

			<div class="fl width_200"><div class="liquid_box_wrapper Fleft ml15">
			<table cellspacing="0" cellpadding="0" border="0">
			<tbody><tr>
			<td valign="top"><img src="<?php echo base_url()?>images/liquied_top1.png"></td>
			<td class="liquid_top_mid1">&nbsp;</td>
			<td valign="top"><img src="<?php echo base_url()?>images/liquied_top3.png"></td>
			</tr>
			<tr>
			<td class="liquid_mid1">&nbsp;</td>
			<td>
			<?php echo $blogMediaSrc; ?>
			</td>
			<td class="liquid_mid2">&nbsp;</td>
			</tr>
			<!-- BOTTOM SHADOW IMAGE-->
			<tr>
			<td><img src="<?php echo base_url()?>images/liquied_bottom1.png"></td>
			<td class="liquid_bottom_mid">&nbsp;</td>
			<td><img src="<?php echo base_url()?>images/liquied_bottom3.png"></td>
			</tr>
			</tbody></table>

			<div class="liquid_box_shadow"></div>	
			<div class="clear"></div>	
			</div>
			<div class="clear"></div>	
			</div>

			<div class="fr width_220 mr17">
			<div class="gradientforstrock width_106 pt1 pb1 pl1 pr1 blogbtndropsheado fl">
			<div class="row recent_box_wrapper01 width_94 pl6 pr6 pb3 bdr_non">

				<div class="pt2 icon_crave4_blog crave craveDiv7185 height_25 float_none <?php echo $cravedALL;?>"><?php echo $this->lang->line('craves'); ?><span class="inline text_alignR fr"><?php echo $craveCount;?></span></div>
				<?php $this->load->view('rating/ratingAvg',array('elementId'=>$row->blogId,'entityId'=>$entityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'fr padding_left16 rateDiv7185 mr3'));?>
				<div class="clear"></div>
				<div class="icon_view5_blog mt4 pr0 pl28"> <?php echo $this->lang->line('project_views'); ?> <span class="inline fr"><?php echo $viewCount;?></span></div>
			</div>
			</div>

			<div class="gradientforstrock width_102 pt1 pb1 pr1 blogbtndropsheado fl mt5">		
			<div class=" bg_444">
			<div class="seprator_12"></div>
			<div class="clear"></div>
			<div class="fl font_arial font_size42 clr_bdbdbd lH30 ml6"><?php echo $postDate; ?></div>
			<div class="fl font_arial font_weight clr_f1592a font_size17 width_40 ml8 lH15"><?php echo $postMon.' '.$postYear; ?> </div>
			<div class="clear"></div>
			<div class="seprator_12"></div>
			<div class="clear"></div>
			</div>
			</div>
			<div class="clear"></div>
			<div class="seprator_20"></div>
				<div class="bdrT_999">
					<div class="blogcont_divider margin_0 font_opensansSBold font_size11 clr_666">
					<?php echo $blogLanguage;?> &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; <?php echo $industryTitle;?>
					</div>
					<div class="blogcont_divider margin_0 font_opensansSBold font_size11 clr_666">
					<?php echo $blogRating;?> 
					</div>
				</div>
			</div>
			<div class="clear"></div>
			</div>
			
	</div>  
	<div class="blogbottom_sheado"></div>
	<div class="row note pt15 clr_purple text_alignl">			   
		<?php echo $row->blogOneLineDesc; ?>
	</div>	
	
	<div class="clear"></div>
	<div class="seprator_20"></div>
	<div class="blogbottom_sheado"></div>  	
		<div class="row bdr_top_btm">
			<div class="cell">
			<div class="row">
				<?php							        
				$currentUrl = base_url().uri_string();								
				$relation = array('getFrontShortLink', 'email','share','entityTitle'=> $row->blogTitle, 'shareType'=>$row->blogTitle, 'shareLink'=> $currentUrl,'id'=> 'Project'.$row->blogId,'entityId'=>$entityId,'elementid'=>$row->blogId,'projectType'=>$row->blogTitle,'isPublished'=>$row->isPublished,'viewType'=>'showcase');
				$this->load->view('common/relation_to_share',array('relation'=>$relation));
				?>	
				
			<!--<div class="tds-button01 cell "> <a href="#" onmousedown="mousedown_tds_button01(this)" onmouseup="mouseup_tds_button01(this)" onmouseover="mousedown_tds_button01(this)" onmouseout="mouseup_tds_button01(this)" ><span class="mr0">
			  <div class="btn_email_icon"></div>
			  <div class="Fright">Email</div>
			  </span></a> </div>
			<div class="tds-button01 cell "> <a href="#" onmousedown="mousedown_tds_button01(this)" onmouseup="mouseup_tds_button01(this)" onmouseover="mousedown_tds_button01(this)" onmouseout="mouseup_tds_button01(this)" ><span class="mr0">
			  <div class="btn_share_icon"></div>
			  <div class="Fright">Share</div>
			  </span></a> </div>
			<div class="tds-button01 cell "> <a href="#" onmousedown="mousedown_tds_button01(this)" onmouseup="mouseup_tds_button01(this)" onmouseover="mousedown_tds_button01(this)" onmouseout="mouseup_tds_button01(this)" ><span class="mr0">
			  <div class="btn_link_icon"></div>
			  <div class="Fright">Short Link</div>
			  </span></a> 
			</div>-->                  
			</div>					
			</div>
						
			<div class="fr">
				<div class="tds-button_rate cell Fright">   
					 <?php $this->load->view('rating/ratingView',array('elementId'=>$row->blogId,'entityId'=>$entityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>'t'));?> 
				</div> 
				<div class="cell Fright">
					<?php					 
						$cacheFile = 'cache/blog/blog_'.$row->blogId.'_'.@$row->custId.'.php';
						$cacheImg = @$row->filePath.'/'.@$row->fileName;						
						$this->load->view('craves/craveView',array('elementId'=>@$row->blogId,'entityId'=>$entityId,'ownerId'=>@$row->custId,'projectType'=>'blog','furteherDetails'=>'{"projectId":"'.@$row->blogId.'","table":"Blogs","primeryField":"blogId","imageUrl":"'.$cacheImg.'","fieldSet":"productId as id, blogTitle as craveTitle, blogOneLineDesc as craveShortDescription, blogTagWords as tagwords","cacheFilePath":"'.$cacheFile.'"}'));
					?>                  
				</div>  
			</div>    
		<div class="clear"></div>                           
		</div> 
		<div class="clear"></div>    
		</div>	
	</div><!--width_476--> 	
<div class="clear"></div> 

<!-- Div for 468x60 advert display -->
<div class="row mt18" id="advert468_60"><?php 
	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
		//Manage left side content bottom advert
		$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'3'));
		if(!empty($bannerRhsData)) {
			$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'3','sectionId'=>$advertSectionId));
		} else {
			$this->load->view('common/adv_content_bot'); 
		} 
	} else {
		$this->load->view('common/adv_content_bot');  
	}?>
</div>   
</td>
<td class="bg_blog_container" valign="top">    
<?php
		$userId = $this->uri->segment('4');
		if(!isset($userId)) $userId = LoginUserDetails('user_id');
		$frontRightArray['userId']=@$userId;
		$frontRightArray['blogId']=$row->blogId;
		echo Modules::run("blogshowcase/frontRight",$frontRightArray);
//}
?>
</td>
                   
<td valign="top" class="advert_column">  
	
		<!-- Div for 160x600 advert display -->
		<div class="ad_box ml11 mt10 mb10" id="advert160_600"><?php 
			if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
				//Manage right side advert
				$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'2'));
				if(!empty($bannerRhsData)) {
					$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'2','sectionId'=>$advertSectionId)); 
				} else {
					$this->load->view('common/adv_rhs');
				} 
			} else {
				$this->load->view('common/adv_rhs');
			}?>
		</div>
	
	<div class="clear"></div>
</td> 
                          
<?php 
	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
		//manage auto advert params and js methods
		echo $advertChangeView;
	}
?>
