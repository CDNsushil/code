<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    
    $craveCount=0;
    $ratingAvg=0;
        $LogSummarywhere=array(
            'entityId'=>$entityId,
            'elementId'=>$elementId
        );
        $resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg',  $LogSummarywhere, '', $orderBy='', '', 1 );
        if($resLogSummary)
        {
            $resLogSummary = $resLogSummary[0];											
            $craveCount = $resLogSummary->craveCount;
            $ratingAvg = $resLogSummary->ratingAvg;
        }else
        {										
            $craveCount=0;
            $ratingAvg=0;
        }
    $loggedUserId=isloginUser();
    if($loggedUserId > 0){
        $where=array(
            'tdsUid'=>$loggedUserId,
            'entityId'=>$entityId,
            'elementId'=>$elementId
        );
        $countPAResult=countResult('LogCrave',$where);
        $cravedALL=($countPAResult>0)?'cravedALL':'';
    }else{
        $cravedALL='';
    }
    
    $ratingAvg=roundRatingValue($ratingAvg);
    $ratingImg=base_url().'images/rating/rating_0'.$ratingAvg.'.png';
    
    if($getPurchaseComment['get_num_rows'] > 0)
    {
        $comments = $getPurchaseComment['get_result']->comments;
        $postUrl = 'purchase_comment_update';
        $heading="Edit";
        $rateSeller=$getPurchaseComment['get_result']->rateSeller;
        
    }else
    {
        $comments = '';
        $postUrl = 'purchase_comment_insert';
        $heading="Add";
        $rateSeller=' ';
    }
?>
<div class="poup_bx width_730 shadow">
   <div class="close_btn position_absolute"  onclick="$(this).parent().trigger('close');"></div>
     <?php
	echo form_open('cart/purchase/', 'class="form" id="purchase_comment" name="purchase_comment"'); 
	?>
   <h3 class="red fs21 text_alighC pb10"> 
        
        <?php
        if($heading=="Add") { ?>

        <?php echo $heading; ?> <?php echo $this->lang->line('purchase_comment_heading_1'); ?> <?php echo ucwords(getUserName($ownerId));?>'<?php echo $this->lang->line('purchase_comment_heading_2'); ?>
        <?php } ?>

        <?php if($heading=="Edit") { ?>

        <?php echo $this->lang->line('purchase_comment_heading_3'); ?>

        <?php } ?>
    </h3>
   <div class="bdrb_afafaf"></div>
   <div class="sap_30"></div>
   <div class="bdr_a1a1a1 fl width100_per display_inline_block min_h50 shadow_down position_relative">
      <div class="p10 fl width338">
         <div class="mt10 position_relative select_drop height30">
           
            <?php
                $options            =   array(
                ''                 =>  'Rate Seller',
                'Very Satisfied'    =>  'Very Satisfied',
                'Satisfied'         =>  'Satisfied',
                'Not Satisfied'     =>  'Not Satisfied',
                );
                $js = 'id="rate_seller" class="main_SELECT shadow_light required right0 width_208 selectBox" ';

                echo form_dropdown('rate_seller',$options,$rateSeller,$js);
            ?>
         </div>
         <textarea class="mt20 width_315 bdr_bbb fl required valid" onkeyup="checkWordLen(this,50,'contactmeMessageLimit')"  id="user_comment" name="user_comment" placeholder="Comment"><?php echo $comments; ?></textarea>
         <div class="sap_10"></div>
         <p> <span class=""><?php echo $this->lang->line('comment_lengh'); ?></span> 
         <span class="fr red">
        <span class="red" id="contactmeMessageLimit">
            <?php echo (!empty($comments))?str_word_count($comments):'0'; ?>
        </span> 
         <?php echo $this->lang->line('comment_lengh_word'); ?></span> </p>
      </div>
      <div class="p10 fr width338">
         <div class="sap_10"></div>
         <div class="fl width_80 height_60 bdr_aeaeae">
            <div class="AI_table">
               <div class="AI_cell"> <img class="maxW80_maxH60" src="<?php echo $geMediaImage; ?>"> </div>
            </div>
         </div>
         <div class="fl pl20 width228">
            <div class="font_bold fs14 pt5 bb_aeaeae lineH10"><?php echo $projName; ?></div>
            <div class="sap_20"></div>
            <div class="fr ps_1 fs14">
               <div class="icon_crave4_blog icon_so mr10  craveDiv<?php echo $projectEntityId.''.$projDetail->projId;?> <?php echo $cravedALL;?>"><?php echo $craveCount;?></div>
               <!--<div class="icon_view3_blog icon_so mr10">417</div>-->
               <div class="rating fl pt6"> <img alt="" src="<?php echo ratingImagePath($ratingAvg);?>"> </div>
            </div>
         </div>
      </div>
   </div>
   
    <input type="hidden" name="ownerId" value="<?php echo $ownerId; ?>" />
    <input type="hidden" name="ordId" value="<?php echo $ordId; ?>" />
    <input type="hidden" name="itemId" value="<?php echo $itemId; ?>" />

    <?php if($getPurchaseComment['get_num_rows']>0) 
    {?>
    <input type="hidden" name="commentId" value="<?php echo $getPurchaseComment['get_result']->id; ?>" />
    <?php } ?>
        
   <button  type="submit" value="Save" name="save">save</button>
   <?php echo form_close(); ?>
</div>

<script>
    $(document).ready(function(){	
        selectBox();
             $("#purchase_comment").validate({
                 
                 submitHandler: function() {
                    var fromData=$("#purchase_comment").serialize();
                    fromData = fromData+'&ajaxHit=1';
                    $.post(baseUrl+language+'/cart/<?php echo $postUrl; ?>',fromData, function(data) {
                      if(data){
                            customAlert(data);
                      }
                    });
                 }
        });
    });
</script>
