<?php 
$categoryTitle = array(
	'name'	=> 'categoryTitle',
	'id'	=> 'categoryTitle',
	'value'	=> set_value('categoryTitle'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip BdrCommon width270px',
	'title'       => $this->lang->line('categoryToolTip'),
	'placeholder'=>  $this->lang->line('categoryUpto10')
	//'style' => 'width:270px;',
);
$categoryArray =0;

?>

<div class="row" id="categoryDiv">
	<div class="label_wrapper cell"><label><?php echo $this->lang->line('categories');?></label></div>
	<!--label_wrapper-->
	<div class="cell" id='insidecategory' style="display:block;">
		<div class="cell frm_element_wrapper">
				<div class="cell ml10 mr10">
					<?php echo form_input($categoryTitle);?>
				</div>
				<div class="cell">
				
					<input type="hidden" id="categoryId" value="0" />
					<input type="hidden" id="replaceId" value="0" />
					<div class="small_btn mr0">
					<?php
							echo anchor('javascript://void(0);','<span><div id="catCancel" class="cat_smll_cancel_icon"></div></span>',array('class'=>'formTip go fl dn',
							'title'=>$this->lang->line('cancel'),
							'onclick'=>"catCancel();",
							'id'=>'catCancel',
							'style'=>'display:none'));								
							//echo '</div>';
					?>
					</div>
					<div class="small_btn mr0">
					<?php
							//Category Delete Icon
							
							$attr = array("onclick"=>"addCategory();","title"=>'<?php echo $label[\'Add\'];?>','class'=>'formTip');
							
							echo anchor('javascript://void(0);','<span><div id="addCatButton" class="cat_smll_save_icon"></div></span>',array('class'=>'formTip go fl',
							'title'=>$this->lang->line('save'),
							'onclick'=>"addCategory('".base_url(lang().'/blog/saveAppendCat')."','catInfo','".$blogId."',$('#categoryTitle').val(),$('#categoryId').val(),'loadImg','categoryTitle','categoryId',$('#replaceId').val());"));	
							//echo '<div id="catCancel" class="dn">';
					?>
					</div>
					
		</div><!-- padding-left:5px; -->
		</div>
	</div><!-- End insidecategory -->
</div><!--End categoryDiv-->
<div id="CATEGORY-Content-Box" style="display:block;">	
		
<?php 
		//This shows posts related with blog
		echo Modules::run("blog/categoryList",$blogId); 
?>	

<input type="hidden" id="countCat" value="<?php echo $countCat;?>" />
<input type="hidden" id="delCatId" name="delCatId" value="" />
</div>
<script type="text/javascript">	
	function addCategory(url,DivID,val1,val2,val3,val4,val5,val6,val7)
	{
		//#('').addClass();
		var oldCatCount = $('#countCat').val();
		
		if(oldCatCount>=0 && val2!='')
			var currentCatCount = Number(parseInt(oldCatCount)+1);
		else 
			var currentCatCount = Number(parseInt(oldCatCount));
		
		if(currentCatCount<=10 || val3>0)
		{
			$('#countCat').val(currentCatCount);
			AJAX(url,DivID,val1,val2,val3,val4,val5,val6,val7);
		}
		else
		{
			//if(val3<=0){
			alert('<?php echo $this->lang->line('categoryLimitAlert');?>');
			return false;
			//}
		}
		
		/*
		if(currentCatCount<10)
		{
			var resultantDiv = '<div class="removeIDVisa" style="float:left;"><div class="row"><div class="cell ml20" id="removeID_'+currentCatCount+'"><div class="cell empty_label_wrapper"></div><div class="cell frm_element_wrapper"><div class="cell"><input id="categoryTitle['+currentCatCount+']" class="formTip BdrCommon required width270px" type="text" title="<?php echo $label['categoryTitle'];?>" size="30" maxlength="80" value="" name="categoryTitle['+currentCatCount+']"></div><div style="padding-left:5px;" id="remScnt" class="cell"><div class="tds-button-top"><a class="formTip" href="javascript:void(0);" title="Remove" style="cursor:pointer"><span><div class="projectDeleteIcon"></div></span></a></div></div></div></div></div></div>';
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
			alert('<?php echo $this->lang->line('categoryLimitAlert');?>');
		}*/
	}
	
	function catCancel()
	{
			$('#categoryTitle').attr('value','');
			$('#categoryId').attr('value',0);
			
			$('#catCancel').hide();	
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
			alert('<?php echo  $this->lang->line('categoryRelated'); ?>');
			return false;
		}
		else
		{
			var conBox = confirm('<?php echo  $this->lang->line('categoryDelMsg'); ?>');
			if(conBox)
			{						
				if(delCatId == '')
				{
					delCatId = userDelId;
				}
				else 
					delCatId =delCatId+','+userDelId;
				
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
