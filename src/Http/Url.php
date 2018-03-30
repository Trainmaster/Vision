<?php
declare(strict_types = 1);

namespace Vision\Http;

class Url
{
    /** @var string */
    private $scheme;

    /** @var string */
    private $host;

    /** @var string */
    private $port;

    /** @var string */
    private $user;

    /** @var string */
    private $pass;

    /** @var string */
    private $path;

    /** @var string */
    private $query;

    /** @var string */
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
     * @param RequestInterface $request
     *
     * @return $this Provides a fluent interface.
     */
    public function populateFromRequest(RequestInterface $request)
    {
        if (!isset($this->scheme)) {
            $this->scheme = $request->getScheme();
        }

        if (!isset($this->host)) {
            $this->host = $request->getHost();
        }

        if (!isset($this->path)) {
            $this->path = $request->getBasePath();
        }

        return $this;
    }

    /**
     * @return bool|string
     */
    public function build()
    {
        $url = '';

        if (isset($this->scheme)) {
            $url .= $this->scheme . '://';
        } else {
            return false;
        }

        if (isset($this->host)) {
            $url .= $this->host;
        } else {
            return false;
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
}
