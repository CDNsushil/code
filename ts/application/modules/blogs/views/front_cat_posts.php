<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<td valign="top" class="bg_blog_container">
	<?php if(!empty($parentPost['postResults'][0]->postTitle)) { ?>
	<div class="row parent_post_sample_heading clr_white">					
		<?php echo $restrictedPostTitle = getSubString($parentPost['postResults'][0]->postTitle,50); ?>						
	</div>	
	<?php } ?>
<div class="cell mr11 ml9 mt9 width_476 bg_white" >
	
<div class="row p10" id="frontPostsInfo">
<?php
$currentClass = $this->router->class;
$currentMethod = $this->router->method;
if(strcmp($currentClass,'blogs')==0) {$postlinkmethod = 'frontpost';$ml = '';}
else {$postlinkmethod = 'frontPostDetail';$ml = '';}
$totalRecords = count($postResults);
		if($totalRecords > 0)
		{	
			$flag =0;
				foreach($postResults as $row)
				{				
					if(LoginUserDetails('user_id') == $row->custId) $flag = 1; //give visiblity to edit delete button only if the post is posted by loggen in user
					else $flag=0;

					$postYear = date('Y',strtotime($row->dateCreated)); 	
					$postDate = date('d',strtotime($row->dateCreated)); 	
					$postMon = date('M',strtotime($row->dateCreated)); 	
									
					//if filepath is set for any of the post type it will show the respective image else show the no-image 
					if(!isset($row->filePath) || @$row->filePath!=''){
						 $imagePathForEvent = @$row->filePath.'/'.@$row->fileName;
						 $smallImg = addThumbFolder(@$imagePathForEvent,'_s');
					}
					else $smallImg = '';

					$finalSmallImg = getImage($smallImg,$this->config->item('defaultBlogImg_s'));
					$postMediaSrc = '<img class="maxWidth165px maxHeight120px ma"  src="'.$finalSmallImg.'" />';						
					$href=($currentMethod=='preview')?'/blogs/preview/'.$row->custId.'/'.$row->postId.'/frontPostDetail':'/'.$currentClass .'/'.$postlinkmethod.'/'.$row->custId.'/'.$row->postId;
					$href=base_url(lang().$href);	
					$LogSummarywhere=array(
					'entityId'=>$entityId,
					'elementId'=>@$row->postId
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
									'elementId'=>@$row->postId
								);
						$countResult = countResult('LogCrave',$where);
						$cravedALL = ($countResult>0)?'cravedALL':'';
					}else
					{
						$cravedALL='';
					}
	?>	
	
	<div class="row">
		
	<div class="bolggradierbg minH294 bdr_ccc ptr " onclick="window.location.href='<?php echo $href;?>'">
	<table width="100%" cellspacing="0" cellpadding="0" padding="0">
		<tbody>
		<tr>
			<td class="blog_headingpatern font_arial clr_white font_weight font_size28 pl30 pr30 pb12 pt12 lH30 height_83">
				  <?php echo getSubString($row->postTitle,50);?>
			</td>
		</tr>
		</tbody>
	</table>
	
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
	</tbody></table>

	<div class="liquid_box_shadow"></div>	
	<div class="clear"></div>	
	</div>
	<div class="clear"></div>	
	</div>


	<div class="fr width_220 mr17 pr height190">
	<div class="gradientforstrock width_106 pt1 pb1 pl1 pr1 blogbtndropsheado fl">
	<div class="row recent_box_wrapper01 width_94 pl6 pr6 pb3 bdr_non">

	<div class="pt2 icon_crave4_blog crave craveDiv7185 height_25 float_none <?php echo $cravedALL;?>"> <?php echo $this->lang->line('craves'); ?><span class="inline text_alignR fr"><?php echo $craveCount; ?></span></div>
	<div class="fr padding_left16 rateDiv7185 mr3">			 
	<?php $this->load->view('rating/ratingAvg',array('elementId'=>$row->postId,'entityId'=>$entityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'fr padding_left16 rateDiv7185 mr3'));?>
	</div>
	<div class="clear"></div>
	<div class="icon_view5_blog mt4 pr0 pl28"> <?php echo $this->lang->line('project_views'); ?><span class="inline fr"><?php echo $viewCount; ?></span></div>
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
	<?php if(!empty($row->categoryTitle)){?>
	<div class="seprator_5"></div>
	<div class="font_opensansSBold font_size12 text_alignR bdr_Bpost pb5 mr10"><?php echo $row->categoryTitle;?></div>
	
	<?php } else echo '<div class="seprator_20"></div>';?>
	<div class="blogdescstyle minH66 pt5">
		<?php echo getSubString($row->postOneLineDesc,130); ?>		
	</div>
	
	<div class="row blogreadmore width_100 tar ptr " onclick="window.location.href='<?php echo $href;?>'">
		<?php echo anchor($href,$this->lang->line('blogRead'),array('class'=>'orange'));?>									
	</div>	
	
	<div class="clear"></div>
	</div>	
	<div class="clear"></div>
	</div>
	<div class="blogbottom_sheado"></div>
	</div>
	<?php
			}//End For
		}//End If
		else 
		{
			echo '<div class="row main_blog_box">';
			echo '<div>';
			echo '<div class="norecordfound">'.$label['noPost'].'</div>';
			echo '</div>';
			echo '</div>';
		}
	?>
</div>	<!-- End pagingContent -->
<div class="seprator_10 clear"></div>
<?php

$post_page['record_num'] = 4;
if($totalRecords > $post_page['record_num']) $this->load->view('pagination_view',$post_page);

?><div class="seprator_10  clear"></div>
</div>
</td>
<td valign="top" class="bg_blog_container"> 
<?php
		$frontRightArray['userId']=$row->custId;
		$frontRightArray['blogId']=$row->blogId;
		//echo '<pre />';print_r($frontRightArray);
		echo Modules::run("blogshowcase/frontRight",$frontRightArray);
?>
</td>
<td valign="top" class="advert_column">  
	<div class="ad_box ml11 mt10 mb10">
		<?php $this->load->view('common/adv_rhs'); ?>
	</div>
	<div class="clear"></div>
</td>
