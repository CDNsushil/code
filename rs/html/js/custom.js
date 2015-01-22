$(document).ready(function(e) {
var maxheight = 0;

// For box heading and content height
$.each( $(".box_heading") ,function(){
	var headingheight = $(this).height();
	maxheight = (headingheight > maxheight) ? headingheight : maxheight;
});
$.each( $(".box_heading") ,function(){
	$(this).height(maxheight);
});
//for content
$.each( $(".box_content") ,function(){
	var contentheight = $(this).height();
	maxheight = (contentheight > maxheight) ? contentheight : maxheight;
});
$.each( $(".box_content") ,function(){
	$(this).height(maxheight);
});
// For box heading and content height ends

});
