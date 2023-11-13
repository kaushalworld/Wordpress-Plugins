<?php

namespace ShopEngine_Pro\Modules\Badge;

use ShopEngine\Core\Register\Module_List;

class Product_Tab
{
	const OPTION_KEY = 'shopengine_product_badge';

	public function init()
	{
		add_filter('woocommerce_product_data_tabs', [$this, 'new_tab']);
		add_action('woocommerce_product_data_panels', [$this, 'tab_panel'], 100);
		add_action('woocommerce_process_product_meta', [$this, 'save_tab_product_meta']);
	}

	public function new_tab($tabs)
	{
		$tabs['shopengine_badge_tab'] = [
			'label'    => 'Shopengine Badge',
			'target'   => 'shopengine_badge_tab_data',
			'priority' => 10
		];
		return $tabs;
	}

	public function tab_panel()
	{
		global $post;
		$settings = Module_List::instance()->get_settings('badge');
		$options  = [__('-- Select One --', 'shopengine-pro')];
		
		if (isset($settings['badges']['value']) && is_array($settings['badges']['value'])) {
			foreach ($settings['badges']['value'] as $value) {
				if(isset($value['_uid'])){
					$options[$value['_uid']] = isset($value['title']) ? $value['title'] : "";
				}
			}
		}
	?>

	<div id="shopengine_badge_tab_data" class="panel woocommerce_options_panel">
		<div class="options_group">
			<?php
			woocommerce_wp_select([
				'id'            => self::OPTION_KEY,
				'label'         => esc_html__('Select badges', 'shopengine-pro'),
				'options'       => $options,
				'value'         => get_post_meta($post->ID, self::OPTION_KEY, true),
				'wrapper_class' => 'se-hidden-field'
			]);
			?>
		</div>
	</div>

	<?php
	}

	public function save_tab_product_meta($post_id)
	{
		if (isset($_POST[self::OPTION_KEY]) &&
			isset($_POST['_wpnonce']) &&
			isset($_POST['post_ID']) && 
			wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])),'update-post_'.sanitize_text_field(wp_unslash($_POST['post_ID'])))
			) {				
				update_post_meta($post_id, self::OPTION_KEY, sanitize_text_field(wp_unslash($_POST[self::OPTION_KEY])));
		}
	}
}
