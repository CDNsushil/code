<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right left_204'));?>
<div class="close_btn position_absolute  " onClick="$(this).parent().trigger('close')" id="popup_close_btn"></div>
<div class="key_Popup">
    <div class="popupscrollbar_bg shiping_csroll width_592">
        <h3 class="bb_aeaeae fs21 red pb10 pl192" >
           <?php echo $searchHeader;?>
        </h3>
        <h4 class="pt10 fs14 pl192">
            <?php echo $searchTitle?>
        </h4>
        <div class="search_wrap width_176 fl">
            <?php
            $formAttributes = array(
                'name'=>'searchontoadsquare',
                'id'=>'searchontoadsquare',
            );
            
            echo form_open($this->uri->uri_string(),$formAttributes);
                $view='search_associated_media_result';
                //if(!isset($sectionList) || !$sectionList){
                    $sectionIdInput = array(
                        'name'	=> 'searchSectionId',
                        'type'	=> 'hidden',
                        'id'	=> 'searchSectionId',
                        'value'	=> $sectionId
                    );
                    echo form_input($sectionIdInput);
               //}
                $keyword = trim($keyword);
                $keyword=(isset($keyword) && !empty($keyword))?$keyword:'';
                
                if(isset($prosectionId)){
                    $projectSectionId = $prosectionId;
                }else{
                    $projectSectionId = 0;
                }
                ?>
                <h4 class="fs21 pb10">
                    Search
                </h4>
                <div class="searchbarbg">
                    <input type="text" name="keyWord" value="<?php echo $keyword;?>" class="new_keyword_style search_text_box font_wN" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
                    <input class="searchbtbbg search_pop" type="submit" value="Submit" name="searchSubmitByImage">
                </div>   
                <ul class="billing_form fl mt5 width_175">
                    <?php
                    if(isset($sectionList) && $sectionList) { ?>
                        <li class="select" id="sectiondiv">
                            <?php echo form_dropdown('sectionId', $sectionList, $sectionId,'id="sectionId"','class="main_SELECT z_index10000 selectBox"');?>
                        </li>
                        <?php
                        $view='search_media_result';
                    } ?>
                </ul>
                <div class="submint_btn mt10 fr">
                    <?php
                    if(isset($sectionList) && $sectionList) { ?>
                        <button class="red fr p10 bdr_a0a0a0 font_weight" type="button" onclick="$('#searchontoadsquare').submit();">
                            Search 
                        </button>
                    <?php } ?>
                </div>
                <input type="hidden" name="fromSection" id="fromSection" value="<?php echo isset($section)?$section:'';?>">
            <?php 
            echo form_close(); ?>
        </div><!--left_coloumn-->
        <!--right_column-->
        <div id="searchontoadsquareResultDiv" class="scroll_right fr">
            <?php
            if($searchResult) {
                echo $searchResult;
            } else {
                echo '<div class="p15">search result will come here</div>';
            } ?>
            <!--<div class="submint_btn mt25 mr15 fr">
                <button class="red fr p10 mr10 bdr_a0a0a0 font_weight" type="button">
                    Add
                </button>
                <button class="bg_ededed fr p10 mr10 bdr_a0a0a0 font_weight" type="button" id="popup_close_btn" onclick="$(this).parent().trigger('close')">
                    Cancel
                </button>
            </div>-->
        </div>
        <!--right_column-->
        <div class="clear"></div>
    </div>
    <div class="clear seprator_25"></div>
</div>

<script>
    $(document).ready(function(){
        $("#searchontoadsquare").validate({
            submitHandler: function() {
                $('html').animate({scrollTop:0}, 'slow');
                $('#searchontoadsquareResultDiv').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
                var fromData=$("#searchontoadsquare").serialize();
                fromData = fromData+'&viewPage=<?php echo $view;?>'+'&prosectionId=<?php echo $projectSectionId;?>';
                $.post(baseUrl+language+'/search/searchMediaResult',fromData, function(data) {
                    if(data){
                        $('#searchontoadsquareResultDiv').html(data);
                    }
                });
             }
        });
        radioCheckboxRender();
    });
    
    // set blank data on close
    $('#popup_close_btn').click(function() {
        $('#keywords').val('');
        $('#id').val(0);
        var supportedMediaCount = $('#supportedMediaCount').val();
        if(supportedMediaCount == 3) {
            $('#searchBoxDiv').hide();
        }
    });
</script>
