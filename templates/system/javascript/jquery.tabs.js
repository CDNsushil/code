function resetTabs(){
    $("#tab_content > div").hide(); //Hide all content
    $("#tabs_link li").attr("id",""); //Reset id's      
}

var myUrl = window.location.href; //get URL
var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // For mywebsite.com/tabs.html#tab2, myUrlTab = #tab2     
var myUrlTabName = myUrlTab.substring(0,4); // For the above example, myUrlTabName = #tab

(function(){
    $("#tab_content > div").hide(); // Initially hide all content
    $("#tabs_link li:first").attr("id","current"); // Activate first tab
    $("#tab_content > div:first").fadeIn(); // Show first tab content
    
    $("#tabs_link li").on("click",function(e) {
        e.preventDefault();
        if ($(this).attr("id") == "current"){ //detection for current tab
         return       
        }
        else{             
        resetTabs();
        $(this).attr("id","current"); // Activate this
        $($(this).attr('name')).fadeIn(); // Show content for current tab
        }
    });

    for (i = 1; i <= $("#tabs_link li").length; i++) {
      if (myUrlTab == myUrlTabName + i) {
          resetTabs();
          $("a[name='"+myUrlTab+"']").attr("id","current"); // Activate url tab
          $(myUrlTab).fadeIn(); // Show url tab content        
      }
    }
})()

/* Added by sushil date: 19-11-2012  Start*/
/*
$(document).ready(function() { 
	//On Click Event
	$("ul#tabs_link li").click(function() {
		$("ul#tabs_link li").removeClass("activetab"); //Remove any "active" class
		$(this).addClass("activetab"); //Add "active" class to selected tab
		$(".outetab").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});
} );*/

function venueOrgniserDetails(details,liId,divId){
	if(details && details != ''){
		loadPopupData('popupBoxWp','popup_box',details);
	}
	
	if($(".liVOD"))
	$(".liVOD").removeClass("activetab");
	
	if($(".divVOD"))
	$(".divVOD").hide(); //Hide all content
	
	if(liId){
		$(liId).addClass("activetab"); //Activate first tab
		var activeTab = $(liId).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
	}
	
	if(divId)
	$(divId).show(); //Show first tab content
	
}
 

	
/* Added by sushil date: 19-11-2012  END*/

