<?php

namespace ShopEngine_Pro\Modules\Product_Size_Charts;

use ShopEngine\Core\Register\Module_List;
use ShopEngine_Pro\Traits\Singleton;

class Product_Size_Charts {

	use Singleton;

	const OPTION_STATUS_KEY = 'shopengine_product_chart_status';
	const OPTION_KEY        = 'shopengine_product_chart';

	public function init() {

		new Route;
		add_action('admin_enqueue_scripts', [$this, 'add_admin_enqueue']);
		add_filter('woocommerce_product_data_tabs', [$this, 'tab']);
		add_action('woocommerce_product_data_panels', [$this, 'tab_content'], 100);
		add_action('woocommerce_process_product_meta', [$this, 'save_tab_data']);
	}

	public function add_admin_enqueue() {
		wp_enqueue_media();
		wp_enqueue_style('product-size-charts-css', \ShopEngine_Pro::module_url() . 'product-size-charts/assets/css/product-size-charts.css', [], \ShopEngine_Pro::version());
		wp_enqueue_script('product-size-charts-js', \ShopEngine_Pro::module_url() . 'product-size-charts/assets/js/product-size-charts.js', [
			'jquery'
		]);
	}

	/**
	 * @param $tabs
	 * @return mixed
	 */
	public function tab($tabs) {
		$tabs['shopengine_product_size_charts'] = [
			'label'    => 'Size Charts',
			'target'   => 'shopengine_product_size_charts',
			'priority' => 10
		];

		return $tabs;
	}

	public function tab_content() {

		global $post;

		$settings = Module_List::instance()->get_settings('product-size-charts');
		$options  = [__('-- select one --', 'shopengine-pro')];

		if (isset($settings['charts']['value']) && is_array($settings['charts']['value'])) {
			foreach ($settings['charts']['value'] as $value) {
				$options[$value['_uid']] = $value['title'];
			}
		}
	?>
	<div id="shopengine_product_size_charts" class="panel woocommerce_options_panel">
		<div class="options_group shopengine_product_size_charts-content care_instruction">
			<?php

			$status_value  = get_post_meta($post->ID, self::OPTION_STATUS_KEY, true);
			$wrapper_class = $status_value == 'yes' ? "" : "se-hidden";

			woocommerce_wp_checkbox([
				'id'          => self::OPTION_STATUS_KEY,
				'label'       => esc_html__('Product Chart', 'shopengine-pro'),
				'value'       => $status_value,
				'description' => esc_html__('Enable Product Chart', 'shopengine-pro')
			]);

			woocommerce_wp_select([
				'id'            => self::OPTION_KEY,
				'label'         => esc_html__('Chart', 'shopengine-pro'),
				'options'       => $options,
				'value'         => get_post_meta($post->ID, self::OPTION_KEY, true),
				'wrapper_class' => $wrapper_class . ' se-hidden-field'
			]);
			?>
			<p><?php esc_html_e('Click on this link to create a new chart', 'shopengine-pro')?> <a title="<?php esc_attr_e('Product Size Chart', 'shopengine-pro')?>" href="<?php echo esc_url(get_admin_url()) . 'edit.php?post_type=shopengine-template#shopengine-modules' ?>"><?php esc_html_e('Link', 'shopengine-pro')?></a></p>
		</div>
	</div>
	<?php
	}

	/**
	 * @param $product_id
	 */
	public function save_tab_data($product_id) {
		
		if(!isset($_POST['_wpnonce']) || !isset($_POST['post_ID']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])),'update-post_'.sanitize_text_field(wp_unslash($_POST['post_ID'])))){
			return false;
		}

		if (isset($_POST[self::OPTION_STATUS_KEY])) {
			$status = sanitize_text_field(wp_unslash($_POST[self::OPTION_STATUS_KEY]));
		} else {
			$status = 'no';
		}

		update_post_meta(
			$product_id,
			self::OPTION_STATUS_KEY,
			$status
		);

		if (isset($_POST[self::OPTION_KEY])) {
			update_post_meta(
				$product_id,
				self::OPTION_KEY,
				sanitize_text_field(wp_unslash($_POST[self::OPTION_KEY]))
			);
		}
	}
}