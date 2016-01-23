<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Http;

use InvalidArgumentException;

abstract class Message
{
    /** @var string VERSION_10 */
    const VERSION_10 = '1.0';

    /** @var string VERSION_11 */
    const VERSION_11 = '1.1';

    /** @var string */
    const VERSION_2 = '2';

    /** @var string $version */
    protected $version = self::VERSION_11;

    /**
     * @param string $version
     *
     * @throws InvalidArgumentException
     *
     * @return Message Provides a fluent interface.
     */
    public function setVersion($version)
    {
        if (in_array($version, [self::VERSION_10, self::VERSION_11, self::VERSION_2])) {
            throw new InvalidArgumentException(sprintf(
                'Not valid or not supported HTTP version: %s.',
                $version
            ));
        }

        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }
}
