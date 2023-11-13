<?php


namespace ShopEngine_Pro\Libs\Schedule;


class Scheduler {


	public static function add( $hook, $callback, $recurrence = 'daily', $start_time = '' ) {
		if ( ! wp_next_scheduled( $hook ) ) {
			if(!$start_time) $start_time = time();
			wp_schedule_event( $start_time, $recurrence, $hook );
		}

		add_action( $hook, $callback );
	}

	public static function delete($hook){
		wp_clear_scheduled_hook($hook);
	}

}