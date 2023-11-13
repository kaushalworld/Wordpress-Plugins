<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_FAQ
     */
    class LAE_WPML_FAQ extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'faq_list';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('question', 'answer');
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'question':
                    return esc_html__('FAQ: Question', 'livemesh-el-addons');

                case 'answer':
                    return esc_html__('FAQ: Answer', 'livemesh-el-addons');

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
                case 'question':
                    return 'LINE';

                case 'answer':
                    return 'VISUAL';

                default:
                    return '';
            }
        }

    }

}
