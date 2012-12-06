<?php
App::import('Controller','_base/Timed');
class AchievementsController extends TimedController{
	var $name = 'Achievements';
	var $ts = 'Logros';
	var $pageTitle = 'Logros';
	var $uses = array('Achievement','Category','Comment');

	function admin_export(){ $this->_export(array('nombre','descripcion','comment_count')); }
}
?>