<?php
/**
 $('#slider').nivoSlider({
	effect:'random', // Efecto de transición: 'fold,fade,sliceDown'
	slices:15, // Para animaciones 'slice'
	boxCols: 8, // Para animaciones 'box'
	boxRows: 4, // Para animaciones 'box'
	animSpeed:500, // Velocidad de la transición
	pauseTime:3000, // Cuánto tiempo en milisegundos se visualiza una imagen
	startSlide:0, // Imagen de comienzo (empezando por cero)
	directionNav:true, // Si queremos que aparezcan controles para siguiente y anterior
	directionNavHide:true, // Sólo cuando el cursor se sitúa sobre el componente
							   se visualizará la navegación
	controlNav:true, // 1,2,3... navegación
	controlNavThumbs:false, // Usar miniaturas para el control de la navegación
	controlNavThumbsFromRel:false, // Usar imagen rel para miniaturas
	controlNavThumbsSearch: '.jpg', // Reemplazar este patrón del nombre de la imagen...
	controlNavThumbsReplace: '_thumb.jpg', // ...con esto para las imágenes miniatura
	keyboardNav:true, // Usar las flechas izquierda y derecha para navegación
	pauseOnHover:true, // Parar navegación al pasar el ratón sobre el componente
	manualAdvance:false, // Forzar transiciones manuales
	captionOpacity:0.8, // Opacidad para los caption o títulos de las imágenes
	prevText: 'Ant', // Texto de navegación hacia la izquierda
	nextText: 'Sig', // Texto de navegación hacia la derecha
	beforeChange: function(){}, // Función que se ejecuta antes de una transición
	afterChange: function(){}, // Función que se ejecuta después de una transición
	slideshowEnd: function(){}, // Función que se ejecuta después de que todas
								   las imágenes se han mostrado
	lastSlide: function(){}, // Función que se ejecuta cuando la última imagen se visualiza
	afterLoad: function(){} // Función que se ejecuta cuando se carga el componente
});
 */

/**
 * Nivo Slider images
 * 
 * @autor Javier Lema <touzas@gmail.com>
 */
class TSlider extends CWidget {
	
	var $images;
	var $width;
	var $height;
	var $alt;
	var $id;
	
	public function init(){		
		
		$dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
		$baseUrl = Yii::app()->getAssetManager()->publish($dir);

		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/jquery.nivo.slider.js', CClientScript::POS_END);
		$cs->registerCssFile($baseUrl.'/nivo-slider.css', 'screen');
		$cs->registerCssFile($baseUrl.'/default.css');
		
		if ($this->id == '')
			$this->id = 'Slider'.date('YmdHis');
		
		$cs->registerScript($this->id, "
			$('#".$this->id."').nivoSlider({
				directionNav: false,
				directionNavHide:false,
				controlNav:false,
				animSpeed:500,
				pauseTime:3000,
			}); 
		", CClientScript::POS_LOAD);				
	}
	
	private function parse2stdClass($array){ 		 
		$tmp = new stdClass();
		foreach($array as $k => $v){
			$tmp->{$k} = $v;			
		}
		return $tmp;
        }	
	
	public function run(){
		echo '
			<div id="'.$this->id.'" class="slider" style="width:'.$this->width.'px; height: '.$this->height.'px">
		';
		if (is_array($this->images)){
			foreach($this->images as $img){
				$img = $this->parse2stdClass($img);				
				if (isset($img->url))
					echo CHtml::link(CHtml::image($img->image, $this->alt, array('width' => $this->width, 'height' => $this->height)), $img->url);
				else
					echo CHtml::image($img->image, $this->alt, array('width' => $this->width, 'height' => $this->height));
			}
		}								
		echo '
			</div>
		';
	}
}
?>
