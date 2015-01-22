<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form show all memberships?>
<?php
	$userId=is_logged_in();
?>
	<h4>
		<?php echo lang('membership:manage_memberships'); ?>
	</h4>

	<div class="content">
		
			<table class="table-list" cellspacing="0">
				<thead>
					<tr>
						<?php $memberIds=array(); ?>
						<?php if(isset($memberships) && !empty($memberships)): ?>
						<th width="300">Plan</th>
						<?php foreach ($memberships as $membership): $memberIds[]=$membership->id; ?>
						<th width="200">
								<?php echo ucfirst($membership->membership_title); ?> 
								  <?php echo lang('membership:for').' ';  echo $membership->membership_days; ?> Days <br>
								 (<?php echo lang('membership:price'); ?> $<?php echo $membership->membership_price; ?>)
						</th >
						
						<?php endforeach;?>
						<?php endif;?>
					</tr>
				</thead>
				<tbody>
						<?php  if(isset($features) && !empty($features)): ?>	
						<?php foreach ($features as $key=>$feature):?>
						<tr>
								<td>	
								<br>
								 <b><?php echo $feature->feature_title; ?> </b><br>
									<?php echo $feature->feature_description; ?>
								<br>
								</td>
								<?php if(!empty($memberIds)): ?>
								<?php foreach($memberIds as $memberId): $count=0;?>
								
									<?php  if(isset($selectFeatures) && !empty($selectFeatures)): ?>
									<?php  foreach ($selectFeatures as $select): ?>
										<?php
										
										if($feature->id==$select->feature_id && $memberId==$select->membership_id){ 
										$count=1;
										?>
											<td align="center"><br>
												<div ><?php echo lang('membership:yes');?> </div>
											<br></td>
									<?php } ?>
										
								<?php endforeach; ?>
								<?php endif;
								//end of inner if 
								?>
								<?php if($count==0){ ?>
										<td align="center"><br>
										<div ><?php echo lang('membership:no');?> </div>
										<br></td>
										<?php } ?>
									
								<?php endforeach; ?>
								<?php endif;?>
								
							</tr>
								
							<?php endforeach;?>
							<?php endif;
							//end of outer if 
							?>
							
				    		<tr>
								<?php if(!$userId):?>
									<?php if(isset($memberships) && !empty($memberships)): ?>
									<th width="300"><b></b></th>
									
									<?php foreach ($memberships as $membership): ?>
									<td width="200" class="actions" align="center"><?php echo anchor('register?id='.$membership->id,'Join', 'class="button join_btn"');
							?></td>
									<?php endforeach;?>
									<?php endif;?>
								<?php endif;?>
							</tr>
						
				</tbody>
				
			</table>
	</div>




