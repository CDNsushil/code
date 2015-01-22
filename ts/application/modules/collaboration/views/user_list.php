<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($like) && !empty($like)) {
	$searchValue = $like; //set value of search
} else {
	$searchValue = $this->lang->line('keywordSearch'); //set default value of search
}
?>	
<div id="userList">
	<div class="popup_box">
		<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>
		<div class="popup_gredient ">		
			<div class="row pt2 ">
				<div class="row ">
					<div class="cell tab_left width_202">
						<div class="tab_heading_global">Member List</div>
						<!--tab_heading-->
					</div>
				</div>
				<!--row-->
				<div class="clear"></div>

				<div class="form_wrapper toggle pr5 minHeight500px"  id="NEWS-Content-Box2" >
					<div class="shadow_wp strip_absolute">
						<table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%">
							<tbody>
							<tr>
								<td height="271"><img src="<?php echo base_url('images/shadow-top.png')?>"></td>
							</tr>
							<tr>
								<td class="shadow_mid">&nbsp;</td>
							</tr>
							<tr>
								<td height="271"><img src="<?php echo base_url('images/shadow-bottom.png')?>"></td>
							</tr>
							</tbody>
						</table>
					</div>

					<div class="row">
						<div class="tab_shadow tab_shadow_g"> </div>
					</div>

					<div class="shadow_sep row"> </div>
					<div class="clear"></div>
					<div class="seprator_10"> </div>
					<div class="row">
						<div class="cell">
							<div class="search_box_wrapper ml20 wp_serch_box_wrapper">
								<input id="searchSortUser" type="text" name="searchSortUser" class="search_text_box" value="<?php echo $searchValue;?>" placeholder="<?php echo $this->lang->line('searchMembers');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">		

								<div class="search_btn" onclick="getUserSortedList();"> 
									<img src="<?php echo base_url('images/btn_search_box.png')?>"> 
								</div>
							</div>
						</div>
						<!----Load user listing view---->
						<div id="showUsersList" class="cell mr12 pl10">
							<?php echo $this->load->view("user_listing_view");?>
						</div>
						<div class="clear"></div>         
					</div>
					<!--from_element_wrapper-->
				</div> <!--tab_wp-->
			</div>	
</div> <!-- popup_gredient -->
</div> <!-- popup_box -->
</div>  
  
