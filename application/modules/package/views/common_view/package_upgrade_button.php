<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<span class="position_relative up_wrap <?php echo $buttonPositionClass; ?> m_auto">
		<?php if($oneYearChecked || $threeYearChecked){ ?>
			<button type="button" class=" b_F1592A selectPackage disable_btn" name="one_year" id="<?php echo $this->config->item('package_type_2'); ?>"><?php echo $this->lang->line('pack_1_year'); ?> </button>
   <?php }else{ ?>
			<button type="submit" class=" b_F1592A selectPackage" name="one_year" id="<?php echo $this->config->item('package_type_2'); ?>"><?php echo $this->lang->line('pack_1_year'); ?> </button>
   <?php } ?>  
   <?php if($threeYearChecked){ ?>
			<button type="button" class="b_F1592A selectPackage disable_btn" name="three_year" id="<?php echo $this->config->item('package_type_3'); ?>"><?php echo $this->lang->line('pack_3_year'); ?></button>
		<?php }else{ ?>
			<button type="submit" class="b_F1592A selectPackage" name="three_year" id="<?php echo $this->config->item('package_type_3'); ?>"><?php echo $this->lang->line('pack_3_year'); ?></button>
		<?php } ?>        
</span>
