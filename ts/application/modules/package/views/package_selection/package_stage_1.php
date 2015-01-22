<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$packageStage1 = array(
  'name'=>'packageStage1',
  'id'=>'packageStage1'
);

$selectedPacakge = array(
  'name'    =>  'selectedPacakge',
  'id'      =>  'selectedPacakge',
  'value'   =>  '0',
  'type'    =>  'hidden',
);



//get 1 & 3 year package id
$pakcageTypeFree        = $this->config->item('package_type_1');
$pakcageTypeOneYear     = $this->config->item('package_type_2');
$pakcageTypeThreeYear   = $this->config->item('package_type_3');

//define default variable for radio button checked
$freePackageChecked   = false;
$oneYearChecked       = false;
$threeYearChecked     = false;

$lblAboveBtn = $this->lang->line('package_join_for');

//check user subscription data is not empty
if(!empty($userSubscription)){
  //if packed is selected
  if(!empty($userSubscription->subscriptionType)){
    //condition for 1 year package
    if($userSubscription->subscriptionType==$pakcageTypeOneYear){
      $oneYearChecked = true;
    //condition for 3 year package	
    }elseif($userSubscription->subscriptionType==$pakcageTypeThreeYear){
      $threeYearChecked =true;
    }elseif($userSubscription->subscriptionType==$pakcageTypeFree){
      $freePackageChecked =true;
    }	
  }
  $lblAboveBtn = $this->lang->line('package_upgrade_to');
}

// free button condition
if($freePackageChecked || $oneYearChecked || $threeYearChecked){
  $joinFreeButton = array(
    'name'    =>  'free',
    'id'      =>  $this->config->item('package_type_1'),
    'content' =>  $this->lang->line('pack_button_already'),
    'class'   =>  'b_F1592A selectPackage disable_btn',
    'type'    =>  'button',
  );
}else{
  $joinFreeButton = array(
    'name'    =>  'free',
    'id'      =>  $this->config->item('package_type_1'),
    'content' =>  $this->lang->line('pack_button_join_free'),
    'class'   =>  'b_F1592A selectPackage ',
    'type'    =>  'submit',
  );
}

?>
<?php 
  echo form_open($this->uri->uri_string(),$packageStage1); 
?>

<!--membership information page start-->

<div class="newlanding_container bg_f6f6f6">
   <div class="wizard_wrap fs14 ">
      <div id="TabbedPanels1" class="TabbedPanels membership">
         <div class="TabbedPanelsContentGroup main_tab m_auto membership_info  display_table ">
            <div class="TabbedPanelsContent TabbedPanelsContentVisible">
               <div class="sap_30 mt2"></div>
               <table width="834" border="1" class="m_auto membership_table font_arial">
                  <tr>
                    <th> 
                         <span class="red bb_F1592A  bt_F1592A fs33 lineH41 pb5 letter_spP7 opens_light" >Membership Options</span> <span class="fs26 pt20 pl7 opens_light lineH31"> <span class="letter_spP7"> Join for FREE and<br />
                        connect to your<br />
                        favourite creatives.</span> <span class="pt13 letter_spP7">Try our Annual or <br />
                        3-year Memberships<br />
                        with a month's trial</span> </span> <span class="pt20 fs15 s_italic lineH26 letter_spP7">Roll over to see more details. 
                        <img src="<?php echo $imgPath; ?>/arrow_mem.png" alt="" class="pl45" /></span> 
                     </th>
                     <th >
                        <span class="free display_block">
                           <p class="height64">Free</p>
                        </span>
                       <div class="fs19 pt25 opens_light lett4"> <span> Create your online <br />
                           multimedia profile,<br />
                           your Showcase,<br />
                           for FREE.</span> <span class="pt15 "> Pay as you go to add<br />
                           additional sections.</span> <span class="pt15 letter_spP7">Unlimited, effortlass editing. </span> 
                        </div>
                          <?php echo form_button($joinFreeButton ); ?>
                     </th>
                     <th>
                        <table>
                           <tr class="free lett4">
                              <td>Annual </td>
                              <td>3 Year</td>
                           </tr>
                           <tr class="defaultP ">
                              <td class="pt8 pb3"><label class="lineH30"> &euro;99 </label></td>
                              <td class="pt8 pb3"><label class="lineH30"> &euro;199 </label></td>
                           </tr>
                        </table>
                        <span class="fs20 pt25 opens_light lett4 pb3"> <span> Grow your Showcase,<br />
                        with unlimited sections </span><br />
                        and<span class="red fs30 pt5 mb8 pl15">50 GB</span> <span>of storage space.</span></span>
						<!--<span class="fs20 lett4 pb3"> <span> <?php //echo $lblAboveBtn;?></span><br />-->
						
                       <?php 
                            $buttonData['oneYearChecked']  		  = $oneYearChecked;
                            $buttonData['threeYearChecked'] 	  = $threeYearChecked;
                            $buttonData['buttonPositionClass'] 	= 'pt25';
                            $this->load->view('common_view/package_upgrade_button',$buttonData);
                        ?>
                     </th>
                  </tr>
                  <tr>
                     <td>
						 Showcase Homepage 
						<!-- showcase homepage popup start-->
                        <div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
                            <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
                           <h4 class="fs21 red bb_F1592A">Showcase Homepage</h4>
                           <h5 class="fs16 pt24 font_weight">Take a Bow! </h5>
                           <p class="fs14">Your Showcase Homepage introduces you on Toadsquare and online. From here you can tell the world about yourself, through words, images and video.</p>
                           <p class="fs14">It’s the door through which people can contact you, review you and recommend your work, as well as being the linchpin of your Showcase.</p>
                           <p class="fs14">Whether you are a creative or a fan put up your Showcase Homepage and enter the creative world. </p>
                        </div>
                         <!-- showcase homepage popup end-->
                     </td>
                     <td>
                        <p><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></p>
                     </td>
                     <td>
                        <p><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></p>
                     </td>
                  </tr>
                  <tr>
                     <td>
						 Multilingual Features
						<!-- Multilingual Features popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Multilingual Features</h4>
							   <h5 class="fs16 pt24 font_weight">Are you part of our increasingly global world?  </h5>
							   <p class="fs14">Introduce yourself in multiple languages on your Homepage and enter information in any language anywhere on Toadsquare to create your multilingual Showcase.</p>
							   <p class="fs14">We plan to translate the site into different languages as it grows, but for now we built it to work well with Google Chrome's translation features.</p>
							</div>
                        <!-- Multilingual Features popup end-->
					 </td>
                     <td>
                        <p><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></p>
                     </td>
                     <td>
                        <p><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></p>
                     </td>
                  </tr>
                  <tr>
                     <td> 
						 Media Showcases
						<!-- Media Showcase  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Media Showcase </h4>
							   <h5 class="fs16 pt24 font_weight">Promote and sell your Media. </h5>
							   <p class="fs14">Present your Films & Videos, Music & Audio Files, Photography & Art Writing and Educational Material to create a fantastic online portfolio.</p>
							   <p class="fs14">You can grow your fan base, get feedback on your work through reviews, craves and ratings, while earning some cash, just by putting your media up on your Showcase. Toadsquare was built to make doing this trouble-free.</p>
							</div>
                        <!-- Media Showcase popup end-->
                     </td>
                     <td>
                        <p>3 FREE then<br />
                           &euro; 10 per extra Media Showcase p.a.
                        </p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  
                  <tr>
                     <td> 
						 Upcoming Media Showcases
						<!-- Media Showcase  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Upcoming Media Showcases </h4>
							   <h5 class="fs16 pt24 font_weight">Create gossip about the media you are developing. </h5>
							   <p class="fs14">Use this section to give out enticing snippets of the media you are developing and build anticipation amongst your fans? It's the start of your online PR campaign.</p>
							   <p class="fs14">As your work progresses, update your Showcase, keeping your fans engaged.</p>
							</div>
                        <!-- Media Showcase popup end-->
                     </td>
                    
                     
                     <td>
                        <p> 12-month trial, then <br />
                          &euro; 8 per Upcoming Media Showcase p.a.
                        </p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  
                  <tr>
                     <td>
                         Shopping Cart 
                        <!-- shoping cart popup start-->
                        <div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
                            <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
                           <h4 class="fs21 red bb_F1592A">Shopping Cart</h4>
                           <h5 class="fs16 pt24 font_weight">We modestly claim to have built a brilliant cart for our members. </h5>
                           <p class="fs14">Our cart allows members to sell digital and physical products across the globe.</p>
                           <p class="fs14">It provides a simple, smooth buying experience.</p>
                           <p class="fs14 ">Sales are in Euros or US dollars. </p>
                        </div>
                         <!-- shoping cart popup end-->
                     </td>
                     <td>
                        <p><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /><br />
                           <span class="fifper">15 % commission charged on sales</span>
                        </p>
                     </td>
                     <td><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /><br />
                        <span class="fifper">15 % commission charged on sales</span>
                     </td>
                  </tr>
                  <tr>
                     <td> Blog
						<!-- Blog popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Blog </h4>
							   <h5 class="fs16 pt24 font_weight">Get your Name out there. </h5>
							   <p class="fs14">Share your ideas about everything, anything and the creative industries.</p>
							</div>
                        <!-- Blog popup end-->
                     </td>
                     <td>
                        <p><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></p>
                     </td>
                     <td><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></td>
                  </tr>
                  <tr>
                     <td> News Collection 
                     
						<!-- New Collection popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">News Collection  </h4>
							   <h5 class="fs16 pt24 font_weight">Make your opinion count in the creative world. </h5>
							   <p class="fs14">Make the news about the creative industries.</p>
							</div>
						<!-- New Collection popup end-->
                     
                     </td>
                     <td>
                        <p><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></p>
                     </td>
                     <td><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></td>
                  </tr>
                  <tr>
                     <td> 
						 Reviews Collection 
						<!-- Reviews Collection popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
								<h4 class="fs21 red bb_F1592A">Reviews Collection  </h4>
								<h5 class="fs16 pt24 font_weight">Let your inner critic out!</h5>
								<p class="fs14">You’ll feel better for expressing your opinion, and you’ll help people improve their work. A tidal wave of creativity can be unleashed from the smallest of suggestions.</p>
								<p class="fs14">Review media and events from Toadsquare and elsewhere.</p>
							</div>
						<!-- Reviews Collection popup end-->
                     
                     </td>
                     <td>
                        <p><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></p>
                     </td>
                     <td><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></td>
                  </tr>
                  <tr>
                     <td> Event Notices
                     
                     	<!-- Event Notices popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
								<h4 class="fs21 red bb_F1592A">Event Notices </h4>
								<h5 class="fs16 pt24 font_weight">The More the Merrier!</h5>
								<p class="fs14">Be part of creating the buzz on the street. Tell people about an event near you and have more fun in a bigger crowd.</p>
							</div>
						<!-- Event Notices popup end-->
                     
                     </td>
                     <td>
                        <p>Unlimited</p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  <tr>
                     <td> Events
                     
                        <!-- Events popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Events</h4>
							   <h5 class="fs16 pt24 font_weight">Grow your Audiences and Sell Tickets.</h5>
							   <p class="fs14">Showcase your event online and sell tickets for up to 20 sessions. If you’re feeling generous, offer free tickets and early bird discounts. </p>
							   <p class="fs14">We do the administration: streamline your payments, send out tickets and provide you with a list of who’s coming. </p>
							   <p class="fs14">Members who buy tickets through us will have a great time connecting with each other at your event using our Meeting Point App. </p>
							</div>
						<!-- Events popup end-->
                     
                     </td>
                     <td>
                        <p>12-month trial, then<br />
                           &euro; 12 per Event per annum
                        </p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  <tr>
                     <td> Launches
						
						<!-- Launches popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Launches</h4>
							   <h5 class="fs16 pt24 font_weight">Launch with a Bang and Sell Tickets.</h5>
							   <p class="fs14">Tell everyone about your launch and promote it with free tickets and early bird discounts.  </p>
							   <p class="fs14 ">We do the administration: streamline your payments, send out tickets and provide you with a list of who’s coming. </p>
							   <p class="fs14 ">Members who buy tickets through us will have a great time as they connect with each other at your event using our Meeting Point App.  </p>
							</div>
						<!-- Launches popup end-->
                     
                      </td>
                     <td>
                        <p>12-month trial, then<br />
                           &euro; 8 per Launch p.a. 
                        </p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  <tr>
                     <td> Events with a Launch
                     
                     	<!-- Event with Launch  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Events with a Launch</h4>
							   <h5 class="fs16 pt24 font_weight pb4">Link your Launch Showcase to your Event Showcase.</h5>
							</div>
						<!-- Event with Launch  popup end-->

                     </td>
                     <td>
                        <p>&euro; 16 per Event with Launch p.a. 
                        </p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  <tr>
                     <td> Meeting Point App.
                     
                     	<!-- Meeting Point App. popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Meeting Point App.</h4>
							   <h5 class="fs16 pt24 font_weight">Want to go to an Event, but scared you’ll be a solitary wallflower? </h5>
							   <p class="fs14">Register for an event or buy tickets through Toadsquare and you can use our Meeting Point App to meet other members at the event.  </p>
							   <p class="fs14 ">Sign in to see who's going, then check in when you arrive, and set your status to let other members find you </p>
							
							</div>
						<!-- Meeting Point App. popup end-->
                     
                      </td>
                     <td>
                        <p><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></p>
                     </td>
                     <td><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></td>
                  </tr>
                  <tr>
                     <td>
                        Upcoming Events 
                        
                        <!--Upcoming Events  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Upcoming Events </h4>
							   <h5 class="fs16 pt24 font_weight">Create gossip about your upcoming events. </h5>
							   <p class="fs14">Use this section to introduce your upcoming event and build anticipation amongst your fans? It's the start of your online PR campaign.</p>
							   <p class="fs14 ">As your work progresses, update your Showcase, keeping your fans engaged.</p>
							
							</div>
						<!--Upcoming Events popup end-->
                        
                     </td>
                     <td>
                        <p>12-month trial,  then<br />
                           &euro;8 per Upcoming Event p.a.
                        </p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  <tr>
                     <td> Work Profile & Work Profile App.
                     
                        <!--Work Profile & Work Profile App.  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Work Profile & Work Profile App. </h4>
							   <h5 class="fs16 pt24 font_weight">Your Work Profile is your multimedia CV. </h5>
							   <p class="fs14">Setup your Work Profile then send a link to it to potential colleagues and employers. They can then privately access your videos, audio files and writings, as well as print out your CV. </p>
							   <p class="fs14 ">You can sync your Work Profile with any tablet or smart phone using our Work Profile App. Your multimedia CV is in your pocket ready to show at any time.</p>
							
							</div>
						<!--Work Profile & Work Profile App. popup end-->
                     
                     </td>
                     <td>
                        <p>12-month trial,  then<br />
                           &euro;10 p.a.
                        </p>
                     </td>
                     <td><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></td>
                  </tr>
                  <tr>
                     <td>
						Work Classifieds
						
						<!--Work Classifieds  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Work Classifieds </h4>
							   <h5 class="fs16 pt24 font_weight">Find work or colleagues. </h5>
							   <p class="fs14">Put up a work classified telling people that you are ready to work or put up a classified telling people that you need someone to work with.  Need someone NOW? Put up an Urgent-Work-Offered Classified.</p>
							   <p class="fs14 ">Once you have started your search we help you manage it by tracking the applications you send and receive.  </p>
							   <p class="fs14 ">Make a bigger impact by linking to your multimedia Work Profile to your applications.  </p>
						
							</div>
						<!--Work Classifieds popup end-->
                     
                     </td>
                     <td>
                        <p>2 X 6-month trials, then <br>
                           &euro; 4 per Classified per 6 months
                        </p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  <tr>
                     <td> Collaborations 
						
						<!--Collaborations  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Collaborations </h4>
							   <h5 class="fs16 pt24 font_weight">Reduce your work stress.</h5>
							   <p class="fs14">Working remotely? Our private, online Collaborations give you a central communications and management hub for each of your creative projects? </p>
							</div>
						<!--Collaborations popup end-->
                     
                     </td>
                     <td>
                        <p>&euro; 25 per Collaboration p.a.</p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  <tr>
                     <td> Favourite Sites 
                     
                     
						<!--Favorite Sites  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Favorite Sites  </h4>
							   <h5 class="fs16 pt24 font_weight">Find a brilliant site & share it with others in the Creative Industries!</h5>
							</div>
						<!--Favorite Sites  popup end-->
                     
                     </td>
                     <td>
                        <p>Unlimited</p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  <tr>
                     <td> Product Classifieds
						
						<!--Product Classifides  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Product Classifieds </h4>
							   <h5 class="fs16 pt24 font_weight">Sell and find products used in the creative industries. </h5>
							   <p class="fs14">Advertise your Products For Sale or let people know how much you’re willing to pay for that niche product you can’t find anywhere else with a Product-Wanted Classified.</p>
							</div>
						<!--Product Classifides popup end-->
                     
                      </td>
                     <td>
                        <p>2 X 6 month trials, then<br />
                           &euro; 2 per Classified per 6 months
                        </p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  <tr>
                     <td> Competition Entries
                     
                     	<!--Competitions Entries  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Competition Entries</h4>
							   <h5 class="fs16 pt24 font_weight">Keep a look out. You never know what you might win. </h5>
							</div>
						<!--Competitions Entries popup end-->
                     
                     </td>
                     <td>
                        <p>Unlimited</p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  <tr>
                     <td> Competitions 
                     
                     	<!--Competitions  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Competitions </h4>
							   <h5 class="fs16 pt24 font_weight">Find the best! </h5>
							   <p class="fs14">Looking for the best creative work or person? Feel like giving something back to the creative community?  </p>
							   <p class="fs14">Run a competition.   </p>
							   <p class="fs14 ">As a bonus, this will get your name out to others in the creative community.   </p>
							</div>
						<!--Competitions popup end-->
                     
                     </td>
                     <td>
                        <p>&euro; 25 per Competition p.a.</p>
                     </td>
                     <td>Unlimited</td>
                  </tr>
                  <tr>
                     <td> Ad Campaigns 
						
						<!--Ad Campaigns   popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Ad Campaigns  </h4>
							   <h5 class="fs16 pt24 font_weight">Straightforward online advertising. </h5>
							   <p class="fs14">Advertise to your peers on Toadsquare. We help you design your ads and then serve them on Toadsquare to an audience interested in creative pursuits. </p>
							</div>
						<!--Ad Campaigns  popup end-->
                     
                     </td>
                     <td>
                        <p>&euro; 4 per Campaign (1000 impressions)</p>
                     </td>
                     <td>
                         <p class="lineH18">5 Campaigns p.a.<br />
                        (5000 impressions) then <br />
                        € 4 per Campaign (1000 impressions)</p>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        Storage Space 
                        
                       	<!--Storage Space  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Storage Space  </h4>
							   <h5 class="fs16 pt24 font_weight">Only buy extra storage space if you need it. </h5>
							   <p class="fs14">Extra Space will expire with the section of your Showcase or your Membership. </p>
							</div>
						<!--Storage Space  popup end-->
                        
                     </td>
                     <td>
                        <p>Each Section has 100 MB then<br />
                           &euro; 0.80 per extra 100 MB per Section
                        </p>
                     </td>
                     <td><span class="fs23">50 GB,</span>  then
                        &euro; 50.00<br />
                        per extra 10 GB per membership
                     </td>
                  </tr>
                  <tr>
                     <td> Online PR Management
						
						<!--Online PR Management  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Online PR Management  </h4>
							   <h5 class="fs16 pt24 font_weight">Know you should do more online PR? </h5>
							   <p class="fs14">But, who has the time? Toadsquare makes it easy.  </p>
							   <p class="fs14 ">Make your Showcase your social-media centre and manage all your online PR form Toadsquare.</p>
							</div>
						<!--Online PR Management  popup end-->
                     
                      </td>
                     <td>
                        <p><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></p>
                     </td>
                     <td><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" />
                     </td>
                  </tr>
                  <tr>
                     <td> Forum 
						<!--Forum  popup start-->
							<div class="member_popup pl36 pt17 pb28 pr30 width_307 text_alighL position_absolute">
							    <span class="pop_arrow arrw fl position_absolute"><img src="<?php echo $imgPath; ?>/arrow_left.png" alt="" /></span>
							   <h4 class="fs21 red bb_F1592A">Forum  </h4>
							   <h5 class="fs16 pt24 font_weight">Rediscover your love of debate.</h5>
							   <p class="fs14">Do your friends' eyes glaze over when you discuss your passion for creative pursuits?   </p>
							   <p class="fs14 ">Come to Toadsquare’s forum to find people who are as passionate as you.</p>
							</div>
						<!--Forum  popup end-->
                     
                     </td>
                     <td>
                        <p><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" /></p>
                     </td>
                     <td><img src='<?php echo $imgPath; ?>/arraow_12.png' alt="" />
                     </td>
                  </tr>
               </table>
               <ul class="btn_wrap fr">
                  <li>
                     <?php echo form_button($joinFreeButton ); ?>
                  </li>
                  <li>
                    <?php
                        $buttonData['buttonPositionClass'] 	= 'pt20';
                        $this->load->view('common_view/package_upgrade_button',$buttonData);
                    ?>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>

<!--membership information page end-->

<?php echo form_input($selectedPacakge); ?>
<?php echo form_close(); ?> 

<script type="text/javascript">
    //call stage switch method
    packageStageSwitch('packageStage1',"/package/packagestageonepost");
  
    //membership popup hover position set daynamic according to content
    $('.membership_info table tr td:first-child').hover(function () {
        var popheight = $(this).children(".member_popup").height()/2;
        $('.pop_arrow').css('top',popheight-20);
        $('.member_popup').css('margin-top',-popheight-25);
    });
</script>
