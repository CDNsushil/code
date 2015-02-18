<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	echo $head;
    $getClassName   =  $this->router->fetch_class(); // get class name
    switch($getClassName){
        case "creatives":
            $className = "lp_crav";
        break;
        
        case "associateprofessional":
            $className = "lp_professional";
        break;
        
        case "enterprises":
            $className = "lp_business";
        break;
        
        case "fans":
            $className = "bg_fans";
        break;
        
        case "filmnvideo":
            $className = "PA_splash_texture";
        break;
        
        case "musicnaudio":
            $className = "ma_landing";
        break;
        
        case "writingnpublishing":
            $className = "writing_bg";
        break;
        
        case "photographynart":
            $className = "photo_lp memberhsip";
        break;
        
        case "educationnmaterial":
            $className = "lp_piceswrap";
        break;
       
        
        default:
            $className = "";
        break;
    }
?>

<body class="bgimg_none billing ">

    <!---popup Box show div--->
    <div class="dn" id="popupBoxWp">
        <div class="popup_box" id="popup_box">
            
        </div>
    </div>
      
    <div id="page" class="<?php echo $className; ?>">
      <div id="wrapperpage" class="wizard_wrapper "> 
        <!--  header nav  wrap  -->
            <?php $this->load->view('partials/template_new_header'); ?>
        <!--  header nav  wrap  end -->
        
        <!--  content wrap  start -->
            <?php echo $content?>
        <!--  content wrap  start -->
        
        <!--start Footer-->
            <?php $this->load->view('partials/template_new_footer'); ?>
        <!--End Footer--> 
        
      </div>
    </div>

    <!----js required add in footer---->
    <script src="<?php echo $jsPath; ?>custom.js" type="text/javascript"></script>
    <script src="<?php echo $jsPath; ?>menuslide_scroll.js" type="text/javascript"></script>
 
</body>
</html>
