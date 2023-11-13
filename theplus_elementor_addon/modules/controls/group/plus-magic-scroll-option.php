<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Theplus_Magic_Scroll_Option_Style_Group extends Elementor\Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'plus-magic-scroll-option';
	}

	protected function init_fields() {

		$fields = [];
		
		$fields['scroll_offset'] = array(
			'label' => esc_html__( 'Offset', 'theplus' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'min' => -2000,
			'max' => 2000,
			'step' => 2,
			'default' => 0,
		);
		$fields['scroll_duration'] = array(
			'label' => esc_html__( 'Duration', 'theplus' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'min' => -4000,
			'max' => 4000,
			'step' => 10,
			'default' => 300,
		);
		return $fields;
	}
}