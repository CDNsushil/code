<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>
<div class="popup_gredient ">
      <div class="width_545">
        <div class="joinpopup_msg_box"> <div class="Fright mr13"><img alt="logo" src="<?echo base_url()?>images/join-popup_logo.png"></div> <div class="clear"> </div></div>
       
        <div class="pop_bdr"></div>
        <div class="position_relative">
			<div class="seprator_27"></div>
			<div class="font_opensans clr_666 font_size13">             
				<div class="row">
					<div class="defaultP pl25 pr_54">
						<div class="font_opensans mediaupload_popup width500px">
							<ul class=" ml15">
								<li>To make your Showcase look better add more information in <a href="<?php echo site_url(lang()).'/media/'.$industryType.'/editProject/furtherDescription/'.$projectId;?>" class="orange">Further Description</a> or <a href="<?php echo site_url(lang()).'/media/'.$industryType.'/editProject/additionalInformation/'.$projectId;?>" class="orange">PR Material</a>.</li>
								<li>You can Preview and Publish from the <a href="<?php echo site_url(lang()).'/media/'.$industryType.'/'.$projectId;?>" class="orange">Index</a> page.</li>
								<li>
									<a href="javascript:void(0)" onclick="$(this).parent().trigger('close');" class="orange">Upload</a>
									 more content. If you want to sell this work, fill in the 
									<a href="javascript:void(0)" onclick="$(this).parent().trigger('close');">Sales section</a> and make sure your 
									<a href="<?php echo site_url(lang()).'/dashboard/globalsettings';?>">Seller Settings</a> are up to date.
								</li>
							</ul>
						</div>
					</div>
				</div>  
			</div>
			<div class="clear"> </div>
        </div>
        <div class="seprator_27 clear"></div>
    </div>
    </div>
