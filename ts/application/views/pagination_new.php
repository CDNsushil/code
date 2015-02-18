<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$perPageRecord=(isset($perPageRecord) && $perPageRecord > 0)?$perPageRecord:10;
$items_per_page=(isset($items_per_page) && $items_per_page > 0)?$items_per_page:10;
$items_per_page=(isset($items_per_page) && $items_per_page > 0)?$items_per_page:10;
$totalRecord=(isset($items_total) && $items_total > 0)?$items_total:0;
$pagingWpaerClass=(isset($pagingWpaerClass))?$pagingWpaerClass:'pagination_wrapper new_page_design new_page_design pl10';
$pagingDDDClass=(isset($pagingDDDClass))?$pagingDDDClass:'left_site_dropdown m0 new_page_design new_page_design';
$unqueId=(isset($unqueId))?$unqueId:'';
$isShowNumber=(isset($isShowNumber))?$isShowNumber:true;
$isShowDD=(isset($isShowDD))?$isShowDD:true;
?>

<div class="pag_1 pt20">
    <?php
    if($isShowNumber){ ?>
        <div id="ajaxPagination<?php echo $unqueId;?>" class="nav_creave <?php echo (!isset($isBorder))?"border_cacaca":""; ?> fl color_999 fs13 <?php //echo $pagingWpaerClass;?>" >
            <?php echo $pagination_links ?>
        </div>
        <?php
    }
    if($isShowDD){ ?>
        <div class="nav_creave display_table  border_cacaca width228 fs13  fr <?php echo $pagingDDDClass;?>">
            <span class="pr20 pl25 result_per fl">Results per page</span>
            <span class="position_relative selct_page width66 fl">
                <select id="pagingDropDown<?php echo $unqueId;?>" class="selectBox width66" name="pagingDropDown<?php echo $unqueId;?>" data-page="1"  >
                    <?php
                    $i=0;
                    $j=0;
                    $dropDownLimit=($totalRecord > 50)?50:$totalRecord;
                    while($i < $dropDownLimit && $i < 50){
                        $i=$i+$perPageRecord;
                        if($i==$items_per_page){
                            $selected='selected';
                        }else{
                            $selected='';
                        }
                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>'; 
                        $j++;
                    }
                    ?>
                </select>
            </span> <!--bg_sel-->
        </div> <!--right_site_dropdown-->
    <?php
    } ?>
</div>
<script type="text/javascript">

    var params = {
        page: null,
        ipp: null
    };
    var url = '<?php echo isset($url)?$url:""?>';
    var container = '<?php echo isset($divId)?$divId:""?>';
    var formId = '<?php echo isset($formId)?$formId:0?>';
    $(document).ready(function(){
        $('#ajaxPagination<?php echo $unqueId;?> a').on('click', function() {
            var control = $(this);
            params.page = control.data('page');
            params.ipp = (control.data('ipp')) ? control.data('ipp') : 1;
            params.isdisabled = (control.data('isdisabled')) ? control.data('isdisabled') : 0;
            if(!params.isdisabled){
                paginate_request(url,container,formId);
            }
        });
        $('select#pagingDropDown<?php echo $unqueId;?>').on('change', function() {
            var url = '<?php echo isset($url)?$url:""?>';
            var control = $(this);
            params.page = control.data('page');
            params.ipp = (control.val()) ? control.val() : 1;
            paginate_request(url,container,formId);
        });
        $("#pagingDropDown<?php echo $unqueId;?>").selectBoxJquery();
    });
    function paginate_request(url, container, formId) {
        var data = 'page='+params.page+'&ipp='+params.ipp+'&ajaxRequest=1&pagingRequest=1';
        $('#'+container).html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
        if(formId && formId != 0){
            if($("#"+formId)){
                var fromData=$("#"+formId).serialize();
                data=data+'&'+fromData
            }
        }
        $.post(url,data, function(data) {
          if(data){
             $('#'+container).html(data);
          }
        });
    }


</script>
