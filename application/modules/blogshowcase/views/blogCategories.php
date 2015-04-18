<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
$currentMethod = $this->router->method;
$currentClass = $this->router->class;
$currentCatId = $this->uri->segment(5);

if(count($catList)>0) {
	
	$href=($currentMethod=='preview')?'/blogshowcase/preview/'.$userId.'/0/frontcatposts/':'/'.$currentClass.'/frontcatposts/'.$userId;
	$href=base_url(lang().$href);
	echo '<div class="row summery_right_archive_wrapper showcase_link_hover">';
	echo anchor($href,'<h1 class="sumRtnew_strip clr_white dash_link_hover">'.$label['categories'].'</h1>');			
?>
<ul>
	<?php
	

		while (list($catkey, $catvalue) = each($catList)) 
		{			
			$categoryTitle=$catvalue->categoryTitle;
			$categoryTitle=getSubString($categoryTitle,30);
			echo '<li>';					
			//CALLING AJAX TO LOAD DATA IN DIVID "POSTINFO"
			if($catvalue->postcount==0)
			{						
				echo '<span class="span_arrow_class white">'.$categoryTitle.' ('.$catvalue->postcount.')'.'</span>';
			}									
			else
			{
				if(@$currentCatId == $catvalue->categoryId) $addClass = " orange ";
				else $addClass = " clr_white ";
				
				$href=($currentMethod=='preview')?'/blogshowcase/preview/'.$userId.'/'.$catvalue->categoryId.'/frontcatposts/':'/'.$currentClass.'/frontcatposts/'.$userId.'/'.$catvalue->categoryId;
				$href=base_url(lang().$href);
				echo anchor($href,ucwords($categoryTitle).' ('.$catvalue->postcount.')',array('class'=>$addClass));	
					
					//echo anchor('javascript://void(0);',$categoryTitle.' ('.$catvalue->postcount.')',array('class'=>'formTip go',
					//'title'=>ucwords($categoryTitle),
					//'onclick'=>"AJAX('".base_url(lang().'/blogshowcase/frontCategoryPosts')."','frontPostsInfo','".encode($blogId)."','".encode($catvalue->categoryId)."');"));	
				
			}									
			echo '</li>';
		}
	//}//else echo '<li><a href="javascript://void(0);" class="clr_white"><div>No Categories</div></a></li>';
	?>
</ul>	
<?php
	echo '</div>';
}
?>
<!--Cat_wrapper-->

<script>
/*
$('.go').click(function(){
	
	$('.go').each(function(index){
		$(this).removeClass('right_menu_selected');
	});		

	$(this).addClass("right_menu_selected");
 
});
*/
</script>
