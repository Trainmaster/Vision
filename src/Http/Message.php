<?php
namespace Vision\Http;

use InvalidArgumentException;

abstract class Message
{
    /** @var string VERSION_10 */
    const PROTOCOL_VERSION_10 = '1.0';

    /** @var string VERSION_11 */
    const PROTOCOL_VERSION_11 = '1.1';

    /** @var string */
    const PROTOCOL_VERSION_2 = '2';

    /** @var string $protocolVersion */
    protected $protocolVersion = self::PROTOCOL_VERSION_11;

    /**
     * @param string $protocolVersion
     *
     * @throws InvalidArgumentException
     *
     * @return Message Provides a fluent interface.
     */
    public function setProtocolVersion($protocolVersion)
    {
        $protocolVersions = [self::PROTOCOL_VERSION_10, self::PROTOCOL_VERSION_11, self::PROTOCOL_VERSION_2];
        if (in_array($protocolVersion, $protocolVersions)) {
            throw new InvalidArgumentException(sprintf(
                'Not valid or not supported HTTP protocol version: %s.',
                $protocolVersion
            ));
        }

        $this->protocolVersion = $protocolVersion;

        return $this;
    }

    /**
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }
}
