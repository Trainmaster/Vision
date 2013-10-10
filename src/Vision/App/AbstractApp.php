<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
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
    protected $debug = true;
    
    protected $environment = 'dev';   
    
    protected $frontController = null;
    
    public function __construct(FrontController $frontController)
    {
        $this->frontController = $frontController;
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
        
        if ($locale === null) {
            return false;
        }
        
        Locale::setDefault($locale);       
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
    
    public function run()
    {   
        $this->frontController->run();
        $response = $this->frontController->getResponse();
        $response->send();
    }
}