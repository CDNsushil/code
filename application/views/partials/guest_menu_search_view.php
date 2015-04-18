<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$formName = (!empty($formName))?$formName:'';
$sectionId = (!empty($sectionId))?$sectionId:'';
  $formAttributes =  array(
    'name'        =>  'SearchHeaderForm'.$formName ,
    'id'          =>  'SearchHeaderForm'.$formName ,
  );
  echo form_open(base_url(lang().'/search/advance'),$formAttributes);
?>

<span class="goto_search position_absolute">
    <span class="searchbarbg ff_arial font_weight fl">
        <input type="text" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','show')" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','hide')" value="" placeholder="<?php echo $this->lang->line('keywordSearchNew');?>"  class="font_wN" name="keyWord" />
        <input name="sectionId"  id="sectionId_<?php echo $formName; ?>" type="hidden" value="<?php echo $sectionId; ?>">
        <input name="Submit" type="submit" class="searchbtbbg" value="<?php echo $this->lang->line('suggestionSubmit');?>"  />
    </span>
</span>
 <?php echo form_close(); ?>
