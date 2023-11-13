<?php

namespace ShopEngine_Pro\Modules\Currency_Switcher;

abstract class Currency_Providers {
	abstract function get_name();
	abstract function get_currencies($settings);
}