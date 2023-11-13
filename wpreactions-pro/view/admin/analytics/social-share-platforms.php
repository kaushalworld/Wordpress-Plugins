<?php
use WPRA\Helpers\Utils;
use WPRA\Config;

$social_data = $options = [];
if (isset($data)) {
    extract($data);
}
?>
    <div class="wpra-analytics-social-wrap">
		<?php foreach ( Config::$social_platforms as $platform => $defaults ):?>
            <div class="wpra-analytics-social-item wpra-white-box">
                <div class="social-item-icon" style="background-color: <?php echo $defaults['color']; ?>40;">
                    <span style="background-color: <?php echo $defaults['color']; ?>">
                        <img src="<?php echo Utils::getAsset( "images/social/$platform.svg" ); ?>" alt="">
                    </span>
                </div>
                <div class="social-item-count">
                    <p><?php echo isset( $social_data[ $platform ] ) ? $social_data[ $platform ] : 0; ?></p>
                    <span>Shares</span>
                </div>
            </div>
		<?php endforeach; ?>
    </div>
<?php