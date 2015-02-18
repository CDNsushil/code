<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?php echo base_url('templates/system/javascript/jquery.royalslider.min.js');?>"></script>
 <input id="fullScreenCurrentImage" type="hidden" value="0">
<?php


$fullscreenArray['fullscreenArray'] =  array(

  array('xs'=>base_url('images/launch_images/art_artists/DSC_6020_thumb.jpg' ),'l'=>base_url('images/launch_images/art_artists/fullscreen/DSC_6020.jpg' )),
  array('xs'=>base_url('images/launch_images/art_artists/DSC_6054_thumb.jpg' ),'l'=>base_url('images/launch_images/art_artists/fullscreen/DSC_6054.jpg' )),
  array('xs'=>base_url('images/launch_images/art_artists/DSC_6086_thumb.jpg' ),'l'=>base_url('images/launch_images/art_artists/fullscreen/DSC_6086.jpg' )),
  array('xs'=>base_url('images/launch_images/art_artists/DSC_6111_thumb.jpg' ),'l'=>base_url('images/launch_images/art_artists/fullscreen/DSC_6111.jpg' )),
  array('xs'=>base_url('images/launch_images/art_artists/DSC_6109_thumb.jpg' ),'l'=>base_url('images/launch_images/art_artists/fullscreen/DSC_6109.jpg' )),
  array('xs'=>base_url('images/launch_images/art_artists/DSC_6116_thumb.jpg' ),'l'=>base_url('images/launch_images/art_artists/fullscreen/DSC_6116.jpg' )),
  array('xs'=>base_url('images/launch_images/art_artists/DSC_6127_thumb.jpg' ),'l'=>base_url('images/launch_images/art_artists/fullscreen/DSC_6127.jpg' )),
  array('xs'=>base_url('images/launch_images/art_artists/DSC_6200_thumb.jpg' ),'l'=>base_url('images/launch_images/art_artists/fullscreen/DSC_6200.jpg' )),
  array('xs'=>base_url('images/launch_images/art_artists/DSC_6202_thumb.jpg' ),'l'=>base_url('images/launch_images/art_artists/fullscreen/DSC_6202.jpg' )),
  array('xs'=>base_url('images/launch_images/art_artists/DSC_6203_thumb.jpg' ),'l'=>base_url('images/launch_images/art_artists/fullscreen/DSC_6203.jpg' ))

);


$fullscreenArray['fullscreenArray1'] =  array(

  
  array('xs'=>base_url('images/launch_images/general/DSC_6001_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/DSC_6001.jpg' )),
  array('xs'=>base_url('images/launch_images/general/DSC_6064_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/DSC_6064.jpg' )),
  array('xs'=>base_url('images/launch_images/general/DSC_6080_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/DSC_6080.jpg' )),
  array('xs'=>base_url('images/launch_images/general/DSC_6217_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/DSC_6217.jpg' )),
  array('xs'=>base_url('images/launch_images/general/DSC_6534_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/DSC_6534.jpg' )),
  array('xs'=>base_url('images/launch_images/general/DSC_6589_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/DSC_6589.jpg' )),
  array('xs'=>base_url('images/launch_images/general/DSC_6654_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/DSC_6654.jpg' )),
  array('xs'=>base_url('images/launch_images/general/DSC_6690_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/DSC_6690.jpg' )),
  array('xs'=>base_url('images/launch_images/general/DSC_6706_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/DSC_6706.jpg' )),
  array('xs'=>base_url('images/launch_images/general/DSC_6741_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/DSC_6741.jpg' )),
  array('xs'=>base_url('images/launch_images/general/IMG_2834_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/IMG_2834.jpg' )),
  array('xs'=>base_url('images/launch_images/general/IMG_3150_thumb.jpg' ),'l'=>base_url('images/launch_images/general/fullscreen/IMG_3150.jpg' ))
  

);

$fullscreenArray['fullscreenArray2'] =  array(

  array('xs'=>base_url('images/launch_images/performing_artists/DSC_5982_thumb.jpg' ),'l'=>base_url('images/launch_images/performing_artists/fullscreen/DSC_5982.jpg' )),
  array('xs'=>base_url('images/launch_images/performing_artists/DSC_6180_thumb.jpg' ),'l'=>base_url('images/launch_images/performing_artists/fullscreen/DSC_6180.jpg' )),
  array('xs'=>base_url('images/launch_images/performing_artists/DSC_6195_thumb.jpg' ),'l'=>base_url('images/launch_images/performing_artists/fullscreen/DSC_6195.jpg' )),
  array('xs'=>base_url('images/launch_images/performing_artists/DSC_6458_thumb.jpg' ),'l'=>base_url('images/launch_images/performing_artists/fullscreen/DSC_6458.jpg' )),
  array('xs'=>base_url('images/launch_images/performing_artists/DSC_6495_thumb.jpg' ),'l'=>base_url('images/launch_images/performing_artists/fullscreen/DSC_6495.jpg' )),
  array('xs'=>base_url('images/launch_images/performing_artists/DSC_6500_thumb.jpg' ),'l'=>base_url('images/launch_images/performing_artists/fullscreen/DSC_6500.jpg' )),
  array('xs'=>base_url('images/launch_images/performing_artists/DSC_6516_thumb.jpg' ),'l'=>base_url('images/launch_images/performing_artists/fullscreen/DSC_6516.jpg' )),
  array('xs'=>base_url('images/launch_images/performing_artists/DSC_6662_thumb.jpg' ),'l'=>base_url('images/launch_images/performing_artists/fullscreen/DSC_6662.jpg' )),
  array('xs'=>base_url('images/launch_images/performing_artists/DSC_6733_thumb.jpg' ),'l'=>base_url('images/launch_images/performing_artists/fullscreen/DSC_6733.jpg' )),
  array('xs'=>base_url('images/launch_images/performing_artists/IMG_2815_thumb.jpg' ),'l'=>base_url('images/launch_images/performing_artists/fullscreen/DSC_2815.jpg' ))


);
$this->load->view('fullscreenView',$fullscreenArray);
?>
<div class="row content_wrap" >
   <div class=" pl45 pr25 bg_f1f1f1 fl title_head ">
      <h1 class="pt10 mb0  fl">News &amp; Public Relations</h1>
   </div>
    <div class="clearbox bgfcfcfc pt17 pb15">
        <ul class="dis_nav fr pr23 news_list clearb fs16 mt27 open_sans ">
         <li><a href="<?php echo base_url(lang().'/pressRelease/index');?>">Press Releases</a>  </li>
         <li><a href="<?php echo base_url(lang().'/news/index');?>">In The News </a></li>
         <li class="active"><a href="javascript:void(0);">Toadsquare Launch </a></li>
         <li><a href="<?php echo base_url(lang().'/news/information_list');?>">Toadsquare Information</a></li>
      </ul>
    </div>
   
     <div class="clearb width740 pt45 m_auto">             
      <div class="content mb15">
         <h2 class="fs24 opens_light c8b9c00 bbc8c8c9 pb7 lineH26 mb18">May 2013</h2>
         <ul class="news_contentlist">
            <li>
                <span class="fs13 font_bold width_112  fl">17 May 2013</span>
                <span class="red fr width570">
                    <a href="<?php echo base_url(lang().'/news/launchdetails');?>">
                        This 17th-18th May the famous art scene of Paris is coming to Prague.
                    </a>
                </span>
            </li>
         </ul>
         <div class="sap_25"></div>
         <h2 class="opens_light fs24 mb10">Art and Artists at the Launch</h2>
         <div class="bg4d4c52 display_inline_block width100_per pt30 pb42">
            <div id="artistslider" class="launchslider fl pb8 pl25">
            <div class="sap_45"></div>
               <a class="buttons prev" href="#">left</a>
               <div class="viewport ">
                  <ul class="overview first_overview lauch_slide" >
                     <li><img src="<?php echo base_url('images/launch_images/art_artists/DSC_6020_thumb.jpg' )?>" /></li>
                            <li><img src="<?php echo base_url('images/launch_images/art_artists/DSC_6054_thumb.jpg')?>" /></li>
                            <li><img src="<?php echo base_url('images/launch_images/art_artists/DSC_6086_thumb.jpg')?>" class="launchactive_img"/></li>
                            <li><img src="<?php echo base_url('images/launch_images/art_artists/DSC_6111_thumb.jpg')?>" /></li>
                            <li><img src="<?php echo base_url('images/launch_images/art_artists/DSC_6109_thumb.jpg')?>" /></li>
                            <li><img src="<?php echo base_url('images/launch_images/art_artists/DSC_6116_thumb.jpg')?>" /></li>
                            <li><img src="<?php echo base_url('images/launch_images/art_artists/DSC_6127_thumb.jpg')?>" /></li>
                            <li><img src="<?php echo base_url('images/launch_images/art_artists/DSC_6200_thumb.jpg')?>" /></li>
                            <li><img src="<?php echo base_url('images/launch_images/art_artists/DSC_6202_thumb.jpg')?>" /></li>
                            <li><img src="<?php echo base_url('images/launch_images/art_artists/DSC_6203_thumb.jpg')?>" /></li>
                  </ul>
               </div>
               <a class="buttons next" href="#">right</a>
            </div>
            <div class="selct_img fr pr40 ptr" slideId="s1"  id="fullScreenButton">
                <img width="236" src="<?php echo base_url('images/launch_images/art_artists/DSC_6086_large.jpg')?>" id="largeImage1" />
            </div>
         </div>
      
      
      
        <div class="sap_25"></div>
         <h2 class="opens_light fs24 mb10">General</h2>
         <div class="bg4d4c52 display_inline_block width100_per pt30 pb42">
            <div id="genSlider" class="launchslider fl pb8 pl25">
            <div class="sap_45"></div>
               <a class="buttons prev" href="#">left</a>
               <div class="viewport ">
                  <ul class="overview second_overview lauch_slide" >
                        <li><img src="<?php echo base_url('images/launch_images/art_artists/DSC_6020_thumb.jpg' )?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/DSC_6001_thumb.jpg' )?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/DSC_6064_thumb.jpg')?>" class="launchactive_img" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/DSC_6080_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/DSC_6217_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/DSC_6534_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/DSC_6589_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/DSC_6654_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/DSC_6690_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/DSC_6706_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/DSC_6741_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/IMG_2815_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/IMG_2834_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/general/IMG_3150_thumb.jpg')?>" /></li>
                                    	
                  </ul>
               </div>
               <a class="buttons next" href="#">right</a>
            </div>
            <div class="selct_img fr pr40 ptr" slideId="s2"  id="fullScreenButton2">                            	
                <img width="236" src="<?php echo base_url('images/launch_images/general/DSC_6064_large.jpg')?>" id="largeImage2"/>
            </div>
         </div>
      
      
        <div class="sap_25"></div>
         <h2 class="opens_light fs24 mb10">Performing Artists</h2>
         <div class="bg4d4c52 display_inline_block width100_per pt30 pb42">
            <div id="launchSlider" class="launchslider fl pb8 pl25">
            <div class="sap_45"></div>
               <a class="buttons prev" href="#">left</a>
               <div class="viewport ">
                  <ul class="overview third_overview lauch_slide" >
                        <li><img src="<?php echo base_url('images/launch_images/performing_artists/DSC_5982_thumb.jpg' )?>" class="launchactive_img" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/performing_artists/DSC_6180_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/performing_artists/DSC_6195_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/performing_artists/DSC_6458_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/performing_artists/DSC_6495_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/performing_artists/DSC_6500_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/performing_artists/DSC_6516_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/performing_artists/DSC_6662_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/performing_artists/DSC_6733_thumb.jpg')?>" /></li>
                        <li><img src="<?php echo base_url('images/launch_images/performing_artists/IMG_2815_thumb.jpg')?>" /></li>
                                    	
                  </ul>
               </div>
               <a class="buttons next" href="#">right</a>
            </div>
            <div class="selct_img fr pr40 ptr" slideId="s3"  id="fullScreenButton3">
                <img width="236"  src="<?php echo base_url('images/launch_images/performing_artists/DSC_5982_large.jpg')?>" id="largeImage3"/>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
      	var ua = navigator.userAgent.toLowerCase();      
		var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
		var isOpera = $.browser.opera;
		
		$("#fullScreenButton,#fullScreenButton2,#fullScreenButton3").click(function(){ 
            var slideId = $(this).attr('slideId');
            
            var slider = $("#r"+slideId).data('royalSlider');
            if(isAndroid || isOpera) {
                $('#'+slideId).removeClass('dn');
            }	
            
            slider.enterFullscreen(); 
            slider.exitFullscreen(); 
          
            slider.ev.on('rsEnterFullscreen', function() {
                $('#'+slideId).removeClass('dn');			
                                
            });
            
            slider.ev.on('rsExitFullscreen', function() {
                $('#'+slideId).addClass('dn');
            });
     });
</script>
<script type="text/javascript">
/*tab function*/
	$(document).ready(function(){
			$('#artistslider').tinycarousel();
			$('#genSlider').tinycarousel();
			$('#launchSlider').tinycarousel();
			
		});
</script>
<script>
$('.first_overview li img').on('click', function(){
	//siblings().removeClass('launchactive_img');
	$('.first_overview .launchactive_img').removeClass();
    $(this).addClass('launchactive_img');
	$('#largeImage1').attr('src',$(this).attr('src').replace('thumb','large'));
});
</script>

<script>
$('.second_overview li img').on('click', function(){
	$('.second_overview .launchactive_img').removeClass();
    $(this).addClass('launchactive_img');
	$('#largeImage2').attr('src',$(this).attr('src').replace('thumb','large'));
});
</script>

<script>
$('.third_overview li img').on('click', function(){
	$('.third_overview .launchactive_img').removeClass();
    $(this).addClass('launchactive_img');
	$('#largeImage3').attr('src',$(this).attr('src').replace('thumb','large'));
});
				
</script>
    
    
    
 
