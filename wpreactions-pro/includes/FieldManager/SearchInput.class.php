<?php

namespace WPRA\FieldManager;

class SearchInput extends Field implements RenderField {
    private $placeholder = '';
    public $values;

    public static function create() {
        return new self();
    }

    public function setValues($values) {
        $this->values = $values;
        return $this;
    }

    public function setPlaceholder($placeholder) {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function render() {
        $selected_val   = empty($this->value) ? key($this->values) : $this->value;
        $selected_val   = empty($selected_val) ? '' : $selected_val;
        $selected_label = empty($selected_val) ? '' : $this->values[$selected_val];
        $is_disabled    = $this->disabled ? 'disabled="disabled"' : ''; ?>
        <div class="wpra-searchable-input <?php echo $this->classes; ?>" <?php echo $this->getDataAttrs(); ?>>
            <input type="hidden" id="<?php echo $this->id; ?>" value="<?php echo $selected_val; ?>">
            <input type="text" class="form-control wpra-no-save" <?php echo $is_disabled; ?>
                   placeholder="<?php echo $this->placeholder; ?>" value="<?php echo $selected_label; ?>">
            <div class="wpra-searchable-input-dropdown wpra-searchable-input-dropdown-values">
                <?php foreach ($this->values as $value => $label): ?>
                    <div class="wpra-searchable-input-dropdown-value" data-value="<?php echo $value; ?>"><?php echo $label; ?></div>
                <?php endforeach; ?>
            </div>
            <div class="wpra-searchable-input-dropdown wpra-searchable-input-dropdown-search"></div>
            <div class="wpra-searchable-input-arrow"></div>
        </div>
    <?php }
}