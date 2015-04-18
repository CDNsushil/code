<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right left_204'));?>
<div class="key_Popup">
   <div class="popupscrollbar_bg bg_fbfbfb shiping_csroll width900imp">
       <div class="close_btn position_absolute  " onClick="$(this).parent().trigger('close')" id="popup_close_btn"></div>
        <h3 class="bb_aeaeae fs21 red pb10 pl192" >Send a member a Tmail to request a recommendation from them.</h3>
        <div class="sap_35"></div>
        <div class="search_wrap width260 fl">
            <?php
            $formAttributes = array(
                'name'=>'searchontoadsquare',
                'id'=>'searchontoadsquare',
            );
            $sectionId = 0;
            echo form_open($this->uri->uri_string(),$formAttributes);
                $view='member_search_result';
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
                
                $projectSectionId = 0;
                ?>
                <h4 class="fs21 pb10">Search</h4>
                <div class="searchbarbg bg_fff fl  mb8">
                    <input type="text" name="keyWord" id="keyWord" value="<?php echo $keyword;?>" class="wid220imp new_keyword_style search_text_box font_wN" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
                    <input class="searchbtbbg search_pop" type="submit" value="Submit" name="searchSubmitByImage">
                </div>
                <div class="clearbox width258 mb8 defaultP bdr_aeaeae bg_fff shadow_down">
                    <ul class="p10 asso_lsit_pop"> 
                        <li>
                            <input type="radio" name="userType" checked="checked" value=""> All
                        </li>
                         <li>
                           <input type="radio" name="userType" value="1"> Creatives
                        </li>
                         <li>
                           <input type="radio" name="userType" value="2"> Professionals
                        </li>
                         <li>
                           <input type="radio" name="userType" value="3"> Businesses
                        </li>
                        <li>
                           <input type="radio" name="userType" value="4"> Fans
                        </li>
                    </ul>
                </div>
                <div class="select_1 height30   clearbox  shadow_down position_relative recommandationSearch" id="sectiondiv">
                    <?php
                    if(isset($sectionList) && $sectionList) {
                        echo form_dropdown('sectionId', $sectionList, $sectionId,'id="sectionId"','class="main_SELECT z_index10000 selectBox"');
                        $view='search_media_result';
                    } ?>
                </div>
                <div class="sap_25"></div>
                <div class="submint_btn fr">
                    <button class="red fr p10 bdr_a0a0a0 font_weight" type="button" onclick="$('#searchontoadsquare').submit();">Search </button>
                </div>
                <input type="hidden" name="fromSection" id="fromSection" value="<?php echo isset($section)?$section:'';?>">
            <?php 
            echo form_close(); ?>
        </div><!--left_coloumn-->
        <!--right_column-->
        <div id="searchontoadsquareResultDiv">
            <?php
            if($searchResult) {
                echo $searchResult;
            } else {
                echo '<div class="p15">search result will come here</div>';
            } ?>
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
                $.post(baseUrl+language+'/showcase/searchmembersresult',fromData, function(data) {
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
