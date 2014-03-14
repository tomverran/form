<?php
/**
 * Element.php
 * @author Tom
 * @since 13/03/14
 */

namespace tomverran\Form;
use Zend\Escaper\Escaper;

/**
 * The highest abstraction of form element, groups common HTML behaviours
 * and dubious magical setting of private class properties when setting attributes
 * @package tomverran\di
 */
abstract class Element
{
    /**
     * Attributes of this element
     * @var array
     */
    private $attributes = [];

    /**
     * HTML to render before this element
     * @var string
     */
    protected $attrBeforeElement = '';

    /**
     * HTML to render after this element
     * @var string
     */
    protected $attrAfterElement = '';

    /**
     * The charset to use for all elements
     * @var string the charset
     */
    private static $defaultCharset = 'utf-8';

    /**
     * The default options for element subclasses,
     * stored as class name => options
     * @var array
     */
    private static $defaultOptions = [];

    /**
     * A Zend_Escaper used to escape things
     * kept private to minimise the extent of the dependency
     * @var \Zend\Escaper\Escaper
     */
    private $escaper = null;

    /**
     * Construct this element
     * @param $options
     */
    public function __construct($options = [])
    {
        foreach (array_replace($this->getDefaultOptions(), $options) as $option => $value) {
            $this->setAttribute($option, $value);
        }
        $this->escaper = new Escaper(self::$defaultCharset);
    }

    /**
     * Get the default options for this class
     * @return array
     */
    protected function getDefaultOptions()
    {
        $parents = [get_called_class()];
        $class = reset($parents);

        while ($parent = get_parent_class($class)) {
            $parents[] = $parent;
            $class = $parent;
        }

        $defaultOptions = [];
        foreach(array_reverse($parents) as $parent) {
            if (isset(self::$defaultOptions[$parent])) {
                $defaultOptions = array_replace($defaultOptions, self::$defaultOptions[$parent]);
            }
        }
        return $defaultOptions;
    }

    /**
     * Set the default options for this class,
     * these will then be replaced by default options set
     * further down the class heirarchy, or on element construction
     * @param array $options
     */
    public static function setDefaultOptions(array $options)
    {
        self::$defaultOptions[get_called_class()] = $options;
    }

    /**
     * Set the default charset for all elements
     * This needs to be used before anything is inited
     * @param $charset
     */
    public static function setDefaultCharset($charset)
    {
        self::$defaultCharset = $charset;
    }

    /**
     * Get a property we should try to set for the given attribute
     * @param string $attribute The attribute that may map to a property
     * @return string
     */
    private static function getCandidateProperty($attribute)
    {
        return 'attr' . ucfirst($attribute);
    }

    /**
     * Set an attribute of this class
     * @param string $attribute
     * @param mixed $value
     */
    public function setAttribute($attribute, $value)
    {
        $candidateProperty = self::getCandidateProperty($attribute);
        if (property_exists($this, $candidateProperty)) {
            $this->$candidateProperty = $value;
        } else {
            $this->attributes[$attribute] = $value;
        }
    }

    /**
     * Get an attribute of this class
     * @param $attribute
     * @return mixed
     */
    public function getAttribute($attribute)
    {
        $candidateProperty = self::getCandidateProperty($attribute);
        if (property_exists($this, $candidateProperty)) {
            return $this->$candidateProperty;
        }
        return array_key_exists($attribute, $this->attributes) ? $this->attributes[$attribute] : null;
    }

    /**
     * Get set attributes compiled into a string
     * @param array|null $attrs A set of attributes to use in place of our own
     * @return string Attributes
     */
    protected function getEscapedAttributeString($attrs = null)
    {
        $buffer = '';
        foreach ($attrs ?: $this->attributes as $key => $value) {
            $buffer .= $this->escaper->escapeHtmlAttr($key) . '="' . $this->escaper->escapeHtmlAttr($value) .'" ';
        }

        //add a leading space if we have attrs, else no
        return $buffer ? ' ' . (trim($buffer)) : '';
    }

    /**
     * Escape some HTML
     * @param string $value
     * @return string
     */
    protected function escape($value)
    {
        return $this->escaper->escapeHtml($value);
    }

    /**
     * Render an HTML representation of this class
     * @return mixed
     */
    public function render()
    {
        return $this->renderBeforeElement() . $this->renderElement() . $this->renderAfterElement();
    }

    /**
     * Return whether this element is valid
     * @param mixed $data info posted
     * @return mixed
     */
    public abstract function isValid($data);

    /**
     * Populate our form with the given data
     * @param array $data The data to populate with
     * @return mixed
     */
    public abstract function populate($data);

    /**
     * Render some HTML before the element itself
     */
    protected function renderBeforeElement()
    {
        return $this->attrBeforeElement;
    }

    /**
     * Render the element itself
     * @return string
     */
    protected abstract function renderElement();

    /**
     * Render some HTML after the element
     * @return string
     */
    protected function renderAfterElement()
    {
        return $this->attrAfterElement;
    }

    /**
     * Return a string representation of this form
     * this is an alias of render()
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
} 