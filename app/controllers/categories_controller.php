<?php
App::import('Controller','_base/Labels');
class CategoriesController extends LabelsController {
	var $name = 'Categories';
	var $ts = 'Programas';
	var $uses = array('Category','Timeline','Poll');
	var $_cid = false;
	var $_category = false;
	var $_program = false;

	function autoselect(){
		$redirect = false;
		
		if(!(isset($this->params['category']) && $this->params['category'])){
			$category = $this->Category->find_(array('contain'=>false,'conditions'=>array('parent_id'=>null)),'first');
		} else {
			$cid = (int)$this->params['category'];
			$category = $this->Category->find_(array($cid, 'contain'=>false));
		}

		if($category){
			$this->_cid = $category['Category']['id'];
			$this->_category = $category;
		}
		
		if($this->_cid && $this->_category){
			if(!(isset($this->params['program']) && $this->params['program'])){
				$program = $this->Category->find_(array('contain'=>false,'conditions'=>array('parent_id'=>$this->_cid)),'first');
				$redirect = true;
			} else {
				$pid = (int)$this->params['program'];
				$program = $this->Category->find_(array($pid, 'contain'=>false),'first');
			}

			$this->_program = $program;
			
			if($this->_category['Category']['src']);
				$this->set('sectionHdr',$this->_category['Category']['src']);
		}
		
		if($this->_program){
			$poll = $this->Poll->find_(array(
				'conditions'=>array(
					'category_id'=>$this->_program['Category']['id']
				),
				'contain'=>array('Question'=>array('Answer'))
			),'first');
			
			if($poll){
				$pid = $poll['Poll']['id'];
				$this->Poll->clean($poll,true);
				$qids = Set::extract($poll,'/Question/id');
				$ip = inet_ptod($this->RequestHandler->getClientIP());
				
				if($this->Poll->Visitor->find_(array('contain'=>false,'conditions'=>array('ip'=>$ip,'item_id'=>$pid,'item'=>'Poll')),'count')){
					$poll = false;
				} else {
					$answered = $this->Poll->Visitor->find_(array(
						'contain'=>array('Question'),
						'conditions'=>array('ip'=>$ip,'item'=>'Question','item_id'=>$qids),
						'fields'=>array('id','item_id')
					),'list');

					foreach($poll['Question'] as $idx => $quest){
						if(empty($quest['Answer']) || ($answered && in_array($quest['id'],$answered)))
							unset($poll['Question'][$idx]);
					}
					
					if(!$poll['Question']) $poll = false;
				}
			}

			$this->set(compact('poll'));
		}
		
		if($this->_program && $this->_category){
			if($redirect){
				$redirect = array('category'=>$this->_category['Category']['slug'],'program'=>$this->_program['Category']['slug']);
				$this->redirect($redirect);
			} else {
				$this->set('_category',$this->_category);
				$this->set('_program',$this->_program);
				
				if($this->action == 'ver'){
					if(!(isset($this->params['type']) && $this->params['type'])){
						$this->redirect(array('action'=>'index'));
					} else {
						$model = false;
						$sections = Configure::read('Sections');
						foreach($sections as $idx => $sect){
							if(strtolower($this->params['type']) == Inflector::slug($sect))
								$model = ucfirst($idx);
						}
					}
					
					if(!$model){
						$this->redirect(array('action'=>'index'));
					} else {
						$this->_model = $model;
						$this->set('_m',array($model));
					}
				}
			}
		} else {
			$poll = $items = $item = false;
			$this->set(compact('poll','items','item'));
			if($this->action == 'ver'){
				$this->redirect(array('action'=>'index'));
			} else {
				$this->render('index');
			}
		}
	}
	
	function index(){
		$cid = $poll = $items = false;
		
		$this->autoselect();

		$conds = array(
			'OR'=>array(
				array('Event.activo'=>1,'Event.category_id'=>$this->params['program']),
				array('Album.activo'=>1,'Album.category_id'=>$this->params['program']),
				array('Achievement.activo'=>1,'Achievement.category_id'=>$this->params['program']),
				array('Document.activo'=>1,'Document.category_id'=>$this->params['program']),
				array('Clink.activo'=>1,'Clink.category_id'=>$this->params['program']),
				array('Post.activo'=>1,'Post.category_id'=>$this->params['program'])
			)
		);
		
		if(isset($this->params['type']) && $this->params['type']){
			if($model = _typmap($this->params['type'],'type','model')){
				$conds = array(
					'Timeline.parent' => $model,
					$model.'.category_id' => $this->params['program'],
					$model.'.activo' => 1
				);
			}
		}
		
		$this->paginate['Timeline']['limit'] = 10;
		$this->paginate['Timeline']['contain'] = array(
			'Album',
			'Achievement',
			'Achievementportada',
			'Post',
			'Postportada',
			'Event',
			'Eventportada',
			'Post',
			'Document',
			'Doccategory',
			'Clink',
			'Linkcategory'
		);
		
		if($items = $this->paginate('Timeline',$conds)){
			foreach($items as $idx => $item){
				if($item['Timeline']['parent'] == 'albums'){
					$imgs = $this->Timeline->Album->getimgs($item['Timeline']['parent_id']);
					$items[$idx]['Albumimg'] = $imgs;
				}
			}
		}

		$this->set(compact('items'));
	}

	function ver($id = false) {
		$id = $this->_checkid($id);
		$this->autoselect();
		
		$this->Timeline->{$this->_model}->recursive = 1;
		
		if($item = $this->Timeline->{$this->_model}->read(null,$id)){
			$this->set(compact('item'));
			$this->pageTitle = $this->_program['Category']['nombre'].' - '.$item[$this->_model][$this->Timeline->{$this->_model}->displayField];
		}

		if(isset($this->Timeline->{$this->_model}->hasMany['Comment']) && isset($this->params['named']['reply']) && $this->params['named']['reply']){
			$this->data['Comment'] = array(
				'autor' => Configure::read('Site.name'),
				'email' => Configure::read('Site.email')
			);
		}

		$this->detour(Inflector::tableize($this->_model));
	}
}
?>