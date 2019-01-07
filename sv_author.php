<?php
namespace sv_100;

/**
 * @author			Matthias Reuter
 * @package			sv_100
 * @copyright		2017 Matthias Reuter
 * @link			https://straightvisions.com
 * @since			1.0
 * @license			See license.txt or https://straightvisions.com
 */
class sv_author extends init{
	static $scripts_loaded						= false;

	public function __construct($path,$url){
		$this->path								= $path;
		$this->url								= $url;
		$this->name								= get_class($this);
	}

	public function init() {
		add_shortcode($this->get_module_name(), array($this, 'shortcode'));
	}

	public function shortcode($settings, $content=''){
		$settings								= shortcode_atts(
			array(
				'inline'						=> true
			),
			$settings,
			$this->get_module_name()
		);
		$this->module_enqueue_scripts($settings['inline']);

		ob_start();
		include($this->get_file_path('lib/tpl/frontend.php'));
		$output									= ob_get_contents();
		ob_end_clean();

		return $output;
	}
}