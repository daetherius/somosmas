<?php
echo
	$this->element('top'),
	$html->div('clear'),
		$html->div('form'),
			$html->div('title title2','deja tu mensaje'),
			$html->para('note',''),
	
			$form->create('Contact',array('id'=>'ContactForm','url'=>'/contacto/enviar')),
			$form->input('mail',array('div'=>'hide')),
			$html->div('subform'),
				$form->input('nombre',array('label'=>'Nombre:')),
				$form->input('email',array('label'=>'E-mail:')),
				$form->input('mensaje',array('label'=>'Mensaje:','rows'=>9,'cols'=>35)),
				$html->para('leydatos','Sus datos serán usados de acuerdo a los términos de la '.$html->link('Ley Federal de Protección de Datos Personales','http://dof.gob.mx/nota_detalle.php?codigo=5150631&fecha=05/07/2010',array('target'=>'_blank','rel'=>'nofollow'))),
				$form->submit('Enviar'),
			'</div>',
			$form->end(),
		'</div>',
		$html->div('info'),
			$html->div('title title3 phone','teléfonos'),
			$html->para(null,'(999) 9.20.90.70'),

			$html->div('title title3 mail','correo electrónico'),
			$html->para(null,$util->ofuscar(Configure::read('Site.email'),true)),

			$html->div('title title3 office','oficinas'),
			$html->para(null,'Calle 14 No. 114 por Avenida Cupules Col. García Ginerés'),

			$html->div(null,$this->element('banners'),array('id'=>'banners')), $moo->showcase('banners',array('nav'=>'out')),
		/*
		*/
		'</div>',
	'</div>',

	$moo->ajaxform('ContactForm');
?>
</div>
</div>