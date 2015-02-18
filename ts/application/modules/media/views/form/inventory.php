<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
$lang=lang();
$projectInventoryForm = array(
	'name'=>'projectInventoryForm',
	'id'=>'projectInventoryForm'
);

$projId = isset($projId)?$projId:0;

$projQuantity = (isset($projQuantity) && (int)$projQuantity > 0)? $projQuantity:0;




$projIdInput = array(
	'name'	=> 'projId',
	'type'	=> 'hidden',
	'id'	=> 'projId',
	'value'	=>$projId
);



$hasDownloadableFileOnly = (isset($hasDownloadableFileOnly) && (int)$hasDownloadableFileOnly > 0)?$hasDownloadableFileOnly:0;
$hasDownloadableFileOnlyInput = array(
	'name'	=> 'hasDownloadableFileOnly',
	'type'	=> 'hidden',
	'id'	=> 'hasDownloadableFileOnly',
	'value'	=>$hasDownloadableFileOnly
);


$nextStep='/shipping/';
$totalCommision = $priceDetails['totalCommision'];
$displayPrice = $priceDetails['displayPrice'];
if($hasDownloadableFileOnly==1){
    $nextStep='sellerconsumptiontax';
    $totalCommision = $downloadPriceDetails['totalCommision'];
    $displayPrice = $downloadPriceDetails['displayPrice'];
    $projPriceInput = $projDownloadPriceInput;
}

$baseUrl = formBaseUrl();
$nextSteplink = $baseUrl.$nextStep.$projId;

echo form_open($baseUrl.DIRECTORY_SEPARATOR.'saveProjectInventory'.DIRECTORY_SEPARATOR,$projectInventoryForm); 
    echo form_input($projIdInput);
    echo form_input($hasDownloadableFileOnlyInput);
    ?>
    <div class="c_1 fixed_cnt">
        <h3 class="red fs21 fnt_mouse bb_aeaeae"><?php echo $this->lang->line('MW_IHcat'.$projCategory);?></h3>
        <div class="sap_40"></div>
       
        <div class="num_sale">
            <span class="fl mr15 lineH33 fs14 color_818181">Number of Sales</span> 
            <span class="add_select width_70 position_relative">
                <p>
                    <span class="ui-spinner ui-widget ui-widget-content ui-corner-all">
                        <input value="<?php echo $projQuantity;?>" name="projQuantity" readonly id="projQuantity" aria-valuenow="89" class="ui-spinner-input" autocomplete="off" role="spinbutton">
                        <a class="ui-spinner-button ui-spinner-up ui-corner-tr ui-button ui-widget ui-state-default ui-button-text-only" tabindex="-1" role="button" aria-disabled="false" id="upSpace">
                            <span class="ui-button-text">
                                <span class="ui-icon-triangle-1-n"></span>
                            </span>
                        </a>
                        <a class="ui-spinner-button ui-spinner-down ui-corner-br ui-button ui-widget ui-state-default ui-button-text-only" tabindex="-1" role="button" aria-disabled="false" id="downSpace">
                            <span class="ui-button-text">
                                <span class="ui-icon-triangle-1-s"></span>
                            </span>
                        </a>
                    </span>
                </p>
            </span>
        </div> 
    
    </div>

    <div class="fr btn_wrap display_block font_weight">
         <a href="<?php echo site_url(lang().'/media/'.$industry.'/'.$projId);?>" id="cancleForm"> 
            <button class="bg_ededed bdr_b1b1b1 mr5" type="button"><?php echo $this->lang->line('cancel');?></button>
        </a>
        <a href="<?php echo $nextSteplink; ?>">
            <button type="button" class="next_click1 bdr_b1b1b1 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('skip');?></span></button>
        </a>
        <a href="<?php echo $baseUrl.DIRECTORY_SEPARATOR.'pricing'.DIRECTORY_SEPARATOR.$projId ;?>">
            <button type="button" class="back back_click1 bdr_b1b1b1 mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('back');?></span></button>
        </a>
        <button type="submit" class="b_F1592A next_click1 bdr_F1592A ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('next');?></span></button>
    </div>
<?php 
echo form_close();?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#projectInventoryForm").validate();
      
      /**
         * @Description: Manage Number of Sales and value on up spinner
         */ 
        $('#upSpace').click(function() {
            manageSales('up');
        });
        
        //------------------------------------------------------------------------
            
        /**
         * @Description: Manage Number of Sales and value on down spinner
         */ 
        $('#downSpace').click(function() {
            manageSales('down');
        });
        
        //------------------------------------------------------------------------
            
        /**
         * @Description: Manage Sales data as spinner changes 
         */ 
        function manageSales(spaceType) {
            
            // get sales quantity value
            var projQuantity = $('#projQuantity').val();
            
            if( spaceType == 'up' ) {
                projQuantity = parseInt(projQuantity)+1;
            } else {
                if(projQuantity > 1) {
                    projQuantity = parseInt(projQuantity)-1;
                } else {
                    return false;
                }
            }
            // append values as sales quantity
            $('#projQuantity').val(projQuantity);
        }
      
  });
</script>	

			
              
		
