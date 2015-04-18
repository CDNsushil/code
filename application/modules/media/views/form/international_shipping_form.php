<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    $formName='internationalShippingForm';

    if(isset($interationalShipping)) {
        //extract($interationalShipping);
        
    }

    
    $formAttributes = array(
        'name'=>$formName,
        'id'=>$formName
        
    );
    $countriesIdInput = array(
        'name'	=> 'countriesId',
        'id'	=> 'countriesId',
        'value'	=> (!empty($interationalShipping['countriesId']))?$interationalShipping['countriesId']:'',
        'type'	=> 'hidden'
    );
    $spIdInput = array(
        'name'	=> 'spId',
        'id'	=> 'spId',
        'value'	=> isset($spId)?$spId:0,
        'type'	=> 'hidden'
    );
    $shippingProjectId = array(
        'name' => 'projectId',
        'id'   => 'projectId',
        'type' => 'hidden',
        'value'=>  (!empty($projectId))?$projectId:0,
    );
    
    $shippingElementId = array(
        'name' => 'elementId',
        'id'   => 'elementId',
        'type' => 'hidden',
        'value'=>  (!empty($elementId))?$elementId:0,
    );

    $shippingEntityId = array(
        'name' => 'entityId',
        'id'   => 'entityId',
        'type' => 'hidden',
        'value'=>  (!empty($entityId))?$entityId:0,
    );
    // set base url
    $baseUrl = formBaseUrl(); 
?>

<div class="c_1" id="IS_Container">
    <h3 class="red fs21 ">Setup your International Shipping</h3>
    <div class="sap_25"></div>
    <ul class="clearb rate_wrap international">
        <li><p>First you need to setup Shipping Zones. Group together countries that you will ship to for the same charge into a zone.</p></li>
        <li><p>You can setup up to seven zones. The countries in each zone can come from more than one continent.</p></li>
        <li><p>Next add the charge for the zone.</p></li>
    </ul>

    <div class="wra_head bb_aeaeae pb25">
        <h3 class="red fs21 mb22 ">Add Countries to Shipping <?php echo $zoneTitle;?>*</h3>
        <div class="defaultP">
            <ul class="zone_list fl mt30 bdr_c4c4c4">
                <?php
                $continentId = 0;
                $continentCountries = array();
                $i = 0;
                $continentCountryName='';
                $continentCountryHTML='';
                $countCuntry = count($conitnentCountryList);
                foreach($conitnentCountryList as $k=>$country) {
                      $i++;
                        if($country->continentId !=$continentId && $country->continentId > 0) {
                            
                            if($i > 1){
                                $style = '';
                                if($continentCountryName == ''){
                                    $style = 'style="display:none;"';
                                }
                                $continentCountryHTML.='
                                <li id="SCCli_'.$continentId.'" '.$style.'>
                                        <h5>'.$conitnentCountryList[$k-1]->continent.'</h5>
                                        <p id="SCC_'.$continentId.'">'.$continentCountryName.'</p>
                                </li>
                                ';
                                $continentCountryName = '';
                           }
                            $continentId=$country->continentId;
                            $checked=$i==1?'checked':'';?>
                            <li>
                                <label>
                                    <input <?php echo $checked;?> type="radio" name="continentId"  value="<?php echo $continentId;?>" onclick="showConitentWiseCountry('<?php echo $continentId;?>'); " /><?php echo $country->continent;?>
                                </label>
                            </li>
                        <?php }
                        
                        if($conitnentZoneCountryList && in_array($country->countryId, $conitnentZoneCountryList)) {
                            if($continentCountryName != '') {
                                $continentCountryName.= ', ';
                            }
                            $continentCountryName.= $country->countryName;
                        }
                        
                        if($i == $countCuntry){
                            $style = '';
                                if($continentCountryName == '') {
                                    $style = 'style="display:none;"';
                                }
                                $continentCountryHTML.='
                                <li id="SCCli_'.$country->continentId.'" '.$style.'>
                                        <h5>'.$country->continent.'</h5>
                                        <p id="SCC_'.$country->continentId.'">'.$continentCountryName.'</p>
                                </li>
                                ';
                        }
                    $continentCountries[$country->continentId][$country->countryId]=$country->countryName;
                }?>
            </ul>
        </div>

    <div class=" mb20 billing_form fl ml37 domestic_country position_relative height_30">
        <div class="defaultP fl ml3 ">
            <p class="clearb pb10 pl1">Select Country</p>
            <div class="slect_menu bdr_c4c4c4 width_223 shadow_light height30" >
                <label class=" pt6 pl10 all_click">
                    <input  value="1" id="checkAllCountry" name="checkAllCountry" onclick="checkUncheckContinentCountry(this);" type="checkbox">All 
                </label>
                <span class="fr r_arrow" onclick="slideCountryMenu(this);"></span>	
            </div>
                    
            <?php
            $continentId=0;
            $i=0;
            $continentIdArray= array();
            foreach($continentCountries as $continentId=>$Countries) {
                $continentIdArray[]=$continentId;
                $dn=$i==0?'':'dn';?>
                <div id="countryListing<?php echo $continentId;?>" class="<?php echo $dn?> countryListing slider small_select bdr_c4c4c4 pt14 pb10 width_223 shadow_light bdr_c4c4c4">
                    <a class="buttons prev" href="javascript:void(0);">left</a>
                    <div class="viewport width_223">
                        <ul class="clearb  overview  width_196 pl10 fl">
                            <?php
                            foreach($Countries as $countryId=>$countryName) {
                                
                                $checked='';
                                if($conitnentZoneCountryList) {
                                    $checked = in_array($countryId, $conitnentZoneCountryList)?'checked':'';
                                }
                                ?>
                                <li>
                                    <label>
                                        <input type="checkbox" class="country_checkox checkox_<?php echo $continentId;?>" name="countryCheckBox[]" value="<?php echo $countryId; ?>" continentId="<?php echo $continentId;?>" title="<?php echo $countryName; ?>" <?php echo $checked;?> />
                                        <span><?php echo $countryName;?></span>
                                    </label>
                                </li>
                                <?php
                            } ?>
                        </ul>
                    </div>
                    <a class="buttons next" href="javascript:void(0);">left</a>
                </div>
                <?php
                $i++;
            } ?>
        </div>
    </div>

    <div class="fr mt20 pt5 ml16 zone_btn" id="addCountriestoZone">
        <button class="red pl6 pr6 bdr_a0a0a0 fshel_bold " type="button" >Add Countries to Zone</button>
    </div>
    </div>

    <div class="sap_10"></div>
    <ul class="review mb10">
    <li class="icon_2">Countries in Shipping <?php echo $zoneTitle;?></li>
    </ul>

    <div id="slider6" class="slider p10 height_134 bdr_a0a0a0">
    <a class="buttons prev" href="">left</a>
    <div class="viewport height_134 width100_per ">
        <ul class="fs14 width100_per overview slect_coustom slect_menu defaultP">
            <?php echo $continentCountryHTML;?>
        </ul>
    </div>

    <a class="buttons next"  href=""></a>
    </div>
   
    <?php 
    echo form_open($baseUrl.'/saveshippingzone/'.$projectId.'/'.$elementId,$formAttributes);?>
        <div class="defaultP lineH20 mt35 fl">
            <label>
                <div class="ez-checkbox"><input type="checkbox" value="1" name="isSameAsGlobal" /></div>
                <span class="display_table"> 
                    <?php echo $this->lang->line('shippingInfoText1');?>
                    <a href="<?php echo site_url(lang().'/dashboard/globalsettings/4')?>"><?php echo $this->lang->line('shippingInfoText2');?></a>
                    <?php echo $this->lang->line('shippingInfoText3');?>
                </span>
            </label>
        </div>
        <?php
        // set back url page name
        $data['backPage'] = 'internationalshipping';
        //$data['isDomestic'] = 1; 
        $this->load->view('common_view/shipping_buttons',$data);
        //set form hidden fields
        echo form_input($shippingProjectId);
        echo form_input($shippingElementId);
        echo form_input($shippingEntityId);
        echo form_input($spIdInput); 
        echo form_input($countriesIdInput);
    echo form_close();?>
</div>
                     
    <script type="text/javascript">
    $(document).ready(function(){
         runTimeCheckBox();
        var continentIdArray = <?php echo json_encode($continentIdArray);?>;
         
         $(continentIdArray).each(function(index, value){
             $('#countryListing'+value).tinycarousel({ axis: 'y', display:1});	
         });
         
         $('#slider6').tinycarousel({ axis: 'y', display:1});
            $( ".country_checkox" ).click(function() {
                continentId = $(this).attr('continentId');
                cl = $(".checkox_"+continentId+":checked" ).length;
                tl = $(".checkox_"+continentId).length;
                if(cl == tl){
                    $("#checkAllCountry" ).attr('checked',true);
                }else{
                    $("#checkAllCountry" ).attr('checked',false);
                }
                runTimeCheckBox();
            });
            

        $("#addCountriestoZone").click(function(){
            var countriesName = new Array();
            var countriesId = new Array();
            var names = '';
            var ids ='';
            
            var i=0;
            var prevContinentId = 0;
            var continentId = 0;
            var name = '';
            var ids = '';
            $('.country_checkox:checked').each(function(index, value){
                    continentId = $(this).attr('continentId');
                    if(continentId != prevContinentId && continentId > 0){
                        if(i > 0){
                            $('#SCC_'+prevContinentId).html(name);
                            $('#SCCli_'+prevContinentId).show('slow');
                            name = '';
                        }
                        prevContinentId = continentId;
                    }
                    if(name != ''){
                        name+= ', ';
                    }
                    name+= this.title;
                    ids+=  '|'+this.value;
                    i++;
                    if(i = $('.country_checkox:checked').length){
                        $('#SCC_'+prevContinentId).html(name);
                        $('#SCCli_'+prevContinentId).show('slow');
                    }
            });
            if(ids != ''){
                ids+= '|';
            }
            $('#countriesId').val(ids);
        });
              
         // --------------- Function to check Country before submit --------------     
         $( "#nextButton" ).click(function() {
			var checkCountry = $('#countriesId').val();
			if(checkCountry == "")
			{ 
				return false;
			}
		});     
              
                
        /*$("#<?php echo $formName;?>").validate({
              submitHandler: function() {
                 var fromData=$("#<?php echo $formName;?>").serialize();
                 $.post('<?php echo $baseUrl.'/saveGlobalShipping/'.$elementId ?>',fromData, function(data) {
                  if(data){
                        $('#IS_Container').html(data);
                            $('#messageSuccessError').html('<div class="successMsg"><?php echo 'Successfully save zone.';?></div>');
                            timeout = setTimeout(hideDiv, 5000);
                  }
                });
             }
        });*/
    });
    
    function slideCountryMenu(obj){
        var continentId = $( "input:radio[name=continentId]:checked" ).val();
        $("#countryListing"+continentId).slideToggle();
        $(obj).toggleClass("arrow_up");
    }
    
    function checkUncheckContinentCountry(obj){
        var continentId = $( "input:radio[name=continentId]:checked" ).val();
        $("#countryListing"+continentId+" input:checkbox[name=countryCheckBox[]]" ).attr('checked',obj.checked);
        runTimeCheckBox();
    }
    
    function showConitentWiseCountry(continentId){
        var currentDiv = '#countryListing'+continentId;
        var eachDiv = '.countryListing';
        if(eachDiv && eachDiv != ''){
            eachDiv = eachDiv.replace(" ",""); 
            $(eachDiv).each(function(index){
                $(this).hide();
            });
        }
        if(currentDiv && currentDiv != ''){
            currentDiv = currentDiv.replace(" ",""); 
            $(currentDiv).each(function(index){
                $(this).show();
            });
        }
        cl = $(".checkox_"+continentId+":checked" ).length;
        tl = $(".checkox_"+continentId).length;
        if(cl == tl){
            $("#checkAllCountry" ).attr('checked',true);
        }else{
            $("#checkAllCountry" ).attr('checked',false);
        }
        runTimeCheckBox();
    }
    
    
    
    
</script>
