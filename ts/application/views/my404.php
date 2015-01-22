<div class="newlanding_container">
<div class="mt40 pb41">
<div class="m_auto width700 shadow_large  patern_404 ">
<div class="pt32 pr40 fr">
<img src="<?php echo base_url();?>images/sorry404.png" alt="404">
</div>
<div>
<div class="fl ml10 mt-12">
<img src="<?php echo base_url();?>images/404_frog.png" alt="404frog">
</div>
<div class="fr mr20 width_325 clr_white pr20 mt-10">
<div class="fl fs23 lineH28 opensans_semi test_s404">
<?php echo $errorMsg1;?>
<div class="sap_15"></div>
<?php echo $errorMsg2;?>
</div>
<div class="clear"></div>
<div class="pr14 mt49">
<div class="searchbarbg search_404 ff_arial font_weight fl">
    
    
<?php
$formAttributes = array(
'name'=>'SearchLoginrForm',
'id'=>'SearchLoginrForm',
);
echo form_open(base_url(lang().'/search/searchform'),$formAttributes);
?>
<input type="text" class="font_wN" name="keyWord" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','show')" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','hide')" value="" placeholder="<?php echo $this->lang->line('keywordSearchNew');?>" >
<input name="sectionId" type="hidden" value="">
<input class="searchbtbbg" name="Submit" type="submit"  value="Submit"/>
<?php echo form_close(); ?>

</div>
<span class="fr  fs20 lineH27 letter_space1">
<a class="clr_white open_sans" href="javascript:history.go(-1);">Go back.</a>
</span>
<div class="clear"></div>
</div>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
 </div>            
            
 
