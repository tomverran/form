<?php
use tomverran\Form\Container;
use tomverran\Form\Container\Fieldset;
use tomverran\Form\Container\Form;

/**
 * OptionsTest.php
 * @author Tom
 * @since 14/03/14
 */

class OptionsTest extends PHPUnit_Framework_TestCase
{
    public function testSettingDefaultOptions()
    {
        Container::setDefaultOptions(['id' => 'containerId', 'data-foo' => 'bar']);
        Fieldset::setDefaultOptions(['id' => 'fieldsetId']);

        $form = new Form();
        $this->assertEquals('containerId', $form->getAttribute('id'));
        $this->assertEquals('bar', $form->getAttribute('data-foo'));

        $fieldset = new Fieldset();
        $this->assertEquals('fieldsetId', $fieldset->getAttribute('id'));
        $this->assertEquals('bar', $fieldset->getAttribute('data-foo'));

    }
} 