<?php
    if($bookmarks){
			$bookmark =	$this->uri->segment(6);
			$bookmarkId =	$this->uri->segment(5);	
?>
<div class="sap_40"></div>
<div class="fs16 mr6 ml3 forum_list position_relative opensans_semi  pb10 bb_F1592A">Discussion Bookmarks <span class="tab_btn" id="tab_btn1"></span>
 </div>
 <ul class=" list_mb15 mt30 ml3 mr6 forum_list" style="<?php if($bookmark == "bookmark"){ echo 'display:block'; } ?>"  id="sub_cat1">
          <?php
                // Build all top level categories
                foreach($bookmarks as $row)
                {
            ?>
            <li> <a href="<?php echo base_url_lang('help/posts/'.$this->topics_m->getCategoryId($row['bookmark_topic_id']).'/'.$row['bookmark_topic_id'])?>/bookmark" class="<?php if($row['bookmark_topic_id'] == $bookmarkId){ echo 'red'; } ?>" > <?php echo $row['bookmark_topic_title']; ?></a></li>
         <?php   }   ?>
 </ul>
<?php   }   ?>
