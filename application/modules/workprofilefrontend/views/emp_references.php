<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
 
	<!----<div class="width_506 pl25">
                   
                    <?php 
                    
                 if(isset($refrences) && !empty($refrences) ) {
                     foreach($refrences as $ref) { ?>
                    
							<div class="mb15">
							  <div class="bdr_4b4b4b bg_373737 pl10 pr10 pt10 pb15 clr_989898 font_opensansSBold ">
								<div class="bdr_B616161 font_size13 lineH16">
								  <div class="cell width175px ml24"><?php echo $this->lang->line('name');?></div>
								  <div class="cell width273px clr_white font_arial">
									    <b>
											<?php  if(isset($ref->refFName) && !empty($ref->refFName))
											{ echo $ref->refFName .' '. $ref->refLName ;} ?>										
											
										</b></div>
										
								  <div class="clear"></div>
								</div>
								<div class="seprator_15"></div>
								<div class="row pt3">
								  <div class="cell width175px ml24"><?php echo $this->lang->line('company');?></div>
								  <div class="cell width273px orange_clr_imp"><?php if(isset($ref->refCompName))echo $ref->refCompName ?></div>
								  <div class="clear"></div>
								</div>
								<div class="row pt3">
								  <div class="cell width175px ml24"><?php echo $this->lang->line('profileEmail');?></div>
								  <div class="cell width273px clr_white"><?php if(isset($ref->refEmail))echo $ref->refEmail ?></div>
								  <div class="clear"></div>
								</div>
								<div class="row pt3">
								  <div class="cell width175px ml24"><?php echo $this->lang->line('phoneNo');?></div>
								  <div class="cell width273px clr_white"><?php if(isset($ref->refContact) && !empty($ref->refContact) )echo '+ '.$ref->refContact ?></div>
								  <div class="clear"></div>
								</div>
							  </div>
							  <div class="line_BW mt18 ml10 mr10"></div>
							</div>
                    
              <?php } } ?>
                  
        </div> -->
                  
 
<div class="width_506 pl25 mt_minus11 pb10">
	
	
			<div class="slider pb3 recomend_btn_place_refrence" id="referenceSlider">
				 <a href="#" class="buttons left_293 prev mr2 disable"></a>
			     <a href="#" class="buttons left_293 next mr2"></a>
			  <div class="viewport CSEprisebottom_scroll_container width506px height_475px">
				<ul class="overview" >
				  		<?php 
                    
                 if(isset($refrences) && !empty($refrences) ) {
                     foreach($refrences as $ref) { ?>
                    <li class="width506px pb15">
							<div class="mb15">
							  <div class="bdr_4b4b4b bg_373737 pl10 pr10 pt10 pb15 clr_989898 font_opensansSBold ">
								<div class="bdr_B616161 font_size13 lineH16">
								  <div class="cell width175px ml24"><?php echo $this->lang->line('name');?></div>
								  <div class="cell width273px clr_white font_arial">
									    <b>
											<?php  if(isset($ref->refFName) && !empty($ref->refFName))
											{ echo $ref->refFName .' '. $ref->refLName ;} ?>										
											
										</b></div>
										
								  <div class="clear"></div>
								</div>
								<div class="seprator_15"></div>
								<?php if(!empty($ref->refCompName)) {?>
								<div class="row pt3">
								  <div class="cell width175px ml24"><?php echo $this->lang->line('company');?></div>
								  <div class="cell width273px orange_clr_imp"><?php if(isset($ref->refCompName))echo $ref->refCompName ?></div>
								  <div class="clear"></div>
								</div>
								<?php } if(!empty($ref->refEmail)) {?>
								<div class="row pt3">
								  <div class="cell width175px ml24"><?php echo $this->lang->line('profileEmail');?></div>
								  <div class="cell width273px clr_white"><?php if(isset($ref->refEmail))echo $ref->refEmail ?></div>
								  <div class="clear"></div>
								</div>
								<?php }
								 if(!empty($ref->refContact)) {?>
								<div class="row pt3">
								  <div class="cell width175px ml24"><?php echo $this->lang->line('phoneNo');?></div>
								  <div class="cell width273px clr_white"><?php if(isset($ref->refContact) && !empty($ref->refContact) )echo '+ '.$ref->refContact ?></div>
								  <div class="clear"></div>
								</div>
								<?php }?>
							  </div>
							  <div class="line_BW mt18 ml10 mr10"></div>
							</div>
           
                    </li>
              <?php } } ?>	 
				 </ul>
			  </div>
			   </div>
 </div>


 
 <script type="text/javascript">
	$(document).ready(function(){
		if($('#referenceSlider'))	
		$('#referenceSlider').tinycarousel({ axis: 'y', display: 3, start:1});	
		
		if($('#AMslider'))	
		$('#AMslider').tinycarousel();	
	});
</script>    
