<?php
declare(strict_types=1);

namespace Vision\File\Loader;

class ScopeFileLoader implements LoaderInterface
{
    /** @var null|string */
    protected $scope;

    /** @var null|string */
    protected $scopeName;

    /**
     * @param string $file
     *
     * @return void
     */
    public function load($file): void
    {
        if (is_readable($file)) {
            ${$this->scopeName} = $this->scope;
            include $file;
        }
    }
}
