<?php
echo $html->div(null,null,array('id'=>'crumbs'));
	
	if($this->params['controller']=='categories'){
		$base = array('category'=>'','program'=>'','type'=>'','subtype'=>'','action'=>'index');
		echo $html->link($_ts,$base);
		
		if(isset($_category) && $_category){
			$base['category'] = $_category['Category']['slug'];
			echo $html->link($_category['Category']['nombre'],$base);
		}

		if(isset($_program) && $_program){
			$base['program'] = $_program['Category']['slug'];
			echo $html->link($_program['Category']['nombre'],$base);
		}

		if(isset($this->params['type']) && $this->params['type']){
			$base['type'] = $this->params['type'];
			
			if(strtolower($this->params['type']) == 'ligas')
				$typelabel = 'Sitios de interés';
			else
				$typelabel = _typmap($this->params['type'],'type','label');
				
			echo $html->link($typelabel,$base);
		}

		if(isset($this->params['subtype']) && $this->params['subtype']){
			$base['subtype'] = $this->params['subtype'];
			
			echo $html->link(ucfirst($this->params['subtype']),$base);
		}

	} elseif($this->params['controller']=='albums'){
		$base = array('category'=>'','type'=>'','action'=>'index');
		echo $html->link($_ts,$base);
		
		if(isset($_category) && $_category){
			$base['category'] = $_category['Category']['slug'];
			echo $html->link($_category['Category']['nombre'],$base);
		}

		if(isset($this->params['type']) && $this->params['type']){
			$base['type'] = $this->params['type'];
			echo $html->link(ucfirst($this->params['type']),$base);
		}

	} elseif(isset($path) && $path){
		echo $html->link($_ts,array('action'=>'index'));
		foreach($path as $link){
			echo $html->link($link['Category']['nombre'],array('action'=>'categoria',$link['Category']['slug']));
		}
	}
	
	echo '</div>';
?>