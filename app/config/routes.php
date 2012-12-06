<?php
#Router::connect('/:lang/:prefix/:controller/:action/*',array('lang'=>null,'prefix'=>null,'controller'=>'inicio','action'=>'index'),array('lang' => '[a-z]{3}','prefix'=>'admin|member'));
$sections = Configure::read('Sections');
foreach($sections as $idx => $sec) $sections[$idx] = Inflector::slug($sec);
$sections[] = '^$';
$typeregex = implode('|',$sections);

$regex = array(
	'category'=>'[0-9]+_[a-zA-Z0-9\-]+',
	'action'=>'ver|index',
	'program'=>'([0-9]+_[a-zA-Z0-9\-]+)?',
	'type'=>$typeregex
);
$extraparams = array_keys($regex);

Router::connect('/:category',array('controller'=>'categories'),$regex);
Router::connect('/:category/:program',array('controller'=>'categories'),$regex);
Router::connect(
	'/:category/:program/:type',
	array('controller'=>'categories'),
	$regex
);

Router::connect(
	'/:category/:program/:type/:action/',
	array('controller'=>'categories'),
	$regex
);
Router::connect(
	'/:category/:program/:type/:action/*',
	array('controller'=>'categories'),
	$regex
);

Router::connect(
	'/:category/:program/:action',
	array('controller'=>'categories'),
	$regex
);

Router::connect(
	'/:category/:program/:action/*',
	array('controller'=>'categories'),
	$regex
);

///// Galerías
$galregex = am($regex,array('type'=>'fotos|video|^$','category'=>'([0-9]+_[a-zA-Z0-9\-]+)?'));
Router::connect(
	'/galerias/:category',
	array('controller'=>'albums'),
	$galregex
);

Router::connect(
	'/galerias/:category/:type',
	array('controller'=>'albums'),
	$galregex
);

Router::connect(
	'/galerias/:type/:action/*',
	array('controller'=>'albums'),
	$galregex
);

Router::connect(
	'/galerias/:type',
	array('controller'=>'albums'),
	$galregex
);

Router::connect(
	'/galerias/:category/:type/:action/*',
	array('controller'=>'albums'),
	$galregex
);

Router::connect(
	'/galerias/:category/:action/*',
	array('controller'=>'albums'),
	$galregex
);

foreach(Configure::read('Site.routes') as $controller => $alias){
	$alias = is_array($alias) ? $alias[0] : $alias;
	Router::connect('/'.$alias,array('controller'=>$controller,'action'=>'index'));
	Router::connect('/'.$alias.'/:action/*',array('controller'=>$controller,'action'=>':action'));
	Router::connect('/admin/'.$alias,array('controller'=>$controller,'action'=>'index','admin'=>1));
	Router::connect('/admin/'.$alias.'/:action/*',array('controller'=>$controller,'action'=>':action','admin'=>1));
}

Router::connect('/',array('controller'=>'inicio','action'=>'index'));
Router::connect('/registro',array('controller'=>'members','action'=>'registro'));
Router::connect('/login',array('controller'=>'members','action'=>'login'));
Router::connect('/logout',array('controller'=>'members','action'=>'logout'));

Router::connect('/panel', array('controller' => 'users', 'action' => 'dashboard','admin'=>1));
Router::connect('/panel/logout',array('controller'=>'users','action'=>'logout','admin'=>1));
Router::connect('/panel/login',array('controller'=>'users','action'=>'login','admin'=>1));

Router::connectNamed(array('category','type','program','page','msg','limit','activo','tipo','favorito','detalle'),array('default'=>true));
?>