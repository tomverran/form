<?php
/**
 * Input.php
 * @author Tom
 * @since 13/03/14
 */

namespace tomverran\Form;

/**
 * Most form elements have the input tag so handle em all
 * @package tomverran\di
 */
abstract class Input extends Field
{
    /**
     * The non-overridable type of this input
     * @var string
     */
    protected $type;

    /**
     * Render an element
     * @return string
     */
    public function renderElement()
    {
        $this->setAttribute('type', $this->type);
        return '<input' . $this->getEscapedAttributeString() . '/>';
    }
} 