
  
  <div id="theme_display" >
	<?php			
			$form_attributes = array('name'=>'theme_form','id'=>'theme_form');
			echo form_open('admin_theme/update_theme',$form_attributes);		
			foreach($theme_options as $theme_data)
			{?>				
				<div class='theme'>
					<div><img src="<?php echo PROFILE_IMG.strtolower($theme_data->theme).'.jpg';?>" /></div>
					
						<?php
						if($theme_active==$theme_data->id) { 
							echo "<input type='radio' name='theme' id='theme' value='".$theme_data->id."' checked > ".$theme_data->theme;
						} else { 
							echo "<input type='radio' name='theme' id='theme' value='".$theme_data->id."' > ".$theme_data->theme;
						}?>								
					
				</div>
			<?php }	?>
			
			<div class="RightClMBoxSP3"> <span><a href="#"><input type="image" src="<?php echo PROFILE_IMG; ?>save.png" title="Save" class="tooltipClass" /></a></span>
			<span><a href="#"><img src="<?php echo PROFILE_IMG; ?>preview.png" title="Preview" onClick="set_theme_session()" /></a></span></div>
		<?php 				
			echo form_close();
		?>
		<div class="clear"></div>
  </div>
  
  <div class="borderShedow"></div>
