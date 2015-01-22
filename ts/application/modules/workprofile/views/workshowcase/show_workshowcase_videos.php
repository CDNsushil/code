<!--/* For video to play*/-->
<script type="text/javascript" src="<?php echo base_url('player/flowplayer/flowplayer-3.2.4.min.js');?>"></script>
<?php echo form_open('workProfile/workshowcase/deleteMedia',"name='mediaForm'");
			echo form_hidden('mediaForm','');
			echo form_hidden('mediaType','Videos');
// echo $WorkProfileId ;?>

<div class="row summery_post_wrapper">
	<?php echo Modules::run("common/strip");?>
		<div class="row">
			<div class=" cell frm_heading">
				<h1>Videos</h1>
			</div>
			<?php include('navigationMenu.php');?>
		</div>
	<div class="frm_wp">
		<div id="pagingContent">
		<?php foreach($values as $row){
		?>
			<div class="all_list_item ">
				<div class="pb10" style="min-height:85px">
					<div style="float:left;width:100%">
					<?php
							$writtenMaterialPath ='media/'.LoginUserDetails('username').'/workshowcase/Videos/'.$row['mediaName'];
							//echo getImage($writtenMaterialPath);
							?>

						<div style="display:inline-table;float:left;">
							<?php if($row['mediaName'] !=''){?>
							<div id="videoFile" class="videoFile"></div>
							<?php }else{?>
							<img width="90" src="<?php echo base_url().'images/no_images.jpg'?>" />
							<?php }?>
						</div>
					
						<div style="display:inline-table;float:left; padding-left:5px; width:85%">
							<div class="title-content">
								<div class="title-content-left">
									<div class="title-content-right">
										<div class="title-content-center">
											<div class="title-content-center-label"><?php echo $row['mediaTitle'];?></div>
											<div class="tds-button-top">
											<?php
												//History Edit Icon
												echo anchor('workProfile/workshowcase/addMoreVideos/'.$row['mediaId'], '<span><div class="projectEditIcon"></div></span>');	
												//History Delete Icon
												echo anchor('javascript://void(0);', '<span><div class="projectDeleteIcon"></div></span>',"onclick=DeleteAction('".encode($row['mediaId'])."');");
											?>
											</div><!--End tds-button-top-->
											<div class="clearfix" > </div>
										</div><!--End title-content-center-label-->
									</div><!--End title-content-center-->
								</div><!--title-content-right-->
							</div><!--End title-content-left-->
							<div><!--Detail Section for Work Description,Tag Words,Craves etc-->
								<div style="display:inline-table;vertical-align:middle;width:432px;padding-left:5px"> 
								<?php echo $row['mediaDesc'];?>
								</div>
								<div style="display:inline-table;text-align:center; float:right; padding-top:5px;"></div>
							</div><!--End title-content-->
							<div class="clearfix"></div>
							<table  border="0" align="right" cellpadding="0" cellspacing="2">
							<tr bgcolor="#EEEEEE">
								<td bgcolor="#EEEEEE">
									<div align="center"></div>
										<a href="#" class="tooltip" title="Total Downloads"></a>
								</td>
								<td width="40" bgcolor="#FFFFFF">
									<div align="center" class="fildsetHeading">
										<strong></strong>
									</div>
								</td>
							</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php }?>
		</div><?php if(empty($values)) { echo "<div align='center'>No Records Found</div>"; }?>
	</div>
	
	<!--frm_wp--><?php if(!empty($values)) { $this->load->view('pagination_view');}?>
</div><!--right_panel-->

<script language="javascript" type="text/javascript">
function DeleteAction(mediaId)
{

	var conBox = confirm("Are you sure you want to delete the selected record." );
	if(conBox){
		document.mediaForm.mediaForm.value = mediaId;
		document.mediaForm.submit();
	}
	else{
		return false;
	}	
}
</script>

<script type="text/javascript" charset="utf-8">
	 function PlayVideo(file, duration){
		$f("videoFile", "<?php echo base_url();?>player/flowplayer/flowplayer-3.2.7.swf", {

			// common clip: these properties are common to each clip in the playlist
			clip: { 
				// by default clip lasts 5 seconds
			  scalincg: "fit",
			  autoPlay: false,
			  autoBuffer: true,
			  image:true
			},
			
			// playlist with four entries
			playlist: [
				{url: file}
			],
			
			// show playlist buttons in controlbar
			 plugins:  {
				controls: {
					playlist: true,
					// use tube skin with a different background color
				url: '<?php echo base_url();?>player/flowplayer/flowplayer.controls-air-3.2.5.swf', 
					backgroundColor: '#aedaff'
				}
			},
			play: {
				label: null,
				replayLabel: "click to play again"
			}
		});
	}
<?php
	if(isset($writtenMaterialPath) && $writtenMaterialPath!=''){
 		echo 'PlayVideo("'.$writtenMaterialPath.'")';
	}
?>
</script>
