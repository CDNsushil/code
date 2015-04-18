<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<ul class=" fs13 pt30 liststyle_none list_box clearb" id="catInfo">
		<?php
		for($icat=1;$icat<=$countCat;$icat++)
		{
			if (in_array($categoryValues[$icat-1]->categoryId,$existinCatId)) 
				$nodelete = '1';
				else  
				$nodelete = '0';
				?>
				<li id="removeID_<?php echo $icat-1;?>" class="pb5">
					<span class="display_block font_bold ml25 bg_f9f9f9 pl18">
						<?php
						$editArr = array('title'=>$label['edit'],							
							'onclick'=>"EditCategory('".$categoryValues[$icat-1]->categoryTitle."',".$categoryValues[$icat-1]->categoryId.",".($icat-1).")"				
						);
						//Category Title
						echo '<b>'.$categoryValues[$icat-1]->categoryTitle.'</b>';?>
						
						<span class="red fs12 fr">
							<a onclick="EditCategory('<?php echo $categoryValues[$icat-1]->categoryTitle;?>','<?php echo $categoryValues[$icat-1]->categoryId;?>','<?php echo ($icat-1);?>')"> Edit</a>
							<?php 
							$delId = $icat-1;									
							if($countCat>0) { ?>
								/
								<a onclick="removeCategoryRow('<?php echo $delId;?>','<?php echo $nodelete;?>')">Delete </a>
							<?php } ?>
							<input type="hidden" id="useDelId_<?php echo $icat-1;?>" value="<?php echo $categoryValues[$icat-1]->categoryId;?>" />
						</span>
					</span>
				</li>
				<?php
			}//End For
			?>
				  
<script language="javascript" type="text/javascript">
function EditCategory(categoryTitle,categoryId,replaceId)
{
		//$('#addCatButton').toggleClass('icon_plus', 'projectDeleteIcon');
		var categoryId = categoryId;
		var categoryTitle = categoryTitle;
		var replaceId = replaceId;
		
		if($('#addCatButton').hasClass('cat_plus_icon'))
		{
			$('#addCatButton').removeClass('cat_plus_icon');
			$('#addCatButton').addClass('cat_edit_icon');
		}
				
		$('#replaceId').val(replaceId);
		$('#categoryId').val(categoryId);
		$('#categoryTitle').val(categoryTitle);	
		$('#catCancel').show();	
		
}
</script>
