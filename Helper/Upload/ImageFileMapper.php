<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Helper\Upload;

use Vision\Database\Mapper\PDOMapper;

use PDO;

/**
 * ImageFileMapper
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class ImageFileMapper extends PDOMapper
{
    public function createDomainObject($path)
    {
        return new ImageFile($path);
    }
    
    public function save(ImageFile $entity)
    {
        $sql = 'INSERT INTO image (
                    image_id,
                    path,
                    height,
                    width,
                    size,
                    alt,
                    caption
                ) VALUES (
                    :image_id,
                    :path,
                    :height,
                    :width,
                    :size,
                    :alt,
                    :caption
                ) ON DUPLICATE KEY UPDATE
                    path = VALUES(path),
                    size = VALUES(size),
                    height = VALUES(height),
                    width = VALUES(width),
                    alt = VALUES(alt),
                    caption = VALUES(caption)';
        $pstmt = $this->pdo->prepare($sql);
        $pstmt->bindValue(':image_id', $entity->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':path', $entity->getPath(), PDO::PARAM_STR);
        $pstmt->bindValue(':height', $entity->getHeight(), PDO::PARAM_INT);
        $pstmt->bindValue(':width', $entity->getWidth(), PDO::PARAM_INT);
        $pstmt->bindValue(':size', $entity->getSize(), PDO::PARAM_STR);
        $pstmt->bindValue(':alt', $entity->getAlt(), PDO::PARAM_STR);
        $pstmt->bindValue(':caption', $entity->getCaption(), PDO::PARAM_STR);
        $pstmt->execute();
        
        $id = $this->pdo->lastInsertId();
        
        if ($entity->getId() === null) {
            $entity->setId($id);
        }
        
        return $entity;
    }
    
    public function findByIds(array $ids)
    {
        $entities = array();
        
        if (empty($ids)) {
            return $entities;
        }
        
        $sql = 'SELECT image_id AS id,
                       path,
                       size,
                       height,
                       width,
                       alt,
                       caption
                FROM image
                WHERE image_id ' . $this->pdo->IN($ids);
        
        $pstmt = $this->pdo->prepare($sql);
        $pstmt->execute($ids);      
        
        while ($row = $pstmt->fetch(PDO::FETCH_ASSOC)) {
            $entities[] = $this->createDomainObject($row['path'])->populate($row);
        }
        
        return $entities;
    }
}