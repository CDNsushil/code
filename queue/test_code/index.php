<?php 
$Source =  dirname(__FILE__).'/testing_file.mp3';
$Source1 =  dirname(__FILE__).'/small_temp.mp4';

    if(file_exists($Source))
    {
        $command= "ffmpeg -y -i '".$Source."'";
        exec($command." 2>&1", $output);
        
        //echo $filePath = dirname(dirname(__FILE__)).'/queue/test_code/test.txt';

        //file_put_contents($filePath, print_r($output, true));
         
        echo "<pre>";
        print_r($output);
        
    }
    else
    {
        echo "file not found.";
    }


    function fileLength($duration=""){
         $time = "00:00:00";
        if(!empty($duration)){  
       
        $percent = 100;
        
        preg_match('/Duration: (.*?),/', $duration, $matches);
        
            if(!empty( $matches[1])){
                $duration = $matches[1];
                $duration_array = split(':', $duration);
                if(!empty($duration_array)){
                    $duration = $duration_array[0] * 3600 + $duration_array[1] * 60 + $duration_array[2];
                    $time = $duration * $percent / 100;
                    $time = intval($time/3600) . ":" . intval(($time-(intval($time/3600)*3600))/60) . ":" . intval(($time-(intval($time/60)*60)));
                }
            }   
        }
        
        return $time;
    }


?>
