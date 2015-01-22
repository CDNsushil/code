<center id="contacts_container">
	<div id="options">
	  <label>
		<?php 
			if(!empty($emails)){
				echo "Choose contacts to send banner";
			}else{
				echo "Internal server problem. Please try again latter.";
			}
		?>
			
				
		</label>
	  <div class="clear"></div>
	  <ul>
		<?php
		if(!empty($emails)){
			foreach($emails as $key=>$email){?>
				<li>
				   <input class="checkbox" type="checkbox" username="<?php echo $email['name'];?>" value="<?php echo $email['email'];?>" name="gmail_contacts[]">
				   <label><?php echo $email['email'];?></label>
				   <div style="clear:both"></div>
				</li>
		<?php
			}
		}
		?>
		</ul>
	</div>
	<div class="footer"><center><div class="submit"><input type="button" value="submit" class="button" name="button"/></div></center></div>
</center>
<style>
body{background-color:#f5f5f5;}
#options label {
  float: left;
  color:#21b8f1;
}

#options ul {
  margin: 0;
  list-style: none;
  float: left;
}
#options ul input{
    float:left;
}
.footer{position:fixed;bottom:0;width:100%;background-color:grey;}
.options{padding:25px;}
.clear{clear:both;}
</style>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.button').click(function(){
		var emails = [];
		obj = {};
		$('input[type=checkbox]:checked').each(function() {
		   obj = {email:this.value,name:$(this).attr('username')};
		   emails.push(obj);
		});
		share_affiliate_banner(emails,'gmail','');
	});
});
function share_affiliate_banner(userdata,type,access_token){
	if(userdata!=''){
		var parentWindow = window.opener;
		banner_data = parentWindow.$('#banner_detail').val();
		$.ajax({
			url:"<?php echo base_url();?>affiliate/shareBanner/"+type,
			type:'POST',
			dataType:'json',
			data:{userdata:userdata,access_token:access_token,banner_data:banner_data},
			success:function(result){
				if(result.status=='success')
				{
					$('#contacts_container').html("Banner Successfully sent to selected contacts !");
					setTimeout(function(){window.close();}, 2000);
				}
				else
				{
					$('#contacts_container').html("An error occurred while sending banner to selected contacts, Please try after some time !");
					setTimeout(function(){window.close();}, 2000);
				}
			}
		});
	}
}
</script>

</script>
<?php die;?>
