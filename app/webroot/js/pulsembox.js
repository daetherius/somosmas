/*
* Pulsembox v20090512 by Daniel Portales for mootools 1.2 based on
* Boris Popoff's Smoothbox (http://gueschla.com) which was based on
* Cody Lindley's Thickbox under a MIT License.
* Pulsembox is licensed under the MIT License: http://www.opensource.org/licenses/mit-license.php

PBoxOverlay - removeBox
PBoxCloseButton - removeBox
PBoxImageClose - removeBox
PBoxPrev - changeImage
PBoxext - changeImage

28/06/10 - Fix del parsing a entero de los params en la url
28/03/11 - Evita repetir anclas a una misma imagen en un grupo (galería)
*/
var Pulsembox = new Class({
	Implements: Options,
	options: {
		prev:"<img src='/img/pbox/prev.png' alt='Anterior' />",
		next:"<img src='/img/pbox/next.png' alt='Siguiente' />",
		cerrar:"<img src='/img/pbox/cerrar.png' alt='Cerrar' />",
		overlay_duration:150,
		transition_duration:550
	},
	overlayFx:false,
	loaderFx:false,
	boxFx:false,
	boxScrollFx:false,
	isShowing:false,
	isReady:true,
	isHTML:false,
	boxWidth:0,
	boxHeight:0,
	isChanging:false,
	galleries:{},
	loaderImage:"/img/pbox/pulsembox-loader",

	initialize: function(options){
		this.setOptions(options);
		this.prevHTML = this.options.prev;
		this.nextHTML = this.options.next;
		this.closeHTML = this.options.cerrar;
		this.overlay_duration = this.options.overlay_duration;
		this.transition_duration = this.options.transition_duration;
		
		$$('a.pulsembox').each(function(el){
			this.setGalleries(el);
			el.addEvent('click',function(e){ this.binder(e); }.bindWithEvent(this));
		}.bind(this)); 
		//for(prop in this.galleries) alert(prop +" "+this.galleries[prop]);
		
	},
	setGalleries: function (el){
		if (this.isImageURL(el.href)){ // Si es imagen a mostrar
			if(group = el.get('rel') || false){
				if(group in this.galleries){
					if(this.galleries[group].every(function(item){ return item.href != el.href; })){
						this.galleries[group][this.galleries[group].length] = el;
					}
				} else
					this.galleries[group] = [el];
			}
		}
	},
	isImageURL: function(url){
		var baseURL = (matchURL = url.match(/(.+)\?/)) ? matchURL[1]:url;
		var imageURL = /\.(jpe?g|png|gif|bmp)/gi;// regex to check if a href refers to an image
		return baseURL.match(imageURL) ? true:false;
	},
	binder: function (event){
		var event = new Event(event);
		event.stopPropagation();
		event.preventDefault();

		var el = $(event.target).get('tag').toLowerCase() != 'a' ? event.target.getParent('a'):event.target;//obtenemos el anchor caller
		el.blur();
	
		var caption = el.title || el.name || '';
		var group = el.rel || false;
		var href = el.href || false;

		this.showOverlay();
		this.prepareBox(caption,href,group);
	},
	showOverlay: function (){
		this.isShowing = true;
		this.isChanging = false; 
		if (!$('PBoxOverlay')) { //Si no hay overlay aún..
			new Element('div',{ id:'PBoxOverlay', styles:{ 'opacity':0 }}).inject(document.body);
			
			if(!this.overlayFx) this.overlayFx = new Fx.Tween('PBoxOverlay',{ property:'opacity', duration:this.overlay_duration, link:'chain' });
				
		} else
			$$('#PulsemBox,#PBoxOverlay').setStyle('display','block');
		
		$('PBoxOverlay').removeEvents();
		$('PBoxOverlay').addEvent('click',function(){ this.removeBox(); }.bindWithEvent(this));
		
		// Listeners
		this.scrollListener = function(){ this.moveBox(); }.bind(this);
		this.keyListener = function(e){
			var event = new Event(e);
			switch (event.code) {
				case 27: this.removeBox(); break;
				case 39: if ($('PBoxNext')) this.changeImage(this.next,this.rel); break;
				case 37: if ($('PBoxPrev')) this.changeImage(this.prev,this.rel); break;
			} return false;
		}.bindWithEvent(this);
		this.resizeListener = function(){
			if(this.isShowing){
				this.moveBox();
				this.moveLoader();
				this.setOverlay();
			}
		}.bindWithEvent(this);
		
		$(window).addEvent('scroll',this.scrollListener);
		$(document).addEvent('keyup',this.keyListener);		
		$(window).addEvent('resize',this.resizeListener);
		
		this.setOverlay();
		this.overlayFx.start(0.7);
	},
	moveBox: function(){
		//$('PBoxOverlay').setStyle('left', window.getScrollLeft()+'px'); Webkit scroll bar extra space
		if(this.boxScrollFx)
			this.boxScrollFx.start({
				width: this.boxWidth,
				height: this.boxHeight,
				left: (window.getScrollLeft() + (window.getWidth() - this.boxWidth) / 2)+'px',
				top: (window.getScrollTop() + (window.getHeight() - this.boxHeight) / 2)+'px'
			});
	},
	setOverlay: function (){
		$$('#PBoxOverlay,#PBoxFrame').setStyles({ 'height': 0 }); // we have to set this to 0px before so we can reduce the size / width of the overflow onresize
		$$('#PBoxOverlay,#PBoxFrame').setStyles({ 'height': window.getScrollSize().y+'px' });
	},
	prepareBox: function(caption, url, rel){
		if(!this.isReady) return false;
		
		this.isReady = false;
		this.rel = rel;
		if (!$('PulsemBox')){
			new Element('div',{id:'PulsemBox', styles:{ 'opacity':0 }}).inject(document.body);
			this.boxFx = new Fx.Morph('PulsemBox',{ duration:this.transition_duration,link:'chain',transition:'Quint:in:out' });
			this.boxScrollFx = new Fx.Morph('PulsemBox',{ duration:this.transition_duration,link:'cancel',transition:'Quint:in:out' });
		}

		this.showLoader();
		
		/////
		if(this.isImageURL(url)){
			this.isHTML = false;
			this.prev = { caption: '', url: '', html: '' };
			this.next = { caption: '', url: '', html: '' };
			var imageCount = '';

			if(rel) { // if an image group is given
				var foundSelf = false;
				var gallength = this.galleries[rel].length;
				
				for (var i=0; i < gallength; i++) {
					var image = this.galleries[rel][i];

					// look for ourself
					if (image.href == url) {
						foundSelf = true;
						imageCount = '<span id="PBoxNav">'+(i+1)+' de '+(this.galleries[rel].length)+'</span>';
					} else {
						if (foundSelf) { // when we found ourself, the current is the next image
							this.next = this.getInfo(image, 'Next', this.nextHTML);
							break;
						} else this.prev = this.getInfo(image, 'Prev', this.prevHTML); // didn't find ourself yet, so this may be the one before ourself
					}
				}
			}

			imgPreloader = new Image();
			imgPreloader = $(imgPreloader);
			imgPreloader.addEvent('load', function(){
				imgPreloader.removeEvents();
				this.imgLoading = true;

				/// Setup HTML
					$('PulsemBox').set('html','');// Deberá limpiarse u ocultar dependiendo de la cantidad de eventos que se asignen a los nodos internos
					
					new Element('div',{ id:'PBoxHeader', html:this.prev['html'] + imageCount + this.next['html'] }).inject('PulsemBox');
					new Element('a',{ id:'PBoxCloseButton', href:'javascript:;', title:'Cerrar esta ventana', html: this.closeHTML, events:{ 'click':function(){ this.removeBox(); }.bindWithEvent(this) } }).inject('PBoxHeader');
					new Element('a',{ id:'PBoxImageClose', title :'Clic para cerrar esta ventana', href :'javascript:;', events:{ 'click':function(){ this.removeBox(); }.bindWithEvent(this) } }).inject('PulsemBox');
					new Element('img',{
						id:'PBoxImage',
						src:url,
						styles:{
							display:'none',
							opacity:0,
							alt:caption
						}
					}).inject('PBoxImageClose');
					
					new Element('div',{ id:'PBoxCaption','html':caption }).inject('PulsemBox').fade('hide');

				//// Ajuste máximo de tamaño de la imagen
					var x = window.getWidth() - 100;
					var y = window.getHeight() - 60 - $('PBoxCaption').getDimensions().height; // Dejar espacio para el PBoxHeader (46px) + Caption (Máx. 130px) + Borde de Imagen principal (2x 2px = 4px ) + Plus 10px

					var imgWidth = imgPreloader.width;
					var imgHeight = imgPreloader.height;

					if (imgWidth > x){
						imgHeight = imgHeight * (x / imgWidth); imgWidth = x;
						if (imgHeight > y){ imgWidth = imgWidth * (y / imgHeight); imgHeight = y;}
					} else {
						if (imgHeight > y) {
							imgWidth = imgWidth * (y / imgHeight); imgHeight = y;
							if (imgWidth > x) { imgHeight = imgHeight * (x / imgWidth); imgWidth = x;}
						}
					}
					
					$('PBoxImage').setStyle('height',imgHeight+'px');
					$('PBoxImage').setStyle('width',imgWidth+'px');
					
					this.boxWidth = imgWidth + 4; // PBoxImage 2px x 2 Border
					this.boxHeight = 46 + 4 + $('PBoxCaption').getDimensions().height + imgHeight;// Calculamos el espacio real ocupado por partes: Header + 2 Bordes 2px + PBoxCaption + Alto imagen

				//// Eventos
					if ($('PBoxPrev')) $("PBoxPrev").addEvent('click',function(){ this.changeImage(this.prev,rel); }.bindWithEvent(this));
					if ($('PBoxNext')) $("PBoxNext").addEvent('click',function(){ this.changeImage(this.next,rel); }.bindWithEvent(this));

				//// SHOW
					this.moveBox();// Setea el ancho de la nueva imagen
					this.showBox();
			}.bindWithEvent(this));

			this.imgLoading = false;
			imgPreloader.src = url;
		
		} else { /// Es HTML
			this.isHTML = true;
			var queryString = (matchURL = url.match(/\?(.+)/)) ? matchURL[1]:false; //var queryString = url.match(/\?(.+)/)[1];
			var params = this.getParams(queryString);

			var ajaxContentW = (params['width']).toInt(), ajaxContentH = (params['height']).toInt();
			
			/// Reajustar tamaño
			var x = window.getWidth() - 100;
			var y = window.getHeight() - 56; // Dejar espacio para el PBoxHeader (46px) + Plus 10px
			var changedHeight = false;
			
			ajaxContentW = ajaxContentW > x ? x : ajaxContentW;
			var changedHeight = ajaxContentH > y;
			ajaxContentH = changedHeight ? y : ajaxContentH;
			ajaxContentW  = changedHeight ? ajaxContentW + 12 : ajaxContentW;// Espacio extra para la barra de desplazamiento vertical
				
			this.boxHeight = ajaxContentH + 56;
			this.boxWidth = ajaxContentW;

			$('PulsemBox').set('html','');// Deberá limpiarse u ocultar dependiendo de la cantidad de eventos que se asignen a los nodos internos
			new Element('div',{ id:'PBoxHeader' }).inject('PulsemBox');
			new Element('a',{
				id:'PBoxCloseButton',
				href:'javascript:;',
				title:'Cerrar esta ventana',
				html: this.closeHTML,
				events:{ 'click':function(){ this.removeBox(); }.bindWithEvent(this) }
			}).inject('PBoxHeader');
			new Element('div',{ id:'PBoxAjaxContent',styles:{ width: ajaxContentW+'px', height: ajaxContentH+'px' } }).inject('PulsemBox');

			$("PBoxCloseButton").addEvent('click',function(){ this.removeBox() }.bindWithEvent(this));

			if (url.indexOf('#PBoxInline?') != -1) { // inline
				$("PBoxAjaxContent").set('html',$(params['inlineId']).get('html'));
				this.moveBox();
				this.showBox();
			} else if(url.indexOf('PBoxFrame') != -1){ // Frame
				/*
				this.moveBox();
				if (frames['PBoxFrameContent'] == undefined) {//be nice to safari
					$(document).keyup(function(e){
						var key = e.keyCode;
						if (key == 27) this.removeBox();
					});
					this.showBox();
				}
				*/
			} else {
				new Request.HTML({
					method: 'get',
					url:url,
					update: $("PBoxAjaxContent"),
					onComplete: function(){ this.moveBox();this.showBox(); }.bind(this),
					evalScripts: true
				}).get();
			}
		} 
	},
	showLoader: function (){
		if(!this.imgLoading){
			if (!$("PBoxLoader")){
				new Element('div',{ id:'PBoxLoader',styles:{ 'opacity':0 } }).inject(document.body);
				this.loaderFx = new Fx.Tween('PBoxLoader',{ property:'opacity', duration:200, link:'chain' });
			}
			
			$("PBoxLoader").set('html','<img src="'+this.loaderImage+'.gif" alt="Cargando..." />');
			
			this.moveLoader();
			this.loaderFx.start(1);
		}
	},
	moveLoader: function(){
		if ($("PBoxLoader")){
			var PBoxLoaderImg = $("PBoxLoader").getElement("img");
			$("PBoxLoader").setStyles({
				left: (window.getScrollLeft() + (window.getWidth() - PBoxLoaderImg.getSize().x) / 2),
				top: (window.getScrollTop() + (window.getHeight() - PBoxLoaderImg.getSize().y) / 2)
			});
		}
	},
	showBox: function(){
		if(this.loaderFx){
			this.loaderFx.start(0).chain(function(){
				if(this.boxFx){
					this.boxFx.start({'opacity':1}).chain(function(){
						if(!this.isHTML){
							$("PBoxImage").setStyle("display","block");
							$("PBoxImage").fade("in");
							$("PBoxCaption").fade("in");
						}
						this.isReady = true;
						this.isChanging = true;
					}.bind(this));
				}
			}.bind(this));
		}

		/*
		} else {
			if($('PBoxLoader')){
				this.loaderFx.start(0).chain(function(){ 
					$('PulsemBox').setStyle('opacity', 1);
				}.bind(this));
			}
		}
		*/
	},
	getParams: function(query){
		var params = {};
		if (!query) return params;

		var pairs = query.split(/[;&]/);
		for (var i = 0; i < pairs.length; i++) {
			var pair = pairs[i].split('=');
			if (!pair || pair.length != 2) continue;
			params[unescape(pair[0])] = unescape(pair[1]).replace(/\+/g,' '); // unescape both key and value, replace "+" with spaces in value
		}
		return params;
	},
	getInfo: function(image, id, controlHTML){
		return { caption: image.title || image.name || "", url: image.href, html: "<a id='PBox" + id + "' href='javascript:;'>"+controlHTML+"</a>" }
	},
	changeImage: function(image,rel){
		if(!this.isReady) return false;
		this.prepareBox(image.caption, image.url, rel);
	},
	removeBox: function(){
		if(!this.isReady) return false;
		this.isReady = false;
		if ($('PBoxPrev')) $("PBoxPrev").removeEvents();
		if ($('PBoxNext')) $("PBoxNext").removeEvents();
		
		$('PBoxOverlay').removeEvents();
		$('PBoxCloseButton').removeEvents(); 

		if($('PBoxImageClose')) $('PBoxImageClose').removeEvents(); 
		if($('PBoxAjaxClose')) $('PBoxAjaxClose').removeEvents();

		$(window).removeEvent('scroll',this.scrollListener);
		$(window).removeEvent('resize',this.resizeListener);
		$(document).removeEvent('keyup',this.keyListener);		

		this.boxFx.start({'opacity':0}).chain(function(){
			this.overlayFx.start(0).chain(function(){
				$$('#PBoxOverlay,#PulsemBox').setStyle('display','none');
				this.isShowing = false;
				this.isReady = true;
			}.bind(this));
		}.bind(this));
	}
});

window.addEvent('domready', function(){ new Pulsembox(); });
