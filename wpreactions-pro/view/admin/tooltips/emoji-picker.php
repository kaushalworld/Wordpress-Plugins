<?php
$layout = isset($_GET['layout']) ? $_GET['layout'] : '';
$min_emojis = WPRA\Config::getLayoutValue( $layout, 'min_emojis' );
$max_emojis = WPRA\Config::getLayoutValue( $layout, 'max_emojis' );
?>
<p>Choose the emojis that you would like to use in your layout.
    This layout holds a minimum of <?php echo $min_emojis; ?> emoji and a maximum of <?php echo $max_emojis; ?>.
    To use our default emoji selections, click the "start" button or go to next step.
    To make new selections, click on the "reset" button and choose your emojis.
    Once selections are made, drag and drop to arrange the emoji order at the bottom of the page.</p>