<?php
uses('L10n');
class AppController extends Controller {
	var $components = array('Cookie','RequestHandler','Simplepie','Session');
	var $helpers = array('Html', 'Form', 'Session','Js','Moo','Util','Text','Resize');
	var $detour = false;
	var $sysMsg = array(
		'master'=>'No se puede eliminar este elemento.',
		'noadd'=>'Ha habido un problema para crear el elemento.',
		'nosave'=>'Ha habido un problema para guardar los cambios del elemento.',
		'somesave'=>'Algunos elementos no han podido guardarse.',
		'nodel'=>'Ha habido un problema para eliminar el elemento.',
		'noactv'=>'Ha habido un problema para activar el elemento.',
		'okadd'=>'Elemento guardado correctamente.',
		'oksave'=>'Cambios realizados correctamente.',
		'okdel'=>'Elemento eliminado correctamente.',
		'okactv'=>'El elemento se ha activado.'
	);

	function beforeFilter(){
		$ctlr = low($this->name);

		Configure::write('Config.language','esp');
		$this->set('sitename_for_layout', Configure::read('Site.name'));
		$this->set('siteslogan_for_layout', Configure::read('Site.slogan'));
		$this->set('sitedomain', Configure::read('Site.domain'));
		
		//// SEDE
		$domain = Configure::read('Site.domain');

		if(!empty($this->data['sede'])){
			$redirect = $domain;

			if($this->data['sede'] != 'Mérida')
				$redirect = Inflector::slug($this->data['sede']).'.'.$redirect;
			
			$redirect = 'http://'.$redirect;
			$this->redirect($redirect,true);

		} else {
			$_sede_full = 'Mérida';
			$_sede = '';
			$domain = $_SERVER['SERVER_NAME'];
			$subdomain = strtolower(substr($domain, 0, strpos($domain, '.')));

			$str_count = substr_count($domain, '.');

			if(in_array($subdomain, array('tizimin','progreso'))){
				$_alias = array('tizimin'=>'Tizimín','progreso'=>'Progreso');
				$_sede_full = $_alias[$subdomain];
				$_sede = $subdomain;
			}

			$this->set(compact('_sede','_sede_full'));
		}

		//// CACHE
		
		if(strpos($this->action,'admin_')===false){
			if($this->params['controller']=='categories'){
				
				if(Cache::read('category_program_recent') === false){
					$this->loadModel('Category');
					$categories = $this->Category->find_(array('contain'=>false,'conditions'=>array('NOT'=>array('parent_id'=>null))));
					$group = array();
					foreach($categories as $categ){
						if(!isset($group[$categ['Category']['parent_id']])){
							$group[$categ['Category']['parent_id']] = array($categ['Category']);
						} else {
							$group[$categ['Category']['parent_id']][] = $categ['Category'];
						}
					}
					
					Cache::write('category_program_recent',$group);
				}

				if(Cache::read('category_recent') === false){
					$this->loadModel('Category');
					$categories = $this->Category->find_(array('contain'=>false,'conditions'=>array('parent_id'=>null)));
					Cache::write('category_recent',$categories);
				}
				
				if(isset($this->params['program']) && $this->params['program']){
					$pid = $this->_checkid($this->params['program']);
					$sections = Configure::read('Sections');
					$ckey = implode('_',array_keys($sections)).'_'.$pid;
					$this->set('cachekey',$ckey);
					
					if(Cache::read($ckey) === false){
						foreach($sections as $modelName => $secLabel){
							$modelName = ucfirst($modelName);
							$this->loadModel($modelName);
							
							if(!$this->{$modelName}->find_(array('conditions'=>array('category_id'=>$pid)),'count'))
								unset($sections[$modelName]);
						}
						
						Cache::write($ckey,$sections);
					}
				}
			}

			if(!$last_update = Cache::read('last_update','updates')){
				$last_update = date('d-m-Y H:i:s');
			}
			
			$this->set(compact('last_update'));

		}
			
		//// Session
		
		$prefixes = Configure::read('Routing.prefixes');
		foreach($prefixes as $prefix){
			$user = 's'.ucfirst($prefix);
			$this->set($user,$this->Session->check($user) ? $this->{$user} = $this->Session->read($user):false);

			if(isset($this->params[$prefix]) && $this->params[$prefix]){ # Si es zona de prefijo
				$this->layout = $prefix;

				/*** Recordatorio de Pagina **/
				if($prefix=='admin'){
					$this->set('highlight',0);
					
					if($this->params['action']=='admin_index'){
						if(isset($this->params['named']['page'])){
							$this->params['named'] = am(array('direction'=>'','page'=>'','sort'=>''),$this->params['named']);
							$paginacion = array(
								'page'=>$this->params['named']['page'],
								'direction'=>$this->params['named']['direction'],
								'sort'=>$this->params['named']['sort']
							);
							$this->Session->write('panel.'.$ctlr.'.paginacion',$paginacion);
							
						}elseif($this->Session->check('panel.'.$ctlr.'.paginacion')){
							
							$paginacion = $this->Session->read('panel.'.$ctlr.'.paginacion');
							$this->Session->delete('panel.'.$ctlr.'.paginacion');
							$this->redirect(am($this->passedArgs,$this->params['named'],$paginacion));
							exit;
						}
						
						if($this->Session->check('panel.'.$ctlr.'.highlight')){
							$this->set('highlight',$this->Session->read('panel.'.$ctlr.'.highlight'));
							$this->Session->delete('panel.'.$ctlr.'.highlight');
						} 
							
					} else {
						if(isset($this->passedArgs[0]) && $id = $this->_checkid($this->passedArgs[0],false)){
							$this->Session->write('panel.'.$ctlr.'.highlight',$id);
						}
						
					}
				}

				/*****/

				if($this->params['action']!=$prefix.'_login' && $this->params['action']!=$prefix.'_logout'){
					if(!$this->Session->check($user))
						$this->redirect($prefix == 'admin' ? '/panel/login':'/login/');
				}
			}
		}

		/// Automation
		$this->m = array();
		$this->set('_t', ucfirst(isset($this->t) ? $this->t : Inflector::singularize($this->ts)));
		$this->set('_ts', $this->ts);
		if($this->uses){
			foreach($this->uses as $modelName)
				$this->m[] = $this->{$modelName};
			
			$this->set('_m',$this->uses);
		} else
			$this->set('_m',false);
				
		/// System Messaging
		$this->set('msg',isset($this->params['named']['msg']) && $this->params['named']['msg'] && array_key_exists($this->params['named']['msg'],$this->sysMsg) ? $this->sysMsg[$this->params['named']['msg']]:false);
		
	}

	function beforeRender(){
		$layoutVars = array('keywords','description');
		$siteVars = Configure::read('Site');
		
		foreach($layoutVars as $lyVar){
			if(!isset($this->viewVars[$lyVar.'_for_layout'])){
				$this->set($lyVar.'_for_layout',isset($siteVars[$lyVar]) && $siteVars[$lyVar] ? $siteVars[$lyVar] : '');
			}
		}

		$this->set('title_for_layout',isset($this->pageTitle) ? $this->pageTitle : $this->ts);
		
		
		
		if(isset($this->params['isAjax'])&& $this->params['isAjax'])
			$this->viewPath = $this->action = 'ajax';
		elseif($this->viewPath != 'errors'){
			if(!$this->detour)
				$this->detour();
			
			if($this->detour)
				$this->action = $this->detour;
		}
	}
	
	/// Default Functions

	function _checkid($id, $redirect = true){
		if($id === false){
			if($redirect){
				$this->redirect(array(
					'action'=>'index',
					'admin'=>isset($this->params['admin']) && $this->params['admin']
				));
				exit;
			}
		} elseif(!is_numeric($id)){
			$id = (int)preg_replace('/[^a-zA-Z0-9\-\_]/','',$id);
		}
		
		return $id;
	}	

	function detour($detour = '_base', $action = false){
		if($detour){
			if(!file_exists(VIEWS.$this->viewPath.DS.($action ? $action : $this->action).'.ctp')){
				$this->viewPath = $detour;
				$this->detour = $action ? $action : $this->action;
			}
		}
		
		if($action!==false) $this->detour = $action;
	}
}
?>