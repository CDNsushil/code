<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author  rajendra patidar
 * @package membsrship
 */ 
 
class Module_Home extends Module {
        public $version = '2.0.0';
        public function info(){
                return array(
                        'name' => array(
                                'en' => 'Home',
                        ),
                        'description' => array(
                                'en' => 'This is a Home Module.',
                        ),
                        'frontend' => TRUE,
                        'backend' => TRUE,
			       
                );
        }
        public function admin_menu(&$menu)
		{			
			
            //add_admin_menu_place('Portfolio', 2);

		}
        public function install()       {
                return true;
        }
        public function uninstall(){
                return true;
        }
        public function upgrade($old_version){
                // Your Upgrade Logic
                return TRUE;
        }
        public function help(){
                // Return a string containing help info
                // You could include a file and return it here.
                return "No Help";
        }
}
