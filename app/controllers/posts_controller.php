<?php
App::import('Controller','_base/Timed');
class PostsController extends TimedController{
	var $name = 'Posts';
	var $ts = 'Noticias';
	var $pageTitle = 'Noticias';
	var $uses = array('Post','Postimg','Comment');

/*
	function admin_agregar() {
		if(!empty($this->data)){
			$tags = $this->data['Tag'];unset($this->data['Tag']);
			
			if($this->m[0]->saveAll($this->data,array('validate'=>true))){
				$this->Tag->savehabtm($tags,$this->m[0]->id);
				$this->redirect(array('action'=>'index','admin'=>1,'msg:oksave'));		
			}

		} else {
			/*** TAGS ***
			if(isset($this->m[0]->hasAndBelongsToMany['Tag'])){
				$tags = $this->m[0]->Tag->find(null,'list');
				$this->m[0]->clean($tags,true);
				$this->set(compact('tags'));
			}
			/************

			if($this->m[0]->hasField('activo')) $this->data[$this->uses[0]]['activo'] = 1;
			if($this->m[0]->hasField('layout')) $this->data[$this->uses[0]]['layout'] = 'left';
		}
			
	}
	
	function admin_editar($id) {
		$id = $this->_checkid($id);
		$this->m[0]->id = $id;
		$this->m[0]->recursive = 0;

		if(empty($this->data)){
			$this->data = $this->m[0]->read();
			$this->m[0]->clean($this->data,true);
			
			/*** TAGS ***
			if(isset($this->m[0]->hasAndBelongsToMany['Tag'])){
				$tags = $this->m[0]->Tag->find_(null,'list');
				$this->m[0]->clean($tags,true);
				$this->set(compact('tags'));
			}
			/************

		} else {
			$tags = $this->data['Tag'];unset($this->data['Tag']);
			if($this->m[0]->saveAll($this->data)){
				$this->Tag->savehabtm($tags,$this->m[0]->id);
				$this->redirect(array('action'=>'index','admin'=>1,'msg:oksave'));
			}
		}
	}
*/
		
	function admin_export(){ $this->_export(array('nombre','descripcion','comment_count')); }
}
?>