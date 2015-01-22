<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="blogShowcaseList">
<?php
$currentMethod = $this->router->method;

 
 ?>
	         
<div class="bg_white p10">
<?php
		//print_r($postResults);
		//die;
		$viewCount=0;
		$craveCount=0;
		$ratingAvg=0;
		
		if(isset($postResults) && is_array($postResults) && count($postResults) > 0){	
			$flag = 0;
				foreach($postResults as $row)
				{				
					//echo '<pre />';print_r($row);
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
					$href=($currentMethod=='preview')?'/blogshowcase/preview/'.$row->custId.'/'.$row->postId.'/frontPostDetail':'/blogshowcase/frontPostDetail/'.$row->custId.'/'.$row->postId;
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
					}
					else
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
			<td class="blog_headingpatern font_arial clr_white font_weight font_size28 pl30 pr30 pb12 pt12 lH30 height_83 gray_light_hover">
				  <?php echo getSubString($row->postTitle,50);?>
			</td>
		</tr>
		</tbody>
	</table>
	
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
	<td><?php echo $postMediaSrc; ?></td>
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
	<div class="fr width_220 mr17  pr height190">
		<div class="gradientforstrock width_106 pt1 pb1 pl1 pr1 blogbtndropsheado fl">
		<div class="row recent_box_wrapper01 width_94 pl6 pr6 pb3 bdr_non">

		<div class="pt2 icon_crave4_blog crave craveDiv7185 height_25 float_none <?php echo $cravedALL;?>"> <?php echo $this->lang->line('craves'); ?><span class="inline text_alignR fr"><?php echo $craveCount; ?></span></div>
		<div class="fr padding_left16 rateDiv7185 mr3">			 
			<img class="fr" src="<?php echo $ratingImg;?>" />
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
		<div class="row blogreadmore width_100 tar">
			<?php echo anchor($href,$this->lang->line('blogRead'),array('class'=>'orange gray_clr_hover'));?>								
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	</div>
	<div class="blogbottom_sheado"></div>
	</div>
	<?php
			}//End For
		
			 if(isset($items_total) && isset($perPageRecord) && ($items_total >  $perPageRecord)){
				?>
				 <div class="row pt3">
						<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>$pagingLink,"divId"=>"frontPostsInfo","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
					<div class="clear"></div>
					<div class="seprator_10"></div>
				</div>
				
				<?php
			} 
		}//End If
		else 
		{
			redirect(base_url('blogshowcase/frontblog/'.$userId));
			echo '<div class="row main_blog_box">';
			echo '<div>';
			echo '<div class="norecordfound">'.$label['noPost'].'</div>';
			echo '</div>';
			echo '</div>';
		}
		
		?>
</div>	<!-- sub_col_middle  global -->

<!-- Div for 468x60 advert display -->
<div class="width470px ma mt20 mb20" id="advert468_60"><?php 
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

<div class="seprator_10 clear"></div>
	 
   </div> <!--cell width_476 sub_col_1 mr11 -->

</div><!-- Container -->
<div class="clear seprator_10"></div>
