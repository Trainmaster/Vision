<?php
declare(strict_types = 1);

namespace Vision\Http;

use Vision\Http\RequestInterface;

class Url
{
    /** @var string */
    private $scheme;

    /** @var string */
    private $host;

    /** @var int|null */
    private $port;

    /** @var string|null */
    private $user;

    /** @var string|null */
    private $pass;

    /** @var string */
    private $path;

    /** @var string|null */
    private $query;

    /** @var string|null */
    private $fragment;

    /**
     * @param string $url
     */
    public function __construct($url = '')
    {
        if (!empty($url)) {
            $this->parseUrl($url);
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $url = '';

        if (isset($this->scheme)) {
            $url .= $this->scheme . '://';
        } else {
            return '';
        }

        if (isset($this->host)) {
            $url = $this->appendUserAndPass($url);
            $url .= $this->host;
        } else {
            return '';
        }

        if (isset($this->port) && $this->isNoDefaultPort()) {
            $url .= ":{$this->port}";
        }

        if (isset($this->path)) {
            $path = $this->path;
            if (strpos($path, '/') !== 0) {
                $path = '/' . $path;
            }
            $url .= $path;
        }

        if (isset($this->query)) {
            $url .= '?' . $this->query;
        }

        if (isset($this->fragment)) {
            $url .= '#' . $this->fragment;
        }

        return $url;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     * @return Url
     */
    public function setScheme(string $scheme): Url
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return Url
     */
    public function setHost(string $host): Url
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * @param int|null $port
     * @return Url
     */
    public function setPort(?int $port): Url
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * @param null|string $user
     * @return Url
     */
    public function setUser(?string $user): Url
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPass(): ?string
    {
        return $this->pass;
    }

    /**
     * @param null|string $pass
     * @return Url
     */
    public function setPass(?string $pass): Url
    {
        $this->pass = $pass;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Url
     */
    public function setPath(string $path): Url
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * @param null|string $query
     * @return Url
     */
    public function setQuery(?string $query): Url
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFragment(): ?string
    {
        return $this->fragment;
    }

    /**
     * @param null|string $fragment
     * @return Url
     */
    public function setFragment(?string $fragment): Url
    {
        $this->fragment = $fragment;
        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return Url
     */
    public function populateFromRequest(RequestInterface $request): self
    {
        if (!isset($this->scheme)) {
            $this->scheme = $request->getUrl()->getScheme();
        }

        if (!isset($this->host)) {
            $this->host = $request->getUrl()->getHost();
        }

        if (!isset($this->path)) {
            $this->path = $request->getBasePath();
        }

        return $this;
    }

    /**
     * @param string $url
     * @return void
     */
    private function parseUrl(string $url): void
    {
        $components = parse_url($url);

        if ($components === false) {
            return;
        }

        $this->scheme = $components['scheme'] ?? '';
        $this->host = $components['host'] ?? '';
        $this->port = $components['port'] ?? null;
        $this->user = $components['user'] ?? null;
        $this->pass = $components['pass'] ?? null;
        $this->path = $components['path'] ?? '';
        $this->query = $components['query'] ?? null;
        $this->fragment = $components['fragment'] ?? null;
    }

    /**
     * @param string $url
     * @return string
     */
    private function appendUserAndPass(string $url): string
    {
        if (!isset($this->user)) {
            return $url;
        }

        $url .= $this->user;

        if (isset($this->pass) && $this->pass !== '') {
            $url .= ':' . $this->pass;
        }

        return $url . '@';
    }

    /**
     * @return bool
     */
    private function isNoDefaultPort(): bool
    {
        $defaultPorts = [
            'http' => 80,
            'https' => 443,
        ];
        $expectedDefaultPort = $defaultPorts[$this->scheme] ?? null;
        return $this->port !== $expectedDefaultPort;
    }
}
