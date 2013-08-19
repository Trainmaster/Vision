<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\File;

use InvalidArgumentException;

/**
 * UploadedFile
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class UploadedFile extends File
{
    /** @type array $clientData */
    protected $clientData = array();
    
    public function __construct($filename)
    {
        if (is_uploaded_file($filename) === false) {
            throw new InvalidArgumentException(sprintf(
                'The file "%s" is not an uploaded file.',
                $filename
            ));
        }
        
        parent::__construct($filename);    
    }
    
    /**
     * @api
     *
     * @param array $data 
     * 
     * @return UploadedFile Provides a fluent interface.
     */
    public function setClientData(array $data)
    {
        $this->clientData = $data;
        return $this;
    }
    
    /**
     * @api
     *
     * @return string|null
     */
    public function getClientName()
    {
        if (isset($this->clientData['name'])) {
            return $this->clientData['name'];
        }
        return null;
    }
    
    /**
     * @api
     *
     * @return string|null
     */
    public function getClientType()
    {
        if (isset($this->clientData['type'])) {
            return $this->clientData['type'];
        }
        return null;
    }
    
    /**
     * @api
     *
     * @return string|null
     */
    public function getClientSize()
    {
        if (isset($this->clientData['size'])) {
            return $this->clientData['size'];
        }
        return null;
    }
    
    /**
     * @api
     *
     * @return string|null
     */
    public function getClientTmpName()
    {
        if (isset($this->clientData['tmp_name'])) {
            return $this->clientData['tmp_name'];
        }
        return null;
    }
    
    /**
     * @api
     *
     * @return string|null
     */
    public function getClientError()
    {
        if (isset($this->clientData['error'])) {
            return $this->clientData['error'];
        }
        return null;
    }
    
    /**
     * @api
     *
     * @return string
     */
    public function getClientExtension()
    {
        $extension = pathinfo($this->getClientName(), PATHINFO_EXTENSION);
        return $extension;
    }
}