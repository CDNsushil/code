<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?php echo base_url();?>templates/system/javascript/jquery-plugin/tipsy-1.0/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/system/javascript/common/tipsy-common.js"></script>
<?php

//if filepath is set for any of the post type it will show the respective image else show the no-image 
	if($values->postId==0)
	{
		$imagePathForPost = 'images/blog/postDeafultImage.jpg';	
	}
	else
	{
		if(isset($values->filePath))
		{
		 if($values->filePath!='')
			$imagePathForPost= $values->filePath.'/'.$values->fileName;
		}
		else 
		{
			$imagePathForPost = 'images/blog/postDeafultImage.jpg';	
		}
	}
	
$postMediaSrc = '<img class="maxWidth165px maxHeight120px ma"  src="'.getImage($imagePathForPost).'" />'; 
					
					
$replacer = 'src="'.base_url().'media';
								
								
?>
<div class="row">
                           
    <div class="cell minMaxWidth480px" id="frontPostsInfo">
                                    
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
				<?php //echo $postMediaSrc;
				if(isset($values->postId) && $values->postId==0)
				echo '<div id="previewPostedImg"></div>';
				else echo $postMediaSrc;
				 ?>
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

		<div class="liquid_box_shadow">
		</div>		
		</div><!--liquid_box_wrapper-->
                                      
		  <div class="cell summery_post_description">
				
				<?php 				
				
				if(isset($values->postId) && $values->postId==0)
				echo '<h1 id="previewPostTitle"></h1>';
				else
				{
					if(strlen($values->postTitle)>50)
						$restrictedPostTitle = substr($values->postTitle,0,50).'...';
					else
						$restrictedPostTitle = $values->postTitle;

					echo '<h1>'.$restrictedPostTitle.'</h1>';
				}
				
				?>
				
				<div class="industry_type_wrapper">
				<div class="cell font_size11">
				Industry: <b><?php echo $industryTitle;?></b>
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
					<?php echo $label['postedOn'];?> &nbsp; <?php
					 
					 if(isset($values->postId) && $values->postId==0) echo '<b class="orange_color" id="previewPostedDate"></b>';
					 else  
					 {
						 $postedDate = $values->dateCreated;
						 echo '<b class="orange_color">'.date("l F d  Y", strtotime($postedDate)).'</b>';
					}				 
					 
					?>
					
				</div><!--summery_posted_date_wrapper--->
				
				</div><!--industry_type_description-->
				
		  </div> <!--summery_post_description-->                                      
                                     
		<div class="row NIC">
	   
			<p><?php 
			
			if(isset($values->postId) && $values->postId==0) 
				echo '<div style="float:left"><div id="previewPostDescription"></div></div>';
			else
			{
				$restrictedPostOneLineDesc =	str_replace('src="../../../media',$replacer, $values->postDesc);
				echo $restrictedPostOneLineDesc; 
			}
			?></p>
		
		</div>	
		
        <div class="seprator_45"></div>
                             
		<div class="row blog_links_wrapper bdr_top_btm">
			<span><a class="icon_getshort">Get Short Link</a></span>
			<span><a class="icon_email">Email</a></span>
			<span><a class="icon_share">Share</a></span>
			<span><a class="icon_invite">Invite</a></span>
			<div class="clear"></div>
		</div><!--blog_links_wrapper-->
                                                          
                                                          
		 <?php
          
          //Not a new post
           if(isset($values->postId) && $values->postId>0) 
           { 
		
			//GET TOTAL CHILD POST PRESENT
			        
		   $totalPostChild = countResult($postsTable,"parentPostId",$values->postId);
		   
		   if($totalPostChild>0)
		   {
			   ?>                                        
			  <div class="row blog_links_wrapper bdr_btm">
					<span ><?php echo anchor('blog/childPosts/'.$values->postId.'/'.$values->blogId,'<b>'.$label['seePosts'].'</b>',array('class'=>"icon_see_post")); ?></span>
					
				  <div class="clear"></div>   
			  </div><!--blog_links_wrapper-->
			   <?php
		   }
		}
		?>                                                        
                                                          
                                                          
		<div class="row blog_links_wrapper bdr_btm">
			<b><?php echo $label['tags'];?></b>
			<p>
			<?php 
				
				if(isset($values->postId) && $values->postId==0) 
					echo '<div id="previewPostTagWords"></div>';
				else
				{			
					echo $values->postTagWords; 
				}
				
			?>
			</p>
			<div class="clear"></div>   
		</div><!--blog_links_wrapper-->

		<div class="seprator_45"></div>
</div><!--widht_500-->      
</div>
<?php 
//
?> 
