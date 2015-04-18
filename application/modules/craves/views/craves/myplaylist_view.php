<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class=" clearbox aboutme_cnt pl115">
    <div class="cnt_abtme  width576 m_auto">
        <div class="width576 edit_showcase"><?php 
            if($userPlaylistData && getMyPlaylistCount($tdsUid)){
                $loggedUserId = isLoginUser();
                echo Modules::run("player/audioplaylistplay"); ?>	
                 <div  id="myplaylist">
                    <?php 
                        $count=0;
                        $first_element_id='';
                        foreach($userPlaylistData as $userPlaylist){
                            
                        if($count==0){
                             $first_element_id = $userPlaylist['elementId'];
                             
                        }	
                        
                        $playlistId  =  (!empty($userPlaylist['id']))?$userPlaylist['id']:0; 
                        $viewCount   =  (!empty($userPlaylist['viewCount']))?$userPlaylist['viewCount']:0; 
                        $craveCount  =  (!empty($userPlaylist['craveCount']))?$userPlaylist['craveCount']:0; 
                        $fileLength  =  (!empty($userPlaylist['fileLength']))?$userPlaylist['fileLength']:0; 
                        $entityId    =  (!empty($userPlaylist['entityId']))?$userPlaylist['entityId']:0; 
                        $elementId   =  (!empty($userPlaylist['elementId']))?$userPlaylist['elementId']:0; 
                       
                            
                        // make music image show
                        $thumbImage_src = addThumbFolder($userPlaylist['imagePath'],'_s');	
                        $elementImage_src=getImage($thumbImage_src,$imagetype_s);
                        
                        // get audio file path
                        $MainFilePath 	=	$userPlaylist['filePath'].$userPlaylist['fileName'];
                        
                        // check media file exist
                        if(file_exists($MainFilePath)) {
                        
                        //$getFullFilePath	=	str_replace('media','',$getFullFilePath);
                        $getFullFilePath =  base_url($MainFilePath);
                        
                        
                        //---------check craved by loggedUserId------------//
                        if($loggedUserId){
                            $where=array(
                                'tdsUid'        =>   $loggedUserId,
                                'entityId'      =>   $entityId,
                                'elementId'     =>   $elementId
                            );
                            
                            $countResult    =   countResult('LogCrave',$where);
                            $cravedALL      =   ($countResult>0)?'cravedALL':'';
                        }else{
                            $cravedALL='';
                        }
                    ?>
                    
                            <div class="muct_p_list">
                                <a id="fire_<?php echo $userPlaylist['elementId'];?>" music_Title='<?php echo getSubString($userPlaylist['title'],100);?>' music_Image='<?php echo $elementImage_src;?>' href="<?php echo $getFullFilePath; ?>" onclick="playNpaush('<?php echo $userPlaylist['elementId'];?>')" playingElementId="<?php echo $userPlaylist['elementId'];?>"  >
                                    <div class="bt_d4d4d4 pt12 width440 pb15 fl">
                                       <div class="pl15 pr10">
                                          <div class="font_bold lineH18 letter_spP7 row pb5 red fl fs16"><?php echo getSubString($userPlaylist['title'],100);?></div>
                                          <div class="fr">
                                             <div class="head_list fl ">
                                                <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                                                <div class="icon_crave4_blog icon_so <?php echo $cravedALL ;?>"><?php echo $craveCount; ?></div>
                                             </div>
                                             <div class="fr">
                                                <div class="red fl pr10 width90 pt3 text_alignR"> <?php echo playlistFileLength($fileLength); ?> </div>
                                                <button class="play_btn" type="button"></button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                </a>
                                 <div class="remove_icon fr mt30 fs13 lett_8p ptr removeCrave"  >
                                    <a class="removePlaylist" id="<?php echo $playlistId; ?>" href="javascript:void(0);">Remove</a> 
                                 </div>
                            </div>
                        
                 
                 <?php $count++; }  } ?>
                 
                 </div>	
                <?php 
            }else{ 
                echo "There is no record found in  the playlist.";
            } ?>        
        </div>
    </div>
</div>
<script type="text/javascript">
    // change text playing, play and paush 
    function playNpaush(elementId){
        var idName= 'fire_'+elementId;
        
        $('.trackname').html($("#"+idName).attr('music_Title'));// show current playing music title
        $('#musciImg').attr('src',$("#"+idName).attr('music_Image'));// show current playing music image
    }  
    
     //previous button
    $(document).on('click','.previous_btn',function(){
        if($(this).hasClass('disabled')===false){
            var ind       = player.getClip().index;
            ind           = (ind > 0)?ind-1:ind;
            nextpreviousplay(ind);
        }
    });
    
    //next button 
    $(document).on('click','.next_btn',function(){    
        if($(this).hasClass('disabled')===false){
            var ind = player.getClip().index;
            ind   = (ind >= 0)?ind+1:ind;
            nextpreviousplay(ind);
        }
    });
    
    
    //play audio file
    function nextpreviousplay(ind) {
      player.play(ind);
    }
    
    //button enable & disbled
    function buttonenable(ind, plength) {
        var getplength = (plength>0)?plength-1:plength;
        var previous = ind > 0 ? false : true;
        var next = (ind < getplength && ind != getplength) ? false : true;
        if(previous){
            $(".previous_btn").addClass("disabled");
        }else{
            $(".previous_btn").removeClass("disabled");
        }
        if(next){
            $(".next_btn").addClass("disabled");
        }else{
            $(".next_btn").removeClass("disabled");
        }
       
    }
    
    //default next previous button disabled
    buttonenable(0);
   
    //first time load title
    setTimeout("playNpaush(<?php echo $first_element_id; ?>);", 100);
    
    //reset all play button of playlist
    $(document).on('click','.stop',function(){
        $('.playing').each(function(){
            $(this).removeClass('playing');
        });
    });
    
    $(".removePlaylist").click(function(){
        var playlistid = $(this).attr('id');
        var formData = {'playlistid':playlistid};
        confirmBox("Do you really want remove this music file?", function () {
            $.post(baseUrl+language+'/showcase/playlistdelete',formData, function(data) {
                if(data){
                    refreshPge();
                }
            });
        });
    });

</script>
