<?php

/**
 * @see       https://github.com/laminas/laminas-form for the canonical source repository
 * @copyright https://github.com/laminas/laminas-form/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-form/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Form\View\Helper;

use Laminas\Form\Element;
use Laminas\Form\View\Helper\FormEmail as FormEmailHelper;

class FormEmailTest extends CommonTestCase
{
    public function setUp()
    {
        $this->helper = new FormEmailHelper();
        parent::setUp();
    }

    public function testRaisesExceptionWhenNameIsNotPresentInElement()
    {
        $element = new Element();
        $this->expectException('Laminas\Form\Exception\DomainException');
        $this->expectExceptionMessage('name');
        $this->helper->render($element);
    }

    public function testGeneratesEmailInputTagWithElement()
    {
        $element = new Element('foo');
        $markup  = $this->helper->render($element);
        $this->assertContains('<input ', $markup);
        $this->assertContains('type="email"', $markup);
    }

    public function testGeneratesEmailInputTagRegardlessOfElementType()
    {
        $element = new Element('foo');
        $element->setAttribute('type', 'radio');
        $markup  = $this->helper->render($element);
        $this->assertContains('<input ', $markup);
        $this->assertContains('type="email"', $markup);
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
            ['maxlength', 'assertContains'],
            ['min', 'assertNotContains'],
            ['minlength', 'assertContains'],
            ['multiple', 'assertContains'],
            ['pattern', 'assertContains'],
            ['placeholder', 'assertContains'],
            ['readonly', 'assertContains'],
            ['required', 'assertContains'],
            ['size', 'assertContains'],
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
            'minlength'          => 'value',
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
        $this->assertContains('type="email"', $markup);
    }

    public function testInvokeWithNoElementChainsHelper()
    {
        $this->assertSame($this->helper, $this->helper->__invoke());
    }
}
