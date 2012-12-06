<?php
App::import('Controller','_base/Timed');
class PollsController extends TimedController{
	var $name = 'Polls';
	var $ts = 'Encuestas';
	var $uses = array('Poll','Question','Answer');
	var $test = true;

	function admin_respuestas($parent = false){
		if($parent = $this->_checkid($parent,false)){
			$question = $this->Question->find_(array($parent,'contain'=>false));
			$this->set('pollquestion',$question['Question']['nombre']);
			$this->set('pollid',$question['Question']['poll_id']);
		} else {
			$this->redirect($this->referer());
		}
		
		if(empty($this->data)){
			$this->set('orderdata',$this->Answer->find_(array(
				'conditions'=>array('question_id'=>$parent),
				'fields'=>array('id',$this->Answer->displayField,'votos','orden'),
				'contain'=>false,
			),'all+'));
		} else {
			foreach($this->data['Answer'] as $it){
				if($parent) $it['question_id'] = $parent;
				$this->Answer->create(false);
				$this->Answer->save($it);
			}
			$this->redirect(array('msg'=>'oksave'));
		}
	}

	function admin_activar($id) {
		$id = $this->_checkid($id);
		parent::admin_activar($id,true);
	}

	function vote() {
		$question = $answer = false;
		$isAjax = isset($this->params['isAjax']) && $this->params['isAjax'];
		
		if(isset($this->data['Question']) && $this->data['Question']){
			if(isset($this->data['Question']['ids']) && $this->data['Question']['ids']){
				reset($this->data['Question']['ids']);
				list($qid,$aid) = explode('_',key($this->data['Question']['ids']));
			} else {
				$qid = $this->data['Question']['qid'];
				$aid = $this->data['Question']['aid'];
			}

			if($qid)
				$question = $this->Poll->Question->find_(array($qid,'contain'=>array('Poll')));

			if($aid)
				$answer = $this->Poll->Question->Answer->find_(array($aid,'contain'=>false));
		}
		
		$ip = inet_ptod($this->RequestHandler->getClientIP());
		
		/// No ha contestado previamente la pregunta
		if($question && $answer && (!$this->Poll->Visitor->find_(array('conditions'=>array('ip'=>$ip,'item'=>'Question','item_id'=>$qid)),'count'))){
			/// +1
			$this->Poll->Question->Answer->id = $answer['Answer']['id'];
			if($this->Poll->Question->Answer->saveField('votos',$answer['Answer']['votos']+1) && (!$test)){
				$this->Poll->Visitor->create(false);
				$this->Poll->Visitor->save(array(
					'ip'=>$this->RequestHandler->getClientIP(),
					'item'=>'Question',
					'item_id'=>$question['Question']['id']
				));
			}

			/// Encuesta completada
			$answered = $this->Poll->Visitor->find_(array(
				'conditions'=>array(
					'ip'=>$ip,
					'item'=>'Question',
					'Question.poll_id'=>$question['Question']['poll_id']
				),
				'contain'=>array('Question')
			),'count');

			if((!$test) && $answered >= $question['Poll']['question_count']){
				$this->Poll->Visitor->create(false);
				$this->Poll->Visitor->save(array(
					'ip'=>$this->RequestHandler->getClientIP(),
					'item'=>'Poll',
					'item_id'=>$question['Question']['poll_id']
				));
				/*
				*/
			}
			$ajax = 'var answered = $("question_'.$question['Question']['id'].'"); answered.getNext(".question").reveal(); answered.nix();';
			
		} else {
			$ajax = 'alert("Ha ocurrido un problema. Intente de nuevo.");';
		}

		if($this->params['isAjax']){
			$this->set(compact('ajax'));
			$this->render('js');
		} else {
			$this->redirect($this->referer());exit;
		}
	}
	
	function getresults($id,$json = false){
		$id = $this->_checkid($id);
		$questions = $this->m[1]->find_(array('conditions'=>array('poll_id'=>$id),'contain'=>false));
		
		if($json){
			$resultsData = array();
			foreach($questions as $opt)
				$resultsData[] = $opt[$this->uses[1]]['id'].':'.$opt[$this->uses[1]]['votos'];
			return '{'.implode(',',$resultsData).'}';
			
		}else{
			$resultsData = '';
			$total = 0;
			
			foreach($questions as $opt)
				$total+= $opt[$this->uses[1]]['votos'];
			
			if($total > 0)
				foreach($questions as $opt)
					$resultsData.= $opt[$this->uses[1]]['opcion'].' = '.$opt[$this->uses[1]]['votos'].' ('.(round($opt[$this->uses[1]]['votos']/$total*100,1)).'%)<br/>';
			else
				$resultsData = '"No hay votos aún"';
				
			return $resultsData;
		}
	}

	function admin_agregar(){
		$this->detour('timeline');
		
		if(isset($this->data['Timeline']['created']) && $this->data['Timeline']['created'])
			$this->data[$this->uses[0]]['created'] = $this->data['Timeline']['created'];

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
		
		if(!empty($this->data)){
			if($return = $this->m[0]->saveAll($this->data,array('validate'=>true))){
				$msg = 'oksave'; if(is_array($return)){ foreach($return as $ret){ if(in_array(false,$ret)) $msg = 'somesave'; }}
				$this->redirect(array('action'=>'editar','admin'=>1,$this->m[0]->id,'msg'=>$msg));		
			}
		} else {
			if($this->m[0]->hasField('activo')) $this->data[$this->uses[0]]['activo'] = 1;
			if($this->m[0]->hasField('layout')) $this->data[$this->uses[0]]['layout'] = 'Izquierda';
		}
		
		if(!isset($this->data[$this->uses[0]][$categmodel]))
			$this->data[$this->uses[0]][$categmodel] = isset($categories) && $categories ? 0:1;
	}

	function admin_editar($id){
		$id = $this->_checkid($id);

		$this->detour('timeline');
		
		if(isset($this->data['Timeline']['created']) && $this->data['Timeline']['created'])
			$this->data[$this->uses[0]]['created'] = $this->data['Timeline']['created'];

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
		
		$this->m[0]->id = $id;

		if(empty($this->data)){
			$this->m[0]->recursive = 0;
			$this->data = $this->m[0]->read();
			$this->m[0]->clean($this->data,true);
		} elseif($return = $this->m[0]->saveAll($this->data,array('validate'=>true))){
			$msg = 'oksave'; if(is_array($return)){ foreach($return as $ret){ if(in_array(false,$ret)) $msg = 'somesave'; }}
			$this->redirect(array($id,'msg'=>$msg));		
		}

		if(!isset($this->data[$this->uses[0]][$categmodel]))
			$this->data[$this->uses[0]][$categmodel] = isset($categories) && $categories ? 0:1;
			
		$orderdata = $this->Question->find_(array(
			'conditions'=>array('poll_id'=>$id),
			'fields'=>array('id','nombre','orden'),
			'contain'=>false
		));
		$this->m[0]->clean($questions,true);
		$this->set(compact('orderdata'));		

	}
}
?>