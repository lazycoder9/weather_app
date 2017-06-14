<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DateRangePicker;
use yii\web\Session;
require_once Yii::getAlias('@app').'/lib/draw_calendar.php';
use function Lib\draw_calendar;

$this->title = 'Weather';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
    foreach(Yii::$app->session->getAllFlashes() as $key => $message) {
        echo '<div class="alert alert-' . $key . '">' . $message . "</div>\n";
    }
?>
<h1><?= Html::encode($this->title) ?></h1>
<hr>
<div class="weather-index">
  <form class="form-inline" action='/weather'>
    <div class="form-group">
        <?= DateRangePicker::widget([
            'name' => 'start_date',
            'value' => $start_date,
            'nameTo' => 'end_date',
            'valueTo' => $end_date,
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'weekStart' => 1,
            ]
        ]);?>
     <input type="submit" value="Submit" class="btn btn-primary">
   </div>
  </form>
  <?php
  foreach($weather as $year=>$yearly_data) {
		foreach($yearly_data as $month=>$monthly_data) {
      draw_calendar($month, $year, $monthly_data);
    }
  }?>
</div>
