<?php
declare(strict_types=1);

namespace VisionTest\Url;

use Vision\Url\Url;

use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function testShouldNotRenderPort80IfSchemeIsHttp()
    {
        $expectedUrl = 'http://localhost';

        $url = (new Url())
            ->setScheme('http')
            ->setHost('localhost')
            ->setPort(80);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldNotRenderPort443IfSchemeIsHttps()
    {
        $expectedUrl = 'https://localhost';

        $url = (new Url())
            ->setScheme('https')
            ->setHost('localhost')
            ->setPort(443);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldRenderNonDefaultPort()
    {
        $expectedUrl = 'https://localhost:8080';

        $url = (new Url())
            ->setScheme('https')
            ->setHost('localhost')
            ->setPort(8080);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldRenderUser()
    {
        $expectedUrl = 'https://user@localhost:8080';

        $url = (new Url())
            ->setScheme('https')
            ->setUser('user')
            ->setHost('localhost')
            ->setPort(8080);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldRenderUserButNotEmptyStringPass()
    {
        $expectedUrl = 'https://user@localhost:8080';

        $url = (new Url())
            ->setScheme('https')
            ->setUser('user')
            ->setPass('')
            ->setHost('localhost')
            ->setPort(8080);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldRenderUserAndPass()
    {
        $expectedUrl = 'https://user:pass@localhost:8080';

        $url = (new Url())
            ->setScheme('https')
            ->setUser('user')
            ->setPass('pass')
            ->setHost('localhost')
            ->setPort(8080);

        $this->assertSame($expectedUrl, $url->__toString());
    }

    public function testShouldAllowEmptyPath()
    {
        $expectedUrl = 'https://localhost';

        $url = (new Url())
            ->setScheme('https')
            ->setHost('localhost')
            ->setPath('');

        $this->assertSame($expectedUrl, $url->__toString());
    }
}
