<?php defined('ABSPATH') || exit;?>

<div class="shopengine-vacation-module-container">
	<div class="shopengine-vacation-module-header">
		<?php if (!empty($settings['shopengine_vacation_title'])) {?>
			<h1><?php echo esc_html($settings['shopengine_vacation_title']) ?> <span class="shopengine-notification-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" viewBox="0 0 16 18" fill="none">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M8.01941 13.3857C12.2488 13.3857 14.2054 12.8432 14.3944 10.6654C14.3944 8.4891 13.0303 8.62904 13.0303 5.95883C13.0303 3.87311 11.0533 1.5 8.01941 1.5C4.98549 1.5 3.00854 3.87311 3.00854 5.95883C3.00854 8.62904 1.64441 8.4891 1.64441 10.6654C1.83412 12.8514 3.79074 13.3857 8.01941 13.3857Z" stroke="<?php echo esc_attr($vacation_icon_color) ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			<path opacity="0.4" d="M9.81101 15.6429C8.78791 16.779 7.1919 16.7925 6.15901 15.6429" stroke="<?php echo esc_attr($vacation_icon_color) ?>"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
			</span>
			</h1>
		<?php }?>
		<p><?php echo esc_html($settings['shopengine_vacation_message']) ?></p>
	</div>
	<div class="shopengine-vacation-module-footer">
	<?php if ($settings['shopengine_show_vacation_holiday'] === 'yes'): ?>
		<div class="vacation-holidays">
			<h6><?php echo esc_html($settings['shopengine_vacation_holiday_title']) ?></h6>
			<?php
			$days = [
				'sun' => esc_html__('Sunday', 'shopengine-pro'),
				'mon' => esc_html__('Monday', 'shopengine-pro'),
				'tue' => esc_html__('Tuesday', 'shopengine-pro'),
				'wed' => esc_html__('Wednesday', 'shopengine-pro'),
				'thu' => esc_html__('Thursday', 'shopengine-pro'),
				'fri' => esc_html__('Friday', 'shopengine-pro'),
				'sat' => esc_html__('Saturday', 'shopengine-pro')
			];
			?>
			<?php foreach ($vacation_days as $day): ?>
			<button title="<?php echo esc_attr($vacation->notice_days_title) ?>"><?php echo esc_html($days[$day]) ?></button>
			<?php endforeach;?>
		</div>
		<?php endif;?>
		<?php if ($settings['shopengine_vacation_emergency_title'] || $settings['shopengine_vacation_mail']): ?>
		<div class="vacation-emergency">
			<h6><?php echo esc_html($settings['shopengine_vacation_emergency_title']) ?></h6>
			<p><a title="<?php esc_html_e('Emergency Contact Mail', 'shopengine-pro')?>" href="mailto:<?php echo esc_html($settings['shopengine_vacation_mail']) ?>"><?php echo esc_html($settings['shopengine_vacation_mail']) ?></a></p>
		</div>
		<?php endif;?>
	</div>
</div>
