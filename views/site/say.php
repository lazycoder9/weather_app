<?php
use yii\helpers\Html;
use app\models\EntryForm;
$model = new EntryForm();
$model->name = 'Qiang';
$model->email = 'bad@bad.com';
$say = $model->validate() ? 'Success' : 'Fail';
?>
<h1><?= Html::encode($message) ?></h1>
<br>
<h2><?= Html::encode($say) ?></h2>
