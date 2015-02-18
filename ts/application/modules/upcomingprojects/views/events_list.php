<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php
if(count($events)>0){

//show list new here

}
else{
echo '<div id="EVENTS-No-Records">';
echo $label['clickHere'].$label['associateElements'].anchor('javascript://void(0);', $label['EVENTS'],array('class'=>'formTip','title'=>$label['EVENTS'],'onclick'=>'showRelatedForm(\'EVENTSForm-Content-Box\',\'EVENTS-No-Records\');'));
echo '</div>';
echo '<div class="row heightSpacer"> &nbsp;</div>';
}
?>