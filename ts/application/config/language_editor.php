<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Config file for CodeIgniter frontend language files editor.
 *
 * @author		Anoop Singh
 */

/*
 * Comments on/off
 *
 * This part allow you to enable/disable comments in language files editor.
 * To enable comments set $config['comments']=1
 *
 * If you don't want them show up front when editing files set $config['comments_show']=0;
 * You can show/hide comments while editing file.
 */
$config['comments'] = 1;
$config['comments_show'] = 0;

/*
 * Pattern on/off
 *
 * This part allow you to enable/disable the visibility of translation for key
 * from main language as a pattern.
 * You need also define which language is your "pattern" by setting the name of
 * that language to $config['language_pattern_lang'];
 */
$config['language_pattern'] = 1;
$config['language_pattern_lang'] = 'english';

/* End of file language_editor.php */
/* Location: ./application/config/language_editor.php */
