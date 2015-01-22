<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class=" pl45 pr25 bg_f1f1f1 fl title_head mb12">
 <h1 class=" letrP-1 mb0  fl"><?php echo $activeheading;?></h1>
 <ul class="dis_nav crave_nav fs16 mt25 fr pl50 pr3 mr-1">
    <li class="active"> <a href="<?php echo base_url(lang().'/craves/index');?>">My Craves</a> </li>
    <li> <a href="<?php echo base_url(lang().'/craves/cravingme');?>">Craving Me</a> </li>
    <li> <a href="<?php echo base_url(lang().'/craves/myplaylist');?>">My Playlist</a> </li>
 </ul>
</div>
