<?php
App::import('Controller','_base/Labels');
class AnswersController extends LabelsController {
	var $name = 'Answers';
	var $ts = 'Respuesta de Encuesta';
	var $uses = array('Answer');
}
?>