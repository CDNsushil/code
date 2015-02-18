<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//echo '<div class="frm_heading_wp pb10"><div class="summery_right_archive_wrapper  absolute_heading "> <h1>'.$this->lang->line('newTopicHeader').'</h1> </div></div>';
echo form_open('help/submit_topic', 'class="form"');
echo '<div class="edit_post_wp">';

if($this->uri->segment(4))
		{
			$catego_id= $this->uri->segment(4);
		}else
		{
			$catego_id = 0;
		}

?>

<div class="seprator_14"></div>
  <div class="bdr_d2d2d2 Contact_form_topbox">
  
  <div class=" font_opensans font_size18 clr_666 pt5 pl15 lineH_30"><?php echo $this->lang->line('newTopicHeader');?></div>
  <div class="seprator_7"></div>
  <div class="position_relative overflow_h pb20">
  <div class="cell shadow_wp strip_absolute left_145">
      <!-- <img src="images/strip_blog.png"  border="0"/>-->
     <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
          <tr>
            <td height="42"><img src="<?php echo  base_url();?>images/subcategory_vshedow_t.png"></td>
          </tr>
          <tr>
            <td class="shadow_mid_small_subcate_popup">&nbsp;</td>
          </tr>
          <tr>
            <td height="42"><img src="<?php echo  base_url();?>images/subcategory_vshedow_b.png"></td>
          </tr>
        </tbody>
      </table>
      <div class="clear"></div>
    </div>
  
  	<!--<div class="cell width_158">
    <div class="seprator_13"></div>
    	<div class="text_alignC font_opensans font_size18">Request a Subcategory</div>
        <div class="seprator_20"></div>
        <div class="w69_h66 margin_auto"><div class="AI_table"><div class="AI_cell"><img src="images/temp_contact_thumb.jpg" class="Contact_form_thumb" /></div></div></div>
    </div>-->
    
    <div class="cell">
  <!-- row01-->
    	<div class="row pt7">
            <div class="contact_label_subcate_popup_new_post_request cell">
              <label class="select_field"><?php echo $this->lang->line('section1Title'); ?></label>
            </div>
            <div class="cell contact_frm_element_wrapper width_250">
             <?php echo form_input($Title); ?>
            </div>
          </div>
           <!-- row01-->
           <div class="clear"></div>
           <div class="seprator_6"></div>
    	<div class="row">
            <div class="contact_label_subcate_popup_new_post_request cell">
              <label class="select_field labe_aerow"><?php echo $this->lang->line('searchTag'); ?></label>
            </div>
            <div class="cell contact_frm_element_wrapper width_250">
              <?php echo form_input($Search_tag); ?>
            </div>
          </div>
        <div class="row">
            <div class="contact_label_subcate_popup_new_post_request cell">
              <label class="select_field labe_aerow"><?php echo $this->lang->line('section2Title'); ?></label>
            </div>
            <div class="cell contact_frm_element_wrapper width_250">
            <?php echo form_dropdown('category', $category_options, $catego_id, 'class="width250px "'); ?>  
            </div>
          </div>  
           <!-- row02-->
    </div>
    <div class="clear"></div>
  </div>
  </div>
  
    <div class="seprator_14"></div>
    
    <div class="row">
      <div class="cell"></div>
      <div class="cell"></div>
    </div>
  
</div>


<div class="page_list">
	<ul class="ul_relative">
	  
		<div class="ml5">
		
		 <div class="cell label_wrapper_topic" id="oneLineDescription">
				<label class="select_field_topic"> <?php //$this->lang->line('enterPost'); ?> </label>
		</div>
		
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
				
				<li class="padding_0"><div class="defaultP">'.form_checkbox($Sticky).'</div>'.$this->lang->line('sticky').''.$this->lang->line('newTopicHintSticky').'</li>
				<li class="padding_0"><div class="defaultP">'.form_checkbox($Close).'</div>'.$this->lang->line('close').''.$this->lang->line('newTopicHintClosed').'</li>';
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
					/*echo 		'<li>';


							if($canStickyDiscussions == '1')
							{
							  //  echo '<div class="defaultP">'.form_checkbox($Sticky).''.$this->lang->line('sticky').'</div>'.$this->lang->line('newTopicHintSticky').'<br>';
							}
							if($canCloseDiscussions == '1')
							{
							//	echo '<div class="defaultP">'.form_checkbox($Close).''.$this->lang->line('close').'</div>'.$this->lang->line('newTopicHintClosed').'<br>';                        
							}
					echo '</li>';  */              
				}
			}
		}
		
		echo '<li><div class="Req_fld cell">'.$this->lang->line('RequiredFields').'</div> <div class="tds-button fr"><button onclick="submitform();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value="Save" name="save"><span class="text-indent_0">'.$this->lang->line('PostDiscussion').'</span></button></div>';
			
		echo '<div class="clear">&nbsp;</div>';
		?>		
		   
		</li>
	</div>

	</ul>
</div>
<?php form_close(); ?>
