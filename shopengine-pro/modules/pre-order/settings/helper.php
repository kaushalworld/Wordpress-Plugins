<?php


namespace ShopEngine_Pro\Modules\Pre_Order\Settings;


class Helper {

	public static function wc_date_picker_field( $field ) {

		$field['type']          = 'date';
		$field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
		$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
		$field['class']         = isset( $field['class'] ) ? $field['class'] : 'short';
		$field['style']         = isset( $field['style'] ) ? $field['style'] : '';
		$field['value']         = isset( $field['value'] ) ? $field['value'] : '';
		$field['description']   = isset( $field['description'] ) ? $field['description'] : '';

		$custom_attributes = [];
		if ( isset( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) ) {

			foreach ( $field['custom_attributes'] as $attribute => $value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
			}
		}

		echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '">
		<label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label>'; ?>

        <input type="date"
               name="<?php echo esc_attr( $field['name'] ) ?>"
               id="<?php echo esc_attr( $field['id'] ) ?>"
               value="<?php echo esc_attr( $field['value'] ) ?>"
               class="<?php echo esc_attr( $field['class'] ) ?>"
               style="<?php echo esc_attr( $field['style'] ) ?>"
               pattern="\d{4}-\d{2}-\d{2}"
               data-date="<?php echo esc_attr( $field['value'] ) ?>"
			<?php echo esc_attr(implode( ' ', $custom_attributes )) ?>
        />

		<?php

		if ( ! empty( $field['description'] ) ) {
			echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
		}

		echo '</p>';
	}

}