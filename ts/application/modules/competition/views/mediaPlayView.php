<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  ?>

<div class="bdr_a8a6a6 backtocomp_shedow width_465">
				
	<!----audio media player div start--->
	<div class="bg_313131 pb70 pt70 mH40 tac dn" id="audioDiv">
	  <div class="margin_auto">
			<div class="AI_table">
				<div class="AI_cell">
				  <div id="imageHolder mH20">
					<div id="audioDivFrame" class="dn" >
						<iframe src="" id="audioMediaShow" width="285" height="65" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" scrolling="no"></iframe>
					</div>
					<div id="audioLoaderDiv" class="mediaLoadDiv pt10" style="display: none; "><img src="<?php echo base_url('images/loading_wbg.gif');?>"></div>
				  </div>
				</div>
			</div>                  
		</div>
	</div>
	<!----audio media player div end--->
	
	<!----video media player div start--->
	<div class="bg_313131 dn" id="videoDiv">
		<div class="w700_h330 margin_auto">
			<div class="AI_table">
				<div class="AI_cell">
				  <div id="imageHolder" class="height270">
					<div id="videoDivFrame" class="dn ">
						<iframe src="" id="videoMediaShow" width="465" height="270" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" scrolling="no"></iframe>
					</div>
					<div id="videoLoaderDiv" class="mediaLoadDiv pt125" style="display: none; "><img src="<?php echo base_url('images/loading_wbg.gif');?>"></div>
				  </div>
				</div>
			</div>                  
		</div>
	</div>
	<!----video media player div end--->
	
	<!----Image div start--->
	<div class="bg_313131 dn" id="imageDiv">
		<div class="w700_h330 margin_auto">
			<div class="AI_table">
				<div class="AI_cell">
				  <div id="imageHolder">
					<div id="imageDivFrame" >
						<img id="imageshow" src="" alt="video">
					</div>
				  </div>
				</div>
			</div>                  
		</div>
	</div>
	<!----Image div end--->

</div>


<script type="text/javascript">
	// change media url and play it
	function playMedia(mediaUrl,mediaType){
		
			// set default value blank and hide 
			$("#audioMediaShow").attr("src",'')
			$("#videoMediaShow").attr("src",'')
			$("#imageshow").attr("src",'')
			$("#audioDiv").hide();
			$("#videoDiv").hide();
			$("#imageDiv").hide();
			$("#videoDivFrame").hide();
			$("#audioDivFrame").hide();
			
			// set condition for image file
			if(mediaType==1){
				$("#imageshow").attr("src",mediaUrl)
				$("#imageDiv").show();
			}
			
			// set condition for video file
			if(mediaType==2){
		
				// show main div
				$("#videoDiv").show();
				
				// hide and show loader div
				$("#audioLoaderDiv").hide();
				$("#videoLoaderDiv").show();
				$("#videoMediaShow").attr("src",mediaUrl)
				
				// iframe loaded event detect
				$("#videoMediaShow").load(function (){
					$("#videoLoaderDiv").hide();
					$("#videoDivFrame").show();
				});
			}
			
			// set condition for audio file
			if(mediaType==3){
			
				//show main div
				$("#audioDiv").show();
				
				// hide and show loader div
				$("#audioLoaderDiv").show();
				$("#videoLoaderDiv").hide();
				$("#audioMediaShow").attr("src",mediaUrl)
				
				// iframe loaded event detect
				$("#audioMediaShow").load(function (){
					$("#audioLoaderDiv").hide();
					$("#audioDivFrame").show();
				});
			}
		}
</script>
