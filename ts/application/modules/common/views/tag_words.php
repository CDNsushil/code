<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$value=html_entity_decode($value);

if(isset($required) && $required == 'required'){
	$required = 'required';
	$wordlength="3,25";
	$wordLabel='3 - 25 '.$this->lang->line('words');
}else{
	$required = '';
	$wordlength="0,25";
	$wordLabel='0 - 25 '.$this->lang->line('words');
}
$class=$required=='required'?'select_field':'';
$labelText=isset($labelText)?$labelText:'tagWords';
//$addTitle=isset($addTitle)?$addTitle:$this->lang->line('TheseWordsImprove');

$id=isset($id)?$id:'tagWords'; 

$tagWords = array(
	'name'	=> $name,
	'id'	=> $id,
	'class'	=> isset($addclass)?$addclass.' rz formTip '.$required:'width556px rz formTip '.$required,
	'title'=>  $this->lang->line('TheseWordsImprove'),
	'value'	=> html_entity_decode($value),
	'wordlength'=>$wordlength,
	'onkeyup'=>"checkWordLen(this,25,'tagLimit')",
	/*'placeholder'	=> $this->lang->line('tagWordsPlaceholder'),*/
	'rows'	=> 1
);

?>

<div class="row">

	<div class="cell label_wrapper" id='tag<?php echo $id;?>'>
		<label class="<?php echo $class;?>">
		<?php 
			echo $this->lang->line($labelText);
		?>
	</label>
	</div>
	<div class="cell frm_element_wrapper" >
		<?php echo form_textarea($tagWords); ?>
		<div id="word_counter" class="row wordcounter">
			<?php echo form_error($tagWords['name']); ?>
			<span class="tag_word_orange"> 
				<?php 
					if(isset($labelMsg)){
						echo $labelMsg;
					}
					else{
						echo $wordLabel;
					}
				?> 
			</span>
			<span class="five_words" > 
				<!--<span><?php echo $this->lang->line('total');?> </span>-->
				<span id="tagLimit"><?php
			  //echo Common::count_words($value);
			    echo str_word_count($value);
			?></span>
				<span> <?php echo $this->lang->line('words');?></span>
			 </span>
		</div>
	</div>
</div>
