<?php
/**
 * Form.php
 * @author Tom
 * @since 13/03/14
 */

namespace tomverran\Form\Container;
use tomverran\Form\Container;

class Form extends Container
{
    /**
     * Construct this form
     * @param string $action
     * @param string $method
     * @param array $options
     */
    public function __construct($action = '', $method = 'post', $options = [])
    {
        parent::__construct(array_replace($options, ['action' => $action, 'method' => $method]));
    }

    /**
     * Render summat before the kids
     * @return string
     */
    protected function renderBeforeChildren()
    {
        return '<form' . $this->getEscapedAttributeString() . '>' . parent::renderBeforeChildren();
    }

    /**
     * Render summat after the kids
     * @return string
     */
    protected function renderAfterChildren()
    {
        return parent::renderAfterChildren() . '</form>';
    }
}