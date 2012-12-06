<?php
echo $this->element('top');

	if($item){
		echo
			$html->tag('h2',$item[$_m[0]]['nombre'],'sectionTitle daysone'),
			$util->th($item[$_m[0]],false,array('w'=>680,'class'=>'aboutTh')),
			$html->div(null,$item[$_m[0]]['descripcion'],array('id'=>'aboutText'));
		}
?>
</div>
</div>
<?php echo $this->element('sidebar'); ?>