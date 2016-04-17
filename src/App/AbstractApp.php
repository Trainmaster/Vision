<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\App;

use Locale;

use Vision\Controller\FrontController;
use Vision\Http\RequestInterface;

abstract class AbstractApp
{
    /** @var bool $debug */
    protected $debug = true;

    /** @var string $fallbackLocale */
    protected $fallbackLocale = 'de_DE';

    /** @var string $environment */
    protected $environment = 'dev';

    /** @var FrontController $frontController */
    protected $frontController;

    /** @var RequestInterface $request */
    protected $request;

    /**
     * @param FrontController $frontController
     * @param RequestInterface $request
     */
    public function __construct(FrontController $frontController, RequestInterface $request)
    {
        $this->frontController = $frontController;
        $this->request = $request;
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

        $httpAcceptLanguage = $this->request->SERVER['HTTP_ACCEPT_LANGUAGE'];

        if (empty($httpAcceptLanguage)) {
            return false;
        }

        $locale = Locale::acceptFromHttp($httpAcceptLanguage);

        if ($locale === null) {
            $locale = $this->fallbackLocale;
        }

        return Locale::setDefault($locale);
    }

    /**
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
     * @return bool
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
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
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @return void
     */
    public function run()
    {
        $this->frontController->run($this->request)->send();
    }
}
