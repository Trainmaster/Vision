<?php

namespace VisionTest\Random;

use Vision\Session\Extension\ExtensionInterface;
use Vision\Session\Session;
use Vision\Session\SessionInterface;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    public function testConstructor()
    {
        $extensionMock = $this->getExtensionMock();
        $extensionMock
            ->expects($this->once())
            ->method('start')
            ->with($this->isInstanceOf(SessionInterface::class));

        (new Session($extensionMock));
    }

    public function testClear()
    {
        $session = new Session($this->getExtensionMock());
        $session['foo'] = 'bar';

        $session->clear();

        $this->assertSame([], $session->getArrayCopy());
    }

    public function testGetStatus()
    {
        $extensionMock = $this->getExtensionMock();
        $extensionMock
            ->expects($this->once())
            ->method('getStatus')
            ->willReturn(PHP_SESSION_ACTIVE);

        $status = (new Session($extensionMock))->getStatus();

        $this->assertSame(PHP_SESSION_ACTIVE, $status);
    }

    public function testGetId()
    {
        $someId = '123abc';

        $extensionMock = $this->getExtensionMock();
        $extensionMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn($someId);

        $id = (new Session($extensionMock))->getId();

        $this->assertSame($someId, $id);
    }

    public function testRegenerateId()
    {
        $deleteOldSession = true;
        $regenerateIdExtension = true;

        $extensionMock = $this->getExtensionMock();
        $extensionMock
            ->expects($this->once())
            ->method('regenerateId')
            ->with($deleteOldSession)
            ->willReturn($regenerateIdExtension);

        $regenerateId = (new Session($extensionMock))->regenerateId($deleteOldSession);

        $this->assertSame($regenerateIdExtension, $regenerateId);
    }

    private function getExtensionMock()
    {
        return $this->createMock(ExtensionInterface::class);
    }
}
