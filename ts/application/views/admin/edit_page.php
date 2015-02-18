<script>
	var BASEURL = "<?php echo BASEURL ?>";
	$(document).ready(function(){
		$("#check_lang").change(function(){
			page_id = $("#page_id").val();
			lang_id = $(this).val();
			$.ajax({
				url: BASEURL+"admin/admin/check_lang",
				async:true,
				type:"post",
				dataType:"json",
				data:{
					page_id:page_id,
					lang_id:lang_id
				},
				beforeSend:function(){
					$("#check_lang").attr('disabled','disabled');
					$("#loading").show();	
				},
				success:function(resp){
					if(resp.num > 0){
						$.each(resp.results, function(i,value){
							$('#page_title').val(value.page_title);
							$('#meta_keywords').val(value.page_meta_keywords);
							$('#meta_description').val(value.page_meta_description);
							$('#heading').val(value.page_heading);
							$('#subhead').val(value.page_subhead);
						
							var EditorInstance = FCKeditorAPI.GetInstance('FCKeditor') ;
							EditorInstance.SetHTML(value.page_content) ;
						
						});
					}else{
						$('#page_title').val('');
						$('#meta_keywords').val('');
						$('#meta_description').val('');
						$('#heading').val('');
						$('#subhead').val('');
						//$('#FCKeditor').val('');
						var EditorInstance = FCKeditorAPI.GetInstance('FCKeditor');
						EditorInstance.SetHTML('') ;
					}
					$("#check_lang").removeAttr('disabled','disabled');
					$("#loading").hide();
				}
			});
		});
	});
	
	
	alert(EditorInstance.EditorDocument.body.innerText); 
	/*if(EditorInstance.EditorDocument.body.innerText.length<=0)
	{
	alert("This firld is mandatory");
	EditorInstance.EditorDocument.body.focus();
	return false;
	}*/

</script>

<!-- Alternative Content Box Start -->
 <div class="contentcontainer">
	 <!--<div id="lang_select" style="float:right">
			<?php
				echo form_open('admin/admin/set_language');
				foreach($lang as $lng){
					$options[$lng->language] = ucwords($lng->language);
				}
				$js = 'onchange="form.submit()"';
				echo '<span class="lang_sel">'.$this->lang->line('edit_page_lang_selec').'</span>';
				echo form_dropdown('lang', $options, $selected_lang,$js);
				echo form_close();	
			?>
	 </div>-->

	<div class="headings altheading">
		<h2><?php echo $this->lang->line('edit_page_heading');?></h2>
	</div>
	<div class="contentbox">
		<?php echo form_open('admin/admin/edit_page/'.$page->page_id,'id="myform"')?>
		<table>
			<tr>
				<td><?php echo $this->lang->line('edit_select_lang_label');?></td>
				<?php 
					foreach($lang as $langs){
						$option[$langs->language_id] = $langs->language;
					}
					$id='id="check_lang"';
					echo '<td>'.form_dropdown('page_lang',$option,$selected_lang_code,$id).'<span id="loading"style="display:none;font-weight:bold;">loading...</h1><span>';
				?>
			</tr>
			<tr>
				<td><?php echo $this->lang->line('edit_page_label_page_title');?></td>
				<td>
					<?php 
						$data = array(
							'name'  =>'page_title',
							'value' =>$page->page_title,
							'id'	=>'page_title',
							'class'	=>'inputbox',
							'type'	=>'text'
						);
						echo form_input($data);
					?>
					<span class="validation_msg" id="validation_page_title"><?php echo $this->lang->line('edit_validation_page_title');?></span>
				</td>
			</tr>
			
			<tr>
				<td><?php echo $this->lang->line('edit_meta_keyword_label');?></td>
				<td>
					<?php 
						$data = array(
							'name' =>'meta_keywords',
							'id' =>'meta_keywords',
							'class'	=>'inputbox',
							'value' =>$page->page_meta_keywords,
							'type' =>'text',
						);
						echo form_input($data);
					?>
				<td>
			</tr>
			<tr>
				<td><?php echo $this->lang->line('edit_meta_desc_label');?></td>
				<td>
					<?php 
						$data = array(
							'name' =>'meta_description',
							'id' =>'meta_description',
							'class'	=>'inputbox',
							'value' =>$page->page_meta_description,
							'type' =>'text',
						);
						echo form_input($data);
					?>
				<td>
			</tr>
			
			<tr>
				<td><?php echo $this->lang->line('edit_page_head_label');?></td>
				<td>
					<?php 
						$data = array(
							'name' =>'heading',
							'id' =>'heading',
							'class'	=>'inputbox',
							'value' =>$page->page_heading,
							'type' =>'heading',
						);
						echo form_input($data);
					?>
				<td>
			</tr>

			<tr>
				<td><?php echo $this->lang->line('edit_page_subhead_label');?></td>
				<td>
					<?php 
						$data = array(
							'name' =>'subhead',
							'id' =>'subhead',
							'class'	=>'inputbox',
							'value' =>$page->page_subhead,
							'type' =>'text',
						);
						echo form_input($data);
					?>
				<td>
			</tr>

			<tr>
				<?php 
					$data = array(
						'name'  =>'page_id',
						'value' =>$page->page_id,
						'type'	=>'hidden',
						'id'	=>'page_id'
					);
					echo form_input($data);
					
					$data = array(
						'name'  =>'content_id',
						'value' =>$page->page_content_id,
						'type'	=>'hidden',
						'id'	=>'content_id'
					);
					echo form_input($data);
				?>
				<td><?php echo $this->lang->line('edit_page_label_page_desc')?></td>
				<td><?php $this->fckeditor->Create();?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<?php
					$data = array(
						'name'  =>'edit',
						'value' =>$this->lang->line('edit_submit_btn'),
						'id'	=>'edit_page',
						'type'	=>'submit',
						'class' =>'btn'
					);
					echo form_input($data);
				?>
				</td>
				</td>
			</tr>
		</table>
		<?php echo form_close();?>
	</div>
</div>
<!-- Alternative Content Box End -->   
