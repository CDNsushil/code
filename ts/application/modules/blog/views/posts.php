<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if(isset($postResults) && is_array($postResults) && count($postResults) > 0){
 $isAnyItemBlocked=isAnyItemBlocked($postResults,true);
 
 $postsTable='Posts';
 $flag =0;
 
 $i=0;
  foreach($postResults as $row)
  {
	$i++;
	$uniqueId='element'.$row->postId;
	$viewCount = 0;
	$craveCount = 0;
	$ratingAvg = 0;
	$isArchive= $row->postArchived;
	$LogSummarywhere = array(
				'entityId'=>$entityId,
				'elementId'=>@$row->postId
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
	$loggedUserId = @$row->custId;
	if($loggedUserId > 0){
		$where = array(
					'tdsUid'=>$loggedUserId,
					'entityId'=>$entityId,
					'elementId'=>@$row->postId
				);
		$countResult = countResult('LogCrave',$where);
		$cravedALL = ($countResult>0)?'admin_cravedALL':'';
	}else
	{
		$cravedALL = '';
	}
	
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
	
	$isBlocked=$row->isBlocked;
	$redBorder3px=($isBlocked=='t')?'redBorder3px':'';
	
	if($i==1 && ($isArchive=='t' || $isAnyItemBlocked==true)){
		if($isArchive=='t'){
			$this->load->view('common/deletedItemMsg');
		}
		if($isAnyItemBlocked==true){
			$this->load->view('common/illegalMsg');
		}
	}?>
	<div class="row blog_wrapper bg_white new_theme_blog_box_gray <?php echo $redBorder3px;?>">
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
			<h2 class="main_blog_heading">
				<?php
				
				//counts the total child post for this posts
				 $totalPostChild = countResult($postsTable,"parentPostId",$row->postId);				
				
					if(strlen($row->postTitle)>50)
						$restrictedPostTitle = substr($row->postTitle,0,50).'...';
					else
						$restrictedPostTitle = $row->postTitle;

				if(LoginUserDetails('user_id') == $row->custId) $flag = 1; //give visiblity to edit delete button only if the post is posted by loggen in user
				else $flag=0
				?>
				<?php echo $restrictedPostTitle; ?>
			</h2>
		  </div>
		  <div class="row">
			<div class="cell padding_top10"> <b class="orange_color"><?php echo $this->lang->line('posted');?></b>&nbsp;&nbsp;<b><?php echo date("l, d F Y", strtotime($row->dateCreated));?> </b> </div>
		  </div>
		  <div class="seprator_10 row"></div>
		  <div class="row"> 
		  
		  <b class="orange_color"><?php echo $label['blogOneLineDesc'];?></b>
			<?php if(strlen($row->postOneLineDesc)>200)
					$restrictedPostOneLineDesc = substr($row->postOneLineDesc,0,200).'...';
				  else
					$restrictedPostOneLineDesc = $row->postOneLineDesc;
			?>
			<p><?php echo $restrictedPostOneLineDesc; ?></p>
			
			<div class="seprator_10"></div>
			
			<b class="orange_color"><?php echo $label['blogTagWords'];?></b>
			<p>
				<?php if(strlen($row->postTagWords)>120)
						$restrictedPostTagWords = substr($row->postTagWords,0,120).'...';
					else
					$restrictedPostTagWords = $row->postTagWords;
				echo $restrictedPostTagWords; ?>
			</p>
			
		  </div>
		<!--<div><a href="javascript:void(0);" onclick="test_notification()">Test Notification</a></div>-->
		<!--blog_links_wrapper-->
		</div>
		<div class="blog_right_wrapper">
		  <div class="blog_link2_wrapper">
			<div class="post_text"><?php echo $label['posts'];?></div>
			<div class="tds-button-top modifyBtnWrapper"> 
			  <?php 
			  
			  if($isArchive=='t' && $flag ==1){
					if($isBlocked == 'f'){ ?>
						<a class="formTip" href="javascript:void(0);" title="<?php echo $this->lang->line('restore');?>" onclick="moveFromArchive('','Posts','postId','<?php echo $row->postId; ?>','postArchived','/blog/showArchives','','','','');"><span><div class="restore_btn_icon"></div></span></a>
						<!--<a class="formTip" href="javascript:void(0);" title="<?php //echo $this->lang->line('unArchive');?>" onclick="moveFromArchive('','Posts','postId','<?php //echo $row->postId; ?>','postArchived','/blog/showArchives','','','','');"><span><div class="blogUnArchiveIcon"></div></span></a>-->
						<a href="javascript:void(0);" class="formTip ml6" title="<?php echo $this->lang->line('delete');?>" onclick="deleteTabelRow('Posts','postId','<?php echo $row->postId;?>','','','','<?php echo $row->postFileId;?>','',1,'','1','<?php echo $this->lang->line('sureDelMsg') ?>')"><span><div class="projectDeleteIcon"></div></span></a> 
						<?php
					}
			  }else{ 
				  
				if($flag ==1){
					echo anchor('blog/postForm/'.$row->postId, '<span><div class="projectEditIcon"></div></span>',array('class'=>'formTip','title'=>$label['Edit']));
				}
				
				$viewLink = 'blogshowcase/frontPostDetail/'.$userId.'/'.$row->postId;
				$viewTooltip=$this->lang->line('view');
				
				$previewTooltip=$this->lang->line('preview');
				$previewLink = 'blogshowcase/preview/'.$userId.'/'.$row->postId.'/frontPostDetail';
									 
				?>
				<a id="viewIcon<?php echo $uniqueId;?>" class="formTip ml6 viewIcon" <?php echo $viewDisplay;?> target="_blank" href="<?php echo base_url($viewLink);?>" title="<?php echo $viewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
				<a id="previewIcon<?php echo $uniqueId;?>" class="formTip ml6 previewIcon" <?php echo $previewDisplay;?> target="_blank" href="<?php echo base_url($previewLink);?>" title="<?php echo $previewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
				<?php
				
				if($flag ==1){?>
					<a href="javascript:void(0);" class="formTip ml6" title="<?php echo $this->lang->line('delete');?>" onclick="moveInArchive('','Posts','postId','<?php echo $row->postId; ?>','postArchived','isPublished','/blog/index','','','','','')"><span><div class="projectDeleteIcon"></div></span></a> 
					<?php
				} 
			 }
			?>
		  </div>
		  </div>
		  <div class="clear"></div>
		  <div class="rating_box_wrapper padding_top10">
			<img class="fr" src="<?php echo $ratingImg;?>" />
		  </div>
		  <!--rating_box_wrapper-->
		  <div class="clear"></div>
		  <div class="blog_link3_wrapper">
			<div class="blog_link3_box">
			 <div class="cell pt2 icon_crave2_blog crave craveDiv<?php echo $entityId.''.$row->blogId?> <?php echo $cravedALL;?>"> <?php echo $this->lang->line('craves') ;?> </span></div>			
			  <div class="blog_link3_point"><?php print($craveCount == '' ? '0' : $craveCount ); ?> </div>
			</div>
			
			<div class="blog_link3_box">
			  <div class="icon_post2_blog"> <?php echo $label['postResponseCount'];?> </div>
			  <div class="blog_link3_point"> <?php print($totalPostChild == '' ? '0' : $totalPostChild );?> </div>
			</div>
			
			<div class="blog_link3_box">
			  <div class="icon_view2_blog"> <?php echo $this->lang->line('Views') ;?> </div>
			  <div class="blog_link3_point"> <?php print($viewCount == '' ? '0' : $viewCount );?> </div>
			</div>
			
			<div class="blog_link3_box">
			  <div class="icon_lastview2_blog"> 
				<?php echo $this->lang->line('Lastview') ;?><br/>
				<b><?php echo date('d M Y');?></b>
			  </div>													
			</div>	
			
				
		  </div>
		</div>
		 <div class="row blog_links_wrapper">
			 <div class="fl  pt0 ml12 cell">
				 <?php				
					$currentUrl = base_url(lang().'/blogshowcase/frontPostDetail/'.$userId.'/'.$row->postId);				
					
					$relation = array('getShortLink','email','share','entityTitle'=> addslashes($row->postTitle), 'shareType'=>$label['posts'], 'shareLink'=> $currentUrl, 'id'=> 'post'.$row->postId,'isPublished'=>$row->isPublished);
					
				?>
				<div id="relationToSharePublish<?php echo $uniqueId;?>" class="row rtsp" <?php echo $rtspDisplay; ?> >
					<?php $relation['isPublished']='t';
					 $this->load->view('common/relation_to_share',array('relation'=>$relation));
					 ?>
				</div>
				
				<div id="relationToShareUnPublish<?php echo $uniqueId;?>" class="row rtsup" <?php echo $rtsupDisplay; ?>>
					<?php $relation['isPublished']='f';
					 $this->load->view('common/relation_to_share',array('relation'=>$relation));
					 ?>
				</div>
			</div>
			
										
			 <?php			
				if($isArchive=='f' && $isBlocked=='f'){ 
					$userFullName = LoginUserDetails('firstName').' '.LoginUserDetails('lastName');
					
					$notificationArray = array('entityId'=>$entityId,'ownerId'=>$row->custId,'elementId'=>$row->postId,'projectId'=>$row->blogId,'industryId'=>$blogIndustry,'projectType'=>'blog','alert_type'=>'element');
					
					
					$publisButton=array('currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','tabelName'=>'Posts','pulishField'=>'isPublished','projModifiedDate' => date("Y-m-d H:i:s"),'field'=>'postId','fieldValue'=>$row->postId,'deleteCache'=>$this->router->fetch_method(),'isElement'=>1,'notificationArray'=>$notificationArray);
					$unpublisButton=array('currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','tabelName'=>'Posts','pulishField'=>'isPublished','projModifiedDate' => date("Y-m-d H:i:s"),'field'=>'postId','fieldValue'=>$row->postId,'deleteCache'=>$this->router->fetch_method(),'isElement'=>1,'notificationArray'=>$notificationArray);
					
					?>
					
					<div id="PublishButton<?php echo $uniqueId;?>" class="cell fr PublishButton" <?php echo $pDisplay; ?>>
						<?php  $this->load->view('common/publishUnpublish',$publisButton); ?>
					</div>
					
					<div id="UnPublishButton<?php echo $uniqueId;?>" class=" cell fr UnPublishButton" <?php echo $upDisplay; ?>>
						<?php $this->load->view('common/publishUnpublish',$unpublisButton);?>
					</div>
					<?php
				}

			?>
			
			
		</div>
		<div class="clear"></div>
	  </div>
	  <!--blog_box-->
		
	</div><!-- End all_list_item -->
	<div class="shadow_blog_box"> </div>
	<?php
  }//End For
  if(isset($items_total) && isset($perPageRecord) && ($items_total >  $perPageRecord)){
		?>
		<div class="row">
			<div class=" cell width_200 Cat_wrapper">&nbsp;</div>
			<div class="cell width_569  pagingWrapper">
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>$pagingLink,"divId"=>"postsInfo","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design ',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design ')); ?>
				<div class="clear"></div>
			</div>
		</div>
		<?php
	} 
 }//End If
else{
	
}
?>
<?php echo form_close();?> 
<div class="clear"></div>
<div class="clear seprator_10"></div>

