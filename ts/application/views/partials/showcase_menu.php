<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    // call user showcase menu module 
   $frentendUserId     =   frentendUserId();
    echo Modules::run("showcase/usershowcasemenu",$frentendUserId);
?>

