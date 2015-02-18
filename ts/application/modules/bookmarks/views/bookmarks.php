<?php

if($bookmarks)
{
?>
<div class=" seprator_45"></div>
<div class="sidebar_box">
<div class="font_opensans font_size18 clr_white categordbtnline"><?php echo $this->lang->line('bookmarksSidebarHeading'); ?>
<div class="tds-button-top fr mr0 mt10 mr-15 showhidebookmark width_20 height_21">
                <a>
                    <span>
                   <!---- <div class="cat_smll_add_icon ml3 mt3"></div>---->
                  <div id="Sent" class="projectToggleIcon" onclick="viewSent()" toggledivid="NEWS-Content-Box2" style="background-position: -1px -121px;"></div>
                   </span>
               </a>
           </div>
</div>


	<div id="showBookmark" class="dn showcase_link_hover">
		<ul >
			<?php
			// Build all top level categories
			foreach($bookmarks as $row)
			{
				echo '<li>'.anchor('forums/posts/'.$this->topics_m->getCategoryId($row['bookmark_topic_id']).'/'.$row['bookmark_topic_id'].'', $row['bookmark_topic_title']).'</li>';
			}
			?>
		</ul>
	</div>
</div>
<?php
}
?>


<script type="text/javascript">
	
$(".showhidebookmark").click(function(){
	
	$(this).css("display","block");
  	$("#showBookmark").slideToggle("slow");
  });
  
</script>


