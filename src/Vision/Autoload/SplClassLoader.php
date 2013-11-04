<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Autoload;

/**
 * SplClassLoader
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class SplClassLoader
{
    /** @type string $fileExtension */
    protected $fileExtension = '.php';

    /** @type string $namespace */
    protected $namespace = null;

    /** @type string $namespaceSeparator */
    protected $namespaceSeparator = '\\';

    /** @type string $path */
    protected $path = null;

    /**
     * @param string $namespace
     * @param string $path
     */
    public function __construct($namespace, $path)
    {
        $this->setNamespace($namespace);
        $this->setPath($path);
    }

    /**
     * @api
     *
     * @param string $fileExtension
     *
     * @return SplClassLoader Provides a fluent interface.
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = (string) $fileExtension;
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * @api
     *
     * @param string $namespace
     *
     * @return SplClassLoader Provides a fluent interface.
     */
    public function setNamespace($namespace)
    {
        $this->namespace = (string) $namespace;
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @api
     *
     * @param string $namespaceSeparator
     *
     * @return SplClassLoader Provides a fluent interface.
     */
    public function setNamespaceSeparator($namespaceSeparator)
    {
        $this->namespaceSeparator = (string) $namespaceSeparator;
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getNamespaceSeparator()
    {
        return $this->namespaceSeparator;
    }

    /**
     * @api
     *
     * @param string $path
     *
     * @return SplClassLoader Provides a fluent interface.
     */
    public function setPath($path)
    {
        $this->path = realpath($path);
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @api
     *
     * @param string $class
     *
     * @return mixed
     */
    public function load($class)
    {
        $hasNamespace = strpos($class, $this->namespace . $this->namespaceSeparator);
        if ($hasNamespace === 0) {
            $class = str_replace($this->namespaceSeparator, DIRECTORY_SEPARATOR, $class);

            $fileName = $this->path . DIRECTORY_SEPARATOR . $class . $this->fileExtension;
            $fileName = stream_resolve_include_path($fileName);

            if ($fileName) {
                return include $fileName;
            }
        }
        return false;
    }

    /**
     * @api
     *
     * @param bool $prepend
     *
     * @return <type>
     */
    public function register($prepend = false)
    {
        spl_autoload_register(array($this, 'load'), true, (bool) $prepend);
    }

    /**
     * @api
     *
     * @return void
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'load'));
    }
}
