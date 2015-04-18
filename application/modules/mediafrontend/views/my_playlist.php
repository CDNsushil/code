<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<td width="800" valign="top" class="fv_content_bg">
	<?php 
		if($userPlaylistData && getMyPlaylistCount($tdsUid)){
		
		$imagetype_xs = $this->config->item('musicNaudioImage_xs');	
		$imagetype_s = $this->config->item('musicNaudioImage_s');	
		
		$userInfo =showCaseUserDetails($tdsUid);
		if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
			$creative_name= $userInfo['enterpriseName'];
		}else{
			$creative_name= $userInfo['userFullName'];
		}	
			
		?>				
		<div class="row  pl6 pr6 pt10 pb10">
			<h1 class="sumRtnew_strip clr_white">My Playlist</h1>
			<div class="grey mt5"><?php echo ucwords($creative_name);?></div>
			<div class="player_position">
				<?php echo Modules::run("player/audioplaylistplay"); ?>	
			</div>
			<div class="slider pb3" id="playListSlider">
				<div class="fr mr9">
					<a href="#" class="buttons  prev mr2 disable"></a>
				</div>
				 
			   <div class="viewport CSEplaylist_scroll_container mt11  global_shadow rightBoxBG pl6 pr6 pb6 width_740_bord "  id="myplaylist">
					  <ul class="overview">
						<?php 
							$count=0;
							$first_element_id='';
							foreach($userPlaylistData as $userPlaylist){
							
							if($count==0){
								 $first_element_id = $userPlaylist['elementId'];
							}	 
								
							$thumbImage = addThumbFolder($userPlaylist['imagePath'],'_xs');	
							$elementImage=getImage($thumbImage,$imagetype_xs);	
							
							// make music image show
							$thumbImage_src = addThumbFolder($userPlaylist['imagePath'],'_s');	
							$elementImage_src=getImage($thumbImage_src,$imagetype_s);
							
							// get audio file path
							$MainFilePath 	=	$userPlaylist['filePath'].$userPlaylist['fileName'];
							
							// check media file exist
							if(file_exists($MainFilePath)) {
							
							//$getFullFilePath	=	str_replace('media','',$getFullFilePath);
							$getFullFilePath =  base_url($MainFilePath);
							?>	
								<li>
									<a id="fire_<?php echo $userPlaylist['elementId'];?>" href="<?php echo $getFullFilePath; ?>" onclick="playNpaush('<?php echo $userPlaylist['elementId'];?>')" playingElementId="<?php echo $userPlaylist['elementId'];?>"  onmousedown="mousedown_tds_download('#dwnFileBtrn<?php echo $userPlaylist['elementId'];?>')" onmouseup="mouseup_tds_download('#dwnFileBtrn<?php echo $userPlaylist['elementId'];?>')">
									  <div class="row recent_box_wrapper01 mH70" >
										  <div class="cell recent_thumb_PApage thumb_absolute01 ptr" >
											<div class="AI_table">
											  <div class="AI_cell"> <img class="max_w68_h68 bdr_cecece" src="<?php echo $elementImage;?>"></div>
											</div>
										  </div>
										  <div class="row ml70 ">
											<div class="row recent_two_line01 height_30 lh25 pl20 fm_os"><?php echo getSubString($userPlaylist['title'],100);?></div>
											
											<div class="row SMA_blog_status_bar width_665">
												<div class="fr ml20 ">
													<div class="Fright"><div>
														<span class="status_bar_play_btn font_opensans width_40 playingButton mt3" playstatus='play' music_Title='<?php echo getSubString($userPlaylist['title'],100);?>' music_Image='<?php echo $elementImage_src;?>'  id="button<?php echo $userPlaylist['elementId'];?>" elementId="<?php echo $userPlaylist['elementId'];?>"> </span>
													</div> </div>
												</div>
												<div class="mt7 fr ">
													<div class="blogS_view_btn fl minwidth ml8"><span class="inline"><?php echo $userPlaylist['viewCount'];?></span></div>
													<div class="blogS_crave_btn fl minwidth ml20 cravedALL"><span class="inline"><?php echo $userPlaylist['craveCount'];?></span></div>
												</div>
												<div id="loadertxt_<?php echo $userPlaylist['elementId'];?>" class="Fright mt11 dn mr10 mL5 playingLoader"><img src="<?php echo  base_url(); ?>images/loading_wbg.gif" ></div>
											
											</div>
										  </div>
										
										<div class="clear"></div>
									  </div>
								 </a>
							  </li>
							  
						<?php $count++; }  } ?>	
					  </ul>
				</div>
				<div class="fr clear mr9">
					<a href="#" class="buttons next mr2"></a>
				</div>
				 
			</div>
			
		
		<?php	
			
			// share details for share
			$competitionTitle= "My Playlist";
			$entityId='';
			$projectId = '';
			$industryType = 'myplaylist';
			
			//--------share button code--------//
			$currentUrl = base_url().uri_string();
			$relation = array('getFrontShortLink', 'email','share','entityTitle'=> $competitionTitle, 'shareType'=>'competition details', 'shareLink'=> $currentUrl,'id'=> 'Project'.$project['projectid'],'entityId'=>$entityId,'elementid'=>$projectId,'projectType'=>$industryType,'isPublished'=>'t','viewType'=>'showcase');
			$this->load->view('common/relation_to_share',array('relation'=>$relation));
		
		?>	
			
		</div>	
	
	<?php }else{
			echo '<div class="p10 red">'.$this->lang->line('noRecord').'</div>';
	}  ?>
	
</td>
<td class="advert_column"  valign="top">
	<div class="cell advert_column ">
	  <div class="seprator_5"></div>
		<div class="ad_box ml11 mt10 mb10"><?php $this->load->view('common/adv_vertical'); ?></div>
	</div>
</td>

<script type="text/javascript">
	
	// Playlist slider	
	$(document).ready(function(){
		if($('#playListSlider'))	
		$('#playListSlider').tinycarousel({ axis: 'y', display: 6, start:1});	
	});
	
	// dedfine player button class
	var playerButtonColor='status_bar_play_btn_hover font_opensans width_40 playingButton mt3'; 
	var playerButton='status_bar_play_btn font_opensans width_40 playingButton mt3';
	
	// change text playing, play and paush 
	function playNpaush(elementId){
		
		var idName= 'button'+elementId;
		

		// set player status playing and pause
		if($("#"+idName).attr('playstatus')=="Playing"){
			$("#"+idName).attr('playstatus','Pause'); // set puase text
			$("#"+idName).removeClass();//remove normal button class
			$("#"+idName).addClass(playerButton);// add color button class
			$("#loadertxt_"+elementId).css("display","none");	
		}else{
			$("#"+idName).attr('playstatus','Playing'); // set playing text
			$('#musciTitle').html($("#"+idName).attr('music_Title'));// show current playing music title
			$('#musciImg').attr('src',$("#"+idName).attr('music_Image'));// show current playing music image
			$("#"+idName).removeClass();
			$("#"+idName).addClass(playerButtonColor);
	
			$("#loadertxt_"+elementId).css("display","block");	
		}
	}
	
	// set player auto play change status
	function AutoPlayAudio(elementId){
		
		var idName= 'button'+elementId;
		
		$(".playingButton").each(function(){
			var getElementId = $(this).attr('id');
			if(getElementId!=elementId){
				var	idAllName= 'button'+getElementId;
				$("#"+$(this).attr('id')).attr('playstatus','Play');// set default player status
				$("#"+$(this).attr('id')).removeClass();
				$("#"+$(this).attr('id')).addClass(playerButton);
				
			}
		});
		$("#"+idName).attr('playstatus','Playing'); // set playing text
		$("#"+idName).removeClass(); // remove normal button class
		$("#"+idName).addClass(playerButtonColor); // add button color class
		$('#musciTitle').html($("#"+idName).attr('music_Title')); // show current playing music title
		$('#musciImg').attr('src',$("#"+idName).attr('music_Image')); // show current playing music image
		
	}

	// play and puash music	
	/*$(document).ready(function(){
		$("#fire_<?php echo $first_element_id; ?>").click();
	});
	
	setTimeout("player_stop()", 4000);*/
		
	function first_music_details(){
		var firstElementId='<?php echo $first_element_id; ?>';
		//$f().pause();
		//$("#button"+firstElementId).attr('playstatus','Pause');
		//$("#button"+firstElementId).removeClass();//remove normal button class
		//$("#button"+firstElementId).addClass(playerButton);// add color button class
		//$("#loadertxt_"+firstElementId).css("display","none");	
		var idNameFirst= 'button'+firstElementId;
		
		$('#musciTitle').html($("#"+idNameFirst).attr('music_Title')); // show current playing music title
		$('#musciImg').attr('src',$("#"+idNameFirst).attr('music_Image')); // show current playing music image
	}
	
	first_music_details();	
	
</script>
