<?php 
$categoryTitle = array(
	'name'	=> 'categoryTitle',
	'id'	=> 'categoryTitle',
	'value'	=> set_value('categoryTitle'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip BdrCommon width270px',
	'title'       => $this->lang->line('categoryToolTip'),
	'placeholder'=>  'Category'
	//'style' => 'width:270px;',
);
$categoryArray =0;?>

<div id="categoryDiv">
	<h3><?php echo $addCatLine;?></h3>
	<div class="sap_15"></div>
	<!--label_wrapper-->
	<span class="fl defaultP pt4" >
		<?php echo form_input($categoryTitle);?>
	</span>
	<span class="fr">
		<input type="hidden" id="categoryId" value="0" />
		<input type="hidden" id="replaceId" value="0" />
		<span class="fr">
			<input type="button" onclick="addCategory('<?php echo base_url(lang().'/blog/saveblogappendcat');?>','catInfo','<?php echo $blogId;?>',$('#categoryTitle').val(),$('#categoryId').val(),'loadImg','categoryTitle','categoryId',$('#replaceId').val())" value="Save" class="fr red height40 bdr_a0a0a0 fshel_bold">
		</span>
		<span>
			<input type="button" id="catCancel" onclick="blogCatCancel();" value="Cancel" class="fr red height40 bdr_a0a0a0 fshel_bold mr10 dn">
		</span>
	</span>
	<!-- End insidecategory -->
		
	<?php
	//This shows posts related with blog
	echo Modules::run("blog/categorylisting",$blogId); 
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
	}
	
	function blogCatCancel()
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
