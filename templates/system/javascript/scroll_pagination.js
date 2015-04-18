(function($) {
	$.fn.scrollPagination = function(options) {
		var settings = { 
			method  : 'getLandingPageData', // define meathod
			url     : '', // The number of posts per scroll to be loaded
			divIds  : '',
			limit   : 10, // The number of posts per scroll to be loaded
			offset  : 0, // Initial offset, begins at 0 in this case
			error   : 'No More Posts!', // When the user reaches the end this is the message that is  // displayed. You can change this if you want.
			delay   : 500, // When you scroll down the posts will load after a delayed amount of time. // This is mainly for usability concerns. You can alter this as you see fit
			scroll  : true // The main bit, if set to false posts will not load as the user scrolls. // but will still load if the user clicks.
		}
		if(options) { // Extend the options so they work with the plugin
			$.extend(settings, options);
		}
		
		return this.each(function() {	// For each so that we keep chainability.	
			var result;
			// Some variables 
			$this = $(this);
			$settings = settings;
			var url = $settings.url;
			var divIds = $settings.divIds;
			var limit = $settings.limit;
			var offset = $settings.offset;
			var busy = false; // Checks if the scroll action is happening 
			                  // so we don't run it multiple times
			
			// Custom messages based on settings
			/*if($settings.scroll == true) $initmessage = 'Scroll for more or click here';
			else $initmessage = 'Click for more'; */
			
			if($settings.scroll == true) $initmessage = '';
			else $initmessage = '';
			
			// Append custom messages and extra UI
			$this.append('<div class="row text_alignC f18 ptr loading-bar ">'+$initmessage+'</div>');
			
			result  = getLandingPageData(url,divIds,'',limit,offset); // Run function initially
			
			if(result && result.offset != undefined){
				offset = result.offset;
				busy = result.busy;
			}
			
			// If scrolling is enabled
			if($settings.scroll == true) {
				// .. and the user is scrolling
				$(window).scroll(function() {
					
					// Check the user is at the bottom of the element
					
					var nearToBottom = 250;
					if( (($(window).scrollTop() + $(window).height()) >= ($(document).height() - nearToBottom )) && !busy) {
						
						// Now we are working, so busy is true
						busy = true;
						
						// Tell the user we're loading posts
						
						var loaderImage = baseUrl+"images/loading_wbg.gif";
						var img_url = $("<img class='ajax_loader' src='" + loaderImage + "' style=\"margin-left: auto; margin-right: auto;\" alt=\"Loading...\" title=\"Loading...\"/>");
						
						$this.find('.loading-bar').html(img_url);
						// Run the function to fetch the data inside a delay
						// This is useful if you have content in a footer you
						// want the user to see.
						setTimeout(function() {
							result  = getLandingPageData(url,divIds,'',limit,offset); // Run function initially
							if(result && result.offset != undefined){
								offset = result.offset;
								busy = result.busy;
							}
						}, $settings.delay);
							
					}	
				});
			}
			
			// Also content can be loaded by clicking the loading bar/
			$this.find('.loading-bar').click(function() {
				if(busy == false) {
					busy = true;
					result  = getLandingPageData(url,divIds,'',limit,offset); // Run function initially
					if(result && result.offset != undefined){
						offset = result.offset;
						busy = result.busy;
					}
				}
			});
			
		});
	}

})(jQuery);
