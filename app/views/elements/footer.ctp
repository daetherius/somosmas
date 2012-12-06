<?php
$src = '';
if(!empty($_sede)){	$src = $_sede.'_'; }

echo
	$html->div('footer'),
	$html->div('center'),
		$html->div('banners'),
			$html->link($html->image('logos/f01.png'),'javascript:;'),
			$html->link($html->image('logos/'.$src.'f02.png'),'javascript:;'),
			$html->link($html->image('logos/'.$src.'f03.png'),'javascript:;'),
		'</div>',
		// Esta actividad es financiada con recursos federales del SUBSEMUN 2011, el cual es un programa de carácter público, y no es patrocinado ni promovido por partido alguno y sus recursos provienen de los impuestos que pagan todos los contribuyentes. Está prohibido el uso de este programa con fines políticos, electorales, de lucro y otros distintos a los establecidos. Quien haga uso indebido de los recursos de este programa deberá ser denunciado y sancionado de acuerdo con la Ley aplicable y ante la autoridad competente. 
		$html->para('legend','SUBSEMUN &copy; '.date('Y').'. Este programa es público, ajeno a cualquier partido político. Queda prohibido el uso para fines distintos a los establecidos en el programa.<br/>Última actualización: '.$last_update.' hrs');
?>
</div><!-- .center -->
</div><!-- .footer -->