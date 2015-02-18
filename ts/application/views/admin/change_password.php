<div class="contentcontainer">
	<div class="headings altheading">
		<h2>Change Password</h2>
	</div>
		
	<div id="main">
		<div id="content">
		   <div class="content">
   	            <div id="signupbox">
      		     <div id="signupwrap">
      			<form id="signupform" autocomplete="off" method="post" action="">
	  		  <table>
	  		  <tr>
	  			<td class="label"><label id="lusername" for="username"><?php echo $this->lang->line('current_password')?></label></td>
	  			<td class="field"><input name="cpassword" type="password" value="" maxlength="50" /></td>
				<td class="status"></td>
	  		  </tr>
	  		  <tr>
	  			<td class="label"><label id="lpassword" for="password"><?php echo $this->lang->line('new_password')?></label></td>
	  			<td class="field"><input id="password" name="password" type="password" maxlength="50" value="" /></td>
	  			<td class="status">
	  				<div class="password-meter">
	  					<div class="password-meter-message">&nbsp;</div>
	  					<div class="password-meter-bg">
		  					<div class="password-meter-bar"></div>
	  					</div>
	  				</div>
				</td>
	  		  </tr>
	  		  <tr>
	  			<td class="label"><label id="lpassword_confirm" for="password_confirm"><?php echo $this->lang->line('retype_password')?></label></td>
	  			<td class="field"><input id="password_confirm" name="password_confirm" type="password" maxlength="50" value="" /></td>
	  			<td class="status"></td>
	  		  </tr>
	  		  <tr>
	  			<td class="label"><label id="lsignupsubmit" for="signupsubmit"><?php echo $this->lang->line('change_password')?></label></td>
	  			<td class="field" colspan="2">
	            <input id="signupsubmit" name="change_password" type="submit" value="Signup" />
	  		<?php echo $this->session->flashdata('message');
				   ?></td>
	  		  </tr>
			</table>
          		</form>
      			</div>
    		   </div>
		</div>
           </div>

</div>
</div>
<script id="demo" type="text/javascript">
		$(document).ready(function() {
	// validate signup form on keyup and submit
	var validator = $("#signupform").validate({
		rules: {
			cpassword: {
				required: true,
				minlength: 2
			},
			password: {
				password: "#username"
			},
			password_confirm: {
				required: true,
				equalTo: "#password"
			}
		},
		messages: {
			cpassword: {
				required: "Enter a Password",
				minlength: jQuery.format("Enter at least {0} characters")
			},
			password_confirm: {
				required: "Repeat your password",
				minlength: jQuery.format("Enter at least {0} characters"),
				equalTo: "Enter the same password as above"
			}
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			error.prependTo( element.parent().next() );
		},
		// specifying a submitHandler prevents the default submit, good for the demo
		//submitHandler: function() {
		//	alert("submitted!");
		//},
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("checked");
		}
	});
	
	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		if(firstname && lastname && !this.value) {
			this.value = firstname + "." + lastname;
		}
	});
	
});
</script>
