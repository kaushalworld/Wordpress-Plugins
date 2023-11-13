<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Features
     */
    class LAE_WPML_Features extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'features';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('feature_title', 'feature_subtitle', 'feature_text');
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'feature_title':
                    return esc_html__('Features: Title', 'livemesh-el-addons');

                case 'feature_subtitle':
                    return esc_html__('Features: Subtitle', 'livemesh-el-addons');

                case 'feature_text':
                    return esc_html__('Features: Description', 'livemesh-el-addons');

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
                case 'feature_title':
                case 'feature_subtitle':
                    return 'LINE';

                case 'feature_text':
                    return 'VISUAL';

                default:
                    return '';
            }
        }

    }

}
