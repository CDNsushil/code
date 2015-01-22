<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$totalRecords = $postQuery->num_rows();
?>
<?php

if($totalRecords > 0)
{
$flag =0;
?>
<h1><?php echo $label['recentPosts'];?></h1>
<div class="row recent_box_wrapper">

<?php
foreach($postResults as $row)
{
	
	if(strlen($row->postTitle)>30)
		$recentPostTitle = substr($row->postTitle,0,30).'...';
	else
		$recentPostTitle = $row->postTitle;
	
	//if filepath is set for any of the post type it will show the respective image else show the no-image 
	if(isset($row->filePath))
	{
		if($row->filePath!='')
			$imagePathForPost= $row->filePath.'/'.$row->fileName;
	}
	else 
		$imagePathForPost = 'images/blog/postDeafultImage.jpg';

	$recentPostMediaSrc = '<img class="minMaxWidth59px ma"  src="'.getImage($imagePathForPost).'" alt="'.$recentPostTitle.'" />';
					
?>
	<div class="row">

		<div class="cell recent_thumb">
			<?php echo anchor('blog/frontPostDetail/'.$row->postId,$recentPostMediaSrc); ?>
		</div>

		<div class="cell recent_two_line">
			<b><?php echo anchor('blog/frontPostDetail/'.$row->postId,$recentPostTitle); ?></b>
			<br/>
			<span class="recent_date"><?php echo date("l F d  Y", strtotime($row->dateCreated));?></span>
		</div>
	</div>
			
	<div class="clear"></div>
	<div class="seprator_10"></div>
	
<?php
}//End For
?>
</div>
<?php
}//End If
else 
{
	
	echo '<div class="norecordfound">'.$label['noPost'].'</div>';
	
}
?>
<div class="clear"></div>
