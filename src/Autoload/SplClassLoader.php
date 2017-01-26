<?php
declare(strict_types=1);

namespace Vision\Autoload;

class SplClassLoader
{
    /** @var string $fileExtension */
    protected $fileExtension = '.php';

    /** @var string $namespace */
    protected $namespace;

    /** @var string $namespaceSeparator */
    protected $namespaceSeparator = '\\';

    /** @var string $path */
    protected $path;

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
     * @return string
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
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
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
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
     * @return string
     */
    public function getNamespaceSeparator()
    {
        return $this->namespaceSeparator;
    }

    /**
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
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
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
     * @param bool $prepend
     *
     * @return void
     */
    public function register($prepend = false)
    {
        spl_autoload_register([$this, 'load'], true, (bool) $prepend);
    }

    /**
     * @return void
     */
    public function unregister()
    {
        spl_autoload_unregister([$this, 'load']);
    }
}
