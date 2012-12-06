<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<title>Panel | <?=$title_for_layout?> | <?=$sitename_for_layout?></title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="Title" content="<?=$sitename_for_layout?>" />
<meta name="Author" content="Pulsem" />
<meta name="Generator" content="daetherius" />
<meta name="Language" content="Spanish" /> 
<meta name="Robots" content="noindex,nofollow" />
<?=$html->css(array('generic','admin','pulsembox'))?> 
</head>
<body class="admin">
<?php
echo
	$html->div('nofooter'),
		$html->div('header'),
			$html->link('Cerrar Sesión',array('admin'=>1,'controller'=>'users','action'=>'logout'),array('class'=>'logout','title'=>'Finalizar sesión como administrador','escape'=>false)),
			$html->link($html->image('admin/logo.jpg',array('alt'=>$sitename_for_layout)),'/',array('id'=>'logo','title'=>'Ir al Inicio')),
			$html->tag('span','Panel de Administración',array('id'=>'title')),
		'</div>';
			
	if(isset($sAdmin) && $sAdmin){
		$adm = array('action'=>'index','admin'=>true);
	echo
		$html->div('sidebar'),

			$html->link($html->tag('span','Programas',	array('class'=>'tags')),	am(array('controller'=>'categories'),$adm)),
			'<br/>',
			$html->link($html->tag('span','Encuestas',	array('class'=>'polls')),	am(array('controller'=>'polls'),$adm)),
			$html->link($html->tag('span','Actividades',array('class'=>'posts')),	am(array('controller'=>'events'),$adm)),
			$html->link($html->tag('span','Artículos',	array('class'=>'posts')),	am(array('controller'=>'posts'),$adm)),
			$html->link($html->tag('span','Galerías',	array('class'=>'photos')),	am(array('controller'=>'albums'),$adm)),
			$html->link($html->tag('span','Logros',	array('class'=>'posts')),	am(array('controller'=>'achievements'),$adm)),
			$html->link($html->tag('span','Ligas',		array('class'=>'links')),	am(array('controller'=>'clinks'),$adm)),
			$html->link($html->tag('span','Descargables',array('class'=>'')),		am(array('controller'=>'documents'),$adm)),
			$html->link($html->tag('span','Comentarios',array('class'=>'comments')),am(array('controller'=>'comments'),$adm)),
			'<br/>',
			$html->link($html->tag('span','Cartelera',	array('class'=>'')),		am(array('controller'=>'boards'),$adm)),
			$html->link($html->tag('span','Enlaces Generales',array('class'=>'links')),am(array('controller'=>'links'),$adm)),
			$html->link($html->tag('span','Carrusel',	array('class'=>'photos')),	am(array('controller'=>'carousels'),$adm)),
			$html->link($html->tag('span','Banners',	array('class'=>'banners')),	am(array('controller'=>'banners'),$adm)),
			$html->link($html->tag('span','Nosotros',	array('class'=>'pages')),	am(array('controller'=>'about'),$adm)),
			'<br/>',
			$html->link($html->tag('span','Categ. Descargables',	array('class'=>'tags')),am(array('controller'=>'doccategories'),$adm)),
			$html->link($html->tag('span','Categ. Enlaces',		array('class'=>'tags')),am(array('controller'=>'linkcategories'),$adm)),
			'<br/>',
			$html->link($html->tag('span','Usuarios',	array('class'=>'users')),		am(array('controller'=>'users'),$adm)),

			///////

			$html->div('support'),
				$html->para('title','Asesoría en Línea');
				
				if(Configure::read('debug')==0){
					echo
						$html->tag('iframe','',array(
							'src'=>'http://www.google.com/talk/service/badge/Show?tk=z01q6amlq9vtqkeirle2urqs13ctijj198eaucsr1halab2aas76nno0m7ncklgss1t6rpru6qt0l80h8n5bga272kcu5023gi8jh3rv7ndo96jpmg3i5gk74dlr8420275jj860hab7l16d2d1c03mihg46qg6pos9nmb5r9rkm26edomujo35psrs4agnaof4&amp;w=180&amp;h=60',
							'width'=>180,
							'frameborder'=>'0',
							'allowtransparency'=>'true'
						)),
						$html->tag('iframe','',array(
							'src'=>'http://www.google.com/talk/service/badge/Show?tk=z01q6amlq54stgfe6rigr5aqk33infgrgsba6r7igs3lb70757t68rd016q45aa8u1k7uasqa4o50ajsvakh3a49stiuo3vehl19vdpdslrpm9mjichpmk25atonb6pcvo12dmkluc6rktjffqi6kchhbtt7tkfh6326cpqdd0fr81trhc5djiq2o1bq0onrr98&amp;w=180&amp;h=60',
							'width'=>180,
							'frameborder'=>'0',
							'allowtransparency'=>'true'
						));
				}
				
			echo	 '</div>',
		'</div>';
	}

	echo
		$html->div('content'.(isset($sAdmin) && $sAdmin ? ' logged':''), $content_for_layout),
		$html->div('cleaner',''),
	'</div>',
	$html->div('footer'),
		$html->link('','http://pulsem.mx',array('id'=>'pulsem','title'=>'Web + Identidad + Consultoría')),
		$html->para('','Web | Identidad | Consultoría'),
	'</div>',
	
	///////	

	$html->script(array('moo13','moo13m','utils','pulsembox')),
	$scripts_for_layout,
	$moo->writeBuffer(array('onDomReady'=>false)),
	$moo->highlight($highlight,1),
	$moo->pop($msg,1);
?>
</body>
</html>