<?php
echo
	$this->element('top'),
	$this->element('crumbs');
	
	if(isset($_program) && $_program){
		echo $html->tag('h2',$_program['Category']['nombre'],'programTitle');
	}
	
	echo $this->element('poll');
	
	if($items){
		foreach($items as $item)
			echo $this->element('thtl',array('item'=>$item, 'model'=>Inflector::classify($item['Timeline']['parent'])));
			
		echo $this->element('pages',array('model'=>'Timeline'));
	} else 
		echo $html->para('noresults','No hay elementos que mostrar');
?>
</div>
</div><!-- .content -->
<?=$this->element('sidebar')?>