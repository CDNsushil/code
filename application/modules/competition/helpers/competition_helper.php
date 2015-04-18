<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	
	/*
	 ****************************************
	 * This function is used to get class by industry id
	 **************************************** 
	 */  
	  
	if ( ! function_exists('getIndustryClass')){	
		  
	function getIndustryClass($industryId=0){
			
			//$industryId = 4;
			switch($industryId){
			  
				case 1:
					// Film & Video
					$industryClass['2pxborderClass'] = 'bdr2_FilmNVideo_Indus';
					$industryClass['4pxborderClass'] = 'bdr4_FilmNVideo_Indus';
					$industryClass['6pxborderClass'] = 'bdr6_FilmNVideo_Indus';
					$industryClass['8pxborderClass'] = 'bdr8_FilmNVideo_Indus';
					$industryClass['10pxborderClass'] = 'bdr10_FilmNVideo_Indus';
					$industryClass['10pxborderClass_1'] = 'bdr10_FilmNVideo_Indus_1';
					$industryClass['commonBigButton'] = 'tds-button_compenter';
					$industryClass['sortButton'] = 'comp_black';
					$industryClass['bigButton'] = 'button_big_black';
					$industryClass['mediumButton'] = 'button_medium_black';
					
					$industryClass['industryBG'] = 'bg_FilmNVideo_Indus';
					$industryClass['industryFntClr'] = 'langFontColor_FilmNVideo_Indus';
					$industryClass['langTabCls'] = 'languagebg_second';
					$industryClass['fontColorClass'] = 'clr_white';
					$industryClass['showHeading'] = 'Film & Video';
					$industryClass['industryId'] = '1';
				break;  
				case 2:
					// Music & Audio
					$industryClass['2pxborderClass'] = 'bdr2_musicNaudio_Indus';
					$industryClass['4pxborderClass'] = 'bdr4_musicNaudio_Indus';
					$industryClass['6pxborderClass'] = 'bdr6_musicNaudio_Indus';
					$industryClass['8pxborderClass'] = 'bdr8_musicNaudio_Indus';
					$industryClass['10pxborderClass'] = 'bdr10_musicNaudio_Indus';
					$industryClass['10pxborderClass_1'] = 'bdr10_musicNaudio_Indus_1';
					$industryClass['commonBigButton'] = 'tds-button_compenter';
					$industryClass['sortButton'] = 'comp_blue';
					$industryClass['bigButton'] = 'button_big_blue';
					$industryClass['mediumButton'] = 'button_medium_grey';
					
					$industryClass['industryBG'] = 'bg_musicNaudio_Indus';
					$industryClass['industryFntClr'] = 'langFontColor_musicNaudio_Indus';
					$industryClass['langTabCls'] = 'languagebg';
					$industryClass['fontColorClass'] = 'clr_70aaff';
					$industryClass['showHeading'] = 'Music & Audio';
					$industryClass['industryId'] = '2';
				break; 
				case 3:
					// Writting & Publishing
					$industryClass['2pxborderClass'] = 'bdr2_writtingNPubli_Indus';
					$industryClass['4pxborderClass'] = 'bdr4_writtingNPubli_Indus';
					$industryClass['6pxborderClass'] = 'bdr6_writtingNPubli_Indus';
					$industryClass['8pxborderClass'] = 'bdr8_writtingNPubli_Indus';
					$industryClass['10pxborderClass'] = 'bdr10_writtingNPubli_Indus';
					$industryClass['10pxborderClass_1'] = 'bdr10_writtingNPubli_Indus_1';
					$industryClass['commonBigButton'] = 'tds-button_compenter';
					$industryClass['sortButton'] = 'comp_brown';
					$industryClass['bigButton'] = 'button_big_brown';
					$industryClass['mediumButton'] = 'button_medium_brown';
					
					$industryClass['industryBG'] = 'bg_writtingNPubli_Indus';
					$industryClass['industryFntClr'] = 'langFontColor_writtingNPubli_Indus';
					$industryClass['langTabCls'] = 'languagebg_second';
					$industryClass['fontColorClass'] = 'font_writtingNPubli_Indus';
					$industryClass['showHeading'] = 'Writing & Publishing';
					$industryClass['industryId'] = '3';
				break;  
				case 4:
					//  Photography Art
					$industryClass['2pxborderClass'] = 'bdr2_photographynart_Indus';
					$industryClass['4pxborderClass'] = 'bdr4_photographynart_Indus';
					$industryClass['6pxborderClass'] = 'bdr6_photographynart_Indus';
					$industryClass['8pxborderClass'] = 'bdr8_photographynart_Indus';
					$industryClass['10pxborderClass'] = 'bdr10_photographynart_Indus';
					$industryClass['10pxborderClass_1'] = 'bdr10_photographynart_Indus_1';
					$industryClass['commonBigButton'] = 'tds-button_compenter';
					$industryClass['sortButton'] = 'comp_green';
					$industryClass['bigButton'] = 'button_big_green';
					$industryClass['mediumButton'] = 'button_medium_green';
					
					$industryClass['industryBG'] = 'bg_photographynart_Indus';
					$industryClass['industryFntClr'] = 'langFontColor_photographynart_Indus';
					$industryClass['langTabCls'] = 'languagebg';
					$industryClass['fontColorClass'] = 'font_photographynart_Indus';
					$industryClass['showHeading'] = 'Photography & Art';
					$industryClass['industryId'] = '4';
				break; 
				case 5:
					//  Performing Art
					$industryClass['2pxborderClass'] = '';
					$industryClass['4pxborderClass'] = '';
					$industryClass['6pxborderClass'] = '';
					$industryClass['8pxborderClass'] = '';
					$industryClass['10pxborderClass'] = '';
					$industryClass['10pxborderClass_1'] = '';
					$industryClass['commonBigButton'] = 'tds-button_compenter';
					$industryClass['sortButton'] = '';
					$industryClass['bigButton'] = '';
					$industryClass['mediumButton'] = '';
					
					$industryClass['industryBG'] = '';
					$industryClass['industryFntClr'] = '';
					$industryClass['fontColorClass'] = '';
					$industryClass['langTabCls'] = '';
					$industryClass['showHeading'] = 'Performing Arts';
					$industryClass['industryId'] = '5';
				break; 
				default:
					$industryClass['2pxborderClass'] = '';
					$industryClass['4pxborderClass'] = '';
					$industryClass['6pxborderClass'] = '';
					$industryClass['8pxborderClass'] = '';
					$industryClass['10pxborderClass'] = '';
					$industryClass['10pxborderClass_1'] = '';
					$industryClass['commonBigButton'] = '';
					$industryClass['sortButton'] = '';
					$industryClass['bigButton'] = '';
					$industryClass['mediumButton'] = '';
					$industryClass['industryBG'] = '';
					$industryClass['industryFntClr'] = '';
					$industryClass['langTabCls'] = '';
					$industryClass['fontColorClass'] = '';
					$industryClass['showHeading'] = '';
					$industryClass['industryId'] = '';
				break; 
			}
			
			return $industryClass;
				
		}
	}
	
	/*
	 * @ access: public
	 * @ Details: This functino is use to get current competition round 
	 * @ parameter: competitionId
	 * @ return: current competition round type  
	 */
	
	
	function competitionRound($competitionId){
		
		
		$CI = & get_instance(); // create instance
		
		$whereCondition = array('competitionId' => $competitionId);	
		$competitionDetail  = $CI->model_common->getDataFromTabel($table='Competition', 'competitionRoundType,votingStartDate,votingEndDate,votingStartDateRound2,votingEndDateRound2',  $whereCondition, '', '', '', $limit=1, $offset=0, $resultInArray=false);
		$competitionDetail = $competitionDetail[0];
		
		// set value in the variable
		$currentDate = strtotime(date("Y-m-d"));
		$votingStartDate = strtotime($competitionDetail->votingStartDate);
		$votingEndDate = strtotime($competitionDetail->votingEndDate);
		$competitionRoundType = $competitionDetail->competitionRoundType;
		$onGoingRound = 1;
		
		// check is it type 2 
		if($competitionRoundType==2){
			if($votingEndDate <= $currentDate){
				$votingStartDate = strtotime($competitionDetail->votingStartDateRound2);
				$votingEndDate = strtotime($competitionDetail->votingEndDateRound2);
				$onGoingRound = 2;
			}
		}
		
		return $onGoingRound; 	// return current ongoging round type
		
	}
	  
	  
