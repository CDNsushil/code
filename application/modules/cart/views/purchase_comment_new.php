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
 <div class="poup_bx width_361 shadow">
   <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
    <?php
	echo form_open('cart/purchase/', 'class="form" id="purchase_comment" name="purchase_comment"'); 
	?>
   <h3 class="">
       <?php
            if($heading=="Add") { 
                echo $this->lang->line('purchase_comment_heading_1');
            }elseif($heading=="Edit"){ 
                echo $this->lang->line('purchase_comment_heading_3'); 
            }
        ?>
       
      </h3>
   <div class="mt20 position_relative select_drop height30 buyer_rating">
       
       <?php
            $options            =   array(
            ''                 =>  'Rate Purchase*',
            'Very Satisfied'    =>  'Very Satisfied',
            'Satisfied'         =>  'Satisfied',
            'Not Satisfied'     =>  'Not Satisfied',
            );
            $js = 'id="rate_seller" class="main_SELECT shadow_light width_270 required " title="This is a required field."  ';

            echo form_dropdown('rate_seller',$options,$rateSeller,$js);
        ?>
   </div>
   <div class="fl mt20">
    
      
        <textarea class="search_box mt10 mb8 width338 bdr_bbb fl required" onkeyup="checkWordLen(this,50,'contactmeMessageLimit')"  id="user_comment" name="user_comment" placeholder="Comment"><?php echo $comments; ?></textarea>
     
        <p>0 - 50 word <span class="fr red">
            <span id="contactmeMessageLimit">
                <?php echo (!empty($comments))?str_word_count($comments):'0'; ?>
            </span> 
            <?php echo $this->lang->line('comment_lengh_word'); ?>
            </span>
        </p>
   </div>
    <input type="hidden" name="ownerId" value="<?php echo $ownerId; ?>" />
    <input type="hidden" name="ordId" value="<?php echo $ordId; ?>" />
    <input type="hidden" name="itemId" value="<?php echo $itemId; ?>" />
   
  <?php if($getPurchaseComment['get_num_rows']>0) 
    {?>
    <input type="hidden" name="commentId" value="<?php echo $getPurchaseComment['get_result']->id; ?>" />
    <?php } ?>
        
   <button  type="submit" value="Save" name="save">Rate</button>
   <?php echo form_close(); ?>
</div>
       

<script>
    $(document).ready(function(){	
       selectBox();
               $("#rate_seller").css({"display": "block"});
               
             $("#purchase_comment").validate({
                 
                 submitHandler: function() {
                    var fromData=$("#purchase_comment").serialize();
                    fromData = fromData+'&ajaxHit=1';
                    $.post(baseUrl+language+'/cart/<?php echo $postUrl; ?>',fromData, function(data) {
                      if(data){
                            customAlert(data);
                            $('#Purchase<?php echo $itemId; ?>').html('Edit your Comment');
                      }
                    });
                 }
        });
    });
</script>
