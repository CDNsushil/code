<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    // call user dashboard menu your toadsquare
    $frentendUserId     =   isLoginUser();
    echo Modules::run("common/yourtoadsquaremenu",$frentendUserId);
?>
