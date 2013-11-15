<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Extension\Navigation;

use Vision\DataStructures\Tree\NodeIterator;
use Vision\Html\Element;
use Vision\Http\RequestInterface;

/**
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class NavigationRenderer implements NavigationRendererInterface
{
    /** @type RequestInterface $request */
    protected $request = null;

    /** @type int $fromDepth */
    protected $fromDepth = 0;

    /** @type int $limitDepth */
    protected $limitDepth = -1;

    /** @type int $expandBy */
    protected $expandBy = -1;

    /** @type bool $link */
    protected $link = false;

    /**
     * Constructor
     *
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @api
     *
     * @param int $fromDepth
     *
     * @return NavigationRenderer Provides a fluent interface.
     */
    public function fromDepth($fromDepth)
    {
        $this->fromDepth = (int) $fromDepth;
        return $this;
    }

    /**
     * @api
     *
     * @param int $limitDepth
     *
     * @return NavigationRenderer Provides a fluent interface.
     */
    public function limitDepth($limitDepth)
    {
        $this->limitDepth = (int) $limitDepth;
        return $this;
    }

    /**
     * @api
     *
     * @param int $expandBy
     *
     * @return NavigationRenderer Provides a fluent interface.
     */
    public function expandBy($expandBy)
    {
        $this->expandBy = (int) $expandBy;
        return $this;
    }

    /**
     * @api
     *
     * @param bool $link
     *
     * @return NavigationRenderer Provides a fluent interface.
     */
    public function link($link)
    {
        $this->link = (bool) $link;
        return $this;
    }

    /**
     * @api
     *
     * @param Node $node
     *
     * @return string
     */
    public function render(Node $node)
    {
        $basePath = $this->request->getBasePath();

        $nodeIterator = new NodeIterator($node);
        $cachingIterator = new \RecursiveCachingIterator($nodeIterator);
        $iterator = new \RecursiveIteratorIterator($cachingIterator, \RecursiveIteratorIterator::SELF_FIRST);

        $fromDepth = $this->fromDepth;
        $limitDepth = $this->limitDepth;
        $expandBy = $this->expandBy;
        $link = $this->link;

        $actives = array();
        $lastDepth = $fromDepth - 1;

        if ($limitDepth > 0) {
            $iterator->setMaxDepth($fromDepth + $limitDepth - 1);
        }

        $html = '';

        foreach ($iterator as $node) {
            $depth = $iterator->getDepth();
            $maxDepth = $iterator->getMaxDepth();

            if (isset($node->isActive)) {
                $actives[$node->getId()] = $depth;
            }

            if ($maxDepth === false) {
                $maxDepth = -1;
            }

            if ($maxDepth >= 0 && $depth > $maxDepth) {
                $iterator->current()->removeChildren();
                continue;
            }

            if ($depth < $fromDepth) {
                continue;
            }

            $parent = $node->getParentId();
            $parentIsActive = array_key_exists($parent, $actives);

            if (!$parentIsActive) {
                if ((!empty($actives) && ($depth > 0 || $depth > max($actives)) && $link)
                    || ($link && $fromDepth > 0)) {
                    $iterator->current()->removeChildren();
                    continue;
                }
            }

            if (empty($actives) && $link) {
                $iterator->setMaxDepth($depth);
                $iterator->current()->removeChildren();
            }

            if ($depth < $lastDepth) {
                $html .= '</ul></li>';
            } elseif ($depth > $lastDepth) {
                $html .= '<ul class="level-' . $depth . '">';
            }

            if ($iterator->hasNext()) {
                if ($depth > $lastDepth) {
                    $class = 'first-item';
                } else {
                    $class = null;
                }
            } else {
                if ($depth > $lastDepth) {
                    $class = 'foreverAlone-item';
                } else {
                    $class = 'last-item';
                }
            }

            if ($node->isVisible()) {
                if ($node->showLink()) {
                    $url = $node->getPath();

                    $element = new Element('a');

                    if (parse_url($url, PHP_URL_SCHEME)) {
                        $href = $url;
                        $element->setAttribute('target', '_blank');
                    } else {
                        $href = $basePath . $url;
                    }

                    $element->setAttribute('href', $href);
                } else {
                    $element = new Element('span');
                }
                $element->addContent($node->getName());
            } else {
                $element = null;
            }

            $li = new Element('li');
            $li->addContent($element);

            $attributes = $node->getAttributes();

            if (!empty($attributes)) {
                $li->setAttributes($attributes);
            }

            if (isset($class)) {
                $li->addClass($class);
            }

            if (isset($node->isActive)) {
                $li->addClass('active');
            }

            $html .= $li->renderStartTag()
                  .  $li->renderContents();

            if (!$iterator->current()->hasChildren() || $depth === $maxDepth) {
                $html .= '</li>';
            }

            $lastDepth = $depth;
        }

        $diff = $lastDepth - $this->fromDepth;

        if ($diff > 0) {
            $html .= str_repeat('</ul></li>', $diff);
        }

        if ($diff >= 0) {
            $html .= '</ul>';
        }

        return $html;
    }
}
