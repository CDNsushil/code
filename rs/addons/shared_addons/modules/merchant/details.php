<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author  rajendra patidar
 * @package membsrship
 */ 
 
class Module_Merchant extends Module {
        public $version = '2.0.0';
        public function info(){
                return array(
                        'name' => array(
                                'en' => 'Merchant',
                        ),
                        'description' => array(
                                'en' => 'This is a Merchant Module.',
                        ),
                        'frontend' => TRUE,
                        'backend' => TRUE,
			       
                );
        }
        public function admin_menu(&$menu)
		{			
			/* $menu['merchant'] = array(
				'Manage Merchant'=> 'admin/merchant',
				'Membership Features'=> 'admin/merchant/features',
			); */

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
