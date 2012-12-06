<?php
$w = $item[$_m[0]]['layout'] == 'Centro' ? 640 : 320;
$class = 'float';

if(isset($item[$_m[0]]['layout']) && $item[$_m[0]]['layout'])
	$class = 'pulsembox postFrontimg postFrontimg'.$item[$_m[0]]['layout'];
	
echo
	$this->element('top'),
	$this->element('crumbs'),
	$html->div('detail clear'),
		$html->tag('h1',$item[$_m[0]]['nombre'],array('class'=>'pTitle')),
		$html->tag('p',$util->fdate('s',$item[$_m[0]]['created']),array('class'=>'pDate')),

		$util->th($item,$_m[0],array('w'=>$w,'h'=>380,'class'=>$class)),
		$html->div('pBody tmce',$item[$_m[0]]['descripcion']),
		$this->element('slider',array('model'=>$_m[0].'img','data'=>$item[$_m[0].'img'])),
		
		///////
	
		$this->element('addthis'),
	'</div>',
	$this->element('comments');
?>
</div>
</div><!-- content -->
<?php echo $this->element('sidebar'); ?>