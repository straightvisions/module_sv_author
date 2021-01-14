<?php
	namespace sv100;

	class sv_author extends init {
		public function init() {
			$this->set_module_title( 'SV Author' )
				->set_module_desc( __( 'Author Template and Settings', $this->get_module_name() ) )
				->load_settings()
				->set_section_title( __( 'Author', 'sv100' ) )
				->set_section_desc( __( 'Author Settings', 'sv100' ) )
				->set_section_type( 'settings' )
				->set_section_icon('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20.822 18.096c-3.439-.794-6.64-1.49-5.09-4.418 4.72-8.912 1.251-13.678-3.732-13.678-5.082 0-8.464 4.949-3.732 13.678 1.597 2.945-1.725 3.641-5.09 4.418-3.073.71-3.188 2.236-3.178 4.904l.004 1h23.99l.004-.969c.012-2.688-.092-4.222-3.176-4.935z"/></svg>')
				->disable_pagination()
				->get_root()
				->add_section( $this );

			// Shortcodes
			add_shortcode( $this->get_module_name(), array( $this, 'shortcode' ) );

			$this->get_script('common')
				->set_path( 'lib/css/common.css' )
				->set_inline(true);
		}

		protected function load_settings(): sv_author {
			// Breakpoints
			$this->get_setting('disable_pagination')
				->set_title(__('Disable Pagination', 'sv100'))
				->set_description(__('Paginated Subpages will redirect to main author page', 'sv100'))
				->load_type('checkbox');

			return $this;
		}

		public function load( $settings = array(), $content = '' ) {
			$settings								= shortcode_atts(
				array(
					'inline'						=> true
				),
				$settings,
				$this->get_module_name()
			);

			// Load Styles
			$this->get_script('common')
				->set_inline($settings['inline'])
				->set_is_enqueued();

			ob_start();
			include( $this->get_path( 'lib/tpl/frontend.php' ) );
			$output									= ob_get_contents();
			ob_end_clean();

			return $output;
		}
		protected function disable_pagination(){
			if($this->get_setting('disable_pagination')->get_data()){
				add_action('pre_get_posts', array($this,'disable_pagination_remove_query'));
				add_action( 'template_redirect', array($this,'disable_pagination_add_redirects') );
			}

			return $this;
		}
		public function disable_pagination_remove_query($query){
			if ( is_author() && $query->is_main_query() ) {
				$query->set('no_found_rows', true);
			}
		}
		public function disable_pagination_add_redirects(){
			global $paged, $page;
			if ( is_author () && ( $paged >= 2 || $page >= 2 ) ) {
				$url = get_author_posts_url( get_the_author_meta ( 'ID' ) );
				wp_redirect( $url , '301' );
				die();
			}
		}
	}