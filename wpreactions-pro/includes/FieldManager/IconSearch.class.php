<?php

namespace WPRA\FieldManager;

class IconSearch extends Field implements RenderField {
    private $placeholder;

    public static function create() {
        return new self();
    }

    public function setPlaceholder($placeholder) {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function render() { ?>
        <div class="icon-search-box <?php echo $this->classes; ?>">
            <input type="hidden" id="<?php echo $this->id; ?>" class="icon-search-box-value" value="<?php echo $this->value; ?>">
            <div class="icon-search-box-selected"><i class="<?php echo $this->value; ?>"></i></div>
            <div class="icon-search-box-input">
                <input type="text" class="icon-search-input form-control no-wpra-option" placeholder="<?php echo $this->placeholder; ?>">
                <span class="wpra-spinner spinner-sm"></span>
                <div class="icon-search-box-result"></div>
            </div>
        </div>
    <?php }
}