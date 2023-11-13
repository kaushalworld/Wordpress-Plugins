<?php

if ( !function_exists( 'shopengine_pro_translator' ) ) {
    /**
     * @param $key
     * @param $value
     */
    function shopengine_pro_translator( $key, $value )
    {
        if(function_exists('shopengine_translator')) {
            return shopengine_translator($key, $value);
        }
        return $value;
    }
}

if ( !function_exists( 'shopengine_get_block_header' ) ) {
    /**
     * Will return the header
     */
    function shopengine_get_block_header(){
        if(wp_is_block_theme()){
            wp_head();
            block_header_area();
        }else{
            get_header();
        }
    }
}

if ( !function_exists( 'shopengine_get_block_footer' ) ) {
    /**
     * Will return the header
     */
    function shopengine_get_block_footer(){
        if(wp_is_block_theme()){
            wp_footer();
            block_footer_area();
         }else{
             get_footer();
         }
    }
}

if ( !function_exists( 'shopengine_pro_content_render' ) ) {
    function shopengine_pro_content_render($content) {
        //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $content;
    }
}
