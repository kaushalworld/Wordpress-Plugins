<?php

namespace WPRA\FieldManager;

class Range extends Field {
    private $min = 0;
    private $max;
    private $unit = 'px';

    public function setMin($min) {
        $this->min = $min;
        return $this;
    }

    public function setMax($max) {
        $this->max = $max;
        return $this;
    }

    public function setUnit($unit) {
        $this->unit = $unit;
        return $this;
    }

    public static function create() {
        return new self();
    }

    function render() {
        $value_wo_unit   = str_replace($this->unit, '', $this->value);
        $factory_wo_unit = str_replace($this->unit, '', $this->factory_value); ?>
        <div class="wpra-field wpra-range-slider <?php echo $this->classes; ?>">
            <div class="wpra-field-label">
                <label class="<?php if (!empty($this->factory_value)) echo 'wpra-reset-field-label'; ?>" for="<?php echo $this->id; ?>">
                    <span><?php echo $this->label . ' (<span class="wpra-range-slider-curr-val">' . $this->value . '</span>)'; ?></span>
                </label>
                <?php if (!empty($this->factory_value)): ?>
                    <span data-factory_value="<?php echo $factory_wo_unit; ?>">reset</span>
                <?php endif; ?>
            </div>
            <div class="wpra-range-slider-input-wrap">
                <span class="wpra-range-slider-change" data-change="minus"><i class="qas qa-minus"></i></span>
                <input type="range" id="<?php echo $this->id; ?>"
                       min="<?php echo $this->min; ?>" max="<?php echo $this->max; ?>"
                       value="<?php echo $value_wo_unit; ?>" data-unit="<?php echo $this->unit; ?>">
                <span class="wpra-range-slider-change" data-change="plus"><i class="qas qa-plus"></i></span>
            </div>
        </div>
    <?php }
}
