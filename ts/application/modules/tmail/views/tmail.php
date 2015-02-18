<table width="100%" border="1" style="border-collapse:collapse; border-color:#CCCCCC;" cellpadding="4" cellspacing="4">
	<tr>
		<td style="padding:10px;"><a href="<?php echo base_url('tmail/index');?>">Inbox</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('tmail/sent');?>">Sent</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('tmail/trashed');?>">Trashed</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('tmail/compose');?>">Compose</a></td>
	</tr>
</table>
<br />
<?php 
if(is_array($result)){?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td colspan="6" align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;">&nbsp;</td>
		  </tr>
		<?php foreach($result as $key => $value):	?>
			<?php //print_r($value);?>	
			<tr>
				<td align="left" valign="top" style="background:#F2F2F2; padding:4px;"><input type="checkbox" id="tmail_chk_<?php echo $value['id'];?>"></td>
				<td width="20%" align="left" valign="top" style="background:#F2F2F2; padding:4px;"><?php echo @$value['image']; ?></td>
				<td align="left" valign="top" style="background:#F2F2F2; padding:4px;"><a href="<?php echo base_url('tmail/tmailList/'.$value['thread_id'].'/'.$value['sender_id']);?>"><?php echo $value['firstName'].'&nbsp;'.$value['lastName'] ; ?></a></td>
				<td align="left" valign="top" style="background:#F2F2F2; padding:4px;"><?php echo $value['subject']; ?></td>
				<td align="left" valign="top" style="background:#F2F2F2; padding:4px;"><?php echo $value['cdate']; ?></td>
			</tr>	
		<?php endforeach; ?>
		</table>	
<?php }else{?>
		<h1>No message found.</h1>
<?php }?>							
