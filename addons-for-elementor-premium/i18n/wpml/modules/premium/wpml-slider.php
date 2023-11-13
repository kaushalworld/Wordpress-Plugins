<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Slides
     */
    class LAE_WPML_Slider extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'slides';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('slide_title', 'slide_content');
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'slide_title':
                    return esc_html__('Slide: Title', 'livemesh-el-addons');

                case 'slide_content':
                    return esc_html__('Slide: Content', 'livemesh-el-addons');

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
                case 'slide_title':
                    return 'LINE';

                case 'slide_content':
                    return 'VISUAL';

                default:
                    return '';
            }
        }

    }

}
