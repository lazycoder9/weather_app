<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `weather`.
 */
class m170615_174933_create_weather_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
      $this->createTable('weather', [
          'id' => Schema::TYPE_PK,
          'time' => Schema::TYPE_INTEGER,
          'day' => Schema::TYPE_DATE,
          'temp' => Schema::TYPE_INTEGER,
          'city_id' => Schema::TYPE_INTEGER,
      ]);

      $this->addForeignKey(
          'fk-weather-country_id',
          'weather',
          'city_id',
          'city',
          'id',
          'CASCADE'
      );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('weather');
    }
}
