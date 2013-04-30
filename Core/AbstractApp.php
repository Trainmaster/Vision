<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Core;

use Locale;

use Vision\Controller\FrontController;
use Vision\File\Loader\LoaderInterface;

/**
 * AbstractApp
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
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
        if (class_exists('Locale') === false) {
            return false;
        }
            
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return false;
        }
        
        $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']); 
        
        Locale::setDefault($locale);  
        setlocale(LC_ALL, $locale);        
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