<?php
namespace ExclusiveAddons\Pro\Elementor;

class ProHelper {

    /**
     * 
     * Return the Primary Color from Plugin Settings
     * @return string of the color code
     * 
     */
    public static $primary_color;

    /**
     * 
     * Return the Posts from Database
     *
     * @return string of an html markup with AJAX call.
     * @return array of content and found posts count without AJAX call.
     */

    public static function exad_get_posts( $settings ) {
        
        $posts = new \WP_Query( $settings['post_args'] );

        while( $posts->have_posts() ) : $posts->the_post(); 

            if ( 'exad-post-carousel' === $settings['template_type'] ) { 
                include EXAD_PRO_TEMPLATES . 'tmpl-post-carousel.php';
            } else {
                _e( 'No Contents Found', 'exclusive-addons-elementor-pro' );
            }

        endwhile;

        wp_reset_postdata();
    }

    public function get_primary_color() {
        self::$primary_color = get_option( 'exad_primary_color_option', '#7a56ff' );
    }
    

    /**
     * Return the site domain
     */
    public static function get_site_domain() {
        return str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
    }


    /**
     * get all types of posts
     */
    public static function exad_get_all_post_type_options() {

        $post_types = get_post_types(array('public' => true), 'objects');

        $options = array();
        unset( $post_types['elementor_library'] );
        unset( $post_types['attachment'] );

        foreach ($post_types as $post_type) {
            $options[$post_type->name] = $post_type->label;
        }

        return $options;
    }


    /**
     * Get Gravity Form Items.
     */
    public static function exad_get_gravity_forms() {
        $forms = array();
        if ( class_exists('GFCommon') ) {
            $gravity_forms = \RGFormsModel::get_forms( null, 'title' );
            if ( !empty($gravity_forms ) && !is_wp_error( $gravity_forms ) ) {

                $forms[0] = esc_html__( 'Select a Gravity Form', 'exclusive-addons-elementor-pro' );
                foreach ($gravity_forms as $form) {
                    $forms[$form->id] = $form->title;
                }

            } else {
                $forms[0] = esc_html__( 'Create a form first', 'exclusive-addons-elementor-pro' );
            }
        }
        return $forms;
    }

    public static function exad_woo_product_categories_fetch( $post_type ) {

        $options = array();
        $taxonomy = 'product_cat';

        if ( ! empty( $taxonomy ) ) {
            // Get categories for post type.
            $terms = get_terms(
                array(
                    'taxonomy'   => $taxonomy,
                    'hide_empty' => false,
                )
            );
            if ( ! empty( $terms ) ) {
                $options = ['' => ''];
                foreach ( $terms as $term ) {
                    if ( isset( $term ) ) {
                        if ( isset( $term->term_id ) && isset( $term->name ) ) {
                            $options[ $term->term_id ] = $term->name;
                        }
                    }
                }
            }
        }

        return $options;
    } 

    public static function exad_mailchimp_list_items() {
        $api_key = get_option('exad_save_mailchimp_api');
        $data = array(
            'apikey' => $api_key
        );

        $exad_mailchimp = curl_init();
        curl_setopt( $exad_mailchimp, CURLOPT_URL, 'https://' . substr( $api_key, strpos( $api_key, '-' ) + 1 ) . '.api.mailchimp.com/3.0/lists/' );
        curl_setopt( $exad_mailchimp, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Authorization: Basic ' . base64_encode( 'user:' . $api_key ) ) );
        curl_setopt( $exad_mailchimp, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $exad_mailchimp, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt( $exad_mailchimp, CURLOPT_TIMEOUT, 10 );
        curl_setopt( $exad_mailchimp, CURLOPT_POST, true );
        curl_setopt( $exad_mailchimp, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $exad_mailchimp, CURLOPT_POSTFIELDS, json_encode( $data ) );

        $lists = curl_exec( $exad_mailchimp );
        $lists = json_decode( $lists );
        if ( ! empty( $lists ) && ! empty( $lists->lists ) ) {
            $lists_name = array( '' => __( 'Select a mailChimp Form', 'exclusive-addons-elementor-pro' ) );
            for ( $i = 0; $i < count( $lists->lists ); $i++ ) {
                $lists_name[$lists->lists[$i]->id] = $lists->lists[$i]->name;
            }
            return $lists_name;
        }
    }

    /**
     * Contain masking shape list
     * @param $element
     * @return array
     */
    public static function exad_masking_shape_list( $element ) {
        $dir = EXAD_PRO_ASSETS_URL . 'img/masking/';
        $shape_name = 'shape-';
        $extension = '.svg';
        $list = [];
        if ( 'list' == $element ) {
            for ($i = 1; $i <= 64; $i++) {
                $list[$shape_name.$i] = [
                    'title' => ucwords($shape_name.''.$i),
                    'url' => $dir . $shape_name . $i . $extension,
                ];
            }
        } elseif ( 'url' == $element ) {
            for ($i = 1; $i <= 64; $i++) {
                $list[$shape_name.$i] = $dir . $shape_name . $i . $extension;
            }
        }
        return $list;
    }

    // Sidebar Widgets
	public static function get_widget_option() {
		global $wp_registered_sidebars;
		$sidebar_options = [];

		if ( ! $wp_registered_sidebars ) {
			$sidebar_options['0'] = esc_html__( 'No sidebars were found', 'exclusive-addons-elementor-pro' );
		} else {
			$sidebar_options['0'] = esc_html__( 'Select Sidebar', 'exclusive-addons-elementor-pro' );

			foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
				$sidebar_options[ $sidebar_id ] = $sidebar['name'];
			}
		}

		return $sidebar_options;
	}
   
    /**
    * Woocommerce Product last product id return for preview or elementor edit
    */
    public static function exad_product_get_last_product_id(){
        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'order'          => 'DESC',
            'orderby'        => 'ID',

        );
        $the_query = new \WP_Query( $args );
        // The Loop
        if ( $the_query->have_posts() ) {
                $product_id = array();
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    
                    $product_id[] = get_the_ID();

                    return reset($product_id);
                }
            }else {
                
        }
        /* Restore original Post Data */
        wp_reset_postdata();
      
    }

    /**
    * Woocommerce Product last order id return
    */
    public static function exad_product_get_last_order_id(){
        $statuses = array_keys(wc_get_order_statuses());
        $statuses = implode( "','", $statuses );

        $args = array(
            'post_type'      => 'shop_order',
            'post_status'    => $statuses,
            'posts_per_page' => 1,
            'order'          => 'DESC',
            'orderby'        => 'ID',

        );
        $the_query = new \WP_Query( $args );
        // The Loop
        if ( $the_query->have_posts() ) {
                $product_id = array();
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    
                    $product_id[] = get_the_ID();

                    return reset($product_id);
                }
            }else {
                
            }
            /* Restore original Post Data */
            wp_reset_postdata();
        
    }

    public static function is_woo_single_template_active( $template_id ) {

        $request = [];

		if ( empty( $request ) ) {
			$request = $_REQUEST;
		}

		if ( isset( $request['action'] ) && 'elementor' === $request['action'] && is_admin() && $template_id == $request['post'] ) {
			return true;
		}
		if ( isset( $request['elementor_library'] ) && isset( $request['preview_id'] ) && $template_id == $request['preview_id'] ) {
			return true;
		}
		if ( isset( $request['elementor_library'] ) && isset( $request['elementor-preview'] ) && $template_id == $request['elementor-preview'] ) {
			return true;
		}
		if ( isset( $_SERVER['HTTP_REFERER'] ) && is_admin() ) {
			$http_referer = $_SERVER['HTTP_REFERER'];
			if ( strpos( $http_referer, 'action=elementor' ) !== false && strpos( $http_referer, 'post=' . $template_id ) !== false ) {
				return true;
			}
		}

		return false;
	}
}
