<?php
use tomverran\Form\Container\Form;

/**
 * FormTest.php
 * @author Tom
 * @since 14/03/14
 */
class FormTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test we can output a basic empty form
     */
    public function testBasicOutput()
    {
        $form = new Form();
        $output = $form->render();
        $this->assertEquals('<form action="" method="post"></form>', $output);
    }

    /**
     * Test that we can set attributes on our form
     * and they get correctly output
     */
    public function testSettingAttributes()
    {
        $form = new Form();
        $form->setAttribute('id', 'on_days_like_these');
        $this->assertContains('id="on_days_like_these"', $form->render());
    }

    /**
     * Test we can add a child to our form
     * and it gets rendered. Nested forms are probably a bad idea
     * but it means we don't need to bring in any other elements yet
     */
    public function testAddChild()
    {
        $form = new Form();
        $form->setAttribute('id', 'outer');

        $formInner = new Form();
        $formInner->setAttribute('id', 'inner');

        $form->add($formInner);
        $this->assertEquals('<form action="" method="post" id="outer"><form action="" method="post" id="inner"></form></form>', $form->render());
    }
} 