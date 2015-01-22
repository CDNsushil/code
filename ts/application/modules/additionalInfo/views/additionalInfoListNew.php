<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$countAdditionalInfo=count($additionalInfo);
$AdditionalInfoFlag=false;
/*
echo "<pre>";
print_r($additionalInfo);
echo "</pre>";
*/
if($countAdditionalInfo > 0){
	foreach($additionalInfo as $m=>$additionalInfoData){
		if(is_array($additionalInfoData) && count($additionalInfoData) > 0){
			$AdditionalInfoFlag=true;
			break;
		}
	}
}
$sectionBgcolor=@$sectionBgcolor?$sectionBgcolor:'C5C5C5';
if($AdditionalInfoFlag){
	?>
	
    <div class="box_wrap clearb fl width250 ">
        
        <?php if(!empty($additionalInfo)){ 
            foreach($additionalInfo as $i=>$infoSection){
        
            //check info section is not empty
            if(!empty($infoSection)){
            
            $infoSectionCount = count($infoSection);     
            //----------create javascript object start------------//
            if(is_array($infoSection) && $infoSectionCount > 0){
                foreach($infoSection as $j=>$info){
                  $AIData=array('info'=>$info,'fieldPrefix'=>$fieldPrefix[$i],'section'=>$sections[$i]);
                  $AIData=json_encode($AIData);
                  $consteent=$i.'_'.$j;
                  echo ' <script>var AIData'.$consteent.'='.$AIData.';</script>';
                }
            }
        ?>
            <div id="additionalInfoSlider<?php echo  $i+1; ?>" slidercount="1" class="slider hori_slide   <?php echo ($i < 2)?'pb14 mb10 bb_b6b6b6':''; ?> ">
               <h4 class="mb12 red font_bold"><?php echo $sections[$i]; ?> </h4>
               <a class="buttons prev" href="#"><img src="<?php echo $imgPath; ?>arr_l.png" alt="" /> </a> 
               <span class="counter1 cnt_no position_absolute  fs12"><span class="current_slide">1</span>/<span class="total_slide"><?php echo $infoSectionCount; ?></span></span>
               <div class="viewport height51 verti">
                  <ul class="img_box overview fs13">
                    <?php 
                        if(!empty($infoSection)){ 
                        foreach($infoSection as $j=>$info){
                            $title=$fieldPrefix[$i].'Title';
                            $description=$fieldPrefix[$i].'Description';
                            $Title=getSubString($info->$title,20);
                            if(is_numeric($info->$description)){
                                $info->$description= ''; 
                            }
                            $Description=getSubString($info->$description,60);
                            $info->$description=urlencode( $info->$description);
                            $consteent=$i.'_'.$j;
                        ?>
                      
                        <li class="ptr" onclick="javascript:lightBoxWithAjax('popupBoxWp','popup_box','/additionalInfo/additionalInfoPopupNew',AIData<?php echo $consteent;?>);">
                            <div class="table_cell img_thum"><img src="<?php echo base_url($this->config->item($sectionsname[$i]));?>" alt="" /></div>
                            <div class="ml28">
                               <p class="lineH20"><?php echo $Title;?>
                               </p>
                            </div>
                        </li>
                    
                    <?php } } ?>  
                    
                  </ul>
               </div>
               <a class="buttons next" href="#"><img src="<?php echo $imgPath; ?>arr_r.png" alt="" /></a> 
            </div>
                     
        <?php }  }  }  ?>
      
    </div>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $('#additionalInfoSlider1').tinycarousel();	
            $('#additionalInfoSlider2').tinycarousel();
            $('#additionalInfoSlider3').tinycarousel();
        });
    </script> 

<?php
    }
?>
