<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

  echo form_open('help/submit_topic', 'class="form" id="new_topic" name="new_topic"');
    if($this->uri->segment(4)){
        $catego_id= $this->uri->segment(4);
    }else{
        $catego_id = 0;
    }
    

?>

      <div class="pl20 pr20">
         <div class="fl opens_light red fs24 lineH24  pb10 bbc1c1c1 width100_per">
            New Discussion
         </div>
         <ul class="mt35 fl width100_per newdiscoussin listpb20">
            <li>
                <?php echo form_input($Title); ?>
            </li>
            <li>
               <span class="position_relative fl width335 height32">
                  
                  <?php 
                        echo form_dropdown('category', $category_options, $catego_id, 'class="width_280 required "');
                  ?> 
               </span>
            </li>
            <li>
                <?php echo form_textarea($Comments); ?>
            </li>
            
            <?php 
		if($this->ion_auth->logged_in())
		{
			if($this->ion_auth->is_admin())
			{
			echo '
			<li>
				
				<h3>'.$this->lang->line('section4Title').'</h3>
				</li>
				
				<li class="pb10_imp"><div class="defaultP">'.form_checkbox($Sticky).'</div>'.$this->lang->line('sticky').''.$this->lang->line('newTopicHintSticky').'</li>
				<li class="pb10_imp"><div class="defaultP">'.form_checkbox($Close).'</div>'.$this->lang->line('close').''.$this->lang->line('newTopicHintClosed').'</li>';
			}
			if($this->ion_auth->is_group('moderators'))
			{
				if($modsStickyDiscussions == '1' || $modsCloseDiscussions == '1')
				{
					echo '
					<li>
						<h3>'.$this->lang->line('section4Title').'</h3>';
							if($modsStickyDiscussions == '1')
							{
								echo ''.form_checkbox($Sticky).''.$this->lang->line('sticky').''.$this->lang->line('newTopicHintSticky').'<br>';
							}
							if($modsCloseDiscussions == '1')
							{
								echo ''.form_checkbox($Close).''.$this->lang->line('close').''.$this->lang->line('newTopicHintClosed').'<br>';                        
							}
					echo '</li>';
				}
			}
			if($this->ion_auth->is_group('members'))
			{
				if($canStickyDiscussions == '1' || $canCloseDiscussions == '1')
				{
					/*echo '
							<div id="oneLineDescription" class="cell label_wrapper_topic">
								<label class=""> '.$this->lang->line('section4Title').' </label>
							</div>';*/
						/*echo '<li>';


							if($canStickyDiscussions == '1')
							{
							  //  echo '<div class="defaultP">'.form_checkbox($Sticky).''.$this->lang->line('sticky').'</div>'.$this->lang->line('newTopicHintSticky').'<br>';
							}
							if($canCloseDiscussions == '1')
							{
								//echo '<div class="defaultP">'.form_checkbox($Close).''.$this->lang->line('close').'</div>'.$this->lang->line('newTopicHintClosed').'<br>';                        
							}
					echo '</li>'; */               
				}
			}
		}
		
		?>	
            
            
            <li class="btn_wrap"><button type="submit"  class="red fr bg_fff">Post</button></li>
         </ul>
         <div class="sap_20 clearb"></div>
      </div>
          
<?php echo form_close(); ?>
         
<script type="text/javascript">
     $(document).ready(function() {
        // validate the comment form when it is submitted
       $("#new_topic").validate({ });
     });  
</script>
