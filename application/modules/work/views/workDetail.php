<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

echo form_open('work/deleteWork',"name='work'");
echo form_hidden('workId','');
echo form_hidden('workType','');//echo "<pre>"; print_r($work);?>

<div class="row form_wrapper">	
	<?php echo $header;
	$count = 0;
	if(isset($work) && is_array($work) && count($work) > 0){
		echo "<div id='elementListingAjaxDiv' class='row'>";
			$this->load->view('work_listing' , array('work'=>$work) );
		echo "</div>";
	} 
	else{ 
		$sectionId=$this->config->item('worksSectionId');
		$returnUrl='/work/'.$workType.'/0/description/';
		?>
		<div class="blog_box_wrapper">
			<div class="row">
				<div class=" cell width_200 Cat_wrapper">			
					<?php 
					
					if($workType=='offered')
					{
						$defaultImage=$this->config->item('defaultWorkOffered_s');
					}else {
						$defaultImage=$this->config->item('defaultWorkWanted_s');
					}
					echo Modules::run("common/imageSlider",'',0,$defaultImage);
					?>				
				</div>
			</div>			  
			<div class="cell width_488 margin_left_55 pr">
				<?php
				if($this->uri->segment(4)!='deletedItems'){?>
					<div id="showContainer">
						<script>
								AJAX('<?php echo base_url(lang().'/package/getAvailableUserContainer');?>','showContainer','<?php echo $sectionId?>','<?php echo $returnUrl?>','1');
						</script>
					</div>
					<?php
				}else{
						//echo "<span class='tac'>".$constant['noRecordFound']."</span>";
				}?>
			</div>
			
		</div>
		<div class="clear"></div>
			<?php
			/*How to publish popup*/
			$this->load->view('common/howToPublish',array('industryType'=>'work'));
			/*End How to publish popup */
			?>
		<?php
	}
	?>
	
	
	<div class="clear"></div>
</div><!-- row form_wrapper -->

<div class="videoLightBoxWp" id="videoLightBoxWp" style="display:none;">
	<div id="close-postPreviewBox" class="tip-tr close-customAlert" original-title=""></div>
	<div class="productFormContainer1" id="productFormContainer1"></div>
</div>
<div class="workLightBoxWpNew" id="workLightBoxWpNew" style="display:none">
	<div id="close-previewWorkBox" class="tip-tr close-customAlert" original-title=""></div>
	<div class="productFormContainer" id="productFormContainer"></div>
</div>
<script language="javascript" type="text/javascript">

function DeleteAction(workId,workType)
{
	var conBox = confirm('<?php echo $this->lang->line('sureDelMsg')?>');
	if(conBox){
		document.work.workId.value = workId;
		document.work.workType.value = workType;
		document.work.submit();
	}else{
		return false;
	}
}

function ArchiveTogAction(work,msg)
{
	var conBox = confirm(sureHalf+" "+msg+" "+selectedRecordHalf );
		if(conBox){
			document.WorkType.workId.value = work;
			document.WorkType.workAction.value = 'archiveWork';
			document.WorkType.submit();
		}
		else{
			return false;
		}	
}

function DeleteItemsAction(dItemsworkType)
{   
	
	document.deletedItemswork.deletedItemsworkType.value = dItemsworkType;
	document.deletedItemswork.submit();
	//alert(document.deletedItemswork.deletedItemsworkType.value);
	
}

function DeletePermanentlyAction(workId,workType)
{
	var conBox = confirm('<?php echo $this->lang->line('sureDelMsg')?>');
	if(conBox){
		location.href=baseUrl+language+"/work/deletePermanently/"+workId+'/'+workType;
	}else{
		return false;
	}
}

function restoreRecord(workId,workType)
{
	var conBox = confirm('Are you sure to restore this record?');
	if(conBox){
		location.href=baseUrl+language+"/work/restoreRecord/"+workId+'/'+workType;
	}else{
		return false;
	}
}
</script>
