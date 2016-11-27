<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * CLass m150717_132906_create_table_lease
 * @package console\migrations
 *
 * Create Lease module tables.
 *
 * Will be created 2 tables:
 * - `{{%lease}}` - Lease table.
 * - `{{%lease_photos}}` - Lease photos table.
 */

class m150717_132906_create_table_lease extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // Users table
        $this->createTable(
            '{{%lease}}',
            [
                // Basic vehicle info
                'id' => Schema::TYPE_PK,
                'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'year' => Schema::TYPE_SMALLINT . '(4) NOT NULL',
                'make' => Schema::TYPE_STRING . '(100) NOT NULL',
                'model' => Schema::TYPE_STRING . ' NOT NULL',
                'vin' => Schema::TYPE_STRING . '(17) NOT NULL',
                'miles' => Schema::TYPE_INTEGER . ' NOT NULL',
                'zip' => Schema::TYPE_INTEGER . ' NOT NULL',
                'trim' => Schema::TYPE_STRING . '(255) NOT NULL',
                'url' => Schema::TYPE_STRING . '(255) NOT NULL',

                'status_id' => 'tinyint(4) NOT NULL DEFAULT 0',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
            ],
            $tableOptions
        );

        // Indexes
        $this->createIndex('user_id', '{{%lease}}', 'user_id');
        $this->createIndex('vin', '{{%lease}}', 'vin');
        $this->createIndex('make', '{{%lease}}', 'make');
        $this->createIndex('year', '{{%lease}}', 'year');
        $this->createIndex('model', '{{%lease}}', 'model');
        $this->createIndex('status_id', '{{%lease}}', 'status_id');
        $this->createIndex('created_at', '{{%lease}}', 'created_at');

        // Users table
        $this->createTable(
            '{{%lease_photos}}',
            [
                'id' => Schema::TYPE_PK,
                'lease_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'url' => Schema::TYPE_STRING . '(50) NOT NULL',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
            ],
            $tableOptions
        );

        // Foreign Keys
        $this->addForeignKey('FK_lease_photos', '{{%lease_photos}}', 'lease_id', '{{%lease}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%lease_photos}}');
        $this->dropTable('{{%lease}}');
    }
}
