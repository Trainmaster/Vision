<?php
declare(strict_types=1);

namespace Vision\Http;

class Url
{
    /** @var array $components */
    protected $components = [];

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $components = parse_url($url);

        if (!empty($components)) {
            $this->components = $components;
        }
    }

    /**
     * @param RequestInterface $request
     *
     * @return $this Provides a fluent interface.
     */
    public function populateFromRequest(RequestInterface $request)
    {
        if (!isset($this->components['scheme'])) {
            $this->components['scheme'] = $request->getScheme();
        }

        if (!isset($this->components['host'])) {
            $this->components['host'] = $request->getHost();
        }

        if (!isset($this->components['path'])) {
            $this->components['path'] = $request->getBasePath();
        }

        return $this;
    }

    /**
     * @return bool|string
     */
    public function build()
    {
        $url = '';

        if (isset($this->components['scheme'])) {
            $url .= $this->components['scheme'] . '://';
        } else {
            return false;
        }

        if (isset($this->components['host'])) {
            $url .= $this->components['host'];
        } else {
            return false;
        }

        if (isset($this->components['path'])) {
            $path = $this->components['path'];
            if (strpos($path, '/') !== 0) {
                $path = '/' . $path;
            }
            $url .= $path;
        }

        if (isset($this->components['host'], $this->components['query'])) {
            $url .= '?' . $this->components['query'];
        }

        if (isset($this->components['host'], $this->components['fragment'])) {
            $url .= '#' . $this->components['fragment'];
        }

        return $url;
    }
}
