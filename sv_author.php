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

class sv_author extends init {
	static $scripts_loaded						= false;

	public function __construct() {

	}

	public function init() {
		$this->set_module_title( 'SV Author' );
		$this->set_module_desc( 'This module gives the ability to manage and display author pages via the "[sv_author]" shortcode.' );

		add_shortcode( $this->get_module_name(), array( $this, 'shortcode' ) );
	}

	public function shortcode( $settings, $content = '' ) {
		$settings								= shortcode_atts(
			array(
				'inline'						=> true
			),
			$settings,
			$this->get_module_name()
		);
		$this->module_enqueue_scripts( $settings['inline'] );

		ob_start();
		include( $this->get_file_path( 'lib/tpl/frontend.php' ) );
		$output									= ob_get_contents();
		ob_end_clean();

		return $output;
	}
}