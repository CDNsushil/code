<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$value=html_entity_decode($value);
$descLimit=isset($descLimit)?$descLimit:'descLimit';

if(isset($required) && $required == 'required'){
	$required = 'required';
}else{
	$required = '';
}
$requiredClass=($required=='required')?'select_field':'';
$labelText=isset($labelText)?$labelText:'description';
$id=isset($id)?$id:$name;


/*Client changes 8 aug 2012 */
if(isset($wordOption) && is_array($wordOption))
{ 
	$minVal=$wordOption['minVal'];
	$maxVal=$wordOption['maxVal'];
	

}elseif($required=='required')
{
	$minVal="15";
	$maxVal='100';
	
}else
{ 
	$minVal="0";
	$maxVal='100';
	
}
$wordLabel=$minVal.' - '.$maxVal.$this->lang->line('words');
$wordLimit=$maxVal;

$wordlength=$minVal.",".$maxVal;

$description = array(
	'name'	=> $name,
	'id'	=> $id,
	'class'	=> isset($addclass)?$addclass.' rz '.$required:'width556px rz '.$required,
	'title'=>  isset($addTitle)?$addTitle:'',
	'value'	=> html_entity_decode($value),
	'wordlength'=>$wordlength,
	'onkeyup'=>"checkWordLen(this,'".$wordLimit."','".$descLimit."')",
	'rows'	=> isset($rows)?$rows:8,
	'cols'	=> isset($cols)?$cols:90,
);
?>
<div class="row">
	<div class="cell label_wrapper" id='desc<?php echo $id;?>'>
		<label class="<?php echo $requiredClass;?>">
		<?php 
			
			if($this->lang->line($labelText)){
				echo $this->lang->line($labelText);
			}else{
				echo $labelText;
			}			
		?>
	</label>
	</div>
	<div class="cell frm_element_wrapper" >
		<?php echo form_textarea($description); ?>
		<div id="word_counter" class="row wordcounter">
			<?php echo form_error($description['name']); ?>
			<span class="tag_word_orange"> <?php echo $wordLabel;?> </span>
			<span class="five_words" > 
				<!--<span><?php echo $this->lang->line('total');?> </span>-->
				<span id="<?php echo $descLimit;?>"><?php
			 // echo Common::count_words($value);
			   echo str_word_count($value);
			?></span>
				<span> <?php echo $this->lang->line('words');?></span>
			 </span>
		</div>
	</div>
</div>
