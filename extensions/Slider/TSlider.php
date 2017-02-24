<?php
/**
 $('#slider').nivoSlider({
	effect:'random', // Efecto de transici�n: 'fold,fade,sliceDown'
	slices:15, // Para animaciones 'slice'
	boxCols: 8, // Para animaciones 'box'
	boxRows: 4, // Para animaciones 'box'
	animSpeed:500, // Velocidad de la transici�n
	pauseTime:3000, // Cu�nto tiempo en milisegundos se visualiza una imagen
	startSlide:0, // Imagen de comienzo (empezando por cero)
	directionNav:true, // Si queremos que aparezcan controles para siguiente y anterior
	directionNavHide:true, // S�lo cuando el cursor se sit�a sobre el componente
							   se visualizar� la navegaci�n
	controlNav:true, // 1,2,3... navegaci�n
	controlNavThumbs:false, // Usar miniaturas para el control de la navegaci�n
	controlNavThumbsFromRel:false, // Usar imagen rel para miniaturas
	controlNavThumbsSearch: '.jpg', // Reemplazar este patr�n del nombre de la imagen...
	controlNavThumbsReplace: '_thumb.jpg', // ...con esto para las im�genes miniatura
	keyboardNav:true, // Usar las flechas izquierda y derecha para navegaci�n
	pauseOnHover:true, // Parar navegaci�n al pasar el rat�n sobre el componente
	manualAdvance:false, // Forzar transiciones manuales
	captionOpacity:0.8, // Opacidad para los caption o t�tulos de las im�genes
	prevText: 'Ant', // Texto de navegaci�n hacia la izquierda
	nextText: 'Sig', // Texto de navegaci�n hacia la derecha
	beforeChange: function(){}, // Funci�n que se ejecuta antes de una transici�n
	afterChange: function(){}, // Funci�n que se ejecuta despu�s de una transici�n
	slideshowEnd: function(){}, // Funci�n que se ejecuta despu�s de que todas
								   las im�genes se han mostrado
	lastSlide: function(){}, // Funci�n que se ejecuta cuando la �ltima imagen se visualiza
	afterLoad: function(){} // Funci�n que se ejecuta cuando se carga el componente
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
