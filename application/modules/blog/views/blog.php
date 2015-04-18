<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$this->session->set_userdata('postId');?>
<div id="postPreviewBoxWp" class="postPreviewBoxWp">
	<div id="close-postPreviewBox" title="" class="tip-tr close-customAlert"></div>			
	<div class="postPreviewFormContainer" id="postPreviewFormContainer"></div><!--End Div postPreviewFormContainer-->
</div><!--End Div postPreviewBoxWp-->

<? if($this->session->flashdata('success_msg')){?>
	<span class="message success_info">
		<?php echo $this->session->flashdata('success_msg');?>
	</span>
<? }?>
<? if($this->session->flashdata('error_msg')){?>
	<span class="message error_info">
		<?php echo $this->session->flashdata('error_msg');?>
	</span>
<? }

foreach($query as $row){
	//echo "<pre />"; print_r($row);
	//echo $row->blogId;

	$lableNewPost = '<span>'.$label['newPost'].'</span>';
	$labelBlogSetting = '<span>'.$label['blogSetting'].'</span>';
	$labelBlogArchive = '<span>'.$label['blogDelItems'].'</span>';
	}
	$data['blogId'] = $row->blogId;
	
	$viewCount = 0;
	$craveCount = 0;
	$ratingAvg = 0;

	$LogSummarywhere = array(
				'entityId'=>$entityId,
				'elementId'=>$row->blogId
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
	$ratingImg=base_url('images/rating/rating_0'.$ratingAvg.'.png');
	$cravedALL = '';
	$loggedUserId = $userId;
	if($loggedUserId > 0){
		$where = array(
					'tdsUid'=>$loggedUserId,
					'entityId'=>$entityId,
					'elementId'=>$row->blogId
				);
		$countResult = countResult('LogCrave',$where);
		$cravedALL = ($countResult>0)?'admin_cravedALL':'';
	}else
	{
		$cravedALL = '';
	}
	$isBlocked='project'.$row->isBlocked;
	$uniqueId='project'.$row->blogId;
	if($row->isPublished == 't'){
		$viewDisplay='';
		$previewDisplay='style="display: none;"';
		
		$rtspDisplay='';
		$rtsupDisplay='style="display: none;"';
		
		$pDisplay='';
		$upDisplay='style="display: none;"';
	}else{
		$viewDisplay='style="display: none;"';
		$previewDisplay='';
		
		$rtspDisplay='style="display: none;"';
		$rtsupDisplay='';
		
		$pDisplay='style="display: none;"';
		$upDisplay='';
	}
?>
<div class="row">
	<div class="cell frm_heading">
			<h1><?php echo $label['indexPage'];?></h1>
	</div>
	<?php echo Modules::run("blog/navigationMenu",$data); ?>
</div>
	<?php 	echo Modules::run("common/strip"); ?>
<div class="row padding_top10 position_relative">
  <div class="cell width_200">
	<div class="box-min-height">
	  <div class="liquid_box_wrapper">
		  <?php
		  						
			if(!isset($row->filePath) || @$row->filePath!='')
			{
				 $imagePathForEvent = @$row->filePath.@$row->fileName;
				 $smallImg = addThumbFolder(@$imagePathForEvent,'_s');
			}
			else $smallImg = '';

			$imgsrc = getImage($smallImg,$this->config->item('defaultBlogImg_s'));
		
		 ?>				
		<table  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td valign="top"><img src="<?php echo base_url()?>images/liquied_top1.png" /></td>
			<td class="liquid_top_mid1">&nbsp;</td>
			<td valign="top"><img src="<?php echo base_url()?>images/liquied_top3.png" /></td>
		  </tr>
		  <tr>
			<td class="liquid_mid1">&nbsp;</td>
			<td><img border="0"  class="maxWidth165px maxHeight200px" src="<?php echo $imgsrc;?>" /></td>
			<td class="liquid_mid2">&nbsp;</td>
		  </tr>
		  <tr>
			<td><img src="<?php echo base_url()?>images/liquied_bottom1.png" /></td>
			<td class="liquid_bottom_mid">&nbsp;</td>
			<td><img src="<?php echo base_url()?>images/liquied_bottom3.png" /></td>
		  </tr>
		</table>
		<div class="liquid_box_shadow"> </div>
	  </div>
	  <!--liquid_box_wrapper-->
	</div>
	<!--box-min-height-->
	<div class="Cat_wrapper">
		<?php		
		//This shows posts related with blog	
		$frontFlag = 0;
		echo Modules::run("blog/blogArchive",$row->blogId,$frontFlag,$userId,$isArchive);
		?>
	</div>
	<div class="seprator_35"> </div>
	<div class="Cat_wrapper">
		<?php
		echo Modules::run("blog/blogCategories",$row->blogId,$frontFlag,$userId,$isArchive);
		?>
	</div>
	<div class="seprator_20"></div>
	<!--How to publish popup -->
	<?php 
	//$this->load->view('common/howToPublish',array('industryType'=>'blog'));
	?>
	<!--End How to publish popup -->
  </div>
  
  <div class="cell width_569 padding_left16">
	<?php if($isArchive !='t' && $isBlocked !='t'){ ?>
		<div class="row blog_wrapper new_theme_blog_box_gray">
		 <div class="toggle_btn"></div>
		  <div class="blog_box">
			  <div class="one_side_small_shadow">
                    		<table width="100%"  height="100% "border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td height="97"><img  src="<?php echo base_url('images/published_shadow_top.png');?>" /></td>
							  </tr>
							  <tr>
								<td class="publish_shad_mid">&nbsp;</td>
							  </tr>
							  <tr>
								<td height="97"><img   src="<?php echo base_url('images/published_shadow_bottom.png');?>" /></td>
							  </tr>
							</table>
                    </div><!--one_side_small_shadow-->
                    
			<div class="cell blog_left_wrapper">
			  <div class="row">
				<h2 class="main_blog_heading"> <?php echo $row->blogTitle; ?> </h2>
			  </div>
			  <div class="row">
				<div class="cell padding_top10"> <b class="orange_color"><?php echo $this->lang->line('created');?></b> <b> &nbsp; <?php echo date("l, d F Y", strtotime($row->dateCreated));?> </b> </div>
			  </div>
			  <div class="seprator_10 row"></div>
			  <div class="row"> 
				<b class="orange_color"><?php echo $label['blogOneLineDesc'];?></b>
				<p><?php echo getSubString($row->blogOneLineDesc,200); ?></p>
				<div class="seprator_10"></div>
				<b class="orange_color"><?php echo $label['blogTagWords'];?> </b>
				<p><?php echo getSubString($row->blogTagWords,120); ?></p>
			  </div>
			 </div>
			  <!--blog_links_wrapper-->
			
			<div class="blog_right_wrapper">
			  <div class="blog_link2_wrapper">
				<div class="blog_text drkGrey"><?php echo $this->lang->line('blog');?></div>
				<div class="tds-button-top"> 
				  
					<!--<a href="<?php echo base_url(lang().'/blog/postForm/0');?>" class="formTip" title="<?php echo $this->lang->line('addPost');?>"   >
						<span><div class="projectAddIcon"></div></span>
					</a> -->
				  <?php echo anchor('blog/blogForm/'.$row->blogId, '<div class="projectEditIcon"></div>',array('class'=>'formTip','title'=>$label['Edit']));?>
					<?php
								
						$viewLink='blogshowcase/frontblog/'.$userId;
						$viewTooltip=$this->lang->line('view');
						
						$previewTooltip=$this->lang->line('preview');
						$previewLink='blogshowcase/preview/'.$userId.'/'.$row->blogId.'/frontblog';
						?>
						
						
						<a id="viewIcon<?php echo $uniqueId;?>" class="formTip ml6 viewIcon" <?php echo $viewDisplay;?> target="_blank" href="<?php echo base_url($viewLink);?>" title="<?php echo $viewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
						<a id="previewIcon<?php echo $uniqueId;?>" class="formTip ml6 previewIcon" <?php echo $previewDisplay;?> target="_blank" href="<?php echo base_url($previewLink);?>" title="<?php echo $previewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
		
				</div>
			  </div>
			  
			  <div class="clear"></div>
			  <div class="rating_box_wrapper">
				<img class="fr" src="<?php echo $ratingImg;?>" />
			  </div>
			  <!--rating_box_wrapper-->
			  <div class="clear"></div>
			  
				<div class="blog_link3_box">
				  <div class="icon_crave2_blog crave <?php echo $cravedALL;?> "><?php echo $label['blogCraves'];?></div>
				  <div class="blog_link3_point"><?php print($craveCount == '' ? '0' : $craveCount ); ?> </div>
				</div>
				
				<div class="blog_link3_box">
				  <div class="icon_post2_blog"><?php echo $label['postCount'];?> </div>
				  <div class="blog_link3_point"><?php print($totalPosts == '' ? '0' : $totalPosts);?></div>
				</div>
				
				<div class="blog_link3_box">
				  <div class="icon_view2_blog"><?php echo $label['blogViews'];?> </div>
				  <div class="blog_link3_point"> <?php print($viewCount == '' ? '0' : $viewCount );?> </div>
				</div>			
				
				<div class="blog_link3_box">
				  <div class="icon_lastview2_blog"> 
					<?php echo $this->lang->line('Lastview') ;?><br/>
					<b><?php echo date('d M Y');?></b>
				  </div>													
				
				</div>	
			  </div>
			<div class="row blog_links_wrapper">
				<?php				
				$currentUrl = base_url(lang().'/blogshowcase/frontBlog/'.$userId);
				$relation = array('getShortLink','email','share','entityTitle'=> addslashes($row->blogTitle), 'shareType'=>$label['posts'], 'shareLink'=> $currentUrl, 'id'=> 'blog'.$row->blogId,'isPublished'=>$row->isPublished);			
				//echo Modules::run("common/loadRelations",$relation); 
				?>
				
				<div id="relationToSharePublish<?php echo $uniqueId;?>" class="cell rtsp" <?php echo $rtspDisplay; ?>>
					<?php $relation['isPublished']='t';
					 $this->load->view('common/relation_to_share',array('relation'=>$relation));
					 ?>
				</div>
				
				<div id="relationToShareUnPublish<?php echo $uniqueId;?>" class="cell rtsup" <?php echo $rtsupDisplay; ?>>
					<?php $relation['isPublished']='f';
					 $this->load->view('common/relation_to_share',array('relation'=>$relation));
					 ?>
				</div>
				
				<?php
				$publisButton=array('isFARF'=>1,'currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','tabelName'=>'Blogs','pulishField'=>'isPublished','field'=>'blogId','fieldValue'=>$row->blogId,'deleteCache'=>'', 'elementTable'=>'', 'elementField'=>'','sessionMsg'=>'','isElement'=>0,'notificationArray'=>'');
				$unpublisButton=array('isFARF'=>$isFARF,'currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','tabelName'=>'Blogs','pulishField'=>'isPublished','field'=>'blogId','fieldValue'=>$row->blogId,'deleteCache'=>'', 'elementTable'=>'', 'elementField'=>'','sessionMsg'=>'','isElement'=>0,'notificationArray'=>'');
				?>
				
				<div id="PublishButton<?php echo $uniqueId;?>" class="cell fr PublishButton" <?php echo $pDisplay; ?>>
					<?php $this->load->view('common/publishUnpublish',$publisButton);?>
				</div>
				
				<div id="UnPublishButton<?php echo $uniqueId;?>" class=" cell fr UnPublishButton" <?php echo $upDisplay; ?>>
					<?php $this->load->view('common/publishUnpublish',$unpublisButton);?>
				</div>
		<!--<span ><a class="icon_invite">Invite</a></span>-->
			 </div>
			 <div class="clear"></div>
			  
		 </div>
			<div class="seprator_10 clear"></div>
	  </div> 
		 <!----------------blog_box------------------> 
		 <div class="shadow_blog_box"> </div>
		 
		<?php
	}?>
	
	<!----------------- Starts Posts Info ----------------> 
		<div id="postsInfo">
		<?php 
			$defaultPostAttr['showFlag'] = 0;
			$defaultPostAttr['limitPosts'] = 0;
			//This shows posts related with blog
			echo Modules::run("blog/posts",$row->blogId,'',$defaultPostAttr,$isArchive); 
		?>	<!--blog_wrapper-->
		</div>
	</div>
	<!------------------- End Posts Info ----------------->
	<div class="row"></div>
	<div class="seprator_5 row"></div>
	
  </div><!--cell_withd559-->
 <div class="clear"></div>


