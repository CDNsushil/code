<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="poup_bx width_400 shadow">
    <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
    <h3 class=""><?php echo $this->lang->line('shippingCharges');?></h3>
    <?php 
        if(!empty($shippingZones)){
    ?>
    <div class="row">
        
        <div class="fl width210 ">
         
            <?php
                  $zoneCountries=array();
                  $l=0;
                  foreach($shippingZones as $k=>$zone){
                      if($zone['spId']>0 && $zone['status']=='t'){
                        
                        $zoneFlag=true;
                        $continentCountries[$zone['zoneId']]=$zone['countriesId'];
                        $shortDesc=str_replace("'","&apos;",$zone['shortDesc']);
                        $shortDesc=str_replace('"',"&quot;",$zone['shortDesc']);
                        $checked='';
                        if($l == 0){
                            $firstShortDesc=$shortDesc;
                            $checked='checked';
                            
                        }
                        $l=($l+1);
                        ?>   
                        <div class="zone_div row pb10 fl clearb ">
                            <div class="defaultP fl">
                                <input <?php echo $checked;?> class="ez-hide " type="radio"  name="zoneId" value="<?php echo $zone['zoneId'];?>" onclick="showCurrentHideEach('#countryListing<?php echo $zone['zoneId'];?>','.countryListing'); $('#sippingSD').html('<?php echo $shortDesc;?>')" ></div>
                            <span class="fl pl10 lineH26 pr10"><?php echo $zone['title'];?></span> 
                            <input readonly type="text" name="" class="p5 width_50imp text_alighC"  value="<?php echo $this->lang->line('EURO').number_format($zone['amount'],2);?>">
                        </div>
             
                        <?php
                        }
                    }
            ?>
          
        </div>
       
       <div class="SP_select_country_box fr ">
          <ul class="list_pb10 ">
            <?php  
                if($zoneFlag){ 
                    $i=0;
                    foreach($continentCountries as $zoneId=>$countriesId){
                        $Countries=zoneCountries($countriesId);
                        $Countries = explode(',',$Countries);
                        $dn=$i==0?'':'dn';?>
                         <div class="<?php echo $dn?> countryListing" id="countryListing<?php echo $zoneId;?>">
                            <?php
                                foreach($Countries as $countryName){ ?>
                                      <li><?php echo $countryName;?></li>
                                     <?php
                                }
                            ?>
                         </div>
                        <?php
                        $i++;
                    }
                }  
            ?>
          </ul>
       </div>
       
    </div>
    <div class="row pt20" id="sippingSD">
      <?php if(isset($firstShortDesc)) echo $firstShortDesc; ?> 
    </div>
    <?php }else{ ?>  
            <div class="row pt20">
                <?php echo $this->lang->line('noRecord'); ?>
             </div>
    <?php  } ?>       
 </div>

<script type="text/javascript">
    radioCheckboxRender();
</script>
