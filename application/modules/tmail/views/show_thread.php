<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  ?>
<?php if(isset($data->status_id) && ($data->status_id!=''))
{ $currentId = $data->status_id;	
	} else {
		$currentId = $status_id;		
		}
/*echo $currentId;
echo "<br>";
echo $current_view_id;*/
$current_view_id = (isset($current_view_id) && !empty($current_view_id))?$current_view_id:0;
//echo $current_view_id;
?>

<div class="sap_25"></div>
<?php if(isset($mailThreadData) && $mailThreadData && is_array($mailThreadData) && count($mailThreadData) > 0 ) {
    $i=1;
    foreach ($mailThreadData as $mail) {
         if( $mail['id'] < $current_view_id) {
        ?>
            <div class="width600 position_relative bdr_b5b5b5 pb20  mb20 fr " >
               <div class="bg_f7f7f7 fl pl25 pt8 pr25 pb10 width100_per">
                  <div class="clearbox ">
                     <div class="bb_F1592A pb7 fl width100_per"><span class="fl red"><?php echo  dateFormatView($mail['cdate'],'d F Y') ?></span> <b class="num_block fr"><?php echo $i ?></b> </div>
                     <div class="pt5 fl fs13"> <?php
											echo isGetUserName($mail['sender_id']); ?></div>
                  </div>
               </div>
               <div class="pr25 pl25 fs13 letter_spP7">
                    <div class="sap_25"></div>
                    <?php 
                        if(isset($mail['body']) && !empty($mail['body'])){
                            echo  nl2br(substr($mail['body'],0,500));
                        }  
                    ?>
               </div>
            </div>
        <?php  $i++; 
    } }
} ?>   
