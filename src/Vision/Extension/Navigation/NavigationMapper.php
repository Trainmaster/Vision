<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Extension\Navigation;

use Vision\Database\AbstractPdoRepository;

/**
 * NavigationMapper
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class NavigationMapper extends AbstractPdoRepository implements NavigationMapperInterface
{
    /**
     * @api
     *
     * @param int $id
     * @param int $languageId
     *
     * @return array $result
     */
    public function loadByIdAndLanguageId($id, $languageId)
    {
        $sql = 'SELECT  nn.node_id,
                        nn.show_link,
                        nn.is_visible,
                        nn.weight,
                        nn.attributes,
                        nt2.ancestor AS parent,
                        ni18n.name,
                        ni18n.path
                FROM navigation_tree as nt1
                    INNER JOIN navigation_node as nn
                        ON nn.node_id = nt1.descendant
                    LEFT JOIN navigation_tree as nt2
                        ON nt2.path_length = 1
                        AND nt2.descendant = nt1.descendant
                    LEFT JOIN navigation_node_i18n AS ni18n
                        ON ni18n.node_id = nn.node_id
                        AND ni18n.language_id = :language_id
                WHERE nt1.ancestor = :ancestor
                AND nn.is_visible = TRUE
                ORDER BY nn.weight ASC,
                         ni18n.name ASC';

        $pstmt = $this->pdo->prepare($sql);
        $pstmt->bindParam(':ancestor', $id, \PDO::PARAM_INT);
        $pstmt->bindParam(':language_id', $languageId, \PDO::PARAM_INT);
        $pstmt->execute();

        $result = array();

        while ($data = $pstmt->fetch(\PDO::FETCH_ASSOC)) {
            $node = new Node($data['node_id']);
            $node->setShowLink($data['show_link'])
                 ->setIsVisible($data['is_visible'])
                 ->setParentId($data['parent'])
                 ->setName($data['name'])
                 ->setPath($data['path'])
                 ->setAttributes(json_decode($data['attributes'], true));
            $result[$data['node_id']] = $node;
        }

        $result = $this->convertFlatToHierarchical($result);

        if (isset($result[$id])) {
            return $result[$id];
        }

        return null;
    }

    /**
     * Converts flat array to hierarchical array.
     *
     * @param array $data
     *
     * @return array $data
     */
    protected function convertFlatToHierarchical(array $data)
    {
        foreach ($data as $row) {
            if ($row instanceof Node) {
                $parent = $row->getParentId();
                if (array_key_exists($parent, $data)) {
                    $data[$parent]->addChild($row);
                    unset($data[$row->getId()]);
                }
            } else {
                throw new RuntimeException('Array element must be an instance of Node.');
            }
        }

        return $data;
    }
}
