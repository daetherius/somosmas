<?php
$subtype = isset($this->params['type']) && $this->params['type'] ? $this->params['type'] : '';
echo
	$this->element('top'),
	$this->element('crumbs'),
	$html->div('subtypes'),
		$html->link('Todo',array('type'=>''),array('class'=>$subtype == '' ? 'selected':'')),
		$html->link('Fotos',array('type'=>'fotos'),array('class'=>$subtype == 'fotos' ? 'selected':'')),
		$html->link('Video',array('type'=>'video'),array('class'=>$subtype == 'video' ? 'selected':'')),
	'</div>';
	
	if($items){
		foreach($items as $item)
			echo $this->element('th',array('item'=>$item));
			
		echo $this->element('pages');
	} else 
		echo $html->para('noresults','No hay elementos que mostrar');
?>
</div>
</div><!-- .content -->
<?php echo $this->element('sidebar');?>