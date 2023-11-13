<?php

use BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;

class BrizyPro_Content_Placeholders_PostLoop extends BrizyPro_Content_Placeholders_AbstractPostLoop
{
	/**
	 * BrizyPro_Content_Placeholders_PostLoop constructor.
     *
     * @param string $label
     * @param string $placeholder
     *
	 * @throws Exception
	 */
    public function __construct( $label, $placeholder )
    {
        $this->setLabel($label);
        $this->setPlaceholder($placeholder);
        $this->setDisplay(self::DISPLAY_BLOCK);
        $this->setGroup(null);
    }

    private function getDynamicContentConfig(Brizy_Content_Context $context)
    {
        $provider = new Brizy_Content_PlaceholderProvider($context);
        return ['groups'=>$provider->getGroupedPlaceholdersForApiResponse()];
    }

    /**
     * @param ContextInterface $context
     * @param ContentPlaceholder $contentPlaceholder
     * @return false|mixed|string
     */
    public function getValue(ContextInterface $context, ContentPlaceholder $contentPlaceholder)
    {
		global $post;

        $attributes = $contentPlaceholder->getAttributes();
	    $attributes = array_map( function ( $value ) {
		    return html_entity_decode( $value, ENT_QUOTES );
	    }, $attributes );

        $posts = $this->getPosts($attributes);
        $content = '';

        // that is bad.. but there is no easy way to return ids instead of content
        if (isset($attributes['content_type']) && $attributes['content_type'] === 'json') {
            return json_encode([
                'collection' => $posts,
                'config' => ['*' => ['dynamicContent' => $this->getDynamicContentConfig($context)]]
            ]);
        }

        //$placeholderProvider = new Brizy_Content_PlaceholderProvider( $context );
        //$extractor           = new \BrizyPlaceholders\Extractor( $context->getProvider() );
        //list( $contentPlaceholders, $placeholderInstances, $newContent ) = $extractor->extract( $content );
        $replacer = new \BrizyPlaceholders\Replacer($context->getProvider());

        foreach ((array)$posts as $postId) {

            // this method will initialize the WP_Post instance avoiding the adding it to cache
            // this way we avoid huge memory usage..
            $_post = $this->getWpPostInstance($postId);

	        if ( ! $_post ) {
		        continue;
	        }

			$post = $_post;

			unset( $_post );

	        setup_postdata( $post );



            $newContext = Brizy_Content_ContextFactory::createContext($context->getProject(), null, $post, null, true);
            $newContext->setProvider($context->getProvider());
            Brizy_Content_ContextFactory::makeContextGlobal($newContext);

	        $content .= do_shortcode( $replacer->replacePlaceholders( $contentPlaceholder->getContent(), $newContext ) );

            Brizy_Content_ContextFactory::clearGlobalContext();

			wp_reset_postdata();
        }

        return $content;
    }

    /**
     * @return mixed|string
     */
    protected function getOptionValue()
    {
        return $this->getReplacePlaceholder();
    }

}

