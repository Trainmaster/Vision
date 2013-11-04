<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DataStructures\EntityManager;

use Vision\DataStructures\EntityManager\IO\IOInterface;
use Vision\DependencyInjection\ContainerInterface;

use InvalidArgumentException;
use RuntimeException;

/**
 * EntityManager
 *
 * @author Frank Liepert
 */
class EntityManager
{
    /** @type null $io */
    protected $io = null;

    /** @type null $container */
    protected $container = null;

    /** @type array $repositories */
    protected $repositories = array();

    /**
     * @param EntityManagerIO $io
     * @param ContainerInterface $container
     *
     * @return void
     */
    public function __construct(IOInterface $io, ContainerInterface $container)
    {
        $this->io = $io;
        $this->container = $container;
    }

    /**
     * @api
     *
     * @param string $file
     *
     * @return bool
     */
    public function import($file)
    {
        return $this->io->import($file, $this);
    }

    /**
     * @api
     *
     * @param string $entity
     * @param string $repository
     *
     * @return EntityManager Provides a fluent interface.
     */
    public function registerRepository($entity, $repository)
    {
        $this->repositories[$entity] = $repository;
        return $this;
    }

    /**
     * @api
     *
     * @param array $data
     *
     * @return EntityManager Provides a fluent interface.
     */
    public function registerRepositories(array $data)
    {
        foreach ($data as $entity => $repository) {
            $this->registerRepository($entity, $repository);
        }

        return $this;
    }

    /**
     * @api
     *
     * @param string|object $entity
     *
     * @return object
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRepository($entity)
    {
        if (is_object($entity)) {
            $entity = get_class($entity);
        }

        if (is_string($entity) === false) {
            throw new InvalidArgumentException(sprintf(
                '%s expects Parameter 1 to be string or object, %s given.',
                __METHOD__,
                gettype($entity)
            ));
        }

        if (isset($this->repositories[$entity])) {
            return $this->container->get($this->repositories[$entity]);
        }

        throw new RuntimeException(sprintf(
            'No repository registered for "%s".',
            $entity
        ));
    }
}
