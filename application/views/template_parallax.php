<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	echo $head; 
?>
	<body class="pc">
		<div class="dn" id="popupBoxWp">
            <div class="popup_box" id="popup_box">
            </div>
        </div>

		<div id="page" class="memberhsip home_wrap">
			<div id="wrapperpage">
				<?php
				$this->load->view('partials/template_new_header'); 
	            ?>
                
                <div class="home_page">
                    <?php 
                        echo $content;
                    ?>
                </div>
                
				<?php
                	$this->load->view('partials/template_new_footer'); 
				?>
			</div>
		</div>
        
         <!----js required add in footer---->
    <script src="<?php echo $jsPath; ?>custom.js" type="text/javascript"></script>
    <script src="<?php echo $jsPath; ?>menuslide_scroll.js" type="text/javascript"></script>
    
	</body>
</html>
