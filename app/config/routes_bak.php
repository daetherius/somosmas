<?php
#Router::connect('/:lang/:prefix/:controller/:action/*',array('lang'=>null,'prefix'=>null,'controller'=>'inicio','action'=>'index'),array('lang' => '[a-z]{3}','prefix'=>'admin|member'));
$regex = array(
	'category'=>'[0-9]+_[a-zA-Z0-9\-]+',
	'program'=>'([0-9]+_[a-zA-Z0-9\-]+)?',
	'type'=>'[a-zA-Z]*'
);
$extraparams = array_keys($regex);

Router::connect('/:category',array('controller'=>'categories'),am(array('pass'=>$extraparams),$regex));
Router::connect('/:category/:program',array('controller'=>'categories'),am(array('pass'=>$extraparams),$regex));
Router::connect(
	'/:category/:program/:type',
	array('controller'=>'categories'),
	am(array('pass'=>$extraparams),$regex)
);

Router::connect(
	'/:category/:program/:type/:action/*',
	array('controller'=>'categories'),
	am(array('pass'=>$extraparams),$regex)
);

Router::connect(
	'/:category/:program/:action/*',
	array('controller'=>'categories'),
	am(array('pass'=>$extraparams),$regex)
);
foreach(Configure::read('Site.menu') as $controller => $alias){
	$alias = is_array($alias) ? $alias[0] : $alias;
	Router::connect('/'.$alias,array('controller'=>$controller,'action'=>'index'));
	Router::connect('/'.$alias.'/:action/*',array('controller'=>$controller,'action'=>':action'));
	Router::connect('/admin/'.$alias,array('controller'=>$controller,'action'=>'index','admin'=>1));
	Router::connect('/admin/'.$alias.'/:action/*',array('controller'=>$controller,'action'=>':action','admin'=>1));
}

Router::connect('/',array('controller'=>'inicio','action'=>'index'));
Router::connect('/registro/',array('controller'=>'members','action'=>'registro'));
Router::connect('/login/',array('controller'=>'members','action'=>'login'));
Router::connect('/logout/',array('controller'=>'members','action'=>'logout'));

Router::connect('/panel', array('controller' => 'users', 'action' => 'dashboard','admin'=>1));
Router::connect('/panel/logout',array('controller'=>'users','action'=>'logout','admin'=>1));
Router::connect('/panel/login',array('controller'=>'users','action'=>'login','admin'=>1));

Router::connectNamed(array('category','type','program','msg','page','limit','activo','tipo','favorito','detalle'),array('default'=>true));
?>