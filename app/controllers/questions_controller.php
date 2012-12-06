<?php
App::import('Controller','_base/Labels');
class QuestionsController extends LabelsController {
	var $name = 'Questions';
	var $ts = 'Preguntas de Encuesta';
	var $uses = array('Question');
}
?>