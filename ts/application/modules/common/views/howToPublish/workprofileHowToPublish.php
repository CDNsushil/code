<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
'name'=>'howToPublish',
'id'=>'howToPublish',
);
?>

<?php echo form_open(base_url(lang().'/media/howToPublish'),$formAttributes); ?>
	
	<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
	<div class="bdr_white bg_white position_relative">
        <div class="shadow_wp strip_absolute left165">
			<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td height="271"><img src="<?php echo site_url().'images/shadow-top.png';?>"></td>
				</tr>
				<tr>
					<td class="shadow_mid">&nbsp;</td>
				</tr>
				<tr>
					<td height="271"><img src="<?php echo site_url().'images/shadow-bottom.png';?>"></td>
				</tr>
			</tbody>
			</table>
         </div>
          
        <table cellpadding="0" cellspacing="0">
			<tr>
				<td class="publist_leftrep align_top">
					<div class="width_165 font_museoSlab font_size24 clr_a6a5a5 mt104 text_alignC">Publish...</div>
				</td>
				<td>
					<div class="width_476 pl32 pr20">
						<div class="seprator_40"></div>
						<div class="font_museoSlab font_size30 clr_f1592a lineH27 bdrb_bfbfbf">How to Publish</div>
						<div class="publish_sepshe"></div>
						<div class="clear"></div>
						<div class="seprator_30"></div>					
						
					<div class="font_opensans font_size14 clr_444">
						Your Work Profile and its attached multimedia Portfolio is published as you save.After you are happy with how your Profile looks in Preview, publish it by sending out a link to those you wish to share your work with or by pressing Print. 
						<div class="seprator_13"></div>
						The link will work for 15 days.  You can always re-send it to someone it if you need to.
						<div class="seprator_13"></div>
						Once you have a Work Profile other Toadsquare members can request it from your <a class="ulLink" href="<?php echo base_url('showcase/showcaseForm');?>">Showcase Homepage</a>.
						<div class="seprator_13"></div>
						The more information you add to your Work Profile the better it will look. You can add to, or edit it at any time; it will automatically update. 
						<div class="seprator_13"></div>
						Colleges can Recommend you by clicking on the link on your Showcase Homage; then you can add Recommendations to your Work Profile from your <a class="ulLink" href="<?php echo base_url('showcase/recommendations ');?>">Recommendations page</a> in your Showcase Homepage Administration section. 

					</div>
					<div class="clear"></div>
					<div class="seprator_35"></div>
				</div>
				</td>
			</tr>
		</table>
	</div>
           
   <?php echo form_close(); ?>

