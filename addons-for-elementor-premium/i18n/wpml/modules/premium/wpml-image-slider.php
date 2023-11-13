<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Image_Slider
     */
    class LAE_WPML_Image_Slider extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'image_slides';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('heading', 'subheading', 'button_text', 'button_url' => array('url'));
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'heading':
                    return esc_html__('Image Slide: Caption Heading', 'livemesh-el-addons');

                case 'subheading':
                    return esc_html__('Image Slide: Subheading', 'livemesh-el-addons');

                case 'button_text':
                    return esc_html__('Image Slide: Caption Button Text', 'livemesh-el-addons');

                case 'url':
                    return esc_html__('Image Slide: Link URL', 'livemesh-el-addons');

                default:
                    return '';
            }
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_editor_type($field) {
            switch ($field) {
                case 'heading':
                case 'button_text':
                case 'subheading':
                    return 'LINE';

                case 'url':
                    return 'LINK';

                default:
                    return '';
            }
        }

    }

}