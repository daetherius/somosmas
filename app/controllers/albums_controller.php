<?php
App::import('Controller','_base/Timed');
class AlbumsController extends TimedController{
	var $name = 'Albums';
	var $ts = 'Galerías';
	var $pageTitle = 'Galería de Fotos';
	var $uses = array('Album','Category','Albumimg','Comment');

	function autoselect() {
		$_category = false;
		if(isset($this->params['category']) && $this->params['category']){
			$cid = $this->_checkid($this->params['category']);
			$_category = $this->Category->find_(array($cid, 'contain'=>false));
		}
		$this->set(compact('_category'));
	}
	
	function index() {
		$this->autoselect();
		$conds = array();
		
		if(isset($this->params['category']) && $cid = $this->_checkid($this->params['category'],false)){
			$conds['Pcategory.id'] = $cid;
		}

		if(isset($this->params['type']) && $this->params['type']){
			$conds['Album.tipo'] = ucfirst(strtolower($this->params['type']));
		}
		$this->paginate['Album']['limit'] = 9;
		$this->Album->unbindModel(array('hasOne'=>array('Timeline')),false);
		$items = $this->paginate($this->uses[0],$this->m[0]->find_($conds,'paginate'));
		$this->set(compact('items'));
	}

	function ver($id = false) {
		$id = $this->_checkid($id);
		$this->autoselect();
		$this->m[0]->recursive = 1;
		if($item = $this->m[0]->read(null,$id)){
			$this->set(compact('item'));
			$this->set('currentCategory', $item[$this->m[0]->categoryModel] ? $item[$this->m[0]->categoryModel] : false);
			$this->set('path',$this->m[0]->{$this->m[0]->categoryModel}->getpath($item[$this->m[0]->categoryModel]['id']));
			//$this->set('related',$this->m[0]->find_(array('contain'=>array($this->uses[0].'portada'),'field'=>'id','value'=>$item[$this->uses[0]]['id']),'neighbors'));
			$this->pageTitle = $item[$this->uses[0]][$this->m[0]->displayField];
		} else $this->redirect(array('action'=>'index'));
	}


}
?>