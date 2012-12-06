<div class="sidebar">
<div class="pad">
<?php
echo
	$this->element('sidemenu'),
	$html->div(null,$this->element('banners'),array('id'=>'banners')), $moo->showcase('banners',array('nav'=>'out'));

	if($this->params['controller'] == 'about'){
	echo
		$html->div('clear'),
			$html->tag('iframe','',array(
				'src'=>'//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FSomos-m%25C3%25A1s-haciendo-paz%2F101752749950715&width=230&height=590&colorscheme=light&show_faces=true&border_color=%23DD1F7D&stream=true&header=false',
				'scrolling'=>'no',
				'frameborder'=>0,
				'style'=>'border:none; overflow:hidden; width:230px; height:590px;background-color:#eee',
				'allowTransparency'=>'false'
			)),

			$html->script('http://widgets.twimg.com/j/2/widget.js',array('inline'=>true)),
			$html->scriptBlock('new TWTR.Widget({
			  version: 2,
			  type: "profile",
			  rpp: 3,
			  interval: 30000,
			  width: 230,
			  height: 300,
			  theme: {
			    shell: {
			      background: "#DD1F7D",
			      color: "#ffffff"
			    },
			    tweets: {
			      background: "#f3f3f3",
			      color: "#444444",
			      links: "#DD1F7D"
			    }
			  },
			  features: {
			    scrollbar: false,
			    loop: false,
			    live: false,
			    behavior: "all"
			  }
			}).render().setUser("SomosMasHPaz").start();',array('inline'=>true)),
		'</div>';		
	}
?>
</div>
</div>