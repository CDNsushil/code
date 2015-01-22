<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form to add/edit banner?>
<?php
	$userId=is_logged_in();
	$testiContent=(isset($testi_content))?$testi_content:'';
	
	
?>

<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">
	<div class="title_bg col-sm-12 margin10">
		<div class="title padding_left0">View Banner</div>
	</div>
	
<div class="clearfix"></div>
	<form class="form-horizontal" role="form">
		<div class="row">
				
			<div class="col-md-6  ">
				<div class="row img_box thum_img">
				<div class="inner_wrap">
					<?php $width=''; $height=''; ?>
						<?php  if( $_banner->image_type==1): $width='70px'; $height='70px'; endif;?>
					<?php  if( $_banner->image_type==2): $width=$_banner->image_width; $height=$_banner->image_height; endif;?>
					<?php  $width=($width>350)?'350':$width; ?>
					
					<?php $bannerImage= ($_banner->upload_type==0)?$_banner->image_url:base_url().$_banner->upload_path.$_banner->upload_image_name;?>
					<img src="<?php echo $bannerImage; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
				</div>
				</div>
			
				<div class="row margin10 ">
			<div class="row">
			<div class="row margin10 padding15 border_top">
				<label>Share on social media :</label>
				<div class="fleft social_network_container">
					<div class="sn_buttons"  onclick="fb_login();"><a href="javascript:void(0)">
						<span class="fa-stack fa-lg">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-facebook fa-stack-1x"></i>
						</span>Facebook</a>
					</div>
					<div class="sn_buttons"><a href="javascript:poptastic('<?php echo base_url()?>affiliate/twitterLogin/<?php echo $_banner->banner_id;?>')">
					<span class="fa-stack fa-lg">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-twitter fa-stack-1x"></i>
						</span>Twitter</a></div>
				
					
				<div class="sn_buttons"><a href="javascript:poptastic('<?php echo $gmail_oauth_url;?>')" >
						<span class="fa-stack fa-lg">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-google fa-stack-1x"></i>
					</span>Gmail</div></a></div>
					<div >
						
					
					<a href="javascript:void(0)" class="email_icon">
					<span class="fa-stack fa-lg">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-envelope fa-stack-1x"></i>
						</span>Email</a>
					</div>
				<!--	<div class="sn_buttons"><a href="javascript:void(0)">
						<span class="fa-stack fa-lg">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-pinterest fa-stack-1x"></i>
						</span>Pinterest</a></div>
					-->
						
				<input type="hidden" id="banner_detail" value='<?php echo json_encode($_banner)?>' name="banner_details">
				<input type="hidden" id="add_testi" name="add_testi" value='<?php echo json_encode($_banner)?>' >
				<div class="clear"></div>
				<div id="status"></div>
			</div>
			</div>
			<!--/END OF FORM GROUP/-->
				 <div class="row margin10 marginb10">
					<div class="btn-group ">

						<button type="button" class="btn btn-primary" onclick="history.go(-1)"> 
						<i class="fa fa-arrow-circle-left fa-fw fa-1x"></i> 
						<span><?php echo lang('global:back');?></span> 
						</button>
					</div>
					</div>
				</div>
				
			</div>
	
		<div class="col-md-6 product_text" >
					<div class="row fs18">
				<span><?php echo  ucfirst($_banner->banner_name);?></span></div>
		    <div class="row">
				
				<span><?php echo  $_banner->banner_description;?></span>
			</div>
			
		   <div class="row">
				<label>Price:</label>
				<label class="color_com"><?php echo  $_banner->banner_price.' '.$_banner->currency_type;?></label>
				,
				<label>Referral Point:</label>
				<span class="color_com"><?php echo  $_banner->referral_point;?></span>
				</div>
				
				<div class="row margin10">
					<?php 
					$refConfig=(isset($config) && !empty($config))?$config->referral_point_amt.' '.$config->currency:'0';
					
					?>
				<b>*Note : </b>   <span class="color_com"> 1 Referral Point =  <?php echo $refConfig;?> </span>.
				
				<div class="row margin10">
						<?php 
							
							$testiId= (!empty($testiData))?$testiData[0]->testimonial_id:'';
							$testiTitle= (!empty($testiData))?$testiData[0]->title:'';
							$checked=(!empty($testiTitle))?'checked':'';
						?>
						<label><input type="checkbox" name="add_testimonial" id="add_testimonial" <?php echo $checked; ?> class="addProductTesti" value="1"></label>
						<span class="">Add Testimonial</span>
						<?php if(!empty($testiTitle)): ?>
						<div class="color_com testi_title">
							<a href="javascript:void(0)" class="addProductTesti"><?php echo $testiTitle; ?></a>
							<a href="<?php echo base_url().'affiliate/removeProductTesti/'.encode($_banner->banner_id); ?>" class="deleteConfirm" title="Remove" >
								
								<button type="button" class="close color_red">
									<span aria-hidden="true" >×</span><span class="sr-only">Close</span>
								</button>
							</a>
						</div>
						<?php endif; ?>
					
					</div>
			
				
			</div>
			</div>
		</div>
	
		</form>
	</div>
	<!--/END OF COL-SM-6/-->	
<?php
    //to load testimonial popup content
	echo $testiContent; 
	echo $email_popup;

?>

<!-- Set your options, most importantly the domain_key -->
<script type="text/javascript">
	// these values will hold the owner information
	function populateTextarea(contacts, source, owner) {
		share_affiliate_banner(contacts,'gmail',0)
	}
	var csPageOptions = {
	  domain_key:'XQDR2YDRWRJNV6VP8E6B',
	  sources:"gmail",
	  skipSourceMenu:false,
	  afterSubmitContacts:populateTextarea
	};
</script>
<script>
    function poptastic(url) {
      var newWindow = window.open(url, 'name', 'height=500,width=500,scrollbars=yes');
      if (window.focus) {
        newWindow.focus();
      }
    }

</script>
<!-- Include the script at the end of the body section -->
<!--
<script type="text/javascript" src="//api.cloudsponge.com/address_books.js"></script>
-->
</div>
<!--/END OF ROW/-->	
</div>

<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      //document.getElementById('status').innerHTML = 'Please log ' +
      //  'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      //document.getElementById('status').innerHTML = 'Please log ' +
      //  'into Facebook.';
    }
  }


  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '594177644021649',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.
    function testAPI() {
		console.log('Welcome!  Fetching your information.... ');
		FB.api('/me', function(response) {
		  //console.log('Successful login for: ' + response.name);
		  //document.getElementById('status').innerHTML =	'Thanks for logging in, ' + response.name + '!';
		});
    }
    function fb_login(){
		FB.login(function(response) {
			console.log(response);
			if(response.authResponse){
				console.log('Welcome!  Fetching your information.... ');
				//console.log(response); // dump complete info
				access_token = FB.getAuthResponse()['accessToken']; //get access token
				user_id = response.authResponse.userID; //get FB UID

				FB.api('/me', function(response) {
					user_email = response.email; //get user email
					share_affiliate_banner(response,'fb',access_token);
					//you can store this data into your database             
				});
			}
			else
			{
				//user hit cancel button
				console.log('User cancelled login or did not fully authorize.');
			}
		},{scope: 'publish_actions'});
    }
    
    function share_affiliate_banner(userdata,type,access_token){
		if(userdata!=''){
			var productTesti=$('#product_testi').val();
			
			banner_data = $('#banner_detail').val();
			$.ajax({
				url:"<?php echo base_url();?>affiliate/shareBanner/"+type,
				type:'POST',
				data:{userdata:userdata,access_token:access_token,banner_data:banner_data,productTesti:productTesti},
				success:function(result){
					alert(result);
				}
			});
		}
	}
</script>



