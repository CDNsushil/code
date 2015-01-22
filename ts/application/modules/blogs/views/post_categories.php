<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!--Cat_wrapper-->
<?php 

	$currentCatId = $this->uri->segment(4);	
	echo anchor(base_url(lang().'/blogs/frontcatposts/'),'<h1 class="sumRtnew_strip clr_white">'.$label['categories'].'</h1>',array('class'=>'','title'=>$label['categories']));			

?>
<ul>
	<?php
	if(count($catList)>0){
		while (list($catkey, $catvalue) = each($catList)) 
		{			
		
			echo '<li>';					
			//CALLING AJAX TO LOAD DATA IN DIVID "POSTINFO"
			if($catvalue->postcount==0)
			{						
				echo '<span class="span_arrow_class">'.$catvalue->categoryTitle.' ('.$catvalue->postcount.')'.'</span>';
			}									
			else
			{
				if(@$currentCatId == $catvalue->categoryId) $addClass = "orange";
				else $addClass = "";
				echo anchor(base_url(lang().'/blogs/frontcatposts/'.$catvalue->categoryId),$catvalue->categoryTitle.' ('.$catvalue->postcount.')',array('class'=>'formTip '.$addClass.'',
					'title'=>ucwords($catvalue->categoryTitle)));	
					
					//echo anchor('javascript://void(0);',$catvalue->categoryTitle.' ('.$catvalue->postcount.')',array('class'=>'formTip go',
					//'title'=>ucwords($catvalue->categoryTitle),
					//'onclick'=>"AJAX('".base_url(lang().'/blogshowcase/frontCategoryPosts')."','frontPostsInfo','".encode($blogId)."','".encode($catvalue->categoryId)."');"));	
				
			}									
			echo '</li>';
		}
	}else echo '<li><a href="javascript://void(0);"><div>No Categories</div></a></li>';
	?>
</ul>	
<?php
	
?>
<!--Cat_wrapper-->

<script>
$('.go').click(function(){
	
	$('.go').each(function(index){
		$(this).removeClass('right_menu_selected');
	});		

	$(this)
	.addClass("right_menu_selected");
 
	$('html, body').animate({scrollTop:0}, 'slow');
	return false;
});
</script>
