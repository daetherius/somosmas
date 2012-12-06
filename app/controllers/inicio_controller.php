<?php
App::import('Controller','_base/My');
class InicioController extends MyController {
	var $name = 'Inicio';
	var $uses = array('Carousel','Album','Event','Achievement','Board','About');
	var $ts = 'Inicio';

	function index(){
		$this->pageTitle = Configure::read('Site.slogan');
		$carrusel = $this->Carousel->find_();
		$this->set(compact('carrusel'));
		$galleries = $this->Album->find_(array('conditions'=>array('tipo'=>'Fotos'),'contain'=>array('Category','Pcategory','Albumportada'),'limit'=>12));
		$this->set(compact('galleries'));
		$this->set('about',$this->About->find_(array('fields'=>array('id','intro')),'first'));
		$this->set('board',$this->Board->find_(null,'first'));
		$this->set('events',$this->Event->find_(array('limit'=>3)));
		$this->set('achievements',$this->Achievement->find_(array('limit'=>3)));

		//* -- LAST OF EACH -------------
		
		$last_items_cache_key = 'achievement_album_document_event_post_clink_link_last_items';
		if(true || (($last_items = Cache::read($last_items_cache_key)) === false)){
			$lasts = array('Achievement','Album','Document','Event','Post','Clink','Link');
			$last_items = $fields = array();

			foreach($lasts as $modelName){
				$fields_ = array('id','created');
				$query[] = 'SELECT id, created, \''.$modelName.'\' as parent FROM '.Inflector::tableize($modelName).' AS '.$modelName.' WHERE '.$modelName.'.activo = 1';
			}
			
			$query = 'SELECT * FROM (('.implode(') UNION (',$query).')) as Result ORDER BY created DESC LIMIT 10';
			$last_items_ = $this->m[0]->query($query);
			$sections = Configure::read('Sections');

			foreach ($last_items_ as $last_it) {
				$model = $last_it['Result']['parent'];
				$this->loadModel($model);
				$this->{$model}->recursive = -1;

				$contains = false;
				$fields = array('id','nombre','created');

				if($model != 'Link') $contains = array('Category.slug','Pcategory.slug');
				if($this->{$model}->hasField('slug')) $fields[] = 'slug';
				if($this->{$model}->hasField('enlace')) $fields[] = 'enlace';

				$item = $this->{$model}->find_(array(
					$last_it['Result']['id'],
					'fields'=>array_merge($fields,$contains),
					'contain'=>$contains
				));
				$item[$model]['externo'] = false;

				switch ($model) {
					case 'Document':
						$item[$model]['url'] = array('controller'=>'documents','action'=>'download',$item[$model]['id']);
					break;
					case 'Clink':
					case 'Link':
						$item[$model]['url'] = $item[$model]['enlace'];
						$item[$model]['externo'] = true;
					break;
					default:
						$item[$model]['url'] = array(
							'controller'=>'categories',
							'action'=>'ver',
							'program'=>$item['Category']['slug'],
							'category'=>$item['Pcategory']['slug'],
							'type'=>Inflector::slug($sections[strtolower($model)]),
							$item[$model]['slug']
						);

					break;
				}

				$last_items[] = $item;
			}
			
			Cache::write($last_items_cache_key,$last_items);
		}

	    $this->set(compact('last_items'));
	    /**/
	}
	
	function email(){ $this->layout = 'empty'; }
	function invitar(){
		$site = Configure::read('Site');
		
		if(!empty($this->data)){
			$this->Invitacion->set($this->data);
			if($this->Invitacion->validates()){
				$data = array_merge($this->data['Invitacion'],array('domain'=>$site['domain'],'business'=>$site['name']));
				$this->Invitacion->clean($data,false,false);
				$this->set($data);

				//// Send
				$this->Email->to = $data['nombre_para'].' <'.$data['email_para'].'>';
				$this->Email->from = $data['nombre_de'].' <'.$data['email_de'].'>';
				$this->Email->subject = $data['nombre_de'].' te ha invitado a visitar '.ucfirst($site['name']);
				$this->Email->replyTo = 'noreply@'.$site['domain'];
				$this->Email->sendAs = 'html';
				$this->Email->template = 'invite';
				
				if(Configure::read('debug')===0){
					if($this->Email->send())
						$msg = 'Tu invitación fue enviada correctamente.';
					else
						$msg = 'Lo sentimos. Hubo un problema al enviar tu invitación. Intenta de nuevo dentro de unos minutos.';
				} else 
					$msg = 'El Formulario ha sido desactivado porque está en modo Demo.';

				$this->set('successmsg',$msg);
			} else
				$this->set('errors',$this->Invitacion->invalidFields());

			$this->set('fid',$this->params['url']['fid']);
			$this->set('model','Invitacion');
			$this->render('form');
		} else
			$this->render('/inicio/invitar');
	}
}
?>