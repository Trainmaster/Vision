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

    public function __construct(string $tag)
    {
        $this->setTag($tag);
    }

    public function __toString(): string
    {
        $html = $this->renderStartTag();

        if ($this->isVoid) {
            return $html;
        }

        $html .= $this->renderContents()
            . $this->renderEndTag();

        return $html;
    }

    public function renderStartTag(): string
    {
        $slash = '';

        if ($this->isVoid) {
            $slash = ' /';
        }

        return sprintf('<%s%s%s>', $this->tag, $this->renderAttributes(), $slash);
    }

    public function start(): string
    {
        return $this->renderStartTag();
    }

    public function renderContents(): string
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

    public function end(): string
    {
        return $this->renderEndTag();
    }

    protected function renderAttributes(): string
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

    public function getTag(): string
    {
        return $this->tag;
    }

    public function isVoid(): bool
    {
        return $this->isVoid;
    }

    /**
     * @param int|float|string|bool|object|null $content
     *
     * @return self Provides a fluent interface.
     */
    public function addContent($content): self
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

    public function clearContents(): self
    {
        $this->contents = [];
        return $this;
    }

    public function setAttribute(string $key, $value = true): self
    {
        if (!in_array($key, $this->invalidAttributes)) {
            $this->attributes[$key] = $value;
        }
        return $this;
    }

    public function setAttributes(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    public function getAttribute(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function removeAttribute(string $key): bool
    {
        if (array_key_exists($key, $this->attributes)) {
            unset($this->attributes[$key]);
            return true;
        }

        return false;
    }

    public function setId($id): self
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

    public function addClass(string $class): self
    {
        $attribute = $this->getAttribute('class');
        $class = trim($class);

        if ($attribute) {
            $class = $attribute . ' ' . $class;
        }

        $this->setAttribute('class', $class);

        return $this;
    }

    public function removeClass(string $class): self
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
