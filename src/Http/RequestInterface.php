<?php
declare(strict_types = 1);

namespace Vision\Http;

use Vision\DataStructures\Arrays\Mutator\SquareBracketNotation;

interface RequestInterface
{
    public function getUrl(): Url;

    public function getQueryParams(): SquareBracketNotation;

    public function getBodyParams(): SquareBracketNotation;

    public function getServerParams(): SquareBracketNotation;

    public function getFiles(): SquareBracketNotation;

    public function getCookies(): SquareBracketNotation;

    public function getMethod();

    public function getBaseUrl();

    public function getBasePath();

    public function getPathInfo();
}
