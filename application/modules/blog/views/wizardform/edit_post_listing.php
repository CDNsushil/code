<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$isRemove = false;
if(isset($isDeletedSection)) {
	$isRemove = true;
}
?>
<div class="row content_wrap">
	<div class="bg_f3f3f3 fl width100_per  title_head">
		<h1 class="fs30 letrP-1 opens_light mb0  fl  textin30">Posts</h1>
		<ul class="dis_nav fs16 mt25 fr pr30">
			<li class="<?php echo (isset($isDeletedSection)) ? '' : 'active'; ?>">
				<a href="<?php echo base_url_lang('blog/editposts');?>">Posts</a>
			</li>
			<li class="<?php echo (isset($isDeletedSection)) ? 'active' : ''; ?>">
				<a href="<?php echo base_url_lang('blog/deletedposts');?>">Deleted Posts</a>
			</li>
		</ul>
	</div>

	<div class="sap_30"></div>

	<div class="m_auto pt3 display_table wid940">

		<div class="right_wrap width_196 mr36 fl">
			<?php		
			//This shows posts related with blog	
			$frontFlag = 0;
			echo Modules::run("blog/blogarchivelist",$blogId,$frontFlag,$userId,'t');
			?>
		
			<div class="clearbox">
				<div class="Cat_wrapper">
					<?php
					$frontFlag = 0;
					echo Modules::run("blog/blogcategorylist",$blogId,$frontFlag,$userId,$isArchive);
					?>
				</div>
			</div>						
		</div>
		
		
		<div id="searchontoadsquareResultDiv">
            <?php
            if($postResults) {
                echo $editPostResult;
            } else {
                echo '<div class="p15">No record found in result.</div>';
            } ?>
        </div>
		
	</div>	
</div>
<!-- End Content wrap  --> 
