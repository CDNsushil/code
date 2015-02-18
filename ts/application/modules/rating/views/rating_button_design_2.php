<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
   
    $loggedUserId   =   isloginUser(); // get loggedIn user id
    $rateAll ='';
    $beforeRatingLoggedIn =  $this->lang->line('beforeRatingLoggedIn');
    $isPublished          =  (!empty($isPublished)) ? $isPublished :'f' ;
    if($loggedUserId > 0){
        //createDate
        $where=array(
            'tdsUid'    =>  $loggedUserId,
            'entityId'  =>  $entityId,
            'elementId' =>  $elementId
        );

        $countResult    = countResult('LogRating',$where);
        if($countResult > 0){
            $rateAll='rateALL';
        }
    }
?>
 
 <li><a href="javascript:void(0)"> Rate me <i class="ab_share rate_me <?php echo $rateAll ?> <?php echo ($isPublished=='t')?'rateAction'.$entityId.$elementId:''; ?>  rateBtn<?php echo $entityId.$elementId?> "></i></a></li>

<script>
    $('.rateAction<?php echo $entityId.$elementId; ?>').click(function(){
        
        if(checkIsUserLogin('<?php echo $beforeRatingLoggedIn; ?>')){
            $.ajax
            ({     
                type: "POST",
                dataType: 'json',
                data:{entityId:'<?php echo $entityId; ?>',elementId:'<?php echo $elementId; ?>'},			
                url: "<?php echo base_url_lang('rating/ratingaction') ?>",
                    success: function(getdata){  
                        
                        if(getdata.isUserLoggedIn){
                            if(getdata.isRated){
                                customAlert(getdata.alreadyRatedMessage);
                            }else{
                                openLightBox('popupBoxWp','popup_box','/rating/ratingpopupopen','<?php echo $entityId; ?>','<?php echo $elementId; ?>');
                            }
                        }else{
                            openLightBox('popupBoxWp','popup_box','/auth/login','<?php echo $beforeRatingLoggedIn; ?>');
                        }
                    }
            });
        }
    });
</script>
