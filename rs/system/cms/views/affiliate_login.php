<!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <?php
	//get login data for affiliate
	$loginData=getRememberAffiliate();

   ?>
  <div class="modal-dialog LoginModal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Login as Affiliate</h4>
      </div>
      <?php echo form_open(base_url().'users/login'); ?>
      <div class="modal-body">
        	<div class="form-group">
            	<div class="control-group">
                	<label>Email<span>*</span></label>
               		<input type="text" name="email" required  class="email" placeholder="Enter Your E-Mail" value="<?php if(!empty($loginData) && array_key_exists("login_email",$loginData)){  echo $loginData['login_email']; }?>" autocomplete="off">
               		<span class="error"></span>
                </div>
                <div class="control-group">
                	<label class="pull-left">Password<span>*</span></label>
                     
               		<input type="password"  name="password"  required placeholder="Enter Your Password" value="<?php if(!empty($loginData)  && array_key_exists("login_pass",$loginData)){  echo $loginData['login_pass']; }?>" autocomplete="off">
                </div>
                 <div class="control-group">
                	<label class="checkbox">
						<?php $checked=(!empty($loginData))?'checked':'';?>
                        <input type="checkbox" name="remember_user" id="remember_user" <?php echo $checked; ?> value="1" class="lc_checkbox"> Remember Me 
                        <a href="<?php echo 'users/forgot-password/'.encode('2'); ?>" class="pull-right">Forgot Password?</a>
                    </label>
                </div>
                <br>
            </div>
      </div>
     
      <div class="modal-footer text-center">
		  <input type="hidden" name="banner_id" id="banner_id" value="<?php if(!empty($loginData) && array_key_exists("banner_id",$loginData)){ echo $loginData['banner_id']; }?>">
		 <input type="hidden" name="group_id" id="group_id" value="2"> 
         <button type="submit" class="btn btn-primary col-xs-12" >Login</button>
      </div>
   <?php echo form_close(); ?>
    </div>
  </div>
</div>
 
