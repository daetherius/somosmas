<?php
$model = isset($model) ? $model : $_m[0];
$field = 'src';
$header = isset($header) && $header ? $header : false;
$atts = isset($atts) ? $atts : array();
$grow = isset($grow) ? $grow : false;

if(isset($data) && $data){
	echo $html->div('inlineGallery',null,$atts);
	
	if($header)
		echo $html->tag('h1',$header,'pTitle');
	
	foreach($data as $it){
		$desc = $src = '';
		
		if(isset($it[$model]))
			$it = $it[$model];
		
		if(isset($it[$field]))
			$src = $it[$field];
		
		if(isset($it['descripcion']) && $it['descripcion'])
			$desc = $it['descripcion'];
		
		if($src && file_exists(WWW_ROOT.$src)){
			if($grow){
				$rel = $resize->resize($src,array('h'=>180,'urlonly'=>true));
				$rela = '';
				$class = '';
				$href = 'javascript:;';
			} else {
				$rel = '';
				$rela = 'pbox';
				$class = ' pulsembox';
				$href = '/'.$src;
			}
			
			echo $html->link($resize->resize($src,array('h'=>90,'atts'=>array('alt'=>$desc,'rel'=>$rel))),$href,array('class'=>'inlineGal'.$class,'rel'=>$rela));
		}
	}
	
	echo '</div>';
		
} else 
	echo $html->para('noresults','No hay elementos que mostrar');
?>