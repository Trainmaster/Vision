<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Authentication\Strategy;

/**
 * StrategyChain
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class StrategyChain implements StrategyInterface
{
    /** @type array $strategies */
    protected $strategies = array();

    /**
     * @api
     *
     * @param StrategyInterface $strategy
     *
     * @return $this Provides a fluent interface.
     */
    public function addStrategy(StrategyInterface $strategy)
    {
        $this->strategies[] = $strategy;
        return $this;
    }

    /**
     * @api
     *
     * @param array $strategies
     *
     * @return $this Provides a fluent interface.
     */
    public function addStrategies(array $strategies)
    {
        foreach ($strategies as $strategy) {
            $this->addStrategy($strategy);
        }
        return $this;
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
        $this->accepted = null;
        foreach ($this->strategies as $strategy) {
            if ($strategy->authenticate($data)) {
                $this->accepted = $strategy;
                return true;
            }
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
        if ($this->accepted instanceof StrategyInterface) {
            return $this->accepted->getIdentity();
        }
        return array();
    }
}
