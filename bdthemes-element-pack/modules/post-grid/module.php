<?php

namespace ElementPack\Modules\PostGrid;

use ElementPack\Base\Element_Pack_Module_Base;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Element_Pack_Module_Base {
	public function __construct() {
		parent::__construct();


		add_action('wp_ajax_nopriv_ep_loadmore_posts', [$this, 'callback_ajax_loadmore_posts']);
		add_action('wp_ajax_ep_loadmore_posts', [$this, 'callback_ajax_loadmore_posts']);
	}

	public function get_name() {
		return 'post-grid';
	}

	public function get_widgets() {

		$widgets = [
			'Post_Grid',
		];

		return $widgets;
	}


	private function mapGroupControlQuery($term_ids = []) {
		$terms = get_terms(
			[
				'term_taxonomy_id' => $term_ids,
				'hide_empty'       => false,
			]
		);

		$tax_terms_map = [];

		foreach ($terms as $term) {
			$taxonomy                     = $term->taxonomy;
			$tax_terms_map[$taxonomy][] = $term->term_id;
		}

		return $tax_terms_map;
	}


	public function query_args() {
		extract($_POST['settings']);

		// setmeta args
		$args = [
			// 'post_type'      => $posts_source,
			'posts_per_page' => $_POST['per_page'],
			// 'paged'          => $_POST['page'],
			'post_status'    => 'publish',
			'suppress_filters' => false,
			'orderby'        => $posts_orderby,
			'order'          => $posts_order,
			'offset'         => $_POST['offset'],
		];
		/**
		 * set feature image
		 *
		 */
		if (isset($posts_only_with_featured_image) && $posts_only_with_featured_image === 'yes') {
			$args['meta_query'] = [
				[
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				]
			];
		}

		/**
		 * set date query
		 */

		$selected_date = $posts_select_date;

		if (!empty($selected_date)) {
			$date_query = [];

			switch ($selected_date) {
				case 'today':
					$date_query['after'] = '-1 day';
					break;

				case 'week':
					$date_query['after'] = '-1 week';
					break;

				case 'month':
					$date_query['after'] = '-1 month';
					break;

				case 'quarter':
					$date_query['after'] = '-3 month';
					break;

				case 'year':
					$date_query['after'] = '-1 year';
					break;

				case 'exact':
					$after_date = $posts_date_after;
					if (!empty($after_date)) {
						$date_query['after'] = $after_date;
					}

					$before_date = $posts_date_before;
					if (!empty($before_date)) {
						$date_query['before'] = $before_date;
					}
					$date_query['inclusive'] = true;
					break;
			}

			if (!empty($date_query)) {
				$args['date_query'] = $date_query;
			}
		}

		$exclude_by = $posts_exclude_by;
		$include_by = $posts_include_by;
		$include_users = [];
		$exclude_users = [];
		// print_r($exclude_by);
		/**
		 * ignore sticky post
		 */
		if (!empty($exclude_by) && $posts_source === 'post' && $posts_ignore_sticky_posts === 'yes') {
			$args['ignore_sticky_posts'] = true;
			if (in_array('current_post', $exclude_by)) {
				$args['post__not_in'] = [get_the_ID()];
			}
		}

		/**
		 * set post type
		 */

		if ($posts_source === 'manual_selection') {
			/**
			 * Set Including Manually
			 */
			$selected_ids      = $posts_selected_ids;
			$selected_ids      = wp_parse_id_list($selected_ids);
			$args['post_type'] = 'any';
			if (!empty($selected_ids)) {
				$args['post__in'] = $selected_ids;
			}
			$args['ignore_sticky_posts'] = 1;
		} elseif ('current_query' === $posts_source) {
			/**
			 * Make Current Query
			 */
			$args = $GLOBALS['wp_query']->query_vars;
			$args = apply_filters('element_pack/query/get_query_args/current_query', $args);
		} elseif ('_related_post_type' === $posts_source) {
			/**
			 * Set Related Query
			 */
			$post_id           = get_queried_object_id();
			$related_post_id   = is_singular() && (0 !== $post_id) ? $post_id : null;
			$args['post_type'] = get_post_type($related_post_id);

			// $include_by = $this->getGroupControlQueryParamBy('include');
			if (in_array('authors', $include_by)) {
				$args['author__in'] = wp_parse_id_list($settings['posts_include_author_ids']);
			} else {
				$args['author__in'] = get_post_field('post_author', $related_post_id);
			}

			// $exclude_by = $this->getGroupControlQueryParamBy('exclude');
			if (in_array('authors', $exclude_by)) {
				$args['author__not_in'] = wp_parse_id_list($posts_exclude_author_ids);
			}

			if (in_array('current_post', $exclude_by)) {
				$args['post__not_in'] = [get_the_ID()];
			}

			$args['ignore_sticky_posts'] = 1;
			$args                        = apply_filters('element_pack/query/get_query_args/related_query', $args);
		} else {
			$args['post_type'] = $posts_source;
			$current_post = [];


			/**
			 * Set Taxonomy && Set Authors
			 */
			$include_terms = [];
			$exclude_terms = [];
			$terms_query   = [];
			if (!empty($exclude_by)) {
				if (in_array('authors', $exclude_by)) {
					$exclude_users = wp_parse_id_list($posts_exclude_author_ids);
					$include_users = array_diff($include_users, $exclude_users);
				}
				if (!empty($exclude_users)) {
					$args['author__not_in'] = $exclude_users;;
				}
				if (in_array('current_post', $exclude_by) && is_singular()) {
					$current_post[] = get_the_ID();
				}
				if (in_array('manual_selection', $exclude_by)) {
					$exclude_ids          = $posts_exclude_ids;
					$args['post__not_in'] = array_merge($current_post, wp_parse_id_list($exclude_ids));
				}
				if (in_array('terms', $exclude_by)) {
					$exclude_terms = wp_parse_id_list($posts_exclude_term_ids);
					$include_terms = array_diff($include_terms, $exclude_terms);
				}
				if (!empty($exclude_terms)) {
					$tax_terms_map = $this->mapGroupControlQuery($exclude_terms);

					foreach ($tax_terms_map as $tax => $terms) {
						$terms_query[] = [
							'taxonomy' => $tax,
							'field'    => 'term_id',
							'terms'    => $terms,
							'operator' => 'NOT IN',
						];
					}
				}
			}

			if (!empty($include_terms)) {

				if (in_array('authors', $include_by)) {
					$include_users = wp_parse_id_list($posts_include_author_ids);
				}
				if (!empty($include_users)) {
					$args['author__in'] = $include_users;
				}
				if (in_array('terms', $include_by)) {
					$include_terms = wp_parse_id_list($posts_include_term_ids);
				}
				$tax_terms_map = $this->mapGroupControlQuery($include_terms);
				foreach ($tax_terms_map as $tax => $terms) {
					$terms_query[] = [
						'taxonomy' => $tax,
						'field'    => 'term_id',
						'terms'    => $terms,
						'operator' => 'IN',
					];
				}
			}
			if (!empty($terms_query)) {
				$args['tax_query']             = $terms_query;
				$args['tax_query']['relation'] = 'AND';
			}
		}

		$ajaxposts = new \WP_Query($args);
		return $ajaxposts;
	}
	public function callback_ajax_loadmore_posts() {
		// $grid_icon = $_POST['readMore']['post_grid_icon'];
		$ajaxposts = $this->query_args();
		$markup    = '';
		if ($ajaxposts->have_posts()) {
			$item_index = 1;
			while ($ajaxposts->have_posts()) :
				$ajaxposts->the_post();
				// $title                 = wp_trim_words(get_the_title(), $title_text_limit, '...');
				$post_link             = get_permalink();
				$image_src             = wp_get_attachment_image_url(get_post_thumbnail_id(), 'full');
				// $category              = upk_get_category($post_type);
				$author_url            = get_author_posts_url(get_the_author_meta('ID'));
				$author_name           = get_the_author();
				$date                  = get_the_date();
				$placeholder_image_src = \Elementor\Utils::get_placeholder_image_src();
				$image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
				if (!$image_src) {
					$image_src = $placeholder_image_src;
				} else {
					$image_src = $image_src[0];
				}




				$markup .= '<div class="nnn bdt-width-1-3@m bdt-width-1-3@s bdt-width-1-1 bdt-secondary bdt-grid-margin">';
				$markup .= '<div class="bdt-post-grid-item bdt-transition-toggle bdt-position-relative">';
				//image wrap
				$markup .= '<div class="bdt-post-grid-img-wrap bdt-overflow-hidden">';
				$markup .= '<a href="' . esc_url(get_permalink()) . '" class="bdt-transition-scale-up bdt-background-cover bdt-transition-opaque bdt-flex" title="' . esc_html__(esc_attr(get_the_title()), 'bdthemes-element-pack') . '" style="background-image: url(' . esc_url($image_src) . ')">';
				$markup .= '</a>';
				$markup .= '</div>';

				$markup .= '<div class="bdt-custom-overlay bdt-position-cover"></div>';

				$markup .= '<div class="bdt-post-grid-desc bdt-position-medium bdt-position-bottom-left">';
				$markup .= '<h2 class="bdt-post-grid-title">';
				$markup .= '<a href="' . esc_url(get_permalink()) . '" class="bdt-post-grid-link" title="' . esc_html__(esc_attr(get_the_title()), 'bdthemes-element-pack') . '">';
				$markup .= esc_html__(esc_attr(get_the_title()), 'bdthemes-element-pack');
				$markup .= '</a>';
				$markup .= '</h2>';
				$markup .= '<div class="bdt-post-grid-meta">';
				$markup .= '<span class="bdt-post-grid-meta-item bdt-post-grid-meta-author">';
				$markup .= '<a href="' . esc_url($author_url) . '" class="bdt-post-grid-meta-link">';
				$markup .= esc_html($author_name);
				$markup .= '</a>';
				$markup .= '</span>';
				$markup .= '<span class="bdt-post-grid-meta-item bdt-post-grid-meta-date">';
				$markup .= '<a href="' . esc_url(get_permalink()) . '" class="bdt-post-grid-meta-link">';
				$markup .= esc_html($date);
				$markup .= '</a>';
				$markup .= '</span>';
				$markup .= '</div>';
				/**
				 * Readmore Button
				 */
				if (isset($_POST['settings']['show_readmore']) && $_POST['settings']['show_readmore'] == 'yes') :
					extract($_POST['readMore']);

					$animation = $readmore_hover_animation ? ' elementor-animation-' . $readmore_hover_animation : '';

					if (!isset($settings['icon']) && !Icons_Manager::is_migration_allowed()) {
						$settings['icon'] = 'fas fa-arrow-right';
					}

					$migrated  = isset($settings['__fa4_migrated'][$post_grid_icon]);
					$is_new    = empty($settings['icon']) && Icons_Manager::is_migration_allowed();

					$markup .= '<a href="' . $post_link . '" class="bdt-post-grid-readmore bdt-display-inline-block ' . $animation . '">';
					$markup .= '<span class="bdt-button-text">' . $readmore_text . '</span>';
					if ($post_grid_icon['value']) :
						$markup .= '<span class="bdt-button-icon-align-' . $readmore_icon_align . '">';
						if ($is_new || $migrated) :
							ob_start();
							Icons_Manager::render_icon($post_grid_icon, ['aria-hidden' => 'true', 'class' => 'fa-fw']);
							$markup .= ob_get_clean();
						else :
							$markup .= '<i class="' . $settings['icon'] . '" aria-hidden="true"></i>';
						endif;
						$markup .= '</span>';
					endif;
					$markup .=	'</a>';
				endif;
				/**
				 * Readmore Button End
				 */

				$markup .= '</div>';
				$markup .= '<div class="bdt-post-grid-category bdt-position-small bdt-position-top-left">';
				$markup .= element_pack_get_category_list($_POST['posts_source']);
				$markup .= '</div>';

				$markup .= '</div>';
				$markup .= '</div>';
				$item_index++;
			endwhile;
		}

		wp_reset_postdata();
		$result = [
			'markup' => $markup,
			// 'max'    => $ajaxposts->max_num_pages,
		];
		wp_send_json($result);
		exit;
	}
}
