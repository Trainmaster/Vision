<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\App;

use Locale;

use Vision\Controller\FrontController;

/**
 * AbstractApp
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractApp
{
    /** @type bool $debug */
    protected $debug = true;

    /** @type string $fallbackLocale */
    protected $fallbackLocale = 'de_DE';

    /** @type string $environment */
    protected $environment = 'dev';

    /** @type FrontController $frontController */
    protected $frontController;

    /**
     * Constructor
     *
     * @param FrontController $frontController
     */
    public function __construct(FrontController $frontController)
    {
        $this->frontController = $frontController;
        $this->initLocale();
    }

    /**
     * This method sets the locale based on the HTTP-Accept-Language-Header.
     *
     * @return bool
     */
    public function initLocale()
    {
        if (class_exists('Locale') === false) {
            return false;
        }

        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return false;
        }

        $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);

        if ($locale === null) {
            $locale = $this->fallbackLocale;
        }

        return Locale::setDefault($locale);
    }

    /**
     * @api
     *
     * @param string $debug
     *
     * @return $this Provides a fluent interface.
     */
    public function setDebug($debug)
    {
        $this->debug = (bool) $debug;
        return $this;
    }

    /**
     * @api
     *
     * @return bool
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * @api
     *
     * @param string $environment
     *
     * @return $this Provides a fluent interface.
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @api
     *
     * @return void
     */
    public function run()
    {
        $this->frontController->run();
        $response = $this->frontController->getResponse();
        $response->send();
    }
}
