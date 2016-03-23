<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Authentication;

use UnexpectedValueException;

class Authentication
{
    /** @var null|Strategy\StrategyInterface $strategy */
    protected $strategy;

    /** @var null|Storage\StorageInterface $storage */
    protected $storage;

    /**
     * @param Strategy\StrategyInterface $strategy
     * @param Storage\StorageInterface $storage
     */
    public function __construct(Strategy\StrategyInterface $strategy, Storage\StorageInterface $storage)
    {
        $this->strategy = $strategy;
        $this->storage = $storage;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function authenticate(array $data)
    {
        $this->clearIdentity();

        $result = $this->strategy->authenticate($data);

        if (!$result instanceof ResultInterface) {
            throw new UnexpectedValueException(sprintf(
                'The method "%s::authenticate" must return an instance of "%s".',
                get_class($this->strategy),
                ResultInterface::class
            ));
        }

        if ($result->isSuccess()) {
            $this->storage->save($result->getIdentity());
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->storage->exists();
    }

    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->storage->load();
    }

    /**
     * @return void
     */
    public function clearIdentity()
    {
        $this->strategy->invalidate($this->getIdentity());
        $this->storage->clear();
    }
}
