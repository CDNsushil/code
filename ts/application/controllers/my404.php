<?php
class my404 extends MX_Controller
{
	public function __construct()
	{
	        parent::__construct();
	        $this->head->add_css($this->config->item('system_css').'frontend.css');
		
	}
	
	public function index()
	{
		
		$this->output->set_status_header('404');
		$data['error_404'] = 'error_404'; // View name
		$data['errorMsg1'] = $this->lang->line('noPageFoundErrorMsg1'); // noRecordFoundErrorMsg1
		$data['errorMsg2'] = $this->lang->line('noPageFoundErrorMsg2'); // noRecordFoundErrorMsg2
		$this->new_version->load('new_version','my404',$data);//loading in my template
	}
	
	public function norecordfound()
	{
		
		$this->output->set_status_header('404');
		$data['error_404'] = 'error_404'; // View name
		$data['errorMsg1'] = $this->lang->line('noRecordFoundErrorMsg1'); // noRecordFoundErrorMsg1
		$data['errorMsg2'] = $this->lang->line('noRecordFoundErrorMsg2'); // noRecordFoundErrorMsg2
		$this->new_version->load('new_version','my404',$data);//loading in my template
	}
}
?>
