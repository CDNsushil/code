<script language="javascript" type="text/javascript" >

//Functionality for "YES" button of prompt
function deleteGallery(confirmflag){
	if(confirmflag=='t'){
		document.GalleryAction.submit();
	}
	else{
		$('#YesNoBoxWp').trigger('close');	
	}			
}

//Functionality for "NO" button of prompt
function noGallery(){
	$('#YesNoBoxWp').trigger('close');	
}

//Delete the selected gallery image if no gallery is selected alert with message
function showYesNo()
{
	var n = $("input:checked").length;
	if(n>0){
		$("#YesNoBoxWp").lightbox_me('center:true');
	}else{
		alert('Please tick the checkbox(s) to delete');
		return false;
	}
}

</script> 

<div id="YesNoBoxWp" class="customAlert" style="display:none; width:430px;">
	<div id="close-YesNoBox" title="Close it" class="tip-tr close-customAlert"></div>			
	<div class="row">
		<div class="cell"><?php echo $label['msgBeforeDelete'];?></div> 
	</div>
	<div class="row">
		<div class="cell" style="width:50%">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>Yes</span>',array('onclick'=>'deleteGallery(\'t\');','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
		<div class="cell">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>No</span>',array('onclick'=>'noGallery();','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
	</div>
</div>
<!------- Top Most Menu Buttons ------->     
<?php echo Modules::run("blog/menuNavigation",$blogId); ?> 
<!------ End Of Top Menu ------->     
<!-- TITLE BAR -->
<?php
  echo form_open('blog/deleteGalleryId','name="GalleryAction"','id="GalleryFrm"');
	?>	
	<div class="title-content">
	  <div class="title-content-left">
		<div class="title-content-right">
		  <div class="title-content-center">
				<div class="title-content-center-label"><?php echo $label['mediaGallery']; ?></div>
					
				<div class="tds-button-top"> 
				<?php 
				echo anchor('blog/postMediaGalleryForm/0', '<span><div class="projectAddIcon"></div></span>',array('class'=>'formTip','title'=>$label['addImage']));
				if(count($values) > 0)
				{
				?>
				
				<a href="javascript:void(0);" onclick="showYesNo();" class="formTip" Title="<?php echo $label['Delete'];?>"><span>
				<div class="projectDeleteIcon"></div>
				</span></a> 
				<?php }	?>
					</div>
					<div class="clearfix" > </div>
		  </div>
		</div>
	  </div>
	</div>
	<?php /*?>
	<div class="tds-button floatRight"><?php echo anchor('blog/postMediaGalleryForm/0', '<span>'.$label['addGallery'] .'</span>'); ?></div><?php*/
	?>
	<div class="row">
		<div class="cell ui-state-focus" style="width:45px;" align="center">#</div><div class="cell">&nbsp;</div>
		<div class="cell ui-state-focus" style="width:200px;" align="center"><? echo $label['image'];?></div><div class="cell" >&nbsp;</div>
		<div class="cell ui-state-focus" style="width:100px;" align="center"><?php echo $label['fileName'];?></div><div class="cell" >&nbsp;</div>
		<div class="cell ui-state-focus" style="width:100px;" align="center"><?php echo $label['dateCreated'];?></div><div class="cell" >&nbsp;</div>
		<div class="cell ui-state-focus" style="width:195px;" align="center"><?php echo $label['title'];?></div><div class="cell" >&nbsp;</div>
		<div class="cell ui-state-focus" style="width:104px;" align="center"><?php echo $label['altText'];?></div><div class="cell" >&nbsp;</div>
		
	</div>
	<div class="clearfix" > </div>

<div id="pagingContent" >
<?php
$isRecord = 0;
$totalRecords = count($values);
if($totalRecords > 0)
{
  foreach($values as $row)
  {
		
?>
<div class="all_list_item ">
<div class="pb10">
<?php			
// Use strrpos() & substr() to get the file extension
$ext = substr($row->galPath, strrpos($row->galPath, "."));
// Then stitch it together with the new string and file's basename and adding suffix to show extra small image
$newImageName = basename($row->galPath, $ext) . $suffix . $ext;

$gallery_thumbs_folder = $gallery_thumb_version_folder.'/';
$galleryThumbsFolderPath = 'media/'.LoginUserDetails('username').'/project/blog/gallery/'.$gallery_thumbs_folder.$newImageName ;

//defining the path to show images
	if(file_exists($galleryThumbsFolderPath)) $showOrgImage =1;
	else  $showOrgImage =0;
	
	$isRecord++;
?>
		
<div class="row" style="border:0px solid; padding-top:5px; vertical-align:text-top; ">

		<div class="cell" style="width:45px;" align="center">
		<input class="ticked" type="checkbox" name="galleryIds[]" id="galleryCheck" value="<?=$row->postGalleryId;?>" />
		</div><div class="cell" style="padding-left:3px;">&nbsp;</div>
		<div class="cell" style="width:205px;" align="center">
	<?php 	
		if($showOrgImage == 1){		
		$imageSrc =  '<img style="margin:auto;" src="'.getImage($galleryThumbsFolderPath).'" class="formTip HoverBorder" title="'.$label['updateImageMsg'].'" />';
		}else $imageSrc =  '<img style="margin:auto; min-height:100px; max-height:100px;min-width:100px;"  src="'.getImage($galleryThumbsFolderPath).'" class="formTip HoverBorder" title="'.$label['updateImageMsg'].'" />';
		echo anchor('blog/postMediaGalleryForm/'.$row->postGalleryId, $imageSrc);?>
		</div><div class="cell" style="padding-left:3px;">&nbsp;</div>
		<div class="cell" style="width:100px;" align="center">
			<?php echo $row->galPath;?>
		</div>
		<div class="cell" style="padding-left:3px;">&nbsp;</div>
		<div class="cell" style="width:100px;" align="center">
			<?php echo date('d/m/Y',strtotime($row->attachedDate));?>
		</div>
		<div class="cell" style="padding-left:3px;">&nbsp;</div>
		<div class="cell" style="width:188px;" align="center">
			<?php if($row->galTitle!='') echo $row->galTitle; else  echo $label['notAvalue'];?>
		</div>
		<div class="cell" style="padding-left:3px;">&nbsp;</div>
		<div class="cell" style="width:104px; vertical-align:middle" align="center">
			<?php if($row->galAltText!='') echo $row->galAltText; else echo $label['notAvalue'];?>
		</div>

</div>      
		<?php
		
	?>
	</div><!-- End all_list_item-->
</div><!-- End pb10-->
	<?php	
  }//End For
if($isRecord <=0) echo '<div style="padding:10px;width:100%;border:0px solid #000; text-align:center;" class="txtError">'.$label['noGal'] .'</div>';
 }//End If

	else 
	{
		echo '<div style="padding:10px;width:100%;border:0px solid #000; text-align:center;" class="txtError">'.$label['noGal'] .'</div>';
	}
		echo form_close();
?>
</div>	<!-- End pagingContent -->
<div class="clearfix"></div>
<?php 
	$post_page['record_num'] = 10;
	if($totalRecords > $post_page['record_num']) $this->load->view('pagination_view',$post_page);
?>
