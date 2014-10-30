<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Html;

use InvalidArgumentException;
use LogicException;

/**
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Element
{
    /** @type array $attributes */
    protected $attributes = array();

    /** @type array $invalidAttributes */
    protected $invalidAttributes = array();

    /** @type array $contents */
    protected $contents = array();

    /** @type array $voidElements */
    protected static $voidElements = array( 'area', 'base', 'br', 'col', 'command', 'embed',
                                            'hr', 'img', 'input', 'keygen', 'link', 'meta',
                                            'param', 'source', 'track', 'wbr');

    /** @type bool $isVoid */
    protected $isVoid = false;

    /** @type string $tag */
    protected $tag;

    /**
     * @param string $tag
     */
    public function __construct($tag)
    {
        $this->setTag($tag);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = $this->renderStartTag();

        if ($this->isVoid) {
            return $html;
        }

        $html .= $this->renderContents()
              .  $this->renderEndTag();

        return $html;
    }

    /**
     * @api
     *
     * @return string
     */
    public function renderStartTag()
    {
        $tag = $this->getTag();

        if (empty($tag)) {
            return '';
        }

        $html = '<%s%s%s>';

        $attributes = $this->renderAttributes();
        $slash = '';

        if ($this->isVoid) {
            $slash = ' /';
        }

        return sprintf($html, $tag, $attributes, $slash);
    }

    /**
     * @api
     *
     * @return string
     */
    public function start()
    {
        return $this->renderStartTag();
    }

    /**
     * @api
     *
     * @return string
     */
    public function renderContents()
    {
        $tag = $this->getTag();

        if (empty($tag)) {
            return '';
        }

        $html = '';
        $contents = $this->getContents();

        if (!empty($contents)) {
            if (is_array($contents)) {
                foreach ($contents as $content) {
                    $html .= $content;
                }
            } elseif (is_string($contents)) {
                $html .= $contents;
            }
        }

        return $html;
    }

    /**
     * @api
     *
     * @return string
     */
    public function renderEndTag()
    {
        $tag = $this->getTag();

        if (empty($tag) || $this->isVoid) {
            return '';
        }

        $html = '</%s>';

        return sprintf($html, $tag);
    }

    /**
     * @api
     *
     * @return string
     */
    public function end()
    {
        return $this->renderEndTag();
    }

    /**
     * Render attributes
     *
     * @return string
     */
    protected function renderAttributes()
    {
        $html = '';

        foreach ($this->attributes as $key => $value) {
            if ($value === true) {
                $html .= ' ' . $key;
            } else {
                $html .= ' ' . $key . '="' . $value . '"';
            }
        }

        return $html;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isVoid()
    {
        return $this->isVoid;
    }

    /**
     * @api
     *
     * @param int|float|string|bool|object|null $content
     *
     * @return $this Provides a fluent interface.
     */
    public function addContent($content)
    {
        if ($this->isVoid) {
            throw new LogicException('Void elements are not allowed to have contents.');
        }

        if (is_scalar($content) || (is_object($content) && method_exists($content, '__toString'))) {
            $this->contents[] = $content;
        } elseif ($content === null) {
            return $this;
        } else {
            throw new InvalidArgumentException('Unsupported argument type.');
        }

        return $this;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @api
     *
     * @return $this Provides a fluent interface.
     */
    public function clearContents()
    {
        $this->contents = array();
        return $this;
    }

    /**
     * @api
     *
     * @param string $key
     * @param string|bool $value
     *
     * @return $this Provides a fluent interface.
     */
    public function setAttribute($key, $value = true)
    {
        if (!in_array($key, $this->invalidAttributes)) {
            $this->attributes[$key] = $value;
        }
        return $this;
    }

    /**
     * @api
     *
     * @param array $attributes
     *
     * @return $this Provides a fluent interface.
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * @api
     *
     * @param string $key
     *
     * @return Element|null
     */
    public function getAttribute($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        return null;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @api
     *
     * @param string $key
     *
     * @return bool
     */
    public function removeAttribute($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            unset($this->attributes[$key]);
            return true;
        }

        return false;
    }

    /**
     * @api
     *
     * @param string $id
     *
     * @return $this Provides a fluent interface.
     */
    public function setId($id)
    {
        $this->setAttribute('id', $id);
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }

    /**
     * @api
     *
     * @param string $class
     *
     * @return $this Provides a fluent interface.
     */
    public function addClass($class)
    {
        $attribute = $this->getAttribute('class');
        $class = trim($class);

        if ($attribute) {
            $class = $attribute . ' ' . $class;
        }

        $this->setAttribute('class', $class);

        return $this;
    }

    /**
     * @api
     *
     * @param string $class
     *
     * @return $this Provides a fluent interface.
     */
    public function removeClass($class)
    {
        $attribute = $this->getAttribute('class');
        $class = trim($class);

        if ($attribute) {
            $class = str_replace($class, '', $attribute);

            if (strpos($class, '  ') !== false) {
                $class = preg_replace('/\s\s+/', ' ', $class);
            }

            $this->setAttribute('class', $class);
        }

        return $this;
    }

    /**
     * @internal
     *
     * @param string $tag
     *
     * @throws InvalidArgumentException
     *
     * @return $this Provides a fluent interface.
     */
    protected function setTag($tag)
    {
        if (!is_string($tag) || !preg_match('#^\w+$#', $tag)) {
            throw new InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string and only use characters in the range 0–9, a–z, and A–Z.',
                __METHOD__
            ));
        }

        $tag = trim($tag);
        $tag = strtolower($tag);
        $this->tag = $tag;

        if (in_array($tag, self::$voidElements)) {
            $this->isVoid = true;
        }

        return $this;
    }
}
