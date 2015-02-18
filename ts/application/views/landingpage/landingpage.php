<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$bgColor = isset($bgColor)?$bgColor:'';
$saprator = isset($saprator)?$saprator:'';
$containerWidth = isset($containerWidth)?$containerWidth:'width900';
?>
<div class="newlanding_container <?php echo $bgColor;?>">
   <div class="<?php echo $containerWidth;?> m_auto">
          <div class="<?php if(empty($saprator)){ echo 'mt15'; }?>">
              <?php 
              if(!empty($saprator)){?>
                <div class="<?php echo $saprator;?>"></div>
                 <?php
              }
                 if(is_array($navigations) && !empty($navigations)){
                    $activeNav = ($method != 'craved')?'active':''; 
                    ?>
                     <ul class="landing_nav <?php echo $activeNav;?> fl position_relative">
                        <li class="fs18">
                          <span class="landing_slected active"><?php echo $navigationHeading; ?></span>
                            <ul class="subnav  fs15 zindex_999  bg_fff">
                              <?php 
                                    foreach($navigations as $key=>$nav){
                                        $activeClass = ($method==$key)?'class="active"':'';
                                        echo '<li '.$activeClass.'> <a href="'.$nav['url'].'">'.$nav['title'].'</a> </li>';
                                    }
                              ?>
                            </ul>
                        </li>
                     </ul>
                 <?php
                 }else{
                     ?>
                     <ul class="landing_nav  active fl position_relative">
                        <li class="fs20 "> <span class="landing_slected"><?php echo $navigationHeading; ?></span> </li>
                      </ul>
                    <?php
                }
              //if(isset($countCravedProject) && ($countCravedProject > 10) && isset($craveNav) && is_array($craveNav) &&  !empty($craveNav)){
              if(isset($craveNav) && is_array($craveNav) &&  !empty($craveNav)){
                   $activeCraveNav = ($method == 'craved')?'active':'';
                   if(count($craveNav) == 1){ 
                        echo '<ul class="landing_nav lp_c_nav  fr position_relative"><li class="fs20 '.$activeCraveNav.'">';
                                foreach($craveNav as $key=>$nav){
                                    echo '<a href="'.$nav['url'].'" ><span class="landing_slected">'.$nav['title'].'</span></a>';
                                }
                         echo '</li></ul>';   
                    }else{
                        echo '<ul class="landing_nav  '.$activeCraveNav.' fr position_relative">';
                            echo '<li class="fs18"><span class="landing_slected active">'.$craveHeading.'</span>';
                                echo '<ul class="subnav position_absolute fs15  zindex_999  bg_fff"> ';
                                    foreach($craveNav as $key=>$nav){
                                        $cravedFor = isset($cravedFor)?$cravedFor:false;
                                        $activeClass = ($cravedFor==$key)?'class="active"':'';
                                        echo '<li '.$activeClass.'> <a href="'.$nav['url'].'">'.$nav['title'].'</a> </li>';
                                    }
                                echo '</ul>';
                            echo '</li>';
                        echo '</ul>';
                    }
              }?>
           
           <?php 
             if(isset($innerView) && !empty($innerView)){
                 $this->load->view($innerView);
             }
           ?>
         </div>
    </div>
</div>
<script>
    function getLandingPageData(url,DivID,value,limit,offset) {
        var totalCol = 0;
        if(!$.isEmptyObject(DivID)){
            $.each(DivID, function(key, value) {
                totalCol ++;
            });
        };
        
        var busy = true;
        var result = false;
        
        $.ajax({
            type: 'POST',
            url : url,		
            dataType :'json',
            data : {
                value:value,
                limit:limit,
                offset:offset,
                ajaxHit:1
            },
            beforeSend:function(){
            
            },
            complete:function(){
                
            },
            success:function(data){
                            
                if(!$.isEmptyObject(data)){
                    offset = offset+limit; 
                    var c=0;
                    $.each(data, function(key, value) {
                        if(totalCol > 0 && $.isNumeric(key)){
                            $.each(DivID, function(k,v) {
                                if((c >= k) && ((c-k)%totalCol) == 0){
                                    $(v).append(value);
                                    
                                }
                            });
                            c++;
                        }
                    });
                    //$this.find('.content').append(data);
                    
                    busy = false;
                    
                }else{
                    busy = true;
                    $('.loading-bar').html('');
                }
                
                result = {"busy":busy,"offset":offset}
                
            },
            async:false,
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError); 
            }
        });
        return result;
    }    
</script>
