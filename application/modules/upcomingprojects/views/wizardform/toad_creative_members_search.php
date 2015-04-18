<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="close_btn position_absolute" onClick="$(this).parent().trigger('close')" id="popup_close_btn"></div>
<div class="key_Popup">
    <div class="popupscrollbar_bg shiping_csroll width_592">
        <h3 class="bb_aeaeae fs21 red pb10 pl192" >
            Creative Team
        </h3>
        <h4 class="pt10 fs14 pl192">
            Add a link to Members of Toadsquare on the Creative Team.
            <?php ?>
        </h4>
        <div class="search_wrap width_176 fl">
            <?php
            $searchAttrForm = array(
                'name'=>'searchontoadsquare',
                'id'=>'searchontoadsquare'
            );
            echo form_open($this->uri->uri_string(),$searchAttrForm); ?>
                <h4 class="fs21 pb10">
                    Search
                </h4>
                <div class="searchbarbg">
                    <input class="font_wN" type="text" name="keyWord" placeholder="Keyword" value="" onclick="placeHoderHideShow(this,'Keyword','hide')" onblur="placeHoderHideShow(this,'Keyword','show')">
                    <input class="searchbtbbg" type="submit" value="Submit" name="Submit">
                </div>
                <ul class="billing_form fl mt5 width_175">
                <!--<ul class="fl mt5 width_175">-->
                    <li class="select">
                        <select name="userProfileType" id="userProfileType" class="main_SELECT z_index10000 selectBox">
                             <option value="" >
                               Select Type
                            </option>
                            <option value="1">
                                Creatives
                            </option>
                            <option value="2">
                                Associated Professionals
                            </option>
                            <option value="3">
                                Enterprises
                            </option>
                            <option value="4">
                                Fans
                            </option>
                        </select>
                    </li>
                </ul>
                <div class="submint_btn mt10 fr">
                    <button class="red fr p10 bdr_a0a0a0 font_weight" type="button" onclick="$('#searchontoadsquare').submit();">
                      Search 
                    </button>
                </div>
            <?php echo form_close(); ?>
        </div>
        <div class="scroll_right  fr" id="searchontoadsquareResultDiv">
            <!-- manage here toadsquares member search result -->
            <?php 
            if($searchResult) {
                echo $searchResult;
            } else {
                echo '<div class="p15">search result will come here</div>';
            } ?>
        </div>
    </div>
</div>
<script>
    // manage search result
    $(document).ready(function() {
        $("#searchontoadsquare").validate({
              submitHandler: function() {
                $('html').animate({scrollTop:0}, 'slow');
                $('#searchResult').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
                var fromData=$("#searchontoadsquare").serialize();
                $.post('<?php echo site_url('/media/searchtoadmemberresult/');?>',fromData, function(data) {
                    if(data){
                        $('#searchontoadsquareResultDiv').html(data.searchRes);
                    }
                },'json');
            }
        });
        radioCheckboxRender();
        
        // reset creative form values on close
        $('#popup_close_btn').click(function() {
            // set field values as blank
            $('#tcrtId').val(0);
            $('#tcrtDesignation').val('');
            $('#tcrtName').val('');
            $('#tcrtLastName').val('');
            // manage buttons
            $('#toadCrtCnlBtn').hide();
            $('#toadMemSave').hide();
            // set first and last name readonly input as false
            $('#tcrtName').attr('readonly', false);
            $('#tcrtLastName').attr('readonly', false);
        });
    });

</script>
