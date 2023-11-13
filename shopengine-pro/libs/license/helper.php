<?php
namespace ShopEngine_Pro\Libs\License;

defined( 'ABSPATH' ) || exit;

class Helper{

    public static $instance = null;

    private $model;
    private $cache;

    public function __construct(){
        $this->model = \ShopEngine\Core\Register\Model::source('license');
    }

    public function get_cache($key){
        if(isset($this->cache[$key])){
            return $this->cache[$key];
        }

        return null;
    }

    public function set_cache($key, $value){
        $this->cache[$key] = $value;

        return true;
    }

    // public function get_license_info(){
    //     return apply_filters('shopengine_pro/license/extended', '');
    // }

	public function get_license() {
		$cached = $this->get_cache('shopengine_pro_license');
		if(null !== $cached) {
			return $cached;
		}

		$license = [
			'checksum' => $this->model->get_option('license_checksum'),
			'key'      => $this->model->get_option('license_key'),
		];

		$this->set_cache('shopengine_pro_license', $license);

		return $license;
	}

    public function activate($key){
        $data = [
            'key' => $key,
            'id' => \ShopEngine_Pro::product_id()
        ];
        $o = $this->com_validate($data);
        if(isset($o->validate) && $o->validate == 1){
            $this->model->set_option('license_checksum', $o->oppai);
            $this->model->set_option('license_key', $o->key);
        }

        return $o;
    }
    public function revoke(){
        $data = [
            'key' => $this->model->get_option('license_key'),
        ];

        $this->model->delete_option('license_checksum');
        $this->model->delete_option('license_key');

        return true;
    }
    public function com_validate($data = []){
        if(strlen($data['key']) < 28){
            return null;
        }
        $data['oppai'] = $this->model->get_option('license_checksum');
        $data['action'] = 'activate';
        $data['v'] = \ShopEngine_Pro::version();
        $url = \ShopEngine_Pro::api_url() . 'license?' . http_build_query($data);

        $args = array(
            'timeout'     => 60,
            'redirection' => 3,
            'httpversion' => '1.0',
            'blocking'    => true,
            'sslverify'   => true,
        );

        $res = wp_remote_get( $url, $args );

        return (object) json_decode(
            (string) $res['body']
        );
    }

    public function com_revoke($data = []){
        $data['oppai'] = $this->model->get_option('license_checksum');
        $data['action'] = 'revoke';
        $data['v'] = \ShopEngine_Pro::version();
        $url = \ShopEngine_Pro::api_url() . 'license?' . http_build_query($data);

        $args = array(
            'timeout'     => 10,
            'redirection' => 3,
            'httpversion' => '1.0',
            'blocking'    => true,
            'sslverify'   => true,
        );

        $res = wp_remote_get( $url, $args );

        return (object) json_decode(
            (string) $res['body']
        );
    }

    public function status(){
        $cached = $this->get_cache( 'shopengine_pro_license_status' );
		if ( null !== $cached ) {
			return $cached;
        }

        $oppai = $this->model->get_option('license_checksum');
        $key = $this->model->get_option('license_key');
        $status = 'invalid';

        if($oppai != '' && $key != ''){
            $status = 'valid';
        }
        $this->set_cache( 'shopengine_pro_license_status', $status );

        return $status;
    }

    public static function instance() {
        if ( is_null( self::$instance ) ) {

            // Fire the class instance
            self::$instance = new self();
        }

        return self::$instance;
    }
}
