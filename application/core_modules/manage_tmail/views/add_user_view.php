<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="slider" id="userMsgSlider">
	<a href="#" class="buttons prev mr2 disable"></a>
	<div class="viewport CSEprisebottom_scroll_container height_475px">
		
		<ul class="overview" >
			<?php if(isset($users) && is_array($users)  && count($users) > 0 ){
			foreach ($users as $user_i =>$user_detail){ 
				if(isset($user_detail['authuid']) && !empty($user_detail['authuid'])){
				?>
				<li class="pr">
					<div class="row ml15 mH40 pa">
						<div class="cell ml15 mt10">
							<div class="pa right4 defaultP top6"> 
								<input type="checkbox" class="case" name="userCheck[]" id="userCheck" value="<?php echo $user_detail['authuid'] ?>" onclick="setValInTo()"/>
							</div>
						</div>
						
						<div class="cell ml10 mt10">
							<div class="mH40">
								<div class="fl width_240 ml2">
									<div class="ml30 pt3 pb3 mt-8">
										<div class="fl font_size14 width220px">
											<?php echo $user_detail['firstName'].' '. $user_detail['lastName'];?>
										</div>
										<div class="fr font_size12"></div>
										<div class="clear"></div>
									</div>
									
								</div>
							</div>
						</div>
					
					</div>
					<div class="clear"></div>
				</li>
				<?php } } }?>	
			<div class="clear"></div> 
		</ul>
	</div>
	<div class="clear"></div>
	<a href="#" class="buttons next mr2"></a>
	</div>    
	
<script type="text/javascript">    
	runTimeCheckBox();   										
</script>
