<?php

use BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;

class BrizyPro_Content_Placeholders_Link extends Brizy_Content_Placeholders_Simple
{

    /**
     * @param ContentPlaceholder $contentPlaceholder
     * @param ContextInterface $context
     *
     * @return false|mixed|string
     */
    public function getValue(ContextInterface $context, ContentPlaceholder $contentPlaceholder)
    {
        $link = parent::getValue($context, $contentPlaceholder);

        if (filter_var($link, FILTER_VALIDATE_EMAIL)) {
            return "mailto:{$link}";
        }

        return $link;
    }

}