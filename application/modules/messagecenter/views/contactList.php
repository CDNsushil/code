<div class="fl width_190  text_alignR"  >
    <form action="<?php base_url_lang('messagecenter/contacts') ?>" id="searchDataForm" name="searchDataForm" >
        <div class="position_relative ff_arial font_weight fl">
            <input type="text" id="contactSearchInput" class="font_wN width170 fs13 pt4 pb4" placeholder="<?php echo $this->lang->line('searchContacts');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('searchContacts');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('searchContacts');?>','show')">			  
            <input class="searchbtbbg  search_btn_glass" type="submit" value="Submit" name="Submit">
        </div>
    </form>
 </div>
 
<div class="fr width560 " id="sorted_data">
    <?php $this->load->view('searchedData');?>
</div>
