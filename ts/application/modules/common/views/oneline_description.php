<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$value=html_entity_decode($value);

if(isset($required) && $required == 'required'){
	$required = 'required';
}else{
	$required = '';
}
$descLimit=isset($descLimit)?$descLimit:'descriptionLimit'.$name;
$class=$required=='required'?'select_field':'';
$labelText=isset($labelText)?$labelText:'oneLineDescription';

$id=isset($id)?$id:'';


if(isset($wordOption) && is_array($wordOption))
{
	$minVal=$wordOption['minVal'];
	$maxVal=$wordOption['maxVal'];
	$wordLabel=$minVal.' - '.$maxVal.$this->lang->line('words');
	$wordLimit=$maxVal;
}
else
{
	$minVal='3';
	$maxVal='50';
	$wordLimit='50';	
	$wordLabel=$this->lang->line('onelineDescriptionMsg');
}

	$wordlength=$minVal.",".$maxVal;

	$oneLineDescription = array(
	'name'	=> $name,
	'id'	=> $name,
	'class'	=> isset($addclass)?$addclass.'rz '.$required:'width556px rz '.$required,
	'title'=>  isset($title)?$title:'',
	'value'	=> html_entity_decode($value),
	'wordlength'=>$wordlength,
	'onkeyup'=>"checkWordLen(this,$maxVal,'descriptionLimit".$name."')",
	/*'placeholder'	=> $this->lang->line('onelineDescriptionPlaceholder'),*/
	'rows'	=> 1
	);

?>
<div class="row">
<div class="cell label_wrapper" id='<?php echo $id;?>'>
	<label class="<?php echo $class;?>">
		<?php 
		
			echo $this->lang->line($labelText);
		?>
	</label>
</div>
<div class="cell frm_element_wrapper" >
		<?php echo form_textarea($oneLineDescription); ?>
		<div id="word_counter" class="row wordcounter">
			<?php echo form_error($oneLineDescription['name']); ?>
			<span class="tag_word_orange"> 
			 
				<span class="tag_word_orange"> <?php echo $wordLabel;?> </span>
			
			</span>
			<span class="five_words" > 
				<!--<span><?php echo $this->lang->line('total');?> </span>-->
				<span id="descriptionLimit<?php echo $name;?>">
			<?php
			 // echo Common::count_words($value);
			  echo str_word_count($value);
			?></span>
				<span> <?php echo $this->lang->line('words');?></span>
			 </span>
		</div>
	</div>
</div>

