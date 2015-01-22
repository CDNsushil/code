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
					<div class="width_165 font_museoSlab font_size24 text_alignR"><a href="#Sell" id="sell_btn"><div id="sell_div" class="how_publishPopuptbtn">
						<span class="fr width_60 font_museoSlab font_size15 tal clr_f1592a mt6 mr60">How to Sell</span></div></a></div>
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
								Before you can publish an Event or Launch you must fill in the Required Fields in:
							<div class="clear"></div>
							<div class=" seprator_7"></div>
							<div class="sale_instruction">
								<ul class="ml30">
								<li><span>Event or Launch Description.</span></li>
								<li><span>Ticket & Session Details.</span></li>
							</ul>
							<div class="clear"></div>
						</div>
						<div class="seprator_30"></div>
						<div class="row text_alignC width100percent">
							<div class="AI_table">
								<div class="AI_cell">
									<img src="<?php echo site_url().'images/how_to_publish/eventdiscription.png';?>" alt="buttons"/>
								</div>
							</div>
						</div>
						<div class="seprator_20"></div>
						<div class="font_opensans font_size14 clr_444 howpub_discrip">
							<div class="seprator_3"></div>
								To publish an Event Notification you only have to fill in Required Fields in:
							<div class="clear"></div>
							<div class=" seprator_7"></div>
							<ul class=" ml15">
								<li>Event Description.</li>
							</ul>
							<div class="clear"></div>
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
						The more information you add to your Event or Launch the better it will look. You can add news, external reviews and interviews in PR Material, and images in Promotional Material. When you have finished adding content go to your Performances & Events Index page and after you are happy with how your work looks in Preview, press Publish. 
						<div class="seprator_13"></div>
						You can add to, or edit your Event or Launch at any time; it will automatically update. Press Hide if you want to remove it from your Showcase for a while.
						<div class="seprator_13"></div>
						Remember, after your Launch to add images in Post-Launch PR Material and to send out a notification to members who bought tickets or craved your Launch.
					</div>
					<div class="clear"></div>
					<div class="seprator_35"></div>
				</div>
					</div>
					<div class="width_476 pl32 pr20" id="Sell">
						<div class="seprator_40"></div>
						<div class="font_museoSlab font_size30 clr_f1592a lineH27 bdrb_bfbfbf">How to Sell</div>
						<div class="publish_sepshe"></div>
						<div class="clear"></div>
						<div class="font_opensans font_size14 clr_444 howpub_discrip">
							<div class="seprator_3"></div>
								To sell tickets to your event, you must set up your Cart to receive payments and enter your sales information.
							<div class="clear"></div>
							<div class="font_opensans font_size14 clr_444 howpub_discrip">
							
							<div class="seprator_10"></div>
								<div class="sale_instruction">
								<ul class="ml30">
								<li><span> Fill in your <a class="ulLink" href="<?php echo base_url('dashboard/globalsettings');?>">Seller Settings</a> in your Global Settings page on your Dashboard.</span></li>
								<li> <span>Tick the Sell radio button on your Tickets & Session Details page. A few notes:</span></li></ul>									
							</div>
							<div class="seprator_10"></div>
							<ul class="ml40">
								<li>You can set the price and number of tickets available for up to 3 categories.</li>
								<li>You can set an Early Bird Offer price for each category and a date you want the offer to end.</li>
								<li>You can see your list of Attendees from your <a class="ulLink" href="<?php echo base_url('cart/sales');?>">Sales page</a> in your Cart. </li>								
							</ul>
							<div class="clear"></div>
						</div>
					<div class="seprator_35"></div>
				</div>
				</td>
					</div>
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
