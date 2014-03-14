<?php
use tomverran\Form\Field\Select;

/**
 * InputTest.php
 * @author Tom
 * @since 14/03/14
 */
class SelectTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test we can basically render this
     */
    public function testBasicRender()
    {
        $select = new Select();
        $this->assertEquals('<select></select>', $select->render());
    }

    /**
     * Can we set options etc
     */
    public function testOptions()
    {
        $select = new Select(['options' => ['option 1', 'option 2']]);
        $this->assertEquals('<select><option value="0">option 1</option><option value="1">option 2</option></select>', $select->render());
    }

    /**
     * Test population works
     */
    public function testPopulate()
    {
        $select = new Select(['name' => 'field', 'options' => ['option 1', 'option 2']]);
        $select->populate(['field' => 1]);

        $this->assertContains('<option value="1" selected="selected">option 2</option>', $select->render());
    }

    /**
     * Make sure that by default our select dislikes values not in its options
     */
    public function testDefaultValidator()
    {
        $select = new Select(['name' => 'field', 'options' => ['option 1', 'option 2']]);
        $this->assertFalse($select->isValid(['field' => 3]));
        $this->assertTrue($select->isValid(['field' => 1]));
    }
} 