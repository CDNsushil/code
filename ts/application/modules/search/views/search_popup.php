<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    $formAttributes = array(
        'name'=>'searchontoadsquare',
        'id'=>'searchontoadsquare',
    );
    $sectionIdInput = array(
        'name'	=> 'sectionId',
        'type'	=> 'hidden',
        'id'	=> 'sectionId',
        'value'	=> isset($sectionId)?$sectionId:0
    );
    $viewPageInput = array(
        'name'	=> 'viewPage',
        'type'	=> 'hidden',
        'id'	=> 'viewPage',
        'value'	=> isset($viewPage)?$viewPage:'search_associated_result'
    );
    $prosectionIdInput = array(
        'name'	=> 'prosectionId',
        'type'	=> 'hidden',
        'id'	=> 'prosectionId',
        'value'	=> isset($prosectionId)?$prosectionId:0
    );
    
    $keyword=(isset($keyword) && $keyword !='' )?$keyword:'';
    
?>
<div class="key_Popup">
   
    <div class="popupscrollbar_bg shiping_csroll ">
         <div onclick="$(this).parent().trigger('close');" class="close_btn position_absolute "></div>
        <h3 class="bb_aeaeae fs21 red pb10 pl192" ><?php echo $this->lang->line('PR_serachHeadding_'.$sectionId);?></h3>
        <h4 class="pt10 fs14 pl192"><?php echo $this->lang->line('PR_serachMsg_'.$sectionId);?></h4>	
        <!--<p class="pt15 pl192 mb-15 text_alighC popup_arrow font_bold display_table">
            <span class="">Click to select News</span>
            <br>
            <img class="pl41 pt5" src="<?php echo base_url('templates/new_version/images/arrow_mem.png')?>" alt="">
        </p>-->
        <div class="search_wrap width_176 fl">
            <?php echo form_open($this->uri->uri_string(),$formAttributes);
                  echo form_input($sectionIdInput);
                  echo form_input($viewPageInput);
                  echo form_input($prosectionIdInput);
                  ?>
                <h4 class="fs21 pb10"><?php echo $this->lang->line('PR_serachTitle_'.$sectionId);?></h4>
                <div class="searchbarbg">
                    <input class="font_wN" type="text" name="keyWord" placeholder="Keyword" value="<?php echo $keyword;?>" onclick="placeHoderHideShow(this,'Keyword','hide')" onblur="placeHoderHideShow(this,'Keyword','show')">
                    <input class="searchbtbbg" type="submit" value="Submit" name="Submit">
                </div>
            
                <div class="submint_btn mt10 mr1 fr">
                    <button class="red fr p10 bdr_a0a0a0 font_weight" type="submit"><?php echo $this->lang->line('search');?></button>
                </div>
            <?php echo form_close(); ?>
        </div>
        
        <div id="searchontoadsquareResultDiv" class="scroll_right  fr">
            <?php
            if($searchResult){
                echo $searchResult;
            }else{
                echo '<div class="p15">search result will come here</div>';
            }
            ?>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){	
		$("#searchontoadsquare").validate({
			  submitHandler: function() {
                postFormGetHTML("#searchontoadsquare","#searchontoadsquareResultDiv");
			 }
		});
	});
</script>
