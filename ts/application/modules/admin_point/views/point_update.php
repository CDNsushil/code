<div class="contentcontainer">
	
		<h1><?php echo $this->lang->line('admin_point')." ".$this->lang->line('update_button');?></h1>
	
		
	<form name="update_point" id="update_point" method="post" action="<?php echo BASEURL?>admin_point/update_save">
		<table  cellspacing="5" cellpadding="5" width="70%" align="center">
			<tr>
				<td><?php echo $this->lang->line('admin_point');?></td>
				<td><input type="text" name="point" id="point" value="<?php echo $val;?>">
				<br><div id="point_error"></div></td>
			</tr>
			<tr>
				<td colspan="2" align="left"><input type="button" name="update" id="update" value="<?php echo $this->lang->line('update_button')?>" onclick="check_val()"></td>
			</tr>
		</table>
		<input type="hidden" name="table_name" id="table_name" value="<?php echo $table_name;?>">
		<input type="hidden" name="col_name" id="col_name" value="<?php echo $col_name;?>">
		<input type="hidden" name="whr_col" id="whr_col" value="<?php echo $whr_col;?>">
		<input type="hidden" name="whr_id" id="whr_id" value="<?php echo $whr_id;?>">
	</form>
	
</div>
