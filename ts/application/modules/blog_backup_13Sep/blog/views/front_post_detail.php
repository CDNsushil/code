<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php
//echo '<pre />';
//print_r($postData);die;
	

if(strlen($postData->postTitle)>50)
$restrictedPostTitle = substr($postData->postTitle,0,50).'...';
else
$restrictedPostTitle = $postData->postTitle;

	//if filepath is set for any of the post type it will show the respective image else show the no-image 
	if(isset($postData->filePath))
	{
	 if($postData->filePath!='')
		$imagePathForPost= $postData->filePath.'/'.$postData->fileName;
	}
	else 
	{
		$imagePathForPost = 'images/blog/postDeafultImage.jpg';	
	}

$postMediaSrc = '<img class="maxWidth165px maxHeight120px ma"  src="'.getImage($imagePathForPost,'blog/postDeafultImage.jpg').'" alt="'.$restrictedPostTitle.'" />'; 
					
$restrictedPostOneLineDesc = $postData->postOneLineDesc;						
								
								
?>
<div class="row summery_post_wrapper">
	<div class="cell  strip_absolute_right shadow_wp"><!-- <img src="images/strip_blog.png"  border="0"/>-->

		<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td height="271">	<img src="<?php echo base_url()?>images/shadow-top.png"></td>
			</tr>
			<tr>
				<td class="shadow_mid">&nbsp;</td>
			</tr>
			<tr>
				<td height="271"><img src="<?php echo base_url()?>images/shadow-bottom.png"></td>
			</tr>
		</tbody>
		</table>

		<div class="clear"></div>
	</div>                        
    <div class="cell width_480 sub_col_1" id="frontPostsInfo">
                                    
			<div class="liquid_box_wrapper Fleft"  >
			<table  border="0" cellspacing="0" cellpadding="0">
				<!-- TOP SHADOW IMAGE-->
				<tr>
					<td valign="top"><img src="<?php echo base_url()?>images/liquied_top1.png" /></td>
					<td class="liquid_top_mid1">&nbsp;</td>
					<td valign="top"><img src="<?php echo base_url()?>images/liquied_top3.png" /></td>
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
					<td><img src="<?php echo base_url()?>images/liquied_bottom1.png" /></td>
					<td class="liquid_bottom_mid">&nbsp;</td>
					<td><img src="<?php echo base_url()?>images/liquied_bottom3.png" /></td>
				</tr>
			</table>

				<div class="liquid_box_shadow"></div>		
			</div><!--liquid_box_wrapper-->
                                      
				  <div class="cell summery_post_description">
						
						<h1><?php echo $restrictedPostTitle;?></h1>
						
						<div class="industry_type_wrapper">
						<div class="cell font_size11">
						<?php echo $label['industry'];?> <b><?php echo $industryTitle;?></b>
						</div>
						
						<div class="Fright">
						<div class="rating_box_wrapper">
							<div class="rating_box">
							</div>
							<div class="rating_box">
							</div>
							
							<div class="rating_box">
							</div>
							<div class="rating_box">
							</div>
							<div class="rating_box">
							</div>
						  </div><!--rating_box_wrapper-->
						</div>
						<div class="clear"></div>
						<div class="summery_posted_date_wrapper">
						<?php echo $label['postedOn'];?> &nbsp; <b class="orange_color"><?php echo dateFormatView($postData->dateCreated);?></b>
						</div><!--summery_posted_date_wrapper--->
						
						</div><!--industry_type_description-->
						
				  </div> <!--summery_post_description-->                                      
                                     
				<div class="row">
			   
					<p><?php echo $restrictedPostOneLineDesc; ?></p>
				
				</div>	
                                        
                <div class="seprator_45"></div>                             				
				<div class="row blog_links_wrapper bdr_top_btm">
				<?php

				// Show view page for getshortLink ,email,share,invite and postOnPost
				// entityTitle:Title of page you want to share
				// shareType: text(like:post,film and video etc)
				// shareLink: url to get shared with users
				
				$currentUrl = $this->config->site_url().$this->uri->uri_string();
				$relation = array('getShortLink','email','share','postOnPost','entityTitle'=>$postData->postTitle,'shareType'=>'post','shareLink'=>$currentUrl);
				echo Modules::run("common/loadRelations",$relation); 
				?>
				</div>
				<?php
				//GET TOTAL CHILD POST PRESENT
						   
				$totalPostChild = countResult($postsTable,"parentPostId",$postData->postId);
				if($totalPostChild>0)
				{
				   ?>                                        
				  <div class="row blog_links_wrapper bdr_btm">
						<span ><?php echo anchor('blog/childPosts/'.$postData->postId.'/'.$postData->blogId,'<b>'.$label['seePosts'].'</b>',array('class'=>"icon_see_post")); ?></span>
						
					  <div class="clear"></div>   
				  </div><!--blog_links_wrapper-->
				   <?php
				}

				?>                                     
				<div class="row blog_links_wrapper bdr_btm">
					<b><?php echo $label['tags'];?> </b><p><?php echo $postData->postTagWords; ?></p>
				  <div class="clear"></div>   
			    </div><!--blog_links_wrapper-->
			  
			    <div class="seprator_45"></div>
</div><!--widht_500-->                        
     
     <div class="cell width_311 right_panel_gray_bg sub_col_2">	
	<?php
		echo Modules::run("blog/frontRight",$postData->blogId);
	?>
</div>                               
                            
                            
</div>
<?php //
?> 
