<?php 
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form;

/**
 * FakeFieldset
 *
 * @todo Find a better class name, FakeFieldset is not really satisfying
 *
 * @author Frank Liepert
 */ 
class FakeFieldset extends AbstractCompositeType 
{        
    public function init()
    {
        $this->addDecorator(new Decorator\Li);
    }
}