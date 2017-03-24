<?php
declare(strict_types = 1);

namespace Vision\Html;

use InvalidArgumentException;
use LogicException;

class Element
{
    /** @var array $attributes */
    protected $attributes = [];

    /** @var array $invalidAttributes */
    protected $invalidAttributes = [];

    /** @var array $contents */
    protected $contents = [];

    /** @var array $voidElements */
    protected static $voidElements = [
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input',
        'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr'
    ];

    /** @var bool $isVoid */
    protected $isVoid = false;

    /** @var string $tag */
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
            . $this->renderEndTag();

        return $html;
    }

    /**
     * @return string
     */
    public function renderStartTag()
    {
        $slash = '';

        if ($this->isVoid) {
            $slash = ' /';
        }

        return sprintf('<%s%s%s>', $this->tag, $this->renderAttributes(), $slash);
    }

    /**
     * @return string
     */
    public function start()
    {
        return $this->renderStartTag();
    }

    /**
     * @return string
     */
    public function renderContents()
    {
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

    public function renderEndTag(): string
    {
        return $this->isVoid ? '' : "</$this->tag>";
    }

    /**
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
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return bool
     */
    public function isVoid()
    {
        return $this->isVoid;
    }

    /**
     * @param int|float|string|bool|object|null $content
     *
     * @return $this Provides a fluent interface.
     */
    public function addContent($content)
    {
        if ($this->isVoid) {
            throw new LogicException('Void elements can\'t have any contents.');
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
     * @return array
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @return $this Provides a fluent interface.
     */
    public function clearContents()
    {
        $this->contents = [];
        return $this;
    }

    /**
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
     * @param string $key
     *
     * @return mixed|null
     */
    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
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
     * @return string
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }

    /**
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

    protected function setTag(string $tag): self
    {
        if (preg_match('#^\w+$#', $tag) !== 1) {
            throw new InvalidArgumentException(sprintf(
                'Invalid tag name "%s". Only alphanumeric ASCII characters [A-Za-z0-9] are allowed.',
                $tag
            ));
        }

        $this->tag = strtolower($tag);
        $this->isVoid = in_array($this->tag, self::$voidElements);

        return $this;
    }
}
