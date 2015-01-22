<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="fr clearb pr115 pt18 width156  about_me">
    <span class="fl"><?php echo $pageheading;?> in</span>
    <span class="fs16 position_relative font_bold select_dowm">
        <select class="selectBox" onchange="changelanguage('<?php echo $userId;?>', this.value, '<?php echo $page;?>');">  <?php 
            if(isset($multilingualList) && is_array($multilingualList) && !empty($multilingualList)){
                $langSelected = ($multilingualShowcaseId==0)? 'selected':'';
                echo '<option '.$langSelected.' value="0" selected>English</option>';
                foreach($multilingualList as $multilingual){
                    $langSelected = ($multilingualShowcaseId==$multilingual->showcaseLangId)?'selected':'';
                    ?>
                    <option <?php echo $langSelected?>  value="<?php echo $multilingual->showcaseLangId;?>"><?php echo $multilingual->Language_local;?></option>
                    <?php
                }
             }else{
                 echo '<option value="0">English</option>';
             } ?>
        </select>
    </span> 
</div>
<script>
function changelanguage(userId, multilangId, page){
    var scurl = baseUrl+language+'/showcase/'+page+'/'+userId;
    if(multilangId > 0){
        scurl = scurl+'/'+multilangId;
    }
    $(location).attr('href',scurl);
}
</script>
