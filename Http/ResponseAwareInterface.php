<?php
namespace Vision\Http;

/**
 * ResponseAwareInterface
 *
 * @author Frank Liepert
 */
interface ResponseAwareInterface
{
    public function setResponse(ResponseInterface $response);
}