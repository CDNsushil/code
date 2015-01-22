<!--Cat_wrapper-->
<?php 


	
	if($showFlag==0)
	{
		echo anchor('javascript://void(0);','<h1>'.$label['categories'].'</h1>',array('class'=>'go',
		'title'=>$label['categories'],
		'onclick'=>"AJAX('".base_url(lang().'/blog/categoryPosts')."','postsInfo','".encode($blogId)."','0');"));	
			
	}
	else
	{
		echo anchor('javascript://void(0);','<h1>'.$label['categories'].'</h1>',array('class'=>'go',
		'title'=>$label['categories'],
		'onclick'=>"AJAX('".base_url(lang().'/blog/frontCategoryPosts')."','frontPostsInfo','".encode($blogId)."','0');"));			
	}
		
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
				echo '<span class="grey">'.$catvalue->categoryTitle.' ('.$catvalue->postcount.')'.'</span>';
			}									
			else
			{
				if($showFlag==0)
				{
					echo anchor('javascript://void(0);',$catvalue->categoryTitle.' ('.$catvalue->postcount.')',array('class'=>'formTip go',
					'title'=>ucwords($catvalue->categoryTitle),
					'onclick'=>"AJAX('".base_url(lang().'/blog/categoryPosts')."','postsInfo','".encode($blogId)."','".encode($catvalue->categoryId)."');"));	
				}
				else
				{
					echo anchor('javascript://void(0);',$catvalue->categoryTitle.' ('.$catvalue->postcount.')',array('class'=>'formTip go',
					'title'=>ucwords($catvalue->categoryTitle),
					'onclick'=>"AJAX('".base_url(lang().'/blog/frontCategoryPosts')."','frontPostsInfo','".encode($blogId)."','".encode($catvalue->categoryId)."');"));	
				}
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
