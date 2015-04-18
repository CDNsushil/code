<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$systemCSS=base_url($this->config->item('system_css'));
$systemJS=base_url($this->config->item('system_js'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="content-language" content="en" />
		<meta name="author" content="CDN" />
		<meta name="description" content="movie, film, music,toadsquare." />
		<link rel="shortcut icon" href="<?php echo base_url();?>templates/system/images/icon/favicon.png" />
	<link href="<?php echo $systemCSS;?>/common.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo $systemCSS;?>/preview.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo $systemCSS;?>/slider.css" rel="stylesheet" type="text/css"/>
	<link type="text/css" href="<?php echo $systemJS;?>/jquery-plugin/tipsy-1.0/tipsy.css" rel="stylesheet" media="all" />
	<script>
		var BASEURL='<?php echo base_url();?>';
	</script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	<script src="<?php echo $systemJS;?>/slider.js"></script>
	<script type="text/javascript" src="<?php echo base_url('player/flowplayer/flowplayer-3.2.4.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo $systemJS;?>/jquery-plugin/tipsy-1.0/jquery.tipsy.js"></script>
	<script type="text/javascript" src="<?php echo $systemJS;?>/common/tipsy-common.js"></script>
	<script type="text/javascript">
		jQuery(function($){
			$('div#items').easyPaginate({
				step:3
			});
		});      
	</script>
</head>

<body>
<div class="Main_wp">
	<div class="Left-panel">

	<div class="left_content_box">
		<div class="Header-wp">
		
				<div class="logo-box"> 
					<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/logo-tod-square.png"/></a>           
				</div>
			   
			   
			   <!--logo-box-->
			 <? /* <div class="Search-box-wp">
				<div class="search-box">
							<input type="button" class="Btn_search"  value=" "/>
					  <input type="text"  class="inpt-search" value="Search Todsquare"/>
				</div><!--Search-box-->
				
				<div class="search-separator">
					<img src="<?php echo base_url();?>images/pipe.jpg" />
				</div><!--search-separator-->
				
			   <div class="bg_sel" > 
				 <span class="abc">00</span>
				 <select id="myselect" class="single" name="myselect2"  >
				   <option selected="selected" >Select By</option>
				   <option  >DD-2</option>
				   <option >DD-3</option>
				 </select>
			   </div>
				<!--bg_sel-->
			   </div> */?>
			   <!--Search-box-wp-->
			 
			 <!--log-in-wp-->
			   <!--<div class="log-in-wp">
					<a href="#">Login</a> | <a href="#">Create Account</a> 
			   </div>-->
			<!--log-in-wp-->
			   
			   <div class="icon-header-tv">
					<img src="<?php echo base_url();?>images/icons/icon_header_tv.png" />
			   </div><!--icon-header-tv-->
				
			   
		</div><!--Header-wp-->
		
		 <div class="main-separetor"></div><!--main-separetor-->
		
		<div class="clear"></div>
		
		<div class="right-inner-content">
				<?php //echo set_breadcrumb(); ?>
				<!-- Added By Anoop -->
				<?=$content?>
		</div><!--right-inner-content-->
		
		<div class="clear"></div>
	</div><!--left_content_box-->
</div><!--Left-panel-->

<div class="Right-panel"> <a href="#"><img src="<?php echo base_url();?>images/adobe_add.jpg" border="0" class="add"/></a>
</div><!--Right-panel-->
                
                
        
        <div class="clear"></div>
        </div><!--Main_wp-->
		
		<script>
				$(document).ready(function(){
					$('select').each(function(){
						var str = $(this).val();
						
						 $(this).parent().find('.abc').text(str );
					});	
					
						$('select').keyup(function(){
						var str = $(this).val();
						
						 $(this).parent().find('.abc').text(str );
					});
						
										   
					$('select').change(function(){
						var singleValues = $(this).val();	
						 $(this).parent().find('.abc').text(singleValues );
					});					   
				});
		</script>
		

</body>
</html>
