<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    //------checked element and get current open element data------//
    $elementData         =   false;
    if(!empty($elementDataList)):
        foreach($elementDataList as $key => $getElementData){
            //check element id and set data
            if($getElementData['elementId']==$elementId){
                $elementData        =  $getElementData;
            }
        }
    endif;
    
    //get media type of educational meterial
    $mediaFileType                =    (!empty($elementData['mediaFileType']))?$elementData['mediaFileType']:'0';  
    
    switch($mediaFileType){
        case "2":
            //video
            $this->load->view('education_video_element_details');
        break;
        
        case "3":
            //audio
            $this->load->view('education_audio_element_details');
        break;
        
        case "4":
            //doc
            $this->load->view('education_doc_element_details');
        break;
        
        default:
        redirectToNorecord404();
    }
?>
