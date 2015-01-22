<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($showcaseData->fans == 't'){
    echo  '<div class="sap_47"></div>';
}else{
    if($page=='mycraves'){
        $crave_section = $this->config->item('crave_section');
    }else{
        $crave_section = $this->config->item('crave_me_section');
    } ?>
    <div class="sap_20"></div>
    <div class="pl20 mr40 clearb my_creave_box  fr">
       <ul class="clearb crave_list fr pr0 fs16 ">
          <li <?php if($page=='mycraves') echo 'class="active"';?> ><a href="<?php echo base_url(lang().'/showcase/mycraves/'.$showcaseData->tdsUid);?>">My Craves</a> </li>
          <li <?php if($page=='cravingme') echo 'class="active"';?>> <a href="<?php echo base_url(lang().'/showcase/cravingme/'.$showcaseData->tdsUid);?>">Craving Me</a></li>
       </ul>
       <div class="sap_20"></div>
       <div class="mb10 display_block fr  clearb 	">
            <?php
            $formAttributes = array(
                'name'=>'craveSearchForm',
                'id'=>'craveSearchForm',
            );
            echo form_open($this->uri->uri_string(),$formAttributes);?>
               <div class=" position_relative select_1 fl height30 width200 mr13" >
                   <?php
                    if(is_array($crave_section) && !empty($crave_section)){?>
                        <select id="projType" name="projType" onchange="showsubsection(this.value);">
                        <?php
                        foreach($crave_section as $Key=>$section){
                            $selected =($projectType==$Key)?'selected':'';?>
                            <option <?php echo $selected;?> value="<?php echo $Key;?>"><?php echo $section;?></option>
                            <?php
                        }?>
                        </select>
                        <?php
                    }?>
                </div>
                <?php
                if($page=='mycraves'){
                    $showSelect = 'dn';
                    $ShowInput = '';
                    if($projectType == 'member' || $projectType == 'media'){
                         $showSelect = '';
                         $ShowInput = 'dn';
                    }
                     ?>
                    <div id="selectProjType2" class="<?php echo $showSelect;?> select_1 fl height30  mr13 " >
                      <div  class="position_relative fl "> <?php
                        $crave_sub_section = $this->config->item('crave_sub_section');
                        if(is_array($crave_sub_section) && !empty($crave_sub_section)){?>
                            <select  id="projType2" class="width260" name="projType2" >
                            <?php
                                $craveSubSection = $crave_sub_section[$projectType];
                                if(is_array($craveSubSection) && !empty($craveSubSection))
                                foreach($craveSubSection as $Key=>$section){
                                    $selected =($projType2==$Key)?'selected':'';?>
                                    <option <?php echo $selected;?> value="<?php echo $Key;?>"><?php echo $section;?></option>
                                    <?php
                                }?>
                            
                            </select>
                            <?php
                        }?>
                        </div>
                    </div>
                    <div id="inputProjType2" class="<?php echo $ShowInput;?> position_relative select_1 fl height30  mr13 " >
                        <input type="text" value=""  class="font_wN light_input width272" name="test" readonly />
                    </div>
                    <?php
                }?>
                <div class="searchbarbg width_auto ff_arial fl font_weight  ml0 mt0">
                   <input id="craveSearch" name="craveSearch" type="text" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywords');?>','show')" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywords');?>','hide')" value="<?php if(empty($craveSearch)){ echo $this->lang->line('keywords');} else echo $craveSearch;?>"  class="font_wN"  />
                   <input name="Submit" type="submit" class="searchbtbbg" value="Submit"  />
                </div>
            <?php echo form_close(); ?>
         </div>
    </div>
    <?php
} ?>
<script>
function showsubsection(value){
    if(value == 'media' || value == 'member'){
        $('#selectProjType2').show();
        $('#inputProjType2').hide();
        
        $("#projType2 option").each(function (index, val) {
            $(this).remove();
        });
        var options;
        if(value == 'media'){
            options = <?php echo json_encode($crave_sub_section['media']);?>;
        }else{
            options = <?php echo json_encode($crave_sub_section['member']);?>;
        }
        
        $.each(options, function (key, data) {
            $('#projType2').append("<option value="+key+">"+data+"</option>");
        });
       $("#projType2").selectBoxJquery('refresh');  
    }else{
        $('#selectProjType2').hide();
        $('#inputProjType2').show();
    }
}
</script>         
