<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
echo '<script type="text/javascript" src="'. base_url('player/flowplayer/flowplayer-3.2.12.js').'"></script>';	
$currentShortUrl = uri_string();
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
    <div class="width100_per clearb position_relative">
        <a href="<?php echo base_url('news/launch_list');?>" class="fl close_btn closebig position_absolute"></a>
        <div class="width742 m_auto clearb">
            <div class="sap_45"></div>
            <h3 class="fs24 opens_light bb3_F1592A pt3 pb12 mb20">This 17th-18th May the famous art scene of Paris is coming to Prague.</h3>
            <div class="date">17 May 2013</div>
            <div class="sap_50"></div>

            <!--Start left contener  --> 
            <div class="width477 pr36 fl left_wrap fs13 lineHp18 ">
                
                <?php if(getOsName()=="mobile")
						{ 
							echo '<script>
									_V_.options.flash.swf = "'.base_url().'player/html5_video_player/video-js.swf";
								  </script> 
											  <div class="launchPagevideobg fl">
											  <video id="launch_video" class="video-js vjs-default-skin html5_launch_video launch_page_video" controls preload="none" 
													poster="'.base_url().'images/logo-tod-square.png"	data-setup="{}" >
												<source src="'.base_url().'images/videos/o_Toadsquare_event_1080p.mp4" type="video/mp4">
												<p>Video Playback Not Supported</p>
											  </video> 
											  </div>';
							
						}else {	?>	
						<div id="launchVideo" class="launchPagevideobg" ></div>
                        <div class="clear"></div><div class="seprator_45"></div>
					<?php } ?>
                
               <p>This 17th-18th May the famous art scene of Paris is coming to Prague. Montparnasse, the Parisian area that became
home to world-class artists such as Picasso, Salvador Dalí, Ernest Hemingway and F Scott Fitzgerald, will be recreated
at Kampa Museum of modern art, in the heart of Prague.</p>

                <div class="sap_50 bb_ccc"></div>

                <div class="box_wrap p0 pt20 bdr_non shadownone bg-non press_social">
                    
                    <?php 
                        echo ' <span class="fl">';
                            
                            //-----short module link by email module array-----//
                            $shortlinkEmailData=array('url'=>$currentShortUrl,'isPublished'=>'t','designType'=>'1');
                            echo Modules::run("share/shareemailbutton",$shortlinkEmailData);								
                        
                            //-----load module shortlink module array-----//
                            $shortlinkData=array('url'=>$currentShortUrl,'isPublished'=>'t','designType'=>'1');
                            echo Modules::run("shortlink/shortlinkfrontbuttonnew",$shortlinkData);								
                   
                        echo '</span>';
                            //-------load module of social share---------------//
                            $shareData=array('url'=>$currentShortUrl,'isPublished'=>'t','designType'=>'1');
                            echo Modules::run("share/sharesocialshowview",$shareData);
                    ?>
                    
                </div>
               
            </div>

            <!--End left contener  --> 
            <!--Start right contener  --> 
            <div class="width186 pl41  fl rightbox blcccccc">
                <div class="clr808285 lineHp19 mt5">
                    <b class="red ">Contact for media </b>
                    <div class="sap_20"></div>
                    <p>Gabriela Dvoráková</p>
                    <p>Best Communications</p>
                    <div class="sap_15"></div>
                    <p class="red">Phone Number</p>
                    <p>+420 601 357 066</p>
                    <div class="sap_20"></div>
                    <p class="red"> Email</p>
                    <p><a href="#" class="clr808285">gabriela.dvorakova@bestcg.com</a></p>
                </div>
            </div>
            <!--Start right contener  --> 

            <div class="sap_20"></div>
            <div class="btn_wrap fr">
                <a href="<?php echo base_url('news/launch_list');?>"><button class=" height40" type="button" > Close</button></a>
                <div class="sap_30"></div>
            </div>
        </div>
    </div>
</div>
<script>
    
<?php
				 // This code add only for desktop os
				if(getOsName()=="desktop")
				{ ?>
				
					$(function() {						
											
						$f("launchVideo", "<?php echo base_url();?>player/flowplayer/flowplayer.commercial-3.2.16.swf", {					
							key: "#$943a9847a4c436aa438",							
							plugins: {								
							},
								
							playlist: [									
								 {
										 url: "<?php echo base_url();?>images/launch_img.png",
										 scaling: "orig"
								 },
									
								 {	 // these two settings will make the first frame visible
										autoPlay: false,
										autoBuffering: true,
										url: '<?PHP echo base_url();?>images/videos/o_Toadsquare_event_1080p.mp4'
										//url:"http://pseudo01.hddn.com/vod/demo.flowplayervod/flowplayer-700.flv" // /media/										
								 }
							],
					});
					
					});
					
				<?php } ?>	
</script>


<!--<div class="seprator120"></div>-->

<!--End cmslist of title -->
