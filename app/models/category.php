<?php
class Category extends AppModel {
	var $name = 'Category';
	var $labels = array(
		'nombre_corto'=>'Nombre corto',
		'src'=>'Imagen de Sección'
	);
	var $hasMany = array('Event','Post','Album','Document','Clink','Poll','Achievement');
	var $actsAs = array('Ordenable','Tree','File' => array('portada'=>false));
	var $skipValidation = array('src');
	var $asTree = true;

	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		return count($this->paginate($conditions,null,null,null,null,$recursive,$extra));
	}
	
	function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
		$recursive = -1;
		$query = '';
		
		$models = array_keys(Configure::read('Sections'));

		if(isset($conditions['tipo']) && $conditions['tipo'] && in_array($conditions['tipo'],$models))
			$models = array($conditions['tipo']);

		foreach($models as $model){
			$model = ucfirst($model);
			App::import('Sanitize');
			
			$query[] = 'SELECT id, \''.$model.'\' as model FROM '.Inflector::tableize($model).' AS '.$model.' WHERE '.$model.'.activo = 1';
		}
		
		$query = 'SELECT * FROM (('.implode(') UNION (',$query).')) as Result '.($page && $limit ? 'LIMIT '.(($page-1)*$limit).', '.$limit:'');
		
	    return $this->query($query);
	}
}
?>