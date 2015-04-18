<?php
/* tky@tmo.blackberry.net inviter.php Fri May 22 04:00:19 GMT 2009 */

class inviter
{
    var $ci;
    var $imported;
    
    public function __construct()
    {
        $this->ci=& get_instance();
    }

    public function grab_contacts($plugin,$username,$password)
    {
        require_once($this->ci->config->item(base_url()).'templates/system/OpenInviter/openinviter.php');
        
        $oi    = new OpenInviter();
        
        $oi->startPlugin($plugin);
        //First modification , added the if clause
        if($oi->login($username,$password))
        {
            $array        =     $oi->getMyContacts();
            
            if(is_array($array) && count($array)>=1)
            {
                $this->imported        =    $array;
                
                $this->_store_invited();
                
                return($this->imported);
            }else{
                return;
            }
        }
        else
        {
        return 'ERROR on login.';
        }
    }
    
    private function _store_invited()
    {
        foreach($this->imported as $mail=>$name)
        {
            //Second modification , commented out the user_id /

            $a    =    array(   /* 'user_id'        =>    ospc_user_id(),*/
                            'name'            =>    $name,
                            'email_address'    =>    $mail,
                            'status'        =>    0,
                            'time_imported'    =>    time()    );
                            
            $this->ci->db->insert('ospc_imported',$a);
            
            unset($a);
        }
    }
}
?>  
