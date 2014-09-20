<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Database;

/**
 * PDO
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class PDO extends \PDO
{
    /** @type bool $hasActiveTransaction */
    protected $hasActiveTransaction = false;

    /**
     * This method returns the current driver name (only if it's supported by the driver)
     *
     * @api
     *
     * @return string
     */
    public function getDriverName()
    {
        return parent::getAttribute(\PDO::ATTR_DRIVER_NAME);
    }

    /**
    * Workaround for WHERE IN() queries
    *
    * @api
    *
    * @param mixed $mixed
    *
    * @return string|array
    */
    public function createQuestionMarks($mixed)
    {
        if (is_array($mixed)) {
            $count = count($mixed) - 1;
            $questionMarks = str_repeat('?,', $count) . '?';
            return $questionMarks;
        }

        return array();
    }

    /**
     * This method returns a UUID ready to be stored as BINARY(16).
     *
     * @todo Support for other drivers.
     *
     * @api
     *
     * @return string
     */
    public function createUuid()
    {
        $name = $this->getDriverName();

        switch ($name) {
            case 'mysql':
                $sth = $this->query('SELECT UNHEX(REPLACE(UUID(), "-", ""))');
                return $sth->fetchColumn();

            default:
                return null;
        }
    }

    /**
     * Another workaround for WHERE IN() queries with array.
     *
     * Example: Passing an array with three elements it will return "IN (?, ?, ?)"
     *
     * @api
     *
     * @param array $data
     *
     * @return string
     */
    public function IN(array $data)
    {
        $string = $this->createQuestionMarks($data);
        $string = 'IN (' . $string . ')';
        return $string;
    }

    public function VALUES($data)
    {
        return $this->createMultipleValuesList($data);
    }

    public function SET(array $data)
    {
        $values = array_keys($data);
        array_walk($values, function(&$value) {
            $value = $value . ' = ?';
        });
        $qs = 'SET ' . implode(', ', $values);
        return $qs;
    }

    /**
     * Useful method for Inserts
     *
     * @api
     *
     * @param mixed $mixed
     *
     * @return string
     */
    public function createMultipleValuesList($mixed)
    {
        if (is_array($mixed)) {
            $list = '';
            $count = count($mixed);
            $firstValue = reset($mixed);
            if (is_array($firstValue)) {
                $list = '(' . $this->createQuestionMarks($firstValue) . ')';
            } elseif (is_string($firstValue) || is_int($firstValue)) {
                $list = '(?)';
            }
            $list = array_fill(0, $count, $list);
            return implode(',', $list);
        }
    }

    /**
     * Support for nested transactions
     *
     * @api
     *
     * @return bool
     */
    public function beginTransaction()
    {
        if ($this->hasActiveTransaction) {
            return false;
        } else {
            $this->hasActiveTransaction = parent::beginTransaction();
            return $this->hasActiveTransaction;
        }
    }

    /**
     * Support for nested transactions
     *
     * @api
     *
     * @return bool
     */
    public function commit()
    {
        $this->hasActiveTransaction = false;
        return parent::commit();
    }

    /**
     * Support for nested transactions
     *
     * @api
     *
     * @return bool
     */
    public function rollback()
    {
        $this->hasActiveTransaction = false;
        return parent::rollback();
    }
}
