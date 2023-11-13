<?php

use BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;

class BrizyPro_Content_Placeholders_PostLoopPagination extends BrizyPro_Content_Placeholders_AbstractPostLoop
{

    /**
     * BrizyPro_Content_Placeholders_PostLoopPagination constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->placeholder = 'brizy_dc_post_loop_pagination';
        $this->label = 'Post loop pagination';
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

        global $wp_rewrite;
        $old_pagination_base = $wp_rewrite->pagination_base;
        $wp_rewrite->pagination_base = self::getPaginationKey();

        // URL base depends on permalink settings.
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $url_parts = explode('?', $pagenum_link);
        $pagenum_link = trailingslashit($url_parts[0]) . '%_%';
        $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit(self::getPaginationKey() . '/%#%', 'paged') : '?' . BrizyPro_Content_Placeholders_PostLoop::getPaginationKey() . '=%#%';

        $attributes = $contentPlaceholder->getAttributes();

	    $attributes = array_map( function ( $value ) {
		    return html_entity_decode( $value, ENT_QUOTES );
	    }, $attributes );

	    $queryVars                   = wp_parse_args( isset( $attributes['query'] ) ? $attributes['query'] : '' );
	    $totalCount                  = (int) $this->getPostCount( $attributes );
	    $count                       = isset( $attributes['count'] ) ? (int) $attributes['count'] : ( isset( $queryVars['posts_per_page'] ) ? $queryVars['posts_per_page'] : '3' );
	    $paginationHtml              = paginate_links( array(
		    'prev_next' => false,
		    'type'      => 'list',
		    'format'    => $format,
		    'current'   => self::pagedValue(),
		    'total'     => ceil( $totalCount / $count ),
	    ) );
	    $wp_rewrite->pagination_base = $old_pagination_base;

	    // that is bad.. but there is no easy way to return ids instead of content
	    if ( isset( $attributes['content_type'] ) && $attributes['content_type'] === 'json' ) {
		    return json_encode( [
			    'itemsPerPage' => $count,
			    'totalCount'   => $totalCount,
		    ] );
	    }

	    return '<div class="brz-posts__pagination">' . $paginationHtml . '</div>';
    }
}
