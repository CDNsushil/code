<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class=" pl45 pr25 bg_f3f3f3 fl title_head mb12">
 <h1 class=" letrP-1 mb0  fl"><?php echo $activeheading;?></h1>
 <ul class="dis_nav crave_nav fs16 mt25 fr pl50 pr3 mr-1">
    <li class="<?php echo isset($mycraveActive)?$mycraveActive:'';?>"> <a href="<?php echo base_url(lang().'/craves/index');?>"><?php echo $this->lang->line('editmyCraves');?></a> </li>
    <li class="<?php echo isset($craveMeActive)?$craveMeActive:'';?>"> <a href="<?php echo base_url(lang().'/craves/cravingme');?>"><?php echo $this->lang->line('editCravingMe');?></a> </li>
    <li class="<?php echo isset($playlistActive)?$playlistActive:'';?>"> <a href="<?php echo base_url(lang().'/craves/myplaylist');?>"><?php echo $this->lang->line('editPlaylist');?></a> </li>
 </ul>
</div>
