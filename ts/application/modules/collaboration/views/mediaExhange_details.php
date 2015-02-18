<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>

	<div class="popup_gredient ">
	  <div class="row pt15 pb15 pr10 pl10 ">
		<div class="cell width450px ">
		  
		  <div class="blog_profile_title dash_link_hover"><?php  echo $title; ?></div>
		  <div class="blog_profile_date ml0 pb10"><?php  echo date("d F Y", strtotime($fileCreateDate)); ?></div>
		  
		  <div class="blog_profile_txt"><?php  echo $description; ?></div>
		  <div class="clear seprator_10"></div>
		  <div class="row">
				<div class="cell b">Notified Members: </div>
				<div class="cell pl20" >
					<div class="row" >
						<?php 
						if(isset($members) && is_array($members) && count($members) > 0){
								foreach($members as $k=>$member){
									$memberName = ($member['enterprise'] == 't')?$member['enterpriseName']:$member['firstName'].' '.$member['lastName'];
									echo '<div class="cell pr10" >';
										echo  $memberName;
									echo '</div>';
								}
						}else{
							echo '<div class="cell">All Mebers</div>';
						}
						?>
					</div>
				</div>
			</div>
			
		  
		</div>
		<div class="clear seprator_13"></div>
	  </div>
	</div>

</div>
