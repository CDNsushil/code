<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class=" pl45 pr25 bg_f3f3f3 fl title_head ">
  <h1 class=" letrP-1  mb0 fl"><?php echo $tmailHeader; ?></h1>
  <ul class="dis_nav fs16 mt25 fr">
     <li  class="<?php echo ($actionMenu=="menu1")?'active':''; ?>"><a href="<?php echo base_url_lang('tmail'); ?>">Tmail</a> </li>
     <li class="<?php echo ($actionMenu=="menu2")?'active':''; ?>"><a href="<?php echo base_url_lang('notifications/index'); ?>">Notifications</a></li>
     <li class="<?php echo ($actionMenu=="menu3")?'active':''; ?>"><a href="<?php echo base_url_lang('messagecenter/contacts'); ?>">Contacts</a> </li>
  </ul>
</div>

