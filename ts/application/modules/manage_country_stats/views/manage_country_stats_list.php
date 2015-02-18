<div class="contentcontainer">
	<div class="headings altheading">
		<span><h2><?php echo $this->lang->line('manage_country_stats');?></h2></span>
	</div>

	<div class="contentbox">
		
		<div id="main">
		<form action="" method="get">
		<div>
				<div class="fLeft">
					<h3><?php echo $this->lang->line('manage_country_stats_showing');?>&nbsp;<?php echo $country_arr->num_rows();?>
					<?php echo $this->lang->line('manage_country_stats_countries');?></h3>
				</div>
				    <div class="fRight">						
						<input class="tooltipClass" title="Search" width="18px" type="image" alt="Search" src="<?php echo ADMINIMG."search.jpg";?>">				
					</div>
					<div class="fRight">			
						<input type="text" name="search_country" value="<?php if(!empty($search_country)){echo $search_country;}else{echo "Search Country";}?>" id="search_country" onfocus="watermark('search_country','Search Country');" onblur="watermark('search_country','Search Country');">
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
		</div>
	</form>
	<table width="100%">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('manage_country_stats_country');?></th>
					<th><?php echo $this->lang->line('manage_country_stats_total_users');?></th>
					<th><?php echo $this->lang->line('manage_country_stats_males');?></th>
					<th><?php echo $this->lang->line('manage_country_stats_females');?></th>
					<th><?php echo $this->lang->line('manage_country_stats_other');?></th>
				</tr>
			</thead>
			
			<tbody>
				<?php  
				if(!empty($country_arr)){
					foreach($country_arr->result() as $country){?>
						<tr>
						    <td><?php echo $country->country_name;?></td>
						    <td><a href="<?php echo BASEURL?>manage_country_stats/user_list/<?php echo $country->country_id?>?gender=''"><?php $user_count = get_country_total_user($country->country_id);echo $user_count;?></a></td>					
							<td><a href="<?php echo BASEURL?>manage_country_stats/user_list/<?php echo $country->country_id?>?gender=male"><?php $total_male_count = get_country_total_genders($country->country_id);echo $total_male_count['male'];?></a></td>
							<td><a href="<?php echo BASEURL?>manage_country_stats/user_list/<?php echo $country->country_id?>?gender=female"><?php $total_female_count = get_country_total_genders($country->country_id);echo $total_female_count['female'];?></a></td>
							<td><a href="<?php echo BASEURL?>manage_country_stats/user_list/<?php echo $country->country_id?>?gender=other"><?php $total_other_count = get_country_total_genders($country->country_id);echo $total_other_count['other'];?></a></td>
						</tr>
				<?php 
					}
				 }
				?>
			</tbody>
		</table>
	</div>

	<div id="pagination">
		<?php echo $paging; ?>
	</div>
</div>
<script type="text/javascript">
function watermark(inputId,text){
  var inputBox = document.getElementById(inputId);
    if (inputBox.value.length > 0){
      if (inputBox.value == text)
        inputBox.value = '';
    }
    else
      inputBox.value = text;
}
</script>
