<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\File\Loader;

/**
 * ScopeFileLoader
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class ScopeFileLoader extends AbstractFileLoader
{
    /** @type null|string */
    protected $scope = null;

    /** @type null|string */
    protected $scopeName = null;

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
