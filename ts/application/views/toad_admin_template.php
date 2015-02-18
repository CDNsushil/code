<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 	echo $head;
 	$selected_class	=	'Left_side_menu_admin';
 	$selectedMenu = "select_".$this->router->fetch_module();
?>		
<body><!-- #wrapper [begin] -->

<div class="dn" id="popupBoxWp">
	<div class="popup_box" id="popup_box"></div>
</div>
<div id="wrapper">
	<!-- header [begin] -->
	<div id="header">
    	<a href="<?php echo base_url();?>" title=""><img src="<?php echo base_url('templates/default/images/logo_toad.png'); ?>" alt="Control Panel" class="logo" /></a>
    	<!--<div id="searcharea">
            <p class="left smltxt"><a href="#" title="">Advanced</a></p>
            <input type="text" class="searchbox" value="Search control panel..." onclick="if (this.value =='Search control panel...'){this.value=''}"/>
            <input type="submit" value="Search" class="searchbtn" />
        </div>-->
    </div>
	<!-- header [end] -->
	
	<!-- Right Side/Main Content Start -->    
    <div id="rightside">
	<?php  $getModuleName=  $this->router->fetch_module();
	$idName = ($getModuleName=="manage_news")?"":"wrapperL";
	?>	
	<div id="<?php echo $idName; ?>">
		<?php echo $contents; ?>		
	</div><!-- wrapperL -->
		<div id="footer">
			&copy; Copyright <?php echo date('Y');?> Toadsquare
		</div>
    
    </div>    
    <!-- Right Side/Main Content End -->
	<?php
		$session_user_data =$this->session->userdata('session_data');
		if($session_user_data['enterprise']=='t')
			$username = $session_user_data['enterpriseName'];
		else
			$username = $session_user_data['firstname']." ".$session_user_data['lastname'];
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
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_language/" ><?php echo $this->lang->line('admin_manage_translation');?></a></li>
					<li class="<?php echo ($selectedMenu=='select_manage_tips')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_tips/" ><?php echo $this->lang->line('admin_manage_tips');?></a></li>
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_cms/cms_list/" ><?php echo $this->lang->line('admin_manage_cms');?></a></li>
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_users/" ><?php echo $this->lang->line('admin_manage_users');?></a></li>				
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_countries/" ><?php echo $this->lang->line('admin_manage_country');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_eu_countries/" ><?php echo $this->lang->line('admin_manage_eu_country');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_state/" ><?php echo $this->lang->line('admin_manage_state');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_templates/" ><?php echo $this->lang->line('admin_manage_temp');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_suggestions/" ><?php echo $this->lang->line('admin_manage_suggestions');?></a></li>
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_continent/" ><?php echo $this->lang->line('admin_manage_continent');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_lang/" ><?php echo $this->lang->line('admin_manage_lang');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_genre/" ><?php echo $this->lang->line('admin_manage_genre');?></a></li>
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_pressRelease" ><?php echo $this->lang->line('admin_pressRelease');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_news" ><?php echo $this->lang->line('admin_News');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_report" ><?php echo $this->lang->line('admin_report');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_messaging" ><?php echo $this->lang->line('admin_manage_messages');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_tmail" ><?php echo $this->lang->line('admin_manage_tmail');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_visitors" ><?php echo $this->lang->line('visitorsLog');?></a></li>
					<li class="<?php echo ($selectedMenu=='select_manage_pressRelease')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_password" ><?php echo $this->lang->line('admin_Manage_password');?></a></li>	
					<li class="<?php echo ($selectedMenu=='select_manage_newsletter')?$selected_class:'';?>"><a href="<?php echo BASEURL?>admin/settings/manage_newsletter" ><?php echo $this->lang->line('admin_Manage_newsletter');?></a></li>	
				</ul>
			</li>
		</ul>
    </div>
    <?php  
    //error and sucess message show helper
	echo get_global_messages();
	?>
    <!-- Left Dark Bar End --> 
</div><!-- end div #wrapper -->
