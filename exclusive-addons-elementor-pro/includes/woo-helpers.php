<?php

    /**
     * Woo My Account page show user info
     */
    function exad_get_userinfo() {
        $user_info = wp_get_current_user();
        $url = get_avatar_url( get_current_user_id() );

        $userinfo   = '';
        
        $userinfo .= '<li class="exad-user-info">';
        $userinfo .= '<div class="exad-user-wrapper">';
        $userinfo .= '<div class="exad-user-thumb">';
        $userinfo .= '<img class="user-img" src="' . esc_url($url) .'" alt="'. esc_attr( $user_info->user_nicename ) . '">';
        $userinfo .= '</div>';
        $userinfo .= '<div class="exad-user-name">';
        $userinfo .= '<h4 class="name">'. esc_html( $user_info->user_nicename ) . '</h3>';
        $userinfo .= '</div>';
        $userinfo .= '</div>';
        $userinfo .= '</li>';

        echo $userinfo;
    }