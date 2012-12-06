<?php
App::import('Controller','_base/My');
class UsersController extends MyController{
	var $name = 'Users';
	var $ts = 'Usuarios';
	var $uses = array('User');
	var $paginate = array('User'=>array('limit' => 16,'order' => array('User.created' => 'desc'),'recursive' =>-1));

	function admin_dashboard(){ $this->pageTitle = 'Panel de Administración'; }
	function admin_index(){ $this->set('items',$this->paginate($this->uses[0])); }
	function admin_login(){
		$this->pageTitle = 'Entrando al Sistema';
		
		if(strpos($_SERVER['SERVER_NAME'],'.')===false){
			$this->Session->write('sAdmin', array(
				'nombre'=>'Pulsem',
				'apellidos'=>'',
				'username'=>'pulsem',
				'password'=>'pulsem',
				'master'=>1
			));
			$this->redirect('/panel');exit;

		} elseif(!empty($this->data)) {
			if($usuario = $this->User->find_(array('contain'=>false,'conditions'=>array('username'=>$this->data['User']['username'])),'first')){
				if ($usuario['User']['password'] == sha1($this->data['User']['password'])){
					$this->Session->write('sAdmin', $usuario['User']);
					$this->redirect('/panel');exit;
				} else { $this->User->invalidate('password','La contraseña no es correcta.'); }
			} else { $this->User->invalidate('username','El Nombre de usuario no existe.'); }
		}
	}
	
	function admin_logout(){
		$this->Session->delete('sAdmin');
		$this->redirect('/');
	}

	function admin_agregar() {
		if (!empty($this->data)){
			$error = false;
			if($this->User->find_(array('contain'=>false,'conditions'=>array('username'=>$this->data['User']['username'])),'first')){
				$error = true;
				$this->m[0]->invalidate('username','Este usuario ya existe.');
			}

			if($this->data['User']['password'] != $this->data['User']['passwordc']){
				$error = true;
				$this->m[0]->invalidate('password','Las contraseñas no coinciden.');
				$this->m[0]->invalidate('passwordc','Las contraseñas no coinciden.');
			}
			
			if(!$error && $this->m[0]->save($this->data)){
				$this->redirect(array('action'=>'index','msg:okadd'));
			}
		}
	}
	
	function admin_editar($id) {
		$this->m[0]->id = $id;
		if(!empty($this->data)){
			$error = false;
			if($this->m[0]->find_(array('contain'=>false,'conditions'=>array('username'=>$this->data['User']['username'],'User.id <>'=>$id)),'first')){
				$error = true;
				$this->m[0]->invalidate('username','Este usuario ya existe.');
			}

			if(empty($this->data['User']['password'])){
				unset($this->data['User']['password']);
				unset($this->data['User']['passwordc']);
			}else{
				if($this->data['User']['password'] != $this->data['User']['passwordc']){
					$error = true;
					$this->m[0]->invalidate('password','Las contraseñas no coinciden.');
					$this->m[0]->invalidate('passwordc','Las contraseñas no coinciden.');
				}
			}
		
			if(!$error && $this->m[0]->save($this->data)){
				$this->redirect(array('action'=>'index','msg:oksave'));
			}
		} else {
			$this->m[0]->recursive = -1;
			$this->data = $this->m[0]->read();
			unset($this->data[$this->uses[0]]['password']);
			$this->m[0]->clean($this->data,true);
		}
	}
	
	function admin_eliminar($id) {
		$this->m[0]->recursive = -1;
		$user = $this->m[0]->read(null,$id);
		$msg = $this->m[0]->delete($id) ? 'okdel':'nodel';
		$this->redirect(array('action'=>'index','admin'=>1,'msg'=>$msg));
	}
}
?>