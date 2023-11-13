<?php

namespace WPRA\Helpers;

class Cron {
    private $jobs;

    function __construct($jobs) {
        $this->jobs = $jobs;

        foreach ($this->jobs as $job) {
            $this->action($job['hook'], $job['callback']);
        }
    }

    static function instance($jobs) {
        return new self($jobs);
    }

    function unscheduleAll() {
        foreach ($this->jobs as $job) {
            wp_clear_scheduled_hook($job['hook']);
        }
    }

    function registerAll() {
        foreach ($this->jobs as $job) {
            if (!wp_next_scheduled($job['hook'])) {
                wp_schedule_event(time(), $job['schedule'], $job['hook']);
            }
        }
    }

    function action($hook, $callback) {
        add_action($hook, $callback);
    }
}