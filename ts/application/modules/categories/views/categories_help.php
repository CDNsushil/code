<?php

if($categories)
{
	

?>

    <!----<div class="sidebar_box">---->
    <div class="sidebar_box">
<div class=" font_opensans font_size18 clr_white categordbtnline">Categories</div>

	<ul>
	 <!----<li> <a href="<?php echo site_url().'help'; ?>" class="fl"> All Categories </a>  <div class="clear"></div> </li>	---->
   <?php
	$t=1;
	$countRow=0;
	
	//print_r($categories);die;
    foreach($categories as $row)
		{
			$categories_count = $this->categories_m->get_categories_count($row['CategoryID']);	
			$sub_categories = $this->categories_m->get_sub_categories($row['CategoryID'],'help');
			
	if($row['parentID']==0)
		{
			 ?>
   
    <li> <a href="<?php echo site_url().'help/topics/'.$row['CategoryID']; ?>" class="fl <?php if(isset($selectedCategory)){ if($selectedCategory==$row['CategoryID']){ echo "selected_category_orange"; } } ?> dash_link_hover"> <?php echo $row['Name']; ?>&nbsp;[<?php echo  $categories_count; ?>] </a> 
    
    
    <?php if(count($sub_categories) > 0) { ?>
    
    <div class="tab_btn_wrapper mt8">
            <div class="tds-button-forum">
              <a> <span>
              <div toggledivid="NEWS-Content-Box<?php echo $t; ?>" class="forumToggleIcon"></div>
              </span> </a> </div>
          </div>
          
    <div class="clear"></div>
    
    <div class="scrollbox showcase_link_hover" id="NEWS-Content-Box<?php echo $t; ?>"> 
    <ul>
    <?php  foreach($sub_categories as $sub_row)
                {
			$categories_count = $this->categories_m->get_categories_count($sub_row['CategoryID']);		 ?>
			<li> <a href="<?php echo site_url().'help/topics/'.$sub_row['CategoryID']; ?>">- <?php echo $sub_row['Name']; ?>  [<?php echo $categories_count; ?>] </a> </li>
    <?php  } ?>
    </ul>
    </div>
    <?php } ?>
    
    <div class="clear"></div>
    </li>
    
    <?php $countRow++; } if($countRow==3) { echo '<div class="seprator_35"></div>'; } ?>
    <?php $t++; 
		} ?>
    
 	</ul>
</div>
 

<?php
}
?>
<div class="text_alignR clr_white font_size18 font_opensan bdrB_6e6e6e pb4"><a href="<?PHP echo site_url();?>forums" class="clr_white dash_link_hover">Forum</a> <span class="aerrow_forum"></span></div>

<script type="text/javascript">
$('.forumToggleIcon').click(function(){
			var togDivId = $(this).attr('toggleDivId');
			if($(this).css("background-position")=='0px -23px'){
				$(this).css("background-position","0px -00px")
				
			}else{
				$(this).css("background-position","0px -23px");
			}
			$('#'+togDivId).slideToggle("slow");
		}); 


	
$("#billing_detail").click(function(){
  	$(".billing_detailbox").toggle();
						  
  });
  
  
</script>
