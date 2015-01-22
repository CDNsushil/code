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
	<div class="cell ml2" style="width:68px; text-align: center;">
		<label class="orange"><?php echo $label['image'];?></label>
	</div>
	<div class="cell promoTitle">
		<label class="orange"><?php echo $label['title'];?></label> 
	</div>
	<!--<div class="cell galAltText">
		<label class="orange"><?php //echo $this->lang->line('description');?></label>
	</div>-->
	
	
	<?php /*
	Client's req 6 aug 2012
	<div class="cell galImageName">
		<label class="orange"><?php echo $label['fileName'];?></label>
	</div>*/?>
	
	<div class="cell galImageName">
		<label class="orange"></label>
	</div>
	<div class="cell galImageAction">
		<label class="orange"><?php echo 'Action';?></label>
	</div>
	
	
</div>
<div class="row line1 width570px mr12"></div>
<div class="row"></div>

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
					$imageSrc = '<img src="'.$galImage.'" class="minMaxWidth59px" id="galImg_'.$row->postGalleryId.'" />';
					$isRecord++;
					
					if(strlen($row->galTitle) >0){
					 $mediaGalTitle = $row->galTitle;					
					}
					else 
					 $mediaGalTitle = $row->galPath;
				?>
					<div class="all_list_item">
						
						<div class="row">
							
							<div class="cell" align="center">
								<div class="defaultP">
									<input class="ticked" type="checkbox" name="galleryIds[]" value="<?=$row->postGalleryId;?>" onclick="runTimeCheckBox();" />
								</div>
							</div>
							<div class='cell ml10 maxWidth59px'>
							<div class="cell recent_thumb promoImgWrapper">
								<?php 
								
								if($row->galAltText != '') 
									$imgDesc = $row->galAltText;
								else 
									$imgDesc = $row->galPath; 
									
									$galFileType = $MediaGalleryAttribute['mime']?$MediaGalleryAttribute['mime']:'No File Type';
									$galDimension = $MediaGalleryAttribute[0]?$MediaGalleryAttribute[0].' x '.$MediaGalleryAttribute[1]:'0 x 0';
									$editBtnArr = array(
									'class'=>"GalId go formTip",
									'id'=>"GalId", 
									'postgalleryid'=>$row->postGalleryId,
									'galtitle'=>$row->galTitle,
									'galalttext'=>$row->galAltText,
									'galfiletype'=>$galFileType,
									'galdimension'=>$galDimension,
									'galfilename'=>$row->galPath,
									'galuploaddate'=>date('d/m/Y',strtotime($row->attachedDate)),
									'title'=>$imgDesc
																	
									);								
									
									echo anchor('javascript://void(0);'.$row->postGalleryId, $imageSrc,$editBtnArr);
									
									//echo anchor('javascript://void(0);'.$row->postGalleryId,$editArr, $imageSrc);
								?>
								
						   </div><!--End Cell-->
						</div>
							<div class="cell galTitle width200px">
								<div class="var_name">
								<?php
									echo getSubString($mediaGalTitle,40);
									//echo '<p>'.date('d/m/Y',strtotime($row->attachedDate)).'</p>';		
								?>
								</div>
							</div><!--End Cell-->
							
							<div class="cell galAltText">
								<?php
									/*if($row->galAltText!='') 
										echo $row->galAltText; 
									else 
										echo $label['notAvalue'];	*/
								?>
							</div><!--End Cell-->
							
							<?php 
							/*Client's req 6 aug 2012
							 * <div class="cell galImageName">
								<?php
									echo $row->galPath; 
								?>
							</div> */?>
							
							<div class="promoAction">
						<div class="modifyBtnWrapper pro_btns">
		
		<?php 
		/*echo anchor('javascript://void(0)', '<span>
			<div class="projectEditIcon"></div></span>',$editArr); */?>
		<div class="small_btn">						
		<?php 
		
		
		$editBtnArr = array('title'=>$label['edit'],
									'class'=>"GalId go formTip",
									'id'=>"GalId", 
									'postgalleryid'=>$row->postGalleryId,
									'galtitle'=>$row->galTitle,
									'galalttext'=>$row->galAltText,
									'galfiletype'=>$galFileType,
									'galdimension'=>$galDimension,
									'galfilename'=>$row->galPath,
									'galuploaddate'=>date('d/m/Y',strtotime($row->attachedDate)),
									'onclick' => 'GalId(this);'									
									);
									
			/*$editBtnArr = array('title'=>'Edit',
			'class'=>"GalId formTip",
			'id'=>"GalId", 
			'mediafileId'=>$listValue['fileId'],
			'mediaPromoId'=>$listValue['mediaId'],
			'mediaTitle'=>$listValue['mediaTitle'],
			'mediaDescription'=>$listValue['mediaDescription'],
			'title'=>$this->lang->line('edit'),
			'fileName' => $imageName ,
			'onclick' => '$(\'#PromoForm-Content-Box\').slideDown(\'slow\');'
			);		*/				
			$editImageSrc = '<span  style="background-position: right 0px;"><div class="cat_smll_edit_icon"></div></span>';
			
			echo anchor('javascript://void(0);', $editImageSrc,$editBtnArr);
		?>						
		</div>	<!-- small_btn -->
		</div>
		</div>
							<!--End Cell-->
						</div><!--End Row-->
						<div class="row heightSpacer"> </div>
					</div><!--End all_list_item-->
				<?php 
				
				}// End ForEach
				if($isRecord <=0){
				 //Client changes 6 aug 2012
				 //echo '<div style="padding:10px;width:100%;border:0px solid #000; text-align:center;" class="txtError">'.$label['noGal'] .'</div>';
				echo '<div style="padding:10px;width:100%;border:0px solid #000; text-align:center;" class="txtError">';
				echo anchor('javascript://void(0);', $label['add'],array('class'=>'a_orange formTip','title'=>$label['add'],'onclick'=>"canceltoggle(1);"));
				echo '</div>';
			 
			 }//End If
		 }
			else 
			{ 	//Client changes 6 aug 2012
				//echo '<div style="padding:10px;width:100%;border:0px solid #000; text-align:center;" class="txtError">'.$label['noGal'] .'</div>';
				echo '<div style="padding:10px;width:100%;border:0px solid #000; text-align:center;" class="txtError">';
				echo anchor('javascript://void(0);', $label['add'],array('class'=>'a_orange formTip','title'=>$label['add'],'onclick'=>"canceltoggle(1);"));
				echo '</div>';
			
			}
			//echo form_close();
			?>
		</div><!-- gallist -->
		
	</div><!-- pagingContent -->
<div class="row"></div>
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
	

		$('#browse_button').hide()
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
		$('#PromoForm-Content-Box').show();	
					
	
	
	}
</script>
