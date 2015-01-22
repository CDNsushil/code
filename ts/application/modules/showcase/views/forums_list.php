<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php
if(count($events)>0){

//show list new here

}
else{
echo '<div id="FORUMS-No-Records">';
echo $label['clickHere'].$label['associateElements'].anchor('javascript://void(0);', $label['FORUM'],array('class'=>'formTip','title'=>$label['FORUM'],'onclick'=>'showRelatedForm(\'FORUMSForm-Content-Box\',\'FORUMS-No-Records\');'));
echo '</div>';
echo '<div class="row heightSpacer"> &nbsp;</div>';
}
?>