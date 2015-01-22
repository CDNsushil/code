<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$totalRecords = $postQuery->num_rows();

?>

<div id="pagingContent" >
<?php
 if($totalRecords > 0)
 {
 $flag =0;
  foreach($postResults as $row)
  {
	
	?>
	<div class="all_list_item ">
	<div class="row blog_wrapper bg_light_gray">
	  <div class="blog_box bg_white">
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
			<div class="cell padding_top10"> <b class="orange_color"><?php echo $label['createdOn'];?>:</b> <b><?php echo date("l F d  Y", strtotime($row->dateCreated));?> </b> </div>
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
		 <div class="row blog_links_wrapper">
		  <?php
			
			// Show view page for getshortLink ,email,share,invite and postOnPost
			// entityTitle:Title of page you want to share
			// shareType: text(like:post,film and video etc)
			// shareLink: url to get shared with users
			$currentUrl = $this->config->site_url().$this->router->class.'/frontPostDetail/'. $row->postId;
			$relation = array('getShortLink','email','share','entityTitle'=> addslashes($row->postTitle), 'shareType'=>$label['posts'], 'shareLink'=> $currentUrl, 'id'=> 'post'.$row->postId);
			echo Modules::run("common/loadRelations",$relation); 

		?>
		</div>
		<!--blog_links_wrapper-->
		</div>
		<div class="blog_right_wrapper">
		  <div class="blog_link2_wrapper">
			<div class="post_text"><?php echo $label['posts'];?></div>
			<div class="tds-button-top modifyBtnWrapper"> 
			  <?php if($flag ==1){?>
				<!-- Post Edit Icon -->
				<?php echo anchor('blog/postForm/'.$row->postId, '<span>
				<div class="projectEditIcon"></div>
				</span>',array('class'=>'formTip','title'=>$label['Edit']));?>
				<?php } 

				$previewUrl = '/blog/previewPost';

				echo anchor('javascript://void(0);', 
				'<span><div class="projectPreviewIcon"></div></span>',				
				array('class'=>'formTip',
				'title'=>$label['postPreview'],
				'onclick'=>'openUserLightBox(\'postPreviewBoxWp\',\'postPreviewFormContainer\',\''.$previewUrl.'\',\''.encode($row->postId).'\');'));

				if($flag ==1){?>
				<!-- Post Delete Icon -->
				<?php 
				$url = 'blog/archivePost/'.$row->postId;
				echo anchor('javascript://void(0);', '<span><div class="projectDeleteIcon"></div></span>',array('class'=>'formTip','title'=>$label['Delete'],'onclick'=>'DeleteAction(\''.$url.'\');'));
				?>
				<?php } ?>
			  </div>
		  </div>
		  <div class="clear"></div>
		  <div class="rating_box_wrapper padding_top10">
			<div class="rating_box"> </div>
			<div class="rating_box"> </div>
			<div class="rating_box"> </div>
			<div class="rating_box"> </div>
			<div class="rating_box"> </div>
		  </div>
		  <!--rating_box_wrapper-->
		  <div class="clear"></div>
		  <div class="blog_link3_wrapper">
			<div class="blog_link3_box">
			  <div class="icon_crave2_blog"> <?php echo $label['blogCraves'];?> </div>
			  <div class="blog_link3_point"> <?php print($row->postCraveCount == '' ? '0' : $row->postCraveCount ); ?> </div>
			</div>
			<div class="blog_link3_box">
			  <div class="icon_view2_blog"> <?php echo $label['blogViews'];?> </div>
			  <div class="blog_link3_point"> <?php print($row->postViewCount == '' ? '0' : $row->postViewCount );?> </div>
			</div>
			<div class="blog_link3_box">
			  <div class="icon_post2_blog"> <?php echo $label['postCount'];?> </div>
			  <div class="blog_link3_point"> <?php print($totalPostChild == '' ? '0' : $totalPostChild );?> </div>
			</div>
			<div class="blog_link3_box">
			  <div class="icon_lastview2_blog"> Last Viewed<br/>
				<b>17 May 2012</b> </div>
			</div>
		  </div>
		</div>
		<div class="clear"></div>
	  </div>
	  <!--blog_box-->
	</div>
	<div class="shadow_blog_box"> </div>
	</div><!-- End all_list_item -->
<?php
  }//End For
 }//End If
else 
{
	echo '<div class="row blog_wrapper bg_light_gray">';
	echo '<div class="blog_box bg_white">';
	echo '<div class="norecordfound">'.$label['noPost'].'</div>';
	echo '</div>';
	echo '</div>';
}
?>
</div>	<!-- End pagingContent -->


<?php 

if(strcmp($this->router->method,'index')!=0) 
{
	echo '</div>';
	echo '</div>';
}	
?>
<div class="clear"></div>
<div class="row">	
	<div class="cell width_569 pagingWrapper">
	<?php
		$post_page['record_num'] = 3;
		if($totalRecords > $post_page['record_num']) $this->load->view('pagination_view',$post_page);

	?>
	</div>
</div>

<script language="javascript" type="text/javascript">
function DeleteAction(work)
{	 
	var conBox = confirm("Are you sure you want to delete the selected record." );
	if(conBox){
		location.href = work;
	}
	else{
		return false;
	}	
}
</script>
