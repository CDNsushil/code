<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if($projects)foreach($projects as $key=>$project){
		?>
		<div class="flower_heading">
			<?php echo $project['projName'];?>
		</div><!--flower_heading-->

		<div class="clear"></div>
		 
		<div class="posted_user_name">
			<?php echo $project['firstName'].'&nbsp;'.$project['lastName'];?>
		</div>

		<div class="clear"></div>

		<div class="video_player_wp">
			<!--<img src="<?php echo base_url();?>images/vedio_screen.jpg" class="bdr_1"/>-->
			
			<div id="videoFile" style="width:640px; height:360px; padding:0px;">
				<?php
					if(!$project['elements']){echo $constant['project_noelementFound'];}
				?>
			</div>
			<div class="piece_wp">
				<?php
				if($project['elements']){?>
					<span class="piece">Piece 1.</span>
					<div class="player_btn_wp">
					<img src="<?php echo base_url();?>images/player_btn.png" />
					</div><!--player_btn_wp-->
					
					<div class="Video_rating_wp">
					
						<div class="rating_box">
						</div><!--rating_box-->
						
						<div class="rating_box">
						</div><!--rating_box-->
						
						<div class="rating_box">
						</div><!--rating_box-->
						
						<div class="rating_box">
						</div><!--rating_box-->
						
						<div class="rating_box">
						</div><!--rating_box-->
						
					</div><!--vidio_rating_wp-->
					<?php
				}?>
			</div><!--peice_wp-->
		</div><!--vidow_palyer_wp-->
		<?php
		if($project['elements']){?>
		<div class="down_thumb_wp_shadow">
				<div id="parentId" class="down_thumb_wp_border">
						<div id="items" class="down_thumb_wrapper">
							<?php
							foreach($project['elements'] as $k=>$element){
												if($k==0){
													$firstVideoFile=$element['filePath'].$element['fileName'];
													$firstVideoFile=getImage($firstVideoFile);
												}
												$videoFile=$element['filePath'].$element['fileName'];
												$videoFile=getImage($videoFile);?>
									<div class="down_thumb_box">
										<a href="javascript:void(0);" class="formTip" title="<?php echo $element['title'];?>" onclick="PlayVideo('<?php echo $videoFile;?>')">
											<img width="91" height="131" src="<?php echo getImage($element['imagePath']);?>"/>
										</a>
									</div><!--down_thumb_box-->
									<?php
								}
							?>
							<div class="clear"></div>
						</div><!--down_thumb_wrapper-->
				</div><!--down_thumb_wp_border-->
		</div><!--down_thumb_wp_shadow-->	
		<?
	  }
	}
?>

<script type="text/javascript" charset="utf-8">
	 function PlayVideo(file, duration){ 
		$f("videoFile", "<?php echo base_url();?>player/flowplayer/flowplayer-3.2.10.swf", {

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
				url: '<?php echo base_url();?>player/flowplayer/flowplayer.controls-tube-3.2.10.swf', 
					backgroundColor: '#aedaff'
				} 
			},
			play: {
				label: null,
				replayLabel: "click to play again"
			}
		});
	}
	PlayVideo('<?php echo $firstVideoFile; ?>');
</script>
		
<?php
/* End of file filmNvideoPreview.php */
/* Location: ./application/module/media/view/filmNvideoPreview.php */
/* Wriiten By Sushil Mishra */
?>
