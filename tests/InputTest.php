<?php
use tomverran\Form\Field\Text;

/**
 * InputTest.php
 * @author Tom
 * @since 14/03/14
 */
class InputTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test we can basically render this
     */
    public function testBasicRender()
    {
        $text = new Text();
        $this->assertEquals('<input type="text"/>', $text->render());
    }

    /**
     * Test population works
     */
    public function testPopulate()
    {
        $text = new Text(['name' => 'field']);
        $text->populate(['field' => 'er']);

        $this->assertContains('value="er"', $text->render());
    }

    public function testLabel()
    {
        $text = new Text(['name' => 'field', 'label' => 'Printer']);
        $this->assertContains('<label for="field">Printer</label>', $text->render());
    }
} 