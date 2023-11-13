<?php
namespace ExclusiveAddons\Pro\Includes\HeaderFooter;

/**
 * Meta Boxes setup
 */
class Target_Rules_Fields {

	private static $instance;

	private static $current_page_type = null;

	private static $current_page_data = array();

	private static $location_selection;

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) :
			self::$instance = new self();
		endif;

		return self::$instance;
	}

	public function __construct() {
		add_action( 'admin_action_edit', array( $this, 'initialize_options' ) );
		add_action( 'wp_ajax_get_posts_by_query', array( $this, 'get_posts_by_query' ) );
	}

	public function initialize_options() {
		self::$location_selection = self::get_location_selections();
	}

	/**
	 * Get location selection options.
	 *
	 * @return array
	 */
	public static function get_location_selections() {
		$args = array(
			'public'   => true,
			'_builtin' => true
		);

		$post_types = get_post_types( $args, 'objects' );
		unset( $post_types['attachment'] );

		$args['_builtin'] = false;
		$custom_post_type = get_post_types( $args, 'objects' );

		$post_types = apply_filters( 'exad_location_rule_post_types', array_merge( $post_types, $custom_post_type ) );

		$special_pages = array(
			'special-404'    => __( '404 Page', 'exclusive-addons-elementor-pro' ),
			'special-search' => __( 'Search Page', 'exclusive-addons-elementor-pro' ),
			'special-blog'   => __( 'Blog / Posts Page', 'exclusive-addons-elementor-pro' ),
			'special-front'  => __( 'Front Page', 'exclusive-addons-elementor-pro' ),
			'special-date'   => __( 'Date Archive', 'exclusive-addons-elementor-pro' ),
			'special-author' => __( 'Author Archive', 'exclusive-addons-elementor-pro' )
		);

		if ( class_exists( 'WooCommerce' ) ) :
			$special_pages['special-woo-shop'] = __( 'WooCommerce Shop Page', 'exclusive-addons-elementor-pro' );
		endif;

		$selection_options = array(
			'basic'         => array(
				'label' => __( 'Basic', 'exclusive-addons-elementor-pro' ),
				'value' => array(
					'basic-global'    => __( 'Entire Website', 'exclusive-addons-elementor-pro' ),
					'basic-singulars' => __( 'All Singulars', 'exclusive-addons-elementor-pro' ),
					'basic-archives'  => __( 'All Archives', 'exclusive-addons-elementor-pro' )
				)
			),

			'special-pages' => array(
				'label' => __( 'Special Pages', 'exclusive-addons-elementor-pro' ),
				'value' => $special_pages
			)
		);

		$args = array(
			'public' => true
		);

		$taxonomies = get_taxonomies( $args, 'objects' );

		if ( ! empty( $taxonomies ) ) :
			foreach ( $taxonomies as $taxonomy ) :

				// skip post format taxonomy.
				if ( 'post_format' == $taxonomy->name ) :
					continue;
				endif;

				foreach ( $post_types as $post_type ) :
					$post_opt = self::get_post_target_rule_options( $post_type, $taxonomy );

					if ( isset( $selection_options[ $post_opt['post_key'] ] ) ) :
						if ( ! empty( $post_opt['value'] ) && is_array( $post_opt['value'] ) ) :
							foreach ( $post_opt['value'] as $key => $value ) :
								if ( ! in_array( $value, $selection_options[ $post_opt['post_key'] ]['value'] ) ) :
									$selection_options[ $post_opt['post_key'] ]['value'][ $key ] = $value;
								endif;
							endforeach;
						endif;
					else :
						$selection_options[ $post_opt['post_key'] ] = array(
							'label' => $post_opt['label'],
							'value' => $post_opt['value']
						);
					endif;
				endforeach;
			endforeach;
		endif;

		$selection_options['specific-target'] = array(
			'label' => __( 'Specific Target', 'exclusive-addons-elementor-pro' ),
			'value' => array(
				'specifics' => __( 'Specific Pages / Posts / Taxonomies, etc.', 'exclusive-addons-elementor-pro' )
			)
		);

		/**
		 * Filter options displayed in the display conditions select field of Display conditions.
		 */
		return apply_filters( 'exad_display_on_list', $selection_options );
	}

	/**
	 * Get location label by key.
	 *
	 * @param string $key Location option key.
	 * @return string
	 */
	public static function get_location_by_key( $key ) {
		if ( ! isset( self::$location_selection ) || empty( self::$location_selection ) ) :
			self::$location_selection = self::get_location_selections();
		endif;
		$location_selection = self::$location_selection;

		foreach ( $location_selection as $location_grp ) :
			if ( isset( $location_grp['value'][ $key ] ) ) :
				return $location_grp['value'][ $key ];
			endif;
		endforeach;

		if ( strpos( $key, 'post-' ) !== false ) :
			$post_id = (int) str_replace( 'post-', '', $key );
			return get_the_title( $post_id );
		endif;

		// taxonomy options.
		if ( strpos( $key, 'tax-' ) !== false ) :
			$tax_id = (int) str_replace( 'tax-', '', $key );
			$term   = get_term( $tax_id );

			if ( ! is_wp_error( $term ) ) :
				$term_taxonomy = ucfirst( str_replace( '_', ' ', $term->taxonomy ) );
				return $term->name . ' - ' . $term_taxonomy;
			else :
				return '';
			endif;
		endif;

		return $key;
	}

	/**
	 * Ajax handeler to return the posts based on the search query.
	 * When searching for the post/pages only titles are searched for.
	 *
	 */
	function get_posts_by_query() {

		check_ajax_referer( 'exad-hf-get-posts-by-query', 'nonce' );

		$search_string = isset( $_POST['q'] ) ? sanitize_text_field( $_POST['q'] ) : '';
		$data          = array();
		$result        = array();

		$args = array(
			'public'   => true,
			'_builtin' => false
		);

		$output     = 'names'; // names or objects, note names is the default.
		$operator   = 'and'; // also supports 'or'.
		$post_types = get_post_types( $args, $output, $operator );

		unset( $post_types['exad-elementor-hf'] ); //Exclude EHF templates.

		$post_types['Posts'] = 'post';
		$post_types['Pages'] = 'page';

		foreach ( $post_types as $key => $post_type ) :
			$data = array();

			add_filter( 'posts_search', array( $this, 'search_only_titles' ), 10, 2 );

			$query = new \WP_Query(
				array(
					's'              => $search_string,
					'post_type'      => $post_type,
					'posts_per_page' => - 1
				)
			);

			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) :
					$query->the_post();
					$title  = get_the_title();
					$title .= ( 0 != $query->post->post_parent ) ? ' (' . get_the_title( $query->post->post_parent ) . ')' : '';
					$id     = get_the_id();
					$data[] = array(
						'id'   => 'post-' . $id,
						'text' => $title,
					);
				endwhile;
			endif;

			if ( is_array( $data ) && ! empty( $data ) ) :
				$result[] = array(
					'text'     => $key,
					'children' => $data,
				);
			endif;
		endforeach;

		$data = array();

		wp_reset_postdata();

		$args = array(
			'public' => true
		);

		$output     = 'objects'; // names or objects, note names is the default.
		$operator   = 'and'; // also supports 'or'.
		$taxonomies = get_taxonomies( $args, $output, $operator );

		foreach ( $taxonomies as $taxonomy ) :
			$terms = get_terms(
				$taxonomy->name,
				array(
					'orderby'    => 'count',
					'hide_empty' => 0,
					'name__like' => $search_string
				)
			);

			$data = array();

			$label = ucwords( $taxonomy->label );

			if ( ! empty( $terms ) ) :
				foreach ( $terms as $term ) :
					$term_taxonomy_name = ucfirst( str_replace( '_', ' ', $taxonomy->name ) );

					$data[] = array(
						'id'   => 'tax-' . $term->term_id,
						'text' => $term->name . ' archive page'
					);

					$data[] = array(
						'id'   => 'tax-' . $term->term_id . '-single-' . $taxonomy->name,
						'text' => 'All singulars from ' . $term->name
					);
				endforeach;
			endif;

			if ( is_array( $data ) && ! empty( $data ) ) :
				$result[] = array(
					'text'     => $label,
					'children' => $data
				);
			endif;
		endforeach;

		// return the result in json.
		wp_send_json( $result );
	}

	/**
	 * Return search results only by post title.
	 * This is only run from get_posts_by_query()
	 *
	 * @param  (string)   $search   Search SQL for WHERE clause.
	 * @param  (WP_Query) $wp_query The current WP_Query object.
	 *
	 * @return (string) The Modified Search SQL for WHERE clause.
	 */
	function search_only_titles( $search, $wp_query ) {
		if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) :
			global $wpdb;

			$q = $wp_query->query_vars;
			$n = ! empty( $q['exact'] ) ? '' : '%';

			$search = array();

			foreach ( (array) $q['search_terms'] as $term ) :
				$search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );
			endforeach;

			if ( ! is_user_logged_in() ) :
				$search[] = "$wpdb->posts.post_password = ''";
			endif;

			$search = ' AND ' . implode( ' AND ', $search );
		endif;

		return $search;
	}

	/**
	 * Function Name: admin_styles.
	 * Function Description: admin_styles.
	 */
	public function admin_styles() {
		wp_enqueue_script( 'exad-select2', EXAD_PRO_URL . 'admin/assets/header-footer/js/select2.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );

		wp_register_script( 'exad-target-rule', EXAD_PRO_URL . 'admin/assets/header-footer/js/target-rule.js', array( 'jquery', 'exad-select2', ), EXAD_PRO_PLUGIN_VERSION, true );

		wp_enqueue_script( 'exad-target-rule' );

		wp_register_script( 'exad-user-role', EXAD_PRO_URL . 'admin/assets/header-footer/js/user-role.js', array( 'jquery', ), EXAD_PRO_PLUGIN_VERSION, true );

		wp_enqueue_script( 'exad-user-role' );

		wp_register_style( 'exad-select2', EXAD_PRO_URL . 'admin/assets/header-footer/css/select2.css', '', EXAD_PRO_PLUGIN_VERSION );
		wp_enqueue_style( 'exad-select2' );
		wp_register_style( 'exad-target-rule', EXAD_PRO_URL . 'admin/assets/header-footer/css/target-rule.css', '', EXAD_PRO_PLUGIN_VERSION );
		wp_enqueue_style( 'exad-target-rule' );

		/**
		 * Registered localize vars
		 */
		$localize_vars = array(
			'please_enter'  => __( 'Please enter', 'exclusive-addons-elementor-pro' ),
			'please_delete' => __( 'Please delete', 'exclusive-addons-elementor-pro' ),
			'more_char'     => __( 'or more characters', 'exclusive-addons-elementor-pro' ),
			'character'     => __( 'character', 'exclusive-addons-elementor-pro' ),
			'loading'       => __( 'Loading more results…', 'exclusive-addons-elementor-pro' ),
			'only_select'   => __( 'You can only select', 'exclusive-addons-elementor-pro' ),
			'item'          => __( 'item', 'exclusive-addons-elementor-pro' ),
			'char_s'        => __( 's', 'exclusive-addons-elementor-pro' ),
			'no_result'     => __( 'No results found', 'exclusive-addons-elementor-pro' ),
			'searching'     => __( 'Searching…', 'exclusive-addons-elementor-pro' ),
			'not_loader'    => __( 'The results could not be loaded.', 'exclusive-addons-elementor-pro' ),
			'search'        => __( 'Search pages / post / categories', 'exclusive-addons-elementor-pro' ),
			'ajax_nonce'    => wp_create_nonce( 'exad-hf-get-posts-by-query' )
		);
		wp_localize_script( 'exad-select2', 'exadRules', $localize_vars );
	}

	/**
	 * Function Name: target_rule_settings_field.
	 * Function Description: Function to handle new input type.
	 *
	 * @param string $name string parameter.
	 * @param string $settings string parameter.
	 * @param string $value string parameter.
	 */
	public static function target_rule_settings_field( $name, $settings, $value ) {
		$input_name     = $name;
		$type           = isset( $settings['type'] ) ? $settings['type'] : 'target_rule';
		$class          = isset( $settings['class'] ) ? $settings['class'] : '';
		$rule_type      = isset( $settings['rule_type'] ) ? $settings['rule_type'] : 'target_rule';
		$add_rule_label = isset( $settings['add_rule_label'] ) ? $settings['add_rule_label'] : __( 'Add Rule', 'exclusive-addons-elementor-pro' );
		$saved_values   = $value;
		$output         = '';

		if ( isset( self::$location_selection ) || empty( self::$location_selection ) ) :
			self::$location_selection = self::get_location_selections();
		endif;
		$selection_options = self::$location_selection;

		/* WP Template Format */
		$output .= '<script type="text/html" id="tmpl-exad-target-rule-' . $rule_type . '-condition">';
		$output .= '<div class="exad-target-rule-condition exad-target-rule-{{data.id}}" data-rule="{{data.id}}" >';
		$output .= '<span class="target_rule-condition-delete dashicons dashicons-dismiss"></span>';
		/* Condition Selection */
		$output .= '<div class="target_rule-condition-wrap" >';
		$output .= '<select name="' . esc_attr( $input_name ) . '[rule][{{data.id}}]" class="target_rule-condition form-control exad-input">';
		$output .= '<option value="">' . __( 'Select', 'exclusive-addons-elementor-pro' ) . '</option>';

		foreach ( $selection_options as $group => $group_data ) :
			$output .= '<optgroup label="' . $group_data['label'] . '">';
			foreach ( $group_data['value'] as $opt_key => $opt_value ) :
				$output .= '<option value="' . $opt_key . '">' . $opt_value . '</option>';
			endforeach;
			$output .= '</optgroup>';
		endforeach;
		$output .= '</select>';
		$output .= '</div>';

		$output .= '</div> <!-- exad-target-rule-condition -->';

		/* Specific page selection */
		$output .= '<div class="target_rule-specific-page-wrap" style="display:none">';
		$output .= '<select name="' . esc_attr( $input_name ) . '[specific][]" class="target-rule-select2 target_rule-specific-page form-control exad-input " multiple="multiple">';
		$output .= '</select>';
		$output .= '</div>';

		$output .= '</script>';

		/* Wrapper Start */
		$output .= '<div class="exad-target-rule-wrapper exad-target-rule-' . $rule_type . '-on-wrap" data-type="' . $rule_type . '">';
		// $output .= '<input type="hidden" class="form-control exad-input exad-target_rule-input" name="' . esc_attr( $input_name ) . '" value=' . $value . ' />';
		$output .= '<div class="exad-target-rule-selector-wrapper exad-target-rule-' . $rule_type . '-on">';
		$output .= self::generate_target_rule_selector( $rule_type, $selection_options, $input_name, $saved_values, $add_rule_label );
		$output .= '</div>';

		/* Wrapper end */
		$output .= '</div>';

		echo $output;
	}

	/**
	 * Get target rules for generating the markup for rule selector.
	 *
	 * @param object $post_type post type parameter.
	 * @param object $taxonomy taxonomy for creating the target rule markup.
	 */
	public static function get_post_target_rule_options( $post_type, $taxonomy ) {
		$post_key    = str_replace( ' ', '-', strtolower( $post_type->label ) );
		$post_label  = ucwords( $post_type->label );
		$post_name   = $post_type->name;
		$post_option = array();

		/* translators: %s post label */
		$all_posts                          = sprintf( __( 'All %s', 'exclusive-addons-elementor-pro' ), $post_label );
		$post_option[ $post_name . '|all' ] = $all_posts;

		if ( 'pages' != $post_key ) :
			/* translators: %s post label */
			$all_archive                                = sprintf( __( 'All %s Archive', 'exclusive-addons-elementor-pro' ), $post_label );
			$post_option[ $post_name . '|all|archive' ] = $all_archive;
		endif;

		if ( in_array( $post_type->name, $taxonomy->object_type ) ) :
			$tax_label = ucwords( $taxonomy->label );
			$tax_name  = $taxonomy->name;

			/* translators: %s taxonomy label */
			$tax_archive = sprintf( __( 'All %s Archive', 'exclusive-addons-elementor-pro' ), $tax_label );

			$post_option[ $post_name . '|all|taxarchive|' . $tax_name ] = $tax_archive;
		endif;

		$post_output['post_key'] = $post_key;
		$post_output['label']    = $post_label;
		$post_output['value']    = $post_option;

		return $post_output;
	}

	/**
	 * Generate markup for rendering the location selction.
	 *
	 * @param  String $type                 Rule type display|exclude.
	 * @param  Array  $selection_options     Array for available selection fields.
	 * @param  String $input_name           Input name for the settings.
	 * @param  Array  $saved_values          Array of saved valued.
	 * @param  String $add_rule_label       Label for the Add rule button.
	 *
	 * @return HTML Markup for for the location settings.
	 */
	public static function generate_target_rule_selector( $type, $selection_options, $input_name, $saved_values, $add_rule_label ) {
		$output = '<div class="target_rule-builder-wrap">';

		if ( ! is_array( $saved_values ) || ( is_array( $saved_values ) && empty( $saved_values ) ) ) :
			$saved_values                = array();
			$saved_values['rule'][0]     = '';
			$saved_values['specific'][0] = '';
		endif;

		$index = 0;

		foreach ( $saved_values['rule'] as $index => $data ) :
			$output .= '<div class="exad-target-rule-condition exad-target-rule-' . $index . '" data-rule="' . $index . '" >';
			/* Condition Selection */
			$output .= '<span class="target_rule-condition-delete dashicons dashicons-dismiss"></span>';
			$output .= '<div class="target_rule-condition-wrap" >';
			$output .= '<select name="' . esc_attr( $input_name ) . '[rule][' . $index . ']" class="target_rule-condition form-control exad-input">';
			$output .= '<option value="">' . __( 'Select', 'exclusive-addons-elementor-pro' ) . '</option>';

			foreach ( $selection_options as $group => $group_data ) :
				$output .= '<optgroup label="' . $group_data['label'] . '">';
				foreach ( $group_data['value'] as $opt_key => $opt_value ) :

					// specific rules.
					$selected = '';

					if ( $data == $opt_key ) :
						$selected = 'selected="selected"';
					endif;

					$output .= '<option value="' . $opt_key . '" ' . $selected . '>' . $opt_value . '</option>';
				endforeach;
				$output .= '</optgroup>';
			endforeach;
			$output .= '</select>';
			$output .= '</div>';

			$output .= '</div>';

			/* Specific page selection */
			$output .= '<div class="target_rule-specific-page-wrap" style="display:none">';
			$output .= '<select name="' . esc_attr( $input_name ) . '[specific][]" class="target-rule-select2 target_rule-specific-page form-control exad-input " multiple="multiple">';

			if ( 'specifics' == $data && isset( $saved_values['specific'] ) && null != $saved_values['specific'] && is_array( $saved_values['specific'] ) ) :
				foreach ( $saved_values['specific'] as $data_key => $sel_value ) :
					// posts.
					if ( strpos( $sel_value, 'post-' ) !== false ) :
						$post_id    = (int) str_replace( 'post-', '', $sel_value );
						$post_title = get_the_title( $post_id );
						$output    .= '<option value="post-' . $post_id . '" selected="selected" >' . $post_title . '</option>';
					endif;

					// taxonomy options.
					if ( strpos( $sel_value, 'tax-' ) !== false ) :
						$tax_data = explode( '-', $sel_value );

						$tax_id    = (int) str_replace( 'tax-', '', $sel_value );
						$term      = get_term( $tax_id );
						$term_name = '';

						if ( ! is_wp_error( $term ) ) :
							$term_taxonomy = ucfirst( str_replace( '_', ' ', $term->taxonomy ) );

							if ( isset( $tax_data[2] ) && 'single' === $tax_data[2] ) :
								$term_name = 'All singulars from ' . $term->name;
							else :
								$term_name = $term->name . ' - ' . $term_taxonomy;
							endif;
						endif;

						$output .= '<option value="' . $sel_value . '" selected="selected" >' . $term_name . '</option>';
					endif;
				endforeach;
			endif;
			$output .= '</select>';
			$output .= '</div>';
		endforeach;

		$output .= '</div>';

		/* Add new rule */
		$output .= '<div class="target_rule-add-rule-wrap">';
		$output .= '<a href="#" class="button" data-rule-id="' . absint( $index ) . '" data-rule-type="' . $type . '">' . $add_rule_label . '</a>';
		$output .= '</div>';

		if ( 'display' == $type ) :
			/* Add new rule */
			$output .= '<div class="target_rule-add-exclusion-rule">';
			$output .= '<a href="#" class="button">' . __( 'Add Exclusion Rule', 'exclusive-addons-elementor-pro' ) . '</a>';
			$output .= '</div>';
		endif;

		return $output;
	}

	/**
	 * Checks for the display condition for the current page/
	 *
	 * @param  int   $post_id Current post ID.
	 * @param  array $rules   Array of rules Display on | Exclude on.
	 *
	 * @return boolean      Returns true or false depending on if the $rules match for the current page and the layout is to be displayed.
	 */
	public function parse_layout_display_condition( $post_id, $rules ) {
		$display           = false;
		$current_post_type = get_post_type( $post_id );

		if ( isset( $rules['rule'] ) && is_array( $rules['rule'] ) && ! empty( $rules['rule'] ) ) :
			foreach ( $rules['rule'] as $key => $rule ) :
				if ( strrpos( $rule, 'all' ) !== false ) :
					$rule_case = 'all';
				else :
					$rule_case = $rule;
				endif;

				switch ( $rule_case ) :
					case 'basic-global':
						$display = true;
						break;

					case 'basic-singulars':
						if ( is_singular() ) :
							$display = true;
						endif;
						break;

					case 'basic-archives':
						if ( is_archive() ) :
							$display = true;
						endif;
						break;

					case 'special-404':
						if ( is_404() ) :
							$display = true;
						endif;
						break;

					case 'special-search':
						if ( is_search() ) :
							$display = true;
						endif;
						break;

					case 'special-blog':
						if ( is_home() ) :
							$display = true;
						endif;
						break;

					case 'special-front':
						if ( is_front_page() ) :
							$display = true;
						endif;
						break;

					case 'special-date':
						if ( is_date() ) :
							$display = true;
						endif;
						break;

					case 'special-author':
						if ( is_author() ) :
							$display = true;
						endif;
						break;

					case 'special-woo-shop':
						if ( function_exists( 'is_shop' ) && is_shop() ) :
							$display = true;
						endif;
						break;

					case 'all':
						$rule_data = explode( '|', $rule );

						$post_type     = isset( $rule_data[0] ) ? $rule_data[0] : false;
						$archieve_type = isset( $rule_data[2] ) ? $rule_data[2] : false;
						$taxonomy      = isset( $rule_data[3] ) ? $rule_data[3] : false;
						if ( false === $archieve_type ) :
							$current_post_type = get_post_type( $post_id );

							if ( false !== $post_id && $current_post_type == $post_type ) :
								$display = true;
							endif;
						else :
							if ( is_archive() ) :
								$current_post_type = get_post_type();
								if ( $current_post_type == $post_type ) :
									if ( 'archive' == $archieve_type ) :
										$display = true;
									elseif ( 'taxarchive' == $archieve_type ) :
										$obj              = get_queried_object();
										$current_taxonomy = '';
										if ( '' !== $obj && null !== $obj ) :
											$current_taxonomy = $obj->taxonomy;
										endif;

										if ( $current_taxonomy == $taxonomy ) :
											$display = true;
										endif;
									endif;
								endif;
							endif;
						endif;
						break;

					case 'specifics':
						if ( isset( $rules['specific'] ) && is_array( $rules['specific'] ) ) :
							foreach ( $rules['specific'] as $specific_page ) :
								$specific_data = explode( '-', $specific_page );

								$specific_post_type = isset( $specific_data[0] ) ? $specific_data[0] : false;
								$specific_post_id   = isset( $specific_data[1] ) ? $specific_data[1] : false;
								if ( 'post' == $specific_post_type ) :
									if ( $specific_post_id == $post_id ) :
										$display = true;
									endif;
								elseif ( isset( $specific_data[2] ) && ( 'single' == $specific_data[2] ) && 'tax' == $specific_post_type ) :
									if ( is_singular() ) :
										$term_details = get_term( $specific_post_id );

										if ( isset( $term_details->taxonomy ) ) :
											$has_term = has_term( (int) $specific_post_id, $term_details->taxonomy, $post_id );

											if ( $has_term ) :
												$display = true;
											endif;
										endif;
									endif;
								elseif ( 'tax' == $specific_post_type ) :
									$tax_id = get_queried_object_id();
									if ( $specific_post_id == $tax_id ) :
										$display = true;
									endif;
								endif;
							endforeach;
						endif;
						break;

					default:
						break;
				endswitch;

				if ( $display ) :
					break;
				endif;
			endforeach;
		endif;

		return $display;
	}


	/**
	 * Get current page type
	 *
	 * @return string Page Type.
	 */
	public function get_current_page_type() {
		if ( null === self::$current_page_type ) :
			$page_type  = '';
			$current_id = false;

			if ( is_404() ) :
				$page_type = 'is_404';
			elseif ( is_search() ) :
				$page_type = 'is_search';
			elseif ( is_archive() ) :
				$page_type = 'is_archive';

				if ( is_category() || is_tag() || is_tax() ) :
					$page_type = 'is_tax';
				elseif ( is_date() ) :
					$page_type = 'is_date';
				elseif ( is_author() ) :
					$page_type = 'is_author';
				elseif ( function_exists( 'is_shop' ) && is_shop() ) :
					$page_type = 'is_woo_shop_page';
				endif;
			elseif ( is_home() ) :
				$page_type = 'is_home';
			elseif ( is_front_page() ) :
				$page_type  = 'is_front_page';
				$current_id = get_the_id();
			elseif ( is_singular() ) :
				$page_type  = 'is_singular';
				$current_id = get_the_id();
			else :
				$current_id = get_the_id();
			endif;

			self::$current_page_data['ID'] = $current_id;
			self::$current_page_type       = $page_type;
		endif;

		return self::$current_page_type;
	}

	/**
	 * Get posts by conditions
	 *
	 * @param  string $post_type Post Type.
	 * @param  array  $option meta option name.
	 *
	 * @return object  Posts.
	 */
	public function get_posts_by_conditions( $post_type, $option ) {
		global $wpdb;
		global $post;

		$post_type = $post_type ? esc_sql( $post_type ) : esc_sql( $post->post_type );

		if ( is_array( self::$current_page_data ) && isset( self::$current_page_data[ $post_type ] ) ) :
			return apply_filters( 'exad_get_display_posts_by_conditions', self::$current_page_data[ $post_type ], $post_type );
		endif;

		$current_page_type = $this->get_current_page_type();

		self::$current_page_data[ $post_type ] = array();

		$option['current_post_id'] = self::$current_page_data['ID'];
		$meta_header               = self::get_meta_option_post( $post_type, $option );

		/* Meta option is enabled */
		if ( false === $meta_header ) :
			$current_post_type = esc_sql( get_post_type() );
			$current_post_id   = false;
			$q_obj             = get_queried_object();

			$location = isset( $option['location'] ) ? esc_sql( $option['location'] ) : '';

			$query = "SELECT p.ID, pm.meta_value FROM {$wpdb->postmeta} as pm
						INNER JOIN {$wpdb->posts} as p ON pm.post_id = p.ID
						WHERE pm.meta_key = '{$location}'
						AND p.post_type = '{$post_type}'
						AND p.post_status = 'publish'";

			$orderby = ' ORDER BY p.post_date DESC';

			/* Entire Website */
			$meta_args = "pm.meta_value LIKE '%\"basic-global\"%'";

			switch ( $current_page_type ) :
				case 'is_404':
					$meta_args .= " OR pm.meta_value LIKE '%\"special-404\"%'";
					break;
				case 'is_search':
					$meta_args .= " OR pm.meta_value LIKE '%\"special-search\"%'";
					break;
				case 'is_archive':
				case 'is_tax':
				case 'is_date':
				case 'is_author':
					$meta_args .= " OR pm.meta_value LIKE '%\"basic-archives\"%'";
					$meta_args .= " OR pm.meta_value LIKE '%\"{$current_post_type}|all|archive\"%'";

					if ( 'is_tax' == $current_page_type && ( is_category() || is_tag() || is_tax() ) ) :
						if ( is_object( $q_obj ) ) :
							$meta_args .= " OR pm.meta_value LIKE '%\"{$current_post_type}|all|taxarchive|{$q_obj->taxonomy}\"%'";
							$meta_args .= " OR pm.meta_value LIKE '%\"tax-{$q_obj->term_id}\"%'";
						endif;
					elseif ( 'is_date' == $current_page_type ) :
						$meta_args .= " OR pm.meta_value LIKE '%\"special-date\"%'";
					elseif ( 'is_author' == $current_page_type ) :
						$meta_args .= " OR pm.meta_value LIKE '%\"special-author\"%'";
					endif;
					break;
				case 'is_home':
					$meta_args .= " OR pm.meta_value LIKE '%\"special-blog\"%'";
					break;
				case 'is_front_page':
					$current_id      = esc_sql( get_the_id() );
					$current_post_id = $current_id;
					$meta_args      .= " OR pm.meta_value LIKE '%\"special-front\"%'";
					$meta_args      .= " OR pm.meta_value LIKE '%\"{$current_post_type}|all\"%'";
					$meta_args      .= " OR pm.meta_value LIKE '%\"post-{$current_id}\"%'";
					break;
				case 'is_singular':
					$current_id      = esc_sql( get_the_id() );
					$current_post_id = $current_id;
					$meta_args      .= " OR pm.meta_value LIKE '%\"basic-singulars\"%'";
					$meta_args      .= " OR pm.meta_value LIKE '%\"{$current_post_type}|all\"%'";
					$meta_args      .= " OR pm.meta_value LIKE '%\"post-{$current_id}\"%'";

					$taxonomies = get_object_taxonomies( $q_obj->post_type );
					$terms      = wp_get_post_terms( $q_obj->ID, $taxonomies );

					foreach ( $terms as $key => $term ) :
						$meta_args .= " OR pm.meta_value LIKE '%\"tax-{$term->term_id}-single-{$term->taxonomy}\"%'";
					endforeach;

					break;
				case 'is_woo_shop_page':
					$meta_args .= " OR pm.meta_value LIKE '%\"special-woo-shop\"%'";
					break;
				case '':
					$current_post_id = get_the_id();
					break;
			endswitch;

			// Ignore the PHPCS warning about constant declaration.
			// @codingStandardsIgnoreStart
			$posts  = $wpdb->get_results( $query . ' AND (' . $meta_args . ')' . $orderby );
			// @codingStandardsIgnoreEnd

			foreach ( $posts as $local_post ) :
				self::$current_page_data[ $post_type ][ $local_post->ID ] = array(
					'id'       => $local_post->ID,
					'location' => unserialize( $local_post->meta_value )
				);
			endforeach;

			$option['current_post_id'] = $current_post_id;

			$this->remove_exclusion_rule_posts( $post_type, $option );
		endif;

		return apply_filters( 'exad_get_display_posts_by_conditions', self::$current_page_data[ $post_type ], $post_type );
	}

	/**
	 * Remove exclusion rule posts.
	 *
	 * @param  string $post_type Post Type.
	 * @param  array  $option meta option name.
	 */
	public function remove_exclusion_rule_posts( $post_type, $option ) {
		$exclusion       = isset( $option['exclusion'] ) ? $option['exclusion'] : '';
		$current_post_id = isset( $option['current_post_id'] ) ? $option['current_post_id'] : false;

		foreach ( self::$current_page_data[ $post_type ] as $c_post_id => $c_data ) :
			$exclusion_rules = get_post_meta( $c_post_id, $exclusion, true );
			$is_exclude      = $this->parse_layout_display_condition( $current_post_id, $exclusion_rules );

			if ( $is_exclude ) :
				unset( self::$current_page_data[ $post_type ][ $c_post_id ] );
			endif;
		endforeach;
	}

	/**
	 * Meta option post.
	 *
	 * @param  string $post_type Post Type.
	 * @param  array  $option meta option name.
	 *
	 * @return false | object
	 */
	public static function get_meta_option_post( $post_type, $option ) {
		$page_meta = ( isset( $option['page_meta'] ) && '' != $option['page_meta'] ) ? $option['page_meta'] : false;

		if ( false !== $page_meta ) :
			$current_post_id = isset( $option['current_post_id'] ) ? $option['current_post_id'] : false;
			$meta_id         = get_post_meta( $current_post_id, $option['page_meta'], true );

			if ( false !== $meta_id && '' != $meta_id ) :
				self::$current_page_data[ $post_type ][ $meta_id ] = array(
					'id'       => $meta_id,
					'location' => ''
				);

				return self::$current_page_data[ $post_type ];
			endif;
		endif;

		return false;
	}

	/**
	 * Formated rule meta value to save.
	 *
	 * @param  array  $save_data PostData.
	 * @param  string $key varaible key.
	 *
	 * @return array Rule data.
	 */
	public static function get_format_rule_value( $save_data, $key ) {
		$meta_value = array();

		if ( isset( $save_data[ $key ]['rule'] ) ) :
			$save_data[ $key ]['rule'] = array_unique( $save_data[ $key ]['rule'] );
			if ( isset( $save_data[ $key ]['specific'] ) ) :
				$save_data[ $key ]['specific'] = array_unique( $save_data[ $key ]['specific'] );
			endif;

			// Unset the specifics from rule. This will be readded conditionally in next condition.
			$index = array_search( '', $save_data[ $key ]['rule'] );
			if ( false !== $index ) :
				unset( $save_data[ $key ]['rule'][ $index ] );
			endif;
			$index = array_search( 'specifics', $save_data[ $key ]['rule'] );
			if ( false !== $index ) :
				unset( $save_data[ $key ]['rule'][ $index ] );

				// Only re-add the specifics key if there are specific rules added.
				if ( isset( $save_data[ $key ]['specific'] ) && is_array( $save_data[ $key ]['specific'] ) ) :
					array_push( $save_data[ $key ]['rule'], 'specifics' );
				endif;
			endif;

			foreach ( $save_data[ $key ] as $meta_key => $value ) :
				if ( ! empty( $value ) ) :
					$meta_value[ $meta_key ] = array_map( 'esc_attr', $value );
				endif;
			endforeach;;
			if ( ! isset( $meta_value['rule'] ) || ! in_array( 'specifics', $meta_value['rule'] ) ) :
				$meta_value['specific'] = array();
			endif;

			if ( empty( $meta_value['rule'] ) ) :
				$meta_value = array();
			endif;
		endif;

		return $meta_value;
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Target_Rules_Fields::get_instance();
