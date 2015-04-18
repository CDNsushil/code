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
						<div class="font_opensans font_size14 clr_444 howpub_discrip">
							<div class="seprator_3"></div>
								Before you can publish anything else, you must publish your Showcase Homepage. Once published your Homepage cannot be removed from the site, unless you delete your account from <a class="ulLink" href="<?php echo base_url('dashboard/globalsettings');?>">General Settings</a>. 
								<div class="seprator_13"></div>
								To publish your Homepage you must first fill in the Required Fields in:
							<div class="clear"></div>
							<div class=" seprator_7"></div>
							<ul class=" ml15">
								<li>Description.</li>
							</ul>
							<div class="clear"></div>
						</div>
						<div class="seprator_30"></div>
						<div class="row text_alignC width100percent">
							<div class="AI_table">
								<div class="AI_cell">
									<img src="<?php echo site_url().'images/how_to_publish/pub_des.png';?>" alt="buttons"/>
								</div>
							</div>
						</div>
						<div class="seprator_20"></div>
						<div class="publish_sepshe"></div>
						<div class="row text_alignC width100percent">
							<div class="AI_table">
							<div class="AI_cell">
								<img src="<?php echo site_url().'images/how_to_publish/magnifireeffect.png';?>" alt="buttons"/>
							</div>
						</div>
					</div>

					<div class="row pl66">
						<div class="Req_fld font_arial font_size11 clr_676767 mt0">Required Fields</div>
					</div>
					<div class="seprator_6"></div>
					<div class="publish_sepshe"></div>

					<div class="font_opensans font_size14 clr_444">
						The more information you add to your Homepage the better it will look. You can add two videos, news and external reviews in <a class="ulLink" href="<?php echo base_url('showcase/additionalInfoForm');?>">PR Material</a>, and links to other sites in <a class="ulLink" href="<?php echo base_url('showcase/socialMedia');?>">Social Media Links</a>. After you are happy with how your Homepage looks in Preview, press Publish.
						<div class="seprator_13"></div>
						You can add to, or edit your Homepage at any time; it will automatically update.
						<div class="seprator_13"></div>					 
						If you want to add a multilingual element to your Showcase, you an put up the front page of your Showcase Homepage in a different language using the Multilingual Showcase Homepage Tool on your <a class="ulLink" href="<?php echo base_url('dashboard');?>">Dashboard</a>. Then in other sections you can enter your information, in each field, in more than one language. <a class="ulLink" href="<?php echo base_url('tips/front_tips/25');?>">(See our Tips page: Multilingual Communication: Found in Translation.)</a>

					</div>
					<div class="clear"></div>
					<div class="seprator_35"></div>
				</div>
				</td>
			</tr>
		</table>
	</div>
           
   <?php echo form_close(); ?>

