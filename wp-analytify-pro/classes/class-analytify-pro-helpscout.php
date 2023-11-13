<?php
/**
 * Class Analytify_Pro_HelpScout
 */
class Analytify_Pro_HelpScout {

	/**
	 * The id for the beacon.
	 *
	 * @var string
	 */
	private $beacon_id;

	/**
	 * The pages where the beacon is loaded.
	 *
	 * @var array
	 */
	private $pages;

	/**
	 * Analytify_Pro_HelpScout constructor.
	 *
	 * @param string $beacon_id   The beacon id.
	 * @param array  $pages       The pages where the beacon is loaded.
	 */
	public function __construct( $beacon_id, array $pages ) {

		$this->beacon_id   = $beacon_id;
		$this->pages       = $pages;

		$this->init();
	}

	/**
	 * Initialize the class.
	 */
	public function init() {

		if ( ! $this->is_beacon_page() ) {
			return;
		}

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_help_scout_script' ] );
	}

	/**
	 * Enqueues the HelpScout script.
	 */
	public function enqueue_help_scout_script() {

		wp_enqueue_script( 'analytify-helpscout-js', plugins_url( 'assets/js/wp-analytify-helpscout.js', dirname( __FILE__ ) ), array(), ANALYTIFY_VERSION );
		wp_localize_script( 'analytify-helpscout-js', 'analytify_helpscout', [
			'beacon_id' => $this->beacon_id
		] );
	}

	/**
	 * Checks if the current page can contain the beacon.
	 *
	 * @return bool
	 */
	private function is_beacon_page() {

		return in_array( $this->get_current_page(), $this->pages, true );
	}

	/**
	 * Retrieves the value of the current page.
	 *
	 * @return string The current page.
	 */
	private function get_current_page() {

		$page = filter_input( INPUT_GET, 'page' );
		
		if ( isset( $page ) && $page !== false ) {
			return $page;
		}

		return '';
	}

}

new Analytify_Pro_HelpScout( 'd4ebb293-a1e5-4497-a668-5e1a4666bc67', ['analytify-settings'] );