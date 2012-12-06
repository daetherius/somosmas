<?php
echo
	$this->element('top'),
	$this->element('crumbs'),
	$html->div('detail clear'),
		$html->tag('h1',$item[$_m[0]]['nombre'],array('class'=>'pTitle')),
		$html->tag('p',$util->fdate('s',$item[$_m[0]]['created']),array('class'=>'pDate'));
		
		if($item[$_m[0]]['tipo'] == 'Video'){
			if($item[$_m[0]]['url']){
				echo $util->youtube($item[$_m[0]]['url']);
			}
		} else {
			echo $this->element('inlinegallery',array('data'=>$item[$_m[0].'img'],'model'=>$_m[0].'img'));
		}
	
		echo $html->div('pBody tmce',''.$item[$_m[0]]['descripcion']),
		
		///////
	
		$this->element('addthis'),
	'</div>',
	$this->element('comments');
?>
</div>
</div><!-- content -->
<?php echo $this->element('sidebar'); ?>