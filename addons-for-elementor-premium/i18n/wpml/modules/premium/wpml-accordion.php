<?php

namespace LivemeshAddons\i18n;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {

    /**
     * Class LAE_WPML_Accordion
     */
    class LAE_WPML_Accordion extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'panels';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('panel_title', 'panel_content');
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'panel_title':
                    return esc_html__('Accordion: Title', 'livemesh-el-addons');

                case 'panel_content':
                    return esc_html__('Accordion: Content', 'livemesh-el-addons');

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
                case 'panel_title':
                    return 'LINE';

                case 'panel_content':
                    return 'VISUAL';

                default:
                    return '';
            }
        }

    }

}