<?php

/**
 * @see       https://github.com/laminas/laminas-form for the canonical source repository
 * @copyright https://github.com/laminas/laminas-form/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-form/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Form\View\Helper;

use Laminas\Form\Element;
use Laminas\Form\View\Helper\FormColor as FormColorHelper;

class FormColorTest extends CommonTestCase
{
    public function setUp()
    {
        $this->helper = new FormColorHelper();
        parent::setUp();
    }

    public function testRaisesExceptionWhenNameIsNotPresentInElement()
    {
        $element = new Element();
        $this->expectException('Laminas\Form\Exception\DomainException');
        $this->expectExceptionMessage('name');
        $this->helper->render($element);
    }

    public function testGeneratesColorInputTagWithElement()
    {
        $element = new Element('foo');
        $markup  = $this->helper->render($element);
        $this->assertContains('<input ', $markup);
        $this->assertContains('type="color"', $markup);
    }

    public function testGeneratesColorInputTagRegardlessOfElementType()
    {
        $element = new Element('foo');
        $element->setAttribute('type', 'email');
        $markup  = $this->helper->render($element);
        $this->assertContains('<input ', $markup);
        $this->assertContains('type="color"', $markup);
    }

    public function validAttributes()
    {
        return [
            ['name', 'assertContains'],
            ['accept', 'assertNotContains'],
            ['alt', 'assertNotContains'],
            ['autocomplete', 'assertContains'],
            ['autofocus', 'assertContains'],
            ['checked', 'assertNotContains'],
            ['dirname', 'assertNotContains'],
            ['disabled', 'assertContains'],
            ['form', 'assertContains'],
            ['formaction', 'assertNotContains'],
            ['formenctype', 'assertNotContains'],
            ['formmethod', 'assertNotContains'],
            ['formnovalidate', 'assertNotContains'],
            ['formtarget', 'assertNotContains'],
            ['height', 'assertNotContains'],
            ['list', 'assertContains'],
            ['max', 'assertNotContains'],
            ['maxlength', 'assertNotContains'],
            ['min', 'assertNotContains'],
            ['multiple', 'assertNotContains'],
            ['pattern', 'assertNotContains'],
            ['placeholder', 'assertNotContains'],
            ['readonly', 'assertNotContains'],
            ['required', 'assertNotContains'],
            ['size', 'assertNotContains'],
            ['src', 'assertNotContains'],
            ['step', 'assertNotContains'],
            ['value', 'assertContains'],
            ['width', 'assertNotContains'],
        ];
    }

    public function getCompleteElement()
    {
        $element = new Element('foo');
        $element->setAttributes([
            'accept'             => 'value',
            'alt'                => 'value',
            'autocomplete'       => 'on',
            'autofocus'          => 'autofocus',
            'checked'            => 'checked',
            'dirname'            => 'value',
            'disabled'           => 'disabled',
            'form'               => 'value',
            'formaction'         => 'value',
            'formenctype'        => 'value',
            'formmethod'         => 'value',
            'formnovalidate'     => 'value',
            'formtarget'         => 'value',
            'height'             => 'value',
            'id'                 => 'value',
            'list'               => 'value',
            'max'                => 'value',
            'maxlength'          => 'value',
            'min'                => 'value',
            'multiple'           => 'multiple',
            'name'               => 'value',
            'pattern'            => 'value',
            'placeholder'        => 'value',
            'readonly'           => 'readonly',
            'required'           => 'required',
            'size'               => 'value',
            'src'                => 'value',
            'step'               => 'value',
            'width'              => 'value',
        ]);
        $element->setValue('value');
        return $element;
    }

    /**
     * @dataProvider validAttributes
     */
    public function testAllValidFormMarkupAttributesPresentInElementAreRendered($attribute, $assertion)
    {
        $element = $this->getCompleteElement();
        $markup  = $this->helper->render($element);
        switch ($attribute) {
            case 'value':
                $expect  = sprintf('%s="%s"', $attribute, $element->getValue());
                break;
            default:
                $expect  = sprintf('%s="%s"', $attribute, $element->getAttribute($attribute));
                break;
        }
        $this->$assertion($expect, $markup);
    }

    public function testInvokeProxiesToRender()
    {
        $element = new Element('foo');
        $markup  = $this->helper->__invoke($element);
        $this->assertContains('<input', $markup);
        $this->assertContains('name="foo"', $markup);
        $this->assertContains('type="color"', $markup);
    }

    public function testInvokeWithNoElementChainsHelper()
    {
        $this->assertSame($this->helper, $this->helper->__invoke());
    }
}
