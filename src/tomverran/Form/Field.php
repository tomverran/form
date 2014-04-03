<?php
/**
 * Field.php
 * @author Tom
 * @since 13/03/14
 */

namespace tomverran\Form;

/**
 * Class Field - This is an element that does not contain other elements,
 * but is a discrete form control with validators, etc
 * @package tomverran\Form
 */
abstract class Field extends Element
{
    /**
     * Validators we have set
     * @var \Zend\Validator\AbstractValidator[]
     */
    protected $attrValidators = [];

    /**
     * The label for this field
     * @var string
     */
    protected $attrLabel = '';

    /**
     * An array of errors, generated either from Zend\Validators
     * or set manually or by some external force.
     * @var array
     */
    private $attrErrors = [];

    /**
     * Construct this field
     * @param array $options - Options for the element
     * @param array $validators - Validators for the field
     */
    public function __construct($options = [], $validators = [])
    {
        //set the id to the name of the field if none is given
        if (isset($options['name']) && !isset($options['id'])) {
            $options['id'] = $options['name'];
        }

        if (array_key_exists('validators', $options)) {
            if (!is_array($options['validators'])) {
                $options['validators'] = [$options['validators']];
            }
            $validators = array_merge($validators, $options['validators']);
        }

        parent::__construct(array_replace($options, ['validators' => $validators]));
    }

    /**
     * Add a validator to this field
     * @param $validator
     */
    public function addValidator($validator)
    {
        $this->attrValidators[] = $validator;
    }

    /**
     * Does this field consider the given data valid?
     * @param array $data An array of data to evaluate
     * @return bool|mixed
     */
    public function isValid($data)
    {
        foreach ($this->attrValidators as $validator) {
            if (!$validator->isValid($data[$this->getAttribute('name')])) {

                $messages = $validator->getMessages();
                foreach ( $messages as &$message ) {
                    $message = $this->attrLabel ? $this->attrLabel . ':' . $message : $message;
                }

                $this->attrErrors = array_merge($this->attrErrors, $messages);
                return false;
            }
        }
        return true;
    }

    /**
     * Get errors ocurring during validation
     * @return array
     */
    public function getErrors()
    {
        return $this->attrErrors;
    }

    /**
     * Populate this Field
     * @param array $data
     * @return void
     */
    public function populate($data)
    {
        if ( isset( $data[$this->getAttribute('name')])) {
            $this->setAttribute('value', $data[$this->getAttribute('name')]);
        }
    }

    /**
     * Render something before an element
     * this is where label rendering happens
     * @return string
     */
    public function renderBeforeElement()
    {
        $labelAttrs = ['for' => $this->getAttribute('id')];
        $label = $this->attrLabel ? '<label' . $this->getEscapedAttributeString($labelAttrs) . '>' . $this->escape($this->attrLabel) . '</label>' : '';
        return parent::renderBeforeElement() . $label;
    }
} 