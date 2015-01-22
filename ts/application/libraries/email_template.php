<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Email_template
{

    private $CI;

    public  function send_email($key = '', $mail_head_data = array(), $mail_body_data = array(), $priority = 1, $language_id = 1)
    {
	
	
        $this->CI = get_instance();
        $this->CI->load->model('email_model');
        if(!$this->CI->email_model->valid_email($mail_head_data['to']))
        {
            return false;
        }
		
        if(in_array(ENVIRONMENT, array('beta', 'production', 'testing') ))
        {
            return $this->CI->email_model->add($mail_head_data['to'], $key, $mail_body_data, $language_id, $priority);
        }
	
        $config = $this->CI->load->config('email',true);
        $SMTP = $config['email']['ses'];//changed to ses for email sending
        $this->CI->load->library('email', $SMTP);
        $this->CI->email->initialize($SMTP);
        $template = $this->CI->email_model->get_template_by_key($key);
		$this->CI->email->from($template->from_email, $template->from_name);
        $this->CI->email->to($mail_head_data['to']);
        $this->CI->email->subject($this->_parse($mail_body_data, @$template->subject));
        $this->CI->email->message($this->_parse($mail_body_data, @$template->body));
        $this->CI->email->set_alt_message($this->_parse($mail_body_data, @$template->body_text));
		if(!$this->CI->email->send())
        {	
			if(in_array(ENVIRONMENT, array('local', 'develop') ))
            {
                show_error('Email was not sent to: '.$mail_head_data['to'].' Subject: '.$this->CI->email->print_debugger());
            }
            else
            {
                error_log('Email was not sent to: '.$mail_head_data['to'].' Subject: '.$this->CI->email->print_debugger());
            }
        }
        /*------------------------------------------------
			// Need to store send mail to email_log table - Start 
			----------------------------------------------------*/
			$today = date("Y-m-d H:i:s");                   // 2001-03-10 17:16:18 (the MySQL DATETIME format)
			$data = array(
		   'from' => $template->from_email ,
		   'to' => $mail_head_data['to'],
		   'created_at'=> $today 
			);
			$this->CI->db->insert('email_log', $data); 
       /*-------- End -----------*/ 

        return true;
    }

    /**
     * @param $array
     * @param $string
     * @return mixed
     */
    private function _parse($array, $string)
    {
        if(empty($string))
            return '';
        foreach($array as $key => $val)
        {
            $string = str_replace('{'.$key.'}', $val, $string);
        }
        $string;
        return $string;
    }
}
