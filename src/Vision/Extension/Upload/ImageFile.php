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
 * ImageFile
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class ImageFile extends File
{
    protected $height = null;

    protected $width = null;

    protected $alt = null;

    protected $caption = null;

    public function setHeight($height)
    {
        $this->height = (int) $height;
        return $this;
    }

    public function getHeight($max = null)
    {
        if (isset($max)) {
            $max = (int) $max;

            if ($max < $this->height) {
                return $max;
            }
        }

        return $this->height;
    }

    public function setWidth($width)
    {
        $this->width = (int) $width;
        return $this;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setAlt($alt)
    {
        $this->alt = $alt;
        return $this;
    }

    public function getAlt()
    {
        return $this->alt;
    }

    public function setCaption($caption)
    {
        $this->caption = $caption;
        return $this;
    }

    public function getCaption()
    {
        return $this->caption;
    }

    public function populate(array $data)
    {
        parent::populate($data);

        if (array_key_exists('height', $data)) {
            $this->setHeight($data['height']);
        }

        if (array_key_exists('width', $data)) {
            $this->setWidth($data['width']);
        }

        if (array_key_exists('alt', $data)) {
            $this->setAlt($data['alt']);
        }

        if (array_key_exists('caption', $data)) {
            $this->setCaption($data['caption']);
        }

        return $this;
    }

    public function getArrayCopy()
    {
        $array = array(
            'height' => $this->getHeight(),
            'width' => $this->getWidth(),
            'alt' => $this->getAlt(),
            'caption' => $this->getCaption()
        );

        return parent::getArrayCopy() + $array;
    }
}
