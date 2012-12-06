<?php
if(isset($item['Comment'])){
echo
	$html->div(null,null,array('id'=>'comments')),
	$html->div(null,$item['Comment'] ? '('.sizeof($item['Comment']).') Comentarios':'No hay Comentarios aún',array('id'=>'commentsHdr'));
	
	if($item['Comment']){
		$odd = false;
		foreach($item['Comment'] as $comment){
			echo $this->element('comment',array('data'=>$comment,'odd'=>$odd));
			$odd = !$odd;
		}
	}
	
	echo '</div>',
	
	//////
	
	$form->create('Comment',array('action'=>'publicar','id'=>'CommentPublicarForm')),
	$html->div(null,null,array('id'=>'commentBox')),
		
		$html->div('title title2','Deja tu Comentario'),
		
		$html->div('subform'),
			$form->input('name',array('div'=>'hide')),
			$form->input('autor',array('label'=>'Nombre:')),
			$form->input('email',array('label'=>'Email:')),
			$form->input('parent',array('value'=>$_m[0],'type'=>'hidden')),
			$form->input('parent_id',array('value'=>$item[$_m[0]]['id'],'type'=>'hidden')),
			$form->input('descripcion',array('label'=>'Comentario:')),
			$form->submit('Enviar'),
		'</div>',
	'</div>',
	$form->end(),
	$moo->addEvent('CommentPublicarForm','submit',array('url'=>'/comments/publicar','prevent'=>true,'append'=>'"comments"','data'=>'"CommentPublicarForm"','fade'=>1));
}
?>