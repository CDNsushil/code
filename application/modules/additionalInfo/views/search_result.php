<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}?>
<div class="row">
	<div class="Cat_wrapper"><h1><?php echo $this->lang->line('find').'&nbsp;'.$this->lang->line($section);?></h1></div>
</div>
<div class="row">
	<?php
		if($searchResult){ ?>
			<div class="row searchAdditionalInfo">
			<?
				foreach ($searchResult as $k=>$item){ 
					$fieldPublishDate=$section.'PublishDate';
					$fieldTitle=$section.'Title';
					$fieldWriter=$section.'Writer';
					$fieldDescription=$section.'Description';
					$fieldEmbed=$section.'Embed';
					$fieldExternalUrl=$section.'ExternalUrl';
					$fieldId=$section.'Id';
					$fieldLanguage=$section.'Language';
					
					$publishDate = date("Y-m-d", strtotime($item->$fieldPublishDate));
					$title = htmlentities(addslashes($item->$fieldTitle),ENT_QUOTES);
					$writer = htmlentities(addslashes($item->$fieldWriter),ENT_QUOTES);
					$description = htmlentities(addslashes($item->$fieldDescription),ENT_QUOTES);
					$embedvalue = $item->$fieldEmbed;
					$ExternalUrl = $item->$fieldExternalUrl;
					$id=$item->$fieldId;
					$languageId=$item->$fieldLanguage;
					
					?>
					<div class="row">
						<div class="cell ">
							<div class="defaultP padding_top4">
								<?php
									$radioArr = array(
										'type'=>"radio",
										'name'=>"getnews",
										'class'=>"prepareAdditionalInfo",
										'id'=>$id,
										'value'=>$id,
										'section'=>'#'.$section, 
										'titlehere'=>$title, 
										'writer'=> $writer, 
										'description'=> $description, 
										'embed'=>$embedvalue, 
										'externalUrl'=>$ExternalUrl, 
										'languageId'=> $languageId, 
										'publishDate'=>$publishDate,
										'onmousedown'=>"mousedown_small_button(this)",
										'onmouseup'=>"mouseup_small_button(this)"
									);
									echo form_radio($radioArr); 
								?>
							</div>
						</div>
						<div class="cell title_small_frm">
							<?php echo stripslashes($title);?>
						</div>
						<div class="cell pt5">
							<?php 
							$len =strlen($description);
							$str=$len>40?'...':'';
							echo substr(stripslashes($description),0,40).$str;?>
						</div>
					</div>
					
					<?
				}?>
			</div>
			<div class=" row">
				<div class="cell pb5">
					<div class="tds-button Fleft"><button class="submitAdditionalInfo" type="button" name="submit" value="Submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php echo $this->lang->line('submit');?></div> <div class="icon-save-btn"></div></span></button></div>
					<div class="seprator_10"></div>
				</div>
			</div>
			<?
		}else{
			echo $this->lang->line('noRecordFound');
		}
	?>
</div>
<script language="javascript" type="text/javascript">
	runTimeCheckBox();
	var section = '';
	var id = '';
	var title = '';
	var writer = '';
	var description = '';
	var embed = '';
	var externalUrl = '';
	var languageId = '';
	var publishDate = '';
	$(document).ready(function(){
		$('.prepareAdditionalInfo').click(function(){
			section = $(this).attr('section');
			id = $(this).attr('id');
			title = $(this).attr('titlehere');
			writer = $(this).attr('writer');
			description = $(this).attr('description');
			embed = $(this).attr('embed');
			externalUrl = $(this).attr('externalUrl');
			languageId = $(this).attr('languageId');
			publishDate = $(this).attr('publishDate');
		}); 
		
		$('.submitAdditionalInfo').click(function(){
			$(section+'Id').val(id);
			$(section+'title').val(title);
			$(section+'writerName').val(writer);
			$(section+'Description').val(description);
			$(section+'externalUrl').val(externalUrl);
			$(section+'EmbbededVideo').val(embed);
			$(section+'Language').val(languageId);
			$(section+'publishDate').val(publishDate);
			selectBox();
			$(this).parent().trigger('close');
		}); 
	});
</script>
