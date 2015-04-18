<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	echo $head;
?>


<body>

<!--customAlert START-->
<div id="customAlert" class="customAlert dn">
	<div id="close-customAlert" title="<?php echo $this->lang->line('closeIt');?>" class="tip-tr close-customAlert"></div>
	<div class="customeMessage"></div>
</div>
<!--customAlert END-->

<!--loginLightBoxWp START-->
<div id="loginLightBoxWp" class="loginLightBoxWp dn">
	<div id="close-lightBox" title="<?php echo $this->lang->line('closeIt');?>" class="tip-tr close-customAlert"></div>
	<div class="loginFormContainer" id="loginFormContainer"></div>
</div>

<!--creativeAssociativeBoxWp START-->
<div id="creativeAssociativeBoxWp" class="creativeAssociativeBoxWp dn">
	<div id="close-creativeAssociativelightBox" title="<?php echo $this->lang->line('closeIt');?>" class="tip-tr close-customAlert" onclick="$(this).parent().trigger('close');"></div>
	<div class="creativeAssociativeContainer" id="creativeAssociativeContainer"></div>
</div>
 <div class="main">
 	<div class="top_strip">
    </div><!--top_strip-->
    
	<div class="wrapper_toad">
   
    		<div class="header_toad">
            	<img src="<?PHP echo $imagePath;?>logo_toad.png" class="toad_logo"/>
                
                <div class="header_right">
                	            
                        
                    <span class="icon_search"><a href="#"><img src="<?PHP echo $imagePath;?>icon_search.png"/></a></span> 
                    <span><a class="comingSoon gray_color-3" href="javascript:void:none"><?php echo $this->lang->line('help')?></a></span> 
                    <span><a class="comingSoon" href="javascript:void:none"><?php echo $this->lang->line('cart')?></a> </span> 
                    <?php if(isLoginUser()){?>
						<span>
								<a href="<?php echo base_url(lang().'/auth/logout');?>" class="gray_color-0"><b></b><?php echo $this->lang->line('logout')?></b></a>
						</span>
						<?php 
					}else{?>
						<span>
								<a href="<?php echo base_url(lang().'/package/packagestageone');  ?>" class="gray_color-0"><b><?php echo $this->lang->line('join')?></b></a>
						</span>
						<span>
								<a href="javascript:openLightBox('loginLightBoxWp','loginFormContainer','/auth/login')" class="askForLogin gray_color-0" id="askForLogin"><b><?php echo $this->lang->line('login')?></b></a>
						</span>
						<?php 
					}?>
                    <span><a class="comingSoon"href="javascript:void:none"><?php echo $this->lang->line('dashboard')?></a></span> 
                    <span><a class="comingSoon" href="javascript:void:none"><?php echo $this->lang->line('showcase')?></a></span> 
					<span class="gray_color-1">
						<?php 
						$userName=isLoginUser()?LoginUserDetails('firstName'):$this->lang->line('guest');
						echo   $this->lang->line('welcome').'&nbsp;<b>'.$userName.'.</b>&nbsp;'.$this->lang->line('youAreIn').'&nbsp;<b>'.getCountryFromIP().'</b>';
						?>
					</span>
                    
                    <div class="search_box_wrapper">
                    	<input type="text" class="search_text_box" value="Keyword Search..." />
                        <div class="search_btn">
                        <img src="<?PHP echo $imagePath;?>btn_search_box.png" />
                        </div>
                  </div><!--search_box_wrapper-->
                </div><!--header_right-->
                
            </div><!--header_toad-->
            
            <div class="clear"></div>
            
            <div class="nav_toad">
            		<div class="nav_left">
						<ul>
							<li><a class="comingSoon" href="javascript:void:none"><?php echo $this->lang->line('creatives')?></a> </li>
							<li>
								<a class="comingSoon" href="javascript:void:none"><?php echo $this->lang->line('associated')?> <br/> 
								<?php echo $this->lang->line('professional')?></a>
							</li>
							<li><a class="comingSoon" href="javascript:void:none"><?php echo $this->lang->line('enterprises')?></a></li>
						</ul>
                    </div>
                    
                    <div class="nav_right">
						<ul>
							<li><a href="<?php echo base_url(lang().'/media/filmNvideo');?>"><?php echo $this->lang->line('film').'&nbsp;'.$this->lang->line('&').' <br/>'.$this->lang->line('video')?> </a></li>
							<li><a href="<?php echo base_url(lang().'/media/musicNaudio');?>"><?php echo $this->lang->line('music').'&nbsp;'.$this->lang->line('&').' <br/>'.$this->lang->line('audio')?></a></li>
							<li><a href="<?php echo base_url(lang().'/media/photographyNArt');?>"><?php echo $this->lang->line('photography').'&nbsp;'.$this->lang->line('&').'<br/>'.$this->lang->line('art')?> </a></li>
							<li><a href="<?php echo base_url(lang().'/media/writingNpublishing');?>"><?php echo $this->lang->line('writing').'&nbsp;'.$this->lang->line('&').' <br/>'.$this->lang->line('publishing')?></a></li>
							<li><a href="<?php echo base_url(lang().'/event');?>"><?php echo $this->lang->line('performances').'&nbsp;'.$this->lang->line('&').' <br/>'.$this->lang->line('events')?></a></li>
							<li><a href="<?php echo base_url(lang().'/media/educationMaterial');?>"><?php echo $this->lang->line('educational')?> <br/> <?php echo $this->lang->line('material')?></a></li>
							<li><a href="<?php echo base_url(lang().'/work');?>"><?php echo $this->lang->line('work')?></a></li>
							<li><a href="<?php echo base_url(lang().'/product/sell');?>"><?php echo $this->lang->line('products')?></a></li>
							<li><a href="<?php echo base_url(lang().'/blog/frontBlogSummary');?>"><?php echo $this->lang->line('blogs')?></a></li>
							<li><a href="<?php echo base_url(lang().'/forums');?>"><?php echo $this->lang->line('forums')?></a></li>
						</ul>
                    </div>
                    
            </div><!--nav_toad-->
            
            
            <div class="content_wrapper">
				<?php
				
				$class_right='right_coloumn_full';
				
				$userId= $this->uri->segment(4);
				
				if(isLoginUser()){
					
					if(isset($userId) && $userId>0) $userId = $userId;
					else $userId = isLoginUser();
					
					$userInfo = showCaseUserDetails($userId);
					
					$userImage = getImage($userInfo['userImage'],'user');
					
					$class_right='right_coloumn bpl-216';
				?>
					
				<?php
            }?>        
			<div class="<?php echo $class_right;?> ml5" style="width:988px;">
				
					<?php 
					if(isLoginUser()){ ?>
						<div class="row heightSpacer">
								<div class="Fleft breadcrumb"><!-- removed the class cell-->
									<?php echo set_breadcrumb(); ?>
								</div>
						 </div>
						<?php
					}?>
						            
                                    
					<?php  echo get_global_messages();?> 
					<!--<div class="rightColomContent">-->
						<?php echo $content?>
					<!--</div>-->
			</div><!--right_column-->
            
            <div class="clear"></div>
            
           
       <!--/* OpenX Javascript Tag v2.8.9 */-->

<!--/*
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://localhost/openx/www/delivery/...'
  * to
  *   'https://localhost/openx/www/delivery/...'
  *
  * This noscript section of this tag only shows image banners. There
  * is no width or height in these banners, so if you want these tags to
  * allocate space for the ad before it shows, you will need to add this
  * information to the <img> tag.
  *
  * If you do not want to deal with the intricities of the noscript
  * section, delete the tag (from <noscript>... to </noscript>). On
  * average, the noscript tag is called from less than 1% of internet
  * users.
  */-->

<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://localhost/openx/www/delivery/ajs.php':'http://localhost/openx/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=5");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://localhost/openx/www/delivery/ck.php?n=a19118b3&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://localhost/openx/www/delivery/avw.php?zoneid=5&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a19118b3' border='0' alt='' /></a></noscript>
     
            
            </div><!--content_wrapper-->
            
            <div class="footer_wrapper">
            		<div class="footer_content">
                    <div class="footer_left"> 
                    <a href="#"><img src="<?PHP echo $imagePath;?>logo_toad_grayscale.png" /></a>
                    
                    <div class="footer_search_box">
                    <div class="search_box_wrapper">
                    	<input type="text" class="search_text_box" value="Keyword Search..." />
                        <div class="search_btn">
                        <img src="<?PHP echo $imagePath;?>btn_search_box.png" />
                        </div>
                  </div><!--search_box_wrapper-->
                  </div><!--footer_search_box-->
                  
                    </div><!--footer_left-->
                    
                    <div class="footer_right">
                    
                    		<div class="footer_link1">
                    		<div class="footer_block">
                            	<a class="comingSoon" href="javascript:void:none"><?php echo $this->lang->line('creatives')?></a><br/>
                                <a class="comingSoon" href="javascript:void:none"><?php echo $this->lang->line('associated').'&nbsp;'.$this->lang->line('professional')?></a><br/>
								<a class="comingSoon" href="javascript:void:none"><?php echo $this->lang->line('enterprises')?></a>
                      </div>
                      
                      <div class="footer_block">
                            	<a href="<?php echo base_url(lang().'/work');?>"><?php echo $this->lang->line('work')?></a><br/>
                                <a href="<?php echo base_url(lang().'/product/sell');?>"><?php echo $this->lang->line('products')?></a>
                    
                      </div>
                      
                         </div>
                         
                            
                            <div class="footer_link2">
                            <div class="footer_block">
                            	<a href="<?php echo base_url(lang().'/media/filmNvideo');?>"><?php echo $this->lang->line('film').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('video')?> </a><br/>
                                <a href="<?php echo base_url(lang().'/media/musicNaudio');?>"><?php echo $this->lang->line('music').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('audio')?></a><br/>
								<a href="<?php echo base_url(lang().'/media/photographyNArt');?>"><?php echo $this->lang->line('photography').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('art')?> </a></a>
							</div>
                      
                      <div class="footer_block">
                            	<a class="comingSoon" href="javascript:void:none"><?php echo $this->lang->line('help')?></a><br/>
                            	<a class="comingSoon" href="javascript:void:none"><?php echo $this->lang->line('cart')?></a> 
                     
                      </div>
                            
                            </div>
                            
                            <div class="footer_link3">
                            <div class="footer_block">
                            	<a href="<?php echo base_url(lang().'/media/writingNpublishing');?>"><?php echo $this->lang->line('writing').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('publishing')?></a><br/>
                                
                               <a href="<?php echo base_url(lang().'/event');?>"><?php echo $this->lang->line('performances').'&nbsp;'.$this->lang->line('events')?></a><br/>
                               <a href="<?php echo base_url(lang().'/media/educationMaterial');?>"><?php echo $this->lang->line('educational').'&nbsp;'.$this->lang->line('material')?></a>
                     
                      </div>
                      
                      
                      <div class="footer_block">
                            	<a href="<?php echo base_url(lang().'/blog/index');?>"><?php echo $this->lang->line('blogs')?></a><br/>
                               <a  href="<?php echo base_url(lang().'/forums');?>"><?php echo $this->lang->line('forums')?></a>
                                
                     
                      </div>                      
                      
                     </div>
                            
                        <div class="copyright"><?php echo $this->lang->line('copyRight');?>     <a href="">Conditions of use</a>    <a href="#">Privacy Statement</a> </div>   
                    </div><!--foote_right-->
                    		
                     <div class="clear"></div>
                            
                    </div><!--footer_content-->
                    
                    <div class="footer_bottom_strip">
                    	<img src="<?PHP echo $imagePath;?>footer_bottom_strip.png"/>
                    </div>
            </div><!--footer-wrapper-->
            <div class="footer_spacer"></div>
            
            
            <div class="clear"></div> 
         
    </div><!--wrapper_toad-->
    </div><!--main-->   
<script>
	renderMaxHeight();
</script>
</body>
</html>
