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
     * Construct this field
     * @param array $options - Options for the element
     * @param array $validators - Validators for the field
     */
    public function __construct($options = [], $validators = [])
    {
        parent::__construct( array_replace($options, ['validators' => $validators]));
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
                return false;
            }
        }
        return true;
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
} 