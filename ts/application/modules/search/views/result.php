<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	 $thumbFolder ='thumb';
	 $searchResultCount=count($searchResult);
		if($items_total >  $items_per_page){?>
			 <div class="row pt15 pl15 pr16">
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links_withoutButton,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/search/searchresult/0/result'),"divId"=>"searchResultDiv","formId"=>"advanceSearchForm","unqueId"=>"wn","isShowNumber"=>true,"isShowDD"=>false,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design fr')); ?>
				<div class="clear"></div>
			</div>
			<?php
	  }?>
	 <div class="width_602 pt15 pb5 bg_light_gray"> 
		<?php
		if($searchResult && is_array($searchResult) && $searchResultCount > 0){ ?>
			
				<?php
				foreach($searchResult as $k=>$search){
					if(isset($searchResult[$k-1]) && (($searchResult[$k-1]->entityid==($searchResult[$k]->entityid)) && ($searchResult[$k-1]->elementid==($searchResult[$k]->elementid)) && ($searchResult[$k-1]->title==($searchResult[$k]->title))  ) ){
								continue;
					}
					$cacheFile = $search->cachefile;
					$elementid = $search->elementid;
					$projectid = $search->projectid;
					$entityid = $search->entityid;
					$section = $search->section;
					$imagetype=$this->config->item($section.'Image');
					$searchImage='';
					$length=$wordCount='';
					if(!empty($cacheFile) && is_file($cacheFile)){
						include($cacheFile);
						if(isset($ProjectData)){
							$fileData=json_decode($ProjectData, true);
						}
						
						if(isset($fileData) && $fileData && is_array($fileData) && count($fileData) > 0){
							if(isset($fileData['projects'][0])){
								$project=$fileData['projects'][0];
							}elseif(isset($fileData['projects'])){
								$project=$fileData['projects'];
							}elseif(isset($fileData[0])){
								$project=$fileData[0];
							}else{
								$project=$fileData;
							}
							if($elementid != $projectid && (isset($project['elements']))){
								foreach($project['elements'] as $projectkey=>$element){
									if($element['elementId']==$elementid){
										$project=$project['elements'][$projectkey];
										break;
									}
								}
								$length=isset($project['fileLength'])?$project['fileLength']:'';
								$wordCount=isset($project['wordCount'])?$project['wordCount']:'';
							}
							
							if(($search->section=='photographyNart' && ($elementid != $projectid)) || $search->section=='performancesevents' || $search->section=='notification' || $search->section=='work' || $search->section=='product' || $search->section=='blog' ||$search->section=='post' || $search->section=='upcoming'){
								$fileName=isset($project['fileName'])?trim($project['fileName']):'';
								$filePath=isset($project['filePath'])?trim($project['filePath']):'';
								$fpLen=strlen($filePath);
								if($fpLen > 0 && substr($filePath,-1) != '/'){
									$filePath=$filePath.'/';
								}
								
								$searchImage=$filePath.$fileName;
							}
							elseif($search->section=='event') {
								$fileName=isset($project['fileName'])?trim($project['fileName']):'';
								$filePath=isset($project['filePath'])?trim($project['filePath']):'';
								//----------make element default event image code start---------//
								$eventImage = $filePath.$fileName;
								if(!empty($eventImage) && file_exists($eventImage)) {
									$searchImage=$eventImage;
								} else {
									$getProjectImage = getEventsPrimaryImage($project['EventId'],'.eventId');
									if(!empty($getProjectImage) && file_exists($getProjectImage)){
										$searchImage = $getProjectImage;
									}else{
										$searchImage = $eventImage;				
									}
								}
							//	var_dump($searchImage);
								
								//----------make element default event image code start---------//
							}
							elseif($search->section=='launch') {
								$fileName=isset($project['fileName'])?trim($project['fileName']):'';
								$filePath=isset($project['filePath'])?trim($project['filePath']):'';
								//----------make element default launch image code start---------//
								$launchImage = $filePath.$fileName;
								if(!empty($launchImage) && file_exists($launchImage)) {
									$searchImage=$launchImage;
								} else {
									$getProjectImage = getEventsPrimaryImage($project['LaunchEventId'],'.launchEventId');
									if($getProjectImage){
										$searchImage = $getProjectImage;
									}else{
										$searchImage=$launchImage;				
									}
								}
								//----------make element default launch image code start---------//
							}
							elseif($search->section=='creatives' || $search->section=='associatedprofessionals'|| $search->section=='enterprises'){
									if($project['stockImgId'] > 0){
										$searchImage=$project['stockImgPath'].'/'.$project['stockFilename'];					
									}
									else{
										$profileImagePath  = 'media/'.$project['username'].'/profile_image/';
										$searchImage=$profileImagePath.$project['profileImageName'];	
									}
							}
							elseif(isset($project['projBaseImgPath']) && !empty($project['projBaseImgPath'])){
									$searchImage=trim($project['projBaseImgPath']);
							}elseif(isset($project['imagePath']) && !empty($project['imagePath'])){
									$searchImage=trim($project['imagePath']);
							}
							
						}
					}
					
					if($search->section=='product'){
						if($search->category=='freeStuff'){
							$imagetype=$this->config->item('defaultProductFree');
						}elseif($search->category=='sell'){
							$imagetype=$this->config->item('defaultProductForSale');
						}elseif($search->category=='wanted'){
							$imagetype=$this->config->item('defaultProductWanted');
						}else{
							$imagetype=$this->config->item('productImage');
						}
					}
					
					if($search->section=='work'){
						$imagetype=$this->config->item($section.$search->work_type.'Image');
					}
					
					$search->length=$length;
					$search->wordCount=$wordCount;
					$search->sell_option= ucfirst($search->sell_option);
					 
					$ratingAvg=roundRatingValue($search->ratingAvg);
					$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';
					$search->ratingImg=$ratingImg;
					$search->craveFClass=(isset($search->craveId) && $search->craveId > 0)?'cravedALL':'';
					
					$search->type=($search->section=='news' || $search->section=='reviews' || $search->section=='educationMaterial' || $search->section=='upcoming')?$search->industry:$search->type;
					
					$section=$search->section;
					
					if($search->section=='upcoming'){
						switch ($search->sectionid) {
							case 1:
								$section='filmNvideo';
								$imagetype=$this->config->item($section.'Image');
								break;
							case 2:
								$section='musicNaudio';
								$imagetype=$this->config->item($section.'Image');
								break;
							case 3:
								$section='writingNpublishing';
								$imagetype=$this->config->item($section.'Image');
								break;
							case 4:
								$section='photographyNart';
								$imagetype=$this->config->item($section.'Image');
								break;
							case 6:
								$section='creatives';
								$imagetype=$this->config->item($section.'Image');
								break;
							case 7:
								$section='associatedprofessionals';
								$imagetype=$this->config->item($section.'Image');
								break;
							case 8:
								$section='enterprises';
								$imagetype=$this->config->item($section.'Image');
								break;
							case 9:
								$section='performances&events';
								$imagetype=$this->config->item($section.'Image');
								break;
							case 10:
								$section='educationMaterial';
								$imagetype=$this->config->item($section.'Image');
								break;
							case 11:
								$section='work';
								if($search->category=='wanted'){
									$imagetype=$this->config->item('workwantedImage');
								}elseif($search->category=='offered'){
									$imagetype=$this->config->item('workofferedImage');
								}else{
									$imagetype=$this->config->item('workImage');
								}
								
								break;
							case 12:
								$section='Product';
								if($search->category=='freeStuff'){
									$imagetype=$this->config->item('defaultProductFree');
								}elseif($search->category=='sell'){
									$imagetype=$this->config->item('defaultProductForSale');
								}elseif($search->category=='wanted'){
									$imagetype=$this->config->item('defaultProductWanted');
								}else{
									$imagetype=$this->config->item($section.'Image');
								}
								break;
							case 13:
								$section='blog';
								$imagetype=$this->config->item($section.'Image');
								break;
							
						}
						
					}
					if(((isset($project['isExternalImageURL']) && $project['isExternalImageURL']=='t') || ((isset($project['isExternal']) && $project['isExternal']=='t')) && (isset($project['filePath']) && $search->section=='photographyNart')) ){
				
						$searchImage = checkExternalImage($project['filePath'],'xs');
				
					}else{
						$searchImage;
						
						
				/* For Promo Image not showing untill user saves after adding promo image */		
						if(is_file($searchImage)){							
							$searchImage=addThumbFolder($searchImage,$suffix='_s',$thumbFolder,$imagetype);
						    $searchImage=getImage($searchImage,$imagetype);					
							}else { 
								  /*
								   *  not section define in old code section add by Lokendra (5-Aug-2013) 
								   *  $searchImage = getProjectImage($entityid,$elementid,$projectid,'');	
								   */ 
								 //echo $entityid.'=='.$elementid.'=='.$projectid.'=='.$section;
								if($section == 'photographyNart'){
									
									$getElementEntityid =  getMasterTableRecord('PaElement');
									$getPojrectImage = getProjectElementImage($projectid,$getElementEntityid);	
									
										if(is_array($getPojrectImage)){
											if($getPojrectImage['isExternal']=="t"){
												$searchImage = checkExternalImage($getPojrectImage['filePath'],'_s');
											}
										}else{
											if($getPojrectImage){
												$searchImage = $getPojrectImage;
											}else{
												$searchImage = addThumbFolder($LID->projBaseImgPath,'_s',$imagetype);				
											}
											$searchImage = getImage($searchImage,$imagetype,1);
										}
								}else{	
									 $searchImage = getProjectImage($entityid,$elementid,$projectid,$section);
									 if($searchImage==''){
										 $searchImage=getImage($searchImage,$imagetype);				
									}
								}
							
							}
					  }
					 
					
					
					$search->searchImage=$searchImage;		
					
					switch ($section) {
						case 'filmNvideo':
							$searchBgClass='bg_SRFilm';
							$search->industry='';
							$search->sell_option='';
							$search->wordCount='';
							$search->city='';
							$search->event_end_date='';
							$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
							$search->link=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'filmvideo'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'filmvideo');
							break;
						case 'musicNaudio':
							$searchBgClass='bg_SRMusic';
							$search->industry='';
							$search->sell_option='';
							$search->city='';
							$search->wordCount='';
							$search->event_end_date='';
							$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
							$search->link=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'musicaudio'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'musicaudio');
							break;
						case 'photographyNart':
							$searchBgClass='bg_SRArt';
							$search->industry='';
							$search->sell_option='';
							$search->wordCount='';
							$search->city='';
							$search->language='';
							$search->event_end_date='';
							$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
							$search->link=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'photographyart'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'photographyart');
							break;
						case 'writingNpublishing':
							$searchBgClass='bg_SRWriting';
							$search->industry='';
							$search->sell_option='';
							$search->city='';
							$search->length='';
							$search->event_end_date='';
							$search->wordCount= ($search->wordCount > 0) ? $this->lang->line('words').' '.$search->wordCount:'';
							$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
							$search->link=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'writingpublishing'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'writingpublishing');
							break;
						case 'educationMaterial':
							$searchBgClass='bg_SREducational';
							$search->industry='';
							$search->sell_option='';
							$search->city='';
							$search->wordCount='';
							$search->length='';
							$search->event_end_date='';
							$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
							$search->link=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'educationmaterial'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'educationmaterial');
							break;
						case 'performances&events':
							$searchBgClass='bg_SREvent';
							$search->industry='';
							$search->sell_option='';
							$search->wordCount='';
							$search->length='';
							$search->creation_date=$search->event_start_date;
							$linkId=$search->userid.'/'.$search->projectid;
							$search->link=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
							break;
						case 'event':
							$searchBgClass='bg_SREvent';
							$search->industry='';
							$search->sell_option='';
							$search->wordCount='';
							$search->length='';
							
							$search->creation_date=$search->event_start_date;
							$linkId=$search->userid.'/'.$search->projectid;
							$search->link=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
							break;
						case 'launch':
							$searchBgClass='bg_SREvent';
							$search->industry='';
							$search->sell_option='';
							$search->wordCount='';
							$search->length='';
							$search->creation_date=$search->event_start_date;
							$linkId=$search->userid.'/'.$search->projectid;
							$search->link=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
							break;
						case 'notification':
							$searchBgClass='bg_SREvent';
							$search->industry='';
							$search->sell_option='';
							$search->wordCount='';
							$search->length='';
							$search->creation_date=$search->event_start_date;
							$linkId=$search->userid.'/'.$search->projectid;
							$search->link=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
							break;
						case 'product':
							$searchBgClass='bg_SRProduct';
							$search->industry='';
							$search->genre='';
							$search->wordCount='';
							$search->language='';
							$search->length='';
							$search->event_end_date='';
							$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
							$search->link=base_url(lang().'/productshowcase/viewproject/'.$linkId);
							break;
						case 'blog':
							$searchBgClass='bg_SRBlogs';
							$search->industry='';
							$search->sell_option='';
							$search->wordCount='';
							$search->city='';
							$search->length='';
							$search->event_end_date='';
							$linkId=($search->elementid == $search->projectid)?'frontblog/'.$search->userid.'/'.$search->projectid.'/':'frontpost/'.$search->userid.'/'.$search->elementid.'/';
							$search->link=base_url(lang().'/blogs/'.$linkId);
							break;
						case 'work':
							$searchBgClass='bg_SRWork';
							$search->industry='';
							$search->sell_option='';
							$search->wordCount='';
							$search->length='';
							$search->event_end_date='';
							$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
							$search->link=base_url(lang().'/workshowcase/viewproject/'.$linkId);
							break;
						case 'news':
							$searchBgClass='bg_SRNews';
							$search->industry='';
							$search->genre='';
							$search->sell_option='';
							$search->wordCount='';
							$search->city='';
							$search->length='';
							$search->event_end_date='';
							$search->type=($elementid != $projectid)?$search->type:'';
							$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
							$search->link=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'news'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'news');
							break;
						case 'reviews':
							$searchBgClass='bg_SRNews';
							$search->industry='';
							$search->genre='';
							$search->sell_option='';
							$search->wordCount='';
							$search->city='';
							$search->length='';
							$search->event_end_date='';
							$search->type=($elementid != $projectid)?$search->type:'';
							$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
							$search->link=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'reviews'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'reviews');
							break;
						case 'creatives':
							$searchBgClass='bg_SRCreative';
							$search->sell_option='';
							$search->genre='';
							$search->wordCount='';
							$search->city='';
							$search->length='';
							$search->event_end_date='';
							$linkId=$search->userid.'/';
							$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
							$search->link=base_url(lang().'/showcase/index/'.$linkId);
							break;
						case 'associatedprofessionals':
							$searchBgClass='bg_SRCreative';
							$search->sell_option='';
							$search->genre='';
							$search->wordCount='';
							$search->city='';
							$search->length='';
							$search->event_end_date='';
							$linkId=$search->userid.'/';
							$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
							$search->link=base_url(lang().'/showcase/index/'.$linkId);
							break;
						case 'enterprises':
							$searchBgClass='bg_SRCreative';
							$search->sell_option='';
							$search->genre='';
							$search->wordCount='';
							$search->city='';
							$search->length='';
							$search->event_end_date='';
							$linkId=$search->userid.'/'; 
							$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
							$search->link=base_url(lang().'/showcase/index/'.$linkId);
							break;
						default:
							$searchBgClass='bg_SRFilm';
							$search->industry='';
							$search->sell_option='';
							$search->city='';
							$search->length='';
							$search->event_end_date='';
							$search->link='#';
					}
					$this->load->view('search/searchFrame',array('search'=>$search,'searchBgClass'=>$searchBgClass));
				}
			if($items_total >  $perPageRecord){?>
				 <div class="row pt3 pl15 pr16">
					<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/search/searchresult/0/result'),"divId"=>"searchResultDiv","formId"=>"advanceSearchForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>
					<div class="clear"></div>
					<div class="seprator_10"></div>
				</div>
				<?php
			}
		}else{ 
			$this->load->view('common/no_search_found');
	  }?>
	</div>
	<div class="clear"></div>
	<script>selectBox();</script>
