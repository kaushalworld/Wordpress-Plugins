<?php
namespace ExclusiveAddons\Pro\Includes\WooBuilder;

if ( ! defined( 'ABSPATH' ) ) exit;

use \ExclusiveAddons\Pro\Elementor\ProHelper;


/**
* Woo_Preview_Data
*/
class Woo_Preview_Data {

    /**
     * [$instance]
     * @var null
     */
    private static $instance   = null;

    /**
     * [$product_id]
     * @var null
     */
    private static $product_id = null;

    public static $preview_args = false;
	public static $preview_query = null;
	public static $current_post_id = 0;
	public static $template_id = 0;
	protected static $request = [];

    /**
     * [instance] Initializes a singleton instance
     * @return [Assets_Management]
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * [__construct] Class Constructor
     */
    function __construct(){

        if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		self::$template_id = get_option( 'exad_wc_single_product_id' );

		if ( empty( self::$template_id ) ) {
			return;
		}

        add_action( 'init', [ $this, 'init'] );
      
    }

    /**
     * [init] Initialize Function
     * @return [void]
     */
    public function init(){
        add_filter( 'body_class', [ $this, 'body_class' ] );
        add_filter( 'post_class', [ $this, 'post_class' ] );
    }

    /**
     * [body_class] Body Classes
     * @param  [type] $classes String
     * @return [void] 
     */
    public function body_class( $classes ){
        $post_type = get_post_type();
        if( $post_type == 'elementor_library' ){
            $classes[] = 'woocommerce';
            $classes[] = 'woocommerce-page';
            $classes[] = 'exad-woocommerce-builder';
            $classes[] = 'single-product';
        }
        return $classes;
    }

    /**
     * [post_class] Post Classes
     * @param  [type] $classes String
     * @return [void]
     */
    public function post_class( $classes ){
        $post_type = get_post_type();
        if( $post_type == 'elementor_library' ){
            $classes[] = 'product';
        }
        return $classes;
    }

      /**
     * [default] Show Default data in Elementor Editor Mode
     * @param  string $addons   Addon Name
     * @param  array  $settings Addon Settings
     * @return [html] 
     */
    public function default( $addons = '', $settings = array() ){

        global $post, $product;
        if( get_post_type() == 'product' ){
            self::$product_id = $product->get_id();
            
        }else{
            
            self::$product_id = ProHelper::exad_product_get_last_product_id();
            $product = wc_get_product( ProHelper::exad_product_get_last_product_id() );
            
        }
        
        if( $product ){
            switch ( $addons ){

                case 'product-add-to-cart':
                    ob_start();
                    echo '<div class="product">';
                    do_action( 'woocommerce_' . $product->get_type() . '_add_to_cart' );
                    echo '</div>';
                    return ob_get_clean();
                    break;
                    
                case 'exad-product-price':
                    ob_start();
                    ?>
                    <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>
                    <?php
                    return ob_get_clean();
                    break;

                case 'exad-product-short-description':
                    ob_start();
                    $short_description = get_the_excerpt( self::$product_id );
                    $short_description = apply_filters( 'woocommerce_short_description', $short_description );
                    if ( empty( $short_description ) ) { return; }
                    ?>
                        <div class="woocommerce-product-details__short-description"><?php echo wp_kses_post( $short_description ); ?></div>
                    <?php
                    return ob_get_clean();
                    break;

                case 'exad-single-product-description':
                    ob_start();
                    $description = get_post_field( 'post_content', self::$product_id );
                    if ( empty( $description ) ) { return; }
                    return $description .= ob_get_clean();
                    break;

                case 'exad-product-rating':
                    if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
                        return;
                    }
                    ob_start();
                    $rating_count = $product->get_rating_count();
                    $review_count = $product->get_review_count();
                    $average      = $product->get_average_rating();

                    if ( $rating_count > 0 ) : ?>
                        <div class="product">
                            <div class="woocommerce-product-rating">
                                <?php echo wc_get_rating_html( $average, $rating_count ); // WPCS: XSS ok. ?>
                                <?php if ( comments_open() ) : ?>
                                    <?php //phpcs:disable ?>
                                    <a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'exclusive-addons-elementor-pro' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)</a>
                                    <?php // phpcs:enable ?>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php else:?>
                        <?php echo '<div class="exad-nodata">'.__('No Rating Available','exclusive-addons-elementor-pro').'</div>';?>
                    <?php endif; 
                    return ob_get_clean();
                    break;

                case 'exad-product-image':
        
                    ob_start();
                    $columns = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
                    $thumbnail_id = $product->get_image_id();
                    $wrapper_classes = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
                        'woocommerce-product-gallery',
                        'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
                        'woocommerce-product-gallery--columns-' . absint( $columns ),
                        'images',
                    ) );

                    if ( function_exists( 'wc_get_gallery_image_html' ) ) {
                        ?>
                        <div class="product">
                            <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="transition: opacity .25s ease-in-out;float: none;width: 100%;">
                                <figure class="woocommerce-product-gallery__wrapper">
                                    <?php
                                    if ( $product->get_image_id() ) {
                                        $html = wc_get_gallery_image_html( $thumbnail_id, true );
                                    } else {
                                        $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                        $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'exclusive-addons-elementor-pro' ) );
                                        $html .= '</div>';
                                    }

                                    echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $thumbnail_id ); 
                                    // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

                                    $attachment_ids = $product->get_gallery_image_ids();

                                    if ( $attachment_ids && $product->get_image_id() ) {
                                        foreach ( $attachment_ids as $attachment_id ) {
                                            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
                                        }
                                    }
                                    
                                    do_action( 'woocommerce_before_single_product_summary' );
                                    ?>
                                </figure>
                            </div>
                        </div>
                        <?php
                    }
                    return ob_get_clean();
                    break;

                case 'exad-product-meta':
                    ob_start();
                    ?>
                     <?php wc_get_template( 'single-product/meta.php' ); ?>
                    <?php
                    return ob_get_clean();
                    break;

                case 'exad-product-tabs':

                    setup_postdata( $product->get_id() );
                    ob_start();
                    if( get_post_type() == 'elementor_library' ){
                        add_filter( 'the_content', [ $this, 'product_content' ] );
                    }
                    wc_get_template( 'single-product/tabs/tabs.php' );
                    return ob_get_clean();
                    break;

                case 'exad-single-product-reviews':
                    ob_start();
                    if( comments_open() ){
                        comments_template();
                    }
                    return ob_get_clean();
                    break;

                case 'exad-product-stock':
                    ob_start();
                    $availability = $product->get_availability();
                    ?>
                        <div class="product"><p class="stock <?php echo esc_attr( $availability['class'] ); ?>"><?php echo wp_kses_post( $availability['availability'] ); ?></p></div>
                    <?php
                    return ob_get_clean();
                    break;

                case 'exad-product-upsell':
                    ob_start();

                    $product_per_page   = '-1';
                    $columns            = 4;
                    $orderby            = 'rand';
                    $order              = 'desc';
                    if ( ! empty( $settings['exad_upsell_columns'] ) ) {
                        $columns = $settings['exad_upsell_columns'];
                    }
                    if ( ! empty( $settings['exad_upsell_orderby'] ) ) {
                        $orderby = $settings['exad_upsell_orderby'];
                    }
                    if ( ! empty( $settings['exad_upsell_order'] ) ) {
                        $order = $settings['exad_upsell_order'];
                    }
                    if ( ! empty( $settings['exad_product_upsell_posts_per_page'] ) ) {
                        $order = $settings['exad_product_upsell_posts_per_page'];
                    }
                    
                    woocommerce_upsell_display( $product_per_page, $columns, $orderby, $order );

                    return ob_get_clean();
                    break;

                case 'exad-product-related':
                    ob_start();
                    if ( ! $product ) { return; }
                    $args = [
                        'posts_per_page' => 9,
                        'columns'        => 4,
                        'orderby'        => 'rand',
                        'order'          => 'desc',
                    ];
                    if ( ! empty( $settings['posts_per_page'] ) ) {
                        $args['posts_per_page'] = $settings['posts_per_page'];
                    }
                    if ( ! empty( $settings['columns'] ) ) {
                        $args['columns'] = $settings['columns'];
                    }
                    wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );
                    $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), 
                        $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );

                    $args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

                    wc_get_template( 'single-product/related.php', $args );

                    return ob_get_clean();
                    break;

                case 'exad-product-related':
                    ob_start();
                    if ( ! $product ) { return; }

                    $next_post = get_next_post( true, '', 'product_cat' );
                    $prev_post = get_previous_post( true, '', 'product_cat' );
                    
            
                    $next_label_escaped = ! empty( $settings['exad_product_navigation_next_text'] ) ? $settings['exad_product_navigation_next_text'] : __( 'Nav', 'exclusive-addons-elementor-pro' );
                    $prev_label_escaped = ! empty( $settings['exad_product_navigation_prev_text'] ) ? $settings['exad_product_navigation_prev_text'] : __( 'Prev', 'exclusive-addons-elementor-pro' ); ?>
            
                    <div class="exad-product-nav-container">
                        <?php if ( ! empty( $settings['exad_product_nav_before'] ) ) : ?>
                                <p class="exad-nav-before" ><?php echo wp_kses_post( $settings['exad_product_nav_before'] );?></p>
                            <?php endif; ?>
                        
                            <ul class="exad-product-navigation">
                                <?php
                                if ( is_a( $prev_post, 'WP_Post' ) ) :
                                    ?>
                                    <li class="exad-product-navigation-link product-prev">
                                        <a class="exad-product-prev" href="<?php echo esc_url( get_the_permalink( $prev_post->ID ) ); ?>" aria-label="Previous" tabindex="-1">
                                        <?php Icons_Manager::render_icon( $settings['exad_product_navigation_prev_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                        <?php if ( !empty( $settings['exad_product_navigation_prev_text'] ) ) : ?>
                                            <span><?php echo $prev_label_escaped; ?></span>
                                        <?php endif; ?>
                                        </a>
                                        <div class="dropdown product-thumbnail prev-short-info">
                                            <a title="<?php echo esc_html( get_the_title( $prev_post->ID ) ); ?>" href="<?php echo esc_url( get_the_permalink( $prev_post->ID ) ); ?>"><?php echo get_the_post_thumbnail( $prev_post->ID, apply_filters( 'single_product_small_thumbnail_size', 'thumbnail' ) ) . '<h3 class="product-title">' . esc_html( get_the_title( $prev_post->ID ) ) . '</h3>'; ?></a>
                                        </div>
                                    </li>
                                    <?php
                                endif;
                
                                if ( is_a( $next_post, 'WP_Post' ) ) :
                                    ?>
                                    <li class="exad-product-navigation-link product-next">
                                        <a class="exad-product-next" href="<?php echo esc_url( get_the_permalink( $next_post->ID ) ); ?>" aria-label="Next" tabindex="-1">
                                            <?php if ( !empty( $settings['exad_product_navigation_next_text'] ) ) :  ?>
                                                <span><?php echo $next_label_escaped; ?></span>
                                            <?php endif;?>
                                            <?php Icons_Manager::render_icon( $settings['exad_product_navigation_next_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                        </a>
                                        <div class="dropdown product-thumbnail next-short-info">
                                            <a title="<?php echo esc_html( get_the_title( $next_post->ID ) ); ?>" href="<?php echo esc_url( get_the_permalink( $next_post->ID ) ); ?>"><?php echo get_the_post_thumbnail( $next_post->ID, apply_filters( 'single_product_small_thumbnail_size', 'thumbnail' ) ) . '<h3 class="product-title">' . esc_html( get_the_title( $next_post->ID ) ) . '</h3>'; ?></a>
                                        </div>
                                    </li>
                                    <?php
                                endif;
                                ?>
                            </ul>
                
                            <?php if ( ! empty( $settings['exad_product_nav_after'] ) ) : ?>
                                <p class="exad-nav-after" ><?php echo wp_kses_post( $settings['exad_product_nav_after'] );?></p>
                            <?php endif; ?>
                        </div>
                    <?php 
                    return ob_get_clean();
                    break;

                default: 
                    return '';
                    break;

            }
        }

    }

    /**
     * [product_content]
     * @param  [string] $content
     * @return [string] 
     */
    public function product_content( $content ){
        $product_content = get_post( self::$product_id );
        $content = $product_content->post_content;
        return $content;
    }

}
Woo_Preview_Data::instance();