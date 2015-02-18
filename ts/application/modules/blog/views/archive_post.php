<?php
 $labelBlogArchive = '<span>'.$label['blogDelItems'].'</span>'; ?>
<div class="row form_wrapper">
<?php 
	//LEFT SHADOW STRIP
	echo Modules::run("common/strip");
?>
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $labelBlogArchive;?></h1>
		</div>
		<?php echo Modules::run("blog/navigationMenu"); ?>
	</div>
	<div id="pagingContent" >
		<div class="row line1"></div>
		<div class="row seprator_27"></div>
		<div class="row">
		<?php if($archivePostQuery->num_rows() > 0){
		//Fetches all records one by one
			foreach($archivePostResults as $row){
				//echo "uuu<pre />"; print_r($row);?> 
			<div class="all_list_item ">
				<div class="row"></div>
				<div class="row pb10">
					<div class="empty_label_wrapper cell"></div><!--label_wrapper-->
					<div class=" cell frm_element_wrapper">
						<div class="row blog_wrapper bg_light_gray">
							<div class="blog_box bg_white">
									<div class="cell blog_left_wrapper">
										<div class="row">
											<h2 class="main_blog_heading">  <?php echo $row->postTitle; ?> </h2>
										</div>
										<div class="row">
											<div class="cell padding_top10"> <b class="orange_color">Created on:</b> <b> &nbsp; <?php echo date("l F d  Y", strtotime($row->dateCreated));?> </b>
											</div>
										</div>
										<div class="seprator_10 row"></div>
										<div class="row">
											<b class="orange_color"><?php echo $label['blogOneLineDesc'];?></b>
											<p>
											<?php if(strlen($row->postOneLineDesc)>200)
													$restrictedBlogOneLineDesc = substr($row->postOneLineDesc,0,200).'...';
												else
												$restrictedBlogOneLineDesc = $row->postOneLineDesc;
											echo $restrictedBlogOneLineDesc; ?></p>
											<div class="seprator_10"></div>
											<b class="orange_color"><?php echo $label['blogTagWords'];?></b>
											<p>
												<?php if(strlen($row->postTagWords)>120)
												$restrictedBlogTagWords = substr($row->postTagWords,0,120).'...';
												else
												$restrictedBlogTagWords = $row->postTagWords;
												echo $restrictedBlogTagWords; ?>
											</p>
										</div>
									</div>
									<div class="blog_right_wrapper">
										<div class="blog_link2_wrapper">
											<div class="post_text">Post</div>
											<div class="tds-button-top">
												<?php echo anchor('blog/archivePost/'.$row->postId.'/'.$row->blogId, '<span><div class="blogUnArchiveIcon"></div></span>',array('class'=>'formTip','title'=>'Un Archive'));?>
											</div><!--unArchive_blog-->
										</div>
										<div class="clear"></div>
										<div class="blog_link3_wrapper">
											<div class="blog_link3_box">
												<div class="icon_crave2_blog">  <?php echo $label['blogCraves'];?>  </div>
												<div class="blog_link3_point"> <?php print($row->postCraveCount == '' ? '0' : $row->postCraveCount ); ?></div>
											</div>
											<div class="blog_link3_box">
												<div class="icon_view2_blog"> <?php echo $label['blogViews'];?> </div>
												<div class="blog_link3_point"> <?php print($row->postViewCount == '' ? '0' : $row->postViewCount );?></div>
											</div>
											<div class="blog_link3_box">
												<div class="icon_post2_blog"> <?php echo $label['postCount'];?>  </div>
												<div class="blog_link3_point"> <?php print($row->postPostCount == '' ? '0' : $row->postPostCount );?></div>
											</div>
											<div class="blog_link3_box">
												<div class="icon_lastview2_blog"> Last Viewed<br/>
													<b>17 May 2012</b>
												</div>
											</div>
										</div>
									</div>
									<div class="clear"></div>
								</div><!--blog_box-->
						</div><!--blog_wrapper-->
						<div class="shadow_blog_box"> </div>
					</div>
				</div><!--pb10-->
			</div><!--all_list_item-->
		<?php } }?>
	</div><!--from_element_wrapper-->
</div><!--pagingContent-->
<div class="row">
<div class="empty_label_wrapper cell"></div><!--label_wrapper-->
<div class=" cell frm_element_wrapper">	
<?php 

$post_page['record_num'] = 3;
if($archivePostQuery->num_rows() > $post_page['record_num']) $this->load->view('pagination_view',$post_page);

?>
</div>
</div>	
</div>


