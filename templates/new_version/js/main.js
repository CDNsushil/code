
$(document).ready(function(){
		setInterval(function(){
			$(".my_slide").fadeOut(1500);
		},3000);
		setInterval(function(){
			$(".my_slide").each(function(){
					var total = $(this).parent().find(".counter").find(".total_slide").html();
					var current = $(this).parent().find(".counter").find(".current_slide").html();
					var i=parseInt(current);
					if(total==current){
						i=0;
					}
					i++;
					
					$(this).fadeIn(2000);
					// updating counter
					$(this).parent().find(".counter").find(".current_slide").html(i);
			});
		},3000);
});

$(document).ready(function(){
		
		var clickCount= 1;	
		var totalSlide = 3;	
   	 	$('.hori_slide .buttons').click(function(){
		
		if($(this).hasClass('next')){
			if(clickCount <= totalSlide){
				clickCount++;
			}
		}else{
			if(clickCount >= '0'){
				clickCount--;
			}
		}
		
		$(this).parent().find(".current_slide").html(clickCount);

        });
        
});

