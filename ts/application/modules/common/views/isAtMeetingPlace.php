<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

$ezchecked = '';
$ezchecked = (strcmp($currentStatus,'checked')==0)?'ez-checked':'';

?>
<div class="greencheck">
<div class="ez-checkbox <?php echo $ezchecked;?>"><input type="checkbox" <?php echo $currentStatus;?> value="banana" id="banana" name="item[]" class="ez-hide"></div>
</div>
