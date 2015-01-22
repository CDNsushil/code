<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_users_profile');?></h2>
	</div>
	<div class="contentbox">
	
	<?php 
	 $hidden = array('user_id' => $user_id);
	$attributes = array('onSubmit' => 'return valid_userdetail()','name'=>'user_update','id'=>'user_update');
	echo form_open('admin_users/user_update',$attributes,$hidden);
	?>

		<table width="50%" align="center">
			<tbody>
				<?php $i=1; 
				if($users!=false){
					foreach($users as $users) { ?>
						<tr>
							<td>
								<div><?php echo $this->lang->line('admin_firstname');?> :</div>
								<div><input type="text" name="name" id="name" value="<?php echo $users->firstname;?>"></div>
							</td>						
							<td>
								<div><?php echo $this->lang->line('admin_lastname');?> :</div>
								<div><input type="text" name="lastname" id="name" value="<?php echo $users->lastname;?>"></div>
							</td>
						</tr>

						<tr>
							<td>
								<div><?php echo $this->lang->line('admin_email');?> :</div>
								<div><input type="text" name="email" id="email" value="<?php echo $users->email;?>"></div>
							</td>
							<td>
								<div><?php echo $this->lang->line('admin_user_dob');?> :</div>
							    <div><input type="text" name="dob" id="dob" value="<?php echo $users->dob;?>"></div>
							</td>
						</tr>
						<tr>
							<td>
								<div><?php echo $this->lang->line('admin_user_gender');?> :</div>
								<div>
									<?php if($users->sex==1) { ?>
										<?php echo $this->lang->line('admin_user_male');?>
										<input type="radio" name="gender" id="gender" value="1" checked="checked" >
										<?php echo $this->lang->line('admin_user_female');?>
										<input type="radio" name="gender" id="gender" value="0" >
									<?php } else { ?>
										<?php echo $this->lang->line('admin_user_male');?>
										<input type="radio" name="gender" id="gender" value="1"  >
										<?php echo $this->lang->line('admin_user_female');?>
										<input type="radio" name="gender" id="gender" value="0" checked="checked" >
									<?php } ?>
								</div>
							</td>
						
							<td>
								<div><?php echo $this->lang->line('admin_points');?> :
									<?php echo $point; ?>
								</div>
							</td>
					</tr>
					<tr>
							<td>
								<div><?php echo $this->lang->line('admin_country');?> :</div>
								<div>
									<select name="country" id="country" size="1" onchange="displayStates(this.value);">
										<?php foreach($country as $clist) 
										{
											if($clist->country_name == $users->country_name) { ?>
										<option value="<?php echo $clist->country_id?>" selected ><?php echo $clist->country_name;?></option>
										<?php 	} else {  ?>
										<option value="<?php echo $clist->country_id?>"><?php echo $clist->country_name;?></option>
										<?php } } ?>
									</select>
								</div>
							</td>
						
							<td>
									<div class="profile_state_box" style="float:left; margin-right:20px;">										
									<div>
										<?php echo $this->lang->line('admin_state');?> :
									</div> 
									<div>
										<?php if(!empty($c_s_c)){ 
											$state_id=$c_s_c[0]->state_id;
											$state_name=$c_s_c[0]->state_name;
											$city_id=$c_s_c[0]->city_id;
											$city_name=$c_s_c[0]->city_name;				
										}else{
											$state_id="NULL";
											$state_name="-- Please Select State--";
											$city_id="NULL";
											$city_name="-- Please Select City--";
										}					
										 ?>
										<input type="hidden" id="h_state" name="user_state" value="<?php echo $state_id ?>">
										<input type="hidden" id="h_state_name" name="user_state_name" value="<?php echo $state_name ?>">
									<?php 	
										$state_data = array('NULL'=>'-- Please Select State --');
										if(isset($state_query) && $state_query!=false):
											if($state_query->num_rows() > 0):
											//$state_data['NULL'] = '-- Please Select State --';
												foreach($state_query->result() as $row):
													$state_data[$row->state_id] = $row->state_name;
												endforeach;
											endif;
										endif;
									?>
									<?php 	
										$element_attributes = 'id="state" class="required error1" onchange="displayCities(this.value);" title="Select State"';
										echo form_dropdown('state', $state_data, set_value('state', $state_id),$element_attributes);
									?>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="profile_city_box" style="float:left;">	
									<div>
										<?php echo $this->lang->line('admin_city');?> :
									</div>
									<div>
										<input type="hidden" id="h_city" name="user_city" value="<?php echo $city_id?>">
										<input type="hidden" id="h_city_name" name="user_city_name" value="<?php echo $city_name?>">
											<?php 	
											
												$city_data = array('NULL'=>'-- Please Select City --');
												
												if(isset($city_query) && $city_query!=false):
												if($city_query->num_rows() > 0):
												$city_data[''] = '';
												foreach($city_query->result() as $row):
													$city_data[$row->city_id] = $row->city_name;
												endforeach;
												endif;
												endif;
											?>
											<?php 		
												$element_attributes = 'id="city" class="required error1" title="Select City"';
												echo form_dropdown('city', $city_data, set_value('city', $city_id),$element_attributes);
											?>	
									</div>
								</td>	
							
								<?php
									$loogged_user_data =$this->session->userdata('session_data');
									if($loogged_user_data['user_role']==1){
								?>
									<td>
										<div><?php echo $this->lang->line('admin_privacy_setting_group_head')?> :</div>
										<div>
											<select name="user_role">
	<option value="<?php echo $users->user_role?>"><?php echo $this->lang->line('admin_select_roll_type')?></option>
												<?php if(count($user_type_list)>0){
														foreach($user_type_list AS $user_type){
													?>
															<option value="<?php echo $user_type->role_id;?>"><?php echo $user_type->user_type;?></option>
												<?php }}?>
											</select>
										</div>									
									</td>
								<?php } ?>
						
							
						</tr>

						<tr><td></td>
							<td>
								<input type="submit" name="submit" id="submit" value="Save">
							</td>
						</tr>
				<?php $i++; }
				 }
				?>
			</tbody>
		</table>

	<?php 
		$string = "</div></div>";
		echo form_close($string);
	?>
<script>
$(document).ready(function(){
	var country_id = $("#country").val();
	if(country_id > 0)
	{
		displayStates(country_id);
		var state_id = $("#state").val();
		if(state_id > 0)
		{
			displayCities(state_id);	
		}	
	}
	
});

function displayStates(country_id)
{
	if (country_id > 0)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo BASEURL;?>common/load_states_by_country",
			data: "country_id="+country_id,
			dateType:'JSON',
			success: function(response){	
				if(response!="")
				{
					if(response=="[]")
					{
						$('#state').parent().find('.abc').html('-- Please select State --');
						var output = [];
						output.push('<option value="">-- Please select State --</option>');
						$('#state').html(output.join(''));
						var output = [];
						$('#city').parent().find('.abc').html('-- Please select City --');		
						output.push('<option value="">-- Please select City --</option>');				
						$('#city').html(output.join(''));
					}	
					else
					{
												
						//2nd method
						var output = [];
						response = eval("(" +response+ ")");
						var state = $('#h_state').val();
						var state_name = $('#h_state_name').val();
						
						output.push('<option selected="selected" value="'+ state +'">'+ state_name +'</option>');
						displayCities(state);
						$.each(response, function(key, value)
						{
							output.push('<option value="'+ key +'">'+ value +'</option>');
						});
						$('#state').html(output.join(''));
					}
				}
			}
		});
	}
}
 
function displayCities(state_id)
{
	if (state_id > 0)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo BASEURL;?>common/load_cities_by_state",
			data: "state_id="+state_id,
			success: function(response){	
				if(response!="")
				{		
					if(response=="[]")
					{						
						var output = [];
						$('#city').parent().find('.abc').html('-- Please select City --');		
						output.push('<option value="">-- Please select City --</option>');			
						$('#city').html(output.join(''));
					}	
					else
					{
						var output = [];
						response = eval("(" +response+ ")");
						var city = $('#h_city').val();
						var city_name = $('#h_city_name').val();
						var state = $('#h_state').val();
						output.push('<option value="">-- Please select City --</option>');
						if(state==state_id){
							output.push('<option selected="selected"value="'+ city +'">'+ city_name +'</option>');
						}else{
							output.push('<option value=""></option>');
						}
						$.each(response, function(key, value)
						{
							output.push('<option value="'+ key +'">'+ value +'</option>');
						});
						$('#city').html(output.join(''));
					}	
				}	
			}
		});
	}	
}

/* Code for display dropdown value selected */  
$('select').change(function(){
	var singleValues = $(this).find(":selected").text();
	$(this).parent().find('.abc').html(singleValues);
});

</script>
