<h5>Сетевые сервисы, которые связаны с Вашим аккаунтом</h5>
<?php foreach($userServices as $model):?>
<div><?=CHtml::link($model->name, $this->module->getComponent(strtolower($model->name))->getProfileUrl($model->service_user_id));?></div>
<?php endforeach;?>