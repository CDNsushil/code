<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*Paypal Details */

$paypalId = array(
    'name'=> 'paypalId',
    'class'	=>'email required',
    'id'=> 'paypalId',
    'value'	=> set_value('paypalId')?set_value('paypalId'):$userProfileData->paypalId,
    'onclick'=>"placeHoderHideShow(this,'PayPal ID','hide')",
    'onblur'=>"placeHoderHideShow(this,'PayPal ID','show')",
    'placeholder'=>"PayPal ID *"

);

$paypalFirstName = array(
    'name'=> 'paypalFirstName',
    'class'	=>'required',
    'id'=> 'paypalFirstName',
    'value'	=> set_value('paypalFirstName')?set_value('paypalFirstName'):$userProfileData->paypalStreet,
    'onclick'=>"placeHoderHideShow(this,'First Name','hide')",
    'onblur'=>"placeHoderHideShow(this,'First Name','show')",
    'placeholder'=>"First Name *"

);

$paypalLastName = array(
    'name'=> 'paypalLastName',
    'class'	=>'required',
    'id'=> 'paypalLastName',
    'value'	=> set_value('paypalLastName')?set_value('paypalLastName'):$userProfileData->paypalZip,
    'onclick'=>"placeHoderHideShow(this,'Last Name','hide')",
    'onblur'=>"placeHoderHideShow(this,'Last Name','show')",
    'placeholder'=>"Last Name *"
);
 
if(isset($userProfileData->verify_status) && ($userProfileData->verify_status == 't')) { 
    $classVerfiedYes = '';
    $classVerfiedNo = 'dn';
}else{
    $classVerfiedYes = 'dn';
    $classVerfiedNo = '';
} 
// set base url
$baseUrl = base_url($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR);
?>
<div class="TabbedPanelsContent TabbedPanelsContentVisible">
    <form id="paypalSettingForm" name="paypalSettingForm">
        <div class="c_1">
            <h3 class="red fs21 fnt_mouse  bb_aeaeae "><?php echo $this->lang->line('paypalDetails');?></h3>
            <div class="sap_40"></div>
            <input type="hidden" id="verify_detail"  name="verify_detail" />
            <input type="hidden" id="verify_paypal"  name="verify_status" value="<?php echo $userProfileData->verify_status?>" />
            <ul class=" display_table paypal clearb rate_wrap ">
                <li><?php echo form_input($paypalId); ?></li>
                <li><?php echo form_input($paypalFirstName);?></li>
                <li><?php echo form_input($paypalLastName); ?></li>
                            
                <li class="fr mt20 mr5 verify pb0"> 
                    <span class="defaultP fl">
                        <button type="button" class="verify_btn <?php  echo $classVerfiedYes ?> "> <?php echo $this->lang->line('verified');?> </button>
                        <button type="button" class="check_btn <?php  echo $classVerfiedNo ?>"><?php echo $this->lang->line('checkDetails');?></button>
                        <!-- <button type="submit" class="fr p10 bdr_a0a0a0 "  onclick="return verifyPaypal();">Verify</button> -->
                        <button class="b_F1592A bdr_F1592A ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" onclick="return verifyPaypal();" type="submit" role="button" aria-disabled="false">
                            <span class="ui-button-text">Verify</span>
                        </button>
                    </span>
                </li>
            </ul>
            
            <ul class="org_list">
                <li class="icon_1 red"> <?php echo $this->lang->line('allSaleUpdate');?></li>
                <li class="icon_2 "><?php echo $this->lang->line('verifypaypalMsg');?></li>
                <li> <?php echo $this->lang->line('matchPaypalDetail');?></li>
                <li ><?php echo $this->lang->line('settingStoreInGlobal');?></li>
            </ul>
            <div class="sap_10"></div>
            <!-- Form buttons -->  
            <div class="fr btn_wrap display_block font_weight">
               <a href="<?php echo $baseUrl;?>" id="cancleForm"> 
                    <button class="bg_ededed bdr_b1b1b1 mr5" type="button"><?php echo $this->lang->line('cancel');?></button>
                </a>
                <a href="<?php echo $baseUrl.'/sellerconsumptiontax/'.$elementId;?>" id="backStep">
                    <button class="back back_click1 bdr_b1b1b1 mr5" type="button">
                        <?php echo $this->lang->line('back');?>
                    </button>
                </a>
                <button class="b_F1592A bdr_F1592A" onclick="savePaypalInfo();" type="button">
                    <?php echo $this->lang->line('next');?>
                </button>          
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    /* Paypal Verify Section */
    function verifyPaypal(){
        var returnFlagPay = <?php echo ($userProfileData->verify_status == 'f')?'false':'true'; ?>;
        var paypalId = $('#paypalId').val();
        var paypalFirstName = $('#paypalFirstName').val();
        var paypalLastName = $('#paypalLastName').val();
        
        $('#paypalSettingForm').validate();     
        
         if (paypalId==''){
             $('#paypalId').addClass('error');
             e.preventDefault();
             }
          if (paypalFirstName==''){
             $('#paypalFirstName').addClass('error');
             e.preventDefault();
             }
             
        if (paypalLastName==''){
             $('#paypalId').addClass('error');
             e.preventDefault();
             } 
        
        if (paypalId!='' && paypalFirstName!='' && paypalId!='') {
            
             fromData = 'val1='+paypalId+'&val2='+ paypalFirstName+'&val3='+ paypalLastName+'&ajaxHit=1';
             loader();
             /* Send the data using post */
            var posting = $.post(baseUrl+language+'/common/verifyPaypalaccount',
                fromData,
                function(data) {
                    var checkSuccess = data.Ack;
                    
                    json_object = JSON.stringify(data);
                    $('#verify_detail').val(json_object);
                    if(data.Ack =="Error"){
                        $('.verify_btn').addClass('dn');
                        $('.check_btn').removeClass('dn');
                        $('#verify_paypal').val('f');
                        customAlert('<?php echo $this->lang->line('tryLaterVerifyPaypal');?>'); 
                        returnFlagPay = false; 
                        
                    } else if(data.Ack =="Success"){
                        $('.check_btn').addClass('dn');
                        $('.verify_btn').removeClass('dn');
                        $('#verify_paypal').val('t');
                        returnFlagPay = true;
                        customAlert('Paypal information verified.');
                        //$('#messageSuccessError').html('<div class="successMsg">Paypal information verified.</div>');
                        //timeout = setTimeout(hideDiv, 5000);
                        return true;
                    } else {
                        $('.verify_btn').addClass('dn');
                        $('.check_btn').removeClass('dn');
                        $('#verify_paypal').val('f');
                        customAlert('<?php echo $this->lang->line('inValidVerifyPaypal');?>'); 
                        notValidPayInfo = 'notValid'; 
                        returnFlagPay = false;
                    }
                },'json');
        }
      return false; 
    }

    function savePaypalInfo() {
        var paypalId = $('#paypalId').val();
        var paypalFirstName = $('#paypalFirstName').val();
        var paypalLastName = $('#paypalLastName').val();
        var verify_status = $('#verify_paypal').val();
        var verify_detail = $('#verify_detail').val();
        
        if (paypalId=='') {
            $('#paypalId').addClass('error');
            e.preventDefault();
        }
        if (paypalFirstName=='') {
            $('#paypalFirstName').addClass('error');
            e.preventDefault();
        }
        if (paypalLastName=='') {
            $('#paypalId').addClass('error');
            e.preventDefault();
        } 
        if (paypalId!='' && paypalFirstName!='' && paypalLastName!='' && verify_status=='t' ) {
            var returnFlag=false;
            returnFlag = ajaxSave('<?php echo base_url(lang()."/dashboard/savePaypalInfo");?>','',paypalId,paypalFirstName,paypalLastName,verify_detail);
            window.location.href = '<?php echo $baseUrl.'/sellersetting/'.$elementId;?>';
            //customAlert('Paypal information updated');
        } else {
            customAlert('<?php echo $this->lang->line('inValidVerifyPaypal');?>');
        }
    }
/* End */
</script>
