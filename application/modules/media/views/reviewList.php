<? if (!empty($result) && (isset($result))) { ?>

<div class="sub_col_middle global_shadow_light mt18">
<div id="pagingContent">
    <?php $space='row  mt5';$i=1;?>     
            <!--loop01-->
            <?php foreach ($result as $proj) {  

              $userData= showCaseUserDetails($proj->userId);
              
              $img=(!empty($proj->imagePath))?$proj->imagePath:$userData['userImage'];  ?>               
             
              <div class="row all_list_item">
				<div class="seprator_5"></div>
				<div class="<?php echo  $space ?>">
				  <div class="cell width_114">
					<div class="blog_profile_img">
					  <div class="AI_table">
						<div class="AI_cell C555"><img class="review_thumb" src="<?php echo base_url().$img ?>"></div>
					  </div>
					</div>
					<div class="blog_profile_name"><?php echo $userData['userFullName'] ?></div>
					<div class="blog_profile_date"><?php echo $proj->createdDate ?></div>
				  </div>
				  <div class="cell width_310 padding_left16">
					<div class="blog_profile_title"><?php echo $proj->title ?></div>
					<div class="blog_profile_txt"><?php echo $proj->article ?> </div>
				  </div>
				  <div class="clear seprator_13"></div>
				  <div class="blog_status_bar padding_left10 padding_right10"> <span class="blogS_crave_btn Fleft width_40"><?php echo $craveCount ?></span> <span class="blogS_view_btn Fleft"><?php echo $viewCount ?></span> <span class=" Fright"><?php echo $i?> / <?php echo count($result) ?></span> </div>
				</div>
            </div>
           <?php $i++; $space='row  mt25';?>
           <? } ?>
    </div>
    <!--pagination area-->
   
</div>

<div class="clear"></div>


<?php
$post_page['record_num'] = 1;
?>


<?php //$data['record_num']=1;
				 if(count($result) > 1){ 					
					$this->load->view('pagination_view',array('totalRecord'=>count($result),'record_num'=>'1'));
					}
				?>
				
				
<? } ?>


