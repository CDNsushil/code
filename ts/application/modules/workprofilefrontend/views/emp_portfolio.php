<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$accessUserProfile = (isset($accessUserProfile) && ($accessUserProfile!='')) ? $accessUserProfile :''; ?>


 <div class="content_wrapper_front">
      <div class="seprator_9"></div>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td valign="top" class="left_coloumn_profile"><a class="circled_link_box" href="<?php echo base_url()?>workprofilefrontend/index/<?php echo $accessUserProfile ?>">
            <div class="seprator_18"></div>
            <div class="workprofile_icon_wp"></div>
            <div class="font_opensansSBold font_size13 text_alignC pt6"><?php echo $this->lang->line('workBrProfile');?></div>
            </a>
            <div class="seprator_20"></div>
            <div class="width_150 font_opensans pb20 margin_auto break_word">
              <div class="font_size18 text_alignR pb18 pr20 mt_minus4">
              
              <?php 
					        if(isset($workDetail->profileFName) && !empty ($workDetail->profileFName))
					        
					        { echo $workDetail->profileFName .' '.$workDetail->profileLName; } 
					        
					        
					        $mediaDetail = getMediaDetail($workDetail->fileId);
							if(is_array($mediaDetail) && !empty($mediaDetail))
							{
								$profileImgPath = $mediaDetail[0]->filePath;
								$profileImgName = $mediaDetail[0]->fileName;
							}else
							{
								$profileImgPath = '';
								$profileImgName = '';
							}
							
							$workProfileThumbImage = addThumbFolder(@$profileImgPath.$profileImgName,'_s');	
							
							$workProfileSrc = '<img src="'.getImage($workProfileThumbImage,$this->config->item('defaultWorkWanted_s')).'" class="bdr_white max_h128_w128 left_colum_thumb" />'
					        
					        
					        ?>
              
              
              </div>
              <div class="AI_table">
                <div class="AI_cell"><?php echo $workProfileSrc; ?></div>
              </div>
              <div class="seprator_20 clear"></div>
              
              <div class="seprator_40"></div>
              <div class=" clr_898989 text_alignR font_size13"><?php if (isset($workDetail->profileAdd)) echo $workDetail->profileAdd ?><br>
                <?php if (isset($workDetail->profileStreet)) echo $workDetail->profileStreet ?><br>
               <?php echo $workDetail->profileCity ?><br>
                  <?php echo $workDetail->profileZip?><br>
               <?php echo getCountry($workDetail->profileCountry)?>
                <div class="seprator_25"></div>
                 <?php  if((isset($workDetail->profilePhone)) && ($workDetail->profilePhone!='')) echo '+ '.$workDetail->profilePhone ?><br />
                    <?php echo $workDetail->profileEmail ?> </div>
            </div>
            <!--left_coloumn-->
          </td>
          <td valign="top" class="right_coloumn_profile">
          <div class="position_relative minh_1125">
              <div class="orange_strip"></div>
             <?php  if(isset($video) && count($video) > 0) { ?>
             
              <?php  if(isset($video) && count($video) > 1) { ?>
				<div class="gall_btn_profile"><a id="prevImageButton" href="javascript:prevImage()" class="gall_pre_btn_profile Fleft disable"></a> <a id="nextImageButton" href="javascript:nextImage()" class="gall_next_btn_profile Fright"></a></div>
			 <?php } ?>
             <div id="imageHolder">  
              
              <div id="titleDiv" class="font_opensans font_size18 clr_c5c3c3 pl25 pr130 pt20 mH20"></div>
              <div class="frame_box ml12 mr12 mt20">
                <div class="bg_313131 pb25 pt25" >
                  <!--video box-->
                  <div class="bg_222222 w700_h330 margin_auto" >
					<div class="AI_table">
						<div class="AI_cell">
						  <div id="imageHolder">
							<div id="imageDiv">
								<iframe src="" width="700" height="330"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no" style="margin:0; padding:0; border:0px solid #CC00DD;"></iframe> 	
							</div>
							<div id="loaderDiv"  class="mediaLoadDiv"><img src="<?php echo  base_url().'images/'; ?>loading_wbg.gif"></div>
							<!----<div id="messageDiv" align="center"><img src="<?php //echo base_url()?>images/default_thumb/no_multimedia_icon.png"></div>---->
							
						  </div>
						</div>
					</div>                  
                </div>
              
              </div>
               </div>  
            	
              <div class="clr_c5c3c3 font_size13 width640px pl47 pt25 pb25" id="imageDescription"></div>
              </div>
              <?php } ?>
              
              <ul id="imageList" class="hidden">

			   <?php 
			   if(isset($video)) {
				   
			   foreach($video as $vid) { 
				   
				
				/*************Here check exnternal video display code**************/ 
				$tableName = getMasterTableName('42');
				
				$mediaTableName= $tableName[0];
						 
				//get media file type 
				$getType = getDataFromTabel('MediaFile','fileType,isExternal,filePath', 'fileId', $mediaId, 'fileId', 'ASC',1,0,true);
								
				if($getType[0]['isExternal']=="t")
				{
					//this section is for external video
					$getMediaUrlData = getMediaUrl($getType[0]['filePath']);
					
					if($getMediaUrlData['isUrl'])
					{
						//url is valid 
						$headerDetails = @get_headers($getType[0]['filePath'],1);
						if(isset($headerDetails['X-Frame-Options']))
						{
							// This code will show error 
							$src = base_url().'en/player/videoError/';

						}else
						{
							// This code will play url 
							$src = $getType[0]['filePath'];

						}
						 
					}else
					{	
						$getSrc = $getMediaUrlData['getsource'];
						if($getMediaUrlData['embedtype'] == 'iframe')
						{
							 // This code will play embeded ifram code
							 $src = $getSrc;
						}else
						{
							// This code will play other type of embed code
							$src = base_url().'en/player/commonPlayerIframe/'.$mediaId.'_full/'.$elementEntityId.'/'.$elementId.'/'.$projectId;
						} 
					}  
					  
					  
				}else
				{
					$src = base_url().'en/player/getPlayerIframe/'.$vid->fileId.'_full/'.$entityId.'/'.$vid->workProfileId.'/'.$vid->workProfileId ;
					$getCodeType ="internalIframe";
				}   
				   
				?>        
				<li onclick="javascript:loadMe(this)" targetpath="<?php echo $src; ?>" getCodeType="<?php echo  $getCodeType; ?>"> 
					<img src="images/video01.jpg" /> 
					 <div class="description hidden">
						<p>
							<?php echo nl2br($vid->mediaDesc); ?>
						</p>
					</div>
					
					<div class="title hidden">
             	       <?php echo $vid->mediaTitle ?>
                   </div>					
					
				</li>
				<?php } } else
			{?>
					
				<li onclick="javascript:loadMe(this)" targetpath="<?php echo base_url()?>/player/videoError" getCodeType="<?php echo  $getCodeType; ?>">  
					
				</li>
					
			<?php } 
				?>
        
        
    </ul>
            </div></td>
        </tr>
      </table>
      <div class="seprator_5"></div>
    </div>
    <!--content_wrapper-->

<script language="javascript">

function mousedown_tds_button(obj){
obj.style.backgroundPosition ='0px -76px';
obj.firstChild.style.backgroundPosition ='right -76px';
}
function mouseup_tds_button(obj){
obj.style.backgroundPosition ='0px -38px';
obj.firstChild.style.backgroundPosition ='right -38px';
} 


	
	// TO HOLD THE PREVIOUS IMAGE INDEX
	var prevImageIndex = null;
	
	// TO HOLD CURRENT IMAGE INDEX
	var currentImageIndex = 0;
	
	// TO HOLD CURRENT IMAGE SOURCE
	var currentImageSrc = '';
	
	// TO HOLD IMAGE TITLE
	var currentImageTitle = '';
	
	// TO HOLD IMAGE DESCRIPTION
	var currentImageDescription = '';
	
	// TO HOLD TOTAL GALLERY IMAGES
	var totalImage = 0;
	
	// CREATE LIST ARRAY
	var optionTexts = [];
	
	// TO HOLD AUTOPLAY INSTRUCTIONS
	var autoPlay = false;
	
	// TO HOLD PAUSE DURATION INCASE OF AUTOPLAY (3 sec = 3000)
	var delay = 3000;
	
	var timer;
	
	// DIV DEFINITIONS.
	/*var imageListUL = '#imageList';
	var imageHolderDIV = '#imageHolder';
	var imageDiv = "#imageDiv"
	var imageDescriptionDiv = '#imageDescription';
	var imageActiveCSS = 'imgActiveBorder';
	var imageLoader = "#loaderDiv";*/
	
	var imageListUL = '';
	var imageHolderDIV = '';
	var imageDiv = '';
	var imageDescriptionDiv = '';
	var imageActiveCSS = '';
	var imageLoader = '';
	var imageTitleDiv = '';
	
	
	$.gallery={options:{_imageListUL:'#imageList',
						_imageHolderDIV:'#imageHolder',
						_imageDiv:"#imageDiv",
						_imageDescriptionDiv:'#imageDescription',
						_imageActiveCSS:'imgActiveBorder',
						_imageLoader:'#loaderDiv',
						_imageTitleDiv: '#titleDiv',
						_autoPlay:false,
						_delay:3000}};
	
	$(document).ready(function() {
		initialise();
	});	
	
	//alert( $("#imageList").children([0]).children([0]).attr('src'))
	
	
	//alert( $(optionTexts[0]).children([0]).attr('src') )
	//alert($(optionTexts).length);
	//alert($("#imageHolder img").attr('src', currentImageSrc))
	
	
	function initialise(){
		imageListUL = $.gallery.options._imageListUL;
		imageHolderDIV = $.gallery.options._imageHolderDIV;
		imageDiv = $.gallery.options._imageDiv;
		imageDescriptionDiv = $.gallery.options._imageDescriptionDiv;
		imageActiveCSS = $.gallery.options._imageActiveCSS;
		imageLoader = $.gallery.options._imageLoader;
		imageTitleDiv = $.gallery.options._imageTitleDiv;
		autoPlay = $.gallery.options._autoPlay;
		delay = $.gallery.options._delay;
		
		
		$(imageListUL+" li").each(function() {optionTexts.push($(this)) });
		
		totalImage = $(optionTexts).length;
		
		loadVideo();
	}
	
 	// LOAD IMAGE BASED ON IMAGE INDEX
	function loadVideo(){
		//alert( "perminder");
		
		currentImageSrc = $(optionTexts[currentImageIndex]).attr('targetpath');
		currentCodeType = $(optionTexts[currentImageIndex]).attr('getCodeType');
		currentHref = $(optionTexts[currentImageIndex]).attr('href');
		
		
		currentImageDescription = '';
		if(  $('.description', $(optionTexts[currentImageIndex]) ).html() != undefined ){
		 	currentImageDescription = $('.description', $(optionTexts[currentImageIndex]) ).html()
		}
		
		currentImageTitle = '';
		if( $('.title', $(optionTexts[currentImageIndex]) ).html() != undefined ){
			currentImageTitle = $('.title', $(optionTexts[currentImageIndex]) ).html();
			
		}
		
		//alert($('.title', $(optionTexts[currentImageIndex]) ).html())
		//alert(  $('.description', $(optionTexts[currentImageIndex]) ).html() ) 
		
		$(imageLoader).show();
		$(imageDiv+" iframe").attr('src', currentImageSrc);
		
		//show iframe height and with by player code
		if(currentCodeType=="internalIframe")
		{
			$(imageDiv+" iframe").attr('width', '700');
			$(imageDiv+" iframe").attr('height', '330');
		}else
		{
			if(currentCodeType=="externalCodeIframe")
			{
				$(imageDiv+" iframe").attr('width', '700');
				$(imageDiv+" iframe").attr('height', '330');
			}else
			{
				$(imageDiv+" iframe").attr('width', '700');
				$(imageDiv+" iframe").attr('height', '330');
			}
		}	
		
		$(imageDiv+" a").attr('href', currentHref);
		$(imageDiv).hide();
		
		$(imageDiv+" iframe")
			.load(function() {
				$('#messageDiv').hide();
				
				$(imageDiv).fadeIn("fast");
				$(imageLoader).hide()
			})
			.error(function(){
				$(imageDiv).hide();
				$('#messageDiv').show();
				//$('#messageDiv').text('Image is not loaded!');
			});
		
		
		$(imageDescriptionDiv).html(currentImageDescription);
		$(imageTitleDiv).html(currentImageTitle);
		// REMOVE CSS FROM PREVIOUS LIST ITEM
		if(prevImageIndex != null) $(optionTexts[prevImageIndex]).find(borderAreaDivClass).removeClass( imageActiveCSS );
		//$(optionTexts[prevImageIndex]).children([0]).removeClass( imageActiveCSS )
		
		// ADD CSS TO CURRENT LIST ITEM
		$(optionTexts[currentImageIndex]).find(borderAreaDivClass).addClass( imageActiveCSS )
		//$(optionTexts[currentImageIndex]).children([0]).addClass( imageActiveCSS )
		
		if(callBackMethod != null) callBackMethod(this);
		
		// UPDATING PREVIOUS IMAGE INDEX
		prevImageIndex = currentImageIndex;
		
		if(autoPlay == true){
			clearTimeout(timer);
			timer = setTimeout(function(){
			  nextImage();
			}, delay);
		}

	}




	// TRIGGER NEXT IMAGE
	function nextImage(){
		
		//alert(currentImageIndex);
		if(currentImageIndex < (totalImage-1)){
			
			$("#prevImageButton").removeClass();
			$("#prevImageButton").addClass('gall_pre_btn_profile Fleft');
			
			currentImageIndex ++;
			//currentImageIndex = 0;
			loadVideo();
			if(currentImageIndex==(totalImage-1))
			{
				$("#nextImageButton").removeClass();
				$("#nextImageButton").addClass('gall_next_btn_profile Fright disable');
				//$("#nextImageButton").removeClass();
			}	
		}
		
	}
	
	// TRIGGER PREVIOUS IMAGE
	function prevImage(){
		
		
		//alert(currentImageIndex);
		if(currentImageIndex > 0){
			currentImageIndex --;
			//currentImageIndex = (totalImage-1);
			loadVideo()
			$("#nextImageButton").removeClass();
			$("#nextImageButton").addClass('gall_next_btn_profile Fright');
			if(currentImageIndex==0)
			{
				$("#prevImageButton").removeClass();
				$("#prevImageButton").addClass('gall_pre_btn_profile Fleft disable');
			}
		}else
		{
			
			$("#prevImageButton").removeClass();
			$("#prevImageButton").addClass('gall_pre_btn_profile Fleft disable');
		}
		
		
	}
	
	// TRIGGER ON LIST ITEM
	function loadMe(listItem){
		loadVideo();
	}
	
	// TRIGGER FROM LARGE IMAGE.
	function bigImageEvent(){
		alert("me")
	}
	


</script>


