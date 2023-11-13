<?php

defined( 'ABSPATH' ) || exit;

if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || isset($_GET['shopengine_template_id'])) {
    $args = array(
        'key'   => 'dummy',
        'login' => 'dummy',
    );
    include 'content.php';
    
}else{
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( ! empty( $_GET['show-reset-form'] ) ) { 
        if ( isset( $_COOKIE[ 'wp-resetpass-' . COOKIEHASH ] ) && 0 < strpos( $_COOKIE[ 'wp-resetpass-' . COOKIEHASH ], ':' ) ) {  // @codingStandardsIgnoreLine
            list( $rp_id, $rp_key ) = array_map( 'wc_clean', explode( ':', wp_unslash( $_COOKIE[ 'wp-resetpass-' . COOKIEHASH ] ), 2 ) ); // @codingStandardsIgnoreLine
            $userdata               = get_userdata( absint( $rp_id ) );
            $rp_login               = $userdata ? $userdata->user_login : '';
            $user                   = check_password_reset_key( $rp_key, $rp_login );
    
            // Reset key / login is correct, display reset password form with hidden key / login values.
            if ( is_object( $user ) ) {
                $args = array(
                    'key'   => $rp_key,
                    'login' => $rp_login,
                );
               
                include 'content.php';
            }
        }else{
            
            /**
             * wp_redirect function is not working here. That is why using js to redirect
             */
            $url = home_url().'/my-account/lost-password'; 
            ?>
            <script>
                location.href = '<?php echo esc_url($url); ?>';
            </script>
            <?php           
        }
    }
}

