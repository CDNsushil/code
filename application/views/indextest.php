<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="login_page_with_header bg_darker">
    		
		<div class="container_index">


		<div class="anicont_top">
		<?php //Common Banner
			 $imgarray['imgarray']=array('topheader.jpg');
			echo $this->load->view('common/common_banner',$imgarray); //common view for image banner placed in main view folder
		?>	
			<div class="animation_top"> 
				<img class="cursor_p" onclick="openAnim();" alt="toplogo" src="<?php echo base_url('images/icont_top.png');?>"> 
			</div>       
		</div>

		<div class="scrollingdiv">
			<div class="position_absolute bottom_0 ml10">
					<img src="<?php echo base_url('images/404_frog.png');?>" alt="404frog">
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
				<div id="close" onclick="openAnim();" class="close_bg font_museoSlab clr_f1592a cursor_p">Close</div>
			</div><!-- inner -->
		</div><!-- scrollingdiv -->

		<div class="anicont_bottom">
			<div class="animation_bottom"> 
				<img class="cursor_p" onclick="openAnim();" src="<?php echo base_url('images/icont_bottompng.png');?>" alt="toplogo">
			</div>

			<div class="bottom_crop">
				<img alt="bottomcrop" src="<?php echo base_url('images/crop_bottom.png');?>">
			</div>

			<div class="Banner_box_indexnewB">
				<!--div class="innercontent">
					<div class="fl width_425 font_museoSlab font_size65 clr_f1592a lineH78 ml60 mt48 test_Nindex">What is Toadsquare?</div>
					<div class="fr width_356 font_museoSlab clr_white font_size18 mr18 lineH22 height_240">
					<div class="seprator_65"></div>
					<div class="cursor_p" onclick="openAnim();" id="read">
					It’s your one-stop shop for talent and entertainment. Your online showcase, job centre and marketplace.
					Like Montparnasse in early 20th-century Paris, Toadsquare is the heart of creativity in all its modes…</div>
					<div class="clear"></div>
					<div class="seprator_14"></div>

					<div class="index_read mr30">
					<span class="clr_f1592a cursor_p" id="read" onclick="openAnim();">Read &gt;</span></div>
					</div>

					<div class="clear"></div>
					<div class=" seprator_18"></div>
					<div class="growbg font_museoSlab font_size24">
					Watch us grow &nbsp; <span class=" font_size36 clr_f1592a">  1,000,000 </span> members
					</div>

					<div class="fl font_size22 clr_bab5b2 ml50 mt20 font_museoSlab">Toadsquare News</div>
				</div><!-- innercontent -->
				<div class="seprator_30"></div>
			</div><!-- Banner_box_indexnewB -->
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
				$('ul#landingpage_slider').cycle('pause');
			}else{
				isOpen = false;
				topDiv_TOP = 0;
				midDiv_TOP = 450;
				midDiv_HEIGHT = 0;
				botDiv_TOP = 461;
				manDiv_HEIGHT = 925;
				$('ul#landingpage_slider').cycle('resume');
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
				  },
				  onStop: function(){
					 if(isOpen == true) $('.Banner_box_indexnewB').animate({ 'opacity': 0 });
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
		//if($f().getState()==3 || $f().getState()==4){$f().resume();}
		
		</script>
