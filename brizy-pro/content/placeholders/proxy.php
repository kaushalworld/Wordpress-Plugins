<?php

use \BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;

class BrizyPro_Content_Placeholders_Proxy extends Brizy_Content_Placeholders_Abstract
{

    /**
     * @var Brizy_Content_Placeholders_Abstract
     */
    protected $placeholder;

    /**
     * @var string
     */
    private $name;

    /**
     * BrizyPro_Content_Placeholders_Proxy constructor.
     *
     * @param $name
     * @param Brizy_Content_Placeholders_Simple $placeholder
     * @param string $display
     */
    public function __construct($name, Brizy_Content_Placeholders_Abstract $placeholder, $display = Brizy_Content_Placeholders_Abstract::DISPLAY_INLINE)
    {
        $this->setPlaceholder($placeholder);
        $this->setLabel($name);
        $this->setDisplay($display);
        $this->setGroup(null);

    }

    public function support($placeholderName)
    {
        return $this->placeholder->support($placeholderName);
    }

    /**
     * @param ContextInterface $context
     * @param ContentPlaceholder $contentPlaceholder
     * @return mixed
     */
    public function getValue(ContextInterface $context, ContentPlaceholder $contentPlaceholder)
    {
        return $this->placeholder->getValue($context, $contentPlaceholder);
    }

    /**
     * @return mixed
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param mixed $placeholder
     *
     * @return Brizy_Content_Placeholders_Abstract
     */
    public function setPlaceholder($placeholder)
    {
        parent::setPlaceholder($placeholder);
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->placeholder->getLabel();
    }

    /**
     * @param mixed $label
     *
     * @return Brizy_Content_Placeholders_Abstract
     */
    public function setLabel($label)
    {
        return $this->placeholder->setLabel($label);
    }

}