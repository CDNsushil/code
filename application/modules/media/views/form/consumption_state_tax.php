<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
    'name'=>'consumptionStateTaxForm',
    'id'=>'consumptionStateTaxForm'
);
// set base url
$baseUrl = formBaseUrl(); 
?>
<div class="TabbedPanelsContentGroup">
    <!-- =================Consumption Tax==================-->
    <div class="TabbedPanelsContent Consumption_Tax TabbedPanelsContentVisible">
        <?php echo form_open($baseUrl.'/saveConsumptionTax/'.$elementId,$formAttributes);?>  
            <div class="c_1 ">
                <h3 class="red fs21  ">
                    <?php echo $this->lang->line('whatRateNeedToCharge')?>
                </h3>
                <div class="sap_40"></div>
                <div class=" width_520 defaultP mb20">
                    <div class=" slect_menu  bdr_c4c4c4 mb10 height_30 ">
                        <label class="pt5 pl10 all_click">
                            <input  value="1" id="checkAllStates" name="checkAllStates" onclick="checkUncheck(this, 0, '.checkboxStatesTax');" type="checkbox">
                            <span>
                                <?php echo $this->lang->line('all');?> 
                            </span>
                        </label>
                    </div>
        
                    <div id="slider7" class="slider p10 bdr_c4c4c4">
                        <a class="buttons prev right5" href="#">
                            <?php echo $this->lang->line('left');?> 
                        </a>
                        <div class="viewport height_120" id="stateTaxList"> </div>
                        <a class="buttons next right5"  href="#"></a>
                    </div>
                </div>
                <label class="defaultP lineH20 mt10 fl">
                    <input type="checkbox" name="isSpecificProjRate" value="checkbox"  />
                    <span> <?php echo $this->lang->line('specificRate');?></span>
                </label>
                <ul class="org_list clearb">
                    <li class="icon_2"><?php echo $this->lang->line('settingStoreInGlobal');?> </li>
                </ul>
                <div class="fr btn_wrap display_block font_weight">
                    <a href="<?php echo $baseUrl;?>" id="cancleForm"> 
                        <button class="bg_ededed bdr_b1b1b1 mr5" type="button">
                            <?php echo $this->lang->line('cancel');?>
                        </button>
                    </a>
                    <a href="javascript://void(0);" id="backToStep2">
                        <button class="back back_click1 bdr_b1b1b1 mr5" type="button">
                            <?php echo $this->lang->line('back');?>
                        </button>
                    </a>
                    <button class="b_F1592A next_click2 bdr_F1592A" type="submit">
                        <?php echo $this->lang->line('next');?>
                    </button>
                </div>
            </div>
            <input id="consumptionStateTax" type="hidden" value="consumptionStateTax" name="consumptionStateTax">
            <input id="stateCountryId" type="hidden" value="" name="stateCountryId">
        <?php echo form_close();?>
    </div>
</div>
<!--End Groub-->

<script type="text/javascript">
    $(document).ready(function() {
       /**
        * Manage form submission
        */
        $("#consumptionStateTaxForm").validate({
            submitHandler: function() {
                var fromData=$("#consumptionStateTaxForm").serialize();
                var stateList = [];
                $(".checkboxStatesTax:checked").each(function() {
                    stateList.push(this.value);
                }); 
                if(stateList.length > 0) {
                    $.post('<?php echo $baseUrl.'/saveConsumptionTax/'.$elementId ?>',fromData, function(data) {
                        window.location.href = '<?php echo $baseUrl ?>' + data.nextStep;
                    }, "json");
                } else {
                    alert('Please select State, Provence, Region first!');
                    return false;
                }
            }
        });
        
       /**
        * Manage state tax slider
        */	
        $('#slider7').tinycarousel({ axis: 'y', display: 1});	
    });

    /**
    * Return form on consumption charge form
    */
    $('#backStep').click(function() {
        $('#charge_consumption_tax_div').show();
        $('#consumption_state_tax_div').hide();
    });

    /**
    * Return to consumption defaut form on cancle
    */
    $('#cancleForm').click(function() {
        window.location.href = window.location.href;
    });

    /**
    * Manage row enable and disable event
    */
    function disbaleEnableRow(obj,id) {
        var checked = $(obj).attr('checked');
        var currentDivClass = $('#StateWiseTaxLI'+id).attr('class').replace('opacity_4', '');
        var currentTNClass = $('#StateWiseTaxName'+id).attr('class').replace('required', '');
        currentTNClass=currentTNClass.replace('error', '');
        var currentTPClass = $('#StateWiseTaxPercentage'+id).attr('class').replace('number required', '');
        currentTPClass=currentTPClass.replace('error', '');
        $("label[for='StateWiseTaxName"+id+"']").remove();
        $("label[for='StateWiseTaxPercentage"+id+"']").remove();
        if(!checked){
            currentDivClass+=' opacity_4';
        }else{
            currentTNClass+=' required';
            currentTPClass+=' number required';
        }
        $('#StateWiseTaxLI'+id).attr('class',currentDivClass);
        $('#StateWiseTaxName'+id).attr('class',currentTNClass);
        $('#StateWiseTaxPercentage'+id).attr('class',currentTPClass);
    }
    
    /**
     * Manage back event of consumption third step to second
     */		
    $('#backToStep2').click(function() {
        $('#consumption_state_tax_div').hide(); 
        $('#charge_consumption_tax_div').fadeIn('slow');
    });

</script>

