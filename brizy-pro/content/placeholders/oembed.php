<?php

use BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;

class BrizyPro_Content_Placeholders_Oembed extends Brizy_Content_Placeholders_Simple {

    /**
     * @param ContextInterface $context
     * @param ContentPlaceholder $contentPlaceholder
     * @return false|mixed|string
     */
	public function getValue( ContextInterface $context, ContentPlaceholder $contentPlaceholder ) {

		$value = parent::getValue( $context, $contentPlaceholder );

		if ( filter_var( $value, FILTER_VALIDATE_URL ) ) {
			return wp_oembed_get( $value );
		}

		return $value;
	}
}