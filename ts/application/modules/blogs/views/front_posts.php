<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$userId = $this->uri->segment('4');
if(!isset($userId) || $userId=='') $userId = isLoginUser();
else $userId =0;

$totalRecords = count($blogPostsData);
$openLi ='<li>';
$closeLi ='</li>';

//Common Banner
	$topCravedArray = array('entityId'=>$entityId,'projectType'=>'blog');
	$topCravedData['data'] = topCraved($topCravedArray);

	if(is_array($topCravedData['data']) && count($topCravedData['data'])>0){		
		$topCravedData['defaultProfileImage'] = $this->config->item('defaultBlogImg_m');			
		$topCravedHtml = $this->load->view('common/top_craved_blog',$topCravedData,true);
	}
	else
		$topCravedHtml = '';
				
	$bannerarray['imgarray']=array('banner_front_blog_have-your-say_HR.jpg','banner_front_blog-latest-word-street_HR.jpg');
	$bannerarray['topCravedHtml'] = $topCravedHtml;
	echo $this->load->view('common/common_banner',$bannerarray); //common view for image banner placed in main view folder

	$currentMethod = $this->router->class;	
	
	$loggedInUser = isLoginUser();
	$goToSectionUrl = '/'.$this->config->item($currentMethod.'_dashboard');
	
	$href = 'javascript://void(0);'; 
	if(isset($loggedInUser) && $loggedInUser>0) {
		$dashboardSectionUrl = "goTolink('','".base_url(lang().$goToSectionUrl)."')";
		$cssLogin="mt7";
	}
	else{
		$cssLogin="mt7";		
		$dashboardSectionUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->config->item($currentMethod)).".')";
	}
	
	$addSectionButton = anchor($href,$this->lang->line('uploadButtonPost'),array('onclick'=>$dashboardSectionUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn'));  
 if($totalRecords <= 0) $class_blog = "mH70";	
 else $class_blog = "";	
?>
<td class="bg_blog_container" valign="top">	       
          <div class="row">
            <div class="cell bdr_purple10 global_shadow bg_white ml40 width_880 <?php echo $class_blog;?>">
				  <!--latest_post_heading-->
				  <ul class="wp_news_tab mt11 ml0 lborder0">
					<li class="blogpost_heading width_100 org_anchor_hover"><a href="javascript:void(0);" onclick="return reloadPage('');" class="blogpost_heading"><?php echo $this->lang->line('latestPosts');?></a></li>
				  </ul>
				 <!-- selectbox-->
				<div class="pa mt9 ml160 org_anchor_hover"><?php echo $addSectionButton;?></div>
						<div class="blog_landing_select">
						<?php 
							$industryVal = $this->uri->segment(4);
							echo form_dropdown('industryId', $industryList, $industryVal ,'id="industryId" onchange="reloadPage(this.options[this.selectedIndex].value);"');
						?>
						</div>
				<?php if($totalRecords > 0){ ?> 	 				
				<div class="news_content_wp" >				
         
                <div class="pl10 pr10 pb10 pt7">		
               	
                  <div id="slider1" class="slider blog_project_scroll_btn_box ">
                   
					<div class="position_relative">
						<div class="z_index_2 position_relative">
							<a href="#" class="buttons next"></a><a href="#" class="buttons prev mr3 disable"></a>
						</div>
						<!--FAKEDIV-->
						<div class="fakebtn z_index_1">
							<span class="buttons next"></span><span class="buttons prev mr3"></span>
						</div>
					</div>
                    <div class="viewport blog_project_scroll_container">
                      <ul class="overview">
						  <?php 
						  
						  $postsCounter =0;
						  foreach($blogPostsData as $countposts => $row)
						  {
							  //echo '<pre />';
							  //print_r($row);
							$postsCounter++;
							
							if($postsCounter==1) echo $openLi;
							
							$userInfo = showCaseUserDetails($row->custId);
							
							$restrictedPostTitle = getSubString($row->postTitle,40);
							
							if(!isset($row->filePath) || @$row->filePath!=''){
								 $imagePathForEvent = @$row->filePath.'/'.@$row->fileName;
								 $smallImg = addThumbFolder(@$imagePathForEvent,'_s');
							}
							else $smallImg = '';

							$finalSmallImg = getImage($smallImg,$this->config->item('defaultBlogImg_s'));
							$postMediaSrc = '<img src="'.$finalSmallImg.'" alt="'.$restrictedPostTitle.'"  class="review_thumb"  />';
						  
						  ?>						  
                          <div class="blog_project_box mr20">
                            <div class="cell width_109 bdr_Rblogpage minHeight124px">
                              <div class="wp_blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><a href="<?php echo base_url(lang().'/blogs/frontpost/'.$row->custId.'/'.$row->postId);?>"  target="_blank"><?php echo $postMediaSrc; ?></a></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name pt12 pb2"><?php echo $userInfo['userFullName'];?></div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_265 ml20">
                              <div class="clr_555 lineH13 org_anchor_hover"><b><a href="<?php echo base_url(lang().'/blogs/frontpost/'.$row->custId.'/'.$row->postId);?>"  target="_blank"><?php echo $restrictedPostTitle;?></a></b></div>
                              <div class="wp_blog_profile_date pb9"><?php echo date("d F Y", strtotime($row->dateCreated));?></div>
                              <div class="clr_555 minHeight54px"><?php echo getSubString($row->postOneLineDesc,110);?></div>
                              
                             <?php
									//echo '<pre />';print_r($row);
									$cravedALL='';
									$countResult = 0;								
									$craveCount=0;
									$ratingAvg=0;
										$LogSummarywhere=array(
											'entityId'=>$entityId,
											'elementId'=>$row->postId
										);
										$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg',  $LogSummarywhere, '', $orderBy='', '', 1 );
										if($resLogSummary)
										{
											$resLogSummary = $resLogSummary[0];											
											$craveCount = $resLogSummary->craveCount;
											$ratingAvg = $resLogSummary->ratingAvg;
										}else
										{										
											$craveCount=0;
											$ratingAvg=0;
										}
									$loggedUserId=isloginUser();
									
									if($loggedUserId > 0)
									{
										$where=array(
										'tdsUid'=>$loggedUserId,
										'entityId'=>$entityId,
										'elementId'=>$row->postId
										);
										$craveCount=countResult('LogCrave',$where);
										$cravedALL=($craveCount>0)?'cravedALL':'';
									}
									else
									{
										$cravedALL = '';
									}
									
							?>

                              <div class="row pt15 font_size10">
								
								  <div class="cell blogS_crave_btn min_w20 craveDiv<?php echo $entityId.''.$row->postId;?> <?php echo $cravedALL;?>">
								  <?php echo $craveCount;?>
								  </div>
                               	<?php $this->load->view('rating/ratingAvg',array('elementId'=>$row->postId,'entityId'=>$entityId,'ratingAvg'=>$row->ratingAvg,'ratingClass'=>'fr cell mt5 mr20 '));?>
                                                   
                                <span class=" cell blogS_view_btn"><?php echo $row->viewCount; ?></span> </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                         <!--news_box_cell-->
                         
                     
                        <?php 
                        if($postsCounter<3) echo '<div class="seprator_10"></div>';
						if($postsCounter==count($blogPostsData)) echo $closeLi;
						if($postsCounter==3 && $countposts<count($blogPostsData)) {  $postsCounter=0;echo $closeLi;}
                        } 
                        ?>
					  </ul>
					 </div><!-- viewport blog_project_scroll_container --> 						
				 </div><!-- slider1 --> 
				 
				 
				 <div class="clear"></div>			 
			  </div><!-- pl10 pr10 pb10 pt7 -->  
             </div><!-- bdr_purple10 global_shadow bg_white ml40 width_880 -->
			<?php } ?>	
			 <div class="clear"></div>
			 </div>
			<div class="clear"></div>
            </div>
    
<div class="clear"></div>
<div class="seprator_40"></div>
</td>
<script type="text/javascript">
/*tab function*/
selectBox();
	$(document).ready(function(){
		
			$('#slider1').tinycarousel();	
			$('#slider2').tinycarousel();
			$('#slider3').tinycarousel();
			$('#slider4').tinycarousel();
			$('#slider5').tinycarousel();
		
		});
		
function reloadPage(industryId) {
	//var thevalue = industryId;
	//var exists = 0 != $('#industryId option[value='+thevalue+']').length;
   if(industryId == ''){
   window.location.href = baseUrl+language+'/blogs/index';
	}
   else
   window.location.href = baseUrl+language+'/blogs/index/' + industryId;
  
}

</script>
