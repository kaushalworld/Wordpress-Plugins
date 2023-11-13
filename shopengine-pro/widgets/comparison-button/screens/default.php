<?php defined('ABSPATH') || exit;

// button settings
$btn_text			= !empty($shopengine_comparison_btn_text) ? $shopengine_comparison_btn_text : '';
$icon				= !empty($shopengine_comparison_btn_icon) ? $shopengine_comparison_btn_icon : '';
$icon_position		= !empty($shopengine_comparison_btn_icon_position) ? $shopengine_comparison_btn_icon_position : 'left';
$show_counter		= !empty($shopengine_comparison_btn_show_counter) ? $shopengine_comparison_btn_show_counter : '';
$counter_position	= !empty($shopengine_comparison_btn_counter_position) ? $shopengine_comparison_btn_counter_position : 'right';
$show_counter_badge	= !empty($shopengine_comparison_btn_show_counter_badge) ? $shopengine_comparison_btn_show_counter_badge : '';
$comparison_lists	= !empty($_COOKIE['shopengine_comparison_id_list']) ? explode(',', sanitize_text_field(wp_unslash($_COOKIE['shopengine_comparison_id_list']))) : [];
$total_products		= count(array_filter($comparison_lists));
$counter_class		= ($show_counter_badge === 'yes') ? 'shopengine-comparison-counter comparison-counter-badge' : 'shopengine-comparison-counter';

// button attributes
$this->add_render_attribute('button', 'href', '#');
$this->add_render_attribute('button', 'data-payload', '{"pid":0}');
$this->add_render_attribute('button', 'class', 'shopengine_comparison_add_to_list_action comparison-button');

// counter attributes
$this->add_render_attribute('counter', 'class', 'shopengine-comparison-counter');
if($show_counter_badge === 'yes') {
	$this->add_render_attribute('counter', 'class', 'comparison-counter-badge');
}
?>

<div class="shopengine-comparison-button">

	<a title="<?php esc_html_e('Product Comparison', 'shopengine-pro')?>" <?php $this->print_render_attribute_string('button'); ?>>
		<?php if($show_counter === 'yes' && $counter_position === 'left') : ?>
			<span <?php $this->print_render_attribute_string('counter'); ?>><?php echo esc_html($total_products); ?></span>
		<?php endif; ?>

		<?php if($icon_position === 'left') :
			\Elementor\Icons_Manager::render_icon($icon, ['aria-hidden' => 'true']);
		endif; ?>

		<?php if(!empty($btn_text)) :
			echo esc_html($btn_text);
		endif; ?>

		<?php if($icon_position === 'right') :
			\Elementor\Icons_Manager::render_icon($icon, ['aria-hidden' => 'true']);
		endif; ?>

		<?php if($show_counter === 'yes' && $counter_position === 'right') : ?>
			<span <?php $this->print_render_attribute_string('counter'); ?>><?php echo esc_html($total_products); ?></span>
		<?php endif; ?>
	</a>

</div>
