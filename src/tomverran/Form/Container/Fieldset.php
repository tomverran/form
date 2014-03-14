<?php
/**
 * Fieldse.php
 * @author Tom
 * @since 13/03/14
 */

namespace tomverran\Form\Container;
use tomverran\Form\Container;

class Fieldset extends Container
{
    /**
     * @var string Our legend
     */
    protected $attrLegend = '';

    /**
     * Render summat before the kids
     * @return string
     */
    protected function renderBeforeChildren()
    {
        $legend = $this->attrLegend ? '<legend>' . $this->attrLegend . '</legend>' : '';
        return '<fieldset' . $this->getEscapedAttributeString() . '>' . $legend . parent::renderBeforeChildren();
    }

    /**
     * Render summat after the kids
     * @return string
     */
    protected function renderAfterChildren()
    {
        return parent::renderAfterChildren() . '</fieldset>';
    }
} 