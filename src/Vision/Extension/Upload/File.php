<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Extension\Upload;

/**
 * File
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class File
{
    protected $id = null;

    protected $path = null;

    protected $size = null;

    public function __construct($path)
    {
        $this->path = (string) $path;
    }

    public function setId($id)
    {
        if (!empty($id)) {
            $this->id = (int) $id;
        }
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getWebPath()
    {
        if (isset($_SERVER['DOCUMENT_ROOT'])) {
            $path = str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', $this->getPath());
            $path = str_replace('\\', '/', $path);
            return $path;
        }

        return null;
    }

    public function setSize($size)
    {
        $this->size = (int) $size;
        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function exchangeArray(array $data)
    {
        if (array_key_exists('id', $data)) {
            $this->setId($data['id']);
        }

        if (array_key_exists('size', $data)) {
            $this->setSize($data['size']);
        }

        return $this;
    }

    public function getArrayCopy()
    {
        return array(
            'id' => $this->getId(),
            'path' => $this->getPath(),
            'size' => $this->getSize()
        );
    }
}
