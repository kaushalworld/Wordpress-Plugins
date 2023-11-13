<?php

use WPRA\Config;
use WPRA\Helpers\Utils;

$shortcode = null;
isset( $data ) && extract( $data );

if ( is_null( $shortcode ) ) return;
?>

<tr data-sgc_id="<?php echo $shortcode->id; ?>">
    <td><?php echo $shortcode->id; ?></td>
    <td><?php Utils::echoIf(empty($shortcode->post_type), 'N/A' ,$shortcode->post_type); ?></td>
    <td><span><?php echo $shortcode->name; ?></span>
		<?php if ( $shortcode->id == Config::$settings['woo_shortcode_id'] ): ?>
            <img style="width:30px;margin-left:10px;" src="<?php echo Utils::getAsset( 'images/woo-logo-original.svg' ); ?>">
		<?php endif; ?>
    </td>
    <td class="generated-sgc">
        <input type="text"
               value="<?php echo esc_attr( '[wpreactions sgc_id="' . $shortcode->id . '"]' ); ?>"
               class="form-control" readonly spellcheck="false">
    </td>
    <td class="td-sm text-center">
        <span class="sgc-action sgc-view" href="#"><i class="qa qa-eye"></i>
            <span class="sgc-view-popup"><span></span></span>
        </span>
    </td>
    <td class="td-sm text-center">
        <span class="sgc-action sgc-edit" href="#"><i class="qa qa-edit"></i></span>
    </td>
    <td class="td-sm text-center">
        <span class="sgc-action sgc-clone" href="#"><i class="qa qa-copy"></i></span>
    </td>
    <td class="td-sm text-center">
        <span class="sgc-action sgc-delete" href="#"><i class="qa qa-trash"></i></span>
    </td>
</tr>
