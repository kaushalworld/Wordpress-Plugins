<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Gallery_Carousel
     */
    class LAE_WPML_Gallery_Carousel extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'gallery_items';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('item_label', 'item_tags', 'item_description', 'video_link', 'mp4_video_link', 'webm_video_link', 'item_link' => array('url'));
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'item_label':
                    return esc_html__('Gallery Carousel Item: Title', 'livemesh-el-addons');

                case 'item_tags':
                    return esc_html__('Gallery Carousel Item: Tags', 'livemesh-el-addons');

                case 'video_link':
                    return esc_html__('Gallery Carousel Item: YouTube/Vimeo Video Link', 'livemesh-el-addons');

                case 'mp4_video_link':
                    return esc_html__('Gallery Carousel Item: MP4 Video Link', 'livemesh-el-addons');

                case 'webm_video_link':
                    return esc_html__('Gallery Carousel Item: WebM Video Link', 'livemesh-el-addons');

                case 'url':
                    return esc_html__('Gallery Carousel Item: Link URL', 'livemesh-el-addons');

                case 'item_description':
                    return esc_html__('Gallery Carousel Item: Description', 'livemesh-el-addons');

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
                case 'item_label':
                case 'item_tags':
                case 'video_link':
                case 'mp4_video_link':
                case 'webm_video_link':
                    return 'LINE';

                case 'item_description':
                    return 'AREA';

                case 'url':
                    return 'LINK';

                default:
                    return '';
            }
        }

    }

}