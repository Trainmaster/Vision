<?php
declare(strict_types = 1);

namespace VisionTest\DependencyInjection;

use Vision\DependencyInjection\AliasAlreadyRegisteredException;
use Vision\DependencyInjection\AliasReservedException;
use Vision\DependencyInjection\Container;
use Vision\DependencyInjection\Definition;
use Vision\DependencyInjection\NotFoundException;
use VisionTest\DependencyInjection\Fixtures\BasicClass;
use VisionTest\DependencyInjection\Fixtures\DependentClass;
use VisionTest\DependencyInjection\Fixtures\Foo;
use VisionTest\DependencyInjection\Fixtures\FooFactory;

use InvalidArgumentException;

use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testRegisterWithClass()
    {
        $this->assertInstanceOf(Definition::class, (new Container())->register(BasicClass::class));
    }

    public function testRegisterWithClassAndAlias()
    {
        $this->assertInstanceOf(Definition::class, (new Container())->register(BasicClass::class, 'alias'));
    }

    public function testRegisterWithClassAndInvalidAlias()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->assertInstanceOf(Definition::class, (new Container())->register(BasicClass::class, new BasicClass()));
    }

    public function testRegisterWhenClassIsAlreadyDefined()
    {
        $this->expectException(AliasAlreadyRegisteredException::class);

        $container = new Container();
        $container->register(BasicClass::class);
        $container->register(BasicClass::class);
    }

    public function testRegisterWhenAliasIsAlreadyDefined()
    {
        $this->expectException(AliasAlreadyRegisteredException::class);

        $container = new Container();
        $container->register(BasicClass::class, 'Alias');
        $container->register(BasicClass::class, 'Alias');
    }

    public function testRegisterWithReservedAlias()
    {
        $this->expectException(AliasReservedException::class);

        $container = new Container();
        $container->register(BasicClass::class, 'self');
    }

    public function testGetDefinition()
    {
        $container = new Container();

        $this->assertSame(null, $container->getDefinition(BasicClass::class));

        $container->register(BasicClass::class);

        $this->assertInstanceOf(Definition::class, $container->getDefinition(BasicClass::class));
    }

    public function testGetDefinitions()
    {
        $container = new Container();

        $container->register(BasicClass::class);
        $container->register(BasicClass::class, 'Alias');

        $this->assertContainsOnlyInstancesOf(Definition::class, $container->getDefinitions());
    }

    public function testGet()
    {
        $container = new Container();
        $container->register(BasicClass::class);

        $this->assertInstanceOf(BasicClass::class, $container->get(BasicClass::class));
    }

    public function testGetWhenAliasIsNotDefined()
    {
        $this->expectException(NotFoundException::class);

        (new Container())->get(BasicClass::class);
    }

    public function testGetShared()
    {
        $container = new Container();
        $container->register(BasicClass::class)->setShared(true);

        $instanceOne = $container->get(BasicClass::class);
        $instanceTwo = $container->get(BasicClass::class);

        $this->assertSame($instanceOne, $instanceTwo);
    }

    public function testGetNonShared()
    {
        $container = new Container();
        $container->register(BasicClass::class)->setShared(false);

        $instanceOne = $container->get(BasicClass::class);
        $instanceTwo = $container->get(BasicClass::class);

        $this->assertNotSame($instanceOne, $instanceTwo);
    }

    public function testGetSelf()
    {
        $container = new Container();

        $self = $container->get('self');

        $this->assertSame($container, $self);
    }

    public function testGetViaFactory()
    {
        $container = new Container();
        $container->register(FooFactory::class, 'FooFactory');
        $container->register(Foo::class, 'Foo')
            ->factory('@FooFactory', 'getInstance');

        $this->assertInstanceOf(Foo::class, $container->get('Foo'));
    }

    public function testGetWithParametersViaFactory()
    {
        $param1 = 'foo';

        $container = new Container();
        $container->register(FooFactory::class, 'FooFactory');
        $container->register(Foo::class, 'Foo')
            ->factory('@FooFactory', 'getInstanceWithParameters', [$param1]);

        $foo = $container->get('Foo');

        $this->assertSame($param1, $foo->param1);
        $this->assertInstanceOf(Foo::class, $foo);
    }

    public function testGetWithParametersViaFactoryStatic()
    {
        $param1 = 'foo';

        $container = new Container();
        $container->register(Foo::class, 'Foo')
            ->factory(FooFactory::class, 'createViaStaticMethod', [$param1]);

        $foo = $container->get('Foo');

        $this->assertSame($param1, $foo->param1);
        $this->assertInstanceOf(Foo::class, $foo);
    }

    public function testDependentClass()
    {
        $container = new Container();
        $container->register(BasicClass::class);
        $container->register(DependentClass::class)->constructor(['@' . BasicClass::class]);

        $instance = $container->get(DependentClass::class);

        $this->assertInstanceOf(DependentClass::class, $instance);
        $this->assertInstanceOf(BasicClass::class, $instance->getBasicClass());
    }

    public function testSetAndGetParameter()
    {
        $container = new Container();

        $this->assertNull($container->getParameter('foo'));
        $this->assertSame($container, $container->setParameter('foo', 'bar'));
        $this->assertSame('bar', $container->getParameter('foo'));
    }

    public function testSetAndGetParameters()
    {
        $params = ['foo' => 'bar'];

        $container = new Container();
        $container->setParameters($params);

        $this->assertSame($params, $container->getParameters());
    }
}
