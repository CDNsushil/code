<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('manage_content')?></h2>
	</div>
	<form action='' method="get" >
	<table class="fright">
	<tr><td>
					<select name="user" ">
						<option value="">--select User --</option>
						<?php if(!empty($all_users)){?><?php foreach($all_users as $all_users1):?>
						<?php if($all_users1->username!=''):?>
						<option  <?php if($user_filter_name==$all_users1->user_id){?> selected="selected"<?php }?> value="<?php echo $all_users1->user_id;?>">
						<?php echo $all_users1->firstname;?>&nbsp;<?php echo $all_users1->lastname;?>
						</option>
						<?php endif?>
						<?php endforeach?>
						<?php }else{echo "No Records";}?>
				    	</select>
	</td>
	<td>
	<select name="filter_post_type" ">
		<option value="">--Select Post Type--</option>
						<?php if(!empty($all_post_type)){?><?php foreach($all_post_type as $posts_type):?>
						<?php if($posts_type->action_name!=''):?>
						<option  <?php if($post_type_filter==$posts_type->action_name){?> selected="selected"<?php }?> value="<?php echo $posts_type->action_name;?>">
						<?php echo $posts_type->action_name;?>
						</option>
						<?php endif?>
						<?php endforeach?>
						<?php }else{echo "No Records";}?>		
		
	
	</select>
	<input type="hidden" name="type" value="<?php $type = $this->input->get('type');if(!empty($type)){echo $type;}?>">
	</td>
	<td class="tooltipClass fLeft">
					<input width="15px" type="image" alt="Search" src="<?php echo ADMINIMG."search.jpg";?>">
				
	</td>
	</tr>
	</table>
	</form>
	
		<table style="width:100%">
			<thead>
				
				
				<th><?php echo $this->lang->line('user_name')?></th>
				<th><?php echo $this->lang->line('post_type')?></th>
				<th><?php echo $this->lang->line('post_content')?></th>
				<th><?php echo $this->lang->line('date')?></th>
				<th>
					   <img height="20px" src="<?php echo ADMINIMG?>/fav.png" class="tooltipClass" title="View user profile">
				</th>
				<th><?php echo $this->lang->line('table_action')?></th>
			</thead>
			<?php if(!empty($posts_result)){?>
			<?php foreach($posts_result as $posts_result):?>
			<tr id="fadout<?php echo $posts_result['post_record_id']?>" class='user_content_tr'>

				<td>
				<div class="user_box">
                    <?php
                    // call get image helper function to get url of the image
						$profile_image_dimention = $this->config->item('__40X40__');
						$image_src = getimage('user', 2, $posts_result['user_id'],'','','','',$profile_image_dimention); 
                        /*----------- If User login with facebook------------*/
                        if(substr($image_src, 0, 26) == "https://graph.facebook.com"){
                            $width = 'width = "40"'; $height = 'height = "40"';
                        } 
                        else{
                            $width = ''; $height = '';
                        }
                    ?>
                    
				<img src="<?php echo $image_src;?>" <?php echo $width.' '.$height;?>/>
				</div><!--user_box-->
				<div class="user_name-box">
					<?php echo get_username($posts_result['user_id'])?>
				</div>
				</td>	
				<td>
				<?php echo $posts_result['action_name'];?>
				</td>
				<td><?php if($posts_result['post_type']==5){
					echo $posts_result['comment'];
					};?>
				<?php 
                    if($posts_result['post_type']==2){
                        $wall_content = preg_replace("#(<a.*?>|</a>)#i",'',$posts_result['wall_content']);
                        echo substr($wall_content, 0, 25)."...";
					};
                ?>
		<?php if($posts_result['post_type']==4){ ?>
				 <a class="upload_photo_onwall upload_photo_onwall player" href="<?php echo USER_PROFILE_IMAGE; ?>user_<?php echo $posts_result['post_user_id'] ?>/album/wall/wall_video/<?php echo $posts_result['media_name'];?>"> </a>
		<?php }?>
				<?php if($posts_result['post_type']==1){ ?>
				<?php ?>
					<img width="92"height="88" src="<?php echo getimage('media', 1, $posts_result['post_user_id'], $posts_result['media_name'], 'thumb',1); ?>" />
					<?php };?>
				
				</td>	
				<td><?php 
				echo date("d F,Y h:i:s",$posts_result['actiondatetime']);?>

				</td>
				<td>
						<a href="<?php echo BASEURL?>admin_users/user_profile/<?php echo$posts_result['user_id']?>" >
							<img src="<?php echo ADMINIMG.'fav.png';?>" height="20px"  class="tooltipClass" title="View <?php echo get_username($posts_result['user_id'])?> profile" />
						</a>
				</td>	
			
				<td>
					<a href="javascript:void(0)" title="Delete post" class="tooltipClass" onclick="posts_delete_confirm('<?php echo $posts_result['post_record_id']?>','<?php echo $posts_result['table']?>');">
				<div class="delete_icon" ></div>
				</a>
				</td>
			</tr>
			<?php endforeach?>
			<?php }else{
			echo "No Record Found.........";}?>
			
		</table>
	<div id="pagination">
		<?php echo $paging ?>
	</div>
</div>
 
