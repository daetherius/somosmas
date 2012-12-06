<?php
if($item){
	$h = isset($h) && $h ? 'h' : '';
	$model = isset($model) ? $model : $_m[0];
	$mini = isset($mini) ? $mini : false;
	$layout = isset($layout) ? $layout : array();
	
	$class = '';
	$th = array(
		'img'=>false,
		'nombre'=>false,
		'fecha'=>false,
		'desc'=>false,
		'comments'=>false,
		'mas'=>false
	);
	
	if($layout){
		$fill = array_fill(0,sizeof($layout),false);
		$th = array_combine($layout,$fill);
	}
	
	$url = array(
		'controller'=>Inflector::tableize($model),
		'action'=>'ver',
		isset($item[$model]['slug']) && $item[$model]['slug'] ? $item[$model]['slug'] : $item[$model]['id']
	);

	switch($model){
		case 'Podcast':
			$th['img'] = $html->div('thPodcast',$html->tag('p','Cargando...',array('id'=>'podPlayer_'.$item[$model]['id']))).
				$moo->player(false,$item[$model]['src'],array('id'=>'podPlayer_'.$item['Podcast']['id']));
		break;
		//////////
		case 'Category':
			$url = array('controller'=>'categories','category'=>$item[$model]['slug']);
		break;
		case 'Link':
			$url = $item[$model]['enlace'];
			
			$th['fecha'] = '';
			$th['desc'] = $html->div('pBody tmce',''.strip_tags($util->txt($item[$model]['descripcion']),'<b><i><strong><em>'));
			
			$th['nombre'] = $html->tag('h2',$html->link($item[$model]['nombre'],$url),array('class'=>'pTitle', 'target'=>'_blank','rel'=>'nofollow'));
			$th['img'] = $util->th($item,$model,array('w'=>164,'h'=>128,'fill'=>true,'url'=>$url,'atts'=>array('target'=>'_blank','rel'=>'nofollow')));
			$th['maslink'] = $html->div('more',$html->link('Leer más',$url,array('target'=>'_blank','rel'=>'nofollow')));
		break;
		//////////
		case 'Magazine':
			$th['img'] = $util->th($item,$model,array('w'=>128,'h'=>168,'fill'=>true));
		break;
		//////////
		case 'Event':
		case 'Achievement':
			
			$th['img'] = $util->th($item,$model,array('w'=>123,'h'=>82,'fill'=>true));
			$th['fecha'] = $html->tag('p',$util->fdate('s',$item[$model]['created']),array('class'=>'pDate'));
			
			if($item[$model]['descripcion'])
				$th['mas'] = 'Leer más';
				
		break;
		//////////
		case 'Album':
			if($item[$model]['tipo']=='Fotos')
				$th['img'] = $util->th($item,$model,array('w'=>180,'h'=>128,'fill'=>true,'url'=>$url));
			else {
				if($item[$model]['src'])
					$th['img'] = $util->th($item[$model],false,array('w'=>180,'h'=>128,'fill'=>true,'url'=>$url));
				else 
					$th['img'] = $util->th(array('src'=>'img/vdefault.jpg'),false,array('w'=>180,'h'=>128,'fill'=>true,'url'=>$url));
			}
				
			$th['desc'] = '';
			$th['fecha'] = '';
			$th['mas'] = false;
		break;
	
		//////////
	
		case 'Post':
		default:
		break;
	}

	if($mini) $th = array('nombre'=>$th['nombre']);
	
	foreach($th as $key => $value){
		if($value === false){
			switch($key){
				case 'img':
					$th[$key] = $util->th($item,$model,array('w'=>180,'h'=>128,'fill'=>true,'url'=>$url));
				break;

				case 'nombre':
					$th[$key] = $html->tag('h2',$html->link($item[$model]['nombre'],$url),array('class'=>'pTitle'));
				break;
				
				case 'fecha':
					$th[$key] = $html->tag('p',$util->fdate('s',$item[$model]['created']),array('class'=>'pDate'));
				break;
				
				case 'desc':
					$th[$key] = $html->div('pBody tmce',''.strip_tags($util->trim($item[$model]['descripcion']),'<b><i><strong><em>'));
				break;
				
				case 'comments':
					if(isset($item['Comment']) && $item['Comment'])
						$th[$key] = $html->link(sizeof($item['Comment']),$url,array('class'=>'pComments'));
				break;
			}
		} elseif($value && $key == 'mas')
			$th['mas'] = $html->div('more',$html->link($th['mas'],$url));
	}
	
	echo $html->div('thumb '.$class.' '.$h.' '.low($model), implode('',$th));

} else
	echo $html->para('noresults','No hay elemento para mostrar');
?>