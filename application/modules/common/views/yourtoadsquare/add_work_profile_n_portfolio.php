<li data-submenu-id="sub_t20" class="bg_f3f3f3  work_profile common_i  toad_menu_open">
   <a href="javascript:void(0)"><span>Add</span> your Work Profile &amp; Portfolio</a> 
	<ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t20">
		<li class=" fs20  clr_geern your_toad bg_f3f3f3 display_table"> <span class="display_cell veti_midl">Your private Showcase
			and multimedia CV</span>
		</li>
		<li>
			<span class="content_menu ">
				<p> Setup your Work Profile & Portfolio then send a link to it to potential colleagues and employers. They can then privately access your videos, audio files and writings, as well as print out your CV. </p>
				<span class="sap_15"></span>
				<p>You can sync your Work Profile & Portfolio with any tablet or smart phone using our Toadsquare App. Your multimedia CV is in your pocket ready to show at any time. </p>
			</span>
			<div class="your_toad_subhead red fs18"> What type of Media do you want to showcase? </div>
			<form action="<?php echo base_url(lang().'/workprofile/setworkprofilenextstep');?>" method="post" id="wpAddForm">
				<span class="content_menu ">
					<ul class=" red_arrow_list menu_radio defaultP  listpb10">
						<li>
							<input type="radio" value="1" name="wpActionType" checked='checked' >
							Setup your online Profile, your CV? 
						</li>
						<li>
							<input type="radio" value="2" name="wpActionType" >
							Setup your online Portfolio showcasing your Media? 
						</li>
					</ul>
					<span class="sap_30"></span>
					<p class="text_alignC">
						<button class="width_208" onclick="$(#wpAddForm).submit();">Create</button>
					</p>
				</span>
			</form> 
		</li>
	</ul>
</li>

