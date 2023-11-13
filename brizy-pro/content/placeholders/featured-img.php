<?php

use BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;

class BrizyPro_Content_Placeholders_FeaturedImg extends BrizyPro_Content_Placeholders_Image
{

    /**
     * BrizyPro_Content_PlaceholderFeaturedImg constructor.
     *
     * @param $label
     * @param $placeholder
     * @param Brizy_Content_Context $context
     */
    public function __construct($label, $placeholder, $group = null)
    {
        parent::__construct($label, $placeholder, function ($context, $contentPlaceholder) {

            $noImageUrl = BRIZY_PRO_PLUGIN_URL . "/public/images/no-image.png";

            if (!$context->getWpPost()) {
                return $noImageUrl;
            }

            $attributes = $contentPlaceholder->getAttributes();

            $attachmentId = get_post_thumbnail_id($context->getWpPost()->ID);

            if (!$attachmentId) {
                return $noImageUrl;
            }

            $thumbnailUid = get_post_meta($attachmentId, 'brizy_attachment_uid', true);

            if (!$thumbnailUid) {
                $thumbnailUid = $attachmentId;
            }

            $type = get_post_mime_type($attachmentId);

            if ($type === 'image/svg+xml') {
                return $this->getUrlAsSvg($attachmentId, $thumbnailUid, $attributes, $context);
            }

            return $this->getUrlAsImage($attachmentId, $thumbnailUid, $attributes, $context);
        }, $group);

		add_filter( 'editor_placeholder_data', [ $this, 'sendWpSizesToEditor' ], 10, 2 );
    }

    private function getUrlAsImage($attachmentId, $thumbnailUid, $attributes, $context)
    {

        $noImageUrl = BRIZY_PRO_PLUGIN_URL . "/public/images/no-image.png";

        $imageMeta = wp_get_attachment_metadata($attachmentId);

        if (!isset($imageMeta['height']) || $imageMeta['height'] == 0) {
            return $noImageUrl;
        }

        $wpSize = ! empty($attributes['size']) ? $attributes['size'] : null;
        $wpSize = $wpSize == 'original' ? 'full' : $wpSize;

        if ($wpSize) {
            $wpSize = array_key_exists($wpSize, $this->getWpImgSizes()) ? $wpSize : 'full';
            return wp_get_attachment_image_url($attachmentId, $wpSize);
        }

		$cW = isset($attributes['cW']) ? intval($attributes['cW']) : 0;
		$cH = isset($attributes['cH']) ? intval($attributes['cH']) : 0;

	    if ( ( ! $cW && ! $cH ) || ( $cW > $imageMeta['width'] && in_array( $cH, [ 'any', '*', '0' ] ) ) ) {
			return wp_get_attachment_image_url( $attachmentId, 'full' );
	    }

        $focalPoint = get_post_meta($context->getWpPost()->ID, 'brizy_attachment_focal_point', true);

        if (!$focalPoint) {
            $focalPoint = array('x' => 50, 'y' => 50);
        }

        list($ox, $oy, $nW, $nH, $cW, $cH) = $this->calculateImageOffsetByFocalPoint(
            (int)$imageMeta['width'],
            (int)$imageMeta['height'],
            (int)$attributes['cW'],
            (int)$attributes['cH'],
            $focalPoint['x'],
            $focalPoint['y']);

        $filterParams = array(
            'iW' => (int)$nW,
            'iH' => (int)$nH,
            'oX' => $ox,
            'oY' => $oy,
            'cW' => (int)$cW,
            'cH' => (int)$cH,
        );

        $params = array(
            Brizy_Editor::prefix('_media') => $thumbnailUid,
            Brizy_Editor::prefix('_crop') => http_build_query($filterParams)
        );

	    return site_url( '?' . http_build_query( $params ) );
    }

    private function getUrlAsSvg($attachmentId, $thumbnailUid, $attributes, $context)
    {

        $params = array(
            Brizy_Editor::prefix('_attachment') => $thumbnailUid,
        );

        return site_url('?' . http_build_query($params));
    }

    public function getValue(ContextInterface $context, ContentPlaceholder $contentPlaceholder)
    {
        return call_user_func($this->value, $context, $contentPlaceholder);
    }

    public function getAttachmentId(Brizy_Content_Context $context, ContentPlaceholder $contentPlaceholder)
    {
	    return $context->getWpPost() ? get_post_thumbnail_id( $context->getWpPost()->ID ) : '';
    }

	public function sendWpSizesToEditor( $placeholderData, Brizy_Content_Placeholders_Abstract $placeholder )
    {
		if ( ! isset( $placeholderData['placeholder'] ) || $this->getReplacePlaceholder() != $placeholderData['placeholder'] || ! $this->getWpImgSizes() ) {
			return $placeholderData;
		}

	    $optgroup = [];

        $optgroup[] = [
            'label'       => 'Custom',
            'placeholder' => '{{' . $this->getPlaceholder() .'}}',
            'display'     => $placeholderData['display']
        ];

	    foreach ( $this->getWpImgSizes() as $sizeName => $sizeAttrs ) {
		    $optgroup[] = [
			    'label'       => $sizeAttrs['label'],
			    'placeholder' => '{{' . $this->getPlaceholder() . " size='{$sizeName}'" . '}}',
			    'display'     => $placeholderData['display']
		    ];
	    }

        return [
	        'label'    => __( 'Featured Image', 'brizy-pro' ),
	        'optgroup' => $optgroup
        ];
    }

	private function getWpImgSizes()
	{
		return method_exists( 'Brizy_Editor', 'get_all_image_sizes' ) ? Brizy_Editor::get_all_image_sizes() : [];
	}
}