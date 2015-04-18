<?php
    if($categories){
?>
    <span class="sap_30"> </span>
    <div class="fs16 mr6 ml3 forum_list position_relative opensans_semi  pb10 bb_F1592A">Categories 
    <span class="tab_btn active" id="tab_btn"></span>
    </div>
    <ul class=" list_mb15 mt30 ml3 mr6 forum_list " id="sub_cat">
        <li><a href="<?php echo base_url_lang('help'); ?>" >All Categories</a></li>
        
             <?php
                $t=1;
                $countRow=0;
                foreach($categories as $row)
                    {
                        
                        
                        $categories_count = $this->categories_m->get_categories_count($row['CategoryID']);	
                        $sub_categories = $this->categories_m->get_sub_categories($row['CategoryID'],'help');
                        
                        //check is child menu
                        $isChildMenu = false;
                        
                        if(!empty($sub_categories) && searchinarray($sub_categories,'CategoryID',$selectedCategory)){
                            $isChildMenu = true;
                        }
                        
                        
                        
                        $naviSelectedClass = ($isChildMenu || $selectedCategory==$row['CategoryID'])?"red":"";
                        
                if($row['parentID']==0)
                    {	
                        
            ?>
                <li>
                    <a href="<?php echo base_url_lang('help/topics/'.$row['CategoryID']); ?>" class="<?php echo $naviSelectedClass; ?>" ><?php echo $row['Name']; ?>&nbsp;[<?php echo  $categories_count; ?>]</a>
                
                <?php if(count($sub_categories) > 0) { 
                    
                    ?>
                    
                    <span class="tab_ul"></span>
                    
                        <ul class="sup_form" <?php echo ($isChildMenu)?'style="display:block"':''; ?> >
                            
                            <?php  foreach($sub_categories as $sub_row)
                                    {
                                    $categories_count = $this->categories_m->get_categories_count($sub_row['CategoryID']);		 ?>
                                    <li> <a class="<?php echo ($selectedCategory==$sub_row['CategoryID'])?'red':''; ?>"   href="<?php echo base_url_lang('help/topics/'.$sub_row['CategoryID']); ?>">- <?php echo $sub_row['Name']; ?>  [<?php echo $categories_count; ?>] </a> </li>
                            <?php  } ?>
                    
                        </ul>
                    
                <?php } ?>
                </li>
            <?php  
                    $countRow++; 
                    } 
                    //echo ($countRow==3)?'<div class="sap_20"></div>':'';
                    $t++;
                } 
            ?>
     
        
     </ul>

<?php   }   ?>

