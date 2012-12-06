<ul id="menu">
<?php
echo $html->tag('li',$html->link($html->tag('span', 'inicio'),'/',array('class'=>$this->params['controller']=='inicio' ? 'mSelected' : '')));
foreach(Configure::read('Site.menu') as $sectionCtllr => $sectionLbl){
	$submenu = '';
	if($sectionCtllr == 'categories'){
		$url = array('controller'=>$sectionCtllr,'action'=>'index','category'=>'','program'=>'','type'=>'');
		
		if($pcategories = Cache::read('category_recent')){
			$submenu = $html->tag('ul',null,'submenu');
			foreach($pcategories as $pcateg){
				$suburl = array('controller'=>'categories','category'=>$pcateg['Category']['slug'],'type'=>'','program'=>'');
				$submenu.= $html->tag('li',$html->link($pcateg['Category']['nombre'],$suburl));
			}
			$submenu.= '</ul>';
		}
	}
	else
		$url = array('controller'=>$sectionCtllr,'action'=>'index','type'=>'','program'=>'');
	//fb($url,$sectionCtllr);
	echo
		$html->tag('li',
			$html->link(
				$html->tag('span',is_array($sectionLbl) ? $sectionLbl[1] : $sectionLbl),
				$url, // url
				array('class'=>$this->params['controller'] == $sectionCtllr ? 'mSelected' : '')
			).$submenu
		);
}
$script = 'var submenu = $$("#menu .submenu");
submenu.set("tween",{ duration:"short" }).fade("hide").setStyle("display","block");
submenu.getParent("li").addEvents({
	"mouseenter":function(){ this.fade("in"); }.bind(submenu),
	"mouseleave":function(){ this.fade("out"); }.bind(submenu)
});';
$moo->buffer($script);
?>
</ul>

