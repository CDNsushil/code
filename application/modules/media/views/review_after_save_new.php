<?php 
    $userId=isLoginUser();
    $isProject = isReviewProject($userId);	
    $isProject = (isset($isProject))?$isProject:'';
?> 

<div class="poup_bx width_325 shadow">
   <div class="close_btn position_absolute " onclick="window.location.reload();"></div>
   <h3 class="">Note</h3>
   <P class=" mt17 fs15" > <?php echo $this->lang->line('reviewFormCotentNewMessageNew'); ?><br></P>
   <?php if($isProject==0) { ?>		
    <P class=" mt17 fs15" > <?php echo $this->lang->line('reviewFormCotentFourthNewMessage'); ?><br></P>
   <?php  } ?>	
   <a href="<?php echo base_url() ?>media/reviewswizard/<?php echo $projId.'/'.$elemId ?>" >
        <button type="button"><?php echo $this->lang->line('yes_big')?></button>
   </a 
</div>
