<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$saprator = isset($saprator)?$saprator:(($method=='news'|| $method=='reviews')?'sap_15':'sap_25');
$divClass = isset($divClass)?$divClass:'m_auto sc_list clearb  review_list width858';
$bgclass = isset($bgclass)?$bgclass:(($method=='news'|| $method=='reviews')?'bg_eee pt20':'');
?>

<div class="<?php echo $saprator?>"></div>
<div class="<?php echo $bgclass;?>"  id="dataListing">
    <div class="<?php echo $divClass?>" id="column1_dataListing"></div>
</div>         
<?php
    if(isset($scroll) && $scroll == false){
       $scroll = 0;
    }else{
       $scroll = 1;
    }
    ?>
<script>
    $(document).ready(function() {
        $('#dataListing').scrollPagination({
            mathod  : 'getLandingPageData', // define post url
            url     : '<?php echo $dataURL;?>', // define post url
            divIds  : {"0":"#column1_dataListing"},
            limit   : 10, // The number of posts per scroll to be loaded
            offset  : 0, // Initial offset, begins at 0 in this case
            error   : 'No More Posts!', // When the user reaches the end this is the message that is // displayed. You can change this if you want.
            delay   : 500, // When you scroll down the posts will load after a delayed amount of time. // This is mainly for usability concerns. You can alter this as you see fit
            scroll  : '<?php echo $scroll;?>' // The main bit, if set to false posts will not load as the user scrolls.  // but will still load if the user clicks.
        });
    });
</script>
