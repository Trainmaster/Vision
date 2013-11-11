<?php
require_once 'TestClasses.php';

use Vision\DependencyInjection\Container;
use Vision\DependencyInjection\Definition;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterWithOneArgument()
    {
        $container = new Container;

        $this->assertInstanceOf('\Vision\DependencyInjection\Definition', $container->register('BasicClass'));
    }

    public function testRegisterWithTwoArguments()
    {
        $container = new Container;

        $this->assertInstanceOf('\Vision\DependencyInjection\Definition', $container->register('BasicClass', 'Alias'));
    }

    public function testRegisterWithOneArgumentWhenClassIsAlreadyDefined()
    {
        $this->setExpectedException('LogicException');

        $container = new Container;
        $container->register('BasicClass');
        $container->register('BasicClass');
    }

    public function testRegisterWithTwoArgumentsWhenClassIsAlreadyDefined()
    {
        $this->setExpectedException('LogicException');

        $container = new Container;
        $container->register('BasicClass', 'Alias');
        $container->register('BasicClass', 'Alias');
    }

    public function testIsDefined()
    {
        $container = new Container;

        $this->assertFalse($container->isDefined('BasicClass'));
        $this->assertFalse($container->isDefined('Alias'));

        $container->register('BasicClass');
        $container->register('BasicClass', 'Alias');

        $this->assertTrue($container->isDefined('BasicClass'));
        $this->assertTrue($container->isDefined('Alias'));
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

    public function testGetWhenArgumentIsNoString()
    {
        $this->setExpectedException('InvalidArgumentException');

        $container = new Container;
        $container->get(1);
    }

    public function testGetWhenIsNotDefined()
    {
        $this->setExpectedException('RuntimeException');

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

    public function testDependentClass()
    {
        $container = new Container;
        $container->register('BasicClass');
        $container->register('DependentClass')->constructor(array('@BasicClass'));

        $instance = $container->get('DependentClass');

        $this->assertInstanceOf('DependentClass', $instance);
        $this->assertInstanceOf('BasicClass', $instance->getBasicClass());
    }

    public function testSetAndGetParameter()
    {
        $container = new Container;

        $this->assertSame($container, $container->setParameter('foo', 'bar'));
        $this->assertSame('bar', $container->getParameter('foo'));
    }

    public function testSetParameterWhenKeyIsNoString()
    {
        $this->setExpectedException('InvalidArgumentException');

        $container = new Container;

        $this->assertSame($container, $container->setParameter(1, 'bar'));
    }

    public function testSetAndGetParameters()
    {
        $params = array('foo' => 'bar');

        $container = new Container;
        $container->setParameters($params);

        $this->assertSame($params, $container->getParameters());
    }
}