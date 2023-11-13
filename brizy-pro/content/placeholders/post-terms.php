<?php

use BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;


class BrizyPro_Content_Placeholders_PostTerms extends Brizy_Content_Placeholders_Abstract
{

    /**
     * BrizyPro_Content_Placeholders_PostLoopPagination constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->placeholder = 'brizy_dc_post_terms';
        $this->label       = 'Post terms by taxonomy';
        $this->setDisplay(self::DISPLAY_BLOCK);
        $this->setGroup(null);
    }

    /**
     * @param ContextInterface $context
     * @param ContentPlaceholder $contentPlaceholder
     *
     * @return false|mixed|string
     */
    public function getValue(ContextInterface $context, ContentPlaceholder $contentPlaceholder)
    {

        if ( ! $context->getWpPost()) {
            return '';
        }

        $postId       = $context->getWpPost()->ID;
        $postTaxonomy = $contentPlaceholder->getAttribute('taxonomy');

        if (empty($postTaxonomy)) {
            return "";
        }

        $tags = wp_get_post_terms($postId, $postTaxonomy);

        if (is_wp_error($tags)) {
            return "";
        }

        return implode(
            ',',
            array_map(function ($tag) {
                return $tag->slug;
            }, $tags)
        );
    }

    /**
     * @return mixed|string
     */
    protected function getOptionValue()
    {
        return null;
    }

}