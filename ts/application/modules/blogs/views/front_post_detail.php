<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

$userId = $this->uri->segment('4');
$currentMethod = $this->router->method;
$currentClass = $this->router->class;

if(strcmp($currentClass,'blogs')==0) {$postlinkmethod = 'frontpost';}
else {$postlinkmethod = 'frontPostDetail';}

if(!empty($postData)){
	//echo '<pre />';	print_r($postData);
	$restrictedPostTitle = $postData->postTitle;
		
	//if filepath is set for any of the post type it will show the respective image else show the no-image 
	if(!isset($postData->filePath) || @$postData->filePath!=''){
		 $imagePathForEvent = @$postData->filePath.'/'.@$postData->fileName;
		 $smallImg = addThumbFolder(@$imagePathForEvent,'_s');
	}
	else $smallImg = '';

	$finalSmallImg = getImage($smallImg,$this->config->item('defaultBlogImg_s'));
	
	$postMediaSrc = '<img class="maxWidth165px maxHeight120px ma"  src="'.$finalSmallImg.'" alt="'.$restrictedPostTitle.'" />'; 						
	$restrictedPostOneLineDesc = $postData->postOneLineDesc;
				
	$viewCount = 0;
	$craveCount = 0;
	$ratingAvg = 0;

	$LogSummarywhere = array(
				'entityId'=>$entityId,
				'elementId'=>@$postData->blogId
	);
	$resLogSummary = getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
	if($resLogSummary)
	{
		$resLogSummary = $resLogSummary[0];
		$viewCount = $resLogSummary->viewCount;
		$craveCount = $resLogSummary->craveCount;
		$ratingAvg = $resLogSummary->ratingAvg;
	}else
	{
		$viewCount = 0;
		$craveCount = 0;
		$ratingAvg = 0;
	}
	
	$ratingAvg = roundRatingValue($ratingAvg);
	$ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';		
	
	$cravedALL = '';
	$loggedUserId = @$postData->custId;
	if($loggedUserId > 0){
		$where = array(
					'tdsUid'=>$loggedUserId,
					'entityId'=>$entityId,
					'elementId'=>@$postData->blogId
				);
		$countResult = countResult('LogCrave',$where);
		$cravedALL = ($countResult>0)?'cravedALL':'';
	}else
	{
		$cravedALL = '';
	}	

	$postYear = date('Y',strtotime($postData->dateCreated)); 	
	$postDate = date('d',strtotime($postData->dateCreated)); 	
	$postMon = date('M',strtotime($postData->dateCreated)); 	
?>
 <td class="bg_blog_container" valign="top">                  
    <div class="cell width_476 p10"  id="frontPostsInfo">
        <div class="row width_451 sub_col_middle  global_shadow_light " >                         
			<div class="row">
	<div class="bolggradierbg minH294 bdr_ccc">
	
	<table width="100%" cellspacing="0" cellpadding="0" padding="0">
		<tbody><tr>
			<td class="blog_headingpatern font_arial clr_white font_weight font_size28 pl30 pr30 pb12 pt12 lH30 height_83">
				  <?php echo $postData->postTitle;?>
			</td>
		</tr>
	</tbody></table>
		
	<div class="seprator_13"></div>

	<div class="fl width_200"><div class="liquid_box_wrapper Fleft ml15">
		<table cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td valign="top"><img src="<?php echo base_url()?>images/liquied_top1.png"></td>
				<td class="liquid_top_mid1">&nbsp;</td>
				<td valign="top"><img src="<?php echo base_url()?>images/liquied_top3.png"></td>
			</tr>
			<tr>
				<td class="liquid_mid1">&nbsp;</td>
				<td>
				<?php echo $postMediaSrc; ?>
				</td>
				<td class="liquid_mid2">&nbsp;</td>
			</tr>
			<!-- BOTTOM SHADOW IMAGE-->
			<tr>
				<td><img src="<?php echo base_url()?>images/liquied_bottom1.png"></td>
				<td class="liquid_bottom_mid">&nbsp;</td>
				<td><img src="<?php echo base_url()?>images/liquied_bottom3.png"></td>
			</tr>
		</tbody>
		</table>

	<div class="liquid_box_shadow"></div>	
	<div class="clear"></div>	
	</div>
	<div class="clear"></div>	
	</div>

	<div class="fr width_220 mr17">
	<div class="gradientforstrock width_106 pt1 pb1 pl1 pr1 blogbtndropsheado fl">
	<div class="row recent_box_wrapper01 width_94 pl6 pr6 pb3 bdr_non">

	<div class="pt2 icon_crave4_blog crave craveDiv7185 height_25 float_none <?php echo $cravedALL;?>"><?php echo $this->lang->line('craves'); ?><span class="inline text_alignR fr"><?php echo $craveCount;?></span></div>
	<?php $this->load->view('rating/ratingAvg',array('elementId'=>$postData->blogId,'entityId'=>$entityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'fr padding_left16 rateDiv7185 mr3'));?>
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
		</div>
	</div>
	<div class="clear"></div><!-- Add to manage the shadow -->
	</div>
	
	</div>	
	<div class="blogbottom_sheado"></div>
	<div class="row note pt15 clr_purple">			   
		<?php echo $restrictedPostOneLineDesc; ?>
	</div>	
	<div class="row padding_top18">			   
		<?php echo htmlspecialchars_decode($postData->postDesc); ?>			
	</div>	
	<div class="clear"></div>
	<div class="seprator_20"></div>
	<div class="blogbottom_sheado"></div>
	
	<div class="row  pb10">
	<?php					   
	$totalPostChild = countResult($postsTable,array('parentPostId'=>$postData->postId,'isPublished'=>'t'));
	
	if($totalPostChild>0)
	{
	?>                                        
	  <div class="cell blog_links_wrapper width260px">					  
			<span ><?php echo anchor('blogs/childposts/'.$postData->custId.'/'.$postData->postId,'<b>'.$label['seePosts'].'</b>',array('class'=>"icon_see_post",'target'=>'blank')); ?></span>
			<div class="clear"></div>   
	  </div><!--blog_links_wrapper-->
	<?php
	}
	?> 
	<div class="fr pt5">
		<div class="tds-button_rate cell Fright">   
		<?php $this->load->view('rating/ratingView',array('elementId'=>$postData->postId,'entityId'=>$entityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>$postData->isPublished));?> 
		</div> 
		<div class="cell Fright">
		<?php

		$cacheFile = 'cache/post/post_'.$postData->blogId.'_'.@$postData->postId.'_'.@$postData->custId.'.php';
		$cacheImg = @$postData->filePath.'/'.@$postData->fileName;	
						
		$this->load->view('craves/craveView',array('elementId'=>@$postData->postId,'entityId'=>$entityId,'ownerId'=>@$postData->custId,'projectType'=>'blog','isPublished'=>$postData->isPublished,'furteherDetails'=>'{"projectId":"'.@$postData->postId.'","table":"Posts","primeryField":"postId","imageUrl":"'.$cacheImg.'","fieldSet":"productId as id, postTitle as craveTitle, postOneLineDesc as craveShortDescription, postTagWords as tagwords","cacheFilePath":"'.$cacheFile.'"}'));

		?>                  
		</div>  	
							 
	</div> 
	<div class="clear"></div>
	</div> <!-- End row -->		
		<?php 
			$frontRightArray['userId'] = @$userId;
			$frontRightArray['blogId'] = @$postData->blogId?@$postData->blogId:0;
			$rightPanel = Modules::run("blogshowcase/frontRight",$frontRightArray);
			
			if(isset($postData->prevRecId)){
				$prevdetailhref=($currentMethod=='preview')?'/blogshowcase/preview/'.$postData->custId.'/'.$postData->postId.'/'.$postlinkmethod.'/':'/'.$currentClass .'/'.$postlinkmethod.'/'.$postData->custId.'/'.$postData->prevRecId;
				$prevdetailhref=base_url(lang().$prevdetailhref);
				$prevPost = anchor($prevdetailhref,$this->lang->line('prevPost'),array('class'=>'cell pre_arrow')); 
			}
			else $prevPost ='';
			
			if(isset($postData->nextRecId)){
				$nextdetailhref=($currentMethod=='preview')?'/blogshowcase/preview/'.$postData->custId.'/'.$postData->postId.'/'.$postlinkmethod.'/':'/'.$currentClass .'/'.$postlinkmethod.'/'.$postData->custId.'/'.$postData->nextRecId;
				$nextdetailhref=base_url(lang().$nextdetailhref);				
				$nextPost = anchor($nextdetailhref,$this->lang->line('nextPost'),array('class'=>'cell Fright next_arrow')); 	
			}
			else $nextPost = '';
			if((isset($nextPost)&&$nextPost!='')||(isset($prevPost)&&$prevPost!='')){
		?>
		<div class="row pagination02 font_opensans mb10">
		<?php echo $prevPost.$nextPost?>
		<div class="clear"></div>
		<?php } //If no prev and next record ?>
		
		</div> <!-- End row bdr_top_btm --> 
		
		<!-- Relation Buttons -->	
		<div class="fl blog_links_wrapper pt0">	
		<?php							        
		//$url = base_url().uri_string();
		$currentUrl = base_url().uri_string();								
		$relation = array('getFrontShortLink', 'email','share','entityTitle'=> $postData->postTitle, 'shareType'=>$postData->postTitle, 'shareLink'=> $currentUrl,'id'=> 'Project'.$postData->postId,'entityId'=>$entityId,'elementid'=>$postData->postId,'projectType'=>$postData->postTitle,'isPublished'=>$postData->isPublished,'viewType'=>'showcase');
		$this->load->view('common/relation_to_share',array('relation'=>$relation));
		?>	
		</div>		
		
		<div class="tds-button01 fr">
		<?php 
			$loggedUserId=isloginUser();
			if($loggedUserId>0){
				$gotourl = '/blogshowcase/postchild/'.$userId.'/'.$postData->postId.'/'.$postData->blogId;
				echo anchor('javascript://void(0);','<span class="mr0"><div class="btn_respond_icon"></div><div class="Fright">'.$this->lang->line('postOnPost').'</div></span>',array('onclick'=>'gotourl(\''. $gotourl.'\')','onmousedown'=>'mousedown_tds_button01(this)','onmouseup'=>'mouseup_tds_button01(this)' )); 
			}
			else{
				$gotourl="openLightBox('popupBoxWp','popup_box','/auth/login','')";
				echo anchor('javascript://void(0);','<span class="mr0"><div class="btn_respond_icon"></div><div class="Fright">'.$this->lang->line('postOnPost').'</div></span>',array('onclick'=>$gotourl,'onmousedown'=>'mousedown_tds_button01(this)','onmouseup'=>'mouseup_tds_button01(this)')); 
			}
		?>
		</div>
		<div class="clear"></div>  
		<!-- Relation Buttons End Here -->
		
		<div class="fr font_size11 lh45 padding_left10 font_opensansSBold"><?php echo $blogRating;?></div>
		<div class="clear"></div>  
	</div>

	</div><!-- end row -->
		
</div><!--width_476-->
<?php
	
} //
else 
{
echo '<div class="cell width_476 mr11 ml9 pt11 sub_col_1"  id="frontPostsInfo">';
	echo '<div class="row sub_col_middle  global_shadow width_451">';		
		echo '<div class="norecordfound">'.$label['noPost'].'</div>';		
	echo '</div>';
echo '</div>';
}
?>     
</td>
<td class="bg_blog_container" valign="top">
	<?php echo @$rightPanel; ?>                            
</td>
<td valign="top" class="advert_column">  
	<div class="ad_box ml11 mt10 mb10">
		<?php $this->load->view('common/adv_rhs'); ?>
	</div>	
	<div class="clear"></div>
</td>                           

