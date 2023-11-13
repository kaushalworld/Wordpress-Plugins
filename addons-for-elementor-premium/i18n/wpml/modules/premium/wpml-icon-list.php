<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Icon_List
     */
    class LAE_WPML_Icon_List extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'icon_list';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('icon_title', 'href' => array('url'));
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'icon_title':
                    return esc_html__('Icon: Text', 'livemesh-el-addons');

                case 'url':
                    return esc_html__('Icon: Link URL', 'livemesh-el-addons');

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
                case 'icon_title':
                    return 'LINE';
                case 'url':
                    return 'LINK';

                default:
                    return '';
            }
        }

    }

}