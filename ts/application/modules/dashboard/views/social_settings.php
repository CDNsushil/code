<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div class="TabbedPanelsContentGroup main_tab m_auto ">
	<div class="TabbedPanelsContent width635 m_auto TabbedPanelsContentVisible">
		 <div class="wra_head clearb">
			<h3 class="red   fs21 fnt_mouse bb_aeaeae">Add links to your social media sites to your Showcase and Work Profile.</h3>            
			<?php $this->load->view('socialmedia_form');?>
			<?php if(is_array($socialMediaData) && count($socialMediaData)>0) { ?>
				<div class="scoial_head  fl clearb font_weight fs15 red mt15 clearb" >
					<span class="width100 pl10"> Add to your</span>
					<span class=" width_273 text_alighC">Your Social Media Page</span>
					<span class=" width_190 text_alignC">Site</span>
				</div>
				<ul class="mt15 scoal_list billing_form defaultP">
				<?php 
					$savedViewsectionIds  = array();
					foreach($socialMediaData as $mediaData) { ?>
						<li id="socialLi<?= $mediaData->profileSocialLinkId; ?>">
							<span class=" width100 pr2 bdrR_c4c4c4 fs12 ">
								<label>
									<?php 
									$showcaseChecked = '';
									if(!empty($mediaData->showcaseId)) {
										$showcaseChecked = 'checked = checked';
										$savedViewsectionIds[] = $mediaData->profileSocialLinkId.'_1'; 
									}?>
									<input type="checkbox" name="showcase" class="addTo" value="<?= $mediaData->profileSocialLinkId.'_1'; ?>" <?= $showcaseChecked; ?> />
									Showcase
								</label>
								<label>
									<?php 
									$workProfileChecked = '';
									if(!empty($mediaData->workProfileId)) {
										$workProfileChecked = 'checked = checked';
										$savedViewsectionIds[] = $mediaData->profileSocialLinkId.'_2'; 
									}?>
									<input type="checkbox" name="workprofile" class="addTo" value="<?= $mediaData->profileSocialLinkId.'_2'; ?>" <?= $workProfileChecked; ?> />
									Work Profile
								</label>
							</span> 
							<span class=" width_252 pl13 pt5 pr12 link"> 
								<a href="<?= $mediaData->socialLink; ?>"><?= $mediaData->socialLink; ?></a>
							</span> 
							<span class="lineH30 text_alignR">
								<a href="<?= $mediaData->socialLink; ?>">
									<span class="text_alignR min_w90 pr10">
										<?= $mediaData->profileSocialMediaName; ?>
									</span> 
									<span class="mt5">
										<img src="<?php echo base_url($mediaData->profileSocialMediaPath);?>" />
									</span>
								</a>
							</span>
							 
							<span class="red pt10 fr"> 
								<a href="javascript://void(0);" onclick="editMediaLink(this)" sociallink="<?= $mediaData->socialLink; ?>" socialLinkType="<?= $mediaData->profileSocialLinkType; ?>" socialLinkId="<?= $mediaData->profileSocialLinkId; ?>"> Edit</a> 
								/ 
								<a href="javascript://void(0);" onClick="removeSocialMedia(<?= $mediaData->profileSocialLinkId; ?>)">Delete </a> 
							</span> 
					 </li>
					<?php }?>
				</ul>
				<div class="fr btn_wrap display_block font_weight mt48">
					<input type="hidden" name="viewsectionIds" id="viewsectionIds" value="">
					<?php $savedViewsectionIds = implode(',',$savedViewsectionIds);?>
					<input type="hidden" name="savedViewsectionIds" id="savedViewsectionIds" value="<?= $savedViewsectionIds;?>">
					<button class="red fr p10 bdr_a0a0a0 fshel_bold" type="button" id="saveMediaSection">Save</button>
				</div>
				<?php 
			}?>
		 </div>
		 
	</div>
</div>
<script>
	//selectBox();
   /**
	* Edit media social link data
	*/
	function editMediaLink(obj) {
		/** get all attributes of social media */
		var socialLink  = $(obj).attr('socialLink');
		var socialLinkType  = $(obj).attr('socialLinkType');
		var socialLinkId  = $(obj).attr('socialLinkId');
		$("SELECT").selectBox();
		$('#profileSocialLinkId').val(socialLinkId);
		$('#socialLink').val(socialLink);
		$('#profileSocialLinkType').val(socialLinkType);
		setSeletedValueOnDropDown('profileSocialLinkType',socialLinkType);
	}
	
   /**
    * remove social media data
	*/
	function removeSocialMedia(profileSocialLinkId) {
        confirmBox("Do you really want to delete this social link?", function () {
           var fromData = {profileSocialLinkId: profileSocialLinkId};
            $.post(baseUrl+language+'/dashboard/removeSocialMedia',fromData, function(data) {
              if(data) {
                    $('#socialLi'+profileSocialLinkId).fadeOut();		
                }
            });
        }); 
	}
	
   /**
	* Manage add to checkboxes 
	*/
	$('#saveMediaSection').click(function() {
		var savedViewsectionIds = $('#savedViewsectionIds').val();
		
		var sectionIds = [];
		$(".addTo:checked").each(function() {
			sectionIds.push(this.value);
		});
		if(sectionIds.length>0) {
			
			var form_data = {sectionIds: sectionIds,savedViewsectionIds: savedViewsectionIds};
			$.ajax
			({
				type: "POST",
				url: baseUrl+language+'/dashboard/manageMediaSection',
				data: form_data,
				success: function(data)
				{	
					if(data) {	
						window.location.href = window.location.href;	
					}
				}
			});
		} else {
			alert('Please select section first!');
		}
		return false;
	});
</script>           
