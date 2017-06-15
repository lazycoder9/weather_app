<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `country`.
 */
class m170615_174843_create_city_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('city', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('city');
    }
}
