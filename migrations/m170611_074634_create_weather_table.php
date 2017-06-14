<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `weather`.
 */
class m170611_074634_create_weather_table extends Migration
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
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('weather');
    }
}
