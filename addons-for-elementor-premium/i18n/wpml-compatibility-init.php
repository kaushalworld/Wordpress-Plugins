<?php

namespace LivemeshAddons\i18n;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('LAE_WPML_Compatibility_Init')):

    class LAE_WPML_Compatibility_Init {

        public function __construct() {

            $this->setup_constants();

            $this->includes();

            $this->hooks();
        }

        private function setup_constants() {

            // Plugin Folder Path
            if (!defined('LAE_WPML_MODULES_DIR')) {
                define('LAE_WPML_MODULES_DIR', LAE_PLUGIN_DIR . 'i18n/wpml/modules/');
            }

        }

        private function includes() {

            require_once LAE_WPML_MODULES_DIR . 'wpml-carousel.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-clients.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-odometers.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-piecharts.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-pricing-table.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-services.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-stats-bars.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-team-members.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-testimonials.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-testimonials-slider.php';

            /* Premium Elements */
            if (lae_fs()->can_use_premium_code__premium_only()) {

                require_once LAE_WPML_MODULES_DIR . 'premium/wpml-accordion.php';
                require_once LAE_WPML_MODULES_DIR . 'premium/wpml-faq.php';
                require_once LAE_WPML_MODULES_DIR . 'premium/wpml-features.php';
                require_once LAE_WPML_MODULES_DIR . 'premium/wpml-gallery.php';
                require_once LAE_WPML_MODULES_DIR . 'premium/wpml-gallery-carousel.php';
                require_once LAE_WPML_MODULES_DIR . 'premium/wpml-icon-list.php';
                require_once LAE_WPML_MODULES_DIR . 'premium/wpml-image-slider.php';
                require_once LAE_WPML_MODULES_DIR . 'premium/wpml-services-carousel.php';
                require_once LAE_WPML_MODULES_DIR . 'premium/wpml-slider.php';
                require_once LAE_WPML_MODULES_DIR . 'premium/wpml-tabs.php';
            }

        }

        private function hooks() {

            add_filter('wpml_elementor_widgets_to_translate', array($this, 'wpml_widgets_to_translate_filter'));
        }

        public function wpml_widgets_to_translate_filter($widgets) {

            $lae_widgets = array(

                'lae-heading' => array(
                    'conditions' => array('widgetType' => 'lae-heading'),
                    'fields' => array(
                        array(
                            'field' => 'heading',
                            'type' => __('Heading: Title', 'livemesh-el-addons'),
                            'editor_type' => 'LINE'
                        ),
                        array(
                            'field' => 'subtitle',
                            'type' => __('Heading: Subheading', 'livemesh-el-addons'),
                            'editor_type' => 'LINE'
                        ),
                        array(
                            'field' => 'short_text',
                            'type' => __('Heading: Short Text', 'livemesh-el-addons'),
                            'editor_type' => 'AREA'
                        ),
                    ),
                ),

                'lae-carousel' => array(
                    'conditions' => array('widgetType' => 'lae-carousel'),
                    'fields' => array(),
                    'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Carousel',
                ),

                'lae-clients' => array(
                    'conditions' => array('widgetType' => 'lae-clients'),
                    'fields' => array(),
                    'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Clients',
                ),

                'lae-odometers' => array(
                    'conditions' => array('widgetType' => 'lae-odometers'),
                    'fields' => array(),
                    'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Odometers',
                ),

                'lae-piecharts' => array(
                    'conditions' => array('widgetType' => 'lae-piecharts'),
                    'fields' => array(),
                    'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Piecharts',
                ),

                'lae-pricing-table' => array(
                    'conditions' => array('widgetType' => 'lae-pricing-table'),
                    'fields' => array(),
                    'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Pricing_Table',
                ),

                'lae-services' => array(
                    'conditions' => array('widgetType' => 'lae-services'),
                    'fields' => array(),
                    'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Services',
                ),

                'lae-stats-bars' => array(
                    'conditions' => array('widgetType' => 'lae-stats-bars'),
                    'fields' => array(),
                    'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Stats_Bars',
                ),

                'lae-team-members' => array(
                    'conditions' => array('widgetType' => 'lae-team-members'),
                    'fields' => array(),
                    'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Team_Members',
                ),

                'lae-testimonials' => array(
                    'conditions' => array('widgetType' => 'lae-testimonials'),
                    'fields' => array(),
                    'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Testimonials',
                ),

                'lae-testimonials-slider' => array(
                    'conditions' => array('widgetType' => 'lae-testimonials-slider'),
                    'fields' => array(),
                    'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Testimonials_Slider',
                ),

            );

            $widgets = array_merge($widgets, $lae_widgets);

            if (lae_fs()->can_use_premium_code__premium_only()) {

                $lae_widgets = array(

                    'lae-button' => array(
                        'conditions' => array('widgetType' => 'lae-button'),
                        'fields' => array(
                            array(
                                'field' => 'button_text',
                                'type' => __('Button: Title', 'livemesh-el-addons'),
                                'editor_type' => 'LINE'
                            ),
                            'href' => array(
                                'field' => 'url',
                                'type' => __('Button: Target URL', 'livemesh-el-addons'),
                                'editor_type' => 'LINK'
                            ),
                        ),

                    ),
                    'lae-portfolio' => array(
                        'conditions' => array('widgetType' => 'lae-portfolio'),
                        'fields' => array(
                            array(
                                'field' => 'heading',
                                'type' => __('Posts Grid: Heading', 'livemesh-el-addons'),
                                'editor_type' => 'LINE'
                            ),
                            'heading_url' => array(
                                'field' => 'url',
                                'type' => __('Posts Grid: Heading URL', 'livemesh-el-addons'),
                                'editor_type' => 'LINK'
                            ),
                            array(
                                'field' => 'read_more_text',
                                'type' => __('Posts Grid: Read More Text', 'livemesh-el-addons'),
                                'editor_type' => 'LINE'
                            ),
                        )
                    ),
                    'lae-posts-block' => array(
                        'conditions' => array('widgetType' => 'lae-posts-block'),
                        'fields' => array(
                            array(
                                'field' => 'heading',
                                'type' => __('Posts Block: Heading', 'livemesh-el-addons'),
                                'editor_type' => 'LINE'
                            ),
                            'heading_url' => array(
                                'field' => 'url',
                                'type' => __('Posts Block: Heading URL', 'livemesh-el-addons'),
                                'editor_type' => 'LINK'
                            ),
                            array(
                                'field' => 'read_more_text',
                                'type' => __('Posts Block: Read More Text', 'livemesh-el-addons'),
                                'editor_type' => 'LINE'
                            ),
                        )
                    ),
                    'lae-gallery' => array(
                        'conditions' => array('widgetType' => 'lae-gallery'),
                        'fields' => array(
                            array(
                                'field' => 'heading',
                                'type' => __('Gallery: Heading', 'livemesh-el-addons'),
                                'editor_type' => 'LINE'
                            ),
                            'heading_url' => array(
                                'field' => 'url',
                                'type' => __('Gallery: Heading URL', 'livemesh-el-addons'),
                                'editor_type' => 'LINK'
                            ),
                        ),
                        'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Gallery',

                    ),
                    'lae-twitter-grid' => array(
                        'conditions' => array('widgetType' => 'lae-twitter-grid'),
                        'fields' => array(
                            array(
                                'field' => 'read_more_text',
                                'type' => __('Twitter Grid: Read More Text', 'livemesh-el-addons'),
                                'editor_type' => 'LINE'
                            ),
                        )
                    ),
                    'lae-accordion' => array(
                        'conditions' => array('widgetType' => 'lae-accordion'),
                        'fields' => array(),
                        'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Accordion',
                    ),

                    'lae-faq' => array(
                        'conditions' => array('widgetType' => 'lae-faq'),
                        'fields' => array(),
                        'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_FAQ',
                    ),

                    'lae-features' => array(
                        'conditions' => array('widgetType' => 'lae-features'),
                        'fields' => array(),
                        'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Features',
                    ),

                    'lae-icon-list' => array(
                        'conditions' => array('widgetType' => 'lae-icon-list'),
                        'fields' => array(),
                        'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Icon_List',
                    ),

                    'lae-gallery-carousel' => array(
                        'conditions' => array('widgetType' => 'lae-gallery-carousel'),
                        'fields' => array(),
                        'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Gallery_Carousel',
                    ),

                    'lae-image-slider' => array(
                        'conditions' => array('widgetType' => 'lae-image-slider'),
                        'fields' => array(),
                        'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Image_Slider',
                    ),

                    'lae-services-carousel' => array(
                        'conditions' => array('widgetType' => 'lae-services-carousel'),
                        'fields' => array(),
                        'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Services_Carousel',
                    ),

                    'lae-slider' => array(
                        'conditions' => array('widgetType' => 'lae-slider'),
                        'fields' => array(),
                        'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Slider',
                    ),

                    'lae-tabs' => array(
                        'conditions' => array('widgetType' => 'lae-tabs'),
                        'fields' => array(),
                        'integration-class' => '\LivemeshAddons\i18n\LAE_WPML_Tabs',
                    ),

                );
            }
            else {

                $lae_widgets = array(

                    'lae-portfolio' => array(
                        'conditions' => array('widgetType' => 'lae-portfolio'),
                        'fields' => array(
                            array(
                                'field' => 'heading',
                                'type' => __('Posts Grid: Heading', 'livemesh-el-addons'),
                                'editor_type' => 'LINE'
                            ),
                        ),
                    ),

                );
            }

            $widgets = array_merge($widgets, $lae_widgets);

            return $widgets;
        }

    }

endif;
