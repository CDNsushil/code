<div class="contactBoxWp dn" id="contactBoxWp">
	<div onclick="$(this).parent().trigger('close');" class="tip-tr close-customAlert" id="close-contactlightBox" original-title=""></div>
	<div id="contactContainer" class="contactContainer"></div>
</div>        

<div class="row">
	<div class="label_wrapper cell bg-non">
		<div class="search_box_wrapper">
			<?php //$formAttributes = array("name"=>'searchForm','id'=>'searchForm');?>
			<input type="text" id="contactSearchInput" class="search_text_box widht_120" placeholder="<?php echo $this->lang->line('searchContacts');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('searchContacts');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('searchContacts');?>','show')">			  
			<div class="search_btn search_btn_glass"> 
			<!--<img src="<?php //echo base_url();?>images/btn_search_box.png">--> </div>
			<?php //form_close();?>
		</div>
	</div>

	<div id="sorted_data">
		<?php $this->load->view('searchedData');?>
	</div><!--sorted_data-->
	<div class="clear"></div>
</div>  <!--form_wrapper toogle frm_strip_bg-->

<div class="row">
	<div class="tab_shadow"></div>
</div>

<script type="text/javascript">
	
</script>
