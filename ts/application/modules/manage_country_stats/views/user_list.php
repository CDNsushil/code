<div class="contentcontainer">
	<div class="headings altheading">
		<span class="admin_user"><h2><?php echo $this->lang->line('admin_users');?></h2></span>
	</div>

	<div class="contentbox">

			<div class='fRight'>
				
				

				<div class="fLeft">

				<?php 	// Second search form start
				   
					$attributes = array('name'=>'search_form','id'=>'search_form','method'=>'get');
					echo form_open('',$attributes);
					 
				?>
			
					<div class="fLeft">
					<input type="text" name="user_search"  value="<?php if(!empty($search_user)){echo $search_user;}?>" PLACEHOLDER="Name or UserID">
						</div>	
						<div title="Search member by name" class="tooltipClass fLeft">
								<input type="image" src="<?php echo ADMINIMG."search.jpg";?>"  alt="Search" width="15px" />
						</div>
						<div class="clear"></div>
					<?php 
						$string = "</div>";
						echo form_close($string);
					?>
					

			<div class="clear"></div>
			</div>
			<div class="clear"></div>

		<table width="100%">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('admin_userid');?></th>
					<th><?php echo $this->lang->line('admin_users');?></th>
					<th >
					   <img height="20px" src="<?php echo ADMINIMG?>/fav.png" class="tooltipClass" title="View user profile">
					</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=1; 
				if($users!=false){
					foreach($users->result() as $users){?>
						<tr>
						    <td><?php echo $users->user_id;?></td>
						    <td><?php echo ucfirst($users->firstname)." ".$users->lastname; ?>
							</div>
						     </td>					
					
					  	    <td>
							<a href="<?php echo BASEURL?>admin_users/user_profile/<?php echo $users->user_id?>" >
							<img src="<?php echo ADMINIMG.'fav.png';?>" height="20px"  class="tooltipClass" title="View <?php echo ucfirst($users->firstname).' '.$users->lastname;?> profile" />
							</a>
						    </td>
						</tr>
				<?php 
						$i++; 
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
