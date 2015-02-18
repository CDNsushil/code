<?php
/**
 * Base_Template.php
 *
 * @package Package Name
 * @subpackage Subpackage
 * @category Category
 * @author  Mohidul Islam
 * @link http://example.com
 */
abstract class Base_Template
{
    public  $template_data = array();
    public  $CI;
    protected $css_path;
    protected $js_path ;
    protected $min_js_file = '';
    protected $min_css_file = '';
    /**
     *
     */
    public function  __construct()
    {
        get_user_current_time_zone_by_ip();
        $this->CI =& get_instance();
        $this->CI->load->driver('minify');
    }
    protected function get_s3_file_path($path, $filename = null)
    {
        return CF_DEFAULT_TEMPLATE_URL.$path.get_s3_directory('_').$filename;
    }
    /**
     * @param $name
     * @param $value
     */
    protected function set($name, $value)
    {
        $this->template_data[$name] = $value;
    }

    protected function set_meta()
    {
        $this->CI->head->add_meta('cache-control', 'max-age=86400');
        $this->CI->head->add_meta('Cache-Control', 'Private');
    }
    protected function set_min_js()
    {
        if(in_array(ENVIRONMENT, array('local','development')))
        {
            $this->generate_min_js();
            $this->CI->head->add_js(site_url($this->js_path.$this->min_js_file));
            return true;
        }
        $this->CI->head->add_js($this->get_s3_file_path($this->js_path, $this->min_js_file));
    }
    /**
     * @return bool
     */
    protected function set_min_css()
    {
        if(in_array(ENVIRONMENT, array('local','development')))
        {
            $this->generate_min_css();
            $this->CI->head->add_css(site_url($this->css_path.$this->min_css_file));
            return true;
        }
        $this->CI->head->add_css($this->get_s3_file_path($this->css_path, $this->min_css_file));
    }
    /**
     * @param $view
     * @param $view_data
     */
    protected function set_content($view, $view_data)
    {
        if(!file_exists(APPPATH.'views/'.$view.'.php'))
        {
            $view = "default";
        }
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
    }

    /**
     * @abstract
     *
     */
    abstract protected function generate_min_css();
    abstract protected function generate_min_js();
    abstract public  function generate_min();
    abstract protected function set_nav();


}
/* End of file Base_Template.php */
/* Location: ${FILE_PATH}/Base_Template.php */ 