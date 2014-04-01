<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tom
 * Date: 29/03/14
 * Time: 14:13
 * To change this template use File | Settings | File Templates.
 */

namespace tomverran\Form\Field;
use tomverran\Form\Field;

class Html extends Field
{
    protected $attrValue;

    /**
     * Render this
     * @return string
     */
    public function renderElement()
    {
        return '<div' . $this->getEscapedAttributeString() . '>' . $this->attrValue . '</div>';
    }
}