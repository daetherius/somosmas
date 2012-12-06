<?php
App::import('Controller','_base/Abcs');
class CommentsController extends AbcsController{
	var $name = 'Comments';
	var $ts = 'Comentarios';
	var $uses = array('Comment','Post');
	var $paginate = array('Comment'=>array('limit' => 20));
	
	function publicar() {
		if(!empty($this->data)){
			$this->m[0]->set($this->data);# Seteamos para validar
			if($this->m[0]->validates()){
				if(!$this->m[0]->save($this->data)){
					$this->set('ajax','Hubo un problema al publicar su comentario.');
				} else {
					$this->m[0]->recursive = -1;
					$comm = $this->m[0]->read();
					$this->set('data',$comm['Comment']);
					$this->render('/elements/comment');
				}
			} else {
				$this->set('errors',$this->Comment->invalidFields());
				$this->render('form');
			}
		}
	}
}
?>