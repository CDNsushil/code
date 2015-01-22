<div id="header">
	<div class="header_toad">
            	<img src="<?php echo base_url() ?>assets/images/logo_toad.png" class="toad_logo"/>
                
                <div class="header_right">
                	            
                        
                    <span class="icon_search"><a href="#"><img src="<?php echo base_url() ?>assets/images/icon_search.png"/></a></span> 
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
                    
                    <div class="search_box_wrapper 11">
                    	<input type="text" class="search_text_box" value="Keyword Search..." />
                        <div class="search_btn">
                        <img src="<?php echo base_url() ?>assets/images/btn_search_box.png"  />
                        </div>
                  </div><!--search_box_wrapper-->
                </div><!--header_right-->
                
            </div><!--header_toad-->
</div>
<div class="clear"></div>
<br> 
            <div class="nav_toad" style="float:left;margin-left:125px;">
			</div>
      <!--      <div class="clear"></div>
            
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
							<li><a class="comingSoon" href="javascript:void:none"><?php echo $this->lang->line('forums')?></a></li>
						</ul>
                    </div>
                    
            </div>
            -->
            <!--nav_toad-->
		
