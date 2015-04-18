/*
 * 	Easy Paginate 1.0 - jQuery plugin
 *	written by Alen Grakalic	
 *	http://cssglobe.com/
 *
 *	Copyright (c) 2011 Alen Grakalic (http://cssglobe.com)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */

(function($) {
	$.fn.easyPaginate = function(options){

		var defaults = {				
			step: 4,
			delay: 100,
			numeric: true,
			nextprev: true,
			auto:false,
			pause:4000,
			clickstop:true,
			controls: 'pagination',
			current: 'current' 
		}; 
		
		var options = $.extend(defaults, options); 
		var step = options.step;
		var lower, upper;
		var children = $(this).children('.down_thumb_box');
		var count = children.length;
		var obj, next, prev;		
		var page = 1;
		var timeout;
		var clicked = true;
		
		function show(){
			clearTimeout(timeout);
			lower = ((page-1) * step);
			upper = lower+step;
			$(children).each(function(i){
				
				var child = $(this);
				child.hide();
				if(i>=lower && i<upper){ setTimeout(function(){ child.fadeIn('fast') }, ( i-( Math.floor(i/step) * step) )*options.delay ); }
				
				if(options.nextprev){
					//if(upper >= count) { next.fadeOut('fast'); } else { next.fadeIn('fast'); }; 
					next.fadeIn('fast');
					//if(lower >= 1) { prev.fadeIn('fast'); } else { prev.fadeOut('fast'); }; 
					prev.fadeIn('fast');
				};
			});	
			$('div','#'+ options.controls).removeClass(options.current);
			$('div[data-index="'+page+'"]','#'+ options.controls).addClass(options.current);
			
			if(options.auto){
				if(options.clickstop && clicked){}else{ timeout = setTimeout(auto,options.pause); };
			};
		};
		
		function auto(){
			if(upper <= count){ page++; show(); }			
		};
		
		this.each(function(){ 
			
			//obj = this;
			obj = $(this).parents('#parentId')
			
			if(count>step){
				
				var pages = Math.floor(count/step);
				if((count/step) > pages) pages++;
				var ol = $('<div class="Pagination_wp" id="'+ options.controls +'"> </div>').insertAfter(obj);
				
				if(options.nextprev){
					prev = $('<div class="pagination_left"></div>')
						.hide()
						.appendTo(ol)
						.click(function(){
							clicked = true;
							page--;
							if(page < 1){
								page = 1;
							}
							show();
						});
				};
				
				if(options.numeric){
					for(var i=1;i<=pages;i++){
					$('<div class="paginaiton_box" data-index="'+ i +'">'+ i +'</div>')
						.appendTo(ol)
						.click(function(){	
							clicked = true;
							page = $(this).attr('data-index');
							show();
						});					
					};				
				};
				
				if(options.nextprev){
					next = $('<div class="pagination_right"></div>')
						.hide()
						.appendTo(ol)
						.click(function(){
							clicked = true;			
							page++;
							if(page > pages){
								page = pages;
							}
							show();
						});
				};
			
				show();
			};
		});	
		
	};	

})(jQuery);