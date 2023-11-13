<img class="shopengine-avatar-close" alt="<?php esc_attr_e('Avatar', 'shopengine-pro'); ?>" src="<?php echo esc_url(\ShopEngine_Pro::module_url() . 'avatar/assets/img/remove.png') ?>">
<label for="shopengine_avatar_image" class='shopengine-avatar'>
      <img alt="<?php esc_attr_e('Uploaded Avatar', 'shopengine-pro'); ?>" src="<?php echo esc_url(\ShopEngine_Pro::module_url() . 'avatar/assets/img/image-upload.png') ?>">
</label>
<?php wp_nonce_field('shopengine-avatar', 'shopengine-nonce');  ?>
<input type="file" id="shopengine_avatar_image" name="shopengine_avatar_image" class="shopengine-avatar-input">
<span><?php esc_html_e('Profile picture max size ', 'shopengine-pro');
      echo sprintf(__('%s KB', 'shopengine-pro'),esc_html(empty($this->settings['avatar']['settings']['max_size']['value']) ? 500 : $this->settings['avatar']['settings']['max_size']['value'])) ?></span>