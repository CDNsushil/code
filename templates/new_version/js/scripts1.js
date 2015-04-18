jQuery(document).ready(function ($) {


    $(window).stellar();

    var links = $('.navigation_slide').find('li');
    slide = $('.slide');
    button = $('.button');
    mywindow = $(window);
    htmlbody = $('html,body');


    slide.waypoint(function (event, direction) {

//console.log(direction);
        dataslide = $(this).attr('data-slide');
		
		$(".navigation_slide li").each(function(){
			$(".navigation_slide li").removeClass("active");
		});	
		
        if (direction === 'down') {
           $('.navigation_slide li[data-slide="' + dataslide + '"]').addClass('active').prev().removeClass('active');
        }
        else {
           $('.navigation_slide li[data-slide="' + dataslide + '"]').addClass('active').next().removeClass('active');
        }

    });
 
    mywindow.scroll(function () {
        if (mywindow.scrollTop() == 0) {
          	$('.navigation_slide li[data-slide="1"]').addClass('active');
            $('.navigation_slide li[data-slide="2"]').removeClass('active');
        }
    });

    function goToByScroll(dataslide) {
        htmlbody.animate({
            scrollTop: $('.slide[data-slide="' + dataslide + '"]').offset().top
        }, 2000, 'easeInOutQuint');
    }



    links.click(function (e) {
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);
    });

    button.click(function (e) {
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);

    });
	$(".navigation_slide li").click(function(){
		
		$(".navigation_slide li").each(function(){
			
			$(".navigation_slide li").removeClass("active");
			
		});	
		
		$(this).addClass("active");
		//console.log(this);
				});
		

});

