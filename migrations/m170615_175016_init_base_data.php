<?php

use yii\db\Migration;
use app\models\City;
use yii\httpclient\Client;

class m170615_175016_init_base_data extends Migration
{
    public function safeUp()
    {
        $city = 'Tashkent';

        $this->insert('city', [
          'name' => $city
        ]);

        echo "Initializing weather data from 2016 to nowadays";
        $city_id = City::find()->select('id')->where(['name' => $city]);
        $start_month = date('m', strtotime('-2 month'));
        $end_month = date('m', time());
        $year = date('Y', time());
        $interval = 1;
        $format = 'json';
        $client = new Client();
        $stop = false;
        for($month = $start_month; $month <= $end_month; $month++) {
          $days_in_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
          $start_date = mktime(0, 0, 0, $month, 1, $year);
          $end_date = $month == $end_month ? time() : mktime(0, 0, 0, $month, $days_in_month, $year);
          echo date('Y-m-d', $start_date) . " - " . date('Y-m-d', $end_date);
          $data = $client->createRequest()
                ->setMethod('post')
                ->setUrl('http://api.worldweatheronline.com/premium/v1/past-weather.ashx ')
                ->setData([
                    'key' => 'fab3aa66659f4ccd9e4203629171006',
                    'q' => $city,
                    'date' => date('Y-m-d', $start_date),
                    'enddate' => date('Y-m-d', $end_date),
                    'tp' => $interval,
                    'format' => $format
                ])
                ->send()->data['data'];
          foreach($data['weather'] as $day) {
            foreach($day['hourly'] as $hourly) {
              $this->insert('weather', [
                  'time' => $hourly['time'],
                  'temp' => $hourly['tempC'],
                  'day' => $day['date'],
                  'city_id' => $city_id
              ]);
            }
          }
        }
    }

    public function safeDown()
    {
        $this->delete('weather');
        $this->delete('city');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170615_175016_init_base_data cannot be reverted.\n";

        return false;
    }
    */
}
