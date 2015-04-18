
<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>
 <div class="pt15 pl15 pb15 pr15 bg_darker bdr5_white">
<div style="padding:10px">
<div class="title-content">
	  <div class="title-content-left">
		<div class="title-content-right">
		  <div class="title-content-center">
			<div class="title-content-center-label"><?php //echo $this->lang->line('shareon');?></div><!--title-content-center-label-->			
		</div><!--title-content-center-->
	  </div><!--title-content-right-->
	</div><!--title-content-left-->
</div><!--title-content-->
<div class="clearfix"></div>
<?php 
  $urlToShare = $UrlToShare;
?>

<div id="addJS">
<script type="text/javascript" src="<?php echo base_url()?>templates/frontend/js/addthis_widget.js"></script>
</div>


<div class="addthis_toolbox addthis_default_style "
	
addthis:url="<?php echo $urlToShare ?>" 
addthis:title="A Link to my Work Profile (it will work for 15 days)"
addthis:description="">


<div class="social_icons_wp mH50">	

	 <div class="share-popup-socialbg fl mr5">
		 <span>
		<a class="addthis_button_facebook formTip"></a>
		</span>
	 </div> 

	<div class="share-popup-socialbg fl mr5">
		 <span>
		 <a class="addthis_button_twitter formTip"></a>
		  </span>
	</div>


	<div class="share-popup-socialbg fl mr5">
		  <span>
			 <a class="addthis_button_linkedin formTip"></a>
		   </span>
	</div>
	
	
	<div class="share-popup-socialbg fl mr5">
			<span>
				<a class="addthis_button_google_plusone_share formTip"></a>
			</span>
		</div>
		
		<div class="share-popup-socialbg fl mr5">
			<span>
				<a class="addthis_button_pinterest formTip" title ="Pintrest"></a>
			</span>
		</div>
		
		<div class="share-popup-socialbg fl mr5">
			<span>
				<a class="addthis_button_digg formTip"></a>
			</span>
		</div>
		
		<div class="share-popup-socialbg fl mr5">
			<span>
				<a class="addthis_button_reddit formTip"></a>
			</span>
		</div>
		
		<div class="share-popup-socialbg fl mr5">
			<span>
				<a class="addthis_button_scoopit formTip"></a>
			</span>
		</div>
		
		<div class="share-popup-socialbg fl mr5">
			<span>
				<a class="addthis_button_stumbleupon formTip"></a>
			</span>
		</div>		
		
	
</div>



</div>




<!-- AddThis Button END -->
<style>
.addthis_button_facebook .at16nc{
	background:none;
}

.addthis_button_twitter .at16nc{
	background:none;
}


.addthis_button_linkedin .at16nc{
	background:none;
}


</style>
