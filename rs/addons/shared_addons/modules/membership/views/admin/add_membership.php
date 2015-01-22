<?php    defined('BASEPATH') or exit('No direct script access allowed');  /***This for used to add/edit membership details ***/ ?>

<?php     
    if ($this->method == 'edit'): ?>
	<section class="title">
    	<h4><?php echo lang('membership:edit_membership'); ?></h4>
	</section>
<?php else: ?>
	<section class="title">
    	<h4><?php echo lang('membership:add_membership'); ?></h4>
	</section>
<?php endif ?>

<section class="item">
	<div class="content">
		<?php echo form_open(uri_string(), 'class="crud"') ?>
		
		<div class="form_inputs">
		
		    <ul>
				<li>
					<label for="title"><?php echo lang('membership:title');?> <span>*</span></label>
					<div class="input"><?php echo form_input('membership_title', $membership->membership_title);?></div>
				</li>
				
				<li class="even">
					<label for="price"><?php echo lang('membership:price');?> <span>*</span></label>
					<div class="input"><?php echo form_input('membership_price', $membership->membership_price);?></div>
				</li>
				<li>
					<label for="membership_status"><?php echo lang('membership:status');?> <span>*</span></label>
					<div class="input">
						<?php
						      $selected=$membership->membership_status;
						      $titleArray=array(lang('membership:enabled'),lang('membership:disabled'));
							  $other='class="" id="membership_status" ';
						      echo form_dropdown('membership_status',$titleArray, $selected, $other);
						  ?>
						</div>
				</li>
				
					<li>
					<label for="membership_days"><?php echo lang('membership:membership_days');?> <span>*</span></label>
					<div class="input">
						<?php
						
						      $selected=$membership->membership_days;
						      $titleArray=array(''=>lang('membership:membership_day_select'),'15'=>15,'30'=>30,'45'=>45,'60'=>60,'90'=>90,'120'=>120,'180'=>180,'270'=>270,'365'=>365);
							  $other='class="" id="membership_days" ';
						      echo form_dropdown('membership_days',$titleArray, $selected, $other);
						  ?>
						</div>
				</li>
				
				<li class="even">
					<label for="membership_features"><?php echo lang('membership:membership_features');?> <span></span></label>
					<div class="membership_div">
						<?php 
						    if(isset($features) && !empty($features)){
								foreach($features as $feature){
									$selected='';
									if(isset($selectFeatures) && !empty($selectFeatures)){
										foreach($selectFeatures as $select){
											if($select->feature_id==$feature->id){
												$selected='true';
											}
										}
									}
									$featureDescription=$feature->feature_description;
									$checkField = array(
										'name'			=> 'membership_features[]',
										'value'			=> $feature->id,
										'checked'		=> $selected,
										'type'			=> 'checkbox',
										'title'			=> $featureDescription
									);
									$other=$selected;
									echo '<div class="feature_div">'.form_checkbox($checkField);
									echo "<span class='feature_span'>".$feature->feature_title."</span></div>";
								}
							}
							?>
							<div class="clear"></div>
					</div>
				</li>
				<li>
					<label for="description"><?php echo lang('membership:description');?> <span></span></label>
					<div class="input"><?php echo form_textarea	('membership_description', $membership->membership_description);?></div>
				</li>
				
		    </ul>
		
		</div>
		
		<div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
		</div>
			
		<?php echo form_close();?>
	</div>
</section>

