<?php
$autor = $data['autor'];

echo
	$html->div('comment'.(isset($odd) && $odd ? ' odd':''),null,array('id'=>'comment_'.$data['id'])),
		$html->link('','',array('name'=>'comment_'.$data['id'])),
		$html->div('cName',$autor),
		$html->para('cDate',$util->fdate('l',$data['created'])),
		$html->div('cBody',$util->txt($data['descripcion'])),
'</div>';


if($this->params['isAjax']){ ?>
	<script type="text/javascript">
		$('CommentPublicarForm').reset();
		formtips.detach('.input_error');
		$$('.input_error').removeClass('input_error');
		new Fx.Slide("comment_<?=$data['id']?>", {duration: 800}).hide().slideIn();
		new Fx.Scroll(window,{ duration:900,transition:Fx.Transitions.Quint.easeInOut }).toElement("comment_<?=$data['id']?>");
	</script>
<? } ?>