<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
foreach($query as $row)
{
	//if filepath is set for any of the blog type it will show the respective image else show the default image
	if(isset($row->filePath))
	{
	 if($row->filePath!='')
		$blogImagePath= $row->filePath.'/'.$row->fileName;
	}
	else 
	{
		$blogImagePath = 'blog/postDeafultImage.jpg';	
	}
	
	if(strlen($row->blogTitle)>50)
		$blogTitle = substr($row->blogTitle,0,50).'...';
	else
		$blogTitle = $row->blogTitle;

	$blogMediaSrc = '<img class="maxWidth165px maxHeight120px ma"  src="'.getImage($blogImagePath,'blog/blogDefaultImage.jpg').'" alt="'.$blogTitle.'" />'; 
					
	$blogOneLineDesc = $row->blogOneLineDesc;
								
?> 
<?php 
	
	if(isset($showRight) && $showRight!=0){
?> 
<div class="row summery_post_wrapper">
	                  
    <div class="cell width_480 sub_col_1" id="frontPostsInfo">
<?php 
}
?>                                  
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
						<?php echo $blogMediaSrc; ?>
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
						
						<h1><?php echo $blogTitle;?></h1>
						
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
						<?php echo $label['postedOn'];?> &nbsp; <b class="orange_color"><?php echo dateFormatView($row->dateCreated);?></b>
						</div><!--summery_posted_date_wrapper--->
						
						</div><!--industry_type_description-->
						
				  </div> <!--summery_post_description-->                                      
                                     
				<div class="row">
			   
					<p><?php echo $blogOneLineDesc; ?></p>
				
				</div>	
                                        
                <div class="seprator_45"></div>                             				
				<div class="row blog_links_wrapper bdr_top_btm">
				<?php

				// Show view page for getshortLink ,email,share,invite and postOnPost
				// entityTitle:Title of page you want to share
				// shareType: text(like:post,film and video etc)
				// shareLink: url to get shared with users
				
				$currentUrl = $this->config->site_url().$this->router->class.'/frontBlog/'.$row->blogId;
				$relation = array('getShortLink','email','share','entityTitle'=>addslashes($row->blogTitle),'shareType'=>'post','shareLink'=>$currentUrl);
				echo Modules::run("common/loadRelations",$relation); 
				?>
				</div>
				                                    
				<div class="row blog_links_wrapper bdr_btm">
					<b><?php echo $label['tags'];?> </b><p><?php echo $row->blogTagWords; ?></p>
				  <div class="clear"></div>   
			    </div><!--blog_links_wrapper-->
			  
			    <div class="seprator_45"></div>
</div><!--widht_480--> 
<?php 
	
	if(isset($showRight) && $showRight!=0){
?>     
  <div class="cell width_311 right_panel_gray_bg sub_col_2">	
	
	<?php
		echo Modules::run("blog/frontRight",$row->blogId);
	?>
</div> 
<?php
	}
?>
<?php
}
?>
</div>
