<?php
namespace Vision\Helper\Navigation;

use Vision\Helper\Navigation\Node;
use PDO;

class NavigationMapper {
    
    protected $database;
    
	public function __construct(PDO $database) {
		$this->database = $database;
	}	
	
	public function loadById($id, $languageId = 1) {	
		$sql = 'SELECT 	n.navigation_id, n.show_link, n.is_visible, n.weight, n.attributes,
						nt2.ancestor AS parent, 
						ni18n.name, ni18n.path
				FROM navigation_tree as nt1
					INNER JOIN navigation as n
						ON n.navigation_id = nt1.descendant
					LEFT JOIN navigation_tree as nt2
						ON nt2.path_length = 1
						AND nt2.descendant = nt1.descendant
					LEFT JOIN navigation_i18n AS ni18n
						ON ni18n.navigation_id = n.navigation_id
						AND ni18n.language_id = :language_id
				WHERE nt1.ancestor = :ancestor
                ORDER BY n.weight ASC, ni18n.name ASC';
		$stmt = $this->database->prepare($sql);
		$stmt->bindParam(':ancestor', $id, \PDO::PARAM_INT);
		$stmt->bindParam(':language_id', $languageId, \PDO::PARAM_INT);
		$stmt->execute();
		$result = array();
		while ($object = $stmt->fetchObject()) {
			$node = new Node($object->navigation_id);
			$node	->setShowLink($object->show_link)
					->setIsVisible($object->is_visible)
					->setParent($object->parent)
					->setName($object->name)
					->setPath($object->path)
					->setAttributes($object->attributes);
			$result[$object->navigation_id] = $node;			
		}
		return $result;
	}
}