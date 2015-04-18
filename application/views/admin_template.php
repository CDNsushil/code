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
						echo   $this->lang->line('welcome').'&nbsp;<b>Admin</b>&nbsp;</b>';
						?>
					</span>
                    
        
                </div><!--header_right-->
                
            </div><!--header_toad-->
            
            <div class="clear"></div>
            
            <div class="nav_toad">
            		<div class="nav_left">
						<ul>
							<li><a class="comingSoon" href="javascript:void:none">Dashboard</a> </li>
							<li><a class="comingSoon" href="javascript:void:none">Users</a> </li>
							<li><a class="comingSoon" href="javascript:void:none">Categories</a> </li>
							<li><a class="comingSoon" href="javascript:void:none">Discussions</a> </li>
							<li><a class="comingSoon" href="javascript:void:none">Visit Site</a> </li>
							
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
					
					$class_right='right_coloumn';
				?>
					<div class="left_coloumn">
					
							
						<div class="user_name_wp">
			
							
							<div class="artist_type">
									<h1>Administrator</h1>
							</div><!--artist_type-->
							
		
						</div><!--user_name_wp-->
						<div class="Left_side_menu">
								<ul>
									<li class="<?php echo @$select_homeindex;?>"> 
										<a href="<?php echo base_url(lang().'/admin/'); ?>" class="nav_dashboard"><?php echo $this->lang->line('dashboard'); ?></a>
									</li>									

								<!-------------  User Section  ------------------>
									<li class="<?php echo @$select_homeindex;?>"> 
											<a  href="<?php echo base_url(lang().'/admin/users/manage/');?> " class="nav_dashboard" href="javascript:void:none" class="nav_dashboard" >
												<?php echo $this->lang->line('users'); ?>
											</a>
									</li>		
							
														
									<li class="<?php echo @$select_homeindex;?>"> 
										<a href="<?php echo base_url(lang().'/admin/users/add_new/'); ?>"><?php echo $this->lang->line('addNewUser'); ?></a>
									</li>									

						<!-------------  Categories Section  ------------------>
									<li class="<?php echo @$select_homeindex;?>"> 
											<a  href="<?php echo base_url(lang().'/admin/categories/manage/');?> " class="nav_dashboard" href="javascript:void:none" class="nav_dashboard" >
												<?php echo $this->lang->line('categories'); ?>
											</a>
									</li>									
						
									<li class="<?php echo @$select_homeindex;?>"> 
										<a href="<?php echo base_url(lang().'/admin/categories/requested/');?>"> <?php echo $this->lang->line('catReqCat'); ?></a>
									</li>									

																		
									<li class="<?php echo @$select_homeindex;?>"> 
										<a href="<?php echo base_url(lang().'/admin/categories/add_new/');?>"> <?php echo $this->lang->line('addNewCategory'); ?></a>
									</li>									

						<!-------------  Discussion Section  ------------------>
									<li class="<?php echo @$select_homeindex;?>"> 
										<a href="<?php echo base_url(lang().'/admin/discussions/manage/');?>" class="nav_dashboard"> <?php echo $this->lang->line('discussions'); ?></a>
									</li>		
																
						<!-------------  Sub Category Request Section  ------------------>
									<!-- <li class="<?php echo @$select_homeindex;?>"> 
										<a href="<?php echo base_url(lang().'/admin/catrequest/manage/');?>" class="nav_dashboard"> <?php echo $this->lang->line('catrequest'); ?></a>
									</li> -->									
									
		

						</ul>
						
						<div class="clear"></div>	
						</div><!--Left_side_menu-->
						
						<div class="clear"></div>
						<div class="down_shadow"></div>
							
				 </div><!--left_coloumn-->
				<?php
            }?>        
			<div class="<?php echo $class_right;?>">
				
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
