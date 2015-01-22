<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if($associatedmembers && is_array($associatedmembers) && count($associatedmembers)>0){
	?>
	<div class="bdr_Bwhite seprator_1"></div>
	<div class="Fleft width_165 height_16"></div>
	  <div class="Fleft width_610">
		<div class="seprator_29"></div>
		<div class="CSEprise_frame mr10">
		  <div class="bg_f7f6f4 global_shadow_light">
			<div class="p15  pb0">
			  <div class="pt7 CSEprise_asso_mem_scroll_btn_box slider" id="AMslider"> 
				 <div class="viewport CSEprise_asso_mem_scroll_container">
					<ul class="overview">
					  <?php 
						foreach($associatedmembers as $ak=>$data){
							$userImage='media/'.$data->username.'/profile_image/'.$data->profileImageName;
							$userImage=(($data->stockImageId>0)?$data->stockImgPath.'/'.$data->stockFilename:$userImage);
							$userImage=getImage($userImage,'user');
							$writerName=$data->firstName.' '.$data->lastName;
							$creativeArea=$data->optionAreaName;
							
							if(($ak > 0)&& ($ak%4==0)){
									echo "</li><li>";
							}
							elseif(($ak%4)==0){
								
								echo "<li>";
							}
							
							?>
							  <div class="pb15">
								<div class="CSEprise_asso_mem_thumb">
								  <img src="<?php echo $userImage;?>">
								</div>
								<div class="cell width_412 clr_444 pl20 pt10 ">
								  <div class="CSEprise_memT bdr_Borange clr_Lblack"><?php echo getSubString($writerName,50);?></div>
								  <div class=" font_opensans font_size13 Fright clr_Lblack"><?php echo get_timestamp('F Y',$data->created_date) ;?></div>
								  <div class="clear"></div>
								  <div class="CSEprise_asso_mem_subBox"><?php echo getSubString($creativeArea,50);?></div>
								</div>
								<div class="clear seprator_15"></div>
								<div class="line5"></div>
							  </div>
							<?php
							if(($ak+1) == count($associatedmembers)){
								echo "</li>";
							}
						}?>
				 	</ul>
			</div>
			
			 <div class="position_relative">
				<div class="z_index_2 position_relative"> <a class="buttons next" href="#"></a><a class="buttons prev disable" href="#"></a> </div>
				<!--FAKEDIV-->
				<div class="fakebtn z_index_1"> <span class="buttons next "></span><span class="buttons prev "></span> </div>
			  </div> 
			  
			  <div class="text_indent0 Fleft ml6 "> <a class="veiw_gallary_btn" onmouseup="mouseup_viewG_btn(this)" onmousedown="mousedown_viewG_btn(this)">
			 <div class="text_alignC ptr" onclick="history.go(-1);">Close</div>
			
		   </a> </div>
		   <div class="clear seprator_5"></div>
			  </div>
			</div>
		  </div>
		</div>
		<div class="seprator_20"></div>
	  </div>
	  <div class="clear"></div>

	<?php
}else{
	//echo $this->lang->line('noRecord');
}?>
