<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the settings module
 *
 * @author 		CDN Team
 * @package 	CMS\Core\Modules\Settings\Controllers
 */
class Admin extends Admin_Controller {

	/**
	 * Validation array
	 * 
	 * @var array
	 */
	private $validation_rules = array();

	/**
	 * Constructor method
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
			
		$this->load->model('settings_m');
		$this->load->library('settings');
		$this->load->library('form_validation');
		$this->lang->load('settings');
		$this->template->append_js('module::settings.js');
		$this->template->append_css('module::settings.css');
		
	}

	/**
	 * Index method, lists all generic settings
	 *
	 * @return void
	 */
	public function index()
	{
		$setting_language = array();
		$setting_sections = array();
		$settings = $this->settings_m->get_many_by(array('is_gui' => 1));
        
		// Loop through each setting
		foreach ($settings as $key => $setting)
		{
			$setting->form_control = $this->settings->form_control($setting);

			if (empty($setting->module))
			{
				$setting->module = 'general';
			}

			$setting_language[$setting->module] = array();

			// Get Section name from native translation, third party translation or only use module name
			if ( ! isset($setting_sections[$setting->module]))
			{
				$section_name = lang('settings:section_'.$setting->module);

				if ($this->module_m->exists($setting->module))
				{
					list($path, $_langfile) = Modules::find('settings_lang', $setting->module, 'language/'.config_item('language').'/');

					if ($path !== false)
					{
						$setting_language[$setting->module] = $this->lang->load($setting->module.'/settings', '', true);

						if (empty($section_name) && isset($setting_language[$setting->module]['settings:section_'.$setting->module]))
						{
							$section_name = $setting_language[$setting->module]['settings:section_'.$setting->module];
						}
					}
				}

				if (empty($section_name))
				{
					$section_name = ucfirst(strtr($setting->module, '_', ' '));
				}

				$setting_sections[$setting->module] = $section_name;
			}

			// Get Setting title and description translations as Section name
			foreach (array(
				'title' => 'settings:'.$setting->slug,
				'description' => 'settings:'.$setting->slug.'_desc'
			) as $key => $name)
			{
				${$key} = lang($name);

				if (empty(${$key}))
				{
					if (isset($setting_language[$setting->module][$name]))
					{
						${$key} = $setting_language[$setting->module][$name];
					}
					else
					{
						${$key} = $setting->{$key};
					}
				}

				$setting->{$key} = ${$key};
			}

			$settings[$setting->module][] = $setting;

			unset($settings[$key]);
		}

		// Render the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', compact('setting_sections', 'settings'));
	}

	/**
	 * Edit an existing settings item
	 *
	 * @return void
	 */
	public function edit()
	{
		
		$settings = $this->settings_m->get_many_by(array('is_gui'=>1));

		// Create dynamic validation rules
		foreach ($settings as $setting)
		{
			$this->validation_rules[] = array(
				'field' => $setting->slug.(in_array($setting->type, array('select-multiple', 'checkbox')) ? '[]' : ''),
				'label' => 'lang:settings:'.$setting->slug,
				'rules' => 'trim'.($setting->is_required ? '|required' : '').($setting->type !== 'textarea' ? '|max_length[255]' : '')
			);
		}

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		// Got valid data?
		if ($this->form_validation->run())
		{
			$settings_stored = array();
			
			// Loop through again now we know it worked
			foreach ($settings as $setting)
			{
				$new_value = $this->input->post($setting->slug, false);

				// Store arrays as CSV
				if (is_array($new_value))
				{
					$new_value = implode(',', $new_value);
				}

				// Only update passwords if not placeholder value
				if ($setting->type === 'password' and $new_value === 'XXXXXXXXXXXX')
				{
					continue;
				}
                
                if ( ($setting->type == 'file') && !empty($_FILES[$setting->slug]['name']) && ($_FILES[$setting->slug]['name'] == 0))
				{
					$config['upload_path'] = './uploads/logo/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size']	= '100';
                    $config['max_width']  = '1024';
                    $config['max_height']  = '768';
                    
                    if(!is_dir($config['upload_path'])){
                       if (!mkdir($config['upload_path'], 0777, true)) {
                            $this->session->set_flashdata('error', 'Failed to create folders, please concern with admin.');
                            redirect('admin/settings');
                       } 
                    }

                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload($setting->slug))
                    {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect('admin/settings');
                    }
                    else
                    {
                        $data = $this->upload->data();
                        if($this->session->userdata('website_logo')){
                            $this->session->unset_userdata('website_logo');
                        }
                        $this->session->set_userdata('website_logo', $data['file_name']);
                        Settings::set($setting->slug, $data['file_name']);
                        $settings_stored[$setting->slug] = $data['file_name'];
                        $this->createThumbnail($config['upload_path'].$data['file_name'],200,70);
                    }
				}

				// Dont update if its the same value
				if ($new_value != $setting->value)
				{
					Settings::set($setting->slug, $new_value);

					$settings_stored[$setting->slug] = $new_value;
				}
			}
			 
			// Fire an event. Yay! We know when settings are updated. 
			Events::trigger('settings_updated', $settings_stored);

			// Success...
			$this->session->set_flashdata('success', lang('settings:save_success'));
		}
		elseif (validation_errors())
		{
			$this->session->set_flashdata('error', validation_errors());
		}

		redirect('admin/settings');
	}
    
    //Create Thumbnail function
 
   private function createThumbnail($filename='',$width=200,$height=70){
         if(!empty($filename)){
            $config['image_library']    = "gd2";      
            $config['source_image']     = $filename;
            $config['new_image'] = $filename;  
            $config['create_thumb']     = TRUE;      
            $config['maintain_ratio']   = TRUE;      
            $config['width'] = $width;      
            $config['height'] = $height;
            $this->load->library('image_lib',$config);
            if(!$this->image_lib->resize()){
                //echo $this->image_lib->display_errors();die;
            } 
        }
    }

	/**
	 * Sort settings items
	 *
	 * @return void
	 */
	public function ajax_update_order()
	{
		$slugs = explode(',', $this->input->post('order'));

		$i = 1000;
		foreach ($slugs as $slug)
		{
			$this->settings_m->update($slug, array(
				'order' => $i--,
			));
		}
	}
	
	function configuration()
	{
		 $userId=is_logged_in();
		 
		$config = $this->common_model->getDataFromTabel('admin_configuration','*',array('user_id'=>$userId));
		

        //validation for edit membershipform
		$this->validateConfigurationFormFields();
		
		
		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);
			
			if ($this->form_validation->run())
			{
				if ($success = $this->settings_m->addConfiguration($this->input->post(),$config))
				{
					$this->session->set_flashdata('success',lang('settings:referral_success_msg'));
				}
				else
				{
					$this->session->set_flashdata('error',lang('settings:referral_error_msg'));
				}
				redirect('admin/settings/configuration');
			}
		}
		$configuration = new stdClass();
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$configuration->{$rule['field']} = set_value($rule['field']);
		} 
		$currencyArray=$this->common_model->getCorrencies();
		$data['currencies']=$currencyArray;
		
		if(!empty($config)){
			$configuration=$config[0];
		}
	
		// Render the layout
		$this->template
		->set('_configuration', $configuration)
		->build('admin/configuration',$data);
	}
	
	function validateConfigurationFormFields()
	{
		 // Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'email',
				'label' => lang('global:email'),
				'rules' => 'trim|required|max_length[250]'
			),
			/*array(
				'field' => 'referral_point',
				'label' => lang('settings:referral_point'),
				'rules' => 'trim|required|max_length[5]'
			), */
			array(
				'field' => 'paypal_id',
				'label' => lang('settings:paypal_id'),
				'rules' => 'trim|required'
			), 
			array(
				'field' => 'referral_point_amt',
				'label' => lang('settings:referral_point_amt'),
				'rules' => 'trim|required|max_length[5]'
			),
			array(
				'field' => 'currency',
				'label' => lang('settings:currency'),
				'rules' => 'trim|required|max_length[5]'
			),
			array(
				'field' => 'minimum_referral_point',
				'label' => lang('settings:minimum_referral_point'),
				'rules' => 'trim|required|max_length[5]'
			),
		);
	}
}


/* End of file admin.php */
