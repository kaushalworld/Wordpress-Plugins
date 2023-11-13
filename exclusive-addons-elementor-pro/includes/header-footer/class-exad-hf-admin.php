<?php
namespace ExclusiveAddons\Pro\Includes\HeaderFooter;

use ExclusiveAddons\Pro\Includes\HeaderFooter\Target_Rules_Fields;

defined( 'ABSPATH' ) or exit;

/**
 * Admin setup
 */
class Admin {

	/**
	 * Instance of Admin
	 */
	private static $_instance = null;

	/**
	 * Instance of Admin
	 *
	 * @return Admin Instance of Admin
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) :
			self::$_instance = new self();
		endif;

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'init', [ $this, 'header_footer_posttype' ] );
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 50 );
		add_action( 'add_meta_boxes', [ $this, 'register_metabox' ] );
		add_action( 'save_post', [ $this, 'save_meta' ] );
		add_action( 'admin_notices', [ $this, 'location_notice' ] );
		add_action( 'template_redirect', [ $this, 'block_template_frontend' ] );
		add_filter( 'manage_exad-elementor-hf_posts_columns', [ $this, 'set_shortcode_columns' ] );
		add_action( 'manage_exad-elementor-hf_posts_custom_column', [ $this, 'render_shortcode_column' ], 10, 2 );
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) && ELEMENTOR_PRO_VERSION > 2.8 ) :
			add_action( 'elementor/editor/footer', [ $this, 'register_hf_epro_script' ], 99 );
		endif;

		if ( is_admin() ) :
			add_action( 'manage_exad-elementor-hf_posts_custom_column', [ $this, 'column_content' ], 10, 2 );
			add_filter( 'manage_exad-elementor-hf_posts_columns', [ $this, 'column_headings' ] );
		endif;
	}

	/**
	 * Script for Elementor Pro full site editing support.
	 */
	public function register_hf_epro_script() {
		$ids_array = [
			[
				'id'    => get_exad_header_id(),
				'value' => 'Header'
			],
			[
				'id'    => get_exad_footer_id(),
				'value' => 'Footer'
			]
		];

		wp_enqueue_script( 'exad-hf-elementor-pro-compatibility', EXAD_PRO_URL . 'assets/js/exad-hf-elementor-pro-compatibility.js', [ 'jquery' ], EXAD_PRO_PLUGIN_VERSION, true );

		wp_localize_script(
			'exad-hf-elementor-pro-compatibility',
			'exad_hf_admin',
			[
				'ids_array' => wp_json_encode( $ids_array ),
			]
		);
	}

	/**
	 * Adds or removes list table column headings.
	 *
	 * @param array $columns Array of columns.
	 * @return array
	 */
	public function column_headings( $columns ) {
		unset( $columns['date'] );

		$columns['exad_hf_display_rules'] = __( 'Display Rules', 'exclusive-addons-elementor-pro' );
		$columns['date']                  = __( 'Date', 'exclusive-addons-elementor-pro' );

		return $columns;
	}

	/**
	 * Adds the custom list table column content.
	 */
	public function column_content( $column, $post_id ) {

		if ( 'exad_hf_display_rules' == $column ) :

			$locations = get_post_meta( $post_id, 'exad_hf_target_include_locations', true );
			if ( ! empty( $locations ) ) :
				echo '<div class="exad-hf-advanced-headers-location-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Display: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			endif;

			$locations = get_post_meta( $post_id, 'exad_hf_target_exclude_locations', true );
			if ( ! empty( $locations ) ) :
				echo '<div class="exad-hf-advanced-headers-exclusion-wrap" style="margin-bottom: 5px;">';
					echo '<strong>Exclusion: </strong>';
					$this->column_display_location_rules( $locations );
				echo '</div>';
			endif;
		endif;
	}

	/**
	 * Get Markup of Location rules for Display rule column.
	 *
	 * @param array $locations Array of locations.
	 * @return void
	 */
	public function column_display_location_rules( $locations ) {

		$location_label = [];
		$index          = array_search( 'specifics', $locations['rule'] );
		if ( false !== $index && ! empty( $index ) ) :
			unset( $locations['rule'][ $index ] );
		endif;

		if ( isset( $locations['rule'] ) && is_array( $locations['rule'] ) ) :
			foreach ( $locations['rule'] as $location ) :
				$location_label[] = Target_Rules_Fields::get_location_by_key( $location );
			endforeach;
		endif;
		if ( isset( $locations['specific'] ) && is_array( $locations['specific'] ) ) :
			foreach ( $locations['specific'] as $location ) :
				$location_label[] = Target_Rules_Fields::get_location_by_key( $location );
			endforeach;
		endif;

		echo join( ', ', $location_label );
	}


	/**
	 * Register Post type for header footer & blocks templates
	 */
	public function header_footer_posttype() {
		$labels = [
			'name'               => __( 'Elementor - Header Footer', 'exclusive-addons-elementor-pro' ),
			'singular_name'      => __( 'Elementor Header Footer', 'exclusive-addons-elementor-pro' ),
			'menu_name'          => __( 'Elementor - Header Footer', 'exclusive-addons-elementor-pro' ),
			'name_admin_bar'     => __( 'Elementor Header Footer', 'exclusive-addons-elementor-pro' ),
			'add_new'            => __( 'Add New', 'exclusive-addons-elementor-pro' ),
			'add_new_item'       => __( 'Add New Header, Footer or Block', 'exclusive-addons-elementor-pro' ),
			'new_item'           => __( 'New Header Footer', 'exclusive-addons-elementor-pro' ),
			'edit_item'          => __( 'Edit Header Footer', 'exclusive-addons-elementor-pro' ),
			'view_item'          => __( 'View Header Footer', 'exclusive-addons-elementor-pro' ),
			'all_items'          => __( 'All Elementor Header Footer', 'exclusive-addons-elementor-pro' ),
			'search_items'       => __( 'Search Header Footer', 'exclusive-addons-elementor-pro' ),
			'parent_item_colon'  => __( 'Parent Header Footer', 'exclusive-addons-elementor-pro' ),
			'not_found'          => __( 'No Header Footer found.', 'exclusive-addons-elementor-pro' ),
			'not_found_in_trash' => __( 'No Header Footer found in Trash.', 'exclusive-addons-elementor-pro' )
		];

		$args = [
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-editor-kitchensink',
			'supports'            => [ 'title', 'thumbnail', 'elementor' ]
		];

		register_post_type( 'exad-elementor-hf', $args );
	}

	/**
	 * Register the admin menu for Header & Footer
	 * Moved the menu under Exclusive Addons -> Header & Footer
	 */
	public function register_admin_menu() {
		add_submenu_page(
			'exad-settings',
			__( 'Header & Footer', 'exclusive-addons-elementor-pro' ),
			__( 'Header & Footer', 'exclusive-addons-elementor-pro' ),
			'edit_pages',
			'edit.php?post_type=exad-elementor-hf'
		);
	}

	/**
	 * Register meta box(es).
	 */
	function register_metabox() {
		add_meta_box(
			'exad-hf-meta-box',
			__( 'Elementor - Header Footer', 'exclusive-addons-elementor-pro' ),
			[
				$this,
				'metabox_render',
			],
			'exad-elementor-hf',
			'normal',
			'high'
		);
	}

	/**
	 * Render Meta field.
	 *
	 * @param  POST $post Currennt post object which is being displayed.
	 */
	function metabox_render( $post ) {
		$values            = get_post_custom( $post->ID );
		$template_type     = isset( $values['ehf_template_type'] ) ? esc_attr( $values['ehf_template_type'][0] ) : '';
		$sticky_header = isset( $values['sticky-header'] ) ? true : false;

		wp_nonce_field( 'exad_hf_meta_nounce', 'exad_hf_meta_nounce' );
		?>
		<table class="exad-hf-options-table widefat">
			<tbody>
				<tr class="exad-hf-options-row type-of-template">
					<td class="exad-hf-options-row-heading">
						<label for="ehf_template_type"><?php _e( 'Type of Template', 'exclusive-addons-elementor-pro' ); ?></label>
					</td>
					<td class="exad-hf-options-row-content">
						<select name="ehf_template_type" id="ehf_template_type">
							<option value="" <?php selected( $template_type, '' ); ?>><?php _e( 'Select Option', 'exclusive-addons-elementor-pro' ); ?></option>
							<option value="type_header" <?php selected( $template_type, 'type_header' ); ?>><?php _e( 'Header', 'exclusive-addons-elementor-pro' ); ?></option>
							<option value="type_footer" <?php selected( $template_type, 'type_footer' ); ?>><?php _e( 'Footer', 'exclusive-addons-elementor-pro' ); ?></option>
						</select>
					</td>
				</tr>

				<tr class="exad-hf-options-row sticky-stacked">
					<td class="exad-hf-options-row-heading">
						<label for="sticky-header">
							<?php _e( 'Sticky Header', 'exclusive-addons-elementor-pro' ); ?>
						</label>
						<i class="exad-hf-options-row-heading-help dashicons dashicons-editor-help" title="<?php _e( 'Enable Sticky Header.', 'exclusive-addons-elementor-pro' ); ?>"></i>
					</td>
					<td class="exad-hf-options-row-content">
						<input type="checkbox" id="sticky-header" name="sticky-header" value="1" <?php checked( $sticky_header, true ); ?> />
					</td>
				</tr>

				<?php $this->display_rules_tab(); ?>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Markup for Display Rules Tabs.
	 */
	public function display_rules_tab() {
		// Load Target Rule assets.
		Target_Rules_Fields::get_instance()->admin_styles();

		$include_locations = get_post_meta( get_the_id(), 'exad_hf_target_include_locations', true );
		$exclude_locations = get_post_meta( get_the_id(), 'exad_hf_target_exclude_locations', true );
		?>
		<tr class="exad-hf-target-rules-row exad-hf-options-row">
			<td class="exad-hf-target-rules-row-heading exad-hf-options-row-heading">
				<label><?php esc_html_e( 'Display On', 'exclusive-addons-elementor-pro' ); ?></label>
				<i class="exad-hf-target-rules-heading-help dashicons dashicons-editor-help"
					title="<?php echo esc_attr__( 'Add locations for where this template should appear.', 'exclusive-addons-elementor-pro' ); ?>"></i>
			</td>
			<td class="exad-hf-target-rules-row-content exad-hf-options-row-content">
				<?php
				Target_Rules_Fields::target_rule_settings_field(
					'exad-target-rules-location',
					[
						'title'          => __( 'Display Rules', 'exclusive-addons-elementor-pro' ),
						'value'          => '[{"type":"basic-global","specific":null}]',
						'tags'           => 'site,enable,target,pages',
						'rule_type'      => 'display',
						'add_rule_label' => __( 'Add Display Rule', 'exclusive-addons-elementor-pro' ),
					],
					$include_locations
				);
				?>
			</td>
		</tr>
		<tr class="exad-hf-target-rules-row exad-hf-options-row">
			<td class="exad-hf-target-rules-row-heading exad-hf-options-row-heading">
				<label><?php esc_html_e( 'Do Not Display On', 'exclusive-addons-elementor-pro' ); ?></label>
				<i class="exad-hf-target-rules-heading-help dashicons dashicons-editor-help"
					title="<?php echo esc_attr__( 'Add locations for where this template should not appear.', 'exclusive-addons-elementor-pro' ); ?>"></i>
			</td>
			<td class="exad-hf-target-rules-row-content exad-hf-options-row-content">
				<?php
				Target_Rules_Fields::target_rule_settings_field(
					'exad-hf-target-rules-exclusion',
					[
						'title'          => __( 'Exclude On', 'exclusive-addons-elementor-pro' ),
						'value'          => '[]',
						'tags'           => 'site,enable,target,pages',
						'add_rule_label' => __( 'Add Exclusion Rule', 'exclusive-addons-elementor-pro' ),
						'rule_type'      => 'exclude'
					],
					$exclude_locations
				);
				?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Save meta field.
	 *
	 * @param  POST $post_id Currennt post object which is being displayed.
	 *
	 * @return Void
	 */
	public function save_meta( $post_id ) {

		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
			return;
		endif;

		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['exad_hf_meta_nounce'] ) || ! wp_verify_nonce( $_POST['exad_hf_meta_nounce'], 'exad_hf_meta_nounce' ) ) :
			return;
		endif;

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) :
			return;
		endif;

		$target_locations = Target_Rules_Fields::get_format_rule_value( $_POST, 'exad-target-rules-location' );
		$target_exclusion = Target_Rules_Fields::get_format_rule_value( $_POST, 'exad-hf-target-rules-exclusion' );

		update_post_meta( $post_id, 'exad_hf_target_include_locations', $target_locations );
		update_post_meta( $post_id, 'exad_hf_target_exclude_locations', $target_exclusion );

		if ( isset( $_POST['ehf_template_type'] ) ) :
			update_post_meta( $post_id, 'ehf_template_type', esc_attr( $_POST['ehf_template_type'] ) );
		endif;

		if ( isset( $_POST['sticky-header'] ) ) {
			update_post_meta( $post_id, 'sticky-header', esc_attr( $_POST['sticky-header'] ) );
		} else {
			delete_post_meta( $post_id, 'sticky-header' );
		}
	}

	/**
	 * Display notice when editing the header or footer when there is one more of similar layout is active on the site.
	 */
	public function location_notice() {
		global $pagenow;
		global $post;

		if ( 'post.php' != $pagenow || ! is_object( $post ) || 'exad-elementor-hf' != $post->post_type ) :
			return;
		endif;

		$template_type = get_post_meta( $post->ID, 'ehf_template_type', true );

		if ( '' !== $template_type ) :
			$templates = \ExclusiveAddons\Pro\Includes\Header_Footer::get_template_id( $template_type );

			// Check if more than one template is selected for current template type.
			if ( is_array( $templates ) && isset( $templates[1] ) && $post->ID != $templates[0] ) :
				$post_title        = '<strong>' . get_the_title( $templates[0] ) . '</strong>';
				$template_location = '<strong>' . $this->template_location( $template_type ) . '</strong>';
				/* Translators: Post title, Template Location */
				$message = sprintf( __( 'Template %1$s is already assigned to the location %2$s', 'exclusive-addons-elementor-pro' ), $post_title, $template_location );

				echo '<div class="error"><p>';
				echo $message;
				echo '</p></div>';
			endif;
		endif;
	}

	/**
	 * Convert the Template name to be added in the notice.
	 */
	public function template_location( $template_type ) {
		$template_type = ucfirst( str_replace( 'type_', '', $template_type ) );

		return $template_type;
	}

	/**
	 * Don't display the elementor header footer & blocks templates on the frontend for non edit_posts capable users.
	 *
	 */
	public function block_template_frontend() {
		if ( is_singular( 'exad-elementor-hf' ) && ! current_user_can( 'edit_posts' ) ) :
			wp_redirect( site_url(), 301 );
			die;
		endif;
	}

	/**
	 * Set shortcode column for template list.
	 *
	 * @param array $columns template list columns.
	 */
	function set_shortcode_columns( $columns ) {
		$date_column = $columns['date'];

		unset( $columns['date'] );

		$columns['shortcode'] = __( 'Shortcode', 'exclusive-addons-elementor-pro' );
		$columns['date']      = $date_column;

		return $columns;
	}

	/**
	 * Display shortcode in template list column.
	 *
	 * @param array $column template list column.
	 * @param int   $post_id post id.
	 */
	function render_shortcode_column( $column, $post_id ) {
		switch ( $column ) {
			case 'shortcode':
				ob_start();
				?>
				<span class="exad-hf-shortcode-col-wrap">
					<input type="text" onfocus="this.select();" readonly="readonly" value="[exad_hf_template id='<?php echo esc_attr( $post_id ); ?>']" class="exad-hf-large-text code">
				</span>

				<?php

				ob_get_contents();
				break;
		}
	}
}

Admin::instance();
