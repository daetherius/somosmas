<?php
class MooHelper extends JsHelper {
	var $helpers = array('Html','Form','Util');

	function __construct() { parent::__construct('Mootools'); }
	function findParent(&$arr,$searchvalue=null,$searchkey=null,$parent=false,&$parents){
		foreach($arr as $key => &$value){
			if(is_array($value)){
				$this->findParent($value,$searchvalue,$searchkey,$key,$parents);
			} else{
				if((isset($searchkey) && isset($searchvalue) && $searchkey===$key && $searchvalue===$value) || (!isset($searchvalue) && isset($searchkey) && $searchkey===$key) || (!isset($searchkey) && isset($searchvalue) && $searchvalue===$value)){
					$parents[] = $parent ? $parent : false;
				}
			}
		}
	}

	function addEvent($element,$event,$options,$xoptions = array()){
		/// Options: update; data; url; stop; append; eval; css;
		$script = '';
		if(!is_array($options)){ /// options es el script para la forma corta de addEvent
			$script = $options;
			$options = $xoptions;
		}
		$mceEditorSave = '';

		$options = array_merge(array(
			'script'=>'',
			'spinner'=>false,
			'json'=>false,
			'url'=>false,
			'if'=>false,
			'oncomplete'=>'',
			'onsuccess'=>'',
			'onrequest'=>'',
			'update'=>false,
			'data'=>false,
			'prevent'=>false,
			'propagation'=>true,
			'confirm'=>false,
			'append'=>false,
			'evalscripts'=>true,
			'css'=>false,
			'fade'=>false
		),$options);

		if($options['url']){ // Ajax
			if($options['url']===true) $options['url'] = '"+$("'.$element.'").get("action")+"';
			if($event === 'submit')
				$mceEditorSave = 'if(this.getElement(".mceEditor")){ tinyMCE.triggerSave(true,true);}';

			$script.= 'new Request';
			if($options['update'] || $options['append'])
				$script.= '.HTML';
			elseif($options['json'])
				$script.= '.JSON';

			$script.= '({ url:"'.$options['url'].'?isAjax=1", evalScripts:'.($options['evalscripts'] ? 'true':'false');

			if($options['spinner']){
				$autoid = time();
				if(is_array($options['spinner'])){
					$options['onrequest'].= ' new Element("div.spinnerLayer",{ id:"spinner_'.$autoid.'", styles:{ opacity:0 }}).inject($('.(current($options['spinner'])).')).fade(0.6); ';
				} else {
					$options['onrequest'].= ' new Element("img",{ id:"spinner_'.$autoid.'", src:"/img/spinner.gif", alt:"Cargando...", styles:{ "margin-left": 6, "vertical-align":"middle" } }).inject($('.(is_string($options['spinner']) ? $options['spinner'] : '"'.$element.'"').'),"after"); ';
				}
			}

			if($options['onrequest']){
				$script.= ', onRequest:function(){ '.$options['onrequest'].' }.bind(this)';
			}

			$script.= ', onComplete:function(a,b){ '.$options['oncomplete'];
				if($options['spinner'])
					$script.= '$("spinner_'.$autoid.'").destroy();';

				/*
				if($options['update'] && $options['fade'])
					$script.= '//$("'.$options['update'].'").adopt(); ';
				*/

			$script.= '}.bind(this)';

			if($options['onsuccess'])
				$script.= ', onSuccess:function(oResponse){'.$options['onsuccess'].'}.bind(this)';

			if($options['update'])
				$script.= ', update:$('.$options['update'].')';

			if($options['append'])
				$script.= ', append:$('.$options['append'].')';

			$script.= '}).'.($options['data'] ? 'post':'get').'('.($options['data'] ? '$('.$options['data'].')':'').');';

			if($options['update'] && $options['fade']){
				$script = '
					var updater = $('.$options['update'].');
					var fader = new Element("div.fader").adopt(updater.getChildren());
					var spinner = new Element("div.spinner").inject(updater);
					fader.inject(spinner).fade("out").get("tween").chain(function(){
						'.$script.'
					}.bind(this));';
			}
			$script = $mceEditorSave.$script;
		}

		if($options['confirm'])
			$script = 'if(confirm("'.$options['confirm'].'")){ '.$mceEditorSave.$script.' }';

		if($options['if'])
			$script = 'if('.$options['if'].'){ '.$script.' } ';

		if($options['propagation'])
			$script = 'e.stopPropagation(); '.$script;

		if($options['prevent'])
			$script = 'e.stop(); '.$script;

		if(strpos($event,'|')!==false){
			$exploded = explode('|',$event);
			$event = $exploded[0];
			$script = 'if(e.key == "'.$exploded[1].'"){ '.$script.' } ';
		}

		$script = ($options['css'] ? '$':'').'$("'.$element.'").addEvent("'.$event.'", function(e){ e = new Event(e); '.$script.' });';

		if($xoptions===true)
			return $script;
		else
			$this->buffer($script);
	}

	//////////////// Componentes

	function headjs($scripts = false) {
		if($scripts)
			echo $this->Html->scriptBlock('head.js("/js/'.implode('.js").js("/js/',$scripts).'.js");',array('inline'=>true));
	}

	function pbox() {
		$this->Html->css('pulsembox','stylesheet',array('inline'=>false));
		$this->Html->script('pulsembox',false);
	}

	function ajaxform($form = false, $options = array()){
		$this->Html->script('ajaxform',false);
		if(!$form) return;
		$options = $this->Util->json($options);
		$this->buffer($form.'_af = new ajaxForm("'.$form.'"'.$options.');');
	}

	function moopload($model,$maxUploads = 10,$field = 'Src',$start = 0){
		$this->Html->css('moopload','stylesheet',array('inline'=>false));
		$this->Html->script('moopload',false);
		$this->buffer('new Moopload($("'.ucfirst($model).'{n}'.ucfirst($field).'"),'.$maxUploads.','.$start.');');
	}

	function mooquee($el,$options = array()){
		$options = $this->Util->json($options);
		$this->Html->script('mooquee',false);
		$this->buffer('new mooquee("'.$el.'"'.$options.');');
	}

	function scroller($el='',$options = array()){
		$options = $this->Util->json(am(array('auto'=>true),$options));
		$this->Html->script('mooscroller',false);
		if($el)
			$this->buffer('new mooScroller("'.$el.'"'.$options.');');
	}

	function showcase($el, $options=array()){
		$options = $this->Util->json($options);
		//$this->Html->css('mooshowcase','stylesheet',array('inline'=>false));
		//$this->Html->script('mooshowcase',false);
		$this->buffer('new mooShowcase("'.$el.'"'.$options.');');
	}

	function slider($el, $options=array()){
		$options = $this->Util->json($options);
		$this->Html->css('mooslider','stylesheet',array('inline'=>false));
		$this->Html->script('mooslider',false);
		$this->buffer('new mooSlider("'.$el.'"'.$options.');');
	}

	function suggest($inpId = false, $inpCaption = false, $url = false, $urlSelector = false, $options = array()){
		$this->Html->script('moosuggest',false);
		$this->Html->css('moosuggest','stylesheet',array('inline'=>false));

		if($inpId && $inpCaption && $url){
			$args = array($inpId,$inpCaption,$url);

			if($urlSelector) $args[] = $urlSelector;
			$args = '"'.implode('","',$args).'"';

			if($options){
				$options = $this->Util->json($options);
				$args.= ',{'.$options.'}';
			}

			$this->buffer('new mooSuggest('.$args.');');
		}
	}

	function tabs($el,$options = array()){
		$options = $this->Util->json($options);
		$this->Html->css('mootabs','stylesheet',array('inline'=>false));
		$this->Html->script('mootabs',false);
		$this->buffer('new mooTabs("'.$el.'"'.$options.');');
	}

	function pop($msg,$inline = false){
		if(!$msg) return;
		$script = 'mooPop("'.$msg.'");';

		if($inline)
			return '<script type="text/javascript">window.addEvent("domready", function(){ '.$script.' });</script>';

		$this->buffer($script);
	}

	function highlight($id = false,$inline = false){
		if(!$id) return;
		$script = 'if($("it'.$id.'")) new Fx.Scroll(window,{ onComplete:function(){ $("it'.$id.'").getParent("tr").set("tween",{duration:5000}).highlight(); }}).toElementCenter("it'.$id.'");';

		if($inline)
			return '<script type="text/javascript">window.addEvent("domready", function(){ '.$script.' });</script>';

		$this->buffer($script);
	}

	function player($video = true, $src = false, $options = array()){
		if($video){
			$this->Html->script('flowplayer-3.2.3.min',false);
			$this->buffer('flowplayer(".vPlayer", "/swf/flowplayer-3.2.3.swf");');
		} else {
			$options = array_merge(array('width'=>'100%'),$options);
			$this->Html->script('audio-player.js',false);
			$this->buffer('AudioPlayer.setup("/swf/player.swf", { width: "'.$options['width'].'",transparentpagebg: "yes" });');
			if($src){
				$options = array_merge(array('id'=>'pPlayer'),$options);
				$src = (strpos($src,'http://')!== 0 ? '/':'').$src;
				$this->buffer('AudioPlayer.embed("'.$options['id'].'", { soundFile: "'.$src.'" });');
			}
		}
	}

	function elist($model,$fields = array(),$options = array(),$attrs=array()){
		/// sort: Es reordenable; min: número mínimo de elementos en la lista (Sin link de cerrar)
		$options = array_merge(array(
			'data'=>false,
			'sort'=>false,
			'min'=>1,
			'adder'=>false,
			'remover'=>false,
			'confirmdelete'=>false,
			'zoom'=>false,
			'images'=>false,
			'custom'=>false,
			'oncreate'=>false,
			'ondelete'=>false
		),$options);

		$listHTML = '';

		if($options['data']){
			$data = $options['data'];
			unset($options['data']);
		} else
			$data = false;

		if(empty($fields))
			$fields = array('id','nombre');

		$listSize = $data ? sizeof($data) : $options['min'];
		$id = isset($attrs['id']) && $attrs['id'] ? $attrs['id'] : $model.'_elist';

		for($i=0;$i<$listSize;$i++){
			$inner='';

			if($options['sort'])
				$inner.= $this->Html->tag('span','',array('class'=>'elist_button elist_handler','title'=>'Arrástrame'));

			if($options['zoom'])
				$inner.= $this->Html->link('',array($data[$i][$model]['id']),array('class'=>'elist_button elist_zoom','title'=>'Ver'));

			foreach($fields as $field => $opts){
				if(is_numeric($field) && !is_array($opts)){ # para fields sin opciones
					$field = $opts;
					$opts = array();
				}

				$defaultmodel = $model;
				if(strpos($field,'.')!== false){
					$defaultmodel = strtok($field,'.');
					$field = strtok('.');
				}

				$attr = $opts = array_merge(array('edit'=>false,'hide'=>true,'label'=>false,'separator'=>false,'class'=>'','div'=>'','type'=>false),$opts);
				$div = $attr['div'];
				$class = $attr['class'];
				//unset($attr['label']);
				if(!$attr['type']) unset($attr['type']);

				unset($attr['div']);
				unset($attr['class']);
				unset($attr['edit']);
				unset($attr['hide']);
				unset($attr['separator']);
				
				$value = '';
				if(isset($data[$i][$defaultmodel][$field]) && $data[$i][$defaultmodel][$field])
					$value = $data[$i][$defaultmodel][$field];

				$attr = am(
					array(
						'value'=>_dec($value),
						'type'=>!$opts['edit'] ? 'hidden':null,
						'label'=>false,
						'div'=>'ib '.$div,
						'format'=>array('before', 'between', 'input', 'after','label', 'error'),
						'class'=>'elist_input elist_input_unselected '.$class
					),$attr
				);

				if($attr['type'] == 'checkbox' && $attr['value'])
					$attr['checked'] = 'checked';

				if($opts['edit'] || $value!==false)
					$inner.= $this->Form->input(implode('.',array($defaultmodel,$i,$field)), $attr);

				if((!$opts['hide']) && (!$opts['edit']) && $value!==false)
					$inner.= ($opts['separator'] ? $opts['separator']:'').$this->Html->tag(
						'span',
						($opts['label'] ? $opts['label']:'').$data[$i][$defaultmodel][$field],
						array('class'=>'elist_tag '.$class)
					);
			}

			if($options['sort'])
				$inner.= $this->Form->input(implode('.',array($model,$i,'orden')),array('value'=>$data ? $data[$i][$model]['orden']:$i,'type'=>'text','label'=>false,'class'=>'orderInput','div'=>'hide')); ###

			if($options['custom']){
				foreach($options['custom'] as $custom){
					$customText = $custom['text']; unset($custom['text']);
					$customAction = $custom['action']; unset($custom['action']);
					$customUrl = am(array('admin'=>true,'action'=>$customAction,$data[$i][$model]['id']),$custom);

					$inner.= $this->Html->link($customText, $customUrl, array('class'=>'datagridButton')); ###
				}
			}
			if($options['remover'])
				$inner.= $this->Html->link('','javascript:;',array('escape'=>false,'class'=>'elist_remove elist_button','title'=>'Eliminar elemento de la lista'));

			$listHTML.= $this->Html->div('elist_item',$inner,array('id'=>'elistitem_'.$data[$i][$model]['id']));
		}

		$script = 'Sortables.implement({
			reorder:function(){
				'.($options['sort'] ? 'this.serialize(false,function(el,idx){ el.getElement("input.orderInput").set("value", this.lists[0].childElementCount - idx - 1); }.bind(this));' : '').'
				return this;
			}
		});

		var '.$id.'Sortable = new Sortables("'.$id.'", {
			handle:".elist_handler",
			onComplete:function(){ this.reorder(); },
			revert:{ duration: 500, transition: "pow:in:out" },
			opacity:0.4,
			snap:10,
			clone:true,
			constrain:true
		}).reorder();
		'; echo $this->buffer($script);

		$editables = array();
		$editableList = $options['sort'] ? $this->Html->tag('span','',array('class'=>'elist_button elist_handler')):'';
		$this->findParent($fields,1,'edit',null,$editables);# Obtenemos los campos definidos como editables para copiarlos al demo (campos con editable === 1)

		foreach($editables as $editable){
			$editableIdx = $editable;
			$defaultmodel = $model;

			if(strpos($editable,'.')!== false){
				$defaultmodel = strtok($editable,'.');
				$editable = strtok('.');

				$editableIdx = $defaultmodel.'.'.$editable;
			}

			$attr = am(array('class'=>'','div'=>'','type'=>false),$fields[$editableIdx]);

			$div = $attr['div'];
			$class = $attr['class'];

			//unset($attr['label']);
			if(!$attr['type']) unset($attr['type']);
			unset($attr['div']);
			unset($attr['class']);
			unset($attr['edit']);
			unset($attr['hide']);

			//$editableList.= $this->Form->input(implode('.',array($model,'{n}',$editable)),array('label'=>false,'class'=>'elist_input elist_input_unselected'));
			$editableList.= $this->Form->input(
				implode('.',array($defaultmodel,'{n}',$editable)),
				am(array(
					'label'=>false,
					'div'=>'ib '.$div,
					'format'=>array('before', 'between', 'input', 'after','label', 'error'),
					'class'=>'elist_input elist_input_unselected '.$class
				),$attr)
			);
		}

		if($options['sort'])
			$editableList.= $this->Form->input(implode('.',array($model,'{n}','orden')),array('value'=>'','type'=>'text','label'=>false,'class'=>'orderInput','div'=>'hide'));

		if($options['remover'])
			$editableList.= $this->Html->link('','javascript:;',array('escape'=>false,'class'=>'elist_remove elist_button'));

		$editableList = r("\n",'',r("\r",'',$editableList));

		echo $this->addEvent('.elist_input','focus','this.removeClass("elist_input_unselected");',array('css'=>1));
		echo $this->addEvent('.elist_input','blur','this.addClass("elist_input_unselected");',array('css'=>1));

		if($options['remover']){
			$remove_url = is_string($options['remover']) ? $options['remover'] : '/admin/'.Inflector::tableize($model).'/eliminar/';
			$remove_script = 'if(this.getParent(".elist").getElements(".elist_item").length > '.$options['min'].'){
				var item = this.getParent();

				if(item.get("id")){
					new Request({
						url:"'.$remove_url.'"+item.id.split("_")[1]+"/'.$id.'",
						onRequest:function(){
							new Element("img",{
								id:"spinner_"+item.id.split("_")[1],
								src:"/img/spinner.gif",
								alt:"Cargando...",
								styles:{ "margin-left": 6 }
							}).inject(this,"after");
						}.bindWithEvent(this),
						onComplete:function(){
							$("spinner_"+item.id.split("_")[1]).destroy();
						}.bindWithEvent(this),
						evalScripts:true
					}).send();
				} else {
					item.nix().get("reveal").chain(function(){ '.$id.'Sortable.reorder(); });
				} '.($options['ondelete'] ? $options['ondelete'] :'').'
			} else {
				new mooPop("Imposible eliminar. La lista debe tener al menos '.$options['min'].' elementos.");
			}';

			if($options['confirmdelete'])
				$remove_script = 'if(confirm("¿Seguro quiere eliminar el elemento?")){'.$remove_script.'}';

			echo $this->addEvent('.elist_remove','click',$remove_script,array('css'=>1));
		}

		if($options['adder']){
			$add_script = '
			newelistitem = new Element("div",{
				"class":"elist_item",
				styles:{ display:"none" },
				html:(\''.$editableList.'\').substitute({ n:'.$id.'Sortable.lists[0].childElementCount })
			}).inject($("'.$id.'")).reveal();';

			if($options['remover'])
				$add_script.= 'newelistitem.getElement("a.elist_remove").addEvent("click", function(e){ '.$remove_script.' });';

			$add_script.= 'newelistitem.getElements(".elist_input").addEvents({
				"focus":function(){ this.removeClass("elist_input_unselected"); }.bindWithEvent(this),
				"blur":function(){ this.addClass("elist_input_unselected"); }.bindWithEvent(this)
			}); '.$id.'Sortable.addItems(newelistitem).reorder();';


			if($options['oncreate'])
				$add_script.= $options['oncreate'];

			echo $this->addEvent($options['adder'],'click',$add_script);
		}
		return $this->Html->div('elist',$listHTML,$attrs);
	}

	function inlabel($data){
		$this->Html->script('mooinlabel',false);
		$data = $this->Util->json($data,false,false);
		$this->buffer('new mooInlabel({'.$data.'});');
	}
}
?>