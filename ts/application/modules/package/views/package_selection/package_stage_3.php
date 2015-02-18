<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$packageStage3 = array(
  'name'=>'packageStage3',
  'id'=>'packageStage3'
);

$email           =   array(
  'name'         =>  'email',
  'id'           =>  'email',
  'class'        =>  'font_wN required email emailCheck',
  'title'        =>  $this->lang->line('packstage3_EmailValidation'),
  'value'        =>  '',
  'maxlength'	 =>  80,
  'size'         =>  30,
  'onclick'      =>  "placeHoderHideShow(this,'Email Address*','hide')",
  'onblur'       =>  "placeHoderHideShow(this,'Email Address*','show')",
  'placeholder'  => "Email Address*",
);

$confirmEmail    =   array(
  'name'         =>  'confirmEmail',
  'id'           =>  'confirmEmail',
  'class'        =>  'font_wN required email',
  'equalTo'      =>  '#email',
  'title'        =>  $this->lang->line('packstage3_confirmEmailValidation'),
  'value'        =>  '',
  'maxlength'	 =>  80,
  'size'         =>  30,
  'onclick'      =>  "placeHoderHideShow(this,'Confirm Email Address*','hide')",
  'onblur'       =>  "placeHoderHideShow(this,'Confirm Email Address*','show')",
  'placeholder'  => "Confirm Email Address*",
);

$password           =   array(
  'name'            =>  'password',
  'id'              =>  'password',
  'class'           =>  'font_wN required',
  'title'           =>  $this->lang->line('packstage3_passwordValidation'),
  'value'           =>  '',
  'minlength'       =>  8,
  'maxlength'       =>  20,
  //'maxlength'       =>  $this->config->item('password_max_length', 'tank_auth'),
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Password*','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Password*','show')",
  'placeholder'     =>  "Password*",
);

$confirm_password   =   array(
  'name'            =>  'confirm_password',
  'id'              =>  'confirm_password',
  'class'           =>  'font_wN required',
  'equalTo'         =>  '#password',
  'title'           =>  $this->lang->line('packstage3_confirmPasswordValidation'),
  'value'           =>  '',
  'minlength'       =>  8,
  'maxlength'       =>  20,
  //'maxlength'       =>  $this->config->item('password_max_length', 'tank_auth'),
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Confirm Password*','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Confirm Password*','show')",
  'placeholder'     =>  "Confirm Password*",
);

$firstName          =   array(
  'name'            =>  'firstName',
  'id'              =>  'firstName',
  'class'           =>  'font_wN required',
  'title'           =>  $this->lang->line('packstage3_firstnameValidation'),
  'value'           =>  '',
  'minlength'       =>  2,
  'maxlength'       =>  25,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'First name*','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'First name*','show')",
  'placeholder'     =>  "First name*",
);

$lastName           =   array(
  'name'            =>  'lastName',
  'id'              =>  'lastName',
  'class'           =>  'font_wN',
  'title'           =>  $this->lang->line('packstage3_lastnameValidation'),
  'value'           =>  '',
  'minlength'       =>  2,
  'maxlength'       =>  25,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Last name','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Last name','show')",
  'placeholder'     => "Last name",
);

$enterpriseName           =   array(
  'name'            =>  'enterpriseName',
  'id'              =>  'enterpriseName',
  'class'           =>  'font_wN',
  'title'           =>  $this->lang->line('packstage3_businssnameValidation'),
  'value'           =>  '',
  'minlength'       =>  2,
  'maxlength'       =>  25,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Business name','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Business name','show')",
  'placeholder'     => "Business name",
);

?>
<!--  content wrap  start end -->
<?php echo form_open(base_url(lang().'/auth/register'),$packageStage3); ?>
<div class="newlanding_container">
	<div class="wizard_wrap fs14 ">
    <div id="TabbedPanels1" class="TabbedPanels membership">
      <!-- membership stages start -->
       <?php $this->load->view('common_view/package_stage_menus') ?>
      <!-- membership stages end-->
      <div class="TabbedPanelsContentGroup main_tab m_auto width635 display_table ">
        <div class="TabbedPanelsContent TabbedPanelsContentVisible">
          <!--  Membership wrap start end -->
          <h3 class="red fs21 fnt_mouse pt12 pb10 bb_aeaeae "> <?php echo $this->lang->line('packstage3_your_details'); ?></h3>
          <!--=============================== Your Detail =============================-->
          <div class="your_detail mt32 display_table">
            <ul class="billing_form width_350 fl">
              <li class="bdr_non"><button type="button" onclick="open_window('<?php echo getFacebookLoginUrl(); ?>');"  class="fb_btn radius5 pl60 text_alighL width_240 sign_btn text_alighC"><?php echo $this->lang->line('packstage3_sign_in_fb_2'); ?></button></li>
              <li class="mt54">
               <?php echo form_input($email); ?>
               <div class="drkGrey" id="emailAvailMsg"></div>
              </li>
             
              <li>
                <?php echo form_input($confirmEmail); ?>
              </li>
              <li>
                 <?php echo form_password($password); ?>
              </li>
              <li>
                <?php echo form_password($confirm_password); ?>
              </li>
              <li>
                 <?php echo form_input($firstName); ?>
              </li>
              <li>
                  <?php echo form_input($lastName); ?>
              </li>
              <li>
                  <?php echo form_input($enterpriseName); ?>
              </li>
              <li class=" width_258 select select_1">
              <?php
                  $countries = getCountryList();
                  echo form_dropdown('country', $countries, set_value('country'),'id="countriesList" class=" main_SELECT selectBox bg_f6f6f6 required" title="'.$this->lang->line('packstage3_county_validation').'"');
							?>
              </li>
            </ul>
            <ul class=" fr ml26 width_240 deatil_ul">
              <li class=" mb20">
                <?php echo $this->lang->line('packstage3_fb_share_msg'); ?> </li>
              <li class="disable">
                <?php echo $this->lang->line('packstage3_fb_share_msg_1'); ?> </li>
              <li class="disable">
                <?php echo $this->lang->line('packstage3_fb_share_msg_1'); ?> </li>
              <li>
                <?php echo $this->lang->line('packstage3_password_hint'); ?> </li>
            </ul>
          </div>
          <?php 
            $data['cancelUrl'] =  base_url('package'); // set cancel url
            $data['backUrl']   =  base_url('package/packagestagetwo');
            $this->load->view('common_view/common_buttons',$data);
          ?>
        </div>
      </div>
      <!--  Membership wrap wrap end -->
    </div>
  </div>
</div>
<?php echo form_close(); ?>  
<!--  content wrap  end -->

<script>
  /**
   * @Description: Join form validation 
   */
  
    $('#email').focus(); // focus on email id
    
    //validate
    $("#packageStage3").validate({

        rules: {
            "firstName": {
                required: true,
                specialChar: true,
            }
        },
        messages: {
            "firstName": {
                specialChar: "Name must contain only letters and numbers."
            }
        },

        submitHandler: function() {
            var email             =  $('#email').val();
            var password          =  $('#password').val();
            var confirm_password  =  $('#confirm_password').val();
            var firstName         =  $('#firstName').val();
            var lastName          =  $('#lastName').val();
            var enterpriseName      =  $('#enterpriseName').val();
            var countryId         =  $('#countriesList').val();
            var cityName          =  $('#cityName').val();
            var selectedPacakge   =  '<?php echo $selectedPacakge; ?>';
            doRegister('<?php echo base_url(lang().'/auth/register');?>',email,password,confirm_password,firstName,lastName,enterpriseName,countryId,cityName,selectedPacakge);
            }
    });	
  
    //check user email availability
    $('.emailCheck').blur(function(){
        var errorStatus     =  $(this).hasClass('error');
        var email           =  $(this).val();
        
        if(email=="Email Address*"){
           return false; 
        }
        var emailChkUrl     =  '<?php echo base_url(lang().'/auth/emailavailablecheck');?>';
        if(errorStatus==false){
             $.ajax({
                  type: 'POST',
                  url : emailChkUrl,
                  dataType :'json',
                  data : {
                    email:email,
                    ajaxHit:1
                  },
                  beforeSend:function(){
                      //show loader
                      $("#emailAvailMsg").html('<img  class="ma ajax_loader" align="absmiddle"src="'+baseUrl+'images/loading_wbg.gif" />');
                  },
                  complete:function(){
                    
                  },
                  success:function(data){
                      
                    if(data.errorStatus){
                        //show error message condition
                        $('#emailAvailMsg').html(data.errorMessage);
                        $('#emailCheck').addClass('error');
                    }else{
                        $('#emailAvailMsg').html('');
                         $('#emailCheck').removeClass('error');
                    }
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                    $("#successMsg").html('');
                  }
            });
        }
    });
  
</script>
