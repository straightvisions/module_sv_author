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
			
			add_shortcode($this->get_module_name(), array($this, 'shortcode'));
			
			add_action('after_setup_theme', array($this, 'enable_author_archives_for_trainers_only')); // remove WC action
			add_action('template_redirect', array($this, 'template_redirect')); // allow profile pages for trainers only
		}
		public function enable_author_archives_for_trainers_only(){
			remove_action('template_redirect', 'wc_disable_author_archives_for_customers');
		}
		public function template_redirect(){
			if(isset($this->get_root()->get_instances()['sv_bb_dashboard']) && get_current_user_id()){
				$dashboard_user							= $this->get_root()->get_instances()['sv_bb_dashboard']->query->trainers->get(get_current_user_id());
				if($dashboard_user && $dashboard_user->get_meta('bb_trainer') != '1'){
					wp_redirect(get_site_url());
				}
			}
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
			include($this->get_path('lib/tpl/frontend.php'));
			$output									= ob_get_contents();
			ob_end_clean();
			
			return $output;
		}
	}
?>