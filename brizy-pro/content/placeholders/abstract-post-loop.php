<?php

use BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;

abstract class BrizyPro_Content_Placeholders_AbstractPostLoop extends Brizy_Content_Placeholders_Abstract
{
    static protected $wpLoopQuery = null;

    /**
     * @return null
     */
    public static function createWpLoopQuery($attributes)
    {
//        if (self::$wpLoopQuery)
//            return self::$wpLoopQuery;
        $params = self::getWpQueryParams($attributes);
        return self::$wpLoopQuery = new WP_Query($params);
    }

    protected function getWpPostInstance($id)
    {
        global $wpdb;
        $_post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d LIMIT 1", $id));

        if (!$_post) {
            return false;
        }

        $_post = sanitize_post($_post, 'raw');

        return new WP_Post($_post);
    }

    /**
     * @return mixed|string
     */
    protected function getOptionValue()
    {
        return $this->getReplacePlaceholder();
    }

    /**
     * @param $attributes
     *
     * @return array
     */
    protected function getPosts($attributes)
    {
        $query = self::createWpLoopQuery($attributes);
        return $query->posts;
    }

    /**
     * @param $attributes
     *
     * @return int
     */
    protected function getPostCount($attributes)
    {
        $query = self::createWpLoopQuery($attributes);
        return $query->found_posts;
    }

    public static function getPaginationKey()
    {
        return apply_filters('brizy_postloop_pagination_key', 'bpage');
    }

    protected static function pagedValue()
    {
        if ($paged = get_query_var(self::getPaginationKey())) {
            return (int)$paged;
        }

        return 1;
    }

    protected static function getWpQueryParams($attributes)
    {
        $paged = self::pagedValue();

	    $attributes = array_map( function ( $value ) {
		    return html_entity_decode( $value, ENT_QUOTES );
	    }, $attributes );

        if (isset($attributes['query']) && !empty($attributes['query'])) {
            $params = array(
                'fields' => 'ids',
                'posts_per_page' => isset($attributes['count']) ? $attributes['count'] : 3,
                'orderby' => isset($attributes['orderby']) ? $attributes['orderby'] : 'none',
                'order' => isset($attributes['order']) ? $attributes['order'] : 'ASC',
                'post_type' => isset($attributes['post_type']) ? $attributes['post_type'] : array_keys(get_post_types(['public' => true])),
                'paged' => $paged,
            );
            $wpParseArgs = wp_parse_args($attributes['query']);
            $params = array_merge($params, $wpParseArgs);
        } else {
            global $wp_query;
            $params = $wp_query->query_vars;

			$params['post__not_in'] = isset( $params['post__not_in'] ) ? $params['post__not_in'] : [];
			$params['post__in'] = isset( $params['post__in'] ) ? $params['post__in'] : [];

            $params['fields'] = 'ids';
            $params['orderby'] = isset($attributes['orderby']) ? $attributes['orderby'] : (isset($params['orderby']) ? $params['orderby'] : null);
            $params['order'] = isset($attributes['order']) ? $attributes['order'] : (isset($params['order']) ? $params['order'] : null);
            $params['posts_per_page'] = isset($attributes['count']) ? (int)$attributes['count'] : (isset($params['posts_per_page']) ? $params['posts_per_page'] : null);
            $params['post__not_in'] = array_merge((array)$params['post__not_in'], isset($attributes['post__not_in']) ? explode(',', $attributes['post__not_in']) : []);
            $params['post__in'] = array_merge((array)$params['post__in'], isset($attributes['post__in']) ? explode(',', $attributes['post__in']) : []);
            //$params['post_type'] = isset($attributes['post_type']) ? $attributes['post_type'] : (isset($params['post_type']) ? $params['post_type'] : null);
            $params['paged'] = (int)$paged;
        }

        if (isset($attributes['offset']) && $attributes['offset'] > 0) {
            $ids = self::getOffsetPostIds($params, $attributes['offset']);
            $params['post__not_in'] = array_merge(isset($params['post__not_in']) ? $params['post__not_in'] : [], $ids);
        }

        return apply_filters('brizy_post_loop_args', $params);
    }

    private static function getOffsetPostIds($params, $offset)
    {
        $params['posts_per_page'] = $offset;
        $params['paged'] = 1;

        $query = new WP_Query($params);
        $ids = $query->posts;
        unset($query);

        return $ids;
    }
}
