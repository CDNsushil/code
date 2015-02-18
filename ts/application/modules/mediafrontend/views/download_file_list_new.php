<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php
	$isRecord=false;
	if($elements){
		$imagetype = $fileConfig['defaultImage_m'];
		$imagetype_xs=$fileConfig['defaultImage_xs'];
		$imagetype_s=$fileConfig['defaultImage_s'];
		$method=$methodName=$industryType;
		$thumbFolder='thumb';
		$elementHeading=$elements[0]['projName'];
		$tdsUid=$elements[0]['tdsUid'];
		
		$userInfo =showCaseUserDetails($tdsUid);
		if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
			$creative_name= $userInfo['enterpriseName'];
		}else{
			$creative_name= $userInfo['userFullName'];
		}
		?>
<div class="row content_wrap blog_wrap" >
   <div class="bg_f1f1f1 fl width100_per  title_head">
      <h1 class="fs24imp letrP-1 opens_light mb0  fl  textin30"> <?php echo $elementHeading;?></h1>
   </div>
   <div class="m_auto display_table wid940">
      <div class="sap_15"></div>
      <div class="pl15 lettsp3">You can access the files via download and/or Pay Per View until <b class="red">14 May 2013</b> 11:59 <span class="fs11">Luxembourg Time</span> </div>
      <div class="sap_20"></div>
      <button class="fr mr15 bg_f1592a bdr_aca height32"><span class="download_file pr20 mr10">Download All Video Files </span>| <span  class="pl5"> 14.34 GB</span></button>
      <div class="defaultP row">
         <div class="fl ml16 mb15">
            <label class="all_click">
            <input  value="1" id="checkAll" name="checkAll" onclick="checkUncheck(this, 0, '.downloadfile'); createStateWiseTaxForm('.downloadfile');" type="checkbox" />
            Select All</label>
         </div>
         <!-- box one -->
         <?php
            $pieceSrartFrom=1;
            $rowCount=2;
            foreach($elements as $e=>$element){
                $fileName=trim($element['fileName']);
                $filePath=trim($element['filePath']);
                $fpLen=strlen($filePath);
                if($fpLen > 0 && substr($filePath,-1) != '/'){
                    $filePath=$filePath.'/';
                }
                $file=$filePath.$fileName;
                if(!is_file($file)){
                    $isRecord=true;
                    if($industryType=='photographyNart'){
                        if($element['projSellstatus']){
                            $thumbFolder='watermark';
                        }
                        $thumbImage = addThumbFolder($element['filePath'].$element['fileName'],'_xs',$thumbFolder);	
                        $elementImage=getImage($thumbImage,$imagetype_xs,'');
                        $elementImage=$element['isExternal']=='t'?trim($element['filePath']):$elementImage;
                    }else{
                        $thumbImage = addThumbFolder($element['imagePath'],'_xs');	
                        $elementImage=getImage($thumbImage,$imagetype_xs);
                    }
                    $elementTextColor='';
                     
                    $craveCount=$element['craveCount']>0?$element['craveCount']:0;
                    $viewCount =$element['viewCount']>0?$element['viewCount']:0;
                    
                    $cravedALL='';
                    $loggedUserId=isloginUser();
                    if($loggedUserId > 0){
                        $where=array(
                                        'tdsUid'=>$loggedUserId,
                                        'entityId'=>$entityId,
                                        'elementId'=>$element['elementId']
                                    );
                        $countResult=countResult('LogCrave',$where);
                        $cravedALL=($countResult>0)?'cravedALL':'';
                    }else{
                        $cravedALL='';
                    }
                      
                                                
                    $downloadDetails=array(
                                'ownerId'=>$element['tdsUid'],
                                'entityId'=>$entityId,
                                'elementId'=>$element['elementId'],
                                'projectId'=>$element['projId'],
                                'fileId'=>$element['fileId'],
                                'tableName'=>'Project',
                                'primeryField'=>'projId',
                                'elementTable'=>$elemetTable,
                                'elementPrimeryField'=>'elementId',
                                'isElement'=>1,
                                'buyerId'=>$buyerId,
                                'dwnId'=>$dwnId
                    );
                    $downloadLink=$downloadDetails['ownerId'].'+'.$downloadDetails['entityId'].'+'.$downloadDetails['elementId'].'+'.$downloadDetails['projectId'].'+'.$downloadDetails['fileId'].'+'.$downloadDetails['tableName'].'+'.$downloadDetails['primeryField'].'+'.$downloadDetails['elementTable'].'+'.$downloadDetails['elementPrimeryField'].'+'.$downloadDetails['isElement'].'+'.$downloadDetails['buyerId'].'+'.$downloadDetails['dwnId'];
                    $downloadLink=encode($downloadLink);
                    $downloadLink=lcfirst($downloadLink);
                    $downloadLink=base_url(lang().'/download/file/'.$downloadLink);
                    
                    $lenghtString='';
                    
                    if($element['fileType']=='image' || $element['fileType']==1){
                        $lenghtString=($element['fileHeight'] > 0 && $element['fileWidth'] > 0)? $element['fileHeight'].'&nbsp;x&nbsp;'.$element['fileWidth'].'&nbsp;'.substr(@$element['fileUnit'],0,2):''; 
                        if($lenghtString!=''){
                                $lenghtString='Dimensions: '.$lenghtString;
                        }
                    }
                    elseif($element['fileType']=='video' || $element['fileType']==2){
                        $lenghtString=($element['fileLength']=='0:0:0' || $element['fileLength']=='00:00:00')?'':$element['fileLength'];
                        if($lenghtString!=''){
                                $lenghtString='Length: '.$lenghtString;
                        }
                    }elseif($element['fileType']=='audio' || $element['fileType']==3){
                        $lenghtString=($element['fileLength']=='0:0:0' || $element['fileLength']=='00:00:00')?'':$element['fileLength'];
                        if($lenghtString!=''){
                                $lenghtString='Length: '.$lenghtString;
                        }
                    }
                    elseif($element['fileType']=='text' || $element['fileType']==4){
                        $lenghtString=($element['wordCount'] > 0)?$element['wordCount'].'&nbsp;'.$this->lang->line('words'):'';
                        if($lenghtString!=''){
                                $lenghtString='Word Count: '.$lenghtString;
                        }
                    }
                    
                    if(is_numeric($element['fileSize']) && $element['fileSize'] > 0){
                        $fileSize=bytestoMB($element['fileSize'],'mb');
                        if($lenghtString !=''){
                            $lenghtString.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Size: $fileSize ".$this->lang->line('mb');
                        }else{
                            $lenghtString="Size: $fileSize ".$this->lang->line('mb');
                        }
                        
                    }

                    ?>	
                     <div class="border_cacaca p10 wid920 display_inline_block row bg_f7f7f7 mb10">
                        <div class="pl5 fl pr5">
                           <input id="checkbox" class="downloadfile" value="1624"  name="checkbox"  type="checkbox" />
                        </div>
                        <div class="display_table fl">
                           <div class="table_cell"><img src="<?php echo $elementImage;?>"  class="img_150x59"   /></div>
                        </div>
                        <div class="pl23 fl width745 fs16 pr5"> <?php echo getSubString($element['title'],100);?>
                            <a href="<?php echo $downloadLink;?>">
                                <button class="fr mt8 bg_f1592a bdr_aca height32"><span class="download_file pr30 mr20">Download </span>| <span class="pl5"> <?php echo formatSizeUnits($element['fileSize']); ?></span></button>
                            </a>
                        </div>
                     </div>
         
                <?php
                        $rowCount++;
                    }
                }
                ?>
         
         <div class="sap_65"></div>
         <div class="sap_65"></div>
      </div>
   </div>
</div>
<?php
	}
?>
