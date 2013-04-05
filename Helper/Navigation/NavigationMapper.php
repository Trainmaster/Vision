<?php
namespace Vision\Helper\Navigation;

use PDO;
use PDOException;

class NavigationMapper
{
    protected $pdo;
    
	public function __construct(PDO $pdo)
    {
		$this->pdo = $pdo;
	}	

	public function loadByIdAndLanguageId($id, $languageId)
    {	
		$sql = 'SELECT 	nn.node_id, nn.show_link, nn.is_visible, nn.weight, nn.attributes,
						nt2.ancestor AS parent, 
						ni18n.name, ni18n.path
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
                ORDER BY nn.weight ASC, ni18n.name ASC';
		$pstmt = $this->pdo->prepare($sql);
		$pstmt->bindParam(':ancestor', $id, PDO::PARAM_INT);
		$pstmt->bindParam(':language_id', $languageId, PDO::PARAM_INT);
		$pstmt->execute();

		$result = array();
        
		while ($data = $pstmt->fetch(PDO::FETCH_ASSOC)) {
			$node = new Node($data['node_id']);
			$node	->setShowLink($data['show_link'])
					->setIsVisible($data['is_visible'])
					->setParent($data['parent'])
					->setName($data['name'])
					->setPath($data['path'])
					->setAttributes($data['attributes']);
			$result[$data['node_id']] = $node;			
		}
        
		return $result;
	}
}