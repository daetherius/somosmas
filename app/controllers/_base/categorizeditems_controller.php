<?php
App::import('Controller','_base/Items');
class CategorizeditemsController extends ItemsController{
	function ver($id = false) {
		if(empty($this->params['category']) && empty($this->params['program'])){
			$redirect_item = $this->m[0]->find_(array($id,'contain'=>array('Category.slug','Pcategory.slug'),'fields'=>array('id','slug','category_id')),'first');
			$sections = Configure::read('Sections');
			$this->redirect(array(
				'controller'=>'categories',
				'action'=>'ver',
				'program'=>$redirect_item['Category']['slug'],
				'category'=>$redirect_item['Pcategory']['slug'],
				'type'=>Inflector::slug($sections[strtolower($this->uses[0])]),
				$redirect_item[$this->uses[0]]['slug']
			));
		}

		$id = $this->_checkid($id);
		$this->m[0]->recursive = 1;
		if($item = $this->m[0]->read(null,$id)){
			$this->set(compact('item'));
			$this->set('currentCategory', $item[$this->m[0]->categoryModel] ? $item[$this->m[0]->categoryModel] : false);
			$this->set('path',$this->m[0]->{$this->m[0]->categoryModel}->getpath($item[$this->m[0]->categoryModel]['id']));
			//$this->set('related',$this->m[0]->find_(array('contain'=>array($this->uses[0].'portada'),'field'=>'id','value'=>$item[$this->uses[0]]['id']),'neighbors'));
			$this->pageTitle = $item[$this->uses[0]][$this->m[0]->displayField];
		} else $this->redirect(array('action'=>'index'));
	}
	
	function categoria($id = false) {
		$id = $this->_checkid($id);
		$this->m[0]->recursive = -1;
		if($category = $this->m[0]->{$this->m[0]->categoryModel}->read(null,$id)){
			$this->set('currentCategory',$category[$this->m[0]->categoryModel]);
			$this->set('path',$this->m[0]->{$this->m[0]->categoryModel}->getpath($category[$this->m[0]->categoryModel]['id']));
			$this->set('items',$this->paginate($this->uses[0], $this->m[0]->find_(array($this->uses[0].'.'.low($this->m[0]->categoryModel).'_id'=>$category[$this->m[0]->categoryModel]['id']),'paginate')));
			$this->pageTitle = $category[$this->m[0]->categoryModel][$this->m[0]->{$this->m[0]->categoryModel}->displayField];
		} else $this->redirect(array('action'=>'index'));
		$this->detour('','index');
	}

	function admin_agregar() {
		$isPost = !empty($this->data);
		$categmodel = strtolower($this->m[0]->categoryModel);
		
		if($isPost && isset($this->data[$this->uses[0]][$categmodel])){
			if(!$this->data[$this->uses[0]][$categmodel])
				unset($this->data[$this->m[0]->categoryModel]);
		}
		
		$categories = $this->m[0]->{$this->m[0]->categoryModel}->generatetreelist(null,'{n}.'.$this->m[0]->categoryModel.'.id','{n}.'.$this->m[0]->categoryModel.'.nombre','—');
		$this->m[0]->clean($categories,true);
		
		if($categmodel == 'category'){
			$sub = '';
			$aux = array();
			
			foreach($categories as $key => $value){
				if(strpos($value,'—')===0){
					$aux[$sub][$key] = mb_substr($value,1);
				} else {
					$sub = $value;
				}
			}
			$categories = $aux;
		}

		$this->set(Inflector::tableize($this->m[0]->categoryModel),$categories);
		
		parent::admin_agregar();
		
		if(!isset($this->data[$this->uses[0]][$categmodel]))
			$this->data[$this->uses[0]][$categmodel] = isset($categories) && $categories ? 0:1;
	}
	
	function admin_editar($id) {
		$isPost = !empty($this->data);
		$categmodel = strtolower($this->m[0]->categoryModel);

		if($isPost && isset($this->data[$this->uses[0]][$categmodel])){
			if(!$this->data[$this->uses[0]][$categmodel])
				unset($this->data[$this->m[0]->categoryModel]);
		}

		$categories = $this->m[0]->{$this->m[0]->categoryModel}->generatetreelist(null,'{n}.'.$this->m[0]->categoryModel.'.id','{n}.'.$this->m[0]->categoryModel.'.nombre','—');
		$this->m[0]->clean($categories,true);

		if($categmodel == 'category'){
			$sub = '';
			$aux = array();
			
			foreach($categories as $key => $value){
				if(strpos($value,'—')===0){
					$aux[$sub][$key] = mb_substr($value,1);
				} else {
					$sub = $value;
				}
			}
			$categories = $aux;
		}
		
		$this->set(Inflector::tableize($this->m[0]->categoryModel),$categories);
		
		parent::admin_editar($id);

		if(!isset($this->data[$this->uses[0]][$categmodel]))
			$this->data[$this->uses[0]][$categmodel] = isset($categories) && $categories ? 0:1;
	}
}
?>