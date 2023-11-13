<?php

defined('ABSPATH') || exit;

$avatar = ShopEngine_Pro\Modules\Avatar\Avatar::instance();
if (isset($avatar->settings['avatar']['status']) && $avatar->settings['avatar']['status'] == 'active') :

	$current_user = wp_get_current_user();
	$user_id      = $current_user->ID;
	$user_email = $current_user->user_email ? $current_user->user_email : '';
	$max_size = empty($avatar->settings['avatar']['settings']['max_size']['value']) ? 500 : $avatar->settings['avatar']['settings']['max_size']['value'];
	$svae_btn_text = $settings['shopengine_avatar_save_btn_text'];
	$editor = \Elementor\Plugin::$instance->editor->is_edit_mode() ? 'yes' : '';
	$random = uniqid();
?>

	<div class="shopengine-avatar-container" data-editor="<?php echo esc_attr($editor); ?>">
		<form action="<?php echo esc_url(admin_url('admin-ajax.php?action=shopengine_avatar')); ?>" method="post" enctype="multipart/form-data" id="upload-form">
			<div class="shopengine-avatar" data-thumbsize="<?php echo esc_attr($max_size); ?>">
				<div class="shopengine-avatar__thumbnail">
					<div class="shopengine-avatar__thumbnail--overlay-close" id="shopengine_avatar_image_cancel_button">
						<?php \Elementor\Icons_Manager::render_icon($settings['shopengine_avatar_image_cancel_button_icon'], ['aria-hidden' => 'true']); ?>
					</div>
					<div class="shopengine-avatar__thumbnail--overlay"></div>
					<?php echo get_avatar($user_id, '100'); ?>
					<label for="<?php echo esc_attr($random); ?>" class="shopengine-avatar__thumbnail--btn">
						<?php \Elementor\Icons_Manager::render_icon($settings['shopengine_avatar_upload_icon'], ['aria-hidden' => 'true']); ?>
					</label>
					<input id="<?php echo esc_attr($random); ?>" type="file" class="shopengine_avatar_image" name="shopengine_avatar_image">
					<?php wp_nonce_field('shopengine-avatar', 'shopengine-nonce'); ?>
				</div>
				<div class="shopengine-avatar__info">
					<h3 class="shopengine-avatar__info--name"><?php echo wp_kses_post($current_user->display_name, 'shopengine-pro') ?></h3>
					<?php if (!empty($user_email)) : ?>
						<p class="shopengine-avatar__info--email"><?php esc_html_e($user_email, 'shopengine-pro'); ?></p>
					<?php endif; ?>
					<input type="submit" class="shopengine-avatar__info--btn" value="<?php esc_attr_e($svae_btn_text, 'shopengine-pro') ?>">
				</div>
			</div>
		</form>
	</div>

<?php endif; ?>