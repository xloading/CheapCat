<div class="services">
  <ul class="auth-services clear">
  <?php
	foreach ($services as $name => $service) {
		echo '<li class="auth-service '.$service->id.'">';
		$html = '<span class="auth-icon '.$service->id.'"><i></i></span>';
		//$html .= '<span class="auth-title">'.$service->title.'</span>';
		/*if(isset($this->module)){
			$login_link = '/login/login';
		}
		else
			$login_link = $this->module->getName();*/
		$html = CHtml::link($html, array('/user/login/login', 'service' => $name/*, 'ret' => substr(Yii::app()->request->getUrl(),1)*/ ), array(
			'class' => 'auth-link '.$service->id,
		));
		echo $html;
		echo '</li>';
	}
  ?>
  </ul>
</div>