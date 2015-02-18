<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
'name'=>'customForm',
'id'=>'customForm',
);

/* echo "<pre>";
print_r($result);
echo "</pre>"; */
?><div id="testIng"></div>
<table width="100%" border="0" cellpadding="0" cellspacing="5" >
	<tr>
		 <td height="25" bgcolor="#09728F" class="fildsetHeading style4"><?php echo $tmailHeading;?>
			<?php 
			if(is_array($result) && ($tmailHeading != 'Trash')){?>
				<div  class="fr widthAuto">
					<a href="#" class="tooltip" title="Remove"> <img id="removeRecord" src="<?php echo base_url('images/icons/1316427111_delete.png');?>" width="16" height="16" /> </a>
				</div>
				<?php
			}?>
		</td>
	</tr>
	<tr>
	<td id="Messages">
		<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
		  <table width="100%" cellpadding="0" cellspacing="0">
			<tbody>
			  <?php 
			 // print_r($result);
				if(is_array($result)){
					$nameString="";
					$status_ids="";?>
					<?php foreach($result as $key => $value):	
					  $userimage=getImage($value['imagePath'],'userIcon');
					  $name= $value['firstName'].'&nbsp;'.$value['lastName'] ;
					  $status_id=$value['status_id'];
					$bold="";
					 if($tmailHeading=='Inbox'){
						$bold=$value['status']==1? '':'b';
					  }
					  if($result[$key]['thread_id'] != @$result[$key+1]['thread_id']){
						  if($nameString==""){
							$nameString=$name;
							$status_ids=$status_id;
						  }
						  ?>
						  <tr onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#CCf9f9'" style="" >
							<td width="30" height="40" nowrap="nowrap" class="borderBottom" >
								<input class="CheckBox" type="checkbox" name="checkbox[]" id="id_<?php echo $status_ids;?>" value="<?php echo $status_ids;?>" />
							</td>
							<td width="35" class="block-main-table"> 
								<a href="<?php echo base_url('tmail/tmailList/'.$value['id'].'/'.$value['sender_id']);?>">
									<img src="<?php echo $userimage;?>" width="30" />
								</a>
								
								<br />
							</td>
							<td width="100" class="borderBottom pl10 pr20 <?php echo  $bold;?>">
								<a href="<?php echo base_url('tmail/tmailList/'.$value['id'].'/'.$value['sender_id']);?>">
									<?php echo $nameString ; ?>
								</a>
							</td>
							<td class="borderBottom <?php echo  $bold;?>">
								<a href="<?php echo base_url('tmail/tmailList/'.$value['id'].'/'.$value['sender_id']);?>">
									<?php echo $value['subject']; ?>
								</a>
								</td>
							<td class="borderBottom <?php echo  $bold;?>">
								<a href="<?php echo base_url('tmail/tmailList/'.$value['id'].'/'.$value['sender_id']);?>">
									<?php echo $value['cdate']; ?>
								</a>
							</td>
						  </tr>
						<?php
						$nameString="";
						$status_ids="";
					}else{
						$nameString=$name.',&nbsp;'.@$result[$key+1]['firstName'].'&nbsp;'.$result[$key+1]['lastName'] ;
						$status_ids=$status_id.','.@$result[$key+1]['status_id'] ;
					}
						endforeach; ?>
					<?php 
				}else{?>
					<tr><td><?php echo $label['noRecord']?></td></tr>
					<?php 
				}?>	
			</tbody>
		  </table>
		<?php echo form_close(); ?>
	</td>
	</tr>
</table>