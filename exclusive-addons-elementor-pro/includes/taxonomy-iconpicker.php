<?php

namespace ExclusiveAddons\Taxonomy;

class IconPicker {

	private $name = '';

	public function __construct( $name ) {
		$this->name = $name;
		add_action( $this->name.'_add_form_fields', [ $this, 'taxonomy_add_icon_field' ], 20 );
		add_action( $this->name.'_edit_form_fields', [ $this, 'taxonomy_edit_icon_field' ], 20 );
		add_action( 'edited_'.$this->name, [ $this, 'taxonomy_icon' ], 10 );  
		add_action( 'create_'.$this->name, [ $this, 'taxonomy_icon' ], 10 );
		add_filter( 'manage_edit-'.$this->name.'_columns', [ $this, 'columns_head' ], 10 );
		add_filter( 'manage_'.$this->name.'_custom_column', [ $this, 'columns_content_taxonomy' ], 10, 3 );
		add_action( 'admin_enqueue_scripts', [ $this, 'scripts_admin' ] );
		add_action( 'admin_footer', [ $this, 'icon_init' ] );
    }

	/*
	 * Add term page
	 */
	public function taxonomy_add_icon_field() {
		?>
		<div class="form-field">
			<label for="term_meta[cat_icons]"><?php _e( 'Icon', 'exclusive-addons-elementor-pro' ); ?></label>
			<div class="icon-picker-wrapper">
				<input type="text" name="term_meta[cat_icons]" class="exad-taxonomy-icon-picker" value="">
			</div>
			<p class="description"><?php _e( 'Choose an icon', 'exclusive-addons-elementor-pro' ); ?></p>
		</div>
		<?php
	}

	/*
	 * Edit term page
	 */
	public function taxonomy_edit_icon_field( $term ) {
		$t_id = $term->term_id;
		$term_meta = get_option( 'taxonomy_'.$t_id );
		if( isset ( $term_meta['cat_icons'] ) && ! empty ( $term_meta['cat_icons'] ) ) :
			$icon_value = $term_meta['cat_icons'];
		else :
			$icon_value = '';
		endif;
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="term_meta[cat_icons]"><?php _e( 'Icon', 'exclusive-addons-elementor-pro' ); ?></label></th>
			<td>
				<div class="icon-picker-wrapper" data-pickerid="fa" data-iconsets='{"fa":"Category Icon"}'>
					<input type="text" name="term_meta[cat_icons]" class="exad-taxonomy-icon-picker" value="<?php echo esc_attr( $icon_value ); ?>">
				</div>
				<p class="description"><?php _e( 'Choose an icon', 'exclusive-addons-elementor-pro' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/*
	 * Save extra taxonomy fields callback function
	 */
	public function taxonomy_icon( $term_id ) {
		if ( isset( $_POST['term_meta'] ) ) :
			$t_id = $term_id;
			$term_meta = get_option( 'taxonomy_'.$t_id );
			$cat_keys = array_keys( $_POST['term_meta'] );
			foreach ( $cat_keys as $key ) {
				if ( isset ( $_POST['term_meta'][$key] ) ) {
					$term_meta[$key] = $_POST['term_meta'][$key];
				}
			}
			// Save the option array.
			update_option( 'taxonomy_'.$t_id, $term_meta );
		endif;
	}

	/**
	 * add icon to texonomy column
	 */
	public function columns_head($defaults) {
	    $defaults['cat_icons']  = esc_html__( 'Icon', 'exclusive-addons-elementor-pro' );
	    return $defaults;
	}

	/*
	 * Icon Column Content 
	 */
	public function columns_content_taxonomy( $columns, $column, $id ) {
	    $term_meta = get_option( "taxonomy_$id" );
	    if ( 'cat_icons' === $column && isset ( $term_meta['cat_icons'] ) && ! empty ( $term_meta['cat_icons'] ) ) :	    	
	        $columns .= '<i class="fa-2x '.esc_attr( $term_meta['cat_icons'] ).'"></i>';
	       return $columns;
	    endif;
	}

	/**
	 * Icon scripts
	 */
	public function scripts_admin(){
		$screen = get_current_screen();
		if( $screen->id == 'edit-'.$this->name ) :
			wp_enqueue_script( 'exad-taxonomy-fonticonpicker', EXAD_PRO_ADMIN_URL . 'assets/css/icons/js/jquery.fonticonpicker.min.js', array( 'jquery' ), EXAD_PRO_PLUGIN_VERSION, true );
			wp_enqueue_style( 'exad-taxonomy-fonticonpicker',  EXAD_PRO_ADMIN_URL . 'assets/css/icons/css/jquery.fonticonpicker.min.css', array(), EXAD_PRO_PLUGIN_VERSION );
			wp_enqueue_style( 'exad-taxonomy-fonticonpicker-grey-theme',  EXAD_PRO_ADMIN_URL . 'assets/css/icons/css/jquery.fonticonpicker.grey.min.css', array(), EXAD_PRO_PLUGIN_VERSION );
			wp_enqueue_style( 'font-awesoume', EXAD_PRO_ADMIN_URL . 'assets/css/icons/font-awesome/css/font-awesome.min.css', array(), EXAD_PRO_PLUGIN_VERSION );
		endif;
	}

	/**
	 * Trigger the icon picker
	 */
	public function icon_init(){
		$screen = get_current_screen();
		if( $screen->id == 'edit-'.$this->name ){
			?>
			<script>
			    jQuery(document).ready(function($) {
			    	var wc_products_cat_icons = {
					    'Font Awesome' 	: [<?php echo $this->font_awesome_icons_for_iconpicker();?>],
					    <?php do_action( 'exad_wc_products_cat_icons' ); ?>
					};

			        $('.exad-taxonomy-icon-picker').fontIconPicker({
			            source:    wc_products_cat_icons,
			            emptyIcon: true,
			            hasSearch: true,
			            iconsPerPage: 72
			        });
			    } );
			</script>
			<?php
		}
	}

	/**
	 * Making Font Awesome icons string for icon picker 
	 */
	public function font_awesome_icons_for_iconpicker(){
		$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"\\\\(.+)";\s+}/';
		$subject =  wp_remote_fopen( EXAD_PRO_ADMIN_URL . 'assets/css/icons/font-awesome/css/font-awesome.css' );
		preg_match_all( $pattern, $subject, $matches, PREG_SET_ORDER );

		foreach($matches as $match) :
		    $icons[$match[1]] = $match[2];
		endforeach;

		ksort($icons);

		$output = array();

		foreach ($icons as $key => $icon) :
			$output[] = 'fa '.$key;
		endforeach;

		return "'".implode( "','", $output )."'";
	}

}

if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :
	new IconPicker( 'product_cat' );
endif;