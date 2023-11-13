<?php

namespace WPRA\FieldManager;

class Color extends Field implements RenderField {
    private $states = [];

    public function setStates($states) {
        $this->states = $states;
        return $this;
    }

    public static function create() {
        return new self();
    }

    function render() {
        $is_disabled    = $this->disabled ? 'disabled' : '';
        $state_switches = ''; ?>
        <div class="wpra-field wpra-color-input <?php echo $this->classes; ?>">
            <div class="wpra-field-label">
                <label class="<?php if (!empty($this->factory_value)) echo 'wpra-reset-field-label'; ?>" for="<?php echo $this->id; ?>">
                    <span><?php echo $this->label; ?></span>
                </label>
                <?php if (!empty($this->factory_value)): ?>
                    <span data-factory_value="<?php echo $this->factory_value; ?>">reset</span>
                <?php endif; ?>
            </div>
            <div class="wpra-color-input-wrap">
                <input type="text" id="<?php echo $this->id; ?>"
                       name="<?php echo $this->id; ?>" class="form-control wpra-color-chooser"
                       value="<?php echo $this->value; ?>" <?php echo $is_disabled; ?> data-state="normal">
                <?php if (!empty($this->states)):
                    foreach ($this->states as $state => $value): ?>
                        <input type="text" id="<?php echo $this->id . '_' . $state; ?>"
                               name="<?php echo $this->id . '_' . $state; ?>" class="form-control wpra-color-chooser"
                               value="<?php echo $value; ?>" <?php echo $is_disabled; ?> data-state="<?php echo $state; ?>">
                        <?php
                        $state_switches .= '<span data-state="' . $state . '">' . $state . '</span>';
                    endforeach; ?>
                    <div class="wpra-color-input-states">
                        <span class="active" data-state="normal">normal</span>
                        <?php echo $state_switches; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
