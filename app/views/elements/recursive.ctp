<?php
$header = isset($header) ? $header : false;
$filter = isset($filter) ? $filter : false;
$model = ucfirst(isset($model) ? $model : $_m[0]);
$belongs = ucfirst(isset($belongs) ? $belongs : $model);
$addclass = isset($addclass) && $addclass ? $addclass : '';
$current = 'current'.$model;

if($model && $items = $this->requestAction('/'.(Inflector::tableize($model)).'/last/mode:threaded/activo:1')){
	echo $html->div('recent');
		if($header)
			echo $html->tag('h2',$header);
			
		echo $util->recursivelist(
			$items,
			array(
				'current'=>${$current},
				'model'=>$model,
				'belongs'=>$belongs,
				'listClass'=>'recent'
			),
			$filter
		);

	echo '</div>';
}
?>