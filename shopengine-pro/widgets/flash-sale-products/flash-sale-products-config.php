<?php

namespace Elementor;

use ShopEngine\Core\Register\Module_List;

defined('ABSPATH') || exit;

class ShopEngine_Flash_Sale_Products_Config extends \ShopEngine\Base\Widget_Config{

    public function get_name() {
		return 'flash-sale-products';
	}

	public function get_title() {
		return esc_html__('Flash Sale Products', 'shopengine-pro');
	}

	public function get_icon() {
		return 'shopengine-widget-icon shopengine-icon-archive_products';
	}

	public function get_categories() {
		return ['shopengine-general'];
	}

	public function get_keywords() {
		return ['woocommerce', 'shopengine', 'flash sale products', 'sale', 'product'];
	}

	public function get_flash_sale_list() {

		$data = [];
		$module_list = \ShopEngine\Core\Register\Module_List::instance();
		if($module_list->get_list()['flash-sale-countdown']['status'] === 'active'):
			$module_settings = $module_list->get_settings('flash-sale-countdown');
			foreach($module_settings['flash_sale']['value'] as $value) {
				if(isset($value['uid'])) {
					$data[$value['uid']] = !empty($value['campaign_title']) ? $value['campaign_title'] : $value['start_date'];
				}else {
					$data[] = !empty($value['campaign_title']) ? $value['campaign_title'] : $value['start_date'];
				}
			}
		endif;
		return $data;
	}

	public function get_template_territory() {
		return [];
	}
}
