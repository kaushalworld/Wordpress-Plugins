


case 'activate':
                if($key == ''){
                    $result['message'] = esc_html__('Your key is empty', 'shopengine-pro');
                    echo $this->return_json($result); wp_die();
                }
        
                $o = License::instance()->activate( $key );
                if ( is_object($o) ) {
                    $result = $o;
                }
            
            break;
            case 'revoke':
                License::instance()->revoke();
                wp_redirect('https://account.wpmet.com/?wpmet-screen=products'); exit;