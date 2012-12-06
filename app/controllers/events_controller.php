<?php
App::import('Controller','_base/Timed');
class EventsController extends TimedController{
	var $name = 'Events';
	var $ts = 'Actividades';
	var $t = 'Actividad';
	var $pageTitle = 'Actividades';
	var $uses = array('Event','Eventimg','Comment');

}
?>