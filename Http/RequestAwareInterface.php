<?php
namespace Vision\Http;

/**
 * RequestAwareInterface
 *
 * @author Frank Liepert
 */
interface RequestAwareInterface
{
    public function setRequest(RequestInterface $request);
}