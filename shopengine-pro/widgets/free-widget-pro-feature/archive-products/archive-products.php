<?php

namespace ShopEngine_Pro\Widgets\Free_Widget_Pro_Feature\Archive_Products;

use ShopEngine\Core\Elementor_Controls\Controls_Manager;

defined( 'ABSPATH' ) || exit;

class Archive_Products
{
    /**
     * @param $controls
     */
    public static function content( $controls )
    {
		$controls->add_control(
			'shopengine_show_off_tag',
			[
				'label'     => esc_html__('Show Off Price Tag', 'shopengine-pro'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'shopengine-pro'),
				'label_off' => esc_html__('Hide', 'shopengine-pro'),
				'default'   => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopengine-archive-products .price .shopengine-discount-badge' => 'display: block;',
				],
			]
		);
    }
}
