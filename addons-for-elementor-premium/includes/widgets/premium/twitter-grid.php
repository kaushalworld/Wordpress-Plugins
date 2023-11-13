<?php

/*
Widget Name: Twitter Grid
Description: Display tweets in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/


namespace LivemeshAddons\Widgets;

use LivemeshAddons\Blocks\LAE_Blocks_Manager;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class for Twitter Grid widget that displays tweets in a multi-column grid.
 */
class LAE_Twitter_Grid_Widget extends LAE_Widget_Base {

    static public $twitter_grid_counter = 0;

    /**
     * Get the name for the widget
     * @return string
     */
    public function get_name() {
        return 'lae-twitter-grid';
    }

    /**
     * Get the widget title
     * @return string|void
     */
    public function get_title() {
        return __('Twitter Grid', 'livemesh-el-addons');
    }

    /**
     * Get the widget icon
     * @return string
     */
    public function get_icon() {
        return 'lae-icon-twitter-grid';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @return string[]
     */
    public function get_categories() {
        return array('livemesh-addons');
    }

    /**
     * Get the widget documentation URL
     * @return string
     */
    public function get_custom_help_url() {
        return 'https://livemeshelementor.com/docs/livemesh-addons/premium-addons/twitter-grid/';
    }

    /**
     * Obtain the scripts required for the widget to function
     * @return string[]
     */
    public function get_script_depends() {
        return [
            'isotope.pkgd',
            'imagesloaded.pkgd',
            'jquery-fancybox',
            'lae-frontend-scripts',
            'lae-blocks-scripts',
            'lae-twitter-grid-scripts'
        ];
    }

    /**
     * Register the controls for the widget
     * Adds fields that help configure and customize the widget
     * @return void
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_twitter_grid',
            [
                'label' => __('Twitter Grid', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'twitter_grid_class', [
                'type' => Controls_Manager::TEXT,
                "description" => __("Specify an unique identifier used as a custom CSS class name and lightbox group name/slug for the grid element.", "livemesh-el-addons"),
                "label" => __("Twitter Grid Class/Identifier", "livemesh-el-addons"),
                'default' => ''
            ]
        );

        $this->add_control(
            'twitter_source',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Twitter source', 'livemesh-el-addons'),
                'options' => array (
                    'user_timeline' =>  __('User Timeline', 'livemesh-el-addons'),
                    'search'        =>  __('Tweets by search', 'livemesh-el-addons'),
                    'favorites'     =>  __('User Favorites', 'livemesh-el-addons'),
                    'list_timeline' =>  __('User List', 'livemesh-el-addons')
                ),
                'default' => 'user_timeline',
            ]
        );

        $this->add_control(
            'twitter_include',
            [
                'type' => Controls_Manager::SELECT2,
                'label' => __('Content to include from Twitter', 'livemesh-el-addons'),
                'options' => array(
                    'retweets' =>  __('Retweets', 'livemesh-el-addons'),
                    'replies'  =>  __('Replies', 'livemesh-el-addons')
                ),
                'condition' => [
                    'twitter_source' => ['user_timeline', 'favorites', 'list_timeline']
                ],
            ]
        );

        $this->add_control(
            'twitter_username',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __('Twitter User Name', 'livemesh-el-addons'),
                'description' => __('Do not prefix with @', 'livemesh-el-addons'),
                'condition' => [
                    'twitter_source' => ['user_timeline', 'favorites', 'list_timeline']
                ],
                'default' => 'live_mesh'
            ]
        );

        $this->add_control(
            'twitter_listname',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __('Twitter List Name', 'livemesh-el-addons'),
                'condition' => [
                    'twitter_source' => ['list_timeline']
                ],
            ]
        );

        $this->add_control(
            'twitter_searchkey',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __('Twitter Search Keyword', 'livemesh-el-addons'),
                'description' => __('Enter any word or #hashtag. Look <a href="https://dev.twitter.com/rest/public/search" target="_blank">here</a> for advanced terms.', 'livemesh-el-addons'),
                'condition' => [
                    'twitter_source' => ['search']
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('General', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'block_type',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose Grid Style', 'livemesh-el-addons'),
                'options' => array(
                    'block_twitter_grid_1' => __('Twitter Grid Style 1', 'livemesh-el-addons'),
                    'block_twitter_grid_2' => __('Twitter Grid Style 2', 'livemesh-el-addons'),
                    'block_twitter_grid_3' => __('Twitter Grid Style 3', 'livemesh-el-addons'),
                ),
                'default' => 'block_twitter_grid_1',
            ]
        );

        $this->add_responsive_control(
            'per_line',
            [
                'label' => __( 'Columns', 'livemesh-el-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'layout_mode',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose a layout for the Twitter grid', 'livemesh-el-addons'),
                'options' => array(
                    'masonry' => __('Masonry', 'livemesh-el-addons'),
                    'fitRows' => __('Fit Rows', 'livemesh-el-addons'),
                ),
                'default' => 'masonry',
            ]
        );

        $this->add_control(
            'display_avatar',
            [
                'label' => __('Display user avatar for each twitter post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_username',
            [
                'label' => __('Display username for each twitter post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_name',
            [
                'label' => __('Display account name for each twitter post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'display_date',
            [
                'label' => __('Display posted date for the twitter post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'date_format',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Date Format', 'livemesh-el-addons'),
                'description' => __('The Standard format is derived from site-wide format specified in Settings->General.', 'livemesh-el-addons'),
                'options' => array(
                    'elapsed_time' => __('Elapsed Time', 'livemesh-el-addons'),
                    'standard_date' => __('Standard Date', 'livemesh-el-addons'),
                    'standard_date_time' => __('Standard Date and Time', 'livemesh-el-addons'),
                ),
                'default' => 'elapsed_time',
                'condition' => [
                    'display_date' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'display_comments',
            [
                'label' => __('Display comments for each twitter post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_retweets',
            [
                'label' => __('Display retweets count for the twitter post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_likes',
            [
                'label' => __('Display likes count for the twitter post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_read_more',
            [
                'label' => __('Display link to the twitter post?', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'label_off' => __('No', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => __('Read more text', 'livemesh-el-addons'),
                'type' => Controls_Manager::TEXT,
                "description" => __('Specify the text for the read more link/button', 'livemesh-el-addons'),
                'default' => __('Read More', 'livemesh-el-addons'),
                'condition' => [
                    'block_type' => ['block_twitter_grid_1', 'block_twitter_grid_2', 'block_twitter_grid_3']
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_size_lightbox',
            [
                'label' => __('Image Size and Lightbox', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'enable_lightbox',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'livemesh-el-addons'),
                'label_on' => __('Yes', 'livemesh-el-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'label' => __('Enable Lightbox Twitter Grid?', 'livemesh-el-addons'),
            ]
        );

        $this->add_control(
            'lightbox_library',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Lightbox Library', 'livemesh-el-addons'),
                'description' => __('Choose the preferred library for the lightbox', 'livemesh-el-addons'),
                'options' => array(
                    'fancybox' => __('Fancybox', 'livemesh-el-addons'),
                    'elementor' => __('Elementor', 'livemesh-el-addons'),
                ),
                'default' => 'fancybox',
                'condition' => [
                    'enable_lightbox' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination',
            [
                'label' => __('Pagination', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );


        $this->add_control(
            'pagination',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Pagination', 'livemesh-el-addons'),
                'description' => __('Choose pagination type or choose None if no pagination is desired. Make sure you enter the items per page value in the option \'Number of items to be displayed on each load more invocation\' field below to control number of items to display per page.', 'livemesh-el-addons'),
                'options' => array(
                    'none' => __('None', 'livemesh-el-addons'),
                    'load_more' => __('Load More', 'livemesh-el-addons'),
                ),
                'default' => 'load_more',
            ]
        );


        $this->add_control(
            'items_per_page',
            [
                'label' => __('Number of tweets to be displayed on each load more invocation.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 8,
                'condition' => [
                    'pagination' => ['load_more'],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_responsive',
            [
                'label' => __('Gutter Options', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $this->add_control(
            'heading_desktop',
            [
                'label' => __( 'Desktop', 'livemesh-el-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );


        $this->add_control(
            'gutter',
            [
                'label' => __('Gutter', 'livemesh-el-addons'),
                'description' => __('Space between columns in the grid.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-block-inner' => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px;',
                    '{{WRAPPER}} .lae-block .lae-block-inner .lae-block-column' => 'padding: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_control(
            'heading_tablet',
            [
                'label' => __( 'Tablet', 'livemesh-el-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );


        $this->add_control(
            'tablet_gutter',
            [
                'label' => __('Gutter', 'livemesh-el-addons'),
                'description' => __('Space between columns.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'selectors' => [
                    '(tablet-){{WRAPPER}} .lae-block .lae-block-inner' => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px;',
                    '(tablet-){{WRAPPER}} .lae-block .lae-block-inner .lae-block-column' => 'padding: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_control(
            'heading_mobile',
            [
                'label' => __( 'Mobile Phone', 'livemesh-el-addons' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'mobile_gutter',
            [
                'label' => __('Gutter', 'livemesh-el-addons'),
                'description' => __('Space between columns.', 'livemesh-el-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'selectors' => [
                    '(mobile-){{WRAPPER}} .lae-block .lae-block-inner' => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px;',
                    '(mobile-){{WRAPPER}} .lae-block .lae-block-inner .lae-block-column' => 'padding: {{VALUE}}px;',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_widget_theme',
            [
                'label' => __('Widget Theme', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'toggle_dark_mode',
            [
                'label' => __( 'Dark Mode', 'elementor-pro' ),
                'description' => __('Enable dark mode when this widget is placed in those pages or sections/rows within a page that have a dark color (such as black) set as background color. ', 'livemesh-el-addons'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'dark-bg',
                'prefix_class' => 'lae-',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_text_styling',
            [
                'label' => __('Tweet Text', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_text_color',
            [
                'label' => __( 'Text Color', 'livemesh-el-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-entry-summary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_text_typography',
                'selector' => '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-entry-summary',
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'section_entry_author_avatar_styling',
            [
                'label' => __('Tweet Author Avatar', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'avatar_size',
            [
                'label' => __('Avatar size in pixels', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 128,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-social-avatar img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'avatar_border_radius',
            [
                'label' => __('Avatar Border Radius', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-social-avatar img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_author_name_styling',
            [
                'label' => __('Tweet Author Name', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'author_name_color',
            [
                'label' => __('Author Name Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-twitter-user .lae-user-details .lae-twitter-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'author_name_link_hover_color',
            [
                'label' => __('Author Name Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-twitter-user:hover .lae-user-details .lae-twitter-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_name_typography',
                'selector' => '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-twitter-user .lae-user-details .lae-twitter-name',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_author_username_styling',
            [
                'label' => __('Tweet Author Username', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'author_username_color',
            [
                'label' => __('Username Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-twitter-user .lae-user-details .lae-twitter-username' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'author_username_link_hover_color',
            [
                'label' => __('Username Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-twitter-user:hover .lae-user-details .lae-twitter-username' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_username_typography',
                'selector' => '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-twitter-user .lae-user-details .lae-twitter-username',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_entry_date_styling',
            [
                'label' => __('Tweet Date', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_date_color',
            [
                'label' => __('Tweet Date Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-tweet-date .lae-published' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_date_link_hover_color',
            [
                'label' => __('Tweet Date Link Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-tweet-date:hover .lae-published' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_date_typography',
                'selector' => '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-tweet-date .lae-published',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_retweets_styling',
            [
                'label' => __('Retweets', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'entry_retweets_icon_size',
            [
                'label' => __('Retweets Icon size in pixels', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 96,
                    ],
                ],
                'default' => [
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-module-details .lae-entry-retweets i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'entry_retweets_icon_color',
            [
                'label' => __('Retweets Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-module-details .lae-entry-retweets i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_retweets_color',
            [
                'label' => __('Retweets Count Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-module-details .lae-entry-retweets' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_retweets_typography',
                'selector' => '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-module-details .lae-entry-retweets',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_entry_likes_styling',
            [
                'label' => __('Likes', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'entry_likes_icon_size',
            [
                'label' => __('Likes Icon size in pixels', 'livemesh-el-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 96,
                    ],
                ],
                'default' => [
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-module-details .lae-entry-likes i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'entry_likes_icon_color',
            [
                'label' => __('Likes Icon Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-module-details .lae-entry-likes i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'entry_likes_color',
            [
                'label' => __('Likes Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-module-details .lae-entry-likes' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'entry_likes_typography',
                'selector' => '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-module-details .lae-entry-likes',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_read_more_styling',
            [
                'label' => __('Read More', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'read_more_color',
            [
                'label' => __('Read More Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-read-more, {{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-read-more a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_hover_color',
            [
                'label' => __('Read More Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-read-more, {{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-read-more a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'read_more_typography',
                'selector' => '{{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-read-more, {{WRAPPER}} .lae-block-twitter-grid .lae-module .lae-read-more a',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_load_more_button_styling',
            [
                'label' => __('Load More Button', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination' => 'load_more',
                ],
            ]
        );

        $this->add_control(
            'load_more_button_custom_color',
            [
                'label' => __('Button Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-load-more' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_button_custom_hover_color',
            [
                'label' => __('Button Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-load-more:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_button_padding',
            [
                'label' => __('Custom Padding', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'isLinked' => false
            ]
        );

        $this->add_control(
            'load_more_button_border_radius',
            [
                'label' => __('Custom Border Radius', 'livemesh-el-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_button_label_color',
            [
                'label' => __('Label Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block-twitter-grid .lae-load-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_button_label_hover_color',
            [
                'label' => __('Label Hover Color', 'livemesh-el-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lae-block .lae-load-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'load_more_button_typography',
                'label' => __('Typography', 'livemesh-el-addons'),
                'selector' => '{{WRAPPER}} .lae-block-twitter-grid .lae-load-more',
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render HTML widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @return void
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        $settings = apply_filters('lae_twitter_grid_' . $this->get_id() . '_settings', $settings);

        $settings['block_id'] = $this->get_id();

        self::$twitter_grid_counter++;

        $settings['block_class'] = !empty($settings['twitter_grid_class']) ? sanitize_title($settings['twitter_grid_class']) : 'twitter-grid-' . self::$twitter_grid_counter;

        $settings = lae_parse_twitter_block_settings($settings);

        $block = LAE_Blocks_Manager::get_instance($settings['block_type']);

        $output = $block->render($settings);

        echo apply_filters('lae_twitter_grid_output', $output, $settings);
    }

    /**
     * Render the widget output in the editor.
     * @return void
     */
    protected function content_template() {
    }

}