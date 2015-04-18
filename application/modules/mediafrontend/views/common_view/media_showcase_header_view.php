<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <div class="pl45 pr25 bg_f3f3f3 fl title_head ">
      <h1 class=" letrP-1  mb0 fl headingnameshow"><?php echo $headingName; ?>
        <?php   if(isset($genreName)){  ?>
            <span class="green"><?php echo $genreName; ?></span>
        <?php } ?>
      </h1>
      <ul class="dis_nav fs16 mt25 fr">
        <?php if(isset($navigation_1)){ ?>
            <li class="<?php echo ($activeMenu=="menu1")?"active":""; ?>"><a  href="<?php echo  $navigation_1; ?>"><?php echo $this->lang->line($industryType.'_detail_navi1_'.$categoryId); ?></a> </li>
        <?php } ?>
        <?php if(isset($navigation_2)){ ?>
            <li class="<?php echo ($activeMenu=="menu2")?"active":""; ?>"><a href="<?php echo  $navigation_2; ?>"><?php echo $this->lang->line($industryType.'_detail_navi2_'.$categoryId); ?></a></li>
        <?php } ?>
        <?php if(isset($navigation_3)){ ?>
            <li class="<?php echo ($activeMenu=="menu3")?"active":""; ?>"><a href="<?php echo  $navigation_3; ?>"><?php echo $this->lang->line($industryType.'_detail_navi3_'.$categoryId); ?> </a> </li>
        <?php } ?>
      </ul>
   </div>
