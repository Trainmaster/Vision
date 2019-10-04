<?php
declare(strict_types=1);

namespace Vision\Http;

use Vision\DataStructures\Arrays\Mutator\SquareBracketNotation;
use Vision\Url\Url;

interface RequestInterface
{
    public function getUrl(): Url;

    public function getQueryParams(): SquareBracketNotation;

    public function getBodyParams(): SquareBracketNotation;

    public function getServerParams(): SquareBracketNotation;

    public function getFiles(): SquareBracketNotation;

    public function getCookies(): SquareBracketNotation;

    public function getMethod(): string;

    public function getBaseUrl(): string;

    public function getBasePath(): string;

    public function getPathInfo(): string;
}
