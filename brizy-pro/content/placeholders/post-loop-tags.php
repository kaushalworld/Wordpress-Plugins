<?php

use BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;

class BrizyPro_Content_Placeholders_PostLoopTags extends BrizyPro_Content_Placeholders_AbstractPostLoop
{


    /**
     * BrizyPro_Content_Placeholders_PostLoopPagination constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->placeholder = 'brizy_dc_post_loop_tags';
        $this->label = 'Post loop tags';
        $this->setDisplay(self::DISPLAY_BLOCK);
        $this->setGroup(null);
    }


    /**
     * @param ContextInterface $context
     * @param ContentPlaceholder $contentPlaceholder
     * @return false|mixed|string
     */
    public function getValue(ContextInterface $context, ContentPlaceholder $contentPlaceholder)
    {

        $attributes = $contentPlaceholder->getAttributes();

        $tagsContext = array();
        $tagsContext['tags'] = $this->getTagList($attributes);
        $tagsContext['ulClassName'] = isset($attributes['ulClassName']) ? $attributes['ulClassName'] : '';
        $tagsContext['liClassName'] = isset($attributes['liClassName']) ? $attributes['liClassName'] : '';
		$tagsContext['allTag']      = empty( $attributes['allTag'] ) ? __( 'All', 'brizy-pro' ) : $attributes['allTag'];

        if (isset($attributes['content_type']) && $attributes['content_type'] === 'json') {
            return json_encode($tagsContext['tags']);
        }

	    return Brizy_Editor_View::get( BRIZY_PRO_PLUGIN_PATH . '/content/views/tags', $tagsContext );
    }

    protected function getTagList($attributes)
    {
        $tax = isset($attributes['tax']) ? $attributes['tax'] : null;

        if(!$tax) {
            return [];
        }

        unset($attributes['tax']);
        unset($attributes['ulClassName']);
        unset($attributes['liClassName']);
        $posts = $this->getPosts($attributes);

        $terms = [];
        foreach($posts as $aPostId) {
            $post_terms = wp_get_post_terms($aPostId, $tax, ['fields' => 'all']);

            foreach($post_terms as $term) {
                $terms[$term->term_id] = $term;
            }
        }

        return array_values($terms);
    }

}
