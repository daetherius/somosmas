<?php
$model = isset($model) ? $model : 'Banner';
$field = isset($field) ? $field : 'src';

$data = $this->requestAction('/'.Inflector::tableize($model).'/last/activo:1');

$w = isset($w) && $w ? $w : 236;
$escape = isset($escape) ? $escape : false;
$all = isset($all) ? $all : false;
$output = '';

if($data){
	App::import('Helper','Resize');
	$resizer = new ResizeHelper();
	foreach($data as $it){
		$hasLink = isset($it[$model]['enlace']) && strlen($it[$model]['enlace']) > 7;
		$permanente = $it[$model]['activo'] && ((!isset($it[$model]['caducidad']) || is_null($it[$model]['caducidad'])));
		$vigente =  $it[$model]['activo'] && isset($it[$model]['caducidad']) && (!is_null($it[$model]['caducidad'])) && (time() < strtotime($it[$model]['caducidad']));

		if($permanente || $vigente || $all){
			$esFlash = low(strrchr($it[$model][$field],'.'))=='.swf';
			$newSize = $util->resize($it[$model][$field],$w);

			if($esFlash)
				$item = $html->tag('span',$util->swf($it[$model][$field],array('width'=>$newSize[0],'height'=>$newSize[1])),array('class'=>($hasLink ? '':'banner item')));
			else
				$item = $resize->resize($it[$model][$field],array('w'=>$newSize[0],'h'=>$newSize[1],'atts'=>array('class'=>$hasLink ? '':'banner item')));

			if($hasLink){ # Si tiene enlace
				$item = $html->link($item,$it[$model]['enlace'],array('title'=>$it[$model]['nombre'],'escape'=>false,'target'=>'_blank','class'=>'banner item'));
			} elseif($model == 'Promotion') {
				$item = $html->link($item,array('controller'=>'promotions','action'=>'ver',$it[$model]['slug']),array('title'=>$it[$model]['nombre'],'escape'=>false,'target'=>'_blank','class'=>'banner item'));
			}

			$output.= $item;
		}
	}
}

echo $escape ? htmlspecialchars($output,ENT_QUOTES,'UTF-8'):$output;

?>