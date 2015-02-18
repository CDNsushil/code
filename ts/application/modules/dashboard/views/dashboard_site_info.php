<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?> 
 <div class="fr width230 ml8">
                    	<div class="row"><div class="font_museoSlab font_size19 clr_f1592a ml28 mt6">Site Information</div></div>
                        <div class="seprator_10"></div>
                        <div class="row">
                        	<div class="img_containebox img_containeboxSLeft pt22 pl2 width224 fr">
								<div class="imgcontainer position_relative width110">
									<a href="<?php echo base_url(lang().'/tips/front_tips');?>">
										<div class="dash_photo_box_S ml17"> <img src="<?php echo base_url();?>images/default_thumb/Tips_110x73.jpg" alt="shoppingcart_1"/></div>
									 </a>	
								</div>
                              
								<div class="imgcontainer position_relative width110">
									<a href="<?php echo base_url(lang().'/package/information');?>">	
										<div class="dash_photo_box_S ml14"> <img src="<?php echo base_url();?>images/default_thumb/Members-Information_110x73.jpg" alt="buytool"/></div>
									 </a>
								</div>                 
                            </div><!-- /img_containebox -->
                            
                            <div class="clear"></div>
                        </div>
                    </div>
                    
                    
                    <div class="fr width230 ml8">
                    	<div class="row"><div class="font_museoSlab font_size19 clr_f1592a ml28 mt6">Work</div></div>
                       <div class="seprator_10"></div>
                        <div class="row">
							
                        	<div class="img_containebox img_containeboxSLeft fr pt22 pl2 width224">
								<a href="<?php echo base_url(lang().'/work/workApplicationsReceived');?>">
									<div class="imgcontainer position_relative width110">
										<div class="dash_photo_box_S ml17"> <img src="<?php echo base_url();?>images/dashboard_images/Apllications-Received_110x73.jpg" alt="shoppingcart_1"/></div>
									</div>
								</a>
                                
                                <?php if($workApplicationsSentCount > 0){ ?>
								<a href="<?php echo base_url(lang().'/work/workAppliedFor');?>">
								<?php } else { ?>
								<a href="#">
								<?php }?>
                                <div class="imgcontainer position_relative width110">
                                	<div class="dash_photo_box_S ml14"> <img src="<?php echo base_url();?>images/dashboard_images/Apllications-Sent_110x73.jpg" alt="buytool"/></div>
                                </div>
                                </a>

                            </div><!-- /img_containebox -->
                            
                            <div class="clear"></div>
                        </div>
                    </div>
                    
                    <div class="fr width230 ml8">
                    	<div class="row"><div class="font_museoSlab font_size19 clr_f1592a ml28 mt6">Purchases</div></div>
                       <div class="seprator_10"></div>
                        <div class="row">
                        	<div class="img_containebox img_containeboxSLeft fr pt22 pl2 width224">
								<div class="imgcontainer position_relative width110">
									<a href="<?php echo base_url(lang().'/cart/wishlist');?>">	
										<div class="dash_photo_box_S ml17"> <img src="<?php echo base_url();?>images/dashboard_images/pixelShopping72x108.jpg" alt="shoppingcart_1"/></div>
									</a>
								</div>
                                                   
								<div class="imgcontainer position_relative width110">
									<a href="<?php echo base_url(lang().'/package/buytools');?>">	
										<div class="dash_photo_box_S ml14"> <img src="<?php echo base_url();?>images/dashboard_images/pixelMembersTools72x108.jpg" alt="buytool"/></div>
									</a>
								</div>
                            </div><!-- /img_containebox -->
                            
                            <div class="clear"></div>
                        </div>
                    </div>
