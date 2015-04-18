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
	$ratingImg=base_url('images/rating/rating_0'.$ratingAvg.'.png');
	
	
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
	/*if(!isset($row->filePath) || @$row->filePath!=''){
		 $imagePathForEvent = @$row->filePath.'/'.@$row->fileName;
		 $smallImg = addThumbFolder(@$imagePathForEvent,'_s');
	   }
	else $smallImg = '';

	$finalSmallImg = getImage($smallImg,$this->config->item('defaultBlogImg_s'));*/
	
	// get blog image
	$blogImagePath = getBlogImage($row,1,'_xxl');
	
	$blogMediaSrc = '<img src="'.$blogImagePath.'" class="blogDetailImg" />'; 
	
	$postYear = date('Y',strtotime($row->dateCreated)); 	
	$postDate = date('d',strtotime($row->dateCreated)); 	
	$postMon = date('M',strtotime($row->dateCreated)); 	

	 //------create share link by current url-------//
    $currentShortUrl = uri_string();
    $isPublished = $row->isPublished;
	$entityId = getMasterTableRecord('Blogs');
	
	if(!isset($userInfo)){
		$userInfo =showCaseUserDetails($userId);
	}
	$seller_currency=$userInfo['seller_currency'];
	$seller_currency=($seller_currency>0)?$seller_currency:0;
	$currencySign=$this->config->item('currency'.$seller_currency);	
	$sectionId=$this->config->item('blogsSectionId');
?> 
<!--  content wrap  start end -->
<div class="newlanding_container bg_f7f7f7">
	<div class="wid940 m_auto pt36"> 
		<!--  Tab Nav -->  
		<div class="landing_blog clearbox mb20  ">
			 <!-- left box -->
			<div class="width610 fl clearbox mr30">
				<div class="pl15 pr15 width580 fl bg_fff  pt12 pb20">
					<div class="img_wra2 position_relative text_alignR"> 
						<?php echo $blogMediaSrc; ?>
						<div class="overlay_blog  opens_light ">
							<h2 class="bb2_b2bd55 pb10 fs30">Introduction to my blog</h2>
						</div>
					</div>
					<div class="sap_35"></div>
					<h3 class="opens_light lineH34 fs29 clr4646"> 
						<?php echo getSubString($row->blogTitle,50);?>
					</h3>
					<div class="sap_25"></div>
					<div class="fs16 open_sans lineH22 clr_888" >
						<?php echo $row->blogOneLineDesc; ?>
					</div>
					<div class="sap_40"></div>
					<span class="red fr pb5"><?php echo $postMon.' '.$postDate.', '.$postYear; ?></span>
					<div class="sap_30 bte6e6"></div>
					<div class="head_list fl ml10">
						<div class="icon_view3_blog fs11 icon_so"><?php echo $viewCount;?></div>
						<div class="icon_crave4_blog fs11 icon_so"><?php echo $craveCount;?></div>
						<div class="rating fl pt6">
							<img class="max_w29" alt="" src="<?php echo $ratingImg;?>"> 
						</div>
					</div>
					<div class="fl clr_888 pl45"><?php echo $blogRating;?></div>
					<div class="sap_30"></div>
					<div class="clr_666 lineH20">
						<?php echo $row->blogDesc; ?>
					</div>
					<div class="sap_30"></div>
					 <?php
					 //-----------crave button load view-----------//
					$creaveButtonTitle = 'Crave';
					$showSocialData= array('buttonDesigntype'=>'1','buttonTitle'=>$creaveButtonTitle,'elementId'=>$row->blogId,'entityId'=>$elementEntityId,'ownerId'=>$frontendUserId,'projectType'=>'','isPublished'=>$row->isPublished,'furteherDetails'=>'');
					echo Modules::run("craves/creavebutton",$showSocialData);
                
                    //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$row->blogId,'entityId'=>$entityId,'isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);

                 	if((isset($row->blogToDonate) && $row->blogToDonate=='t') || ((isset($blogDetail['blogToDonate']) && $blogDetail['blogToDonate']=='t')) || ((isset($blogToDonate) && $blogToDonate=='t'))){
						
						$donorDetail=array('entityId'=>$entityId,'elementId'=>$row->blogId,'projId'=>$row->blogId,'sectionId'=>$sectionId,'ownerId'=>$row->custId,'seller_currency'=>$seller_currency);
						$this->load->view("mediafrontend/common_view/donate_button_frontend",$donorDetail);
					} ?>
					
					<div class="sap_15 bb_b7b7b7"></div>
					<div class="sap_20"></div>
					<div class="clearbox mb10 socail_icon width_542"> 
						<ul class="socail_list">
							<li> 
								<?php 
								echo ' <span class="fl">';
									
									//-----short module link by email module array-----//
									$shortlinkEmailData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'1');
									echo Modules::run("share/shareemailbutton",$shortlinkEmailData);								

									//-----load module shortlink module array-----//
									$shortlinkData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'1');
									echo Modules::run("shortlink/shortlinkfrontbuttonnew",$shortlinkData);								

								echo '</span>';

									//-------load module of social share---------------//
									$shareData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'4');
									echo Modules::run("share/sharesocialshowview",$shareData);		
								?>
							</li>
						</ul>
					</div>
				</div>
				<div class="sap_20"></div>
				<div class="bg_fff width100_per pt15 pb15 text_alignC">
					<!-- Div for 468x60 advert display -->
					<div id="advert468_60">
						<?php 
						if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)) {
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
				</div>
			</div>
			  <!-- right box -->
			<div class="third_intro_cnt fl widht_300"> 
				<?php
				$userId = $this->uri->segment('4');
				if(!isset($userId)) $userId = LoginUserDetails('user_id');
				$frontRightArray['userId']=@$userId;
				$frontRightArray['blogId']=$row->blogId;
				echo Modules::run("blogshowcase/newfrontRight",$frontRightArray);
				?>
			</div>
			         
		</div>
	</div>
</div>


<?php /*?>
<td class="bg_blog_container" valign="top">	                  
    <div class="cell width_476 sub_col_1 mr11 ml9 mt10" id="frontPostsInfo">
		<div class="row width_451 sub_col_middle  global_shadow_light " >  
		<div class="seprator_10"></div>
        	<div class="row">
			<div class="bolggradierbg minH294 bdr_ccc">
			<div class="blog_headingpatern height_72 font_arial clr_white font_weight font_size28 pt10 pl30 pr30 lH30">
			<?php echo getSubString($row->blogTitle,50);?>
			</div>
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
			<img class="fr" src="<?php echo $ratingImg;?>" />
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
	
	<?php if(!empty($row->blogDesc)){ ?>
	<div class="row padding_top18 NIC">			   
		<?php echo $row->blogDesc; ?>
	</div>	
	<?php }?>
	<div class="clear"></div>
	<div class="seprator_20"></div>
	<div class="blogbottom_sheado"></div>  	
		<div class="row bdr_top_btm">
			<div class="cell">
			<div class="row">
				<?php							        
				//$url = base_url().uri_string();
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
			</div> -->                 
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
		</div>
		</div>
	</div><!--width_476--> 
		<div class="clear"></div>     

	<!-- Div for 468x60 advert display -->
	<div class="row width470px ma mt20" id="advert468_60"><?php 
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
		echo Modules::run("blogshowcase/newfrontRight",$frontRightArray);
//}
?>
</td>
<?php */?>

<?php 
	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
		//manage auto advert params and js methods
		echo $advertChangeView;
	}
?>
