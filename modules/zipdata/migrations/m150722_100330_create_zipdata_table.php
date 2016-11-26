<?php

use yii\db\Schema;
use yii\db\Migration;

class m150722_100330_create_zipdata_table extends Migration
{
    public function up()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // Users table
        $this->createTable(
            '{{%zipdata}}',
            [
                'city' => Schema::TYPE_STRING . '(50) NOT NULL',
                'state_code' => 'char(2) NOT NULL',
                'zip' => Schema::TYPE_INTEGER . '(5) NOT NULL',
                'latitude' => Schema::TYPE_DOUBLE . ' NOT NULL',
                'longitude' => Schema::TYPE_DOUBLE . ' NOT NULL',
                'country' => Schema::TYPE_STRING . '(50) NOT NULL'
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%zipdata}}');
        echo "m150722_100330_create_zipdata_table cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
