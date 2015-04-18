<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="login_page_with_header bg_darker">
		<div class="container_index">
		<div class="anicont_top">
			 <?php 
				$showcaseEntityId = '93';
				
				$topCravedData_creatives['defaultProfileImage'] = $this->config->item('defaultCreativeImg_m');
				$topCravedData_creatives['data'] = topCraved(array('entityId'=>$showcaseEntityId,'projectType'=>'creatives'));
				
				if(is_array($topCravedData_creatives['data']) && count($topCravedData_creatives['data'])>0)	
					$topCravedHtml_creatives['html'] = $this->load->view('common/top_craved_creative',$topCravedData_creatives,true);			
				else
					$topCravedHtml_creatives['html'] = '';
				
				$topCravedData_enterprises['defaultProfileImage'] = $this->config->item('defaultEnterpriseImg_m');
				$topCravedData_enterprises['data'] = topCraved(array('entityId'=>$showcaseEntityId,'projectType'=>'enterprises'));
				
				if(is_array($topCravedData_enterprises['data']) && count($topCravedData_enterprises['data'])>0)	
					$topCravedHtml_enterprises['html'] = $this->load->view('common/top_craved_enterprise',$topCravedData_enterprises,true);			
				else
					$topCravedHtml_enterprises['html'] = '';
				
				$topCravedData_asso_prof['defaultProfileImage'] = $this->config->item('defaultAssProfImg_m');
				$topCravedData_asso_prof['data'] = topCraved(array('entityId'=>$showcaseEntityId,'projectType'=>'associatedprofessionals'));
				
				if(is_array($topCravedData_asso_prof['data']) && count($topCravedData_asso_prof['data'])>0)	
					$topCravedData_asso_prof['html'] = $this->load->view('common/top_craved_associatedprofessional',$topCravedData_asso_prof,true);			
				else
					$topCravedData_asso_prof['html'] = '';
				
				//Common Banner				
				$imgarray['imgarray'] = array('topheader.jpg',$topCravedHtml_creatives,$topCravedHtml_enterprises,$topCravedData_asso_prof);
				echo $this->load->view('common/common_banner',$imgarray); //common view for image banner placed in main view folder
				
			?>	
			<div class="animation_top stopVideo"> 
				<img class="cursor_p" onclick="openAnim();" alt="toplogo" src="<?php echo base_url('images/icont_top.png');?>"> 
			</div>       
		</div>

		<div class="scrollingdiv">
			<div class="position_absolute bottom_0 ml10">
				<img src="<?php echo base_url('images/index_frog.png');?>" alt="Home Frog">
			</div>
			<div class="inner">
				<div class="seprator_74"></div>
				<div class="ml80 mr80 clr_444 font_size14 font_opensans">
				Production. Debate. Inspiration. Collaboration. PR. Advertising. Competition. Camaraderie.
				Transactions. Toadsquare is the hub of the creative industries, providing simple tools 
				and a receptive audience in order to let artistic professionals concentrate on the business of creation.
				</div>

				<div class="seprator_16"></div>
				<div class="ml80 mr80 clr_444 font_size14 font_opensans">
				Membership is free, so sign up and establish your distinctive creative presence in a global network that links professional talents in the worlds of Film &amp; Video, Music &amp; Audio, Performing Arts, Photography &amp; Art and Writing &amp; Publishing. All you do is click Join, enter your name and country, validate your email address &ndash; and, hey, you’re in!
				</div>

				<div class="seprator_16"></div>
				<div class="ml80 mr80 clr_444 font_size14 font_opensans">
				A Toadsquare member is never more than a few hops from finding a new job or recruiting a key talent. Managed by you &ndash; from your computer, tablet or smart phone, wherever you are in the world - you can launch your work to a global audience or orchestrate an event. You can meet inspiring fellow artists and broadcast your own expertise. As the heart of the modern world’s intellectual and artistic endeavours, Toadsquare enables you to tap the zeitgeist and discover the whole range of weird and wonderful specialist creative skills out there.
				</div>

				<div class="seprator_16"></div>
				<div class="ml80 mr80 clr_444 font_size14 font_opensans pl80">
				The artist Marc Chagall said of Montparnasse, “The sun of Art then shone only in Paris.” The glory of the global network is that the sun of Art can brighten every corner of the world. If the idea of managing your business online sounds daunting, rest assured. We have designed Toadsquare so that each step is simple, logical and cost-effective. Our Tips section works like a fairy godmother: mentoring you through the potential features of the site and helping make wonderful things happen. Enjoy! 
				</div>
				
				<div class="clear"></div>
				<div class="seprator_32"></div>
				<div id="close" onclick="openAnim();" class="close_bg font_museoSlab clr_f1592a cursor_p gray_clr_hover">Close</div>
			</div><!-- inner -->
		</div><!-- scrollingdiv -->

		<div class="anicont_bottom stopVideo">
			<div class="animation_bottom"> 
				<img class="cursor_p" onclick="openAnim();" src="<?php echo base_url('images/icont_bottompng.png');?>" alt="toplogo">
			</div>

			<div class="bottom_crop" id="bottom_crop">
				<img alt="bottomcrop" src="<?php echo base_url('images/crop_bottom.png');?>">
			</div>
			<div class="clear"></div>
			<div class="Banner_box_indexnewB" style="opacity: 1;">
				<!---Start right side banner div-->
            	<div class="transapremt_bottom pb4 fl width447 mt8 height312">
					<div class="fl width_412 font_museoSlab font_size65 clr_f1592a lineH78 ml20 test_Nindex mt8">What is Toadsquare?</div>
					<div class="clear"></div>
					<div class="seprator_8"></div>
					<div class="ml width_405 font_museoSlab clr_white font_size18 mr10 lineH26 ml20">
						<div class="cursor_p font_museoSlab clr_white font_size18" onclick="openAnim();" id="read">
							It’s your one-stop shop for talent and entertainment. Your online showcase, job centre and marketplace.
							Like Montparnasse in early 20th-century Paris, Toadsquare is the heart of creativity in all its modes…</div>
						<div class="clear"></div>
						<div class="seprator_14"></div> 
						<div class="index_read mt-34">
							<span id="read" class="clr_f1592a cursor_p fl white_link_hover font_museoSlab" onclick="openAnim();">Read </span>
							<span class="orangeaerow_index fr ml12 mt6 "></span>
						</div>
					</div>
					<div class="clear"></div>
                </div>
                <!---End right side banner div-->
                
                <!---Start left side banner div-->
                <a href="<?php echo base_url(lang().'/pressRelease/index')?>" target="_blank" id="feature_box">
					<div class="transapremt_bottom pb4 fl width_420 mt8 height312 mr0 ml0">
						<div class="font_museoSlab font_size48 clr_f1592a lineH52 test_Nindex mt8 text_alignC bdrb_a6a99f ml15 mr15">FEATURED ON</div>
						<div class="clear"></div>
						<div class="seprator_8"></div>
					
						<div class="row ml15 bdrb_a6a99f mr15 mt4 pb2">
							<div class="row">
								<img src="<?php echo base_url('images/home_images/financialtimes.jpg');?>" alt="finance" class="ml5"/>
								<div class="clear"></div>
							</div>
							<div class="mt16 row">
								<img src="<?php echo base_url('images/home_images/photography.jpg');?>" alt="photo" class="fl"/>
								<img src="<?php echo base_url('images/home_images/yahoofinance.jpg');?>" alt="yahoo" class="fl ml6"/>
								<div class="clear"></div>
							</div>
							<div>
								<img src="<?php echo base_url('images/home_images/cnnireport.jpg');?>" alt="cnnreport" class="fl mt20"/>
								<img src="<?php echo base_url('images/home_images/80news.png');?>" alt="80news" class="fl ml15"/>
								<div class="clear"></div>
							</div>
						</div>
						
						<div class="fl font_size32 clr_f1592a ml15 mt13 font_museoSlab text_shadow white_link_hover"> 
							<span class="fl">Toadsquare PR &amp; News</span> 
							<span class="orangeaerow_index fr  ml18"></span>
						</div>
						<div class="clear"></div>
					</div>
				</a>	
		
				<div class="clear"></div>
				<div class="seprator_20"></div>
                <!---End left side banner div-->
				<div class="growbg font_museoSlab font_size24" style="background:none;border:none">
					<!--Watch us grow <span class=" font_size36 clr_f1592a"><?php echo $registerdUser;?></span> members-->
				</div>
            
              <!-- <div class="fl font_size22 clr_white ml18 mt20"> 
				   <span class="fl font_museoSlab index_text_shadow">Toadsquare PR &amp; News</span> 
				   <span class="orangeaerow_index fr  ml12"></span>
				   <div class="clear"></div>
				   <div class="fr mr26 font_museoSlab clr_f15921 font_size18 mt10 index_text_shadow">Coming Soon</div>
               </div>-->
                
            <!--<a href="<?php //echo base_url(lang().'/pressRelease/index')?>">
				<div class="fl font_size22 clr_white ml18 mt20 "> 
				   <span class="fl font_museoSlab index_text_shadow dash_link_hover">Toadsquare PR &amp; News</span> 
				   <span class="orangeaerow_index fr  ml12"></span>
				   <div class="clear"></div>
               </div>
              </a>-->
               <div class="seprator_30"></div>
            </div>
            </div><!-- anicont_bottom -->
		</div>

    </div>

  <script>
		var isOpen = false;
		
		function openAnim(){ 
			
				if(!isOpen){
				isOpen = true;
				manDiv_HEIGHT = 925;
				topDiv_TOP = -270;
				midDiv_TOP = 191;
				midDiv_HEIGHT = 540;
				botDiv_TOP = 731;
				<?php
				 // This code add only for desktop os
				if(getOsName()=="desktop")
				{ ?>	
				$f().pause();
				<?php } ?>
				$('ul#landingpage_slider').cycle('pause');							
			}else{
				isOpen = false;
				topDiv_TOP = 0;
				midDiv_TOP = 450;
				midDiv_HEIGHT = 0;
				botDiv_TOP = 461;
				manDiv_HEIGHT = 925;
				
				$('ul#landingpage_slider').cycle('resume');	
				<?php
				 // This code add only for desktop os
				if(getOsName()=="desktop")
				{ ?>
				$f().pause();	
				<?php } ?>					
			}
			
			$('.container_index').tween({
			   height:{
				  start: $('.container_index').attr('height'),
				  stop: manDiv_HEIGHT,
				  time: 0,
				  units: 'px',
				  duration: 1,
				  effect:'easeInOut'
			   }
			});
			
			$('.anicont_top').tween({
			   top:{
				  start: $('.anicont_top').attr('top'),
				  stop: topDiv_TOP,
				  time: 0,
				  units: 'px',
				  duration: 1,
				  effect:'easeInOut'
			   }
			});
			
			$('.anicont_bottom').tween({
			   top:{
				  start: $('.scrollingdiv').attr('top'),
				  stop: botDiv_TOP,
				  time: 0,
				  units: 'px',
				  duration: 1,
				  effect:'easeInOut',
				  onStart:function(){
					  $('.Banner_box_indexnewB').animate({ 'opacity': 1});
					  $('#bottom_crop').attr({ 'class': 'bottom_crop z_index_low'});
				  },
				  onStop: function(){
					 if(isOpen == true){
						 $('.Banner_box_indexnewB').animate({ 'opacity': 0 });
						  $('#bottom_crop').attr({ 'class': 'bottom_crop z_index_heigh'});
					 }
					 
				  }
			   }
			});
			
			$('.scrollingdiv ').tween({
				top:{
				  start: $('.anicont_bottom').attr('top'),
				  stop: midDiv_TOP,
				  time: 0,
				  units: 'px',
				  duration: 1,
				  effect:'easeInOut'
			   },
			   height:{
				  start: $('.scrollingdiv').attr('height'),
				  stop: midDiv_HEIGHT,
				  time: 0,
				  units: 'px',
				  duration: 1,
				  effect:'easeInOut'
			   }
			});
			 
			$.play();
		}
		
		/*$('#video').bind('play', function() {		
			$('ul#landingpage_slider').cycle('pause');
		});*/
		
			
			<?php
				 // This code add only for desktop os
				if(getOsName()=="desktop")
				{ ?>
				
					$(function() {						
											
						$f("video", "<?php echo base_url();?>player/flowplayer/flowplayer.commercial-3.2.16.swf", {					
							key: "#$943a9847a4c436aa438",							
							plugins: {								
							},
							onBeforeResume: function() {
								
								$('ul#landingpage_slider').cycle('pause');
								//$("ul#landingpage_slider").cycle({ pause: false });
								},
								
							playlist: [									
								 {
										 url: "<?php echo base_url();?>images/home_img.png",
										 scaling: "orig"
								 },
									
								 {	 // these two settings will make the first frame visible
										autoPlay: false,
										autoBuffering: true,
										url: '<?PHP echo base_url();?>images/videos/home_new_video.mp4'
										//url:"http://pseudo01.hddn.com/vod/demo.flowplayervod/flowplayer-700.flv" // /media/										
								 }
							],
					});
					var state = $f().getState();				
					if(state==3) $('ul#landingpage_slider').cycle('pause');
					else  $('ul#landingpage_slider').cycle('resume');
					});
					
					
					$(function() {						
											
						$f("launchVideo", "<?php echo base_url();?>player/flowplayer/flowplayer.commercial-3.2.16.swf", {					
							key: "#$943a9847a4c436aa438",							
							plugins: {								
							},
							onBeforeResume: function() {
								
								$('ul#landingpage_slider').cycle('pause');
								//$("ul#landingpage_slider").cycle({ pause: false });
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
					var state = $f().getState();				
					if(state==3) $('ul#landingpage_slider').cycle('pause');
					else  $('ul#landingpage_slider').cycle('resume');
					});
					
				<?php } ?>	
					
		
		</script>
