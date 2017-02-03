<?php
namespace VisionTest\DependencyInjection;

require_once 'TestClasses.php';

use Vision\DependencyInjection\Container;

class ContainerTest extends \PHPUnit\Framework\TestCase
{
    public function testRegisterWithOneArgument()
    {
        $container = new Container;

        $this->assertInstanceOf('\Vision\DependencyInjection\Definition', $container->register('BasicClass'));
    }

    public function testRegisterWhenArgumentOneIsNoString()
    {
        $this->expectException('InvalidArgumentException');
        $container = new Container;

        $this->assertInstanceOf('\Vision\DependencyInjection\Definition', $container->register(new \BasicClass));
    }

    public function testRegisterWhenArgumentTwoIsNoString()
    {
        $this->expectException('InvalidArgumentException');
        $container = new Container;

        $this->assertInstanceOf('\Vision\DependencyInjection\Definition', $container->register('BasicClass', new \BasicClass));
    }

    public function testRegisterWithTwoArguments()
    {
        $container = new Container;

        $this->assertInstanceOf('\Vision\DependencyInjection\Definition', $container->register('BasicClass', 'Alias'));
    }

    public function testRegisterWithOneArgumentWhenClassIsAlreadyDefined()
    {
        $this->expectException('LogicException');

        $container = new Container;
        $container->register('BasicClass');
        $container->register('BasicClass');
    }

    public function testRegisterWithTwoArgumentsWhenClassIsAlreadyDefined()
    {
        $this->expectException('LogicException');

        $container = new Container;
        $container->register('BasicClass', 'Alias');
        $container->register('BasicClass', 'Alias');
    }

    public function testRegisterWithReservedAlias()
    {
        $this->expectException('LogicException');

        $container = new Container;
        $container->register('BasicClass', 'self');
    }

    public function testGetDefinition()
    {
        $container = new Container;

        $this->assertSame(null, $container->getDefinition('BasicClass'));

        $container->register('BasicClass');

        $this->assertInstanceOf('\Vision\DependencyInjection\Definition', $container->getDefinition('BasicClass'));
    }

    public function testGetDefinitions()
    {
        $container = new Container;

        $container->register('BasicClass');
        $container->register('BasicClass', 'Alias');

        $this->assertContainsOnlyInstancesOf('\Vision\DependencyInjection\Definition', $container->getDefinitions());
    }

    public function testGet()
    {
        $container = new Container;
        $container->register('BasicClass');

        $this->assertInstanceOf('BasicClass', $container->get('BasicClass'));
    }

    /*
    public function testGetWhenNotRegisteredWithRequiredParameterCountForConstructor()
    {
        $this->expectException('RuntimeException');

        $container = new Container;
        $container->register('DependentClass');

        $container->get('DependentClass');
    }
    */

    public function testGetWhenArgumentIsNoString()
    {
        $this->expectException('InvalidArgumentException');

        $container = new Container;
        $container->get(1);
    }

    public function testGetWhenIsNotDefined()
    {
        $this->expectException('RuntimeException');

        $container = new Container;
        $container->get('BasicClass');
    }

    public function testGetShared()
    {
        $container = new Container;
        $container->register('BasicClass')->setShared(true);

        $instanceOne = $container->get('BasicClass');
        $instanceTwo = $container->get('BasicClass');

        $this->assertSame($instanceOne, $instanceTwo);
    }

    public function testGetNonShared()
    {
        $container = new Container;
        $container->register('BasicClass')->setShared(false);

        $instanceOne = $container->get('BasicClass');
        $instanceTwo = $container->get('BasicClass');

        $this->assertNotSame($instanceOne, $instanceTwo);
    }

    public function testGetSelf()
    {
        $container = new Container;

        $self = $container->get('self');

        $this->assertSame($container, $self);
    }

    public function testGetViaFactory()
    {
        $container = new Container;
        $container->register('VisionTest\DependencyInjection\Fixtures\FooFactory', 'FooFactory');
        $container->register('VisionTest\DependencyInjection\Fixtures\Foo', 'Foo')
            ->factory('@FooFactory', 'getInstance');

        $this->assertInstanceOf('VisionTest\DependencyInjection\Fixtures\Foo', $container->get('Foo'));
    }

    public function testGetWithParametersViaFactory()
    {
        $param1 = 'foo';

        $container = new Container;
        $container->register('VisionTest\DependencyInjection\Fixtures\FooFactory', 'FooFactory');
        $container->register('VisionTest\DependencyInjection\Fixtures\Foo', 'Foo')
            ->factory('@FooFactory', 'getInstanceWithParameters', [$param1]);

        $foo = $container->get('Foo');

        $this->assertSame($param1, $foo->param1);
        $this->assertInstanceOf('VisionTest\DependencyInjection\Fixtures\Foo', $foo);
    }

    public function testGetWithParametersViaFactoryStatic()
    {
        $param1 = 'foo';

        $container = new Container;
        $container->register('VisionTest\DependencyInjection\Fixtures\Foo', 'Foo')
            ->factory('VisionTest\DependencyInjection\Fixtures\FooFactory', 'createViaStaticMethod', [$param1]);

        $foo = $container->get('Foo');

        $this->assertSame($param1, $foo->param1);
        $this->assertInstanceOf('VisionTest\DependencyInjection\Fixtures\Foo', $foo);
    }

    public function testDependentClass()
    {
        $container = new Container;
        $container->register('BasicClass');
        $container->register('DependentClass')->constructor(['@BasicClass']);

        $instance = $container->get('DependentClass');

        $this->assertInstanceOf('DependentClass', $instance);
        $this->assertInstanceOf('BasicClass', $instance->getBasicClass());
    }

    public function testSetAndGetParameter()
    {
        $container = new Container;

        $this->assertNull($container->getParameter('foo'));
        $this->assertSame($container, $container->setParameter('foo', 'bar'));
        $this->assertSame('bar', $container->getParameter('foo'));
    }

    public function testSetParameterWhenKeyIsNoString()
    {
        $this->expectException('InvalidArgumentException');

        $container = new Container;

        $this->assertSame($container, $container->setParameter(1, 'bar'));
    }

    public function testSetAndGetParameters()
    {
        $params = ['foo' => 'bar'];

        $container = new Container;
        $container->setParameters($params);

        $this->assertSame($params, $container->getParameters());
    }
}
