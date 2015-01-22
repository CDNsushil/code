<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Head Class
 * 
 * Creates the Doctype and head tags for an HTML page built with CodeIgniter.
 * 
 * @license		GNU General Public License
 * @author		Adam Fairholm
 * @email		adam.fairholm@gmail.com
 * @forked by	Dan Smith
 * @email		dansmith65@gmail.com
 * @link		http://github.com/dansmith65/CodeIgniter-Head-Library/
 * 
 * @file		Head.php
 * @version		2.0
 * @date		March 14, 2011
 * 
 * Copyright (c) 2011
 */


class Head
{
	var $packs;											// Packages to include
	var $packs_processed;								// Packages that have included
	var $meta;											// Additional Metadata	
	var $css;											// CSS files
	var $js;											// JavaScript files
	var $inline_css;									// CSS code
	var $inline_js;										// JavaScript code
	var $feed;											// RSS/Atom feets
	var $misc;											// Misc items to add in
  	var $jquery;            							// JQuery Items
	
	var $xml_doctypes = array('xhtml11',				// Doctypes that require some special XHTML love
							'xhtml1-strict',
							'xhtml1-trans',
							'xhtml1-frame');
	
	// properties that can be set from configuration file
	var $show_errors 		= TRUE;						// Should we throw a hissy fit?
	var $close_head			= TRUE;						// Should we use the closing </head> tag?
	var $debug				= FALSE;					// Should we debug?
	var $output_string		= TRUE;					// Should we output this to a string? If not, then we'll use a constant
	var $constant_name		= 'HEAD';					// Name of constant to save to if we are going that route
	var $base_url			= '';						// URL to use for relative links, defaults to base_url from CI config
	var $js_location		= '';			// Location of the Javascript files
	var $css_location		= '';					// Location of the CSS files
	var $doctype			= 'xhtml1-strict';			// Default Doctype
	var $use_base			= TRUE;					// Should we use the <base> tag?
	var $base_target		= '';						// Target for the base, if needed
	var $base_ref			= '';						// Href for the base. Uses base_url in config if blank
	var $site_title			= '';						// The title of the site
	var $title 				= '';						// The title page
	var $title_append		= TRUE;						// Should we append this to the site title?
	var $title_append_str	= ' - ';					// How we should append, if necessary
	var $use_meta			= TRUE;						// I don't know, maybe someone doesn't want to
	var $meta_content		= '';						// Content type for meta data
	var $meta_language		= 'en';						// Language for meta data
	var $meta_author		= '';						// Author name for the meta data
	var $meta_description	= '';						// Description for the meta data
	var $meta_keywords		= '';						// Keywords for the meta data
	var $use_favicon		= TRUE;						// Should we use the favicon?
	var $favicon_location 	= 'images/favicon.ico'; 	// Location of the favicon if we're using it
	var $ga_tracking_id		= '';						// Google Analytics Tracking Code
	var $jquery_file		= '';				// Name of JQuery file
	var $packages			= array();					// Packages
	var $defaults			= array();					// Default items to load

	// --------------------------------------------------------------------------
	
	public function __construct($config = array())
	{
		$CI =& get_instance();
	
		// We need the html helper
		if ( ! function_exists('br'))
		{
			$CI->load->helper('html');
		}
			
		// set default base_url
		$this->base_url	= $CI->config->item('base_url');
		
		// set default meta_content
		$this->meta_content = 'text/html; charset='.$CI->config->item('charset');
		
		//Initialize the configs
		if (count($config) > 0)
		{
			$this->initialize($config);
		}
		else
		{
			// include defaults, so they are output before all others
			$this->_process_defaults();
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Initialize the user preferences
	 *
	 * Accepts an associative array as input
	 *
	 * @access	public
	 * @param	array	config preferences
	 * @return	void
	 */
	public function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}
		
		// if config contained defaults
		if (isset($config['defaults']))
		{
			// include defaults, so they are output before all others
			$this->_process_defaults();
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Render Head <head></head>
	 * 
	 * Creates our doctype and head calls for a nice clean head to the document.
	 *
	 * @param	array [$passed_config]
	 * @return	void or string
	 */
	public function render_head($passed_config = array())
	{
		if (count($passed_config) > 0)
		{
			$this->initialize($passed_config);
		}
		
		// Start the party
		
		$this->_process_packages();
		
		$html  = $this->_render_doctype();
		
		$html .= $this->_render_html().PHP_EOL.'<head>'.$this->_bump(FALSE);
		
		if ($this->use_base)
		{
			$html .= $this->_render_base();
		}
		
		if ($this->use_meta)
		{
			$html .= $this->_render_meta();
		}
		
		$html .= $this->_render_custom_meta();
		
		if ($this->use_favicon)
		{
			$html .= $this->_render_favicon();
		}
		
		$html .= $this->_render_items('css');
		$html .= $this->_render_inline('css');
		$html .= $this->_bump(FALSE);

		// Jquery likes to be loaded first, so if we are using it,
		// make it the first value in the array
		if ( ! is_array($this->js))
		{
			$this->js = (array)$this->js;
		}
		$jquery_location = array_search($this->jquery_file, $this->js);
		if ($jquery_location !== FALSE OR ! empty($this->jquery))
		{
			if ($jquery_location !== FALSE)
			{
				unset($this->js[$jquery_location]);
			}
			array_unshift($this->js, $this->jquery_file);
		}
		
		$html .= $this->_render_inline('js');
		$html .= $this->_render_items('js');
		$html .= $this->_render_jquery();
		$html .= $this->_bump(FALSE);
		
		$html .= $this->_render_feed();
		
		$html .= $this->_render_misc();
		
		$html .= $this->_render_title();
		
		$html .= $this->_render_ga();
		
		if ($this->close_head)
		{
			$html .= '</head>';
		}
		
		//Debug
		if ($this->debug == TRUE)
		{
			$this->_check_head();
		}
		
		//Final out
		if ($this->output_string == TRUE)
		{
			return $html;
		}
		else
		{
			define($this->constant_name, $html);
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add a package to head
	 *
	 * @param	mixed string or array
	 *				as string:[$packs] separated by "|"
	 *				as array: array of package names
	 * @return	void
	 */
	public function add_package($packs)
	{
		if (is_string($packs))
		{
			$packs = explode('|', $packs);
		}

		foreach($packs as $pack)
		{
			$this->_save_package($pack);
		}
		
		// processing all packages as they are added has all items
		// be output in the order they were declared
		$this->_process_packages();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * alias of add_package
	 * DEPRECIATED!
	 */
	public function include_packages($packs)
	{
		$this->add_package($packs);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add a meta item
	 * 
	 * Allows you to create a new meta item
	 *
	 * @param	string [$name] name of the meta item
	 * @param	string [$content] meta content
	 * @param	string [$name_or_equiv] "name" or "equiv" meta. Defaults to "name"
	 * @return 	void
	 */
	public function add_meta($name, $content, $name_or_equv = 'name')
	{
		$this->_process_item(array(array($name, $content, $name_or_equv)), 'meta');
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add a CSS file link tag
	 *
	 * @param	string [$file] filename of the CSS file
	 * @param	string [$media] media type. Defaults to "all"
	 * @param	string [$condition] conditional statement to wrap <style> tag in. Defaults to NULL
	 * @return	void
	 */
	function add_css($file, $media="all", $condition=NULL)
	{
		$this->_process_item(array(array($file, $media, $condition)), 'css');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Add a JS file link tag
	 *
	 * @param	string [$file] file name of the JS file
	 * @return	void
     * @modified by: lokendra
	 */
	function add_js($file, $condition=NULL,$isLast=NULL)
	{
		$this->_process_item(array(array($file, $condition,$isLast)), 'js');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Add a CSS or JS file link tag
	 * 
	 * same result as using either add_js or add_css
	 * 
	 * @param	mixed string or array [$item] filename of file, and options (if any)
	 * @return	void
	 */
	function add($item, $opt1=NULL, $opt2=NULL)
	{
		if ($opt2 !== NULL)
		{
			$this->_process_item(array(array($item, $opt1, $opt2)));
		}
		elseif ($opt1 !== NULL)
		{
			$this->_process_item(array(array($item, $opt1)));
		}
		else
		{
			$this->_process_item($item);
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add some JQuery code
	 *
	 * @param	string [$code] the JQuery code to be added
	 * @return	void
	 */
	function add_jquery($code)
	{
		$this->_process_item($code, 'jquery');
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add some inline CSS code
	 *
	 * @param	string [$code] The code to add
	 * @return	void
	 */
	function add_inline_css($code)
	{
		$this->_process_item($code, 'inline_css');
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add some inline JS code
	 *
	 * @param	string [$code] The code to add
	 * @return	void
	 */
	function add_inline_js($code)
	{
		$this->_process_item($code, 'inline_js');
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add some inline CSS code or JS code
	 *
	 * DEPRECIATED! Kept for backwards compatability.
	 * use add_inline_css() or add_inline_js() instead
	 * 
	 * @param	string [$code] The code to inserted
	 * @param	string [$js_or_css] set to "js" or "css"
	 * @return	void
	 */
	function add_inline($code, $js_or_css)
	{
		$this->_process_item($code, 'inline_'.$js_or_css);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add RSS or Atom feed link
	 *
	 * @param	string [$feed] full feed URL
	 * @param	string [$name] feed title
	 * @param	string [$rss_or_atom] RSS or Atom. Defaults to RSS.
	 */
	function add_feed($feed, $name, $rss_or_atom = 'rss')
	{
		$this->_process_item(array(array($feed, $name, $rss_or_atom)), 'feed');
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add misc
	 *
	 * Add pretty much anything into the head document
	 *
	 * @param	string [$code] code to add to head
	 * @return	void
	 */
	public function add_misc($code)
	{
		$this->_process_item($code, 'misc');
	}

	// --------------------------------------------------------------------------
	
	
	
	/**
	 * Render Doctype
	 * 
	 * Get our doctype out there.
	 * Uses the html helper doctype function and accesses doctype config array
	 *
	 * @return	string doctype
	 */
	private function _render_doctype()
	{
		$doc = doctype($this->doctype);
		
		if ( ! trim($doc))
		{
			$this->_handle_error(__FUNCTION__.': Invalid Doctype');
		}
		else
		{
			return $doc.PHP_EOL;
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Render the html opening tag
	 * 
	 * @return	string
	 */
	private function _render_html()
	{
		if (in_array($this->doctype, $this->xml_doctypes))
		{
			return '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$this->meta_language.'" lang="'.$this->meta_language.'">';
		}
		else
		{
			return '<html>';
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Render the base tag
	 *
	 * @return	string
	 */
	private function _render_base()
	{
		if ( ! $this->base_ref)
		{
			$base = $this->base_url;
		}
		else
		{
			$base = $this->base_ref;
		}
			
		$out = '<base href="'.$base.'"';
		
		if ($this->base_target)
		{
			$out .= ' '.$this->base_target;
		}
	
		return $out .= ' />'.$this->_bump();
	}

	// --------------------------------------------------------------------------
	
	
	/**
	 * Render metadata
	 *
	 * @return	string
	 */
	private function _render_meta()
	{
		$out = '';
		
		if ($this->meta_content)
		{
			$out .= meta('content-type', $this->meta_content, 'equiv').$this->_indent();
		}
	
		if ($this->meta_language)
		{
			$out .= meta('content-language', $this->meta_language, 'equiv').$this->_indent();
		}
	
		if ($this->meta_author)
		{
			$out .= meta('author', $this->meta_author).$this->_indent();
		}
		
		if ($this->meta_description)
		{
			$out .= meta('description', $this->meta_description).$this->_indent();
		}
		
		if ($this->meta_keywords)
		{
			$out .= meta('keywords', $this->meta_keywords).$this->_indent();
		}
		
		// add extra line of whitespace if there is no more metadata to add
		if (count($this->meta) == 0)
		{
			$out .= $this->_bump(FALSE);
		}
		
		return $out;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Render metadata that was added via add_meta(), packages, or default
	 *
	 * @return	string
	 */
	private function _render_custom_meta()
	{
		$out = '';
		
		if (is_array($this->meta) && count($this->meta)>0)
		{
			foreach($this->meta as $meta_item)
			{
				if ( ! is_array($meta_item) OR count($meta_item)<2)
				{
					$this->_handle_error('custom meta item had too few parameters');
				}
				elseif (count($meta_item) == 2)
				{
					$out .= meta($meta_item[0], $meta_item[1]);
				}
				elseif (count($meta_item) == 3)
				{
					$out .= meta($meta_item[0], $meta_item[1], $meta_item[2]);
				}
				else
				{
					$this->_handle_error('custom meta item had too many parameters');
				}
				
				$out .= $this->_indent();
			}
			$out .= $this->_bump(FALSE);
		}
		
		return $out;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Render Favicon
	 *
	 * @return	string
	 */
	private function _render_favicon()
	{
		return '<link rel="shortcut icon" href="'.$this->_get_link($this->favicon_location, 'favicon').'" />'.$this->_bump();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Render CSS or JS
	 *
	 * @return	string
	 */
	private function _render_items($type)
	{
		$out = '';
		
		if ($type == 'css')
		{
			foreach($this->$type as $it)
			{
				// ensure it is an array with 3 values
				$it = array_pad((array)$it, 3, NULL);
				$file = $it[0];
				$media = $it[1]!=NULL ? $it[1] : 'all';
				$condition = $it[2];
				
				if ($condition !== NULL)
				// open condition
				{
					$out .= '<!--[if '.$condition.']>'.$this->_bump(FALSE);
				}
				
				if($file!="all")
				{
					// create html
					$out .= '<link type="text/css" href="'.$this->_get_link($file, $type).'" rel="stylesheet" media="'.$media.'" />'.$this->_bump(FALSE);
				}	
				
				if ($condition !== NULL)
				// close condition
				{
					$out .= '<![endif]-->'.$this->_bump(FALSE);
				}
			}
		}
		elseif ($type == 'js')
		{
			foreach($this->$type as $it)
			{
				// ensure it is an array with 2 values
				$it = array_pad((array)$it, 2, NULL);
				$file = $it[0];
				$condition = $it[1];
				$lastAdd = $it[2];
				
				if ($condition !== NULL)
				// open condition
				{
					$out .= '<!--[if '.$condition.']>'.$this->_bump(FALSE);
				}
				
				// create html //changed by lokendra
                if($lastAdd==NULL){
                    $out .= '<script type="text/javascript" src="'.$this->_get_link($file, $type).'"></script>'.$this->_bump(FALSE);
                }
                
				if ($condition !== NULL)
				// close condition
				{
					$out .= '<![endif]-->'.$this->_bump(FALSE);
				}
			}
            
            //add js in last after all js loaded [added by lokendra]
            foreach($this->$type as $it)
			{
				// ensure it is an array with 2 values
				$it = array_pad((array)$it, 2, NULL);
				$file = $it[0];
				$condition = $it[1];
				$lastAdd = $it[2];
				
				if ($condition !== NULL)
				// open condition
				{
					$out .= '<!--[if '.$condition.']>'.$this->_bump(FALSE);
				}
				
				// create html
                if($lastAdd=='lastAdd'){
                    $out .= '<script type="text/javascript" src="'.$this->_get_link($file, $type).'"></script>'.$this->_bump(FALSE);
                }
                
				if ($condition !== NULL)
				// close condition
				{
					$out .= '<![endif]-->'.$this->_bump(FALSE);
				}
			}
		}
		else
		{
			$this->_handle_error(__FUNCTION__.': invalid parameter: '.$type);
		}
		
		return $out;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Render inline CSS or JS code
	 *
	 * @param	string [$type] "js" or "css"
	 * @return	void
	 */
	private function _render_inline($type)
	{
		$out = '';
		
		if ($type == 'css')
		{
			if (count($this->inline_css)>0)
			{
				$out = '<style type="text/css">'.$this->_bump(FALSE).$this->_indent();
				$out .= implode($this->_bump(FALSE).$this->_indent(), $this->inline_css);
				$out .= $this->_bump(FALSE).'</style>'.$this->_bump(FALSE);
			}
		}
		elseif ($type == 'js')
		{
			if (count($this->inline_js)>0)
			{
				$out = '<script type="text/javascript" language="javascript">'.$this->_bump(FALSE);
				$out .= '// <![CDATA['.$this->_bump(FALSE).$this->_indent();
				$out .= implode($this->_bump(FALSE).$this->_indent(), $this->inline_js);
				$out .= $this->_bump(FALSE).'// ]]>'.$this->_bump(FALSE);
				$out .= '</script>'.$this->_bump(FALSE);
			}
		}
		
		return $out;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Render JQuery
	 *
	 * Takes all the JQuery items and spits them out in the document.ready function
	 * 
	 * @return	string
	 */
	private function _render_jquery()
	{
		if (count($this->jquery)>0)
	    {
			$out = '<script type="text/javascript" language="javascript">'.$this->_bump(FALSE);
			$out .= '// <![CDATA['.$this->_bump(FALSE);
			$out .= '$(document).ready(function(){'.$this->_bump(FALSE);

			foreach($this->jquery as $code)
			{
				$out .= $this->_indent().$code.$this->_bump(FALSE);
			}

			$out .= '});'.$this->_bump(FALSE);
			$out .= '// ]]>'.$this->_bump(FALSE);
			$out .= '</script>'.$this->_bump(FALSE);

			return $out;
	    }
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Render metadata that was added via add_meta(), packages, or default
	 * 
	 * @return	string
	 */
	private function _render_feed()
	{
		$out = '';
		
		if (is_array($this->feed) && count($this->feed)>0)
		{
			foreach($this->feed as $feed)
			{
				if ( ! is_array($feed) OR count($feed)<2)
				{
					$this->_handle_error('feed item had too few parameters');
				}
				elseif (count($feed) > 3)
				{
					$this->_handle_error('feed item had too many parameters');
				}
				$href = $feed[0];
				$name = $feed[1];
				$rss_or_atom = isset($feed[2]) ? $feed[2] : 'rss';
				$rss_or_atom = strtolower($rss_or_atom);
				
				$out .= '<link href="'.$href.'" type="application/'.$rss_or_atom.'+xml" rel="alternate" title="'.$name.'" />'.$this->_bump(FALSE);
			}
			$out .= $this->_bump(FALSE);
		}
		
		return $out;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Render the misc items
	 */
	private function _render_misc()
	{
		$out = '';
	
		if (count($this->misc)>0)
		{
			foreach ($this->misc as $item)
			{
				$out .= $item.$this->_bump(FALSE);
			}
			$out .= $this->_bump(FALSE);
		}
		
		return $out;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Render the title tag
	 *
	 * @return	string
	 */
	private function _render_title()
	{
		$out = '<title>';
		
		if ($this->title_append)
		{
			$out .= $this->site_title.$this->title_append_str;
		}
		
		$out.= $this->title.'</title>'.PHP_EOL;
		
		return $out;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Render Google Analytics tracking code
	 *
	 * @return 	string
	 */
	private function _render_ga()
	{
		if ($this->ga_tracking_id != '')
		{
			return '
			
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \''.$this->ga_tracking_id.'\']);
  _gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
			';
		}
		
		return null;
	}

	// --------------------------------------------------------------------------
	
	
	
	/**
	 * Handles our error and sees if we want to keep quiet or not
	 * so we don't have to do it a million times.
	 * 
	 * @access	private
	 * @return 	void
	 */
	private function _handle_error($msg)
	{
		log_message('error', __CLASS__ .' --> '.$msg);
		if ($this->show_errors)
		{
			show_error($msg);
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Add defaults to appropriate properties
	 * 
	 * @return	void
	 */
	private function _process_defaults()
	{
		// process defaults
		foreach ($this->defaults as $type => $item)
		{
			$this->_process_item($item, $type);
		}
		
		// process default packages
		if (isset($this->defaults['packages']))
		{
			foreach ((array)$this->defaults['packages'] as $def_package)
			{
				$this->_save_package($def_package);
			}
			
			// process the defaults from the packs property
			$this->_process_packages();
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Process the packages from packs property
	 * 
	 * @return 	void
	 */
	private function _process_packages()
	{
		// get list of un-processed packs
		$packs = array_diff((array)$this->packs, (array)$this->packs_processed);
		
		// process the packages
		foreach ($packs as $pack)
		{
			foreach ($this->packages[$pack] as $type => $item)
			{
				$this->_process_item($item, $type);
			}
			
			// add pack to list of processed packs
			$this->packs_processed[] = $pack;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/*
	 * Save a package name and all it's dependant package's names to the packs property
	 */
	private function _save_package($package)
	{
		// recursively process dependant packages
		if (isset($this->packages[$package]['packages']))
		{
			foreach((array)$this->packages[$package]['packages'] as $dependant_pack)
			{
				$this->_save_package($dependant_pack);
			}
		}
		
		// check if package exists
		if ( ! array_key_exists($package, $this->packages))
		{
			$this->_handle_error("Package '$package' is not declared in config file");
		}
		else
		{
			// only save package if it has not already been saved
			if ( ! is_array($this->packs) OR ! in_array($package, $this->packs))
			{
				$this->packs[] = $package;
			}
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Main processor for all items: css, js, inline_css, inline_js, jquery, misc
	 * 
	 * Takes user input and saves it to the correct property, in a consistent format
	 * 
	 * @param	mixed string or array	item to add to appropriate property
	 *				if array: (type, item, [options])
	 *				if string: wil determine type by file extension,
	 *							only css and js are supported as strings
	 * @return	void
	 * 
	 * SETS THESE VALUES
	 * $this->css[]			string or array
	 * $this->js[]			'filename.js'
	 * $this->inline_css[]	'user-supplied code'
	 * $this->inline_js[]	'user-supplied code'
	 * $this->misc[]		'user-supplied code'
	 * $this->jquery[]		'user-supplied code'
	 * 
	 */
	private function _process_item($item, $type=NULL)
	{
		// ignore type='packages'
		// that type is used to include dependant packages
		if ($type == 'packages') return;
		
		$valid_types = array('css', 'js', 'inline_css', 'inline_js', 'jquery', 'misc', 'meta', 'feed');
		
		// cast item to an array
		$item = (array)$item;
		
		// determine type based on the file's extension
		// if type is numeric, then an indexed array was used
		// this was the prior format, which is supported for css or js files only
		if ($type == NULL OR is_numeric($type))
		{
			$file = is_array($item[0]) ? $item[0][0] : $item[0];
			$elems = explode('.', $file);
			$type = array_pop($elems);
			if ($type != 'css' && $type != 'js')
			{
				$this->_handle_error(__FUNCTION__.': could not determine type for: '.print_r($item, TRUE).'. Item was left out of head.');
				return;
			}
		}
		
		// validate type
		if ( ! in_array($type, $valid_types))
		{
			$this->_handle_error(__FUNCTION__.': type: '.$type.' is not valid');
			return;
		}
		
		// add each item to appropriate property
		foreach ($item as $it)
		{
			// set optional parameters
			// this causes test for in_array to match whether the
			// optional parameter was provided or not
			if ($type=='meta' && ! isset($it[2]))
			{
				$it[2] = 'name';
			}
			elseif ($type=='css')
			{
				if ( ! isset($it[1]))
				{
					$it[1] = 'all';
				}
				elseif ( ! isset($it[2]))
				{
					$it[2] = NULL;
				}
			}
			elseif ($type=='feed' && ! isset($it[2]))
			{
				$it[2] = 'rss';
			}
			// DO NOT add duplicate items
			if (is_array($this->{$type})
				&& in_array($it, $this->{$type}))
			{
				continue;
			}
			$this->{$type}[] = $it;
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Provides the bump so we can still have nice and pretty head spacing
	 *
	 * @access	private
	 * @param	string [$new_line] should we add a new line in there?
	 * @return	string
	 */
	private function _bump($new_line = TRUE)
	{
		if ($new_line)
		{
		return '
		
	';		}
		else
		{
		return '
	';		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Return indents; use for formatting html output
	 * 
	 * @param	int		# of indents to return
	 * @return	string	
	 */
	private function _indent($times=1)
	{
		$indent = "\t";
		$out = '';
		for ($i=$times; $i>0; $i--)
		{
			$out .= $indent;
		}
		return $out;
	}

	// --------------------------------------------------------------------------
	
	/**
	* Convert user-provided link into a link that can be used in the HTML
	*
	* link with leading '/', will prepend with domain name.
	* Link with URL will not be changed.
	*
	* @access	private
	* @param	string file (can be url, relative, or absolute)
	* @param	string type (can be 'css', 'js', 'favicon')
	* @return   string
	*/
	private function _get_link($file, $type)
	{
		// this regex patter was taken from carabiner library
		$pattern = '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@';
		if (preg_match($pattern, $file))
		// is URL
		{
			return $file;
		}
		elseif (substr($file, 0, 1) == '/')
		// is absolute
		{
			return $file;
		}
		elseif ($type == 'css')
		// css in default location
		{
			return $this->base_url.$this->css_location.$file;
		}
		elseif ($type == 'js')
		// javascript in default location
		{
			return $this->base_url.$this->js_location.$file;
		}
		elseif ($type == 'favicon')
		// favicon in default location
		{
			return $this->base_url.$file;
		}
		else
		// INVALID parameters
		{
			log_message('error', __METHOD__.' --> '.'invalid parameters: file['.$file.'] type'.$type.']');
			return NULL;
		}
	}

	// --------------------------------------------------------------------------	
	
	/**
	 * Checks the doctype and makes sure the stuff needed in the head is there
	 *
	 * @return 	TRUE on ok, string (ul of errors) if not ok
	 */
	private function _check_head()
	{
		show_error('debug does not work with the current version of Head library');
	
		$errors = '';
	
		//Check all the links for CSS
		foreach((array)$this->css as $css)
		{
			$file = is_array($css) ? $css[0] : $css;
			if ( ! file_exists($this->_get_link($file, 'css')))
			{
				$errors .= '<li>'.$file.' not found</li>';
			}
		}

		//Check all the links for JS
		foreach((array)$this->js as $js)
		{
			$file = is_array($js) ? $js[0] : $js;
			if ( ! file_exists($this->_get_link($file, 'js')))
			{
				$errors .= '<li>'.$file.' not found</li>';
			}
		}
		
		//Check for favicon
		if ($this->use_favicon)
		{
			if ( ! file_exists($this->_get_link($this->favicon_location), 'favicon'))
			{
				$errors .= '<li>Favicon not found</li>';
			}
		}
		
		if (trim($errors))
		{
			show_error('The following errors were encountered in the head area: <ul>'.$errors.'</ul>');
		}
	}

	// --------------------------------------------------------------------------
}

/* End of file Head.php */
/* Location: ./application/libraries/Head.php */
