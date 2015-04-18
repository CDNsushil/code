<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="clearbox">
    <ul class="dis_nav fs16 ">
        <li class="<?php echo ($actionMenu=="menu1")?'active':''; ?>" ><a href="<?php echo base_url_lang('tmail/inbox') ?>">Inbox</a> </li>
        <li class="<?php echo ($actionMenu=="menu2")?'active':''; ?>" ><a href="<?php echo base_url_lang('tmail/sent') ?>">Sent</a></li>
        <li class="<?php echo ($actionMenu=="menu3")?'active':''; ?>" ><a href="<?php echo base_url_lang('tmail/trash') ?>">Trash</a> </li>
    </ul>
    <span class="unread_msg fl  bdr_L_ddd  ml25"> <b class="red"><?php echo $unreadCount; ?></b> Unread Messages</span>
    <?php if($isCompose){ ?>
        <a href="<?php echo base_url_lang('tmail/compose'); ?>"><button class="fl ml75 red mt-12  ">Compose </button></a>
    <?php } ?> 
</div>

