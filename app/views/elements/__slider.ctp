<?php
$id = isset($id) ? $id : 'roller';
$model = isset($model) ? $model : $_m[0].'img';
if(isset($titlemodel)){ if(!isset($title)) $title = true; } else { $titlemodel = $model; }
$title = isset($title) ? (is_string($title) ? $title : 'nombre') : false;
$enlace = isset($enlace) ? $enlace : false; // Nombre del campo que tiene el enlace
$element = isset($element) ? $element : false;
$redirect = isset($redirect) ? $redirect : array(); // Array URL
$zoom = isset($zoom) ? $zoom : true; // Se abre en Lightbox?
$w = isset($w) ? $w : false;
$h = isset($h) ? $h : 90;
$display = isset($display) ? $display : 'src'; // Campo imagen

$params = isset($params) ? $util->named($params) : '';
$data = isset($data) ? $data : $this->requestAction('/'.Inflector::tableize($model).'/last/activo:1'.$params);

$dinamic = array(); // Contiene los campos que serán reemplazados por item en el FOR
if($data){
	$datasize = sizeof($data);
	
	foreach($redirect as $idx => $param){
		if(strpos($param,':')===0){
			$dinamic[] = substr($param,1);
			unset($redirect[$idx]);
		}
	}
	
	echo $html->div(null,null,array('id'=>$id));
	
	for($i=0; $i < $datasize; $i++){
		$caption = '';
		
		if(isset($data[$i][$model]))
			$it = $data[$i][$model];
		elseif(isset($data[$i][$display]))
			$it = $data[$i];
		else
			continue;
			
		if($esFlash = strtolower(strrchr($it[$display],'.'))=='.swf'){
			$newSize = $util->resize($it[$display],0,$h);
			$flashAtts = array('width'=>$newSize[0],'height'=>$newSize[1]);
		}

		$className = ($zoom ? 'pulsembox ' : '');
		
		$linkAtts = array('class'=>$className, 'title' => isset($data[$i][$titlemodel]['nombre']) ? str_replace('"','',_dec($data[$i][$titlemodel]['nombre'])) : '');
		$noFlashAtts = array();
		$atts = array(
			'id' => 'sgItem_'.$i,
			'class' => 'sgItem '.($i+1==$datasize ? 'omega ':''),
		);

		//// URL
		$url = false;

		if($enlace && isset($it[$enlace]) && $it[$enlace]){
			$url = $enlace;
			$linkAtts['target'] = '_blank';
		} elseif($redirect) {
			$url = $redirect;
			foreach($dinamic as $param){
				if(isset($it[$param]) && $it[$param])
					$url[] = $it[$param];
			}
		} else { /// NO URL
			
			if($esFlash){
				$flashAtts = am($flashAtts,$atts);
			} else {
				if($zoom){
					$linkAtts['rel'] = $id;
					$url = '/'.$it[$display];
				} else {
					$noFlashAtts = $atts;
				}
			}
		}

		if($esFlash){
			$th = $util->swf($it[$display],$flashAtts);
		} else {
			$th = $resize->resize($it[$display],array('h'=>$h,'atts'=>$noFlashAtts));
		}
		
		if($title && isset($data[$i][$titlemodel][$title]) && $data[$i][$titlemodel][$title]){
			if($url && !$zoom)
				$caption = $html->link($data[$i][$titlemodel][$title],$url,array('class'=>'caption'));
			else
				$caption = $html->tag('span',$data[$i][$titlemodel][$title],array('class'=>'caption'));
			
		}
		
		/////

		# Si tiene enlace
		if($element && file_exists(VIEWS.'elements'.DS.$element.'.ctp')){
			echo $this->element($element,am(compact('th','url','atts','linkAtts','esFlash'),array('item'=>$data[$i],'idx'=>$i)));
		} else {
			if($url){
				$linkAtts['class'] = $atts['class'].$className;
				$atts = am($atts,$linkAtts);
				echo $html->link($th.$caption,$url,$atts);
			} else
				echo $th;
		}
	}
	
	echo '</div>', $moo->slider($id),$moo->pbox();
}
?>