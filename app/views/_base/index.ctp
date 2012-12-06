<?php
echo
	$this->element('top'),
	$this->element('crumbs');
	
	if($items){
		foreach($items as $item)
			echo $this->element('th',array('item'=>$item));
			
		echo $this->element('pages');
	} else 
		echo $html->para('noresults','No hay elementos que mostrar');
?>
</div>
</div><!-- .content -->
<?=$this->element('sidebar')?>