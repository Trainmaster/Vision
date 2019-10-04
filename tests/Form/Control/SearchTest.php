<?php

namespace VisionTest\Form\Control;

use Vision\Form\Control\Search;
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    /** @var Search */
    private $control;

    public function setUp()
    {
        $this->control = new Search('search');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\AbstractInput', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('search', $control->getAttribute('type'));
    }
}
