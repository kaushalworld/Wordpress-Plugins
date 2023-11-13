<?php

namespace ShopEngine_Pro\Modules\Comparison;

use ShopEngine\Core\Register\Module_List;
use ShopEngine\Modules\Comparison\Comparison_Share;

class Comparison_Support {

	public function init() {
		$settings = Module_List::instance()->get_active_settings( 'comparison' );

		if ( ! is_admin() && ! empty( $settings ) ) {
			$this->comparison_endpoint();

			add_action('wp_footer', function () {
				$this->comparison_bar_on_bottom();
			}, 100);

		}
	}

	public function comparison_endpoint() {

		add_action( 'init', function () {
			add_rewrite_rule( 'comparison', 'index.php?comparison=yes', 'top' );
		} );

		flush_rewrite_rules();

		add_filter( 'query_vars', function ( $query_vars ) {
			$query_vars[] = 'comparison';

			return $query_vars;
		} );

		add_action( 'template_redirect', function () {
			if ( get_query_var( 'comparison' ) ) {
				add_filter( 'template_include', function () {
					Comparison_Share::init();
				} );
			}
		} );
	}


	public function comparison_bar_on_bottom() {

		add_filter( 'post_link', [$this, 'nhs_custom_case_studies_permalink_post'], 10, 3 );

		$url = home_url('?comparison=yes') ; 

		$settings = Module_List::instance()->get_settings( 'comparison' )['show_bottom_bar']['value'] ?? null;

		if ( $settings == 'yes' && isset($_SERVER['REQUEST_URI']) && (strpos(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])), 'comparison') === false)) {
			?>

            <div class="shopengine-comparison-bottom-bar" hidden>
                <div class="shopengine-comparison-button-area" id="shopengine-comparison-button">
                    <a title="<?php esc_attr_e('Product Comparison', 'shopengine-pro')?>" class="comparison-endpoint-bottom" data-comparison-url="<?php echo esc_url($url)  ?>" hidden>  <i class="eicon-frame-expand"></i> </a>
                    <a title="<?php esc_attr_e('Product Comparison', 'shopengine-pro')?>" class="comparison-bottom-bar-toggle"> <?php echo esc_html__("Compare Products", 'shopengine-pro') ?>  </a>
                </div>

                <div class="shopengine-comparison-box" id="shopengine-comparison-bottom-content">

                </div>
            </div>
			<?php
		}
	}

}