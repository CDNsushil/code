<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
if(count($catList)>0) {
		
	if($showFlag==0)
	{
		echo anchor('javascript://void(0);','<h4 class="red bb_F1592A fs16 font_bold pl10 pb5">'.$label['categories'].'</h4>',array('class'=>'go',
		//'title'=>$label['categories'],
		'onclick'=>"AJAX('".base_url(lang().'/blog/categoryPosts')."','postsInfo','".encode($blogId)."','0','".$isArchive."');"));				
	}
	else
	{
		echo anchor('javascript://void(0);','<h4 class="red bb_F1592A fs16 font_bold pl10 pb5">'.$label['categories'].'</h4>',array('class'=>'go',
		//'title'=>$label['categories'],
		'onclick'=>"AJAX('".base_url(lang().'/blog/frontCategoryPosts')."','frontPostsInfo','".encode($blogId)."','0','".encode($userId)."');"));			
	}		
?>
<ul class="pt23 pl18 pr20 date_list">
	
		<?php
		while (list($catkey, $catvalue) = each($catList)) 
		{	
			// set active category class
			$activeCatCls = '';
			if($catId == $catvalue->categoryId) {
				$activeCatCls = 'red';
			}
			// set no data cls for count 0
			$disableLi = '';
			if($catvalue->postcount==0) {
				$disableLi = ' greyClr';
			}		
			echo '<li class="'.$activeCatCls. $disableLi .'">';					
			//CALLING AJAX TO LOAD DATA IN DIVID "POSTINFO"
			if($catvalue->postcount==0)
			{						
				echo $catvalue->categoryTitle.'<span class="greyClr fr">'.$catvalue->postcount.'</span>';
			}									
			else
			{
				// set posts listing url as per category
				$catPostsUrl = base_url_lang('blog/editposts/'.$catvalue->categoryId);
				
				if($showFlag==0)
				{
					
					echo anchor($catPostsUrl,$catvalue->categoryTitle.'<span class="red fr">'.$catvalue->postcount.'</span>');	
				}
				else
				{
					echo anchor($catPostsUrl,$catvalue->categoryTitle.'<span class="red fr">'.$catvalue->postcount.'</span>',array('class'=>'go',
					'onclick'=>"AJAX('".base_url(lang().'/blog/frontCategoryPosts')."','frontPostsInfo','".encode($blogId)."','".encode($catvalue->categoryId)."');"));	
				}
			}									
			echo '</li>';
		}
	?>
</ul>
<?php	
}
?>
<script>
$('.go').click(function(){
	
	$('.go').each(function(index){
		$(this).removeClass('right_menu_selected');
	});		

	$(this).addClass("right_menu_selected"); 
	$('html, body').animate({scrollTop:0}, 'slow');
	return false;
});
</script>
