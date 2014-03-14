<?php
use tomverran\Form\Container\Fieldset;

/**
 * FieldsetTest.php
 * @author Tom
 * @since 14/03/14
 */
class FieldsetTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test the basic output we should get when rendering a noargs fieldset
     */
    public function testBasicOutput()
    {
        $fieldset = new Fieldset();
        $this->assertEquals('<fieldset></fieldset>', $fieldset->render());
    }

    /**
     * Test whether outputting a legend works
     */
    public function testLegend()
    {
        $fieldset = new Fieldset(['legend' => 'dary']);
        $this->assertEquals('<fieldset><legend>dary</legend></fieldset>', $fieldset->render());
    }
} 