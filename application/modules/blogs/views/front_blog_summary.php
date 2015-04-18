<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed')?>
<div class="row">	
<?php 
$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right left_801'));
?>

 <div class="cell sub_col_1 width660px" >
	<div class="row main_blog_box bg-non" style="margin:12px;">
		<div id="frontPostsInfo">
		<?php			
			echo Modules::run("blogfrontend/frontblogposts",$blogPostsData); //This shows all posts 
		?>		
		</div>
	</div>
 </div><!-- cell width_480 --> 
 
<div class="cell advert_column sub_col_3 height1636px">
<div class="seprator_5"></div>
<div class="ad_box ml11 mt10 mb10"><img class="max_w159_h593" src="<?php echo  base_url();?>images/advert_img.jpg" ></div>
</div>
</div>
<div class="clear"></div>
</div>



