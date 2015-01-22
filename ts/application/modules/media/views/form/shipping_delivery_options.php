<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
    'name'=>'deliveryForm',
    'id'=>'deliveryForm'
);
$elementIdInput = array(
	'name' => 'projectId',
	'id'   => 'projectId',
	'type' => 'hidden',
	'value'=>  (!empty($projectId))?$projectId:0,
);
$elementId = (isset($elementId))?$elementId:'';
$projElementInput = array(
	'name' => 'elementId',
	'id'   => 'elementId',
	'type' => 'hidden',
	'value'=>  $elementId,
);
// set base url
$baseUrl = formBaseUrl();
?>
<div class="TabbedPanelsContentGroup design_wrap width_665 m_auto ">
    <div class="TabbedPanelsContent member width635 m_auto clearb">
        <!--=======================pickup=======================-->    
        <?php echo form_open($baseUrl.DIRECTORY_SEPARATOR.'setprintdeliveryoptions'.DIRECTORY_SEPARATOR.$projectId,$formAttributes); ?>       
            <div class="TabbedPanelsContent">
                <div class="c_1">
                    <h3 class="red fs21 fnt_mouse  bb_aeaeae"> How will you deliver your Prints?* </h3>
                    <div class="sap_40"></div>
                    <ul class=" display_table clearb pickup rate_wrap defaultP">
                        <li >
                            <label>
                                <input type="checkbox" name="isPickup" value="1" checked="checked " />
                                <b>Pickup </b>
                            </label>
                        </li>
                        <li class="pl30">AND/OR </li>
                        <li>
                            <label>
                                <input type="checkbox" name="isDomesticShipping" value="1" checked="checked " />
                                <b>Domestic</b> Shipping 
                            </label>
                        </li>
                        <li class="pl30">AND/OR</li>
                        <li>
                            <label>
                                <input type="checkbox" name="isInternationalShipping" value="1" checked="checked " />
                                <b>International</b> Shipping 
                            </label>
                        </li>
                    </ul>
                    <ul class=" clearb org_list">
                        <li class="icon_1"><?php echo $this->lang->line('buyerBuyFromYou')?></li>
                        <li class="icon_2"><?php echo $this->lang->line('shippingStoreInGlobal')?></li>
                    </ul>
                </div>
                <!-- form buttons  -->
                <?php 
                // set back page name
                $data['backPage'] = $backPage;
                $this->load->view('common_view/shipping_buttons',$data);
                //set form hidden fields
                echo form_input($elementIdInput);
                echo form_input($projElementInput);
                ?>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#deliveryForm").validate({
            submitHandler: function() {
                var fromData = $("#deliveryForm").serialize();
                $.post('<?php echo $baseUrl.'/setprintdeliveryoptions/'.$projectId.'/'.$elementId;?>',fromData, function(data) {
                    if(data) {
                        if(data.optionCount > 0) {
                            window.location.href = '<?php echo $baseUrl;?>'+data.nextStep;
                            $('#messageSuccessError').html('<div class="successMsg"><?php echo "Successfully set delivery options";?></div>');
                            timeout = setTimeout(hideDiv, 5000);
                        } else {
                            customAlert('You must setup at least one form of shipping in order to delivery your products.');
                            return false;
                        }
                    }
                }, "json");
            }
        });
    });
</script>
