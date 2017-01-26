<?php
namespace Vision\Authentication;

interface ResultInterface
{
    /**
     * @return bool
     */
    public function isSuccess();

    /**
     * @return mixed
     */
    public function getIdentity();
}
