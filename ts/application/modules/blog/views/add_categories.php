<?php 
$categoryTitle = array(
	'name'	=> 'categoryTitle[0]',
	'id'	=> 'categoryTitle[0]',
	'value'	=> set_value('categoryTitle'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip BdrCommon required width270px',
	'title'       => 'Category Title'
	//'style' => 'width:270px;',
);
$categoryArray =0;
?>

<div class="row" id="categoryDiv">
	<div class="label_wrapper cell"><label><?php echo $label['categories'];?></label></div>
	<!--label_wrapper-->
	<div class="cell frm_element_wrapper" id='insidecategory' style="width:365px; display:block;">
		<div class="title-content" style="width:365px">
			<div class="title-content-left">
				<div class="title-content-right">
					<div class="title-content-center">
						<div class="title-content-center-label"><?php echo $label['category'];?></div>
						<div class="tds-button-top">
			
					<?php
							//Category Delete Icon
							$attr = array("onclick"=>"addCategory();","title"=>'<?php echo $label[\'Add\'];?>','class'=>'formTip');
							echo anchor('javascript://void(0);','<span><div class="projectAddIcon"></div></span>',$attr);
							?>
				</div><!-- tds-button-top -->
						<div class="toggleAdditionalInfo" toggleDivId="CATEGORY-Content-Box"  align="right">
					<img src="<?php echo base_url();?>images/icons/down_arrow.png" border="0" class="formTip" title="<?php echo $label['addCategory']; ?>"/>
				</div>
						<div class="clearfix" > </div>
					</div><!-- End title-content-center-->
				</div><!-- End title-content-right-->
			</div><!-- End title-content-left-->
		</div><!-- End title-content-->
	</div><!-- End insidecategory -->
</div><!--End categoryDiv-->
<div id="CATEGORY-Content-Box" style="display:none;">
<div class="row" >
	<div class="empty_label_wrapper cell"></div>
	<div class="cell frm_element_wrapper">
		<?php echo $label['categoryTitle'];?>
	</div>
</div>

<div class="row" id="catArea">
	<?
	if($countCat==0)
	{ ?>
	<div class="row">
		<div id="removeID_0">
			<div class="row heightSpacer"> &nbsp;</div>
			<div class="cell empty_label_wrapper"></div>
			<div class="cell">
				<div class="cell frm_element_wrapper"><?php echo form_input($categoryTitle);?></div>
				<div class="cell" style="padding-left:5px;">
					<?php
					if($countCat>0)
					{
					?>
						<div class="tds-button-top">
							<?php
							//Category Delete Icon
							$attr = array("onclick"=>"removeCategoryRow('0')","title"=>'<?php echo $label[\'Delete\'];?>','class'=>'formTip');
							echo anchor('javascript://void(0);','<span><div class="projectDeleteIcon"></div></span>',$attr);
							?>
						</div><!--End tds-button-top-->
					<?php
					} 
					?>
				</div>
			</div>
		</div>
	</div>

	<?php
	}
	else
	{
		for($icat=1;$icat<=$countCat;$icat++)
		{
			if (in_array($categoryValues[$icat-1]->categoryId,$existinCatId)) 
				$nodelete ='1';
			else  
				$nodelete ='0';
				?>
				<div id="removeID_<?php echo $icat-1;?>">
					<div class="row">	
						<div class="cell empty_label_wrapper"></div>
							<div class="cell frm_element_wrapper">
								<div class="cell">
									<input id="<?php echo $categoryValues[$icat-1]->categoryId;?>" class="formTip BdrCommon required width270px" type="text" title="<?php echo $label['categoryTitle'];?>" size="30" maxlength="80" value="<?php echo $categoryValues[$icat-1]->categoryTitle;?>" name="categoryTitleEdit[<?php echo $categoryValues[$icat-1]->categoryId;?>]" >
									<input type="hidden" id="useDelId_<?php echo $icat-1;?>" value="<?php echo $categoryValues[$icat-1]->categoryId;?>" />
								</div>
								<div class="cell" style="padding-left:5px;">
								<?php
								if($countCat>0)
								{
								?>
									<div class="tds-button-top">
										<?php
										//Category Delete Icon
										$delId =$icat-1;
										$attr = array("onclick"=>"removeCategoryRow('$delId ','$nodelete')","title"=>'<?php echo $label[\'Delete\'];?>','class'=>'formTip');
										echo anchor('javascript://void(0);','<span><div class="projectDeleteIcon"></div></span>',$attr);
										?>
									</div><!--End tds-button-top-->
								<?php
								} 
								?>
							</div>
						</div>
					</div>
				</div>
				<?php
		}
	}//End For Else
	?>
	<div class="row heightSpacer"> &nbsp;</div>
</div>


<input type="hidden" id="countCat" value="<?php echo $countCat;?>" />
<input type="hidden" id="delCatId" name="delCatId" value="" />
</div>
<script type="text/javascript">
	
	function addCategory()
	{
		var oldCatCount = $('#countCat').val();
		
		if(oldCatCount<=0)
			var currentCatCount = Number(parseInt(oldCatCount)+1);
		else 
			var currentCatCount = Number(parseInt(oldCatCount));
		
		if(currentCatCount<10)
		{
			var resultantDiv = '<div class="removeIDVisa" style="float:left;"><div class="row"><div id="removeID_'+currentCatCount+'"><div class="cell empty_label_wrapper"></div><div class="cell frm_element_wrapper"><div class="cell"><input id="categoryTitle['+currentCatCount+']" class="formTip BdrCommon required width270px" type="text" title="<?php echo $label['categoryTitle'];?>" size="30" maxlength="80" value="" name="categoryTitle['+currentCatCount+']"></div><div style="padding-left:5px;" id="remScnt" class="cell"><div class="tds-button-top"><a class="formTip" href="javascript:void(0);" title="Remove" style="cursor:pointer"><span><div class="projectDeleteIcon"></div></span></a></div></div></div></div></div></div>';
			$('#countCat').val(currentCatCount);
			$(resultantDiv).appendTo($('#catArea'));
			
			$('#remScnt').live('click', function() {
				$(this).parents('div.removeIDVisa').remove();	
				return false;
			});
			$('#countCat').attr('value',Number(parseInt(oldCatCount)+1));
		}
		else
		{
			alert('<?php echo $label['categoryLimitAlert'];?>');
		}
	}
	
	function removeCategoryRow(removeId,flag)
	{
		var delCatId = $('#delCatId').attr("value");
		var catTitle = $('#delCatId').attr("value");

		var userDelId = $('#useDelId_'+removeId).val();
		
		var oldCatCount = $('#countCat').val();
		
		$('#countCat').attr('value',Number(parseInt(oldCatCount)-1));
		
		if(flag==1)
		{
			alert('<?php echo $label['categoryRelated']; ?>');
			return false;
		}
		else
		{
			var conBox = confirm('<?php echo $label['categoryDelMsg']; ?>');
			if(conBox)
			{						
				if(delCatId == '')
				{
					delCatId = userDelId;
				}
				else 
					delCatId = delCatId+','+userDelId;
				
				$('#delCatId').attr('value',delCatId);
				$('#removeID_'+removeId).remove();
			
			}
			else
			{
				return false;
			}
		}		
	}

</script>
