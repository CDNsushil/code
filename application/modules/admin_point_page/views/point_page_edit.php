<script>
	var BASEURL = "<?php echo BASEURL ?>";
	$(document).ready(function(){
   /*
		$("#check_lang").change(function(){
	
			
						$('#page_title').val('');
						$('#meta_keywords').val('');
						$('#meta_description').val('');
						$('#heading').val('');
						$('#subhead').val('');
						//$('#FCKeditor').val('');
						var EditorInstance = FCKeditorAPI.GetInstance('FCKeditor');
						EditorInstance.SetHTML('') ;
				
					$("#check_lang").removeAttr('disabled','disabled');
					$("#loading").hide();
			
		});
		*/
	});
	
	
	// alert(EditorInstance.EditorDocument.body.innerText); 


</script>

<!-- Alternative Content Box Start -->
 <div class="contentcontainer">
	
	<div class="headings altheading">
		<h2>Edit Page</h2>
	</div>
	<div class="contentbox">
		<?php echo form_open('admin_point_page/edit_page/','id="myform"')?>
		<table>

			<tr>
				<td><?php echo $this->lang->line('edit_page_label_page_title');?></td>
				<td>
					<?php 
						$data = array(
							'name'  =>'page_title',
							'value' =>$page_name,
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
				<td>Page source(HTML)</td>
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
			<?php
					$data = array(
						'name'  =>'page_id',
						'value' =>$bubble_id,
						'id'	=>'page_id',
						'type'	=>'hidden'
					);
					echo form_input($data);
		?>
		<?php echo form_close();?>
	</div>
</div>
<!-- Alternative Content Box End -->   
