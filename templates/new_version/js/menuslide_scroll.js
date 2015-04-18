

$(document).ready(function(e) {
    //--------------go to menu code----------------//
    var timeoutId;
    $("#cssmenu").hover(function() {
        
        //this code for reset 
        var countli = 1;
        $('.menu_open > .dropdown-menu').each(function(){
            if(countli==1){
                $(this).css("display","block")
            }else{
                $(this).css("display","none")
            }
            countli++;
        });
		        $('.menu_open2 > sub_menu2').each(function(){
            if(countli==1){
                $(this).css("display","block")
            }else{
                $(this).css("display","none")
            }
            countli++;
        });

        
        if (!timeoutId) {
                timeoutId = window.setTimeout(function() {
                    timeoutId = null;
                    $("#displaynone").css('visibility',"visible");
                    $("#displaynone").css('opacity',"1");
                     $(".gotobtn" ).css('opacity',".3");
                    $(".yourtoadsquare").css('z-index',"96");
                    $(".menuslideup").css('opacity',"1");
                    $(".menuslideup").css('visibility',"visible");
               }, 200);
            }
        }
        ,
        function () {
            if (timeoutId) {
                window.clearTimeout(timeoutId);
                timeoutId = null;
            }
            else {
               $("#displaynone").css('visibility',"hidden");
                $("#displaynone").css('opacity',"0");
                $(".yourtoadsquare").css('z-index',"99");
                $(".menuslideup").css('opacity',"0");
                $(".menuslideup").css('visibility',"hidden");
                $(".gotobtn").css('opacity',"1");
                     
            }
        }
    );
     
    
    //--------------go to menu code----------------//
    
    var timeoutIdMenu;
    var menuObj;
  
    $(".menu_open").hover(function() {
        
        //reset menu
        /*$(".sub_menu1").each(function(){
            $(this).css("display","none");
        });*/
        
        menuObj = this;
        //show menu li
        if (!timeoutIdMenu) {
                timeoutIdMenu = window.setTimeout(function() {
                    timeoutIdMenu = null;
                        $(menuObj).find('.sub_menu1').css("display","block");
                        $(menuObj).find('.green_menu .got_to_menu').css("opacity","1");
                        
                        //reset all
                         $(".sub_menu1").each(function(){
                            $(this).removeClass('activemenu');
                        });
                        
                         $(menuObj).find('.sub_menu1').addClass('activemenu');
                        //$(menuObj).removeClass("mouseout");
               }, 300);
            }
        },
        function () {
            if (timeoutIdMenu) {
                window.clearTimeout(timeoutIdMenu);
                timeoutIdMenu = null;
            }
            else {
               
                //hide out show
                if (!timeoutIdMenu) {
                    timeoutIdMenu = window.setTimeout(function() {
                        timeoutIdMenu = null;
                            $('.menu_open').find('.sub_menu1').css("display","none");
                            $(menuObj).find('.sub_menu1').css("display","block");
                            //$( ".menu_open" ).removeClass('activemenu');
                            //$(menuObj).addClass('activemenu');
                    },300);
                }
            }
        }
    );
	
    //reset menu
    $(".menu_open").mouseleave(function() {
        $(".sub_menu1").each(function(){
            
            if($(this).hasClass('activemenu')==false){
                $(this).css("display","none");
            }
        });
    });
	
	
    var timeoutIdMenuSub;
    var menuObjMenu;
	$(".menu_open2").hover(function() {
        
        //reset menu
        /*$(".sub_menu2").each(function(){
            $(this).css("display","none");
        });*/
        
        menuObjMenu = this;
        //show menu li
        if (!timeoutIdMenuSub) {
                timeoutIdMenuSub = window.setTimeout(function() {
                    timeoutIdMenuSub = null;
                        $(menuObjMenu).find('.sub_menu2').css("display","block");
                        //$(menuObjMenu).addClass('activemenu');
                        //$(menuObjMenu).removeClass("mouseout");
                        //reset all
                         $(".sub_menu2").each(function(){
                            $(this).removeClass('activemenu');
                        });
                        
                        $(menuObj).find('.sub_menu2').addClass('activemenu');
               }, 200);
            }
        },
        function () {
            if (timeoutIdMenuSub) {
                window.clearTimeout(timeoutIdMenuSub);
                timeoutIdMenuSub = null;
            }
            else {
               
                //hide out show
                if (!timeoutIdMenuSub) {
                    timeoutIdMenuSub = window.setTimeout(function() {
                        timeoutIdMenuSub = null;
                            $('.menu_open2').find('.sub_menu2').css("display","none");
                            $(menuObjMenu).find('.sub_menu2').css("display","block");
                            //$( ".menu_open" ).removeClass('activemenu');
                            //$(menuObjMenu).addClass('activemenu');
                    },200);
                }
            }
        }
    );
    
    
    var timeoutIdMenuSubToda;
    var menuObjMenuToda;
	$(".toad_menu_open").hover(function() {
        
        //reset menu
        /*$(".sub_menu2").each(function(){
            $(this).css("display","none");
        });*/
        
        menuObjMenuToda = this;
        //show menu li
        if (!timeoutIdMenuSubToda) {
                timeoutIdMenuSubToda = window.setTimeout(function() {
                    timeoutIdMenuSubToda = null;
                        $(menuObjMenuToda).find('.toad_menu_open_sub').css("display","block");
                        //$(menuObjMenuToda).addClass('activemenu');
                        //$(menuObjMenuToda).removeClass("mouseout");
                        //reset all
                         $(".toad_menu_open_sub").each(function(){
                            $(this).removeClass('activemenu');
                        });
                        
                        $(menuObj).find('.toad_menu_open_sub').addClass('activemenu');
               }, 200);
            }
        },
        function () {
            if (timeoutIdMenuSubToda) {
                window.clearTimeout(timeoutIdMenuSubToda);
                timeoutIdMenuSubToda = null;
            }
            else {
               
                //hide out show
                if (!timeoutIdMenuSubToda) {
                    timeoutIdMenuSubToda = window.setTimeout(function() {
                        timeoutIdMenuSubToda = null;
                            $('.toad_menu_open').find('.toad_menu_open_sub').css("display","none");
                            $(menuObjMenuToda).find('.toad_menu_open_sub').css("display","block");
                            //$( ".menu_open" ).removeClass('activemenu');
                            //$(menuObjMenuToda).addClass('activemenu');
                    },200);
                }
            }
        }
    );
    
    //reset menu
    $(".menu_open2").mouseleave(function() {
        /*$(".sub_menu2").each(function(){
            if($(this).hasClass('activemenu')==false){
                $(this).css("display","none");
            }
        });*/
    });
    
    });   
    //--------------showcase menu code----------------//
    
    var timeoutIdShowcase;
    $(".Showcase_menu").hover(function() {
        if (!timeoutIdShowcase) {
                timeoutIdShowcase = window.setTimeout(function() {
                    timeoutIdShowcase = null;
                    $("#displaynone2").css('visibility',"visible").css('z-index','101');
                    $(".Showcase_menu").css('z-index','102');
                    $("#displaynone2").css('opacity',"1");
                    $(".show_tabmenu").css('visibility',"visible");
                    $(".show_tabmenu").css('opacity',"1");
                    $('.Showcase_menu').css('background-color',"#444444");
                    		
               }, 200);
            }
        }
        ,
        function () {
            if (timeoutIdShowcase) {
                window.clearTimeout(timeoutIdShowcase);
                timeoutIdShowcase = null;
            }
            else {
                $(".Showcase_menu").css('z-index','96');
                $("#displaynone2").css('z-index','97');
                $(".show_tabmenu").css('visibility',"hidden");
                $(".show_tabmenu").css('opacity',"0");
                $('.Showcase_menu').css('background-color',"#717171");
              
            }
            
    
        }
    );
    
     
    
    /*
        $(".Showcase_menu").mouseover(function(){
            $("#displaynone2").css('visibility',"visible").css('z-index','101');
            $(".Showcase_menu").css('z-index','102');
            $("#displaynone2").css('opacity',"1");		
        });


        $(".Showcase_menu").mouseout(function(){	
            $(".Showcase_menu").css('z-index','96');
            $("#displaynone2").css('z-index','97');
        });
    
    */
        
        /*
         shivpal code 20-march-2015 go to menu
        $("#cssmenu").mouseover(function(){
            $("#displaynone").css('visibility',"visible");
            $("#displaynone").css('opacity',"1");
            $(".yourtoadsquare").css('z-index',"96");
            $(".menuslideup").addClass("active");
        });
        
        $("#cssmenu").mouseout(function(){
            $("#displaynone").css('visibility',"hidden");
            $("#displaynone").css('opacity',"0");
            $(".yourtoadsquare").css('z-index',"99");
            $(".menuslideup").removeClass("active");
		});	
	      
		$("#displaynone").hover(function(){
            $(".popover").css("display", "none");
            $("a.maintainHover").removeClass("maintainHover");
			$(".yourtoadsquare").css('z-index',"99");
            $(".menuslideup").removeClass("active");
		});*/
					
		
					
    $("#cssmenu").hover(function(){
		$("#cssmenu .popover>li:nth-child(2)").addClass("active");
	});
			
					
	$("#cssmenu .popover>li").mouseover(function(){
	$("#cssmenu .popover>li:nth-child(2)").removeClass("active");
			});

			
		$(".popover").mouseleave(function(){
		$(".popover>li:nth-child(2)").addClass("active");
		$(".first_main ul").css("display","none");
			});
			
			
		$("#toadsquare .toadsq").click(function(){
            $("#displaynone1 ").toggleClass("active");
            $("#toadsquare").toggleClass("activetoad");
		});
		
        $("#displaynone1").click(function(){
            $(this).removeClass("active");
            $("#toadsquare").removeClass("activetoad");
        });	
		
		
		
		
		
			
$(".yourtoadsquare").hover(function(){
$(".yourtoadsquare .menufrist .msg_center").addClass("active");
});
			
$(".yourtoadsquare .menufrist").hover(function(){
$(".yourtoadsquare .menufrist .msg_center").addClass("active");
});			
					
$(".yourtoadsquare .menufrist li").mouseover(function(){
$(".yourtoadsquare .menufrist .msg_center").removeClass("active");
});

                
			




if (navigator.userAgent.indexOf('Mac OS X') != -1) {
  $("body").addClass("mac");
  
} else if(navigator.userAgent.indexOf('Win') != -1) {
	 $("body").addClass("pc");
} else {
  $("body").addClass("linux");
}
// Get OS
/*var os = ['linux'];
var match = navigator.appVersion.toLowerCase().match(new RegExp(os.join('|')));
if (match) {
    $('body').addClass("linux");
}*/


 var removeClass = true;
         $("#banana").click(function () {
             $("body").toggleClass('new');
             removeClass = false;
         });
         $("body").click(function() {
             removeClass = true;
         });
         $(".defaultP").mouseover(function(){
         		$('.color_bg p1').css("display","block");
         });
		    $(".new .defaultP").mouseover(function(){
         		$('.color_bg p2').css("display","block");
         });
        

//  top navigatio js ==========================
$("#displaynone").mouseover(function(){
		$("#displaynone").css('visibility',"hidden");
			$("#displaynone").css('opacity',"0");	
});
		

	$("#displaynone2").mouseover(function(){
		$("#displaynone2").css('visibility',"hidden");
				$("#displaynone2").css('opacity',"0");	
					
				
});			
		
		
    
			
				/*
				$(".menu_wrap .hov_menu").mouseover(function(){	
			$(".popover").css("display", "none");
				});*/
				
	//  top navigatio js  end==========================					
		/*function placeHoderHideShow(obj,placeHoder,action){
	var input = $(obj);
	if(!action){ action = 'hide'; }
 	if(action=='hide'){
		if (input.attr('value') == placeHoder || input.attr('value') == '') {
			input.attr("placeholder","");
			input.attr('value','');
		}
	}
	else if(action=='show'){
		if (input.attr('value') == '' || input.attr('value') == placeHoder) {
			input.attr("placeholder",placeHoder );
			input.attr('value',placeHoder);	}}}



	

	
        var $menu = $(".dropdown-menu");
        // Hook up events to be fired on menu row activation.
        $menu.menuAim({
            activate: activateSubmenu,
            deactivate: deactivateSubmenu
        });

        // events at the right times so you know when to show and hide your submenus.
        function activateSubmenu(row) {
            var $row = $(row),
                submenuId = $row.data("submenuId"),
                $submenu = $("#" + submenuId),
                height = $menu.outerHeight(),
                width = $menu.outerWidth();

            // Show the submenu
            $submenu.css({
                display: "block",
                top: 1,
                 // padding for main dropdown's arrow
            });

            // Keep the currently activated row's highlighted look
            $row.find("a").addClass("maintainHover");
        }
     
	  function deactivateSubmenu(row) {
            var $row = $(row),
                submenuId = $row.data("submenuId"),
                $submenu = $("#" + submenuId);

            // Hide the submenu and remove the row's highlighted look
            $submenu.css("display", "none");
            $row.find("a").removeClass("maintainHover");
        }
           $(".first_main ul").css("display","none");
        // itself because the plugin is agnostic to bootstrap.
        $(".dropdown-menu li").click(function(e) {
            e.stopPropagation();
        });*/




			
			
		

					
						
					
