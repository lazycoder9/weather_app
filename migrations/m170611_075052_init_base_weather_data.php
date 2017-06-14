<?php

use yii\db\Migration;
use yii\httpclient\Client;

class m170611_075052_init_base_weather_data extends Migration
{
    public function safeUp()
    {
      echo "Initializing weather data from 2016 to nowadays";
        $city = 'Tashkent';
        $start_date = '2016-01-01';
        $end_date = '2016-01-31';
        $interval = 1;
        $format = 'json';
        $client = new Client();
        $stop = false;
        for($year = 2016; $year < 2018; $year++) {
          for($month = 1; $month < 13; $month++) {
            $days_in_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
            $start_date = mktime(0, 0, 0, $month, 1, $year);
            $end_date = mktime(0, 0, 0, $month, $days_in_month, $year);
            if ($end_date > time()) {
              $end_date = time();
              $stop = true;
            }
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
            print_r($data);
            foreach($data['weather'] as $day) {
              foreach($day['hourly'] as $hourly) {
                $this->insert('weather', [
                    'time' => $hourly['time'],
                    'temp' => $hourly['tempC'],
                    'day' => $day['date']
                ]);
              }
            }
            if ($stop) {
              break;
            }
          }
        }
    }

    public function safeDown()
    {
        $this->delete('weather');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170611_075052_init_base_weather_data cannot be reverted.\n";

        return false;
    }
    */
}
