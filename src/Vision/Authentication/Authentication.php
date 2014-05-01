<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
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
    protected $strategy;

    /** @type null|Storage\StorageInterface $storage */
    protected $storage;

    /**
     * Constructor
     *
     * @param Strategy\StrategyInterface $strategy
     * @param Storage\StorageInterface $storage
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
        $this->clearIdentity();

        $result = $this->strategy->authenticate($data);

        if ($result->isSuccess()) {
            $this->storage->save($result->getIdentity());
        }

        return $result;
    }

    /**
     * @api
     *
     * @return void
     */
    public function isAuthenticated()
    {
        return $this->storage->exists();
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
     * @return void
     */
    public function clearIdentity()
    {
        $this->strategy->invalidate($this->getIdentity());
        return $this->storage->clear();
    }
}
