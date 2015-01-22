<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->session->set_userdata('postId');?>
<div id="postPreviewBoxWp" class="postPreviewBoxWp">
	<div id="close-postPreviewBox" title="Close it" class="tip-tr close-customAlert"></div>			
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
?>
<?php
	$lableNewPost = '<span>'.$label['newPost'].'</span>';
	$labelBlogSetting = '<span>'.$label['blogSetting'].'</span>';
	$labelBlogArchive = '<span>'.$label['blogDelItems'].'</span>';
	}
	$data['blogId'] = $row->blogId;
?>
<div class="row">
	<!-- TOP NAVIGATION-->
	<?php echo Modules::run("blog/navigationMenu",$data); ?>
</div>
<div class="row padding_top10 position_relative">
  <div class="cell width_200">
	<div class="box-min-height">
	  <div class="liquid_box_wrapper">
		  <?php
			
			//if filepath is set for any of the blog type it will show the respective image else show the default image
			if(isset($row->filePath))
			{				
				 if($row->filePath!='' || file_exists(ROOTPATH.$row->filePath.'/'.$row->fileName))
					$blogImagePath= $row->filePath.'/'.$row->fileName;
				 else
					$blogImagePath = 'blog/blogDefaultImage.jpg';
			}
			else 
			{
				$blogImagePath = 'blog/blogDefaultImage.jpg';	
			}
			
				
			//TO DISPLAY IMAGE USING RESIZE MODULE
			$imgsrc = getImage($blogImagePath,'blog/blogDefaultImage.jpg');
					
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
		echo Modules::run("blog/blogArchive",$row->blogId,$frontFlag);
		?>
	</div>
	<div class="seprator_35"> </div>
	<div class="Cat_wrapper">
		<?php
		echo Modules::run("blog/blogCategories",$row->blogId,$frontFlag);
		?>
	</div>
  </div>
  <div class="cell shadow_wp strip_absolute "><!-- <img src="images/strip_blog.png"  border="0"/>-->
		<table  height="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td height="271">	<img src="<?php echo base_url('images/shadow-top.png')?>"/></td>
		</tr>
		<tr>
		<td class="shadow_mid">&nbsp;</td>
		</tr>
		<tr>
		<td height="271"><img src="<?php echo base_url('images/shadow-bottom.png')?>"/></td>
		</tr>
		</table>
	 <div class="clear"></div>
	</div>
	
  <div class="cell width_569 padding_left16">
	<div class="row blog_wrapper">
		
	<!---------------------------------------------------->	
	<!-- DIV TO GET SLIDE DOWN HERE CONTANING BLOG INFO -->
	<!---------------------------------------------------->
	<div class="toggle_btn"></div>
	
	  <div class="blog_box">
		<div class="cell blog_left_wrapper">
		  <div class="row">
			<h2 class="main_blog_heading"> <?php echo $row->blogTitle; ?> </h2>
		  </div>
		  <div class="row">
			<div class="cell padding_top10"> <b class="orange_color">Created on:</b> <b> &nbsp; <?php echo date("l F d  Y", strtotime($row->dateCreated));?> </b> </div>
		  </div>
		  <div class="seprator_10 row"></div>
		  <div class="row"> <b class="orange_color"><?php echo $label['blogOneLineDesc'];?></b>
			<p>
				<?php if(strlen($row->blogOneLineDesc)>200)
						$restrictedBlogOneLineDesc = substr($row->blogOneLineDesc,0,200).'...';
					else
					$restrictedBlogOneLineDesc = $row->blogOneLineDesc;
				echo $restrictedBlogOneLineDesc; ?></p>
			<div class="seprator_10"></div>
			<b class="orange_color"><?php echo $label['blogTagWords'];?> </b>
			<p>
				<?php if(strlen($row->blogTagWords)>120)
						$restrictedBlogTagWords = substr($row->blogTagWords,0,120).'...';
					else
					$restrictedBlogTagWords = $row->blogTagWords;
				echo $restrictedBlogTagWords; ?>
			</p>
		  </div>
		  <div class="row blog_links_wrapper">
			   <?php
			
			// Show view page for getshortLink ,email,share,invite and postOnPost
			// entityTitle: Title of page you want to share
			// shareType: text(like: post,film and video etc)
			// shareLink: url to get shared with users
			$currentUrl = $this->config->site_url().$this->router->class.'/frontBlog/'. $row->blogId;
			
			$relation = array('getShortLink','email','share','entityTitle'=> addslashes($row->blogTitle), 'shareType'=>$label['posts'], 'shareLink'=> $currentUrl, 'id'=> 'blog'.$row->blogId);
			
			echo Modules::run("common/loadRelations",$relation); 

		?>
			<!--<span ><a class="icon_invite">Invite</a></span>-->
		  </div>
		  <!--blog_links_wrapper-->
		</div>
		<div class="blog_right_wrapper">
		  <div class="blog_link2_wrapper">
			<div class="blog_text">Blog</div>

			<div class="tds-button-top"> 
			  <?php echo anchor('blog/blogForm/'.$row->blogId, '
			  <div class="projectEditIcon"></div>
			  ',array('class'=>'formTip','title'=>$label['Edit']));?>
			</div>

			<!--icon_edit_blog-->
		  </div>
		  <div class="clear"></div>
		  <div class="rating_box_wrapper">
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
			  <div class="blog_link3_point"> <?php print($row->blogCraveCount == '' ? '0' : $row->blogCraveCount ); ?> </div>
			</div>
			<div class="blog_link3_box">
			  <div class="icon_view2_blog"> <?php echo $label['blogViews'];?> </div>
			  <div class="blog_link3_point"> <?php print($row->blogViewCount == '' ? '0' : $row->blogViewCount );?> </div>
			</div>
			<div class="blog_link3_box">
			  <div class="icon_post2_blog"> <?php echo $label['postCount'];?> </div>
			  <div class="blog_link3_point"><?php print($totalPosts == '' ? '0' : $totalPosts);?></div>
			</div>
			<div class="blog_link3_box">
			  <div class="icon_lastview2_blog"> Last Viewed<br/>
				<b>17 May 2012</b> </div>
			</div>
		  </div>
		</div>
		<div class="clear"></div>
	  </div> 
	  
	 <!----------------blog_box------------------> 
	 
	 </div>
	<!--blog_wrapper-->
	<div class="shadow_blog_box"> </div>
	<!--shadow_blog_box-->
	
	<!----------------- Starts Posts Info ----------------> 
		<div id="postsInfo">
		<?php 
			$defaultPostAttr['showFlag'] = 0;
			$defaultPostAttr['limitPosts'] = 0;
			//This shows posts related with blog
			echo Modules::run("blog/posts",$row->blogId,'',$defaultPostAttr); 
		?>	<!--blog_wrapper-->
		</div>
	<!------------------- End Posts Info ----------------->
	<div class="row"></div>
	<div class="seprator_5 row"></div>
  </div><!--cell_withd559-->
 <div class="clear"></div>

</div>
