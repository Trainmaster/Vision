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
        $this->filterChain = new FilterChain;
    }

    public function testAddShouldProvideFluentInterface()
    {
        $this->assertSame($this->filterChain, $this->filterChain->add($this->getFilterMock()));
    }

    public function testFilterShouldCallAddedFilter()
    {
        $filterMock = $this->getFilterMock();
        $filterMock->expects($this->once())
            ->method('filter');

        $this->filterChain->add($filterMock);
        $this->filterChain->filter('foo');
    }

    private function getFilterMock()
    {
        return $this->createMock(Filter::class);
    }
}
