<?php

use WPRA\Config;
use WPRA\Helpers\Utils;

$layout = '';
$behavior = 'regular';
if ( isset( $data ) ) {
	extract( $data );
}

$steps  = Config::getLayoutValue( $layout, 'steps' );
?>
<div class="wpra-stepper">
    <ol class="wpra-stepper__bar">
		<?php foreach ( $steps as $order => $step ):
			$order ++; ?>
            <li class="wpra-stepper__bar-item <?php Utils::echoIf( $order == 1, 'is-current' ); ?>" data-tab_id="<?php echo $order; ?>">
                <div class="wpra-stepper__bar-item-wrap">
                    <span class="wpra-stepper__bar-item-num"><?php echo $order; ?></span>
                    <span class="wpra-stepper__bar-item-desc"><span><?php echo $step['name']; ?></span></span>
                </div>
            </li>
		<?php endforeach; ?>
    </ol>
    <div class="wpra-stepper__body">
		<?php foreach ( $steps as $order => $step ):
			$order ++; ?>
            <div class="wpra-stepper__body-item <?php Utils::echoIf( $order == 1, 'active' ); ?>" data-body_id="<?php echo $order; ?>">
				<?php Utils::renderTemplate( $step['template'] ); ?>
            </div>
		<?php endforeach; ?>
    </div>
</div>
