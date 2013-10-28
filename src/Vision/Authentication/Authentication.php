<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Authentication;

/**
 * Authentication
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Authentication
{
    /** @type null|Strategy\StrategyInterface $strategy */
    protected $strategy = null;
    
    /**
     * Constructor
     * 
     * @param FrontController $frontController 
     */
    public function __construct(Strategy\StrategyInterface $strategy, Storage\StorageInterface $storage)
    {
        $this->strategy = $strategy;
        $this->storage = $storage;
    }
    
    /**
     * @api
     * 
     * @param array $data 
     * 
     * @return bool
     */
    public function authenticate(array $data)
    {
        $authentication = $this->strategy->authenticate($data);
        
        if ($authentication) {
            $this->storage->save($this->strategy->getIdentity());
            return true;
        }
        
        return false;
    }
    
    /**
     * @api
     * 
     * @return array
     */
    public function getIdentity()
    {
        return $this->storage->load();
    }
    
    /**
     * @api
     * 
     * @return bool
     */
    public function clearIdentity()
    {
        return $this->storage->clear();
    }
}