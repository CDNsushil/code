<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once('header.php');?>
</head>
<body>
	<div id="logincontainer">
    	<div id="loginbox">
        	<div id="loginheader">
            	<img src="<?php echo base_url();?>templates/admin_template/css/themes/blue/img/cp_logo_login.png" alt="Control Panel Login" />
            </div>
            <div id="innerlogin">
				<?php echo form_open($this->uri->uri_string(),$formAttributes=array('method'=>'post', 'name'=>'adminLoginForm','id'=>'adminLoginForm',)); ?>
                	<p><?php echo $this->lang->line('label_username')?></p>
					<?php
					$data = array(
							  'size'        => '40',
							  'name'		=> 'username',
							  'id'			=> 'username',
							  'class'		=>'logininput'
								);
					echo form_input($data);
					?>
					<span class="validation_msg" id="validation_username"><?php echo $this->lang->line('validation_username')?><br /></span>
					
                    <p><?php echo $this->lang->line('label_password')?></p>
					<?php
					$data = array(
							  'size'        => '40',
							  'name'		=> 'password',
							  'id'			=> 'password',
							  'type'		=> 'password',
							  'class'		=> 'logininput'
								);
					echo form_input($data);
					?>
                   <span class="validation_msg" id="validation_password"><?php echo $this->lang->line('validation_password')?><br /></span>
				   
				   <?php
					$data = array(
							  'name'		=> 'login',
							  'id'			=> 'login',
							  'class'		=>'loginbtn',
							  'type'		=>'submit',
							  'value'		=>$this->lang->line('label_submit')
								);
					echo form_input($data);
					?>
				   

				   <div id="err_msg"style="color:red;font-size:15px;margin-top:20px;">
				   <?php echo $this->session->flashdata('message');
				   ?>
				   </div>
                </form>
            </div>
        </div>
        <img src="<?php echo base_url()?>templates/admin_template/img/login_fade.png" alt="Fade" />
    </div>
</body>
</html>
