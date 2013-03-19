<?php
namespace Vision\Core;

use Vision\Controller\FrontController;
use Vision\File\Loader\LoaderInterface;
use Locale;

abstract class AbstractApp
{
    protected $debug = true;
    
    protected $environment = 'dev';   
    
    protected $frontController = null;
    
    protected $loader = null;
    
    protected $configDir = null;
    
    public function __construct(FrontController $frontController, LoaderInterface $loader)
    {
        $this->frontController = $frontController;
        $this->loader = $loader;
        $this->initLocale();
    }
    
    public function initLocale()
    {
        if (class_exists('Locale')) {
            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);            
                if ($locale !== null) {
                    Locale::setDefault($locale);    
                }
            }
        }
    }
    
    public function setDebug($debug)
    {
        $this->debug = (bool) $debug;
        return $this;
    }
    
    public function getDebug()
    {
        return $this->debug;
    }
    
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }
    
    public function getEnvironment()
    {
        return $this->environment;
    }
    
    public function setConfigDir($configDir)
    {
        $this->configDir = $configDir;
        return $this;
    }
    
    public function run()
    {   
        if ($this->configDir !== null) {
            $this->loader->load($this->configDir . DIRECTORY_SEPARATOR . 'routes.php');
        }
        $this->frontController->run();
        $response = $this->frontController->getResponse();
        $response->send();
    }
}