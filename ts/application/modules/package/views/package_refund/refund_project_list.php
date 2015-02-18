<?php
  
  $divCounter = 1;
  
  //-----------------------filmNvideo------------------------//
  if(search_multi_array("filmNvideo", $mediaprojectlist)){
    $filmNvideoData['projectDataList']  =  $mediaprojectlist;
    $filmNvideoData['sectionname']      =  'filmNvideo';
    $filmNvideoData['divCounter']       =  $divCounter;
    $filmNvideoData['elementEntityId']  =  12; 
    $this->load->view('package_refund/refund_film_n_video',$filmNvideoData);
    $divCounter++;
  }
  
  //-----------------------musicNaudio------------------------//
  if(search_multi_array("musicNaudio", $mediaprojectlist)){
    $musicNaudioData['projectDataList']  =  $mediaprojectlist;
    $musicNaudioData['sectionname']      =  'musicNaudio';
    $musicNaudioData['divCounter']       =  $divCounter;
	$musicNaudioData['elementEntityId']  =  25; 
    $this->load->view('package_refund/refund_music_n_audio',$musicNaudioData);
    $divCounter++;
  }
  
  //-----------------------writing & publishing (news/review)------------------------//
  if(search_multi_array("news", $mediaprojectlist) || search_multi_array("reviews", $mediaprojectlist)){
    $writtingNPublishingData['projectDataList']   =  $mediaprojectlist;
    $writtingNPublishingData['sectionname1']      =  'reviews';
    $writtingNPublishingData['sectionname2']      =  'news';
    $writtingNPublishingData['sectionname3']      =  'writingNpublishing';
    $writtingNPublishingData['divCounter']        =  $divCounter;
    $writtingNPublishingData['elementEntityId']   =  84; 
    $this->load->view('package_refund/refund_writing_n_publishing',$writtingNPublishingData);
    $divCounter++;
  }
   
  //-----------------------photographyNart------------------------//
  if(search_multi_array("photographyNart", $mediaprojectlist)){
    $photographyNartData['projectDataList']  =  $mediaprojectlist;
    $photographyNartData['sectionname']      =  'photographyNart';
    $photographyNartData['divCounter']       =  $divCounter;
    $photographyNartData['elementEntityId']  =  47; 
    $this->load->view('package_refund/refund_photography_n_art',$photographyNartData);
    $divCounter++;
  }
  
   //-----------------------educationMaterial------------------------//
  if(search_multi_array("educationMaterial", $mediaprojectlist)){
    $educationMaterialData['projectDataList']  =  $mediaprojectlist;
    $educationMaterialData['sectionname']      =  'educationMaterial';
    $educationMaterialData['divCounter']       =  $divCounter;
    $educationMaterialData['elementEntityId']  =  7; 
    $this->load->view('package_refund/refund_education_material',$educationMaterialData);
    $divCounter++;
  }
  
  //-----------------------eventShowcase------------------------//
  if(search_multi_array("Event Showcases", $eventlaunchproject) && search_multi_array("{9:2}", $eventlaunchproject)){
    
    $eventLaunchData['projectDataList']  =  $eventlaunchproject;
    $eventLaunchData['sectionname']      =  'Event Showcases'; // event showcase
    $eventLaunchData['divCounter']       =  $divCounter;
    $this->load->view('package_refund/refund_event_showcase',$eventLaunchData);
    $divCounter++;
  }
  
  //-----------------------launch------------------------//
  if(search_multi_array("Launch Showcases", $eventlaunchproject) && search_multi_array("{9:3}", $eventlaunchproject)){
    
    $eventLaunchData['projectDataList']  =  $eventlaunchproject;
    $eventLaunchData['sectionname']      =  'Launch Showcases'; // launch
    $eventLaunchData['divCounter']       =  $divCounter;
    $this->load->view('package_refund/refund_launch',$eventLaunchData);
    $divCounter++;
  }
  
   //-----------------------launch with event------------------------//
  if(search_multi_array("Events with Launch Showcases", $eventlaunchproject) && search_multi_array("{9:4}", $eventlaunchproject)){
    
    $eventLaunchData['projectDataList']  =  $eventlaunchproject;
    $eventLaunchData['sectionname']      =  'Events with Launch Showcases'; // Events with Launch 
    $eventLaunchData['divCounter']       =  $divCounter;
    $this->load->view('package_refund/refund_launch_with_events',$eventLaunchData);
    $divCounter++;
  }
  
   //-----------------------Ad Campaigns--------------------------------//
  if(search_multi_array("Ad Campaigns", $addcampaignprojectlist) && search_multi_array("{24}", $addcampaignprojectlist)){
    
    $addCampaignData['projectDataList']  =  $addcampaignprojectlist;
    $addCampaignData['sectionname']      =  'Ad Campaigns'; // adverts campaign project list
    $addCampaignData['divCounter']       =  $divCounter;
    $this->load->view('package_refund/refund_add_campaign',$addCampaignData);
    $divCounter++;
  }
  
  //-----------------------Competition--------------------------------//
  if(search_multi_array("Competition", $competitionprojectlist) && search_multi_array("{16}", $competitionprojectlist)){
    $competitionData['projectDataList']  =  $competitionprojectlist;
    $competitionData['sectionname']      =  'Competition'; // Competition project list
    $competitionData['divCounter']       =  $divCounter;
    $this->load->view('package_refund/refund_competition',$competitionData);
    $divCounter++;
  }
  
  
  //-----------------------Collaborations--------------------------------//
  if(search_multi_array("Collaborations", $collaborationprojectlist) && search_multi_array("{15}", $collaborationprojectlist)){
    $collaborationsData['projectDataList']  =  $collaborationprojectlist;
    $collaborationsData['sectionname']      =  'Collaborations'; // Collaborations project list
    $collaborationsData['divCounter']       =  $divCounter;
    $this->load->view('package_refund/refund_collaboration',$collaborationsData);
    $divCounter++;
  }
  
  //-----------------------Product Classifides--------------------------------//
  if(search_multi_array("Product Classifides", $productprojectlist) && (search_multi_array("{12:1}", $productprojectlist) || search_multi_array("{12:2}", $productprojectlist))){
    $productData['projectDataList']  =  $productprojectlist;
    $productData['sectionname']      =  'Product Classifides'; // Product Classifides project list
    $productData['divCounter']       =  $divCounter;
    $this->load->view('package_refund/refund_product_classifides',$productData);
    $divCounter++;
  }
  
  //-----------------------Upcoming--------------------------------//
  if(search_multi_array("Upcoming Media or Events", $upcommingprojectlist) && search_multi_array("{17}", $upcommingprojectlist)){
    $upcommingData['projectDataList']  =  $upcommingprojectlist;
    $upcommingData['sectionname']      =  'Upcoming Media or Events'; // Upcoming project list
    $upcommingData['divCounter']       =  $divCounter;
    $this->load->view('package_refund/refund_upcomming_media',$upcommingData);
    $divCounter++;
  }
  
  //-----------------------Work Profile--------------------------------//
  if(search_multi_array("Work Profile & Work Profile App", $workprofileprojectlist) && search_multi_array("{14}", $workprofileprojectlist)){
    $workProfileData['projectDataList']  =  $workprofileprojectlist;
    $workProfileData['sectionname']      =  'Work Profile & Work Profile App'; // Work Profile project list
    $workProfileData['divCounter']       =  $divCounter;
    $this->load->view('package_refund/refund_workprofile',$workProfileData);
    $divCounter++;
  }
  
?>
<script type="text/javascript">
  
  var currentcounter = 1; //defined default value
  var nextcounter    = 2; //defined default value
  var backcounter    = 0; //defined default value
  var totaldivcounter = parseInt("<?php echo $divCounter; ?>"); // convert string into number
  $( document ).ready(function() {
    
    // next functionality
    $('.next_container').click(function(){
       
        // if next and total equal
        if(totaldivcounter ==nextcounter){
          $('#refundStage1').submit();
          return false;
        }
        
        $("#divCounter"+currentcounter).hide();
        $("#divCounter"+nextcounter).show();
        
        //for next
        if(nextcounter < totaldivcounter){
          currentcounter = nextcounter;
          nextcounter    = nextcounter + 1;
        }
        
        return false;
    });
    
    // back functionality
    $('.back_container').click(function(){
       
        backcounter = currentcounter;
        
        // if backcounter is 1 means first page
        if(backcounter==1){
          return false; 
        }else{
          backcounter  = backcounter -1;
        }
        
        $("#divCounter"+currentcounter).hide();
        $("#divCounter"+backcounter).show();

        //assign current page couner
        currentcounter = backcounter;
        nextcounter    = backcounter +1;
    });
    
  });
</script> 
