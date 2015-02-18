<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$value=html_entity_decode($value);
$required=@$required?@$required:'';
$class=$required=='required'?'select_field':'';
$labelText=@$labelText?@$labelText:'oneLineDescription';
$id=@$id?@$id:'oneLineDescription'; 
$oneLineDescription = array(
	'name'	=> $name,
	'id'	=> $name,
	'class'	=> 'width556px rz',
	'title'=>  '',
	'value'	=> $value,
	'wordlength'=>"0,500",
	'onkeyup'=>"checkWordLen(this,500,'descriptionLimit".$name."')",
	/*'placeholder'	=> $this->lang->line('onelineDescriptionPlaceholder'),*/
	'rows'	=> 1
);

?>
<div class="row">
<div class="cell label_wrapper" id='<?php echo $id;?>'>
	<label>
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
			<?php 
				if(!isset($labelMsg))
					echo $this->lang->line('onelineDescriptionMsg');
				else 
					//echo $labelMsg;
					echo $this->lang->line('0_500_words');
			?> 
			</span>
			<span class="five_words" > 
				<!--<span><?php echo $this->lang->line('total');?> </span>-->
				<span id="descriptionLimit<?php echo $name;?>">
			<?php
			  echo Common::count_words($value);
			?></span>
				<span> <?php echo $this->lang->line('words');?></span>
			 </span>
		</div>
	</div>
</div>

