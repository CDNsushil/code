<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$isLoginUser = isLoginUser(); ?>
<!--  header nav  wrap  end -->
<div class="index_wrap">
   <div class="login_index   <?php echo ($isLoginUser)?"width826":"width800";?>    m_auto">
     <?php if($isLoginUser){ ?>
        <div class="width826   fl">
             <a href="" class="fl"> <img src="<?php echo $imgPath; ?>toad_new_logo.png" alt="" /> </a>
             <div class="clearbox"></div>
             <h2 class="opens_light fr pr70 fs40 lineH45"> Where creatives<br />
                and their fans<br />
                connect, inspire<br />
                and share their work 
             </h2>
        </div>
       <?php }else{ ?>
          <div class="width445  bdr_r_C7C7C7 pl10 fl">
             <a href=""> <img src="<?php echo $imgPath; ?>toad_new_logo.png" alt="" /> </a>
             <div class="sap_80"></div>
             <h2 class="opens_light fs40 lineH45">
                Where creatives<br />
                and their fans<br />
                connect, inspire<br />
                and share their work
             </h2>
          </div>
        
    
          <div class="width245 pl70  fl">
             <div class="opens_light fs20">Put up your Showcase,
                your multimedia portfolio,
                for free
             </div>
             <div class="sap_55"></div>
               
                    <a href="javascript:void(0);" onclick="javascript:openLightBox('popupBoxWp','popup_box','/auth/login');">
                        <button type="button" class="bg_f1592a radius5 fs25">Login   </button>     
                    </a>
                    <button type="button" onclick="javascript:openLightBox('popupBoxWp','popup_box','/package/termsncondition');" class=" radius5 fs16 fb_btn ">Sign in with Facebook</button>        
                    <div class="open_sans fs16 or_border" >OR</div>
                    <a href="<?php echo base_url_lang('package/index'); ?>">
                        <button type="button" class="green_btn radius5 fs25imp">Join for FREE</button> 
                    </a> 
               
          </div>
          
        <?php } ?>
   </div>
	<div class="  index_bg m_auto">
		<ul class="index_images">
			<?php 
			$totalCount = count($imageCollection);
			if(!empty($imageCollection)) {
				$counter 	= 0;
				$remainrow 	= 0;
				$remain  	= $totalCount;
			
				for( $i=0;$i<$totalCount;$i++ ) {
					$counter++;
					if($counter == 5) {
						$remainrow = $remainrow + 4; 
						$remain    = $totalCount - $remainrow;  
						$counter = 1;
					} 
				
					if($remain < 4){
						break;  
					}
					?>
					<li>
						<a href="<?php echo $imageCollection[$i]['link']; ?>">
							<img src="<?php echo $imageCollection[$i]['imagePath']; ?>" alt="" />
							<div class="hover_collection">
								<span class="display_cell width190 text_alighC fs24 opens_light">VIEW
								<?php echo $imageCollection[$i]['lableText'];?></span>
							</div>
						</a>
					</li>
					<?php 
					if($i==39){
						break;  
					}
				} 
			}?>
		</ul>
	</div>
</div>
<!--  content wrap  start end -->
<div class=" clearbox aboutme_cnt ">
   <div class="sap_60"></div>
</div>

