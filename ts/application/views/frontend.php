<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	echo $head;

	$currentModuleClass = $this->router->class;
	$bodyClass = '';
	$mainClass='main';
	
	
	if(strcmp($currentModuleClass,'writingnpublishing')==0)
	 $bodyClass = 'class="seanless_texture"';
	 
	if(strcmp($currentModuleClass,'upcomingfrontend')==0)
	 $bodyClass = 'class="seanless_texture"';
	
	if(strcmp($currentModuleClass,'musicnaudio')==0)
	 $bodyClass = 'class="MA_Seamless_2_texture"';
	
	if(strcmp($currentModuleClass,'blogs')==0)
	 $bodyClass = 'class="seamless_bright_yellow"';
	
	if(strcmp($currentModuleClass,'photographynart')==0){
	 $bodyClass = 'class="PA_strip_bg"';
	 $mainClass = 'PA_splash_texture';
	}
	
	if(strcmp($currentModuleClass,'filmnvideo')==0){
	 $bodyClass = 'class="FV_Seamless"';	 
	}
	
	if(strcmp($currentModuleClass,'performancesnevents')==0){
	 $bodyClass = 'class="PE_Seamless"';
	 $mainClass = 'PE_main_red_texture';	 
	}
	
	if(strcmp($currentModuleClass,'educationnmaterial')==0){
	 $bodyClass = 'class="EM_Seamless"';	 
	}
	
	if(strcmp($currentModuleClass,'associateprofessional')==0){
	 $bodyClass = 'class="AP_Seamless"';	 
	}
	
	if(strcmp($currentModuleClass,'creatives')==0){
	 $bodyClass = 'class="Creative_Seamless"';	 
	}
	
	if(strcmp($currentModuleClass,'enterprises')==0){
	 $bodyClass = 'class="Enterprise_Seamless"';	 
	}
	
	if(strcmp($currentModuleClass,'products')==0){
	 $bodyClass = 'class="Product_Seamless"';	 
	}
	
	if(strcmp($currentModuleClass,'works')==0){
	 $bodyClass = 'class="Work_Seamless"';	 
	}
	
	if(strcmp($currentModuleClass,'home')==0 || strcmp($currentModuleClass,'pressRelease')==0|| strcmp($currentModuleClass,'news')==0){
	 $bodyClass = 'class="lpwh_bg"';	 
	}
	
	//Membership cart 
	
	if(strcmp($currentModuleClass,'membershipcart')==0){
	   $bodyClass = 'class="cart_texturea"';	 
	}
	
	if(strcmp($currentModuleClass,'cart')==0){
	   $bodyClass = 'class="cart_texturea"';
     }
    
	 if(strcmp($currentModuleClass,'auth')==0){
	 $bodyClass = 'class="lpwh_bg"';	 
	}
	if(strcmp($currentModuleClass,'my404')==0){
	 $bodyClass = 'class="lpwh_bg"';	 
	}
	
	if(strcmp($currentModuleClass,'tips')==0){
		 $bodyClass = 'class="homepage_seamless_texture"';	 
	}
	
	
	if(isset($error_404) && $error_404 == 'error_404') $bodyClass='class="lpwh_bg"';
?>

<body <?php echo $bodyClass;?> >
<div class="dn" id="popupBoxWp">
	<div class="popup_box" id="popup_box"></div>
</div>
<!------add verified email popup Condition start--------->

<!------ verified email popup Condition end--------->
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
 <div class="<?php echo $mainClass;?>">
 	<!--<div class="top_strip">
    </div><!--top_strip-->
    
	<div class="wrapper_toad">
   
    <?php 
    $userId = isLoginUser();
    $this->load->view('header');
    ?>
   
    <div class="content_front_wrapper">
     <?php 
     if($currentModuleClass=='home' || $currentModuleClass=='auth' || (isset($error_404) && $error_404 == 'error_404')){
		echo $content;
	}else if($currentModuleClass=='tips'){
		echo $content;
	}else{
    if((strcmp($currentModuleClass,'writingnpublishing')==0)||(strcmp($currentModuleClass,'upcomingfrontend')==0)||(strcmp($currentModuleClass,'musicnaudio')==0)||(strcmp($currentModuleClass,'blogs')==0) || (strcmp($currentModuleClass,'photographynart')==0) || (strcmp($currentModuleClass,'filmnvideo')==0)||(strcmp($currentModuleClass,'educationnmaterial')==0)||(strcmp($currentModuleClass,'associateprofessional')==0)|| (strcmp($currentModuleClass,'enterprises')==0)||(strcmp($currentModuleClass,'creatives')==0)||(strcmp($currentModuleClass,'products')==0)||(strcmp($currentModuleClass,'works')==0) || (strcmp($currentModuleClass,'performancesnevents')==0) || (strcmp($currentModuleClass,'membershipcart')==0) || (strcmp($currentModuleClass,'cart')==0) || (strcmp($currentModuleClass,'payment')==0))
    {
	
     $main_div = '<div class="pt10 pr10 pb10 pl10">';
     
     if((strcmp($currentModuleClass,'performancesnevents')==0) || (strcmp($currentModuleClass,'blogs')==0) || (strcmp($currentModuleClass,'blogs')==0))
		$main_div .='<div class="bg_white pr">';
     else
		$main_div .='<div class="bg_white">';
	}
	else{
		$main_div_class='cell right_coloumn shade_white_body pt0 mt0 ml9 width982px';
		if(strcmp($currentModuleClass,'pressRelease')==0 || strcmp($currentModuleClass,'news')==0){
			$main_div_class='';
		}
	 $main_div = '<div class="row"><div class="'.$main_div_class.'">';
	}
	echo $main_div;
	?>
				
				<?php echo $content?>
				<div class="clear"></div>
				</div> 
				
				   
     <?php if(strcmp($currentModuleClass,'writingnpublishing')==0)
    {
     $main_div_end = '</div>';
	}
	else{
	 $main_div_end = '';
	}
	echo '</div>';
  }
	?> 
	<div class="clear"></div>
	</div><!--content_wrapper-->
	
	  
   <div class="clear"></div>
   <?php $this->load->view('footer');?>
   
    </div><!--wrapper_toad-->
</div><!--main-->   

<script>
	$('.Main_btn_right a').click(function(){
			$(this).parent().parent().parent().addClass('Main_select ');
			$(this).parent().parent().parent().siblings().removeClass('Main_select ');
	})
	renderMaxHeight();
</script>
</body>
</html>
