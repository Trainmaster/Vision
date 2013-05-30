<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Helper\Upload;

use Vision\DataStructures\EntityManager\EntityManager;
use Vision\File\FileSystem;
use Vision\File\UploadedFile;

use RuntimeException;

/**
 * UploadService
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class UploadService
{    
    protected $entityManager = null;
    
    protected $fileSystem = null;
    
    protected $tmpPath = null;
    
    protected $processors = array();
    
    public function __construct(EntityManager $entityManager, FileSystem $fileSystem)
    {
        $this->entityManager = $entityManager;
        $this->fileSystem = $fileSystem;
        $this->initTmpPath();
    }
    
    public function getFileSystem()
    {
        return $this->fileSystem;
    }
    
    public function addProcessor($processor)
    {
        $this->processors[] = $processor;
        return $this;
    }
    
    public function move(UploadedFile $file, $dest)
    {
        if ($this->fileSystem->isWritable($dest) === false) {
            throw new RuntimeException(sprintf(
                'Unable to write to destination "%s". Double-check the permissions.', 
                $dest
            ));
        }
        
        foreach ($this->processors as $processor) {
            if ($processor->isResponsibleFor($file)) {
                return $processor->process($file, $dest);
            }
        }
        
        return false;
    }
    
    public function save(File $file)
    {
        return $this->entityManager->getRepository($file)->save($file);
    }
    
    public function findByIds($file, array $ids)
    {
        return $this->entityManager->getRepository($file)->findByIds($ids);
    }
    
    public function initTmpPath()
    {
        if ($tmp = getenv('TMP') === false) {
            return;
        } elseif ($tmp = ini_get('upload_tmp_dir') === false) {
            return;
        }
        
        $this->tmpPath = realpath($tmp);
    }
    
    public function getTmpPath()
    {
        return $this->tmpPath;
    }
}