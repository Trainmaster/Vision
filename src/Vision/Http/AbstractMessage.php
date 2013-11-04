<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Http;

use InvalidArgumentException;

/**
 * AbstractMessage
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractMessage
{
    /** @type string VERSION_10 */
    const VERSION_10 = '1.0';

    /** @type string VERSION_11 */
    const VERSION_11 = '1.1';

    /** @type string $version */
    protected $version = self::VERSION_11;

    /**
     * @api
     *
     * @param string $version
     *
     * @throws InvalidArgumentException
     *
     * @return AbstractMessage Provides a fluent interface.
     */
    public function setVersion($version)
    {
        if ($version !== self::VERSION_10 || $version !== self::VERSION_11) {
            throw new InvalidArgumentException(sprintf(
                'Not valid or not supported HTTP version: %s.',
                $version
            ));
        }

        $this->version = $version;

        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }
}
