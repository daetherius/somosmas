<?php
echo
	$this->element('adminhdr',array('links'=>array('back'))),
	$html->div('OrderContainer'),
		$form->create($_m[0],array('url'=>$this->here)),
		$html->tag('p',$form->submit('Guardar Cambios',array('div'=>false,'class'=>'submitRt')).$html->image('admin/handlerguide.gif').' Haga clic en estos botones y arrastre para reordenar la lista.',array('id'=>'elist_instructions')),
		$moo->elist($_m[0],
			array('id','nombre'=>array('hide'=>0,'edit'=>0)),
			array('data'=>$orderdata,'sort'=>1)
		,array('id'=>$_m[0].'_elist')),
		$form->end(),
	'</div>';
?>
