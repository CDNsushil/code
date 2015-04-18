<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	//---load head section by library---//
    echo $head;
    
    //-----template background class name get and show-----//
    $className   =  templatebgname(); // get class name
   
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
