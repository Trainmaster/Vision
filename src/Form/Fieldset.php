<?php
declare(strict_types=1);

namespace Vision\Form;

use Vision\Html\Element;

/**
 * Fieldset
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Fieldset extends AbstractCompositeType
{
    /** @var null|string $legend */
    protected $legend;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('fieldset');
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        $content = parent::getContents();

        if ($this->legend) {
            $legend = new Element('legend');
            $legend->addContent($this->legend);
            $content = $legend . $content;
        }

        return $content;
    }

    /**
     * @param string $legend
     *
     * @return $this Provides a fluent interface.
     */
    public function setLegend($legend)
    {
        $this->legend = (string) $legend;
        return $this;
    }

    /**
     * @return string
     */
    public function getLegend()
    {
        return $this->legend;
    }
}
