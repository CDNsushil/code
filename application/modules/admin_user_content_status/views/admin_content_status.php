<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('content_status')?></h2>
	</div>
	<div class="table">
	
	<!--Start Posts section-->
			<div class="fleft">
				<h3><?php echo $this->lang->line('chatching_content_status')?></h3>
			</div>
		<div class="fleft padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=&type=today">
                <?php echo $this->lang->line('number_posts_today')?>
            </a>
		</div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=&type=today"><?php echo $total_posts['res1'];?></a>
		</div>
		<div class="clear"></div>
		<div class="fleft padding-common">
            <a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=&type=week">
                <?php echo $this->lang->line('number_posts_week')?>
            </a>    
		</div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=&type=week"><?php echo $total_posts['res2'];?></a>
		</div>
		<div class="clear"></div>
            <div class="fleft padding-common">
                <a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=&type=month">        
                    <?php echo $this->lang->line('number_posts_month')?>
                </a>
            </div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=&type=month"><?php echo $total_posts['res3'];?></a>
		</div>
		<div class="clear"></div>
		<div class="fleft padding-common">
            <a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=&type=year"> 
                 <?php echo $this->lang->line('number_posts_year')?>
            </a>
		</div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=&type=year"><?php echo $total_posts['res4'];?></a>
		</div>
		<div class="clear"></div>
		
		<div class="fleft padding-common">
			<?php echo $this->lang->line('total_deleted_posts')?>
		</div>
		<div class="fright padding-common">
			<?php $total_deleted_posts=$total_comments['res6']+$total_wall_posts['res6'];echo ($total_deleted_posts);?>
		</div>
		
				<div class="fleft padding-common">
			<?php echo $this->lang->line('number_posts_chatching')?>
		</div>
		<div class="fright padding-common">
			<?php echo $total_deleted_posts+$total_posts['res5'];?>
		</div>
		<div class="clear"></div>

<!--End Posts section-->
	</div>
	<div class="border"></div>
	<div class="table">
<!--Start Wall Post section-->
		<div class="fleft">
				<h3><?php echo $this->lang->line('chatching_content_status_activity')?></h3>
		</div>
            <div class="fleft padding-common">
            <a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=Status Update&type=today">        
                <?php echo $this->lang->line('number_posts-status_today')?>
            </a>
		</div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=Status Update&type=today"><?php echo $total_wall_posts['res1'];?></a>
		</div>
		<div class="clear"></div>
		<div class="fleft padding-common">
            <a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=Status Update&type=week">
                <?php echo $this->lang->line('number_posts-status_week')?>
            </a>
		</div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=Status Update&type=week"><?php echo $total_wall_posts['res2'];?></a>
		</div>
		<div class="clear"></div>
            <div class="fleft padding-common">
            <a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=Status Update&type=month">        
                <?php echo $this->lang->line('number_posts-status_month')?>
            </a>
		</div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=Status Update&type=month"><?php echo $total_wall_posts['res3'];?></a>
		</div>
		<div class="clear"></div>
		<div class="fleft padding-common">
            <a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=Status Update&type=year">
                <?php echo $this->lang->line('number_posts-status_year')?>
            </a>
		</div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=Status Update&type=year"><?php echo $total_wall_posts['res4'];?></a>
		</div>
		<div class="clear"></div>

		<div class="fleft padding-common">
			<?php echo $this->lang->line('number_posts-status_deleted_chatching')?>
		</div>
		<div class="fright padding-common">
			<?php echo $total_wall_posts['res6'];?>
		</div>
		<div class="clear"></div>

		<div class="fleft padding-common">
			<?php echo $this->lang->line('number_posts-status_chatching')?>
		</div>
		<div class="fright padding-common">
			<?php echo $total_wall_posts['res5'];?>
		</div>
		<div class="clear"></div>
	<!--End Wall Post section-->
	</div>
	<div class="border"></div>
	<div class="table">
<!--Start Comment section-->
		<div class="fleft">
				<h3><?php echo $this->lang->line('chatching_content_status_comment')?></h3>
		</div>
		<div class="fleft padding-common">
            <a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=comment&type=today">
                <?php echo $this->lang->line('number_comments_today')?>
            </a>
		</div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=comment&type=today"><?php echo $total_comments['res1'];?></a>
		</div>
		<div class="clear"></div>
		<div class="fleft padding-common">
            <a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=comment&type=week">
                <?php echo $this->lang->line('number_comments_week')?>
            </a>
		</div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=comment&type=week"><?php echo $total_comments['res2'];?></a>
		</div>
		<div class="clear"></div>
        <div class="fleft padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=comment&type=month">
                <?php echo $this->lang->line('number_comments_month')?>
            </a>
		
        </div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=comment&type=month"><?php echo $total_comments['res3'];?></a>
		</div>
		<div class="clear"></div>
		<div class="fleft padding-common">
            <a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=comment&type=year">
                <?php echo $this->lang->line('number_comments_year')?>
            </a>
		</div>
		<div class="fright padding-common">
			<a href="<?php echo BASEURL?>admin_manage_content?user=&filter_post_type=comment&type=year"><?php echo $total_comments['res4'];?></a>
		</div>
		<div class="clear"></div>
		
		<div class="fleft padding-common">
			<?php echo $this->lang->line('number_deleted_comments_chatching')?>
		</div>
		<div class="fright padding-common">
			<?php echo $total_comments['res6'];?>
		</div>
		<div class="clear"></div>
		
		<div class="fleft padding-common">
			<?php echo $this->lang->line('number_comments_chatching')?>
		</div>
		<div class="fright padding-common">
			<?php echo $total_comments['res5'];?>
		</div>
		<div class="clear"></div>
	<!--End Comment section-->
	</div>
</div>
