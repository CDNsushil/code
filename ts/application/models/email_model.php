<?php
/**
 * email_model.php
 *
 * @package Package Name
 * @subpackage Subpackage
 * @category Category
 * @author Mohidul Islam
 * @link http://example.com
 */
class email_model extends MY_Model {

    /**
     * @param $to
     * @param $template
     * @param $template_data
     * @param int $priority
     * @param int $language_id
     * @return int
     */
    public function add($to, $template, $template_data, $language_id = 1, $priority = 0)
    {
        if(!$this->valid_email($to))
        {
            return false;
        }
        $hash = sha1($to.time());
        $template_data['favicon_url'] = site_url('/favicon/'.$hash);
        $template_data['unsubscribe_url'] = site_url('/unsubscribe/'.$hash);
        $data['to_email'] = $to;
        $data['template_name'] = $template;
        $data['template_data'] = json_encode($template_data);
        $data['priority'] = $priority;
        $data['language_id'] = $language_id;
        $data['hash'] = $hash;
        $data['date_created'] = date("Y-m-d H:i:s");

        return $this->insert($data);
    }
    /**
     * @param $key
     * @return mixed
     */
    public function get_template_by_key($key)
    {
        $this->_table = 'email_template';
        $template =  $this->get_by(array('key' => $key));
        $this->_table = 'emails';
        return $template;
    }
    /**
     * @param $email
     * @return bool
     */
    public function valid_email($email)
    {
        $this->_table = 'do_not_contact_emails';
        $count =  $this->count_by("emails like  '%$email%'");
        $this->_table = 'emails';
        return empty($count)? true: false;
    }
    /**
     * @param $hash
     * @return bool
     */
    public function increment_read_count($hash)
    {
        if(!empty($hash) and strlen($hash) == 40)
        {
            if($email = $this->get_by(array('hash' => $hash)))
            {
                return $this->update($email->id, array('status' => 'read', 'read_count' => $email->read_count+1 , 'read_from_ip' => $_SERVER['REMOTE_ADDR'], 'last_read_date' => date("Y-m-d H:i:s")));
            }
        }
        return false;
    }
    /**
     * @param $hash
     * @return bool
     */
    public function unsubscribe($hash)
    {
        if(!empty($hash) and strlen($hash) == 40)
        {
            if($email = $this->get_by(array('hash' => $hash)))
            {
                return $this->add_dont_contact_email(@$email->to_email);
            }
        }
        return false;
    }
    /**
     * @return mixed
     */
    public function get_dont_contact_email()
    {
        $this->_table = 'do_not_contact_emails';
        $return = $this->get_all();
        $this->_table = 'emails';
        return $return;
    }
    public function add_dont_contact_email($email = null)
    {
        $emails = $this->get_dont_contact_email();
        $data = array(
            'id' => @$emails[0]->id,
            'emails' => @$emails[0]->emails.', '.$email
        );
        $this->save_dont_contact_email($data);

    }
    public function save_dont_contact_email($data)
    {
        $this->_table = 'do_not_contact_emails';
        $return = $this->save(array('id' => $data['id'], 'emails' => $data['emails']));
        $this->_table = 'emails';
        return $return;
    }
}
/* End of file email_model.php */
/* Location: ${FILE_PATH}/email_model.php */ 