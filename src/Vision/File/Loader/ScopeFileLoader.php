<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\File\Loader;

class ScopeFileLoader extends AbstractFileLoader
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
    public function load($file)
    {
        if ($this->isLoadable($file)) {
            ${$this->scopeName} = $this->scope;
            include $file;
        }
    }
}
