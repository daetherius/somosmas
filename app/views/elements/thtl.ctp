<?php
if($item){
	if(!(isset($model) && $model)){
		$keys = array_keys($item);
		$model = $keys[1];
	}
	
	$model = Inflector::classify($model);

	$class = '';
	$th = array(
		'nombre'=>false,
		'img'=>false,
		'fecha'=>false,
		'descripcion'=>false,
		'comments'=>false,
		'more'=>false
	);
	$url = array(
		'type'=>_typmap(Inflector::classify($item['Timeline']['parent']),'model','type'),
		'action'=>'ver',
		isset($item[$model]['slug']) && $item[$model]['slug'] ? $item[$model]['slug'] : $item[$model]['id']
	);

	switch($model){

		case 'Album':
			if($item[$model]['tipo']=='Video'){
				if($item[$model]['src'])
					$th['nombre'] = $util->th($item[$model],false,array('w'=>180,'h'=>128,'fill'=>true,'url'=>$url));
				else 
					$th['nombre'] = $util->th(array('src'=>'img/vdefault.jpg'),false,array('w'=>180,'h'=>128,'fill'=>true,'url'=>$url));
			
				$th['img'] = $html->tag('h3',$html->link($item[$model]['nombre'],$url),array('class'=>'pTitle'));
				$th['mas'] = 'Ver Video';
				
			} else {
				if($item['Albumimg']){
					foreach($item['Albumimg'] as $img)
						$th['descripcion'].= $html->link($resize->resize($img['Albumimg']['src'],array('h'=>120,'atts'=>array('alt'=>$util->trim($util->txt($img['Albumimg']['descripcion']))))),$url);
				}
	
				$th['img'] = '';
				$th['mas'] = 'Ver Fotos';
			}
			
			$th['descripcion'] = $html->div('albumMask',$th['descripcion']);
		break;

		//////////

		case 'Poll':
		break;

		//////////

		case 'Document':
			$url = array('controller'=>'documents','action'=>'download',$item['Document']['id']);
			$th['descripcion'] = '';
			$th['fecha'] = $html->para('pDate',$util->fdate('s',$item[$model]['created']).' '.$html->tag('span',$item['Doccategory']['nombre'],'pSubcategory'));
				
			$th['nombre'] = $html->tag('h3',$html->link($item['Document']['nombre'],$url,array('class'=>'document '.low(substr(strrchr($item['Document']['src'],'.'),1)))),'pTitle');
			$th['img'] = '';
		break;

		//////////
		
		case 'Clink':
			$url = $item[$model]['enlace'];
			
			if(trim($util->txt($item[$model]['descripcion'])))
				$th['descripcion'] = $html->div('pBody tmce',''.$util->txt($item[$model]['descripcion']));
			else
				$th['descripcion'] = '';
			
			$th['nombre'] = $util->th($item,$model,array('w'=>164,'h'=>128,'fill'=>true,'url'=>$url,'atts'=>array('target'=>'_blank','rel'=>'nofollow')));
			$th['img'] = $html->tag('h3',$html->link($item[$model]['nombre'],$url,array('target'=>'_blank','rel'=>'nofollow')),array('class'=>'pTitle'));
			$th['maslink'] = $html->div('more',$html->link('Ir al Sitio',$url,array('target'=>'_blank','rel'=>'nofollow')));
		break;

		//////////

		case 'Event':
		case 'Achievement':
		case 'Post':
			$th['mas'] = 'Leer más';
		default:
		break;
	}

	foreach($th as $key => $value){
		if($value === false){
			switch($key){
				case 'img':
					$th[$key] = $util->th($item,$model,array('w'=>164,'h'=>128,'fill'=>true,'url'=>$url));
				break;

				case 'nombre':
					$th[$key] = $html->tag('h3',$html->link($item[$model]['nombre'],$url),array('class'=>'pTitle'));
				break;
				
				case 'fecha':
					$th[$key] = $html->para('pDate',$util->fdate('s',$item[$model]['created']));
				break;
				
				case 'descripcion':
					$th[$key] = $html->div('pBody tmce',''.strip_tags($util->trim($item[$model]['descripcion']),'<b><i><strong><em>'));
				break;
				
				case 'comments':
					if(isset($item['Comment']) && $item['Comment'])
						$th[$key] = $html->link(sizeof($item['Comment']),$url,array('class'=>'pComments'));
				break;
			}
		} elseif($key == 'mas')
			$th['mas'] = $html->div('more',$html->link($th['mas'],$url));
	}
	
	echo $html->div('thumb h timeline '.$class.' '.low($model),implode('',$th));

} else
	echo $html->para('noresults','No hay elemento para mostrar');
?>