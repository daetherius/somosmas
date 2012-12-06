<?php
$id = isset($id) && $id ? $id : 'carousel';
$model = isset($model) && $model ? $model : 'Carousel';
$size = isset($size) && $size ? explode('x',$size) : false;
$url = isset($url) && $url ? $url : false;
$conditions = isset($conditions) && $conditions ? $conditions : array();
$defaults = array('nav'=>'out');
$opts = isset($opts) && $opts ? am($defaults,$opts) : $defaults;

if($data = isset($data) && $data ? $data : $this->requestAction('/'.Inflector::tableize($model).'/last'.$util->named($conditions))){

	echo $html->div('showcase',null,array('id'=>$id));
	
	foreach($data as $snap){
		if(isset($snap[$model]['enlace']) && $snap[$model]['enlace'])
			echo $html->link(
				$size ? $resize->resize($snap[$model]['src'],array('w'=>$size[0],'h'=>$size[1])) : $html->image('/'.$snap[$model]['src']),
				$url ? $url : $snap[$model]['enlace'],
				array('target'=>'_blank','rel'=>'nofollow','class'=>'item')
			);
		else
			echo $size ? $resize->resize($snap[$model]['src'],array('w'=>$size[0],'h'=>$size[1],'atts'=>array('class'=>'item'))) : $html->image('/'.$snap[$model]['src'],array('class'=>'item'));
		
		echo $html->div('caption',''.isset($snap[$model]['descripcion']) ? $snap[$model]['descripcion'] : '');
	}
	echo '</div>';
	
	$moo->showcase($id,$opts);
}
?>