<?php 
$categoryTitle = array(
	'name'	=> 'categoryTitle[0]',
	'id'	=> 'categoryTitle[0]',
	'value'	=> set_value('categoryTitle'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr4 required error',
	'title'       => 'Category Title',
	'style' => 'width:270px;',
);

$categoryArray =0;

?>	
		
<div class="row" id="categoryDiv">
<div class="cell orng_lbl"><?php echo $label['addCategory'];?></div>
<div class="cell" id='insidecategory' style="width:365px; display:block;">
	<div class="title-content" style="width:365px">
		<div class="title-content-left">
			<div class="title-content-right">
					<div class="title-content-center">
					<div class="title-content-center-label"><?php echo $label['category'];?></div>
					<div class="tds-button-top">
					<a>
						<span><div class="projectAddIcon" title ="<?php echo $label['addCategory'];?>" style="cursor:pointer" onclick="addCategory();"></div></span>
					</a>
					
				</div><!--End tds-button-top-->
				<div class="clearfix" > </div>
				</div><!-- End title-content-center-->
			</div><!-- End title-content-right-->
		</div><!-- End title-content-left-->
	</div><!-- End title-content-->
</div><!-- End insidecategory -->
</div><!-- End categoryDiv -->
		
<div class="row" ><div class="cell orng_lbl" >&nbsp;</div><div class="cell orng_lbl" style="padding-left:65px;"><?php echo $label['categoryTitle'];?></div></div>

<div class="row" id="catArea">
<?
if($countCat==0)
{ ?>
<div class="row heightSpacer"> &nbsp;</div>		
<div class="row">
	<div id="removeID_0">
	<div class="cell orng_lbl">&nbsp;</div>
		<div class="cell" style="text-align: left;">
		<div class="cell" style="text-align: left;"><?php echo form_input($categoryTitle);?></div>
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
}else{
for($icat=1;$icat<=$countCat;$icat++)
{
if (in_array($categoryValues[$icat-1]->categoryId,$existinCatId)) $nodelete ='1';
else  $nodelete ='0';
?>
<div id="removeID_<?php echo $icat-1;?>">
<div class="row heightSpacer"> &nbsp;</div>
	<div class="row">
	
	<div class="cell orng_lbl">&nbsp;</div>
		<div class="cell" style="text-align: left;">
		<div class="cell" style="text-align: left;">
		<input id="<?php echo $categoryValues[$icat-1]->categoryId;?>" class="formTip Bdr4 required error" type="text" style="width:270px;" title="<?php echo $label['categoryTitle'];?>" size="30" maxlength="80" value="<?php echo $categoryValues[$icat-1]->categoryTitle;?>" name="categoryTitleEdit[<?php echo $categoryValues[$icat-1]->categoryId;?>]" >
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
</div>

<?php

}
}//End For Else
?>
</div>
				
<input type="hidden" id="countCat" value="<?php echo $countCat;?>" />
<input type="hidden" id="delCatId" name="delCatId" value="" />

<script type="text/javascript">		
	function addCategory()
	{
		var oldCatCount = $('#countCat').val();
		var currentCatCount = Number(oldCatCount)+Number(1);
		if(currentCatCount<10){
		var resultantDiv = '<div class="removeIDVisa" style="float:left;"><div class="row heightSpacer"> &nbsp;</div><div class="row"><div id="removeID_'+currentCatCount+'"><div class="cell orng_lbl">&nbsp;</div><div class="cell" style="text-align: left;"><input id="categoryTitle['+currentCatCount+']" class="formTip Bdr4 required error" type="text" style="width:270px;" title="<?php echo $label['categoryTitle'];?>" size="30" maxlength="80" value="" name="categoryTitle['+currentCatCount+']"></div><div id="remScnt" class="cell"  style="padding-left:5px;" ><div class="tds-button-top"><a class="formTip" href="javascript:void(0);" title="Remove" style="cursor:pointer"><span><div class="projectDeleteIcon"></div></span></a></div></div></div></div></div>';
		$('#countCat').val(currentCatCount);
		$(resultantDiv).appendTo($('#catArea'));
$('#remScnt').live('click', function() {
 $(this).parents('div.removeIDVisa').remove();	
 return false;
});
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
		//alert(delCatId);
		//alert(userDelId);
if(flag==1){
alert('<?php echo $label['categoryRelated']; ?>');
return false;
}else{
			var conBox = confirm('<?php echo $label['categoryDelMsg']; ?>');
			if(conBox){				
					
			if(delCatId == ''){
			delCatId =userDelId;
			}else delCatId =delCatId+','+userDelId;
			
			$('#delCatId').attr('value',delCatId);
			$('#removeID_'+removeId).remove();
			
			}else
			{
				return false;
			}
}
		
	}

</script>
