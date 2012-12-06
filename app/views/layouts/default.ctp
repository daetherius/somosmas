<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<title><?=$sitename_for_layout.($title_for_layout ? ' | '.$title_for_layout : '')?></title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="description" content="<?=$description_for_layout?>" />
<meta name="keywords" content="<?=$keywords_for_layout?>" />
<meta name="Title" content="<?=$sitename_for_layout?>" />
<meta name="Author" content="Pulsem" />
<meta name="Generator" content="daetherius" />
<meta name="Language" content="Spanish" /> 
<meta name="Robots" content="Index" />
<link href='http://fonts.googleapis.com/css?family=Days+One' rel='stylesheet' type='text/css'>
<?=$html->css(array('generic','main','pulsembox','mooshowcase'))?> 
</head>
<?php
echo
	$html->tag('body',null,'c_'.$this->params['controller'].' a_'.$this->params['action']),
		$html->div(null,null,array('id'=>'nofooter')),
			$html->div('behind',$html->div('',''),array('id'=>'behindGreen')),
			$html->div('behind','',array('id'=>'behindGrey')),
			$html->tag('h1',$html->link($sitename_for_layout,'/',array('title'=>$sitename_for_layout)),array('id'=>'logo')),
			$html->div(null,null,array('id'=>'header')),
				$html->div('sede',$_sede_full.''),
				$html->div(null,null,array('id'=>'headerInfo')),
					$html->link('facebook','http://facebook.com/pages/Somos-mas-haciendo-paz/101752749950715',array('class'=>'facebook','target'=>'_blank','rel'=>'nofollow')),
					$html->link('twitter','http://twitter.com/SomosMasHPaz',array('class'=>'twitter','target'=>'_blank','rel'=>'nofollow')),
					$html->link('youtube','http://youtube.com/somosmashaciendopaz',array('class'=>'youtube','target'=>'_blank','rel'=>'nofollow')),
				'</div>',
				$form->create(false,array('id'=>'sedeForm','url'=>$this->here)),
					$form->input('sede',array(
						'options'=>array(
							'Mérida'=>'Mérida',
							'Progreso'=>'Progreso',
							'Tizimin'=>'Tizimin'
						),
						'label'=>false,
						'empty'=>false,
						'default'=>'Mérida'
					)),
				$form->end('Cambiar Sede'),
			'</div>',
			$this->element('menu'),
			$html->div(null,$content_for_layout.'',array('id'=>'body')),
			$html->div(null,'',array('id'=>'cleaner')),
		'</div><!-- #nofooter -->',

		$this->element('footer'),
		$html->script(array('moo13','moo13m','utils','pulsembox','mooshowcase')),
		$scripts_for_layout,
		$moo->writeBuffer(array('onDomReady'=>false)),
		//$this->element('gfont',array('fonts'=>array('Cantarell','Droid+Serif'))),
	'</body>';
?></html>