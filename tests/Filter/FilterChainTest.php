<?php
namespace VisionTest\Filter;

use Vision\Filter\Filter;
use Vision\Filter\FilterChain;

use PHPUnit\Framework\TestCase;

class FilterChainTest extends TestCase
{
    /** @var FilterChain */
    protected $filterChain;

    protected function setUp()
    {
        $this->filterChain = new FilterChain();
    }

    public function testAddShouldProvideFluentInterface()
    {
        $this->assertSame($this->filterChain, $this->filterChain->add($this->createMock(Filter::class)));
    }

    public function testFilterShouldCallAddedFilter()
    {
        $value = 'foo';

        $filterMock = $this->createMock(Filter::class);
        $filterMock->expects($this->once())
            ->method('filter')
            ->with($value)
            ->willReturn($value);

        $this->filterChain->add($filterMock);

        $this->assertSame($value, $this->filterChain->filter($value));
    }

    public function testFilterShouldPassFilteredValue()
    {
        $value = 'foo';
        $valueAfterFirstFilter = 'fo';
        $valueAfterSecondFilter = 'f';

        $filterMockA = $this->createMock(Filter::class);
        $filterMockA->expects($this->once())
            ->method('filter')
            ->with($value)
            ->willReturn($valueAfterFirstFilter);

        $filterMockB = $this->createMock(Filter::class);
        $filterMockB->expects($this->once())
            ->method('filter')
            ->with($valueAfterFirstFilter)
            ->willReturn($valueAfterSecondFilter);

        $this->filterChain->add($filterMockA);
        $this->filterChain->add($filterMockB);

        $this->assertSame($valueAfterSecondFilter, $this->filterChain->filter($value));
    }
}
