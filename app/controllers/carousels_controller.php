<?php
App::import('Controller','_base/Npimgs');
class CarouselsController extends NpimgsController{
	var $name = 'Carousels';
	var $ts = 'Carrusel';
	var $uses = array('Carousel');
}
?>