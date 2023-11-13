<?php

namespace ExclusiveAddons\Elementor;

use Elementor\Controls_Manager;

class Mailchimp_API {

    public static function init() {
        add_action( 'wp_ajax_exad_mailchimp_subscriber', [ __CLASS__, 'mailchimp_subscribe_through_ajax' ] );
        add_action( 'wp_ajax_nopriv_exad_mailchimp_subscriber', [ __CLASS__, 'mailchimp_subscribe_through_ajax' ] );
	}

    public static function mailchimp_subscribe( $email, $status, $list_id, $api_key, $merge_fields = array( 'FNAME' => '', 'LNAME' => '' ) ) {
        $data = array(
            'apikey'        => $api_key,
            'email_address' => $email,
            'status'        => $status,
            'merge_fields'  => $merge_fields
        );

        // cURL Setup
        $exad_mailchimp = curl_init();
        curl_setopt( $exad_mailchimp, CURLOPT_URL, 'https://' . substr( $api_key, strpos($api_key, '-' ) + 1 ) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower( $data['email_address'] ) ) );
        curl_setopt( $exad_mailchimp, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Authorization: Basic ' . base64_encode( 'user:' . $api_key ) ) );
        curl_setopt( $exad_mailchimp, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $exad_mailchimp, CURLOPT_CUSTOMREQUEST, 'PUT' );
        curl_setopt( $exad_mailchimp, CURLOPT_TIMEOUT, 10 );
        curl_setopt( $exad_mailchimp, CURLOPT_POST, true );
        curl_setopt( $exad_mailchimp, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $exad_mailchimp, CURLOPT_POSTFIELDS, json_encode( $data ) );

        $result = curl_exec( $exad_mailchimp );
        return $result;
    }

    /**
     * Mailchimp Ajax subscription
     * 
     */
    public static function mailchimp_subscribe_through_ajax() {
        $api_key = $_POST['apiKey'];
        $list_id = $_POST['listId'];
        if ( isset( $_POST['fields'] ) ) :
            parse_str($_POST['fields'], $settings);
        else :
            return;
        endif;

        $merge_fields = array(
            'FNAME' => !empty( $settings['exad_mailchimp_firstname'] ) ? $settings['exad_mailchimp_firstname'] : '',
            'LNAME' => !empty( $settings['exad_mailchimp_lastname'] ) ? $settings['exad_mailchimp_lastname'] : '',
        );

        $result = json_decode( self::mailchimp_subscribe( $settings['exad_mailchimp_email'], 'subscribed', $list_id, $api_key, $merge_fields, @$settings['exad_mailchimp_phone'] ) );

        if ( 400 === $result->status ) :
            _e( 'Error', 'exclusive-addons-elementor-pro' );
        elseif ( 'subscribed' === $result->status ) :
            _e( 'Congratulation, You have subscribed successfully!', 'exclusive-addons-elementor-pro' );
        endif;
        die();
    }

}

Mailchimp_API::init();
