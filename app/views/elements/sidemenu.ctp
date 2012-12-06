<?php
if($this->params['controller']=='categories'){
	$categories = Cache::read('category_program_recent');fb($categories,'$categories');
	if($categories && isset($categories[(int)$this->params['category']]) && $categories = $categories[(int)$this->params['category']]){
		echo
			$html->div('programas bulleted'),
				$html->tag('ul');
				
				foreach($categories as $cat){
					$nombre = $cat['nombre_corto'] ? $cat['nombre_corto'] : $cat['nombre'];
					$programSelected = $cat['id'] == (int)$this->params['program'] ? 'selected' :'';
					
					echo
						$html->tag('li',null, $programSelected),
							$html->link($nombre,array('controller'=>'categories','program'=>$cat['slug'],'type'=>'','action'=>'index'));
						
						if($programSelected && $sections = Cache::read($cachekey)){
							echo
								$html->tag('ul'),
								$html->tag('li',$html->link('Recientes',array('controller'=>'categories','program'=>$cat['slug'],'type'=>'','action'=>'index')), (!(isset($this->params['type']) && $this->params['type'])) ? 'selected' :'');
								
							foreach($sections as $section){
								if($section == 'ligas')
									$seclabel = 'Sitios de Interés';
								else
									$seclabel = ucfirst($section);
							
							
								if($section != 'encuesta')
									echo $html->tag('li',$html->link($seclabel,array('controller'=>'categories','action'=>'index','program'=>$cat['slug'],'type'=>Inflector::slug($section))), isset($this->params['type']) && $this->params['type'] == Inflector::slug($section) ? 'selected' :'');
							}

							echo '</ul>';
						}
					
					echo '</li>';
					
				}
				
				echo '</ul>',
			'</div>';
	}
}elseif($this->params['controller']=='albums'){
	if($categories = Cache::read('category_recent')){

		$programSelected = '';
		if(!(isset($this->params['category']) && $pid = (int)$this->params['category'])){
			$programSelected = 'selected';
		}

		echo
			$html->div('programas bulleted'),
				$html->tag('ul'),
				$html->tag('li',
					$html->link('Mostrar todo',array('controller'=>'albums','category'=>'','type'=>'','action'=>'index')),
					$programSelected
				);
				
				foreach($categories as $cat){
					$programSelected = '';
					
					if(isset($this->params['category']) && $pid = (int)$this->params['category']){
						if($cat['Category']['id'] == $pid)
							$programSelected = 'selected';
					}
					
					echo
						$html->tag('li',
							$html->link($cat['Category']['nombre'],array('controller'=>'albums','category'=>$cat['Category']['slug'],'action'=>'index')),
							$programSelected
						);
				}
				
				echo '</ul>',
			'</div>';
	}	
}
?>