<?php

use yii\db\Schema;
use yii\db\Migration;

class m150729_120945_create_table_route extends Migration
{
    public function safeUp()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // Users table
        $this->createTable(
            '{{%route}}',
            [
                'id' => Schema::TYPE_PK,
                'url' => Schema::TYPE_STRING . '(255) NOT NULL',
                'route' => Schema::TYPE_STRING . '(50) NOT NULL',
                'params' => Schema::TYPE_TEXT . ' DEFAULT NULL',
                'created_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'updated_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            ],
            $tableOptions
        );

        $this->createIndex('url', '{{%route}}', 'url', true);
        $this->createIndex('route', '{{%route}}', 'route');
    }

    public function safeDown()
    {
        $this->dropTable('{{%route}}');
        echo "m150729_120945_create_table_route cannot be reverted.\n";

        return false;
    }
}
