
<div class="row">
      <div class="cell frm_heading">
        <h1>Dashboard</h1>
      </div>
	<div class="cell frm_element_wrapper pt1">						   
		<div class="tds-button-big Fright"><a href="<?php echo base_url(); ?>package/information/" onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)"><span>Membership</span></a></div>					   
			<div class="tds-button-big Fright"> 
				<a href="<?php echo base_url(); ?>dashboard/globalsettings" onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)"><span>Global Settings</span></a>  
			</div>
		<div class="row line1 mr3"></div>   								
	
	</div>	
</div>

<div class="clear"></div>
<div class="row seprator_5"></div>
<?php
if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ ?>
	
	<div class="row">
	<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>media/musicNaudio"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>media/musicNaudio">MUSIC &amp; AUDIO</a> </div>
			</div><!--liquid_box_wrapper-->
			
			
	<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>media/filmNvideo"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid"></td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>media/filmNvideo">FILM &amp; VIDEO</a> </div>
			</div><!--liquid_box_wrapper-->
			
			
	<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
		<table cellspacing="0" cellpadding="0" border="0">
			<tbody><tr>
				<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
				<td class="liquid_top_mid1">&nbsp;</td>
				<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
			</tr>
			<tr>
				<td class="liquid_mid1">&nbsp;</td>
				<td><a href="<?php echo base_url(); ?>media/writingNpublishing"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
				<td class="liquid_mid2">&nbsp;</td>
			</tr>
			<tr>
				<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
				<td class="liquid_bottom_mid">&nbsp;</td>
				<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
			</tr>
		</tbody></table>
		<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>media/writingNpublishing">WRITING &amp; PUBLISHING</a> </div>
	</div><!--liquid_box_wrapper-->
			

	<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>media/photographyNart"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>media/photographyNart">PHOTOGRAPHY &amp; ART</a> </div>
			</div><!--liquid_box_wrapper-->


		<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>media/educationMaterial"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>media/educationMaterial">EDUCATIONAL MATERIAL</a> </div>
			</div><!--liquid_box_wrapper-->
			
			
			<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>blog/index"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>blog/index">BLOGS</a> </div>
			</div><!--liquid_box_wrapper-->
			
			
			<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>event"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>event">EVENTS</a> </div>
			</div><!--liquid_box_wrapper-->
			
			
			<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>upcomingprojects"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>upcomingprojects">UPCOMING PROJECTS</a></div>
			</div><!--liquid_box_wrapper-->
			
			
			<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="javascript:void:none" class="comingSoon"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="javascript:void:none" class="comingSoon">COLLABORATION</a> </div>
			</div><!--liquid_box_wrapper-->
			
			
			<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>work"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>work">WORK</a> </div>
			</div><!--liquid_box_wrapper-->
			
			
			<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>product/sell"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>product/sell">PRODUCTS</a></div>
			</div><!--liquid_box_wrapper-->
			
			<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a class="comingSoon" href="javascript:void:none"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a class="comingSoon" href="javascript:void:none">RECOMMENDATION</a> </div>
			</div><!--liquid_box_wrapper-->
			
			
			<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>tmail"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>tmail">MESSAGE CENTER</a> </div>
			</div><!--liquid_box_wrapper-->
			
			
			<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>dashboard/membership"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a href="<?php echo base_url(); ?>dashboard/membership">MEMBERSHIP</a> </div>
			</div><!--liquid_box_wrapper-->
			
			<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a class="comingSoon" href="javascript:void:none"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a class="comingSoon" href="javascript:void:none">CART</a> </div>
			</div><!--liquid_box_wrapper-->
			
			
			<div class="liquid_box_wrapper" style="float:left; padding: 6px;">
				<table cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top1.png"></td>
						<td class="liquid_top_mid1">&nbsp;</td>
						<td valign="top"><img src="<?php echo base_url(); ?>images/liquied_top3.png"></td>
					</tr>
					<tr>
						<td class="liquid_mid1">&nbsp;</td>
						<td><a href="<?php echo base_url(); ?>event/usermeetingpoint"><img border="0" src="<?php echo base_url(); ?>images/video.png" class="maxWidth165px maxHeight200px"></a></td>
						<td class="liquid_mid2">&nbsp;</td>
					</tr>
					<tr>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom1.png"></td>
						<td class="liquid_bottom_mid">&nbsp;</td>
						<td><img src="<?php echo base_url(); ?>images/liquied_bottom3.png"></td>
					</tr>
				</tbody></table>
				<div class="liquid_box_shadow" style="text-align:center;"><a  href="<?php echo base_url(); ?>event/usermeetingpoint">MEETING PLACE</a> </div>
			</div><!--liquid_box_wrapper-->
	</div>
<?php
}
else{
	$showcaseInfo=$this->load->view('showcase/showcase_info','',true);
	 ?>
	 <script>var showcaseInfo=<?php echo json_encode($showcaseInfo);?>;</script>
	<div class="row pl10"><img class="ptr" src="<?php echo base_url('images/dashboard_guest_image.jpg');?>" onclick="loadPopupData('popupBoxWp','popup_box',showcaseInfo)" /></div>	
<?php
}
?>
