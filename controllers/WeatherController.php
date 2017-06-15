<?php

namespace app\controllers;

use Yii;
use app\models\Weather;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

define("START_DATE", date('Y-m-01', strtotime('-2 month')));
define("END_DATE", date('Y-m-d', time()));

class WeatherController extends Controller
{
    public function actionIndex($start_date = START_DATE, $end_date = END_DATE)
    {
      $data = Weather::find()
        ->select(['DAY_TEMP' => 'MAX(temp)','NIGHT_TEMP' => 'MIN(temp)', 'day'])
        ->where(['between', 'day', $start_date, $end_date])
        ->groupBy('day')
        ->asArray()
        ->all();

      $amount_of_days = (strtotime($end_date) - strtotime($start_date)) / 60 / 60 / 24;
      $is_dates_valid = $amount_of_days >= 0;
      if($amount_of_days > count($data)) {
        Yii::$app->getSession()->setFlash('warning', 'The data you have requested is not complete, you should probably <a href="#">update</a> it.');
      }
      $ast_weather = $this->data_to_ast($data);
      $weather = $this->add_data_type($ast_weather);
      return $this->render('index', [
        'weather' => $weather,
        'is_dates_valid' => $is_dates_valid,
        'start_date' => $start_date,
        'end_date' => $end_date,
      ]);
    }

    private function data_to_ast($data) {
      return array_reduce($data, function($acc, $value) {
        $date = strtotime($value['day']);
        list($year, $month, $week, $day_of_week) = explode('-', date('Y-n-W-N', $date));
        $acc[$year][$month][$week][$day_of_week] = $value;
        $acc[$year][$month][$week][$day_of_week]['type'] = 'default';
        return $acc;
      }, array());
    }

    private function add_data_type($weather) {
      foreach($weather as $year=>$yearly_data) {
        foreach ($yearly_data as $month=>$monthly_data) {
          $current_max_diff = 0;
          $max_diff_day = '';
          foreach ($monthly_data as $week => $weekly_data) {
            $avg_week_diff = array_reduce($weekly_data, function($acc, $daily_data) {
              $acc += $daily_data['DAY_TEMP'] - $daily_data['NIGHT_TEMP'];
              return $acc;
              }, 0) / count($weekly_data);
            foreach ($weekly_data as $day => $daily_data) {
              $temp_diff = $daily_data['DAY_TEMP'] - $daily_data['NIGHT_TEMP'];
              if ($temp_diff > $avg_week_diff) {
                $weather[$year][$month][$week][$day]['type'] = 'higher';
              }
              if ($temp_diff > $current_max_diff) {
                $current_max_diff = $temp_diff;
                $max_diff_day = $daily_data['day'];
              }
            }
          }
          $date = strtotime($max_diff_day);
          list($year, $month, $week, $day_of_week) = explode('-', date('Y-n-W-N', $date));
          $weather[$year][$month][$week][$day_of_week]['type'] = 'highest';
        }
      }
      return $weather;
    }
}
