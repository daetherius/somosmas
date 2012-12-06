<?php
/****
* 02/Jul/11 - +Var $model
* 06/Oct/11 - Auto imgmodel, file, recurrentes (layout, category_id)
* 16/Dic/11 - Soporte para campos de tipo SET, campo activo siempre al final
****/
	$model = isset($model) ? $model : $_m[0];

	App::import('Model',$model);
	$m = new $model();
	$mergeSchema = isset($schema) && $schema ? Set::normalize($schema) : array();
	$_schema = Set::normalize(array_keys($m->_schema));

	$updating = isset($this->data[$model]['id']) && $this->data[$model]['id'];
	$imgmodel = isset($imgmodel) ? (is_string($imgmodel) || (!$imgmodel) ? $imgmodel : $model.'img') : (!$updating && ClassRegistry::isKeySet($model.'img') ? $model.'img' : false);
	$formAtts = isset($formAtts) && $formAtts ? $formAtts: array();
	$end = isset($end) ? $end : 'Guardar Cambios';
	$formtag = isset($formtag) ? $formtag : true;
	$before = isset($before) && $before ? $before : false;
	$after = isset($after) && $after ? $after : false;
	$afterOf = array(); /// Para reordenamiento
	$skips = array();
	$inpQueue = array();
	$fileFields = false;

	//// Campos Archivo
	if(isset($m->Behaviors->File->settings[$model]))
		$fileFields = array_keys($m->Behaviors->File->settings[$model]['fields']);

	//// Skip parent_id si es por comportamiendo de árbol
	if($m->hasField('parent_id') && property_exists($m->Behaviors,'Tree'))
	{ unset($_schema['parent_id']); }

	//// !!! form->create() antes de $form->input() si no, falla la automagia !!!

	$formDefaults = array('url'=>$this->here, 'type'=>'file', 'class'=>'catalog');
	if($formtag !== false)
		echo $form->create($model,am($formDefaults,$formAtts)),$this->element('invalidform');

	//// SKIPPING
	foreach($mergeSchema as $fieldName => $fieldData){
		if(is_string($fieldData) && low($fieldData) === 'skip'){
			unset($mergeSchema[$fieldName]);

			if(array_key_exists($fieldName,$_schema))
				unset($_schema[$fieldName]);
			
			$skips[] = $fieldName;
		}
	}

	//// Merge de solo campos para aplicar defaults

	$_schema = am($_schema,Set::normalize(array_keys($mergeSchema)));

	//////// Automagic
	
	foreach($_schema as $fieldName => $fieldData){
		$_schema[$fieldName] = (array)$fieldData;

		//// More Skip
			// Campo ID y se está agregando registro
			if(low($fieldName) === 'id' && (!$updating))
			{ unset($_schema[$fieldName]);continue; }

			// Campos automágicos
			if(in_array($fieldName,array('created','modified','updated','orden','slug','lft','rght')) || strpos($fieldName,'_count')!==false)
			{ unset($_schema[$fieldName]);continue; }

			/// Campo URL (tip)
			if(isset($m->validate[$fieldName])) {

				$isUrl = false;
				
				if(isset($m->validate[$fieldName]['rule']) && $m->validate[$fieldName]['rule'] == 'url'){
					$isUrl = true;
				} else {
					foreach($m->validate[$fieldName] as $rule){
						$isUrl = $isUrl || (isset($rule['rule']) && $rule['rule']=='url');
					}
				}
				
				if($isUrl){
					$_schema[$fieldName]['tip'] = 'Ingrese la URL del sitio o recurso al que se enlazará. Ej.: www.google.com';
				}
			}

		//// Tipo de input automágico
			// Combo
			if(strpos($fieldName,'_id') !== false && isset($mergeSchema[$fieldName]['type']) && $mergeSchema[$fieldName]['type']!= 'hidden'){
				$_schema[$fieldName] = array('type'=>'select','empty'=>'— Seleccione —','default'=>'');
			}

			// Enum
			if(isset($m->_schema[$fieldName]['type']) && strpos($m->_schema[$fieldName]['type'],'enum(')!==false){
				$keys = explode("','",substr(substr($m->_schema[$fieldName]['type'],6),0,-2));
				$options = array_combine($keys,array_map('ucfirst',$keys));
				$_schema[$fieldName] = array('type'=>'select','default'=>$m->_schema[$fieldName]['default'], 'options'=> $options);
			}
			// Set
			if(isset($m->_schema[$fieldName]['type']) && strpos($m->_schema[$fieldName]['type'],'set(')!==false){
				$keys = explode("','",substr(substr($m->_schema[$fieldName]['type'],5),0,-2));
				$options = array_combine($keys,array_map('ucfirst',$keys));
				$_schema[$fieldName] = array('div'=>'cuteCheckbox','type'=>'select','multiple'=>'checkbox','default'=>$m->_schema[$fieldName]['default'], 'options'=> $options);
			}

			// Archivo
			if($fileFields && in_array($fieldName, $fileFields)){
				$between = $types = $extra = '';

				if($m->Behaviors->File->settings[$model]['fields'][$fieldName]['types'])
					$types = 'Tipos permitidos: '.up(implode(', ',$m->Behaviors->File->settings[$model]['fields'][$fieldName]['types'])).'<br/>';

				if(isset($this->data[$model][$fieldName]))
					$between = $util->uploadinfo($model.'.'.$fieldName, $this->data[$model][$fieldName]);

				if(isset($mergeSchema[$fieldName]['strict'])){
					$extra = '<span style="color:#ff0">Dimensiones: <strong>'.$mergeSchema[$fieldName]['strict'].'</strong> (píxeles)</span><br/>';
					unset($mergeSchema[$fieldName]['strict']);
				}

				$_schema[$fieldName] = array(
					'between'=>$between,
					'type'=>'file',
					'label'=>'Archivo',
					'tip'=>array($extra.$types.'<span style="font-size:10px;color:#9f9f9f">Peso máximo recomendado para imágenes: 150 kb</span>','Especificaciones de Archivo')
				);
			}

		//// Labeling
		if(isset($m->_schema[$fieldName]['label'])){
			$_schema[$fieldName]['label'] = $m->_schema[$fieldName]['label'];
		}

	}

	//// Campos recurrentes
		// caducidad
		if(array_key_exists('caducidad',$_schema)){
			$_schema['caducidad'] = array(
				'before'=>$form->input($model.'.caduca',array('type'=>'checkbox','id'=>'caduca','label'=>'Fecha de Caducidad')),
				'type'=>'date',
				'label'=>false,
				'div'=>array('id'=>'caducidad'),
				'afterof'=>'activo'
			);

			$caducaCheck = 'function caducaCheck(){ $("caducidad").getElements("select").set("disabled",!$("caduca").get("checked")); }';
			$activoCheck = 'function activoCheck(){ $("caduca").set("disabled",!$("'.$model.'Activo").get("checked")); if(!$("'.$model.'Activo").get("checked")){ $("caduca").set("checked",false); } caducaCheck(); } ';

			echo
				$moo->buffer($caducaCheck.$activoCheck.' caducaCheck(); activoCheck();'),
				$moo->addEvent($model.'Activo','change','activoCheck();'),
				$moo->addEvent('caduca','change','caducaCheck();');
		}

		// category_id
		if($m->categoryModel && array_key_exists(strtolower($m->categoryModel).'_id',$_schema) && (!in_array('category',$skips))){
			$category = $m->categoryModel;
			$l_category = strtolower($m->categoryModel);
			$fkey = $l_category.'_id';
			$categoryVar = Inflector::tableize($category);
			
			////
			$firstpart = array_slice($_schema,0,array_search($fkey,array_keys($_schema)));
			$lastpart = array_slice($_schema,array_search($fkey,array_keys($_schema))+1);
			////
			
			unset($_schema[$fkey]);
			$category_array[$l_category] = array(
				'legend'=>'Categoría',
				'div'=>'category',
				'type'=>'radio',
				'options'=>array('Seleccionar existente:','Crear nueva:'),
				'after'=>$form->input($model.'.'.$fkey,array('label'=>false,'empty'=>'— Seleccione —')).$form->input($category.'.nombre',array('label'=>false,'value'=>''))
			);
			
			$_schema = array_merge($firstpart,$category_array,$lastpart);
			
			$switchcategory = 1;
			
			if(isset($this->data[$_m[0]][$l_category])){
				$switchcategory = $this->data[$_m[0]][$l_category];
			}elseif(isset(${$categoryVar}) && ${$categoryVar}){
				$switchcategory = 0;
			}
			
			$script = 'function switchcategory(opc){
				var els = [$("'.$model.$category.'Id"), $("'.$category.'Nombre")];
				if(opc) els.reverse();
				els[0].getParent("div").reveal();
				els[1].getParent("div").dissolve();
			} switchcategory('.$switchcategory.');';

			echo
				$moo->addEvent($model.$category.'0','change','switchcategory(0);'),
				$moo->addEvent($model.$category.'1','change','switchcategory(1);'),
				$moo->buffer($script);
		}

		// layout
		if(array_key_exists('layout',$_schema)){
			$_schema['layout'] = array(
				'type'=>'radio',
				'legend'=>false,
				'before'=>$html->div('label','Disposición de imagen'.$util->tip('Indica la posición de la imagen principal (portada) dentro del texto del Artículo.')),
				'options'=>array('Izquierda'=>$html->image('admin/postLayoutLeft.gif'),'Derecha'=>$html->image('admin/postLayoutRight.gif'),'Centro'=>$html->image('admin/postLayoutFull.gif'))
			);
		}
		
		// Tags
		if(isset($m->hasAndBelongsToMany['Tag'])){
			$_schema['Tag'] = array(
				'label'=>'Etiquetas:'.$util->tip('Marque las etiquetas que desee asignar o agregue nuevas escribiendo en el cuadro.'),
				'multiple'=>'checkbox',
				'div'=>'cuteCheckbox',
				'between'=>$this->element('admin_tags')
			);
		}

	//// Model img
	if($imgmodel){
		$mergeSchema[$imgmodel.'.{n}.src'] = array(
			'type'=>'file',
			'label'=>'Imágenes:'.$util->tip(array('Peso máximo recomendado p/foto: 150 kB<br/>Tipos permitidos: JPG, JPEG, GIF, PNG<br/>La primera imagen se convertirá en la Portada','Especificaciones de Archivo'))
		);
		$moo->moopload($imgmodel);
	}

	//// Combina $mergeSchema con $_schema

	foreach($mergeSchema as $fieldName => $fieldData){
		$mergeSchema[$fieldName] = (array)$fieldData; /// Forzamos array

		if(!isset($_schema[$fieldName]))
			$_schema[$fieldName] = array();

		$_schema[$fieldName] = am($_schema[$fieldName],$mergeSchema[$fieldName]);
	}
	//// Post merge
	$hasActivo = false;
	foreach($_schema as $fieldName => $fieldData){
		if(isset($fieldData['label'])){
			if(isset($fieldData['type']) && $fieldData['type'] == 'radio' && (!isset($fieldData['legend']))){
				$fieldData['legend'] = $fieldData['label'];
			} elseif(isset($fieldData['tip'])) {
				$fieldData['label'].= $util->tip($fieldData['tip']);
				unset($fieldData['tip']);
			}
		}

		//// Reordenar
		if(isset($fieldData['afterof']) && $fieldData['afterof']){
			if(!isset($afterOf[$fieldData['afterof']]))
				$afterOf[$fieldData['afterof']] = array();
			
			$aftr = $fieldData['afterof'];
			unset($fieldData['afterof']);
			
			$afterOf[$aftr][] = $form->input($fieldName,$fieldData);
		} else {
			if($fieldName == 'activo'){
				$hasActivo = $form->input($fieldName,$fieldData);
			} else {
				$inpQueue[$fieldName] = $form->input($fieldName,$fieldData);
			}
		}
	}

	///// Output

	if($before) echo $before;

	//// Reordenamiento
	foreach($inpQueue as $fieldName => $inp){
		echo $inp;
		//// Si tiene inputs después de él
		if(isset($afterOf[$fieldName]) && $afterOf[$fieldName]){
			foreach($afterOf[$fieldName] as $afterOfInp){
				echo $afterOfInp;
			}
		}
	}
	
	if($hasActivo) echo $hasActivo;
	if($after) echo $after;
	if($end) echo $form->end($end);
?>