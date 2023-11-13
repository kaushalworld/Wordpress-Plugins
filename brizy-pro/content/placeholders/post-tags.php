<?php
use BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;


class BrizyPro_Content_Placeholders_PostTags extends Brizy_Content_Placeholders_Abstract {

	/**
	 * BrizyPro_Content_Placeholders_PostLoopPagination constructor.
	 * @throws Exception
	 */
	public function __construct() {
		$this->placeholder = 'brizy_dc_post_tags';
		$this->label       = 'Post tags';
		$this->setDisplay( self::DISPLAY_BLOCK );
        $this->setGroup(null);
	}

    /**
     * @param ContextInterface $context
     * @param ContentPlaceholder $contentPlaceholder
     * @return false|mixed|string
     */
    public function getValue( ContextInterface $context, ContentPlaceholder $contentPlaceholder )  {

		if ( ! $context->getWpPost() ) {
			return '';
		}

		$tax  = $context->getWpPost()->post_type == 'product' ? 'product_tag' : 'post_tag';
		$tags = wp_get_post_terms( $context->getWpPost()->ID, $tax );
		
		if ( is_wp_error( $tags ) ) {
			return [];
		}

		return implode( ',', array_map( function ( $tag ) {
			return $tag->slug;
		}, $tags ) );
	}

	/**
	 * @return mixed|string
	 */
	protected function getOptionValue() {
		return null;
	}

}