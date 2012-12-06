<?php
App::import('Controller','_base/Imgs');
class AchievementimgsController extends ImgsController{
	var $name = 'Achievementimgs';
	var $uses = array('Achievementimg','Achievement');
}
?>