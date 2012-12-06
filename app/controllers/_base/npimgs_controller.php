<?php
App::import('Controller','_base/Imgs');
class NpimgsController extends ImgsController{
	function admin_index(){	
		if(!empty($this->data)){
			$msg = 'oksave';
			foreach($this->data[$this->uses[0]] as $item){
				$this->m[0]->create(false);
				if(!$this->m[0]->save($item))
					$msg = 'someimgsave';
			}
			$this->redirect(array('msg'=>$msg));
			exit();
		}
		$items = $this->paginate($this->uses[0]);
		$this->m[0]->clean($items,true);
		$this->set(compact('items'));
	}

	function admin_order() {
		if(empty($this->data)){
			$this->set('orderdata',$this->m[0]->find_(array(
				'fields'=>array('id',$this->m[0]->displayField,'orden'),
				'contain'=>false
			),'all+'));
		} else{
			foreach($this->data[$this->uses[0]] as $it){
				$this->m[0]->create(false);
				$result = $this->m[0]->save($it);
			}
			$this->redirect(array('msg:oksave'));
		}
	}
}
?>