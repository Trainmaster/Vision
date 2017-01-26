<?php
namespace Vision\Http;

interface RequestInterface
{
    public function getHost();

    public function getMethod();

    public function getUrl();

    public function getBaseUrl();

    public function getQueryString();

    public function getBasePath();

    public function getPath();

    public function getPathInfo();

    public function getScheme();
}
