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
					<div class="width_165 font_museoSlab font_size24 mt40 text_alignR"><a href="#Publish" id="publish_btn">
							<div id="publish_div" class="how_publishPopuptbtn changehow_publishbtn">
						<span class="fr width_60 font_museoSlab font_size15 tal clr_f1592a mt6 mr60">How to Publish</span></div></a></div>
					
				</td>
				<td>
					<div class="height800ScrollY">
					<div class="width_476 pl32 pr20" id="Publish">
						<div class="seprator_40"></div>
						<div class="font_museoSlab font_size30 clr_f1592a lineH27 bdrb_bfbfbf">How to Publish</div>
						<div class="publish_sepshe"></div>
						<div class="clear"></div>
						<div class="font_opensans font_size14 clr_444 howpub_discrip">
							<div class="seprator_3"></div>
								Before you can publish a Project you must fill in the Required Fields in:
							<div class="clear"></div>
							<div class=" seprator_7"></div>
							<div class="sale_instruction">
								<ul class="ml30">
								<li><span>Project Description and </span></li>
								<li><span>Uploads & Pricing.</span></li>
								</ul>
							</div>
							
							<div class="clear"></div>
						</div>
						<div class="seprator_30"></div>
						<div class="row text_alignC width100percent">
							<div class="AI_table">
								<div class="AI_cell">
									<img src="<?php echo site_url().'images/how_to_publish/projectdescription.png';?>" alt="buttons"/>
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
						The more information you add to your Project the better it will look. You can add news, external reviews and interviews in PR Material.
						<div class="seprator_13"></div>
						Filling in the fields in the Project section of Further Description creates your "cover": Your online equivalent of a book cover. In Further Description you can also tailor how each Piece will look on its Showcase page.
						<div class="seprator_13"></div>
						When you have finished adding content go to the Reviews Collection Index page and after you are happy with how your work looks in Preview, press Publish.
						<div class="seprator_13"></div>
						You can add to, or edit your Project at any time. Information relating to your Project will automatically update, but you need to individually publish each additional Piece you wish to add to your Project. Press Hide if you want to remove a Project or Piece from your Showcase for a while.
					</div>
					<div class="clear"></div>
					<div class="seprator_35"></div>
				</div>
					
					</div>
				</td>
			</tr>
		</table>
	</div>
           
   <?php echo form_close(); ?>
<script>
    /*Function for change class of publish btn */
	$("#publish_div").click(function() {
		$("#publish_div").addClass('changehow_publishbtn');
		$("#sell_div").removeClass("changehow_publishbtn");
	});
	
	 /*Function for change class of sell btn */
	$("#sell_div").click(function() {
		$("#sell_div").addClass('changehow_publishbtn');
		$("#publish_div").removeClass("changehow_publishbtn");
	});
</script>
