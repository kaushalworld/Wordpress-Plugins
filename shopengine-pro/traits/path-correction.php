<?php

namespace ShopEngine_Pro\Traits;


trait Path_Correction {

	protected function get_builder_template_dir() {

		return \ShopEngine_Pro::plugin_dir() . 'templates/screens/';
	}
}
