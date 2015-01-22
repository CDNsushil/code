<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$countAdditionalInfo=count($additionalInfo);
$AdditionalInfoFlag=false;
/*
echo "<pre>";
print_r($additionalInfo);
echo "</pre>";
*/
if($countAdditionalInfo > 0){
	foreach($additionalInfo as $m=>$additionalInfoData){
		if(is_array($additionalInfoData) && count($additionalInfoData) > 0){
			$AdditionalInfoFlag=true;
			break;
		}
	}
}
$sectionBgcolor=@$sectionBgcolor?$sectionBgcolor:'C5C5C5';
if($AdditionalInfoFlag){
	?>
	<div class="row summery_right_archive_wrapper width_auto position_relative">
		<!--tabs start-->
		<div class="tabs_RShowcase">
		  <ul id="tabs_link">
			<?php
			
			if(@$largeTab==1) {$width = 'class="width100px dash_link_hover"';$margin='class="ml130"'; $ml130='ml130';} else {$width='class="dash_link_hover"';$margin=""; $ml130="";}
			
			if(is_array($sections))foreach($sections as $k=>$section){
				$hilightClass="z_index_".(3-$k);
				$mlLocal130="";
				if($k==1 && (@$largeTab==1))$mlLocal130="ml130";
				?>
				<li id="tab0<?php echo ($k+1);?>" name="#tab<?php echo ($k+1);?>" <?php  echo 'class="'.$mlLocal130.' '.$hilightClass.'"';?>><a ><span><span <?php echo $width;?>><?php echo $section;?></span></span></a></li>
				<?php
			}?>
		  </ul>
		  <div class="clear"></div>
		</div>
		<!--tabs ends-->
		<!-- tabbox1 start-->
		<?php /* <div id="tab_content" class="global_shadow bdr_non <?php echo $sectionBgcolor;?>"> */ ?>
		<div id="tab_content" class="outershadw global_shadow <?php echo $sectionBgcolor;?>">
		  <!--content box-->
		  <?php
			foreach($additionalInfo as $i=>$infoSection){
				$section=$sections[$i];
				//if(!is_array($infoSection) || count($infoSection) <= 0) $thisSectionBackColor[$i] = 'backgroundBlack';
				if(!is_array($infoSection) || count($infoSection) <= 0) $thisSectionBackColor[$i] = '';
				
				?>
				
				<?php /*<div class="scroll_box innershadw bg-non-color" id="tab<?php echo ($i+1)?>"> */?>
				<div class="scroll_box innershadw bg-non-color <?php echo @$thisSectionBackColor[$i]; ?>" id="tab<?php echo ($i+1)?>" >
					<div id="additionalInfoSlider<?php echo ($i+2)?>" class=" slider mt3 scroll_light_btn nriSlider"> <a class="buttons prev" href="#"></a>
					  <div class="viewport scroll_container02">
						  <?php
						  if(is_array($infoSection) && count($infoSection) > 0){
							  foreach($infoSection as $j=>$info){
								  $AIData=array('info'=>$info,'fieldPrefix'=>$fieldPrefix[$i],'section'=>$section);
								  $AIData=json_encode($AIData);
								  $consteent=$i.'_'.$j;
								  echo ' <script>var AIData'.$consteent.'='.$AIData.';</script>';
								}
						  }?>
						
						<ul class="overview">
						  <?php
						  if(is_array($infoSection) && count($infoSection) > 0){
							  
							  foreach($infoSection as $j=>$info){
								  $title=$fieldPrefix[$i].'Title';
								  $description=$fieldPrefix[$i].'Description';
								  $Title=getSubString($info->$title,20);
								  if(is_numeric($info->$description)){
									 $info->$description= ''; 
								  }
								  $Description=getSubString($info->$description,60);
								  $info->$description=urlencode( $info->$description);
								  $consteent=$i.'_'.$j;
								  $ml55='ml55 width_213';
								  if($fieldPrefix[$i]=='interv' || $fieldPrefix[$i]=='review'){
									  $ml55='width_286';
								  }
								  ?>
								  <li>
									 
									 <div class="row recent_box_wrapper01 ptr" onclick="javascript:lightBoxWithAjax('popupBoxWp','popup_box','/additionalInfo/additionalInfoPopup',AIData<?php echo $consteent;?>);">
									  <div class="row">
										<?php
											 if(!($fieldPrefix[$i]=='interv' || $fieldPrefix[$i]=='review')){ ?>
												  <div class=" cell recent_thumb01 thumb_absolute01 cell "><div class="AI_table"> <div class="AI_cell"> <img class="max_w43_h49" border="0" src="<?php echo base_url($this->config->item('defaultNewsImg_s'));?>"></div></div> </div>
											<?php
											}
										?>
										<div class="cell <?php echo $ml55;?>">
										  <div class="cell recent_two_line02 padding_left10 pt4"> 
											<span class="recent_short_title Fleft dash_link_hover"><?php echo $Title?> </span> 
											<span class="recent_short_txt clear"> <?php echo changeToUrl($Description)?> </span></div>
										</div>
										<div class="clear"></div>
									  </div>
									  <div class="clear"></div>
									</div>
								  </li>
								 <?php
							 }
						}
						else{ ?>
						<li>
							<div class="width260px height200px">
								<div class="AI_table">
									<div class="AI_cell"><img src="<?php echo base_url();?>images/toadsquare_gray_logo.png" ></div>
								</div>
							</div>
						</li>
						<?php
						}?> 
						</ul>
					  </div>
					  <a class="buttons next" href="#"></a>
					</div>
				</div>
				<?php
			}
		  ?>
		</div>
		<!-- tabbox1 end-->
	</div>
	<script type="text/javascript">
	/*tab function*/
	function resetTabs(){
		$("#tab_content > div").hide(); //Hide all content
		$("#tabs_link li").attr("class",""); //Reset id's      
	}
	$(document).ready(function(){
		var myUrl = window.location.href; //get URL
		var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // For mywebsite.com/tabs.html#tab2, myUrlTab = #tab2     
		var myUrlTabName = myUrlTab.substring(0,4); // For the above example, myUrlTabName = #tab

		(function(){
				$("#tab_content > div").hide(); // Initially hide all content
				$("#tabs_link li:first").attr("class","current"); // Activate first tab
				$("#tab_content > div:first").fadeIn(); // Show first tab content
				
				$("#tabs_link li").on("click",function(e) {
					e.preventDefault();
					if ($(this).attr("class") == "current"){ //detection for current tab
					 return       
					}
					else{             
					resetTabs();
					$(this).attr("class","current"); // Activate this
					$($(this).attr('name')).fadeIn(); // Show content for current tab
						
						if ($(this).attr("id") == "tab01"){ //detection for current tab
							
							//$("#tab01").attr("class","z_index_3");
							//$("#tab02").attr("class","z_index_2 <?php echo @$ml130;?>");
							//$("#tab03").attr("class","z_index_1");
							$("#tab01").addClass("z_index_3");
							$("#tab02").addClass("z_index_2 <?php echo @$ml130;?>");
							$("#tab03").addClass("z_index_1");
								   
							}
						else if ($(this).attr("id") == "tab02"){ //detection for current tab
							
							//$("#tab01").attr("class","z_index_1");
							//$("#tab02").attr("class","z_index_3");
							//$("#tab03").attr("class","z_index_2 <?php echo @$ml130;?>");
							$("#tab01").addClass("z_index_1");
							$("#tab02").addClass("z_index_3 <?php echo @$ml130;?>");
							$("#tab03").addClass("z_index_2");
								   
							}
						else {
							//$("#tab01").attr("class","z_index_1");
							//$("#tab02").attr("class","z_index_2 <?php echo @$ml130;?>");
							//$("#tab03").attr("class","z_index_3");
							$("#tab01").addClass("z_index_1");
							$("#tab02").addClass("z_index_2 <?php echo @$ml130;?>");
							$("#tab03").addClass("z_index_3");
						
							}
					}
				});

				for (i = 1; i <= $("#tabs_link li").length; i++) {
				  if (myUrlTab == myUrlTabName + i) {
					  resetTabs();
					  $("a[name='"+myUrlTab+"']").attr("class","current"); // Activate url tab
					  $(myUrlTab).fadeIn(); // Show url tab content        
				  }
				}
			})()
			
			$('#additionalInfoSlider2').tinycarousel({ axis: 'y', display: 3});	
			$('#additionalInfoSlider3').tinycarousel({ axis: 'y', display: 3});
			$('#additionalInfoSlider4').tinycarousel({ axis: 'y', display: 3});	
				
	});
	</script>
	<?php
}
?>
