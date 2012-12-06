<?php
$wide = isset($wide) && $wide ? 'wide':'';
$sub = isset($sub) ? $sub : false;
$hdrclass = '';

if($this->params['controller'] == 'categories'){
	if(isset($sectionHdr) && $sectionHdr){
		$_ts = $resize->resize($sectionHdr,array('w'=>960,'h'=>115,'fill'=>true));
		$hdrclass = 'customhdr';
	} else {
		$_ts = $_category['Category']['nombre'];
	}
}

if(isset($header)){
	if(!$header){
		$header = '';
	
	} elseif(is_string($header)) {
		$header = $html->div('sectionHdr '.$hdrclass,$header);
	
	} elseif(is_array($header)) {
		$text = $header['text'];
		unset($header['text']);
		$header = $html->div('sectionHdr '.$hdrclass,$html->link($text,$header));
	}
} else {
	$header = $html->div('sectionHdr '.$hdrclass,$_ts);
}

echo
	$header,
	$html->div('content'.$wide),
	$html->div('pad');

if($sub){
	echo
		$html->div('clear'),
		$html->div('nosubsidebar');
}
?>