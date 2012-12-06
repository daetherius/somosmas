<?php
echo
	$this->element('showcase',array('data'=>$carrusel,'opts'=>array('nav'=>false))),
	$html->div('contentwide'),
	$html->div('pad'),
		$html->div('gallery_place'),
			$this->element('slider',array(
				'data'=>$galleries,
				'model'=>'Album',
				'h'=>143,
				'redirect'=>array('controller'=>'albums','category'=>':Pcategory.slug','action'=>'ver',':slug'),
				'element'=>'thgal',
				'min'=>false,
				'id'=>'galsroller'
			)),
			$moo->buffer('$$("#galsroller .sgItem").each(function(el){
				var img = el.getElement("img");
				img.set("tween",{ transition:"pow:out" });
				el.addEvents({
					mouseenter:function(){ this.fade("out"); }.bind(img),
					mouseleave:function(){ this.fade("in"); }.bind(img)
				});
			});'),
		'</div>',
		$html->div('clear cols'),

			$html->div('column left'),
				$html->div('sumate'),
					$html->div('title title1','Súmate+'),
					$about['About']['intro'] ? $html->div('pBody',''.$about['About']['intro']):'',
					$html->div('more',$html->link('Leer más',array('controller'=>'about','action'=>'index'))),
				'</div>',
				
				/// Cartelera
				
				$board['Board']['enlace'] ? $html->tag('a',null,array('href'=>$board['Board']['enlace'],'class'=>'cartelera','rel'=>'nofollow','target'=>'_blank')) : $html->div('cartelera'),
					$html->div('title title1','Cartelera'),
					$html->div('pad'),
						$util->th($board,'Board',array('w'=>160)),
						$html->tag('h3',$board['Board']['nombre'],'pTitle'),
						$html->div('pBody',''.$board['Board']['descripcion']),
					'</div>',
				$board['Board']['enlace'] ? '</a>':'</div>',

				/// funcionarios login

				$form->create(null,array('url'=>'http://f.'.(Configure::read('Site.domain')),'id'=>'loginForm')),
				/*
					$html->div('title title3','Usuarios'),
					$form->input('Member.email',array('label'=>'E-mail:')),
					$form->input('Member.password',array('label'=>'Contraseña:')),
				$form->end('Entrar'),
				*/
				$form->end(),
				
				//$html->link('Haz una denuncia ciudadana, es completamente anónima',array('controller'=>'contacto','action'=>'index'),array('class'=>'denuncia')),
			'</div>',

			$html->div('column'),
				$html->div(null,null,array('id'=>'tabsHome')),
					$html->link($html->tag('span','').'eventos','javascript:;'),
					$html->link($html->tag('span','').'logros','javascript:;'),
					$html->div('');
						foreach($events as $it) echo $this->element('th',array('item'=>$it,'model'=>'Event','h'=>1,'layout'=>array('fecha','nombre','img','desc','mas')));
					echo '</div>',
					$html->div('');
						foreach($achievements as $it) echo $this->element('th',array('item'=>$it,'model'=>'Achievement','h'=>1,'layout'=>array('fecha','nombre','img','desc','mas')));
					echo '</div>',
				'</div>';

				#---------------------------------

				if($last_items){ fb($last_items,'$last_items');
					$alias = array(
						'Achievement'=>'Logros',
						'Album'=>'Galería',
						'Document'=>'Documentos',
						'Link'=>'Sitios de Interés',
						'Clink'=>'Sitios de Interés',
						'Event'=>'Actividades',
						'Post'=>'Blog'
					);

					echo
						$html->div('latest_updates'),
							$html->div('title title3',$html->link('Lo más reciente','javascript:;',array('class'=>'tipCaller','rel'=>'Conoce las últimas actualizaciones del observatorio.'))),
							$html->tag('ul');

							foreach ($last_items as $last_it) {
								$li_model = key($last_it);
								$atts = array();
								if($last_it[$li_model]['externo'])
									$atts = array('target'=>'_blank','rel'=>'nofollow');

								echo
									$html->tag('li'),
										$html->link(
											$html->tag('span',$util->fdate('%d/%b/%y',$last_it[$li_model]['created']),'date').
											$html->tag('span',$last_it[$li_model]['nombre'].' en '.$alias[$li_model]),
											$last_it[$li_model]['url'],
											$atts
										),
									'</li>';
							}

							echo '</ul>',
						'</div>';
				}

				# ---------------------------
			echo '</div>',
			'</div>',
		$moo->tabs('tabsHome');
?>
</div>
</div>