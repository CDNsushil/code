<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author  Sushil Mishra
 * @package cms
 */ 
 
class Module_Cms extends Module {
        public $version = '2.0.0';
        public function info(){
                $info = array(
                        'name' => array(
                                'en' => 'Blocks',
                        ),
                        'description' => array(
                                'en' => 'This is a Block Module.',
                        ),
                        'frontend' => false,
                        'backend' => TRUE,
                        'menu' => 'content',
                        'roles'		=> array('admin_profile_fields')
			       
                );
                
                if (function_exists('group_has_role'))
                {
                    if(group_has_role('cms', 'admin_profile_fields'))
                    {
                        $info['sections'] = array(
                            'cms' => array(
                                    'name' 	=> 'cms:list_title',
                                        'shortcuts' => array(
                                            'create' => array(
                                                'name' 	=> 'cms:add_title',
                                                'uri' 	=> 'admin/cms/create',
                                                'class' => 'add'
                                                )
                                            )
                                        ),
                                );
                    }
                }
                
                return $info;
        }
        
        public function admin_menu(&$menu)
		{			
			 //$menu['CMS'] = 'admin/cms/index';
				
           /* $menu['Cms'] = array(
				'Affiliate Cms'=> 'admin/cms/index',
				'Merchant Payment'=> 'admin/cms/merchantPayment',
				
			);*/

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
