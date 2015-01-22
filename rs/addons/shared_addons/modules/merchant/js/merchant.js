
/*
 *--------------------------------------------------------------------------------------- 
 * This js file include for copy clipboard
 *---------------------------------------------------------------------------------------
 */ 

$("footer").append('<script type="text/javascript" src="addons/shared_addons/modules/merchant/js/zclip/jquery-1.10.2.js"></script>');
$("head").append('<script type="text/javascript" src="addons/shared_addons/modules/merchant/js/zclip/zclip.min.js"></script>');
$("footer").append('<script type="text/javascript" src="addons/shared_addons/modules/merchant/js/zclip/jquery.zclip.js"></script>');
$("head").append('<script type="text/javascript" src="addons/shared_addons/modules/merchant/js/plupload.full.min.js"></script>');

/*
 *--------------------------------------------------------------------------------------- 
 * This function for preview of image
 *---------------------------------------------------------------------------------------
 */ 
$(document).ready(function(){

	$(".banner_preview").click(function(e) {
		//open preview popup
		$('#banner_preview').modal({ backdrop: 'static', keyboard: true });
		var imgSrc='';
		var width=$('#image_width').val();
		var height=$('#image_height').val();
		var imgOption=$('input[name=image_option]:checked').val();
		var imgType=$('input[name=image_type]:checked').val();
	
		if(imgType==1){
			 width="70";
			 height="70";
		}else if(imgType==0){
			 width="";
			 height="";
		}
		if(imgOption==0){
			imgSrc=$('#image_url').val();
		}else if(imgOption==1){
			imgSrc=baseUrl+'assets/banner_images/'+$('#uploaded_img_name').val();
		}
		
		$('#img_preview').attr('src',imgSrc);
		$('.img_preview').attr('width',width+'px');
		$('.img_preview').attr('height',height+'px');
		
		
	});
	
});
