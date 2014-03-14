<?php
/**
 * Selec.php
 * @author Tom
 * @since 14/03/14
 */

namespace tomverran\Form\Field;
use tomverran\Form\Field;
use Zend\Validator\InArray;

/**
 * Class Select - A select field
 * @package tomverran\Form\Field
 */
class Select extends Field
{
    /**
     * An array of options
     * @var array
     */
    protected $attrOptions = [];

    /**
     * The "value" of this select
     * which we rewrite to be the selected option
     * @var string
     */
    protected $attrValue = null;

    /**
     * Is this select valid?
     * If this select has options we also add a compulsory
     * inArray validator check for security etc
     * @param array $data
     * @return bool|mixed
     */
    public function isValid($data)
    {
        $passesInArrayCheck = true;
        if (is_array($this->attrOptions) && count($this->attrOptions)) {
            $passesInArrayCheck =(new InArray(['haystack' => array_keys($this->attrOptions)]))->isValid($data[$this->getAttribute('name')]);
        }
        return parent::isValid($data) && $passesInArrayCheck;
    }

    /**
     * Render the element itself
     * @return string
     */
    protected function renderElement()
    {
        $buffer = '<select' . $this->getEscapedAttributeString() . '>';
        if (is_array($this->attrOptions)) {
            foreach ($this->attrOptions as $value => $label) {
                $optionAttrs = ['value' => $value] + ($this->attrValue === $value ? ['selected' => 'selected'] : []);
                $buffer .= '<option' . $this->getEscapedAttributeString($optionAttrs) . '>' . $this->escape($label) . '</option>';
            }
        }
        return $buffer . '</select>';
    }
}