<div class="services">
	<div class="auth-services clear">
		<?php
		foreach ($services as $name => $service) {
		//	echo '<li class="auth-service ' . $service->id . '">';
			/*$html = '<span class="auth-icon ' . $service->id . '"><i></i></span>';
			$html .= '<span class="auth-title">' . $service->title . '</span>';*/
            $class = ($service->id=='vkontakte')? 'vk' : $service->id;
            $html = '<span class="fa fa-'.$class.'"></span>'.Yii::t('messages','Login with').' '. $service->title;
			$html = CHtml::link($html, array($action, 'service' => $name), array(
				'class' => 'auth-link btn btn-md btn-social  btn-block btn-' . $class,
			));
			echo $html;  
		//	echo '</li>';
		}
		?>
	</div>
</div>
