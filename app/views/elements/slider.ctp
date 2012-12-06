<?php
$id = isset($id) ? $id : 'roller';
$model = isset($model) ? $model : $_m[0].'img';
$srcmodel = isset($srcmodel) ? $srcmodel : $model;
if(isset($titlemodel)){ if(!isset($title)) $title = true; } else { $titlemodel = $model; }
$title = isset($title) ? (is_string($title) ? $title : 'nombre') : false;
$display = isset($display) ? $display : 'src'; // Campo imagen
$enlace = isset($enlace) && $enlace ? (is_string($enlace) ? $enlace : 'enlace') : false; // Nombre del campo que tiene el enlace
$element = isset($element) ? $element : false; // Nombre del elemento para renderizar. Vars que se pasan: $it, $model, $th, $url, $atts, $linkAtts, $esFlash
$redirect = isset($redirect) ? ((!(is_string($redirect) || is_array($redirect))) && $redirect ? array('controller'=>Inflector::tableize($model),'action'=>'ver',':slug') : $redirect) : array(); // Array URL

$zoom =  $redirect ? false : (isset($zoom) ? $zoom : true); // Se abre en Lightbox?
$w = isset($w) ? $w : false;
$h = isset($h) ? $h : 90;
$min = isset($min) ? $min : 2;

$params = isset($params) ? $util->named($params) : '';
$data = isset($data) ? $data : $this->requestAction('/'.Inflector::tableize($model).'/last/recursive:0/activo:1'.$params);

$dinamic = array(); // Contiene los campos que serán reemplazados por item en el FOR

if($data){
	$datasize = sizeof($data);
	if($min && $datasize < $min) return;

	foreach($redirect as $idx => $param){
		if(strpos($param,':')===0){
			$dinamic[$idx] = substr($param,1);
			unset($redirect[$idx]);
		}
	}
	
	echo $html->div(null,null,array('id'=>$id));
	
	for($i=0; $i < $datasize; $i++){
		$src = '';
		$caption = '';
		$it = $data[$i];
		$linkAtts = array();
		$atts = array(
			'id' => 'sgItem_'.$i,
			'class'=>'sgItem'.($i+1==$datasize ? ' omega':'').($zoom ? ' pulsembox' : '')
		);

		/// Adecuación para cuando data es tiene array simple
		if(isset($it[$display])) $it = array($srcmodel => $it);
			
		//// Title
		if($title && isset($it[$titlemodel][$title]) && $it[$titlemodel][$title]){
			$caption = $it[$titlemodel][$title];
			$linkAtts['title'] = str_replace('"','',_dec($caption));
		}
			
		/// Src
		if(isset($it[$srcmodel][$display]) && $it[$srcmodel][$display] && file_exists(WWW_ROOT.$it[$srcmodel][$display])){
			$src = $it[$srcmodel][$display];
		} elseif(isset($it[$model.'portada'][$display]) && $it[$model.'portada'][$display] && file_exists(WWW_ROOT.$it[$model.'portada'][$display])){
			$src = $it[$model.'portada'][$display];
		} else
			continue;
		
		if($esFlash = strtolower(strrchr($src,'.'))=='.swf'){
			$newSize = $util->resize($src,0,$h);
			$th = $util->swf($src,array('width'=>$newSize[0],'height'=>$newSize[1]));
		} else {
			$th = $resize->resize($src,array('h'=>$h));
		}

		//// URL
		$url = false;
		
		if($zoom){
			if(!$esFlash){
				$linkAtts['rel'] = $id;
				$url = '/'.$src;
			}
		} else {
			if($enlace && isset($it[$model][$enlace]) && $it[$model][$enlace]){
				$url = $enlace;
				$linkAtts['target'] = '_blank';
				
			} elseif($redirect) {
				$url = $redirect;
				
				foreach($dinamic as $idx => $param){
					$dinamicmodel = $model;
					if(strpos($param,'.')!== false){
						$dinamicmodel = strtok($param,'.');
						$param = strtok('.');
					}
					
					if(isset($it[$dinamicmodel][$param]) && $it[$dinamicmodel][$param])
						$url[$idx] = $it[$dinamicmodel][$param];
				}
			}	
		}
		
		if($caption){ $caption = $html->tag('span',$caption,array('class'=>'caption')); }
		
		/////

		# Si tiene enlace
		if($element && file_exists(VIEWS.'elements'.DS.$element.'.ctp')){
			echo $this->element($element,am(compact('it','model','src','th','url','atts','linkAtts','esFlash'),array('item'=>$it,'idx'=>$i)));
		} else {
			if($url){
				echo $html->link($th.$caption,$url,am($atts,$linkAtts));
			} else {
				echo $html->div(null,$th.$caption,$atts);
			}
		}
	}
	
	echo '</div>', $moo->slider($id),$moo->pbox();
}
?>