<?php
namespace VisionTest\DataStructures\Tree;

use Vision\DataStructures\Tree\Node;
use Vision\DataStructures\Tree\NodeInterface;

use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase {

    public function testParent() {
        $nodeA = new Node();
        $this->assertNull($nodeA->getParent());

        $nodeB = (new Node())->setParent($nodeA);
        $this->assertSame($nodeA, $nodeB->getParent());
    }

    public function testAddChild() {
        $nodeA = new Node();
        $nodeB = (new Node())->addChild($nodeA);

        $this->assertSame($nodeB->getChildren(), [$nodeA]);
    }

    public function testdAddChildShouldSetParent() {
        $nodeA = new Node();
        $nodeB = (new Node())->addChild($nodeA);

        $this->assertSame($nodeA->getParent(), $nodeB);
    }

    public function testGetChildren() {
        $node = new Node();
        $this->assertSame($node->getChildren(), []);

        $node->addChild(new Node());
        $this->assertContainsOnlyInstancesOf(NodeInterface::class, $node->getChildren());
        $this->assertCount(1, $node->getChildren());
    }

    public function testRemoveChild() {
        $nodeA = new Node();
        $nodeB = (new Node())->addChild($nodeA);
        $nodeB->removeChild($nodeA);

        $this->assertEmpty($nodeB->getChildren());
    }

    public function testHasChildren() {
        $node = new Node();
        $this->assertSame($node->hasChildren(), false);

        $node->addChild(new Node());
        $this->assertSame($node->hasChildren(), true);
    }
}
