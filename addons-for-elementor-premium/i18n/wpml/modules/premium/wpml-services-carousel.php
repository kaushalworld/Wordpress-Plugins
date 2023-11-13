<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Services_Carousel
     */
    class LAE_WPML_Services_Carousel extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'services';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('service_title', 'service_subtitle', 'service_excerpt', 'button_text', 'button_url' => array('url'));
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'service_title':
                    return esc_html__('Service: Title', 'livemesh-el-addons');

                case 'service_subtitle':
                    return esc_html__('Service: Subtitle', 'livemesh-el-addons');

                case 'button_text':
                    return esc_html__('Service: Button Text', 'livemesh-el-addons');

                case 'url':
                    return esc_html__('Service: Link URL', 'livemesh-el-addons');

                case 'service_excerpt':
                    return esc_html__('Service: Excerpt', 'livemesh-el-addons');

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
                case 'service_title':
                case 'button_text':
                case 'service_subtitle':
                    return 'LINE';

                case 'url':
                    return 'LINK';

                case 'service_excerpt':
                    return 'AREA';

                default:
                    return '';
            }
        }

    }

}