<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if(count($result)>0):?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td colspan="6" align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;">&nbsp;</td>
		  </tr>
	<?PHP $padding=0;?>  
	<?php foreach($result as $key => $value):	?>
	<?PHP $padding+=10;?>  
		<tr>
			<td align="left" valign="top" style="background:#F2F2F2; padding-left:<?php echo $padding;?>px;"><?php echo $label['from']?> <?php echo @$value['image']; ?>&nbsp;<?php echo $value['firstName'].'&nbsp;'.$value['lastName'];?></td>
		</tr>
		<tr>
			<td width="20%" align="left" valign="top" style="background:#F2F2F2; padding-left:<?php echo $padding;?>px;"><?php echo $label['subject']?><?php echo @$value['subject']; ?></td>
		</tr>
		<tr>
			<td width="20%" align="left" valign="top" style="background:#F2F2F2; padding-left:<?php echo $padding;?>px;"><?php echo $label['date']?> <?php echo @$value['cdate']; ?></td>
		</tr>
		<tr>		
			<td align="left" valign="top" style="background:#F2F2F2; padding-left:<?php echo $padding;?>px;"><br><?php echo nl2br($value['body']);?></td>
		</tr>	
		<tr>	
			<td align="left" valign="top" style="background:#F2F2F2; padding-left:<?php echo $padding;?>px;"></td>
		</tr>
		<tr>		
			<td align="left" valign="top" style="background:#F2F2F2; padding-left:<?php echo $padding;?>px;"></td>
		</tr>
		<tr>
			<td style="height:10px;">&nbsp;</td>
		</tr>	
		<?php if($value['sender_id'] != 4){?>
			<tr>
				<td>
					<div class="button fl mr20"><a href="<?php echo base_url('tmail/compose/Re/'.$value['id'].'/'.$value['sender_id'])?>"><?php echo $label['reply']?></a></div>
					<div class="button fl"><a href="<?php echo base_url('tmail/compose/Fwd/'.$value['id'].'/'.$value['sender_id'])?>"><?php echo $label['forward']?></a></div>
				</td>
			</tr>
		<?
		}?>
	<?php endforeach; ?>
	</table>
<?php else:?>
	<h1><?php echo $label['noRecord']?></h1>
<?php endif;?>	