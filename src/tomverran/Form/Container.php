<?php
/**
 * Containe.php
 * @author Tom
 * @since 13/03/14
 */

namespace tomverran\Form;

/**
 * Class Container - This is an element that contains other elements
 * @package tomverran\Form
 */
abstract class Container extends Element
{
    /**
     * @var Element[]
     */
    private $elements = [];

    /**
     * @var string
     */
    protected $attrBeforeChildren = '';

    /**
     * @var string
     */
    protected $attrAfterChildren = '';

    /**
     * Is this container valid
     * @param mixed $data
     * @return mixed|void
     */
    public function isValid($data)
    {
        $isValid = true;
        foreach ($this->elements as $child) {
            $isValid = $isValid && $child->isValid($data);
        }
    }

    /**
     * Populate all our children with the data
     * Because we know nothing about our children
     * each of them gets the entire data array to pick from
     * @param array $data
     * @return mixed|void
     */
    public function populate($data)
    {
        foreach ($this->elements as $child) {
            $child->populate($data);
        }
    }

    /**
     * Add an element
     * @param Element $element
     * @return $this|\tomverran\Form\Container
     */
    public function add(Element $element)
    {
        $this->elements[] = $element;
        return $element instanceof Container ? $element : $this;
    }

    /**
     * Render some html before our children
     * @return string
     */
    protected function renderBeforeChildren()
    {
        return $this->attrBeforeChildren;
    }

    /**
     * Render some html after out children
     * @return string
     */
    protected function renderAfterChildren()
    {
        return $this->attrAfterChildren;
    }

    /**
     * Render this element
     * @return string
     */
    protected function renderElement()
    {
        $buffer = $this->renderBeforeElement() . $this->renderBeforeChildren();
        foreach ($this->elements as $element) {
            $buffer .= $element->render();
        }
        $buffer .= $this->renderAfterChildren() . $this->renderAfterElement();
        return $buffer;
    }
} 