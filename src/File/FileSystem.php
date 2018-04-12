<?php
declare(strict_types = 1);

namespace Vision\File;

class FileSystem
{
    /** @var array */
    protected $aliases = [];

    /** @var null|string $dirs */
    protected $currentDir;

    /**
     * @param string $alias
     * @param string $path
     *
     * @return FileSystem Provides a fluent interface.
     */
    public function addAlias($alias, $path): self
    {
        $this->aliases[$alias] = $path;
        return $this;
    }

    /**
     * @param string $alias
     *
     * @return string|null
     */
    public function getAlias($alias): ?string
    {
        return isset($this->aliases[$alias]) ? $this->aliases[$alias] : null;
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * @param string $dest
     *
     * @return bool
     */
    public function isWritable($dest): bool
    {
        return is_file($dest) ? is_writable($dest) : is_writable(pathinfo($dest, PATHINFO_DIRNAME));
    }

    /**
     * @param string $src
     * @param string $dest
     *
     * @return bool
     */
    public function move($src, $dest): bool
    {
        if ($this->isWritable($dest) === false) {
            return false;
        }

        return is_uploaded_file($src) ? move_uploaded_file($src, $dest) : rename($src, $dest);
    }

    /**
     * @param string $dir
     *
     * @return bool
     */
    public function chdir($dir): bool
    {
        return $this->setCurrentDir($dir);
    }

    /**
     * @param string $dir
     *
     * @return bool
     */
    public function setCurrentDir($dir): bool
    {
        if (is_dir($dir)) {
            $this->currentDir = $dir;
            return true;
        }
        return false;
    }

    /**
     * @param string $source
     * @param string $newName
     *
     * @return bool
     */
    public function moveHere($source, $newName = null): bool
    {
        if ($this->currentDir === null) {
            return false;
        }

        if ($newName === null) {
            return $this->move($source, $this->currentDir . DIRECTORY_SEPARATOR . basename($source));
        }

        return $this->move($source, $this->currentDir . DIRECTORY_SEPARATOR . $newName);
    }
}
