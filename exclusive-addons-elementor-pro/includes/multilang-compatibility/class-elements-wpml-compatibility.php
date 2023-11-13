<?php
namespace ExclusiveAddons\ProElementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WPML Compatibility Elementor Elements.
 *
 * @package     Exclusive Addons
 * @author      DevsCred.com
 * @link        https://exclusiveaddons.com/
 * @since       1.4.4
 */

class Exad_WPML_Element_Compatibility {

    /**
	 * A reference to an instance of this class.
	 * @since 1.4.4
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * Constructor for the class
	 */
	public function init() {

		// WPML String Translation plugin exist check
		if ( defined( 'WPML_ST_VERSION' ) ) {

			if ( class_exists( 'WPML_Elementor_Module_With_Items' ) ) {
				$this->load_wpml_widgets();
			}

			add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'exad_add_translatable_widgets' ] );
		}

	}

    /**
	 * Load wpml required repeater class files.
	 * @return void
	 */
	public function load_wpml_widgets() {
		require_once( EXAD_PRO_PATH . 'includes/multilang-compatibility/wpml/class-wpml-business-hours.php' );
		require_once( EXAD_PRO_PATH . 'includes/multilang-compatibility/wpml/class-wpml-chart.php' );
		require_once( EXAD_PRO_PATH . 'includes/multilang-compatibility/wpml/class-wpml-comparison-table.php' );
		require_once( EXAD_PRO_PATH . 'includes/multilang-compatibility/wpml/class-wpml-demo-previewer.php' );
		require_once( EXAD_PRO_PATH . 'includes/multilang-compatibility/wpml/class-wpml-floating-animation.php' );
		require_once( EXAD_PRO_PATH . 'includes/multilang-compatibility/wpml/class-wpml-image-hotspot.php' );
		require_once( EXAD_PRO_PATH . 'includes/multilang-compatibility/wpml/class-wpml-mega-menu.php' );
		require_once( EXAD_PRO_PATH . 'includes/multilang-compatibility/wpml/class-wpml-slider.php' );
		require_once( EXAD_PRO_PATH . 'includes/multilang-compatibility/wpml/class-wpml-table.php' );
		require_once( EXAD_PRO_PATH . 'includes/multilang-compatibility/wpml/class-wpml-team-carousel.php' );
		require_once( EXAD_PRO_PATH . 'includes/multilang-compatibility/wpml/class-wpml-testimonial-carousel.php' );


    }

    /**
	 * Add element translation widgets
	 * @param array $widgets
	 * @return array
	 */
	public function exad_add_translatable_widgets( $widgets ) {

		$widgets[ 'exad-author-box' ] = [
			'conditions' => [ 'widgetType' => 'exad-author-boxe' ],
			'fields'     => [
				[
					'field'       => 'exad_author_before_login_message',
					'type'        => esc_html__( 'Not Logged in Message', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_author_custom_name',
					'type'        => esc_html__( 'Author Name', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_author_custom_description',
					'type'        => esc_html__( 'Author Description', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-breadcrumbs' ] = [
			'conditions' => [ 'widgetType' => 'exad-breadcrumbs' ],
			'fields'     => [
				[
					'field'       => 'exad_breadcrumbs_home_text',
					'type'        => esc_html__( 'Text For Home', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_breadcrumbs_separate_arrow_text',
					'type'        => esc_html__( 'Symbol', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];		

		$widgets[ 'exad-promo-box' ] = [
			'conditions' => [ 'widgetType' => 'exad-promo-box' ],
			'fields'     => [
				[
					'field'       => 'exad_promo_box_content_heading',
					'type'        => esc_html__( 'Heading', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_promo_box_content_details',
					'type'        => esc_html__( 'Details', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_promo_box_countdown_expired_text',
					'type'        => esc_html__( 'Count Down Expired Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_promo_box_mailchimp_button_text',
					'type'        => esc_html__( 'Button Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_promo_box_mailchimp_loading_text',
					'type'        => esc_html__( 'Loading Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_promo_box_mailchimp_success_text',
					'type'        => esc_html__( 'Success Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_promo_box_mailchimp_error_text',
					'type'        => esc_html__( 'Error Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_promo_box_button_text',
					'type'        => esc_html__( 'Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];
         
		$widgets[ 'exad-content-switcher' ] = [
			'conditions' => [ 'widgetType' => 'exad-content-switcher' ],
			'fields'     => [
				[
					'field'       => 'exad_switcher_content_primary_heading',
					'type'        => esc_html__( 'Heading', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_switcher_content_secondary_heading',
					'type'        => esc_html__( 'Heading', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_switcher_content_primary_content',
					'type'        => esc_html__( 'Content', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];

		$widgets[ 'exad-cookie-consent' ] = [
			'conditions' => [ 'widgetType' => 'exad-cookie-consent' ],
			'fields'     => [
				[
					'field'       => 'exad_cookie_consent_message',
					'type'        => esc_html__( 'Message', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],	
				[
					'field'       => 'exad_cookie_consent_button_text',
					'type'        => esc_html__( 'Cookie Button Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_cookie_consent_read_more_text',
					'type'        => esc_html__( 'Read More Button Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];		

		$widgets[ 'exad-counter' ] = [
			'conditions' => [ 'widgetType' => 'exad-counter' ],
			'fields'     => [
				[
					'field'       => 'exad_counter_title',
					'type'        => esc_html__( 'Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_counter_suffix',
					'type'        => esc_html__( 'Suffix', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-iconbox' ] = [
			'conditions' => [ 'widgetType' => 'exad-iconbox' ],
			'fields'     => [
				[
					'field'       => 'exad_icon_box_label',
					'type'        => esc_html__( 'Label Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_icon_box_title',
					'type'        => esc_html__( 'Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_icon_box_description',
					'type'        => esc_html__( 'Description', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-instagram-feed' ] = [
			'conditions' => [ 'widgetType' => 'exad-instagram-feed' ],
			'fields'     => [
				[
					'field'       => 'exad_instagram_feed_access_token',
					'type'        => esc_html__( 'Access Token', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_instagram_feed_user_name',
					'type'        => esc_html__( 'User Name', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];		


		$widgets[ 'exad-login-register' ] = [
			'conditions' => [ 'widgetType' => 'exad-login-register' ],
			'fields'     => [
				[
					'field'       => 'exad_login_heading_text',
					'type'        => esc_html__( 'Heading Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_login_register_button_text',
					'type'        => esc_html__( 'Button Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_lost_password_text',
					'type'        => esc_html__( 'Lost Password text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_remember_me_text',
					'type'        => esc_html__( 'Remember me text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_login_register_username_laebl',
					'type'        => esc_html__( 'Username Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_login_register_password_laebl',
					'type'        => esc_html__( 'Password Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_login_register_username_placeholder',
					'type'        => esc_html__( 'Username Placeholder', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_login_register_password_placeholder',
					'type'        => esc_html__( 'Password Placeholder', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];		
		
		$widgets[ 'exad-lottie-animation' ] = [
			'conditions' => [ 'widgetType' => 'exad-lottie-animation' ],
			'fields'     => [
				[
					'field'       => 'exad_lottie_caption',
					'type'        => esc_html__( 'Caption', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-mailchimp' ] = [
			'conditions' => [ 'widgetType' => 'exad-mailchimp' ],
			'fields'     => [
				[
					'field'       => 'exad_mailchimp_email_label_text',
					'type'        => esc_html__( 'Email Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_mailchimp_email_placeholder_text',
					'type'        => esc_html__( 'Email Placeholder', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_mailchimp_firstname_label_text',
					'type'        => esc_html__( 'First Name Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_mailchimp_firstname_placeholder_text',
					'type'        => esc_html__( 'First Name Placeholder', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_mailchimp_last_name_label_text',
					'type'        => esc_html__( 'Last Name Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_mailchimp_lastname_placeholder_text',
					'type'        => esc_html__( 'Last Name Placeholder', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_mailchimp_button_text',
					'type'        => esc_html__( 'Button Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_mailchimp_loading_text',
					'type'        => esc_html__( 'Loading Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_mailchimp_success_text',
					'type'        => esc_html__( 'Success Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_mailchimp_error_text',
					'type'        => esc_html__( 'Error Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];		

		$widgets[ 'exad-offcanvas' ] = [
			'conditions' => [ 'widgetType' => 'exad-offcanvas' ],
			'fields'     => [
				[
					'field'       => 'exad_offcanvas_button_text',
					'type'        => esc_html__( 'Button Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_offcanvas_custom_class',
					'type'        => esc_html__( 'Custom Class', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];		

		$widgets[ 'exad-page-title' ] = [
			'conditions' => [ 'widgetType' => 'exad-page-title' ],
			'fields'     => [
				[
					'field'       => 'before_title',
					'type'        => esc_html__( 'Before Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'after_title',
					'type'        => esc_html__( 'After Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-post-carousel' ] = [
			'conditions' => [ 'widgetType' => 'exad-post-carousel' ],
			'fields'     => [
				[
					'field'       => 'exad_post_carousel_read_more_btn_text',
					'type'        => esc_html__( 'Button Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_post_carousel_user_name_tag',
					'type'        => esc_html__( 'Author Name Tag', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];		

		$widgets[ 'exad-post-navigation' ] = [
			'conditions' => [ 'widgetType' => 'exad-post-navigation' ],
			'fields'     => [
				[
					'field'       => 'exad_post_nav_prev_label',
					'type'        => esc_html__( 'Previous Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_post_nav_next_label',
					'type'        => esc_html__( 'Next Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-post-slider' ] = [
			'conditions' => [ 'widgetType' => 'exad-post-slider' ],
			'fields'     => [
				[
					'field'       => 'exad_post_slider_read_more_btn_text',
					'type'        => esc_html__( 'Button Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-search-form' ] = [
			'conditions' => [ 'widgetType' => 'exad-search-form' ],
			'fields'     => [
				[
					'field'       => 'placeholder',
					'type'        => esc_html__( 'Placeholder', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		
		$widgets[ 'exad-site-tagline' ] = [
			'conditions' => [ 'widgetType' => 'exad-site-tagline' ],
			'fields'     => [
				[
					'field'       => 'before_tagline',
					'type'        => esc_html__( 'Before Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'after_tagline',
					'type'        => esc_html__( 'After Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	
	
		$widgets[ 'exad-site-title' ] = [
			'conditions' => [ 'widgetType' => 'exad-site-title' ],
			'fields'     => [
				[
					'field'       => 'before_title',
					'type'        => esc_html__( 'Before Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'after_title',
					'type'        => esc_html__( 'After Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-social-share' ] = [
			'conditions' => [ 'widgetType' => 'exad-social-share' ],
			'fields'     => [
				[
					'field'       => 'social_share_facebook_label',
					'type'        => esc_html__( 'Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'social_share_twitter_label',
					'type'        => esc_html__( 'Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'social_share_pinterest_label',
					'type'        => esc_html__( 'Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'social_share_linkedin_label',
					'type'        => esc_html__( 'Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'social_share_reddit_label',
					'type'        => esc_html__( 'Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-source-code' ] = [
			'conditions' => [ 'widgetType' => 'exad-source-code' ],
			'fields'     => [
				[
					'field'       => 'exad_source_code_copy_btn_text',
					'type'        => esc_html__( 'Copy Button Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_source_code_after_copied_btn_text',
					'type'        => esc_html__( 'After Copied Button Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-woo-add-to-cart' ] = [
			'conditions' => [ 'widgetType' => 'exad-woo-add-to-cart' ],
			'fields'     => [
				[
					'field'       => 'exad_woo_mini_cart_bag_title',
					'type'        => esc_html__( 'Cart Bag Heading', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-woo-category' ] = [
			'conditions' => [ 'widgetType' => 'exad-woo-category' ],
			'fields'     => [
				[
					'field'       => 'exad_woo_product_cat_subtitle',
					'type'        => esc_html__( 'Subtitle', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-woo-my-account' ] = [
			'conditions' => [ 'widgetType' => 'exad-woo-my-account' ],
			'fields'     => [
				[
					'field'       => 'exad_woo_my_account_navigation_show_dashboard_text',
					'type'        => esc_html__( 'Dashboard Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_woo_my_account_navigation_show_orders_text',
					'type'        => esc_html__( 'Orders Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_woo_my_account_navigation_show_downloads_text',
					'type'        => esc_html__( 'Downloads Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_woo_my_account_navigation_show_addresses_text',
					'type'        => esc_html__( 'Addresses Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_woo_my_account_navigation_show_account_details_text',
					'type'        => esc_html__( 'Account Details Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_woo_my_account_navigation_show_logout_link_text',
					'type'        => esc_html__( 'Logout Link Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-woo-products' ] = [
			'conditions' => [ 'widgetType' => 'exad-woo-products' ],
			'fields'     => [
				[
					'field'       => 'product_in_ids',
					'type'        => esc_html__( 'Product Include', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'product_not_in_ids',
					'type'        => esc_html__( 'Product Exclude', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_woo_product_featured_tag_text',
					'type'        => esc_html__( 'Featured Tag.', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-woo-product-carousel' ] = [
			'conditions' => [ 'widgetType' => 'exad-woo-product-carousel' ],
			'fields'     => [
				[
					'field'       => 'product_in_ids',
					'type'        => esc_html__( 'Product Include', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'product_not_in_ids',
					'type'        => esc_html__( 'Product Exclude', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],	
				[
					'field'       => 'exad_woo_product_carousel_featured_tag_text',
					'type'        => esc_html__( 'Featured Tag.', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'product-add-to-cart' ] = [
			'conditions' => [ 'widgetType' => 'product-add-to-cart' ],
			'fields'     => [
				[
					'field'       => 'exad_add_to_cart_button_text',
					'type'        => esc_html__( 'Button Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'product_add_to_cart_before',
					'type'        => esc_html__( 'Show Text Before Cart', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],	
				[
					'field'       => 'product_add_to_cart_after',
					'type'        => esc_html__( 'Show Text After Cart', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-product-breadcrumb' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-breadcrumb' ],
			'fields'     => [
				[
					'field'       => 'exad_product_breadcrumb_before',
					'type'        => esc_html__( 'Show Text Before Breadcrumb', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_product_breadcrumb_after',
					'type'        => esc_html__( 'Show Text After Breadcrumb', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-product-cross-sell' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-cross-sell' ],
			'fields'     => [
				[
					'field'       => 'exad_product_cross_sell_section_title_text',
					'type'        => esc_html__( 'You may also like&hellip;', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_product_cross_sell_before',
					'type'        => esc_html__( 'Before Cross Sell', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_product_cross_sell_after',
					'type'        => esc_html__( 'After Cross Sell', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-product-meta' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-meta' ],
			'fields'     => [
				[
					'field'       => 'exad_product_meta_category_caption_single',
					'type'        => esc_html__( 'Singular', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_product_meta_category_caption_plural',
					'type'        => esc_html__( 'Plural', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'tag_caption_single',
					'type'        => esc_html__( 'Singular', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_product_meta_tag_caption_plural',
					'type'        => esc_html__( 'Plural', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_product_meta_sku_caption',
					'type'        => esc_html__( 'SKU', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_product_meta_sku_missing_caption',
					'type'        => esc_html__( 'Missing', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_product_meta_separator',
					'type'        => esc_html__( 'Separator', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_product_meta_before',
					'type'        => esc_html__( 'Show Text Before Meta', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_product_meta_after',
					'type'        => esc_html__( 'Show Text After Meta', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-product-navigation' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-navigation' ],
			'fields'     => [
				[
					'field'       => 'exad_product_navigation_prev_text',
					'type'        => esc_html__( 'Prev', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_product_navigation_next_text',
					'type'        => esc_html__( 'Next', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_product_nav_before',
					'type'        => esc_html__( 'Show Text Before Nav', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_product_nav_after',
					'type'        => esc_html__( 'Show Text After Nav', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-product-price' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-price' ],
			'fields'     => [
				[
					'field'       => 'exad_product_price_before',
					'type'        => esc_html__( 'Show Text Before Price', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_product_price_after',
					'type'        => esc_html__( 'Show Text After Price', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-product-qr-code' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-qr-code' ],
			'fields'     => [
				[
					'field'       => 'exad_product_qr_code_before',
					'type'        => esc_html__( 'Show Text Before QR Code', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_product_qr_code_after',
					'type'        => esc_html__( 'Show Text After QR Code', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-product-related' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-related' ],
			'fields'     => [
				[
					'field'       => 'exad_product_related_title_text',
					'type'        => esc_html__( 'Related Products', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-product-short-description' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-short-description' ],
			'fields'     => [
				[
					'field'       => 'exad_product_before_description',
					'type'        => esc_html__( 'Show Text Before Description', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_product_after_description',
					'type'        => esc_html__( 'Show Text After Description', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-product-stock' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-stock' ],
			'fields'     => [
				[
					'field'       => 'exad_product_stock_before',
					'type'        => esc_html__( 'Show Text Before Stock', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_product_stock_after',
					'type'        => esc_html__( 'Show Text After Stock', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-product-tabs' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-tabs' ],
			'fields'     => [
				[
					'field'       => 'exad_product_tabs_info_before',
					'type'        => esc_html__( 'Show Text Before Tabs', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_product_tabs_info_after',
					'type'        => esc_html__( 'Show Text After Tabs', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-product-image' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-image' ],
			'fields'     => [
				[
					'field'       => 'exad_product_image_before',
					'type'        => esc_html__( 'Before Gallery', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'exad_product_image_after',
					'type'        => esc_html__( 'After Gallery', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];		

		$widgets[ 'exad-product-title' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-title' ],
			'fields'     => [
				[
					'field'       => 'before_title',
					'type'        => esc_html__( 'Before Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'after_title',
					'type'        => esc_html__( 'After Title', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
			],
		];	

		$widgets[ 'exad-product-upsell' ] = [
			'conditions' => [ 'widgetType' => 'exad-product-upsell' ],
			'fields'     => [
				[
					'field'       => 'exad_product_upsell_section_title_text',
					'type'        => esc_html__( 'You may also like&hellip;', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		
		$widgets[ 'exad-thank-you-order' ] = [
			'conditions' => [ 'widgetType' => 'exad-thank-you-order' ],
			'fields'     => [
				[
					'field'       => 'order_thankyou_message',
					'type'        => esc_html__( 'Thank you message', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'thankyou_order_table_order_heading',
					'type'        => esc_html__( 'Order Heading', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'thankyou_order_table_date_heading',
					'type'        => esc_html__( 'Date Heading', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'thankyou_order_table_email_heading',
					'type'        => esc_html__( 'Email Heading', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'thankyou_order_table_total_heading',
					'type'        => esc_html__( 'Total Heading', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'thankyou_order_table_payment_method_heading',
					'type'        => esc_html__( 'Payment Heading', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		$widgets[ 'exad-thank-you-order-details' ] = [
			'conditions' => [ 'widgetType' => 'exad-thank-you-order-details' ],
			'fields'     => [
				[
					'field'       => 'exad_thank_you_order_details_section_title_text',
					'type'        => esc_html__( 'Order Details', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_thank_you_order_details_table_header_title_text',
					'type'        => esc_html__( 'Table Header', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_thank_you_order_details_table_header_title_2_text',
					'type'        => esc_html__( 'Table Header', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];	

		//Widgets Where use Repeater Controller

		$widgets[ 'exad-business-hours' ] = [
			'conditions' => [ 'widgetType' => 'exad-business-hours' ],
			'fields'     => [
				[
					'field'       => 'exad_business_hours_heading',
					'type'        => esc_html__( 'Heading', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => 'WPML_Exad_Business_Hours',
		];

		$widgets[ 'exad-chart' ] = [
			'conditions' => [ 'widgetType' => 'exad-chart' ],
			'fields'     => [
				[
					'field'       => 'single_label',
					'type'        => esc_html__( 'Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'single_datasets',
					'type'        => esc_html__( 'Data', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'single_bg_colors',
					'type'        => esc_html__( 'Background', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'single_border_colors',
					'type'        => esc_html__( 'Border Colors', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => 'WPML_Exad_Chart',
		];	

		
		$widgets[ 'exad-comparison-table' ] = [
			'conditions' => [ 'widgetType' => 'exad-comparison-table' ],
			'fields'     => [],
			'integration-class' => 'WPML_Exad_Comparison_Table',
		];

		$widgets[ 'exad-demo-previewer' ] = [
			'conditions' => [ 'widgetType' => 'exad-demo-previewer' ],
			'fields'     => [
				[
					'field'       => 'exad_demo_previewer_all_item_text',
					'type'        => esc_html__( 'Text for All Item', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_demo_previewer_dropdown_filter_text',
					'type'        => esc_html__( 'Text for All Dropdown', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_demo_previewer_search_placeholder_text',
					'type'        => esc_html__( 'Search Placeholder Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_demo_previewer_load_more_button_text',
					'type'        => esc_html__( 'Load More Button Text', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => 'WPML_Exad_Demo_Previewer',
		];

		$widgets[ 'exad-blob-maker' ] = [
			'conditions' => [ 'widgetType' => 'exad-blob-maker' ],
			'fields'     => [],
			'integration-class' => 'WPML_Exad_Floating_Animation',
		];

		$widgets[ 'exad-image-hotspot' ] = [
			'conditions' => [ 'widgetType' => 'exad-image-hotspot' ],
			'fields'     => [],
			'integration-class' => 'WPML_Exad_Image_Hotspot',
		];

		$widgets[ 'exad-mega-menu' ] = [
			'conditions' => [ 'widgetType' => 'exad-mega-menu' ],
			'fields'     => [],
			'integration-class' => 'WPML_Exad_Mega_Menu',
		];

		$widgets[ 'exad-news-ticker-pro' ] = [
			'conditions' => [ 'widgetType' => 'exad-news-ticker-pro' ],
			'fields'     => [
				[
					'field'       => 'exad_news_ticker_label',
					'type'        => esc_html__( 'Label', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_news_ticker_include_specific_items_by_ids',
					'type'        => esc_html__( 'Include', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_news_ticker_exclude_specific_items_by_ids',
					'type'        => esc_html__( 'Exclude', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
		];


		$widgets[ 'exad-exclusive-slider' ] = [
			'conditions' => [ 'widgetType' => 'exad-exclusive-slider' ],
			'fields'     => [],
			'integration-class' => 'WPML_Exad_Slider',
		];

		$widgets[ 'exad-table' ] = [
			'conditions' => [ 'widgetType' => 'exad-table' ],
			'fields'     => [
				[
					'field'       => 'exad_table_searching_text',
					'type'        => esc_html__( 'Search Text.', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_table_searching_placeholder_text',
					'type'        => esc_html__( 'Placeholder Text for Search', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_table_text_for_no_data',
					'type'        => esc_html__( 'Text For Not Found', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_table_text_for_previous',
					'type'        => esc_html__( 'Text For Previous', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
				[
					'field'       => 'exad_table_text_for_next',
					'type'        => esc_html__( 'Text For Next', 'exclusive-addons-elementor-pro' ),
					'editor_type' => 'LINE',
				],
			],
			'integration-class' => 'WPML_Exad_Table',
		];

		$widgets[ 'exad-team-carousel' ] = [
			'conditions' => [ 'widgetType' => 'exad-team-carousel' ],
			'fields'     => [],
			'integration-class' => 'WPML_Exad_Team_Carousel',
		];

		$widgets[ 'exad-testimonial-carousel' ] = [
			'conditions' => [ 'widgetType' => 'exad-testimonial-carousel' ],
			'fields'     => [],
			'integration-class' => 'WPML_Exad_Testimonial_Carousel',
		];

        return $widgets;
    }

	/**
	 * Returns the instance.
	 * @since  1.4.4
	 * @return object
	 */
	
    public static function get_instance() {
		if ( ! isset( self::$instance ) ) :
			self::$instance = new self();
		endif;

		return self::$instance;
	}


}
