<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="cell shadow_wp strip_absolute_right left0">
	<!-- <img src="images/strip_blog.png"  border="0"/>-->
	<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td height="350"><img src="<?php echo base_url();?>images/dashboard_images/dashboard_newshedow_top.png"></td>
			</tr>
			<tr>
				<td class="dashnew_shadow_mid">&nbsp;</td>
			</tr>
			<tr>
				<td height="378"><img src="<?php echo base_url();?>images/dashboard_images/dashboard_newshedow_bottom.png"></td>
			</tr>
		</tbody>
	</table>
	<div class="clear"></div>
</div>

<div class="row">
	<div class="font_opensans font_size14 clr_black lineH22 pb5">Please read the <a href="<?php echo site_url().'dashboard/loadWelcomePage/welcome_performancesevents';?>"><span class="display_inline clr_f1592a font_opensansSBold gray_clr_hover underline">Performances & Events Welcome </span></a> before you use the section.
		<div class="bdrB_e2e2e2 fr mr20 width_158 mt15"></div>
	</div>
</div>
<div class="row">
	<?php if(!isset($isNotification) && empty($isNotification)) { ?>
	<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt15">Events, Launches and <br /> Events with Launch
</div>

<div class="font_size12 font_opensans clr_3d3d3d mt7">To add an <span class="font_opensansSBold display_inline">Event, Launch or Event with Launch </span>pick the Tool you want to use from the appropriate Select Tool box. Click the radio button next to the Tool you want to use, click

	<img src="<?php echo base_url();?>images/dashboard_images/newsevent.png" class="mt5"/>

	<div class="clear"></div>
	<div class=" line_H13">
		then fill in and save the forms in the wizard. <br />
		<div class="seprator_14"></div>
	</div>
	Once you have saved an Event, Launch or Event with Launch from here you can:
	<div class="clear"></div>
	<div class="seprator_6"></div>
	<ul class="dashside_inform">
		<li>
			<div>
				Add
				<img src="<?php echo base_url();?>images/dashboard_images/addinfor.png" alt="add" class="display_inline mb-5"/>
				another session; only to an Event,
			</div>
		</li>

		<li>
			<div>
				Edit <img src="<?php echo base_url();?>images/dashboard_images/editinfor.png" alt="add" class="display_inline mb-5"/>
				it
			</div>
		</li>

		<li>
			<div>
				View 
					<img src="<?php echo base_url();?>images/dashboard_images/viewinfoer.png" alt="add" class="display_inline mb-5"/> 
				it on your Showcase, 
			</div>
		</li>
		<li><div>See how much space you have left to use,</div></li>
		<li> 
			<div>
				<img src="<?php echo base_url();?>images/dashboard_images/addspace.png" alt="add" class="display_inline mb-10"/> 
				if you exceed the 100 MB limit and 
			</div>
		</li>
		<li><div><img src="<?php echo base_url();?>images/dashboard_images/renew.png" alt="add" class="display_inline mb-10"/></div></li>
	</ul>
	
<div class="clear"></div>
<div class="row mt15">
<div class="fl">The Events Event</div> <div class="dashperformance_eventcircle_Sm font_opensansSBold font_size12 clr_white fl mr5 ml5 mt-4 font_size4 lineh6">
<div class="AI_table">
<div class="AI_cell">
Event <br>Index Page
</div>
</div>
</div> <div class="fl">Index</div>
<div class="row"></div>
</div>

<div class="seprator_6"></div>
<div class="row">
<div class="fl">Launches </div> <div class="dashperformance_eventcircle_Sm font_opensansSBold font_size12 clr_white fl mr5 ml5 mt-4 font_size4 lineh6">
<div class="AI_table">
<div class="AI_cell">
Event <br>Index Page
</div>
</div>
</div> <div class="fl">Index and</div>
<div class="row"></div>
</div>

<div class="seprator_6"></div>
<div class="row">
<div class="fl">Events with Launch</div> <div class="dashperformance_eventcircle_Sm font_opensansSBold font_size12 clr_white fl mr5 ml5 mt-4 font_size4 lineh6">
<div class="AI_table">
<div class="AI_cell">
Event<br />
with Launch<br />
Index Page
</div>
</div>
</div> <div class="fl"> Indexes
provide more details and tools to manage your Events.</div>
<div class="row"></div>
</div>
</div>

<?php } if(!isset($isEvent) && empty($isEvent) && !isset($isNotification) && empty($isNotification)) { ?>

<div class="row">
	<a href="<?php echo site_url().'dashboard/performancesevents/containers';?>">
<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt18 underline gray_clr_hover">What are Event, Launch and
Event with Launch Tools?</div></a>
<div class="font_size12 clr_3d3d3d font_opensans mt12 lineh17">An Event Tool and a Launch Tool are free when you join, and if you joined before 31st March 2014, you also have a free Event with Launch Tool as part of our opening special.<div class="seprator_14"></div>

These Tools guide you through your Showcase setup. Pick the tool that best suits the nature of your event. A main difference between an Event and a Launch is that an Event can have up to twenty sessions and a Launch only one. An Event with Launch Tool combines the two other tools and links then on your Showcase. If have no available Tools and you wish to put up another Event you will need to buy one: an Event Tool is €10, a Launch Tool €6, and Event with Launch Tool €16. Each Tool comes with 100 MB of space, if you need more you can add it at €0.80 per 100 MB. <div class="seprator_14"></div>

A Tool is valid for six months after which you need to renew it. You can change the space when you renew, and it is a good time to check that your Event is up to date.</div>
</div>


<?php } if(!isset($isEvent) && empty($isEvent)) { ?>
<div class="row">
<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt28">Event Notifications</div>
<div class="font_size12 clr_3d3d3d font_opensans mt12 lineh17">A collection of Event Notifications is free and comes with 100 MB of free space, if you need more you can add it at €0.80 per 100 MB for six months.<div class="seprator_14"></div>

To add an Event Notification click
<div class="clear"></div>
<div class="fl mr5"> <img src="<?php echo base_url();?>images/dashboard_images/newnotification.png" /></div>
<div class="clear"></div>
then fill in and save the forms in the wizard.

<div class="seprator_14"></div>
Once you have saved an Event Notification from here you can:</div>
<ul class="dashside_inform mt10 font_opensans">
<li>
<div>
<span class="fl"> Add another  </span> 
<div class="fl mr5"> <img src="<?php echo base_url();?>images/dashboard_images/newnotification.png" /></div>to your Performances & Events Showcase,
</div>
</li>

<li>
<div>
<span class="fl">View</span> <div class="fl ml5 mr5"> <img src="<?php echo base_url();?>images/dashboard_images/viewinfoer.png" /> </div> your Notifications on your Showcase, </div></li>
<li> <div>See how much space you have left to use and </div></li>
<li> <div> <img class="display_inline mb-10" alt="add" src="<?php echo base_url();?>images/dashboard_images/addspace.png"> if you exceed the 100 MB limit and </div></li>
</ul>

</div>
<div class="clear"></div>

<div class="row">
<div class="font_opensansSBold clr_f1592a font_size14 lineH20 mt28">Membership Notifications</div>
<div class="font_opensans clr_3d3d3d mt10">provides a detailed description of all Toadsquare’s Tools and prices.</div>
</div>
<?php }?>

</div>
