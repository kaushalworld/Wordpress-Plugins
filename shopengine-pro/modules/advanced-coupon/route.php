<?php

namespace ShopEngine_Pro\Modules\Advanced_Coupon;

use ShopEngine\Base\Api;

class Route extends Api
{
    public function config()
    {
        $this->prefix = 'advanced-coupon';
        $this->param  = "";
    }

    public function get_export()
    {
        $data = $this->request->get_params();

        if (!empty($data['term'])) {

            $upload_dir = wp_upload_dir();

            $csv = $upload_dir['basedir'] . "/".$data['term']."-coupons.csv";

            $file = fopen($csv, 'w');

            $args = [
                'post_type' => 'shop_coupon',
                'tax_query' => [
                    [
                        'taxonomy' => 'shopengine_coupon_identifier',
                        'field'    => 'slug',
                        'terms'    => [$data['term']]
                    ]
                ]
            ];
            
            $posts = get_posts($args);

            foreach ($posts as $post) {
                $wc_coupon = new \WC_Coupon($post->post_title);
                fputcsv($file, [
                    'code'          => $wc_coupon->get_code(),
                    'amount'        => $wc_coupon->get_amount(),
                    'discount_type' => $wc_coupon->get_discount_type(),
                    'date_created'  => $wc_coupon->get_date_created(),
                    'date_expires'  => $wc_coupon->get_date_expires()
                ], ',');
            }

            fclose($file);

            $fsize      = filesize($csv) + 3;
            $path_parts = pathinfo($csv);

            header("Content-type: text/csv;charset=utf-8");
            header("Content-Disposition: attachment; filename=\"" . $path_parts["basename"] . "\"");
            header("Content-length: $fsize");

            ob_clean();
            flush();

            // csv encoding format
            echo "\xEF\xBB\xBF";
            readfile($csv);
            unlink($csv);
        }
    }
}
