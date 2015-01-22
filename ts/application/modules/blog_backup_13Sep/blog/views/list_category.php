<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="row">	
	<div class="cell empty_label_wrapper"></div>
		<div class="cell frm_element_wrapper" id="catInfo">
			<?php
			for($icat=1;$icat<=$countCat;$icat++)
			{
				if (in_array($categoryValues[$icat-1]->categoryId,$existinCatId)) 
				$nodelete = '1';
				else  
				$nodelete = '0';
				?>
					<div class="cell ml20" id="removeID_<?php echo $icat-1;?>" >
						<div class="artist_type_frm_label">
							<?php
							$editArr = array('title'=>$label['edit'],							
							'onclick'=>"EditCategory('".$categoryValues[$icat-1]->categoryTitle."',".$categoryValues[$icat-1]->categoryId.",".($icat-1).")"				
							);
							//Category Title
							echo $categoryValues[$icat-1]->categoryTitle;				               
							?>
							</div><!--artist_type-->							
								<div class="pro_btns">
								<?php 
								
								$delId = $icat-1;									
								if($countCat>0)
								{
								?>
									<div class="small_btn"><a class=" formTip" onmousedown="mousedown_small_button(this)" onmouseup="mouseup_small_button(this)" Title="<?php echo $label['Delete'];?>" onclick="removeCategoryRow('<?php echo $delId;?>','<?php echo $nodelete;?>')"><span><div class="cat_smll_plus_icon"></div></span></a></div><!--small_cross_btn_wp-->									
								<?php
								}
								?>
								
								<div class="small_btn"><a class=" formTip" title="<?php echo $this->lang->line('edit')?>" onclick="EditCategory('<?php echo $categoryValues[$icat-1]->categoryTitle;?>','<?php echo $categoryValues[$icat-1]->categoryId;?>','<?php echo ($icat-1);?>')"><span><div class="cat_smll_edit_icon"></div></span></a></div><!--small_cross_btn_wp-->							
								
								<input type="hidden" id="useDelId_<?php echo $icat-1;?>" value="<?php echo $categoryValues[$icat-1]->categoryId;?>" />
								</div>		
					</div><!-- removeID -->
				<?php
			}//End For
			?>	
		</div><!-- frm_element_wrapper-->
	
</div>
				  
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
