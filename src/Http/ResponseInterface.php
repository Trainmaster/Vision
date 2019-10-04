<?php

declare(strict_types=1);

namespace Vision\Http;

interface ResponseInterface
{
    public function setStatusCode(int $statusCode): ResponseInterface;

    public function addHeader(string $name, string $value): ResponseInterface;

    public function body(string $body): ResponseInterface;

    public function addCookie(
        string $name,
        string $value = '',
        int $expire = 0,
        string $path = '',
        string $domain = '',
        bool $secure = false,
        bool $httponly = false
    ): ResponseInterface;

    public function addRawCookie(
        string $name,
        string $value = '',
        int $expire = 0,
        string $path = '',
        string $domain = '',
        bool $secure = false,
        bool $httponly = false
    ): ResponseInterface;

    public function send();
}
