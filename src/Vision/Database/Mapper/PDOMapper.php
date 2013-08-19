<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Database\Mapper;

use PDO;
use PDOException;

/**
 * PDOMapper
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class PDOMapper
{
    /** @type null|PDO */
    protected $pdo = null;
           
    /**
     * @param PDO $pdo 
     * 
     * @return void
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    /**
     * @return PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }
}