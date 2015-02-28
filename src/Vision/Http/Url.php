<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Http;

/**
 * Url
 *
 * @author Frank Liepert
 */
class Url
{
    /** @var array $components */
    protected $components = array();

    /**
     * Constructor
     *
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
     * @api
     *
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
     * @api
     *
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
