<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
  $formAttributes =  array(
    'name'        =>  'SearchHeaderForm',
    'id'          =>  'SearchHeaderForm',
  );
  echo form_open(base_url(lang().'/search/advance'),$formAttributes);
?>
<div class="searchbarbg  fl">
	Search by <input type="text" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','show')" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','hide')" value="" placeholder="<?php echo $this->lang->line('keywordSearchNew');?>" class="font_wN" name="keyWord">
  <input name="Submit" type="submit" class="searchbtbbg" value="Submit"/>
</div>

 <?php echo form_close(); ?>
