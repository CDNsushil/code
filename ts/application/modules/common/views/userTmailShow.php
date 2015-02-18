<div class="poup_bx width329 shadow fshel_midum">
   <div class="close_btn position_absolute "  onclick="$(this).parent().trigger('close');"></div>
   <h3 class="red fs21 fnt_mouse text_alighC pb10"><?php echo $this->lang->line('note'); ?> </h3>
   <div class="bdrb_afafaf"></div>
   <P class="text_alighC mt20 lineH20 fs16" > <?php echo $this->lang->line('tmailAlertyouHave'); ?> <?php echo $unread_tmail; ?> <?php echo $this->lang->line('tmailAlertnewTmails').' '.$this->lang->line('tmailAlertclickHereToReadThem'); ?>
   </P>
   <div class="fr mb10">
      <!--<button type="button" class="bg_ededed bdr_b1b1b1 bdr_bbb" onclick="$(this).parent().trigger('close');"><?php echo $this->lang->line('cancel')?></button>-->
      <a href="<?php echo base_url('tmail'); ?>"><button type="button" class=" bdr_bbb"><?php echo $this->lang->line('yes')?></button></a>
   </div>
</div>
