<?php //this si affiliate login form?>
<?php
	$uriString=(isset($uri_string))?$uri_string:'';
 ?>


	<div class="content">
	<h2 class="page-title" id="page_title"><?php if(isset($form_heading)): echo $form_heading; endif; ?></h2>
	<?php echo form_open($uriString, array('id'=>'login'))) ?>
		<ul>
			<li>
				<label for="email"><?php echo lang('global:email') ?></label>
				<?php echo form_input('email', $this->input->post('email') ? escape_tags($this->input->post('email')) : '')?>
			</li>
			<li>
				<label for="password"><?php echo lang('global:password') ?></label>
				<input type="password" id="password" name="password" maxlength="20" />
				
			</li>
			<li id="remember_me">
				<label><?php echo lang('user:remember') ?></label>
				<?php echo form_checkbox('remember', '1', false) ?>
			</li>
			<li class="form_buttons">
				<input type="submit" value="<?php echo lang('user:login_btn') ?>" name="btnLogin" /> <span class="register"> | <?php echo anchor('register?user=2', lang('user:register_btn'));?></span>
			</li>
			<li class="reset_pass">
				<?php echo anchor('users/reset_pass', lang('user:reset_password_link'));?>
			</li>
		</ul>
		<?php echo form_close(); ?>
	</div>
