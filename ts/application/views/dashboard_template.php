<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
echo $head;?>
<body>
	<div class="dn" id="popupBoxWp">
		<div class="popup_box" id="popup_box"></div>
	</div>

	<!--customAlert START-->
	<div id="customAlert" class="customAlert dn">
		<div id="close-customAlert" class="tip-tr close-customAlert"></div>
		<div class="customeMessage"></div>
	</div>
	<!--customAlert END-->

	<!--loginLightBoxWp START-->
	<div id="loginLightBoxWp" class="loginLightBoxWp dn">
		<div id="close-lightBox" class="tip-tr close-customAlert"></div>
		<div class="loginFormContainer" id="loginFormContainer"></div>
	</div>
	<!--creativeAssociativeBoxWp START-->
	<div id="creativeAssociativeBoxWp" class="creativeAssociativeBoxWp dn">
		<div id="close-creativeAssociativelightBox" class="tip-tr close-customAlert" onclick="$(this).parent().trigger('close');"></div>
		<div class="creativeAssociativeContainer" id="creativeAssociativeContainer"></div>
	</div>
	<div class="main">
		<div class="wrapper_toad">
			<?php $this->load->view('header');?>
			<div class="content_wrapper">
				<?php echo $content?>
			</div>
		
			<!--content_wrapper-->
		   <?php $this->load->view('footer');?>   
			<div class="clear"></div> 
		</div><!--wrapper_toad-->
	</div><!--main-->   

	<script>
	$('.Main_btn_right a').click(function(){
							
			$(this).parent().parent().parent().addClass('Main_select ');
			$(this).parent().parent().parent().siblings().removeClass('Main_select ');
		 })
			
	  renderMaxHeight()
	  
	  
  function getShortLink (url,viewType) {	
  	
		$.ajax
		({     
			type: "POST",
			dataType: 'json',
			data:{url:url},			
			url: baseUrl+language+"/shortlink/addShortLink",

				success: function(msg){  									
					 if(viewType=='share') {															
						openUserLightBox('popupBoxWp','popup_box','/share/socialShare',msg.shortlink);
					 }
					 else if(viewType=='email') {						   
						  openUserLightBox('popupBoxWp','popup_box','/share/shareEmail',msg.shortlink);
					 }      
				}
		});			
	}
	</script>
</body>
</html>
