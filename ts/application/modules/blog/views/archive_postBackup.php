
				<!-- TOP NAVIGATION-->

<?php
	$lableNewPost = '<span>'.$label['newPost'].'</span>';
	$labelBlogSetting = '<span>'.$label['blogSetting'].'</span>';
	$labelBlogArchive = '<span>'.$label['blogArchive'].'</span>';
	?>

		<div class="projectSection">
	 <div class="tds-button floatRight" > 	<?php echo anchor('blog/postForm/'.$blogId, 	$lableNewPost,array('onmousedown'=>'mousedown_tds_button(this)', 
'onmouseup'=>'mouseup_tds_button(this)'));?><?php echo anchor('blog/blogForm/'.$blogId, $labelBlogSetting,array('onmousedown'=>'mousedown_tds_button(this)', 
'onmouseup'=>'mouseup_tds_button(this)'));?>	<?php echo anchor('blog/showArchives/'.$blogId, $labelBlogArchive,array('onmousedown'=>'mousedown_tds_button(this)', 
'onmouseup'=>'mouseup_tds_button(this)'));?></div>	
		<div class="clearfix"> </div>
		<?php
	
 //Checks if record exists in table
	 if($archivePostQuery->num_rows() > 0)
	 { 
		//Fetches all records one by one
		foreach($archivePostResults as $row)
		{
		?> 

  <!-- TITLE BAR -->
		<?php
	
		//To restrict the post title upto 50 words only
		
		if(strlen($row->postTitle)>50)
			$restrictedPostTitle = substr($row->postTitle,0,50).'...';
		else
			$restrictedPostTitle = $row->postTitle;
	
	?>
	<div class="title-content">
	  <div class="title-content-left">
		<div class="title-content-right">
		  <div class="title-content-center">
						<div class="title-content-center-label"><?php echo $restrictedPostTitle; ?></div>
						<div class="tds-button-top"></div><div class="clearfix" > </div>
					</div><!-- End title-content-center -->
				</div><!-- End title-content-right -->
			</div><!-- End title-content-left -->
		</div><!-- End title-content -->
	  <div class="element-content" style="background-color:#e2e1e2; float:left; width:100%; margin-top:12px;" >
      <div class="element-content-top">
        <div class="element-content-top-left"></div>
        <div class="element-content-top-right"></div>
        <div class="element-content-top-repeat"></div>
      </div>
      <div class="element-content-repeat">
        <div class="element-content-repeat-left">
          <div class="element-content-repeat-right">
            <div class="element-content-repeat-center" > 
	<div style="border:0px solid; padding:10px; ">
	
  		<div style="display:inline-table; vertical-align:middle;width:400px;"> <?php echo '<b>'.$label['postTitle'].'</b>'; echo '&nbsp;'.$row->postTitle; ?>
 
  <p><strong> <?php echo $label['postDescription'];?></strong> <?php echo $row->postDesc; ?></p>
		</div>
		<div style="display:inline-table; vertical-align:middle; text-align:center; float:right; padding-top:5px; w"> <!-- Start for count div -->
		<div style="display:inline-table;"> 
			<img height="16" width="16" alt="Craves" src="<?php echo base_url();?>images/icons/1317210972_star_red.png"><br /><?php print($row->postCraveCount == '' ? '0' : $row->postCraveCount ); ?>
		</div>
		<div style="display:inline-table"> 
			<img height="16" width="16" alt="Craves" src="<?php echo base_url();?>images/icons/group.png"><br /><?php print($row->postViewCount == '' ? '0' : $row->postViewCount );?>
		</div>
		<div style="display:inline-table"> 
			<img height="16" width="16" alt="Reviews" src="<?php echo base_url();?>images/icons/comments.png"><br /><?php print($row->postReviewCount == '' ? '0' : $row->postReviewCount );?>
		</div>
		<div style="display:inline-table"> 
			<img height="16" width="16" alt="Reviews" src="<?php echo base_url();?>images/icons/my-account.png"><br /><?php print($row->postPostCount == '' ? '0' : $row->postPostCount );?>
		</div>
		</div> <!-- End for count div -->
		
 <div class="clearfix"></div>
  
  <div class="tds-button floatRight" >  
		<?php //Checks if post is having TRUE as archvied value
			  if($row->postArchived == 't') 
				echo anchor('blog/archivePost/'.$row->postId.'/'.$row->blogId, '<span>Archive</span>'); 
			  
			  //Checks if post is having FALSE as archvied value
			  if($row->postArchived == 'f')  
				echo anchor('blog/archivePost/'.$row->postId.'/'.$row->blogId, '<span>Unarchive</span>');
				?> 
		</div>
              <div class="clearfix"></div>
   </div>
			 </div>       
            <div class="clearfix"></div>													
          </div>
        </div>
      </div>	<div class="element-content-bottom">
        <div class="element-content-bottom-left"></div>
        <div class="element-content-bottom-right"></div>
        <div class="element-content-bottom-repeat"></div>
      </div>
    </div> <div class="clearfix"></div><br />     
		<?php
  }//End For
 }//End If
	else 
	{
?> 
<div class="element-content" style="background-color:#e2e1e2; float:left; width:100%; margin-top:12px;" >
      <div class="element-content-top">
        <div class="element-content-top-left"></div>
        <div class="element-content-top-right"></div>
        <div class="element-content-top-repeat"></div>
      </div>
      <div class="element-content-repeat">
        <div class="element-content-repeat-left">
          <div class="element-content-repeat-right">
            <div class="element-content-repeat-center" > <h3><span style="padding:10px;">&nbsp;</span></h3>											
				<?php 
				
				 echo '<div class="norecordfound">'.$label['noArchive'].'</div>'; 
				?>									  
            </div>       
            <div class="clearfix"></div>													
          </div>
        </div>
      </div>					
      <div class="element-content-bottom">
        <div class="element-content-bottom-left"></div>
        <div class="element-content-bottom-right"></div>
        <div class="element-content-bottom-repeat"></div>
      </div>
    </div>
 
<?php
	}
?>
<div class="clearfix"></div>
</div>
