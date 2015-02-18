<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	echo $head;
?>

<body><!-- #wrapper [begin] -->
	<link href="<?php echo ADMINCSS?>layout.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ADMINCSS?>wysiwyg.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ADMINCSS?>themes/blue/styles.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ADMINCSS?>style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ADMINCSS?>update_password_validation.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ADMINCSS?>jquery.alerts.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" >
		var BASEPATH = "<?php echo base_url();?>";
		var baseUrl = "<?php echo base_url();?>";
	</script>
	
<div class="dn" id="popupBoxWp">
	<div class="popup_box" id="popup_box"></div>
</div>
<div id="wrapper">
	<!-- header [begin] -->
	<div id="header">
    	<a href="" title=""><img src="" alt="Control Panel" class="logo" /></a>
    	<!--<div id="searcharea">
            <p class="left smltxt"><a href="#" title="">Advanced</a></p>
            <input type="text" class="searchbox" value="Search control panel..." onclick="if (this.value =='Search control panel...'){this.value=''}"/>
            <input type="submit" value="Search" class="searchbtn" />
        </div>-->
    </div>
	<!-- header [end] -->
	
	<!-- Right Side/Main Content Start -->
    <div id="rightside">
		<?php echo $contents ?>
		<div id="footer">
			&copy; Copyright <?php echo date('Y');?> Toadsquare
		</div>
    </div><!-- Right Side/Main Content End -->
	<?php
		$session_user_data =$this->session->userdata('session_data');
		$username =$session_user_data['firstname']." ".$session_user_data['lastname'];
	 ?> 
	<!-- Left Dark Bar Start -->
    <div id="leftside">
    	<div class="user">
        	<img src="<?php echo base_url('images/var_user_img_default2.jpg');//echo getimage('user',1,$session_user_data['user_id']);?>"  alt="Admin" />
            <p><?php echo $this->lang->line('login_as_text');?></p>
            <p class="username"><?php echo (trim($username)==''?'Admin':$username);?></p>            
            <p class="userbtn">
                <a href="<?php echo BASEURL ?>toad_admin/toad_admin/settings" style="float:left;margin-right:3px;">settings</a>
                <a href="<?php echo BASEURL ?>toad_admin/toad_admin/logout" style="float:left;"><?php echo $this->lang->line('btn_log_out')?></a>
            </p>
        </div>
      
		<ul id="nav">
        	<li>
                <ul class="navigation">
						<li><a href="<?php echo BASEURL?>language/" ><?php echo $this->lang->line('admin_manage_translation');?></a></li>
						<li><a href="<?php echo BASEURL?>tips/" ><?php echo $this->lang->line('admin_manage_tips');?></a></li>
						<li><a href="<?php echo BASEURL?>cms/cms_list/" ><?php echo $this->lang->line('admin_manage_cms');?></a></li>


						<!--li><a href="<?php echo BASEURL?>admin/users/" ><?php echo $this->lang->line('admin_manage_users');?></a></li-->
						<li><a href="<?php echo BASEURL?>pressRelease/listing/" ><?php echo $this->lang->line('admin_pressRelease');?></a></li>
						<li><a href="<?php echo BASEURL?>news/listing/" ><?php echo $this->lang->line('admin_News');?></a></li>

<?php /* ?>
						<li>
							<a href="<?php echo BASEURL?>admin_global_setting" class="<?php echo ($this->uri->segment(1)=="admin_global_setting"?"selected":""); ?>">
								<?php echo $this->lang->line('admin_template_global_setting');?>
							</a>
						</li>
						
						
						<li><a href="<?php echo BASEURL?>admin/admin/advertisment" class="<?php echo ($this->uri->segment(3)=="advertisment"?"selected":""); ?>" ><?php echo $this->lang->line('manage_advert')?></a></li>										
						<!--<li><a href="<?php echo BASEURL?>admin/advert/" 				class="<?php echo ($this->uri->segment(2)=="advert"?"selected":""); ?>" ><?php echo $this->lang->line('manage_advert')?></a></li>-->					
						<li><a href="<?php echo BASEURL?>admin/admin/manage_states" 	class="<?php echo ($this->uri->segment(3)=="manage_states"?"selected":""); ?>" ><?php echo $this->lang->line('admin_manage_states')?></a></li>
						
						<li><a href="<?php echo BASEURL?>admin_users" 					class="<?php echo ($this->uri->segment(1)=="admin_users"?"selected":""); ?>" title=""><?php echo $this->lang->line('admin_manage_user');?></a></li>
						
					
                        <li><a href="<?php echo BASEURL?>admin_statistics" 				class="<?php echo ($this->uri->segment(1)=="admin_statistics"?"selected":""); ?><?php echo ($this->uri->segment(1)=="manage_country_stats"?"selected":""); ?>" title="" ><?php echo $this->lang->line('admin_manage_statistics');?></a></li>
					
                                        
						<li><a href="<?php echo BASEURL?>admin/admin/admin_manage_activity" 			class="<?php echo ($this->uri->segment(1)=="admin_manage_activity"?"selected":""); ?>"><?php echo $this->lang->line('manage_admin_content')?></a></li>	
					
					
						<li><a href="<?php echo BASEURL?>admin/admin/get_all_reports" 	class="<?php echo ($this->uri->segment(3)=="get_all_reports"?"selected":""); ?>" ><?php echo $this->lang->line('admin_report')?></a></li>
					
						
						<!--<li><a href="<?php echo BASEURL?>manage_country_stats" 		class="<?php echo ($this->uri->segment(1)=="manage_country_stats"?"selected":""); ?>"><?php echo $this->lang->line('manage_country_stats')?></a></li>-->
						<li><a href="<?php echo BASEURL?>admin_manage_email_templates/view_email_template" 	class="<?php echo ($this->uri->segment(3)=="invite_report"?"selected":""); ?>" ><?php echo $this->lang->line('manage_email_templates');?></a></li>
<?php */ ?>					
				</ul>
			</li>
		</ul>
    </div>
    <!-- Left Dark Bar End --> 
</div><!-- end div #wrapper -->
</body>
</html>
