	//  help & forum js	
		
		    $('#tab_btn1').click(function () {
				$('#sub_cat1').slideToggle();
				$(this).toggleClass('active');
			});
			
			 $('#tab_btn').click(function () {
				$(this).toggleClass('active');
				$('#sub_cat').slideToggle();
				
			
			});
			
			 
			
			 $('.tab_ul').click(function () {
				$(this).next('.sup_form').slideToggle();
				$(this).toggleClass('active');
			});
			
			//	 $('#tab_btn1.active').click(function () {
//				$(this).toggleClass('active');
//				$('#sub_cat').slideDown();
//			
//			});
//			 $('#tab_btn.active').click(function () {
//				$(this).removeClass('active');
//				$('#sub_cat1').slideDown();
//			
//			});
			
			

		$('.membership_info table tr td:first-child').hover(function () {
				var popheight = $(this).children(".member_popup").height()/2;
		$('.pop_arrow').css('top',popheight-20);
		$('.member_popup').css('margin-top',-popheight-25);
		});
		
		
		/*=============================== profile socail icon==================================    */
		
		
		$(document).ready(function(e) {
		 $(".main_w").mouseover(function(){
         	var social_width = $("#scroller").width();
			var count = $( ".soical_creave ul li" ).length;
			if(count>3){
         	$(".simply-scroll").css('width',social_width);
            $(".creave_title").css('opacity',0);
            $(".creave_title").css('transition','linear .3s');
			}
         });
          $(".main_w").mouseout(function(){
         	 $(".simply-scroll").css('width',125);
         	 $("#scroller").css('left','0');
         	 $(".creave_title").css('opacity',1);
         	 $(".creave_title").css('transition','linear .5s');
         }); });
         
		
		// banner background button
		
			$('.color_bg .ez-hide').click(function () {
			$('.banner_collection').toggleClass("bg_444");
			$('p.p1').toggleClass("display_block");
			$('.banner_collection h2').toggleClass("clr_fff");
			});

		// Header footer html common
		
			$(function(){
			$("#header").load("header.html");
			$("#footer").load("footer.html");
			});
			
			
			// Header footer html common
			
			$('.thum_banner .open').click(function () {
			$(this).addClass("display_none");
			$('.thum_banner .close').removeClass("display_none");
			$(".toggle_slider").css('height','97px');
			}); 
			
			$('.thum_banner .close').click(function () {
			$(this).addClass("display_none");
			$('.thum_banner .open').removeClass("display_none");
			$(".toggle_slider").css('height','0px');
			});
			
 		$('.r_arrow').click(function () {
			$(this).toggleClass("arrow_up");
			});
			
			function slideMenu(slider){
			$(slider).slideToggle();
			}
			
			// html common
			
			$('.up_wrap').mouseover(function () {
			$(".up_list").css('opacity','1');
			$(".up_list").css('height','162px');
			$(".up_list").css('display','block');
			});  
			$('.up_wrap').mouseout(function () {
			$(".up_list").css('opacity','0');
			$(".up_list").css('height','0x');
			$(".up_list").css('display','none');
			});  
			
			// popup select jquery
			
		
			
			$('.wrap_list').click(function (){
			if($(".mCSB_container li").has("active")){
			$(".wrap_list").removeClass("active");
			}
			$(this).addClass("active");
			});
			
			// edit_album common
			
			$('.edit_album li .rate_wrap').click(function (){
			$(this).parent().parent().addClass("active_img");
			});
			$('.edit_album li label').click(function (){			
			$(".b_F1592A").removeClass("display_none");
			});
			
			
			
			
			$('.edit_album .rate_wrap label').click(function (){
			if($(".edit_album li").has("active_img")){
			$(".edit_album li").removeClass("active_img");
			}
			});
			
			$('.next_edit').click(function () {
			if($(".ez-radio").hasClass("ez-selected")){
			$(".replace").removeClass("display_none");
			$(".edit_wrap").addClass("display_none");
			}
			
			});
			
			
			$('.back_edit').click(function () {
			
			$(".replace").addClass("display_none");
			$(".edit_wrap").removeClass("display_none");
			
			
			});
			
			$('.paypal_btn').click(function () {
			$(".verify_btn").removeClass("display_none");
			});
			
			
			/*=========================== sateg one heading changes ================================*/
			
			$('.next_click').click(function () {
			if($(".main_tab").hasClass("p_one")){
			$(".second_tab1_art").addClass("display_none");
			$(".second_tab_art").addClass("display_none");
			$(".second_tab").addClass("display_none");
			$(".second_tab1").removeClass("display_none");
			}
			
			});
			
			
			$('.next_click').click(function () {
			if($(".main_tab").hasClass("p_one")){
			$(".second_tab1_art").addClass("display_none");
			$(".second_tab_art").addClass("display_none");
			$(".second_tab").addClass("display_none");
			$(".second_tab1_art").removeClass("display_none");
			}
			
			
			});
			
			
			
			
			$('.option_album .photgaphy').click(function () {
			$(".option_btn .next_click").addClass("photo_one");
			$(".option_btn .next_click").removeClass("art_one");
			$(".main_tab ").addClass("p_one");
			$(".main_tab ").removeClass("a_one");
			
			
			
			});	
			
			
			$('.option_album .art_title').click(function () {
			$(".option_btn .next_click").removeClass("photo_one");
			$(".option_btn .next_click").addClass("art_one");
			$(".main_tab ").addClass("a_one");
			$(".main_tab ").removeClass("p_one");
			});	
			
			$('#TabbedPanels2 .option_btn .next_click').click(function () {
			
			if($(".next_click").hasClass("art_one")){
			$(".both_head").addClass("display_none");
			$(".photo_head").addClass("display_none"); 
			$(".art_head").removeClass("display_none");   
			}
			else{
			$(".both_head").addClass("display_none");
			$(".art_head").addClass("display_none"); 
			$(".photo_head").removeClass("display_none"); 
			}
			});
			
			$('.back_last_1').click(function () {
			$(".photo_head").addClass("display_none"); 
			$(".art_head").addClass("display_none"); 
			$(".both_head").removeClass("display_none");  
			
			});	
			
			
			
			
			
			
			
			
			/*=========================== selct image ================================*/
			
			
			$('.selct_img img').click(function () {
			$(".butn_unselect").addClass("display_none");
			$(".butn_select").removeClass("display_none"); 
			
			});
			
			
		
	     
	    
  
$(".check_img").on("click", function() {
	$(".thum_text.active").removeClass("active");
    $(this).parents(".thum_text").addClass("active");

});
   
    
			/*===========================  button of select fouction ================================*/
			
			
			$('.selct_img .butn_select').click(function () {
			$(".selct_img").addClass("display_none"); 
			$(".creative_wrap .c_1").removeClass("display_none"); 
			
			});	
			
			
			$('.option_album .photgaphy').click(function () {
			
			$(".price_have").removeClass("display_none");
			$(".process_not").addClass("display_none");
			$(".second_tab").removeClass("display_none");
			$(".second_tab_art").addClass("display_none");
			
			
			});
			$('.option_album .art_title').click(function () {
			$(".price_have").removeClass("display_none");
			$(".process_not").addClass("display_none");
			$(".second_tab_art").removeClass("display_none");
			$(".second_tab").addClass("display_none");
			
			
			});
			
			
			
			
			
			/*=========================== value scroll fouction================================*/
			
			
	//		$(function() {
//			var spinner = $( "#spinner" ).spinner();
//			
//			$( "#getvalue" ).click(function() {
//			alert( spinner.spinner( "value" ) );
//			});
//			$( "#setvalue" ).click(function() {
//			spinner.spinner( "value", 100 );
//			});
//			$( "button" ).button();
//			});
//			
			
			$('.add_media').click(function () {
			$(".extra_space").css("display","table");
			});

			
			$('.no_media').click(function () { 
			$(".extra_space").css("display","none");
			});
						
			$('.last_click').click(function () {
			$(".main_tab").css("background","none");
			
			});	

			
			$('.tab_setting .overview li').click(function () {
			$(".overview li").addClass("active");
			});
			
			$('.price_yes').click(function () {
			$(".tab_2").removeClass("display_none");
			$("#man_haedtab").removeClass("without_sale");
			$(".main_tab").removeClass("sale_no");
			$(".main_tab").addClass("sale_yes");
			
			
			
			
			
			
			});	
			
			$('.price_no').click(function () {
			$(".tab_2").addClass("display_none");
			$("#man_haedtab").addClass("without_sale");
			$(".main_tab").addClass("sale_no");
			$(".main_tab").removeClass("sale_yes");
			
			
			});	
			
			/*=========================== sateg one heading changes ================================*/
			
			$('.link_btn').click(function () {
			$(".serch_1").removeClass("display_block");
			$(".link_1").removeClass("display_none");
			
			});	
			
			
			$('.serch_btn').click(function () {
			$(".serch_1").addClass("display_block");
			$(".link_1").addClass("display_none");
			
			
			});	
			
			$('.link_btn1').click(function () {
			$(".serch_2").removeClass("display_block");
			$(".link_2").removeClass("display_none");
			
			});	
			
			
			$('.serch_btn1').click(function () {
			$(".serch_2").addClass("display_block");
			$(".link_2").addClass("display_none");
			
			
			});	
			
			
			$('.Eu_btn').click(function () {
			$(".US_dolar").addClass("display_none");
			$(".Euros").removeClass("display_none");
			
			});	
			
			
			$('.Us_btn').click(function () {
			$(".Euros").addClass("display_none");
			$(".US_dolar").removeClass("display_none");
			
			
			});	
			
			$('.US_dolar').click(function () {
			$(".main_price").addClass("display_none");
			$(".us_wrap").removeClass("display_none");
			$(".Euros_wrap").addClass("display_none");
			
			});	
			
			
			$('.Euros').click(function () {
			$(".main_price").addClass("display_none");
			$(".us_wrap").addClass("display_none");
			$(".Euros_wrap").removeClass("display_none");
			
			
			});	
			
			
			
			$('.tax_no').click(function () {
			$(".taxb_yes").addClass("display_none");
			$(".taxb_not").removeClass("display_none");
			});	
			
			$('.tax_yes').click(function () {
			$(".taxb_not").addClass("display_none");
			$(".taxb_yes").removeClass("display_none");
			});	
			
			
			$('.taxb_not').click(function () {
			$(".tax_one").addClass("display_none");
			$(".taxt_first").addClass("display_none");
			});	
			
			$('.taxb_yes').click(function () {
			$(".tax_two").addClass("display_none");
			$(".tax_one").removeClass("display_none");
			$(".taxt_first").addClass("display_none");
			});	
			
			
			
			$('.taxtc_not').click(function () {
			$(".taxbt_yes").addClass("display_none");
			$(".taxbt_not").removeClass("display_none");
			});	
			
			$('.taxtc_yes').click(function () {
			$(".taxbt_yes").removeClass("display_none");
			$(".taxbt_not").addClass("display_none");
			});	
			
			
			
			
			
			
			
			
			// ==================dolor or euros ==================
			
			
			$('.serch_btn2').click(function () {
			$(".link_3").removeClass("display_block");
			$(".serch_3").removeClass("display_none");
			
			});	
			
			
			$('.link_btn2').click(function () {
			$(".link_3").addClass("display_block");
			$(".serch_3").addClass("display_none");
			
			
			});	
			
			$('.serch_btn2').click(function () {
			$(".taxt_first").removeClass("display_block");
			$(".tax_one").addClass("display_none");
			$(".tax_two").addClass("display_none");
			
			});	
			
			
			
			
			
			// ===========================JavaScript select menu ============================
			
			
			
			
			
			// ===========================JavaScript tab first ============================
			
			
			$('.back_remove').click(function () { 
			$(".wizard_wrap").addClass("frist_1"); });
			
			$('.publish_yes').click(function () {
			$(".pub_1").addClass("display_none");
			$(".pub_2").addClass("display_block");
			
			
			});	
			
			$('.publish_no').click(function () {
			$(".pub_1").removeClass("display_none");
			$(".pub_2").removeClass("display_block");
			
			
			});
			
			$('.fixed').click(function () {
			$(".fixed_cnt").removeClass("display_none");
			$(".auction_cnt").addClass("display_none");
			$(".print_cnt").addClass("display_none");
			$(".print_ship").addClass("display_none");
			
			
			});	
			
			$('.auction').click(function () {
			$(".auction_cnt").removeClass("display_none");
			$(".fixed_cnt").addClass("display_none");
			$(".print_cnt").addClass("display_none");
			$(".print_ship").addClass("display_none");
			
			
			});
			$('.print_btn').click(function () {
			$(".print_cnt").removeClass("display_none");
			$(".fixed_cnt").addClass("display_none");
			$(".auction_cnt").addClass("display_none");
			$(".print_ship").addClass("display_none");
			
			
			});
			
			
			
			
			$('.prnit_without').click(function () {
			
			if($(".scond_li").hasClass("shilpdiv")){
			$(".print_cnt").addClass("display_none");
			$(".fixed_cnt").addClass("display_none");
			$(".auction_cnt").addClass("display_none");
			$(".print_ship").removeClass("display_none");
			$(".individual_cnt").addClass("display_none");
			}
			
			
			
			
			});
			
			$('.indi_btn').click(function () {
			
			if($(".scond_li").hasClass("shipless")){
			$(".print_cnt").addClass("display_none");
			$(".fixed_cnt").addClass("display_none");
			$(".auction_cnt").addClass("display_none");
			$(".print_ship").addClass("display_none");
			$(".individual_cnt").removeClass("display_none");
			}
			
			
			
			});
			
			
			$('.ship_remove').click(function () {
			$('.shipgroup .shipContent').remove();
			$('li.shiptab').remove();
			$("ul.scond_li").addClass("shipless").removeClass("shilpdiv");
			$("ul.scond_li .c_22").addClass("display_none");
			$("ul.scond_li .c_21").removeClass("display_none");
			
			
			});
			
			$('.ship_btn').click(function () {
			$('.shipless').find(' > li:nth-last-child(1)').before('<li class="TabbedPanelsTab shiptab"><span>Step 3 <b>Shipping Charges</b></span></li>');
			$("ul.scond_li").removeClass("shipless").addClass("shilpdiv");
			$("ul.scond_li .c_22").removeClass("display_none");
			$("ul.scond_li .c_21").addClass("display_none");
			
			$(".shipContent").insertBefore(".seller_wrap");
			});
			
			
				
			
			// ===========================JavaScript Document for full screen ============================
			
		
			
			$(function() {
			// check native support
			
			// open in fullscreen
            $(document).on("click","#fullscreen .requestfullscreen",function(){
                $('#fullscreen').fullscreen();
		        return false;
			});
			
			// exit fullscreen
            $(document).on("click","#fullscreen .exitfullscreen",function(){
                $.fullscreen.exit();
                return false;
			});
			
			
			var videoDemo = $('#fullscreen')[0];
			
			// document's event
			$(document).bind('fscreenchange', function(e, state, elem) {
			// if we currently in fullscreen mode
			if ($.fullscreen.isFullScreen()) {
                
                $(".hideshowfullscreen").hide();
                
                $('#fullscreen .requestfullscreen').hide();
                $('#fullscreen .exitfullscreen').show();
                 $('body').removeClass("new");
                /*
                $('.color_bg').css('display',"block");
                $('.cell_wr').css('display',"none");
                $('.slide-text a').css('display',"none");
                $('.wrap_2 h2').css('margin',"0 0 0 -27px");
                $('.social_wrap').css('display',"none");
                $('#fullscreen').addClass("shadow1");
                $('.flex-viewport .slides').addClass("sldie_full");
                $('.zoom_wrap').css('background',"#444444");
                */
                
                var 
                E = $(window).height();
                H= E - 125;
                $('.sldie_full li img').css('max-height',H);	
			
			
			} else {
                
                $(".hideshowfullscreen").show();
                
                $('#fullscreen .requestfullscreen').show();
                $('#fullscreen .exitfullscreen').hide();
                 $('body').removeClass("new");
                /*
                $('.color_bg').css('display',"none");
                $('.slide-text a').css('display',"block");
                $('.wrap_2 h2').css('margin',"0 auto");
                $('.cell_wr').css('display',"block");
                $('.social_wrap').css('display',"block");
                $('.defaultP div').removeClass("ez-checked");
                $('.flex-viewport .slides').removeClass("sldie_full");
               
                $('#fullscreen').removeClass("shadow1");
                $('.zoom_wrap').css('background',"#fff");
                */
		
			
			
			
			
			}
			
			$('#state').text($.fullscreen.isFullScreen() ? '' : 'not');
			
			
			});	
			
			});
			// ===========================JavaScript for tab content 1===========================
			
			
			$('.next_click_1').click(function () {
			var li = $("#TabbedPanels2 li.TabbedPanelsTabSelected");
			
			// tab next buttn script
			if (li.length)
			li.removeClass(" TabbedPanelsTabSelected").next().addClass("TabbedPanelsTabSelected").addClass("visited");
			
			else
			$("#TabbedPanels2 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels2 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").next().addClass("TabbedPanelsContentVisible")
			
			else
			$("#TabbedPanels2 div").first().addClass("TabbedPanelsContentVisible");
			
			
			
			
			$(".wizard_wrap").removeClass("frist_1");
			
			
			});
			
			
			$('.back_click_1').click(function () {
			
			var li = $("#TabbedPanels2 li.TabbedPanelsTabSelected");
			
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").removeClass("visited").prev().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels2 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels2 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").prev().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels2 div").first().addClass("TabbedPanelsContentVisible");
			
			$(".tab_setting .TabbedPanelsContent").removeClass("TabbedPanelsContentVisible");
			$(".tab_setting .Tabbed2.TabbedPanelsContent").addClass("TabbedPanelsContentVisible");
			
			$(".wizard_wrap").addClass("frist_1");
			$(".step_border").css('width','186px');
			
			});
			
			
			
			
			
			
			
			
			
			$('.next_click').click(function () {
			var li = $("#TabbedPanels2 li.TabbedPanelsTabSelected");
			
			// tab next buttn script
			if (li.length)
			li.removeClass(" TabbedPanelsTabSelected").next().addClass("TabbedPanelsTabSelected").addClass("visited");
			
			else
			$("#TabbedPanels2 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels2 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").next().addClass("TabbedPanelsContentVisible")
			
			else
			$("#TabbedPanels2 div").first().addClass("TabbedPanelsContentVisible");
			
			
			
			var processRunPrv =(li.width()+(li.css('margin-left').replace('px','')*2))/2 ;	
			var processRunNxt =(li.next('li').width()+(li.next('li').css('margin-left').replace('px','')*2))/2 ;
			$('.step_border').animate({
			width: '+='+(processRunPrv+processRunNxt)+'px'
			});
			
			
			
			
			});
			
			
			
			
			$('.back_click').click(function () {
			
			var li = $("#TabbedPanels2 li.TabbedPanelsTabSelected");
			
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").removeClass("visited").prev().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels2 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels2 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").prev().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels2 div").first().addClass("TabbedPanelsContentVisible");
			
			
			var processRunPrv =(li.width()+(li.css('margin-left').replace('px','')*2))/2 ;	
			var processRunNxt =(li.prev('li').width()+(li.prev('li').css('margin-left').replace('px','')*2))/2 ;
			$('.step_border').animate({
			width: '-='+(processRunPrv+processRunNxt)+'px'
			});
			
			
			});
			
			
			
			
			
			
			
			
			
			// ===========================JavaScript for main tab change===========================
			
			$('.next_tab').click(function () {
			var li = $("#man_haedtab>li.TabbedPanelsTabSelected");
			
			// tab next buttn script
			if (li.length)
			li.removeClass(" TabbedPanelsTabSelected").next().addClass("TabbedPanelsTabSelected").addClass("visited");
			else
			$("#man_haedtab>li").first().addClass("TabbedPanelsTabSelected");
			var div = $(".main_tab>div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").next().addClass("TabbedPanelsContentVisible");
			else
			$(".main_tab>div").first().addClass("TabbedPanelsContentVisible");
			
			$(".wizard_wrap").removeClass("frist_1");
			});
			
			
			$('.back_tab').click(function () {
			
			var li = $("#man_haedtab>li.TabbedPanelsTabSelected");
			
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").removeClass("visited").prev().addClass("TabbedPanelsTabSelected");
			else
			$("#man_haedtab>li").first().addClass("TabbedPanelsTabSelected");
			var div = $(".main_tab>div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").prev().addClass("TabbedPanelsContentVisible");
			else
			$(".main_tab>div").first().addClass("TabbedPanelsContentVisible");
			
			});
			
			
			$('.back_tab1').click(function () {
			
			var li = $(".scond_li>li.TabbedPanelsTabSelected");
			
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").removeClass("visited").prev().addClass("TabbedPanelsTabSelected");
			else
			$(".scond_li>li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels3>.TabbedPanelsContentGroup>div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").prev().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels3>.TabbedPanelsContentGroup>div").first().addClass("TabbedPanelsContentVisible");
			
			
			
			var processRunPrv =(li.width()+(li.css('margin-left').replace('px','')*2))/2 ;	
			var processRunNxt =(li.prev('li').width()+(li.prev('li').css('margin-left').replace('px','')*2))/2 ;
			$('.step_border1').animate({
			width: '-='+(processRunPrv+processRunNxt)+'px'
			});
			
			
			});
			
			// ===========================JavaScript for tab content 2===========================
			
			$('.next_click4').click(function () {
			var li = $("#TabbedPanels5 .thrid_list li.TabbedPanelsTabSelected");
			
			// tab next buttn script
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").next().addClass("TabbedPanelsTabSelected").addClass("visited");
			else
			$("#TabbedPanels5 .thrid_list li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels5>.design_wrap>div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").next().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels5>.design_wrap>div").first().addClass("TabbedPanelsContentVisible");
			
			
			var processRunPrv =(li.width()+(li.css('margin-left').replace('px','')*2))/2 ;	
			var processRunNxt =(li.next('li').width()+(li.next('li').css('margin-left').replace('px','')*2))/2 ;
			$('.step_border3').animate({
			width: '+='+(processRunPrv+processRunNxt)+'px'
			});
			
			});
			
			
			$('.back_click4').click(function () {
			
			var li = $("#TabbedPanels5 .thrid_list li.TabbedPanelsTabSelected");
			
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").removeClass("visited").prev().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels5 .thrid_list  li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels5 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").prev().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels5>div div").first().addClass("TabbedPanelsContentVisible");
			
			
			var processRunPrv =(li.width()+(li.css('margin-left').replace('px','')*2))/2 ;	
			var processRunNxt =(li.prev('li').width()+(li.prev('li').css('margin-left').replace('px','')*2))/2 ;
			$('.step_border3').animate({
			width: '-='+(processRunPrv+processRunNxt)+'px'
			});
			
			
			
			});
			
			
			
			// ===========================JavaScript for tab content 2===========================
			
			$('.next_click1').click(function () {
			var li = $("#TabbedPanels3>.scond_li>li.TabbedPanelsTabSelected");
			
			// tab next buttn script
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").next().addClass("TabbedPanelsTabSelected").addClass("visited");
			
			else
			$("#TabbedPanels3>.scond_li>li.TabbedPanelsTab").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels3 .m_auto>div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").next().addClass("TabbedPanelsContentVisible")
			
			else
			$("#TabbedPanels3 .m_auto>div").first().addClass("TabbedPanelsContentVisible");
			
			
			
			var processRunPrv =(li.width()+(li.css('margin-left').replace('px','')*2))/2 ;	
			var processRunNxt =(li.next('li').width()+(li.next('li').css('margin-left').replace('px','')*2))/2 ;
			$('.step_border1').animate({
			width: '+='+(processRunPrv+processRunNxt)+'px'
			});
			
			
			
			
			});
			
			
			$('.back_click1').click(function () {
			var li = $("#TabbedPanels3>.scond_li>li.TabbedPanelsTabSelected");
			
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").removeClass("visited").prev().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels3>.scond_li>li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels3>.m_auto>div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").prev().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels3>.m_auto>div").first().addClass("TabbedPanelsContentVisible");
			
			var processRunPrv =(li.width()+(li.css('margin-left').replace('px','')*2))/2 ;	
			var processRunNxt =(li.prev('li').width()+(li.prev('li').css('margin-left').replace('px','')*2))/2 ;
			$('.step_border1').animate({
			width: '-='+(processRunPrv+processRunNxt)+'px'
			});
			
			
			});
			
			
			// ===========================JavaScript for tab content 3 inner tab===========================
			
			
			
			$('.next_click3').click(function () {
			var li = $("#TabbedPanels4 li.TabbedPanelsTabSelected").addClass("visited");
			
			// tab next buttn script
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").next().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels4 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels4 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").next().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels4div").first().addClass("TabbedPanelsContentVisible");
			
			
			
			var processRunPrv =(li.width()+(li.css('margin-left').replace('px','')*2))/2 ;	
			var processRunNxt =(li.next('li').width()+(li.next('li').css('margin-left').replace('px','')*2))/2 ;
			$('.step_border2').animate({
			width: '+='+(processRunPrv+processRunNxt)+'px'
			});
			
			
			});
			
			$('.back_click3').click(function () {
			
			var li = $("#TabbedPanels4 li.TabbedPanelsTabSelected");
			
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").removeClass("visited").prev().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels4 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels4 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").prev().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels4 div").first().addClass("TabbedPanelsContentVisible");
			
			
			var processRunPrv =(li.width()+(li.css('margin-left').replace('px','')*2))/2 ;	
			var processRunNxt =(li.prev('li').width()+(li.prev('li').css('margin-left').replace('px','')*2))/2 ;
			$('.step_border2').animate({
			width: '-='+(processRunPrv+processRunNxt)+'px'
			});
			
			
			
			});
			
			
			
			
			// ===========================JavaScript for tab content 2 inner tab===========================
			
			$('.next_click2').click(function () {
			var li = $("#TabbedPanels6 li.TabbedPanelsTabSelected").addClass("visited");
			
			// tab next buttn script
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").next().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels6 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels6 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").next().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels6 div").first().addClass("TabbedPanelsContentVisible");
			
			
			
			});
			
			$('.back_click2').click(function () {
			
			var li = $("#TabbedPanels6 li.TabbedPanelsTabSelected");
			
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").removeClass("visited").prev().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels6 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels6 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").prev().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels6 div").first().addClass("TabbedPanelsContentVisible");
			
			
			});
			
			
			
			
			
			
			
			$('.next_click31').click(function () {
			var li = $("#TabbedPanels7 li.TabbedPanelsTabSelected").addClass("visited");
			
			// tab next buttn script
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").next().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels7 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels7 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").next().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels7 div").first().addClass("TabbedPanelsContentVisible");
			
			
			
			});
			
			$('.back_click31').click(function () {
			
			var li = $("#TabbedPanels7 li.TabbedPanelsTabSelected");
			
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").removeClass("visited").prev().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels7 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels7 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").prev().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels7 div").first().addClass("TabbedPanelsContentVisible");
			
			
			});
			
			
			
			
			
			$('.next_click32').click(function () {
			var li = $("#TabbedPanels8 li.TabbedPanelsTabSelected").addClass("visited");
			
			// tab next buttn script
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").next().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels8 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels8 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").next().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels8 div").first().addClass("TabbedPanelsContentVisible");
			
			
			
			});
			
			$('.back_click32').click(function () {
			
			var li = $("#TabbedPanels8 li.TabbedPanelsTabSelected");
			
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").removeClass("visited").prev().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels8 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels8 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").prev().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels8 div").first().addClass("TabbedPanelsContentVisible");
			
			
			});
			
			
			
			
			
			$('.next_tabw').click(function () {
			var li = $("#TabbedPanels5 li.TabbedPanelsTabSelected");
			
			// tab next buttn script
			if (li.length)
			li.removeClass(" TabbedPanelsTabSelected").next().addClass("TabbedPanelsTabSelected").addClass("visited");
			
			else
			$("#TabbedPanels5 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels5 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").next().addClass("TabbedPanelsContentVisible")
			
			else
			$("#TabbedPanels5 div").first().addClass("TabbedPanelsContentVisible");
			
			
			
			
			
			
			});
			
			
			
			
			$('.back_tabw').click(function () {
			
			var li = $("#TabbedPanels5 li.TabbedPanelsTabSelected");
			
			if (li.length)
			li.removeClass("TabbedPanelsTabSelected").removeClass("visited").prev().addClass("TabbedPanelsTabSelected");
			else
			$("#TabbedPanels5 li").first().addClass("TabbedPanelsTabSelected");
			var div = $("#TabbedPanels5 div.TabbedPanelsContentVisible");
			if (div.length)
			div.removeClass("TabbedPanelsContentVisible").prev().addClass("TabbedPanelsContentVisible");
			else
			$("#TabbedPanels5 div").first().addClass("TabbedPanelsContentVisible");
			
			
			});
			
			<!-- ================================  custome tab on wizard  ============================-->	
	
	

	
	function resetTabs(){
    jQuery("#content_tabs > div").hide(); //Hide all content
    jQuery("#tabs_nav a").attr("id",""); //Reset id's      
}

var myUrl = window.location.href; //get URL
var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // For mywebsite. com/tabs.html#tab2, myUrlTab = #tab2     
var myUrlTabName = myUrlTab.substring(0,4); // For the above example, myUrlTabName = #tab

jQuery(function(){
    jQuery("#content_tabs > div").hide(); // Initially hide all content
    jQuery("#tabs_nav li:first a").attr("id","current"); // Activate first tab
    jQuery("#content_tabs > div:first").fadeIn(); // Show first tab content

    jQuery("#tabs_nav a").on("click",function(e) {
        e.preventDefault();
        if (jQuery(this).attr("id") == "current"){ //detection for current tab
         return       
        }
        else{             
        resetTabs();
        jQuery(this).attr("id","current"); // Activate this
        jQuery(jQuery(this).attr('name')).fadeIn(); // Show content for current tab
        }
    });

    for (i = 1; i <= $("#tabs_nav li").length; i++) {
      if (myUrlTab == myUrlTabName + i) {
          resetTabs();
          jQuery("a[name='"+myUrlTab+"']").attr("id","current"); // Activate url tab
          jQuery(myUrlTab).fadeIn(); // Show url tab content        
      }
    }
});


			$(document).ready(function(){
			
			function runTimeCheckBox(){
			$('.defaultP input').ezMark();
			$('.customP input[type="checkbox"]').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked-green'})	
			}
			
 });


$(document).ready(function(){
		
		//var clickCount= 1;	
		//var totalSlide = 3;	
   	 	$('.buttons').click(function(){
		 var totalSlide = $(this).closest('.hori_slide').find('li').size();
		 var clickCount = parseInt($(this).closest('.hori_slide').attr('slidercount'));
		
		if($(this).hasClass('next')){
			if(clickCount <= totalSlide){
				clickCount++;
			}
		}else{
			if(clickCount >= '0'){
				clickCount--;
			}
		}
		
		$(this).closest('.hori_slide').find(".current_slide").html(clickCount);
		$(this).closest('.hori_slide').find(".total_slide").html(totalSlide);
		$(this).closest('.hori_slide').attr('slidercount',clickCount)

        });
        
});

$(document).ready(function(e) {
    

    var removeClass = true;
         $("#banana").click(function () {
             $("body").toggleClass('new');
             removeClass = false;
         });
         $("body").click(function() {
             removeClass = true;
         });
       


});


/*  ==================all select js====================   */

$(document).ready(function(e) {
$(function() {
			$( "#datepicker" ).datepicker({
			showOn: "button",
			buttonImage: "images/calander.png",
			buttonImageOnly: true
			});
			});
			
			
			$(function() {
			$( ".datepicker" ).datepicker({
			});
			});

});
