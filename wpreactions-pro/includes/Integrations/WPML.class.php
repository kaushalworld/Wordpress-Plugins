<?php

namespace WPRA\Integrations;

class WPML {

	static function register_package_actions($options, $id = 0) {
		$package = self::get_package($id);

		if (isset($options['flying']['labels'])) {
			foreach ($options['flying']['labels'] as $emoji_id => $label) {
				do_action(
					'wpml_register_string',
					$label,
					"flying_labels_$emoji_id",
					$package,
					__("Emoji Label - $emoji_id", 'wpreactions'),
					'LINE'
				);
			}
		}

		if (isset($options['title_text'])) {
			do_action(
				'wpml_register_string',
				$options['title_text'],
				'title_text',
				$package,
				__('Call to Action', 'wpreactions'),
				'LINE'
			);
		}

		if (isset($options['total_counts_label'])) {
			do_action(
				'wpml_register_string',
				$options['total_counts_label'],
				'total_counts_label',
				$package,
				__('Overall Counts Label', 'wpreactions'),
				'LINE'
			);
		}

		if ($options['layout'] == 'button_reveal') {
			do_action(
				'wpml_register_string',
				$options['reveal_button']['text'],
				'reveal_button_text',
				$package,
				__( 'Reaction Button - Primary Call to Action', 'wpreactions' ),
				'LINE'
			);
			do_action(
				'wpml_register_string',
				$options['reveal_button']['text_clicked'],
				'reveal_button_text_clicked',
				$package,
				__('Reaction Button - Social Share Call to Action', 'wpreactions'),
				'LINE'
			);
			do_action(
				'wpml_register_string',
				$options['reveal_button']['popup_header'],
				'reveal_button_popup_header',
				$package,
				__('Reaction Button - Social Popup Header text', 'wpreactions'),
				'LINE'
			);
		}
	}

	static function getTranslation($id, $param, $value) {
		return esc_html(apply_filters( 'wpml_translate_string', $value, $param, self::get_package($id)));
	}

	public static function get_package($id = 0) {
		$package = [
			'kind' => 'WP Reactions Pro',
			'edit_link' => '',
			'view_link' => '',
		];
		if ($id == 0) {
			return array_merge($package, [
				'name' => 'wpra-global',
				'title' => 'Global Activation',
			]);
		}
		return array_merge($package, [
			'name' => 'wpra-shortcodes-' . $id,
			'title' => 'Shortcode ' . $id,
		]);
	}
}