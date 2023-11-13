<?php
namespace ExclusiveAddons\Pro\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Addons_Manager {

    /**
     * 
     * Check Activated Widgets
     */
    public static $is_pro_activated_feature;
        

	/**
	 * Initialize
	 */
	public static function init() {
        // Add Elementor Widgets
        add_filter( 'exad_add_pro_widgets', [ __CLASS__, 'add_pro_widgets_to_free' ] );
        add_filter( 'exad_add_pro_extensions', [ __CLASS__, 'add_pro_extensions_to_free' ] );
        self::activated_pro_features();
        add_action( 'elementor/widgets/register', [ __CLASS__, 'initiate_pro_widgets' ] );
        self::initiate_pro_extensions();

        if ( class_exists( 'woocommerce' ) ) {

            add_filter( 'exad_add_pro_widgets', [ __CLASS__, 'add_woo_pro_widgets_to_free' ] ); 
            add_action( 'elementor/widgets/register', [ __CLASS__, 'initiate_woo_pro_widgets' ] );
            
        }
    }

    /**
     * Add Pro Widgets to Free Plugin
     * 
     */
    public static function add_pro_widgets_to_free( $widget_lists ) {
        return array_merge( $widget_lists, self::widget_map_pro() );
    }

    /**
     * Add Pro Widgets to Free Plugin
     * 
     */
    public static function add_pro_extensions_to_free( $extension_lists ) {
        return array_merge( $extension_lists, self::extension_map_pro() );
    }

    /**
     * Add Woo Pro Widgets to Free Plugin
     * 
     */
    public static function add_woo_pro_widgets_to_free( $widget_lists ) {
        return array_merge( $widget_lists, self::woo_widget_map_pro() );
    }

    /**
     * This function returns true for all activated widgets
     *
    * @since  1.0
    */
    public static function activated_pro_features() {
        $pro_all_features_array = array_merge( array_keys( self::widget_map_pro() ), array_keys( self::extension_map_pro() ), array_keys( self::woo_widget_map_pro() ) );
        $pro_all_features_settings  = array_fill_keys( $pro_all_features_array, true );
        self::$is_pro_activated_feature = get_option( 'exad_save_settings', $pro_all_features_settings );
    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them
     *
     * @since 1.0.0
     *
     * @access public
     */
    public static function initiate_pro_widgets() {

        foreach( self::widget_map_pro() as $key => $widget ) {
            if ( isset( self::$is_pro_activated_feature[$key] ) && self::$is_pro_activated_feature[$key] == true ) {

                $widget_file = EXAD_PRO_ELEMENTS . $key . '/'. $key .'.php';
                if ( file_exists( $widget_file ) ) {
                    require_once $widget_file;
                }
            }
        }
    }

    /**
     * 
     * Manage Extensions
     * 
     */
    public static function initiate_pro_extensions() {

        foreach( self::extension_map_pro() as $key => $extension ) {
            if ( isset( self::$is_pro_activated_feature[$key] ) && self::$is_pro_activated_feature[$key] == true ) {

                $extension_file = EXAD_PRO_EXTENSIONS . $key .'.php';
                if ( file_exists( $extension_file ) ) {
                    include_once $extension_file;
                }
            }
        }

    }

     /**
     * Init woo Widgets
     *
     * Include widgets files and register them
     *
     * @since 1.0.0
     *
     * @access public
     */
    public static function initiate_woo_pro_widgets() {

        foreach( self::woo_widget_map_pro() as $key => $widget ) {
            if ( isset( self::$is_pro_activated_feature[$key] ) && self::$is_pro_activated_feature[$key] == true ) {

                $widget_file = EXAD_PRO_ELEMENTS . $key . '/'. $key .'.php';
                if ( file_exists( $widget_file ) ) {
                    require_once $widget_file;
                }
            }
        }
    }
    
    /**
     * Pro version Widget Map
     * 
     */
    public static function widget_map_pro() {
        return [
            'animated-shape'  => [
                'title'  => __( 'Animated Shape', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Animated_Shape',
                'demo_link' => 'https://exclusiveaddons.com/animated-shape/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'author-box'  => [
                'title'  => __( 'Author Box', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Author_Box',
                'demo_link' => 'https://exclusiveaddons.com/author-box/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'floating-animation'  => [
                'title'  => __( 'Floating Animation', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Floating_Animation',
                'demo_link' => 'https://exclusiveaddons.com/floating-animation/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'breadcrumb'  => [
                'title'  => __( 'Breadcrumb', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Breadcrumb',
                'demo_link' => 'https://exclusiveaddons.com/exclusive-addons/breadcrumb/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'business-hours'  => [
                'title'  => __( 'Business Hours', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Business_Hours',
                'demo_link' => 'https://exclusiveaddons.com/business-hours/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'campaign'  => [
                'title'  => __( 'Campaign', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Campaign',
                'demo_link' => 'https://exclusiveaddons.com/campaign/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'chart'  => [
                'title'  => __( 'Chart', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Chart',
                'demo_link' => 'https://exclusiveaddons.com/chart/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'comparison-table'  => [
                'title'  => __( 'Comparison Table', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Comparison_Table',
                'demo_link' => 'https://exclusiveaddons.com/comparison-table/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'content-switcher'  => [
                'title'  => __( 'Content Switcher', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Content_Switcher',
                'demo_link' => 'https://exclusiveaddons.com/content-switcher/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'cookie-consent'  => [
                'title'  => __( 'Cookie Consent', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Cookie_Consent',
                'demo_link' => 'https://exclusiveaddons.com/cookie-consent/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'counter'  => [
                'title'  => __( 'Counter', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Counter',
                'demo_link' => 'https://exclusiveaddons.com/counter/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'demo-previewer'  => [
                'title'  => __( 'Demo Previewer', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Demo_Previewer',
                'demo_link' => 'https://exclusiveaddons.com/demo-previewer/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'gravity-form'  => [
                'title'  => __( 'Gravity Form', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Gravity_Form',
                'demo_link' => 'https://exclusiveaddons.com/gravity-form/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'iconbox'  => [
                'title'  => __( 'Icon Box', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Iconbox',
                'demo_link' => 'https://exclusiveaddons.com/icon-box/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'image-carousel'  => [
                'title'  => __( 'Image Carousel', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Image_Carousel',
                'demo_link' => 'https://exclusiveaddons.com/image-carousel/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'image-hotspot'  => [
                'title'  => __( 'Image Hotspot', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Image_Hotspot',
                'demo_link' => 'https://exclusiveaddons.com/image-hotspot/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'image-mask'  => [
                'title'  => __( 'Image Mask', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Image_Mask',
                'demo_link' => 'https://exclusiveaddons.com/image-mask/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'instagram-feed'  => [
                'title'  => __( 'Instagram Feed', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Instagram_Feed',
                'demo_link' => 'https://exclusiveaddons.com/instagram-feed/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'login-register'  => [
                'title'  => __( 'Login Form', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Login_Register',
                'demo_link' => 'https://exclusiveaddons.com/login-register/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'lottie-animation'  => [
                'title'  => __( 'Lottie Animation', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Lottie_Animation',
                'demo_link' => 'https://exclusiveaddons.com/lottie-animation/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'mailchimp'  => [
                'title'  => __( 'MailChimp', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\MailChimp',
                'demo_link' => 'https://exclusiveaddons.com/mailchimp/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'mega-menu'  => [
                'title'  => __( 'Mega Menu', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Mega_Menu',
                'demo_link' => 'https://exclusiveaddons.com/mega-menu/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'navigation-menu'  => [
                'title'  => __( 'Navigation Menu', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Navigation_Menu',
                'demo_link' => 'https://exclusiveaddons.com/navigation-menu/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'news-ticker-pro'  => [
                'title'  => __( 'News Ticker', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\News_Ticker_Pro',
                'demo_link' => 'https://exclusiveaddons.com/news-tricker-pro/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'off-canvas'  => [
                'title'  => __( 'Off Canvas', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Off_Canvas',
                'demo_link' => 'https://exclusiveaddons.com/off-canvas/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'page-title'  => [
                'title'  => __( 'Page Title', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Page_Title',
                'demo_link' => 'https://exclusiveaddons.com/page-title/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'post-carousel'  => [
                'title'  => __( 'Post Carousel', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Post_Carousel',
                'demo_link' => 'https://exclusiveaddons.com/post-carousel/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'post-navigation'  => [
                'title'  => __( 'Post Navigation', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Post_Navigation',
                'demo_link' => 'https://exclusiveaddons.com/post-navigation/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'post-slider'  => [
                'title'  => __( 'Post Slider', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Post_Slider',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-breadcrumb'  => [
                'title'  => __( 'Product Breadcrumb', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Breadcrumb',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-title'  => [
                'title'  => __( 'Product Title', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Title',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'product-image'  => [
                'title'  => __( 'Product Image ', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Image',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-price'  => [
                'title'  => __( 'Product Price', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Price',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],  
            'product-rating'  => [
                'title'  => __( 'Product Rating', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Rating',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],   
            'product-add-to-cart'  => [
                'title'  => __( 'Product Add to Cart', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Add_to_Cart',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],  
            'product-short-description'  => [
                'title'  => __( 'Product Short Description', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Short_Description',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-meta'  => [
                'title'  => __( 'Product Meta', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Meta',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-stock'  => [
                'title'  => __( 'Product Stock', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Stock',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'product-upsell'  => [
                'title'  => __( 'Product Upsell', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Upsell',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-cross-sell'  => [
                'title'  => __( 'Product Cross Sell', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Cross_Sell',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],   
            'product-tabs'  => [
                'title'  => __( 'Product Tabs', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_tabs',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-qr-code'  => [
                'title'  => __( 'Product QR Code', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_QR_Code',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'product-related'  => [
                'title'  => __( 'Product Related', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Related',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],   
            'product-navigation'  => [
                'title'  => __( 'Product Navigation', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Navigation',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'search-form'  => [
                'title'  => __( 'Search Form', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Search_Form',
                'demo_link' => 'https://exclusiveaddons.com/search/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'site-logo'  => [
                'title'  => __( 'Site Logo', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Site_Logo',
                'demo_link' => 'https://exclusiveaddons.com/site-logo/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'site-title'  => [
                'title'  => __( 'Site Title', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Site_Title',
                'demo_link' => 'https://exclusiveaddons.com/site-title/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'site-title'  => [
                'title'  => __( 'Site Title', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Site_Title',
                'demo_link' => 'https://exclusiveaddons.com/site-title/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'site-tagline'  => [
                'title'  => __( 'Site Tagline', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Site_Tagline',
                'demo_link' => 'https://exclusiveaddons.com/site-tagline/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'social-share'  => [
                'title'  => __( 'Social Share', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Social_Share',
                'demo_link' => 'https://exclusiveaddons.com/social-share/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'slider'  => [
                'title'  => __( 'Slider', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Slider',
                'demo_link' => 'https://exclusiveaddons.com/slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'source-code'  => [
                'title'  => __( 'Source Code', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Source_Code',
                'demo_link' => 'https://exclusiveaddons.com/source-code/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'table'  => [
                'title'  => __( 'Table', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Table',
                'demo_link' => 'https://exclusiveaddons.com/table/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'team-carousel'  => [
                'title'  => __( 'Team Carousel', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Team_Carousel',
                'demo_link' => 'https://exclusiveaddons.com/team-carousel/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'template'  => [
                'title'  => __( 'Template', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Template',
                'demo_link' => 'https://exclusiveaddons.com/template/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'testimonial-carousel'  => [
                'title'  => __( 'Testimonial Carousel', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Testimonial_Carousel',
                'demo_link' => 'https://exclusiveaddons.com/testimonial-carousel/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'thankyou-customer-address-details'  => [
                'title'  => __( 'Customer Address Details', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Woo_Customer_Address_Details',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],   
            'thankyou-order'  => [
                'title'  => __( 'Thank You Order', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Woo_Thank_you_order',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'thankyou-order-details'  => [
                'title'  => __( 'Thank You Order Details', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Woo_Thank_you_order_Details',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'woo-my-account'  => [
                'title'  => __( 'Woo My Account', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\WC_My_Account',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'woo-add-to-cart'  => [
                'title'  => __( 'Woo Mini Cart', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Woo_Mini_Cart',
                'demo_link' => 'https://exclusiveaddons.com/woo-add-to-cart',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'woo-cart'  => [
                'title'  => __( 'Woo Cart', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Woo_Cart',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'woo-category'  => [
                'title'  => __( 'Woo Category', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Woo_Category',
                'demo_link' => 'https://exclusiveaddons.com/woo-category/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'woo-checkout'  => [
                'title'  => __( 'Woo Checkout', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Woo_Checkout',
                'demo_link' => 'https://exclusiveaddons.com/shop',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'woo-products'  => [
                'title'  => __( 'Woo Products', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Woo_Products',
                'demo_link' => 'https://exclusiveaddons.com/woo-product/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'woo-products-carousel'  => [
                'title'  => __( 'Woo Product Carousel', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Woo_Product_Carousel',
                'demo_link' => 'https://exclusiveaddons.com/woo-products-carousel-demo',
                'tags'   => 'pro',
                'is_pro' => true
            ]
        ];
    }

    public static function extension_map_pro() {
        return [
            'section-particles'  => [
                'title'  => __( 'Section Particles', 'exclusive-addons-elementor-pro' ),
                'class'  => '\Exclusive_Addons\Elementor\Extensions\Section_Particles',
                'tags'   => 'pro',
                'demo_link' => 'https://exclusiveaddons.com/section-particles/',
                'is_pro' => true
            ],
            'section-parallax'  => [
                'title'  => __( 'Section Parallax', 'exclusive-addons-elementor-pro' ),
                'class'  => '\Exclusive_Addons\Elementor\Extensions\Section_Parallax',
                'tags'   => 'pro',
                'demo_link' => 'https://exclusiveaddons.com/section-parallax/',
                'is_pro' => true
            ],
            'gradient-animation'  => [
                'title'  => __( 'Gradient Animation', 'exclusive-addons-elementor-pro' ),
                'class'  => '\Exclusive_Addons\Elementor\Extensions\Gradient_Animation',
                'tags'   => 'pro',
                'demo_link' => 'https://exclusiveaddons.com/gradient-animation/',
                'is_pro' => true
            ],
            'cross-site-copy-paste'  => [
                'title'  => __( 'Cross Site Copy Paste', 'exclusive-addons-elementor-pro' ),
                'class'  => '\Exclusive_Addons\Elementor\Extensions\Cross_Site_Copy_Paste',
                'tags'   => 'pro',
                'demo_link' => 'https://exclusiveaddons.com/cross-site-copy-paste',
                'is_pro' => true
            ]
        ];
    }

    
    public static function woo_widget_map_pro() {
        return [
            'product-breadcrumb'  => [
                'title'  => __( 'Product Breadcrumb', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Breadcrumb',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-title'  => [
                'title'  => __( 'Product Title', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Title',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'product-thumbnail'  => [
                'title'  => __( 'Product Thumbnail ', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Image',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-price'  => [
                'title'  => __( 'Product Price', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Price',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],  
            'product-rating'  => [
                'title'  => __( 'Product Rating', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Rating',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],   
            'product-add-to-cart'  => [
                'title'  => __( 'Product Add to Cart', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Add_to_Cart',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],  
            'product-short-description'  => [
                'title'  => __( 'Product Short Description', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Short_Description',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-meta'  => [
                'title'  => __( 'Product Meta', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Meta',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-stock'  => [
                'title'  => __( 'Product Stock', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Stock',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'product-upsell'  => [
                'title'  => __( 'Product Upsell', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Upsell',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-cross-sell'  => [
                'title'  => __( 'Product Cross Sell', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Cross_Sell',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],   
            'product-tabs'  => [
                'title'  => __( 'Product Tabs', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_tabs',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],
            'product-qr-code'  => [
                'title'  => __( 'Product QR Code', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_QR_Code',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ], 
            'product-related'  => [
                'title'  => __( 'Product Related', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Related',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ],   
            'product-navigation'  => [
                'title'  => __( 'Product Navigation', 'exclusive-addons-elementor-pro' ),
                'class'  => '\ExclusiveAddons\Elements\Product_Navigation',
                'demo_link' => 'https://exclusiveaddons.com/post-slider/',
                'tags'   => 'pro',
                'is_pro' => true
            ]
        ];
    }

}

Addons_Manager::init();
