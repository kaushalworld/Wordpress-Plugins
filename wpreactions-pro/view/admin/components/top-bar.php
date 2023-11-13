<?php
use WPRA\Helpers\Utils;
use WPRA\Config;
use WPRA\Helpers\Notices;

$layout = $tooltip = $section_title = '';
$screen  = 'global';
isset( $data ) && extract( $data );

?>
<div class="wpra-messages-container"></div>
<div class="wpra-header">
    <div class="wpra-header-logo">
        <i class="qas qa-bars floating-menu-toggler"></i>
        <img src="<?php echo Utils::getAsset( 'images/logo.svg' ); ?>" alt="">
        <div class="top-section-title">
            <span class="tt-1"><?php echo $section_title; ?></span>
			<?php if (!empty( $layout )):
				echo '<span class="tt-2">' . Config::getLayoutValue( $layout, 'name' ) . '</span>';
			endif; ?>
        </div>
    </div>
    <div class="wpra-header-links">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="https://helpdesk.wpreactions.com" target="_blank">
                    <span><?php _e( 'Documentation', 'wpreactions' ); ?></span><i class="qa qa-external-link-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://wpreactions.com/support/" target="_blank">
                    <span><?php _e( 'Support', 'wpreactions' ); ?></span><i class="qa qa-external-link-alt"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<div style="padding-bottom: 90px"></div>

<?php
Notices::printAll();
