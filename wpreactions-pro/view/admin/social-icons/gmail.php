<?php
if ( ! isset( $color ) ) return;
if ( ! isset( $override ) ) return;

$color1 = '#4285f4';
$color2 = '#34a853';
$color3 = '#fbbc04';
$color4 = '#ea4335';
$color5 = '#c5221f';

if ($override == 'true' || $color == '#ffffff') {
    $color1 = $color2 = $color3 = $color4 = $color5 = $color;
}
?>
<svg width="2500" height="2500" viewBox="0 0 2500 2500" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M170.459 2188.14H568.184V1222.23L0 796.091V2017.69C0 2111.86 76.2793 2188.15 170.459 2188.15V2188.14Z" fill="<?php echo $color1; ?>"/>
    <path d="M1931.82 2188.14H2329.55C2423.72 2188.14 2500 2111.86 2500 2017.68V796.091L1931.82 1222.23V2188.14Z" fill="<?php echo $color2; ?>"/>
    <path d="M1931.82 483.591V1222.23L2500 796.091V568.82C2500 358.166 2259.52 237.854 2090.91 364.274L1931.82 483.591Z" fill="<?php echo $color3; ?>"/>
    <path fill-rule="evenodd" clip-rule="evenodd" d="M568.184 1222.23V483.591L1250 994.958L1931.82 483.591V1222.23L1250 1733.59L568.184 1222.23Z" fill="<?php echo $color4; ?>"/>
    <path d="M0 568.82V796.091L568.184 1222.23V483.591L409.092 364.274C240.478 237.853 0 358.166 0 568.811V568.82Z" fill="<?php echo $color5; ?>"/>
</svg>