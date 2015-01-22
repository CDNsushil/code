<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php
	$lableNewPost = '<span>'.$label['newPost'].'</span>';
	$labelBlogSetting = '<span>'.$label['blogSetting'].'</span>';
	$labelBlogArchive = '<span>'.$label['blogDelItems'].'</span>';

echo form_open('blog/deleteGalleryId','name="GalleryAction"','id="GalleryFrm"');
?>
<div class="row lineHeight35px">
	<div class="cell width30px mt7 ">
		<div class="defaultP">
			<input class="selectall" type="checkbox" name="allGalleryIds" id="allGalleryIds" onclick="clickAllGalleryIds();" />
		</div>
	</div>
	<div class="cell ml2" style="width:68px">
		<label class="orange"><?php echo $label['image'];?></label>
	</div>
	<div class="cell galTitle">
		<label class="orange"><?php echo $label['title'];?></label> 
	</div>
	<div class="cell galAltText">
		<label class="orange"><?php echo $label['alternativeText'];?></label>
	</div>
	<div class="cell galImageName">
		<label class="orange"><?php echo $label['fileName'];?></label>
	</div>
</div><!--End Row-->

<div class="row line1"></div>

	<div id="gallist" >
		<div class="row seprator_15"></div>
			<div id="pagingContent" >

			<?php
			$isRecord = 0;
			$totalRecords = count($values);

			if($totalRecords > 0)
			{
				foreach($values as $row)
				{						
					$galImage = getImage('media/'.LoginUserDetails('username').'/project/blog/gallery/'.$row->galPath);
					$MediaGalleryAttribute = @getimagesize('media/'.LoginUserDetails('username').'/project/blog/gallery/'.$row->galPath); //To get image attributes
					$countGalleryCount = count($MediaGalleryAttribute);
					$imageSrc = '<img src="'.$galImage.'" class="formTip HoverBorder minMaxWidth59px" title="'.$label['updateImageMsg'].'" id="galImg_'.$row->postGalleryId.'" />';
					$isRecord++;
				?>
					<div class="all_list_item">
						
						<div class="row">
							
							<div class="cell" align="center">
								<div class="defaultP">
									<input class="ticked" type="checkbox" name="galleryIds[]" value="<?=$row->postGalleryId;?>" onclick="runTimeCheckBox();" />
								</div>
							</div>
							
							<div class="cell recent_thumb ml2">
								<?php 
								
									$galFileType = $MediaGalleryAttribute['mime']?$MediaGalleryAttribute['mime']:'No File Type';
									$galDimension = $MediaGalleryAttribute[0]?$MediaGalleryAttribute[0].' x '.$MediaGalleryAttribute[1]:'0 x 0';
									$editArr = array('title'=>$label['edit'],
									'class'=>"GalId go",
									'id'=>"GalId", 
									'postgalleryid'=>$row->postGalleryId,
									'galtitle'=>$row->galTitle,
									'galalttext'=>$row->galAltText,
									'galfiletype'=>$galFileType,
									'galdimension'=>$galDimension,
									'galfilename'=>$row->galPath,
									'galuploaddate'=>date('d/m/Y',strtotime($row->attachedDate)),
									'onclick'=>'GalId(this);'									
									);
									
									echo anchor('javascript://void(0);'.$row->postGalleryId, $imageSrc,$editArr);
								?>									
						   </div><!--End Cell-->
						
							<div class="cell galTitle">
								<?php
									if($row->galTitle!='') 
										echo $row->galTitle; 
									else  
										echo $label['notAvalue'];
									echo '<p>'.date('d/m/Y',strtotime($row->attachedDate)).'</p>';		
								?>
							</div><!--End Cell-->
							
							<div class="cell galAltText">
								<?php
									if($row->galAltText!='') 
										echo $row->galAltText; 
									else 
										echo $label['notAvalue'];	
								?>
							</div><!--End Cell-->
							
							<div class="cell galImageName">
								<?php
									echo $row->galPath; 
								?>
							</div><!--End Cell-->
						</div><!--End Row-->
						<div class="row heightSpacer"> </div>
					</div><!--End all_list_item-->
				<?php 
				
				}// End ForEach
				if($isRecord <=0) echo '<div style="padding:10px;width:100%;border:0px solid #000; text-align:center;" class="txtError">'.$label['noGal'] .'</div>';
			 }//End If
			else 
			{
				echo '<div style="padding:10px;width:100%;border:0px solid #000; text-align:center;" class="txtError">'.$label['noGal'] .'</div>';
			}
			//echo form_close();
			?>
		</div><!-- gallist -->
		
	</div><!-- pagingContent -->
<div class="row line1"></div>
<div class="row seprator_5"></div>

<?php
$post_page['record_num'] = 10;

if($totalRecords > $post_page['record_num']) $this->load->view('pagination_view',$post_page);

?>	
<div class="seprator_5 row"></div>
<script language="javascript" type="text/javascript">

//To check/uncheck all check boxes on click 

function clickAllGalleryIds()
{
		if	($('#allGalleryIds').is( ':checked' ))
		{
			$(".ticked").each( function() {
				$(this).attr("checked",true);
				$(".ez-checkbox").addClass("ez-checked");
			});
		}
		else
		{
			$(".ticked").each( function() {
				$(this).attr("checked",false);
				$(".ez-checkbox").removeClass("ez-checked");
			});
		}
}

//To fill the post gallery form on click on image
function GalId(obj)
{		
		var postgalleryid = $(obj).attr('postgalleryid');
		var galtitle = $(obj).attr('galtitle');
		var galalttext = $(obj).attr('galalttext');		
		var galfiletype = $(obj).attr('galfiletype');		
		var galdimension = $(obj).attr('galdimension');		
		var galfilename = $(obj).attr('galfilename');		
		var galuploaddate = $(obj).attr('galuploaddate');		
		
		new_img_src = $('#galImg_'+postgalleryid).attr('src');

		$('#galImage').attr('src',new_img_src);	
				
		$('#postGalleryId').val(postgalleryid);
		$('#galTitle').val(galtitle);
		$('#galAltText').val(galalttext);
		$('#galFileType').val(galfiletype);
		$('#galDimension').val(galdimension);
		$('#galFileName').val(galfilename);
		$('#galUploadDate').val(galuploaddate);
		$('#FileUpload').hide();
		$('#showGalForm').show();		
	
	}
</script>
