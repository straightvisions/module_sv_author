<?php
namespace sv_100;

/**
 * @version         1.00
 * @author			straightvisions GmbH
 * @package			sv_100
 * @copyright		2017 straightvisions GmbH
 * @link			https://straightvisions.com
 * @since			1.0
 * @license			See license.txt or https://straightvisions.com
 */

class sv_author extends init {
	public function __construct() {

	}

	public function init() {
		// Module Info
		$this->set_module_title( 'SV Author' );
		$this->set_module_desc( __( 'This module gives the ability to display author pages via the "[sv_author]" shortcode.', $this->get_module_name() ) );

		// Shortcodes
		add_shortcode( $this->get_module_name(), array( $this, 'shortcode' ) );

		$this->scripts_queue['frontend']			= static::$scripts->create( $this )
			->set_ID('frontend')
			->set_path( 'lib/css/frontend.css' )
			->set_inline(true);
	}

	public function shortcode( $settings, $content = '' ) {
		$settings								= shortcode_atts(
			array(
				'inline'						=> true
			),
			$settings,
			$this->get_module_name()
		);

		// Load Styles
		$this->scripts_queue['frontend']
			->set_inline($settings['inline'])
			->set_is_enqueued();

		ob_start();
		include( $this->get_path( 'lib/tpl/frontend.php' ) );
		$output									= ob_get_contents();
		ob_end_clean();

		return $output;
	}
}